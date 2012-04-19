<?php
// $Id: utility.inc,v 1.4.2.13.2.3 2010/05/25 13:04:48 dman Exp $
/**
 * @file Utility form, conversion and rendering functions for image processes
 */



/**
 * Prepare a subform for displaying RGB fields
 *
 * Helper function to render a common element.
 * 
 * Note that any module that re-uses this form also has to declare the theme
 * function in order to ensure it's in the registry.
 */
function imagecache_rgb_form($action) {
  if ($action['HEX'] && $deduced = hex_to_rgb($action['HEX'])) {
    $action = array_merge($action, $deduced);
    $action['HEX'] = ltrim($action['HEX'], '#');
    // With or without # is valid, but trim for consistancy
  }
  $form = array('#theme' => 'imagecacheactions_rgb_form'); 
  $form['farb'] = array('#weight' => -1); // Placeholder to get its weight right
  $form['HEX'] = array( '#type' => 'textfield', '#title' => t('HEX'), '#default_value' => $action['HEX'], '#size' => 7);

  return $form;
}


/**
 * Prepare a subform for displaying positioning fields
 *
 * Helper function to render a common element.
 */
function imagecacheactions_pos_form($action) {
  $defaults = array(
    'xpos' => 'center',
    'ypos' => 'center',
  );
  $action = array_merge($defaults, (array)$action);

  $form = array(
    #'#theme' => 'canvasactions_pos_form',
    'xpos' => array(
      '#type' => 'textfield',
      '#title' => t('X offset'),
      '#default_value' => $action['xpos'],
      '#size' => 6,
      '#description' => t('Enter an offset in pixels or use a keyword: <em>left</em>, <em>center</em>, or <em>right</em>.'),
      '#element_validate' => array('imagecache_actions_validate_number'),
    ),
    'ypos' => array(
      '#type' => 'textfield',
      '#title' => t('Y offset'),
      '#default_value' => $action['ypos'],
      '#size' => 6,
      '#description' => t('Enter an offset in pixels or use a keyword: <em>top</em>, <em>center</em>, or <em>bottom</em>.'),
      '#element_validate' => array('imagecache_actions_validate_number'),
    ),
  );
  return $form;
}

/**
 * Ensure the numbers are valid.
 * 
 * Set blanks to zero, just so the status summary doesn't get odd blanks
 */
function imagecache_actions_validate_number(&$element, &$form_state) {
  if (empty($element['#value'])) form_set_value($element, 0, $form_state);
}

function imagecache_actions_validate_alpha(&$element, &$form_status) {
  if (!is_numeric($element['#value']) || $element['#value'] < 1 || $element['#value'] > 100) {
    form_set_error(join('][', $element['#parents']), t('Opacity must be a number between 1 and 100.'));
  }
}


/**
 * Render the subform in a table
 */
function theme_imagecacheactions_rgb_form(&$form) {
  // Add a farb element
  drupal_add_css('misc/farbtastic/farbtastic.css', 'module', 'all', FALSE);
  drupal_add_js('misc/farbtastic/farbtastic.js');
  //  drupal_add_js(drupal_get_path('module', 'imagecache_coloractions') . '/color.js');

  $hex_id = $form['HEX']['#id'];
  $form['farb'] = array('#value' => "<div id=\"$hex_id-farb\" style=\"float:right\"></div>", '#weight' => -1 );

  // Adds the JS that binds the textarea with the farb element
  $js = "
  $(document).ready(function() {
    farbify($('#$hex_id'), '#$hex_id-farb');
  });

  function farbify(elt, wrapper) {
    var farb = $.farbtastic(wrapper);
    farb.linkTo(function(color) {
        elt
          .css('background-color', color)
          .css('color', this.hsl[2] > 0.5 ? '#000' : '#fff')
          .val(color.substring(1));
      });
    farb.setColor('#' + elt.val());
    elt.bind('keyup', function(){ updateColor(elt, farb); });
  }
  function updateColor(elt, farb) {
    var text = elt.val();
    if (text.length == 6)
      farb.setColor('#' + text);
  }

  ";
  drupal_add_js($js, 'inline');  
  $output = drupal_render($form);
  return $output;
}


function theme_imagecacheactions_rgb($rgb) {
  if ($rgb['HEX']) {
    return " <span style=\"width:2em; border:1px solid white; background-color:#{$rgb['HEX']}\" >&nbsp;#{$rgb['HEX']}&nbsp;</span>";
  }
  else {
    return ' '. t('Transparent');
  }
}



 /**
 * Decode an HTML hex-code into an array of R, G, and B values.
 * accepts these formats: (case insensitive) #ffffff, ffffff, #fff, fff
 */
function hex_to_rgb($hex) {
  $hex = trim($hex);
  // remove '#'
  if (substr($hex, 0, 1) == '#')
    $hex = substr($hex, 1) ;

  // expand short form ('fff') color
  if (strlen($hex) == 3) {
    $hex = substr($hex, 0, 1) . substr($hex, 0, 1) .
           substr($hex, 1, 1) . substr($hex, 1, 1) .
           substr($hex, 2, 1) . substr($hex, 2, 1) ;
  }

  if (strlen($hex) != 6)
    trigger_error('Error: Invalid color "'. $hex .'"') ;

  // convert
  $rgb['red'] = hexdec(substr($hex, 0, 2)) ;
  $rgb['green'] = hexdec(substr($hex, 2, 2)) ;
  $rgb['blue'] = hexdec(substr($hex, 4, 2)) ;

  return $rgb ;
}

/**
 * Accept a keyword (center, top, left, etc) and return it as an offset in pixels.
 * Called on either the x or y values.
 * 
 * May  be something like "20", "center", "left+20", "bottom+10". + values are
 * in from the sides, so bottom+10 is 10 UP from the bottom. 
 * 
 * "center+50" is also OK.
 * 
 * "30%" will place the CENTER of the object at 30% across. to get a 30% margin,
 * use "left+30%"
 * 
 * @param $value 
 *   string or int value. 
 * @param $current_size
 *   int size in pixels of the range this item is to be placed in
 * @param $object_size
 *   int size in pixels of the object to be placed
 * 
 * 
 */
function imagecache_actions_keyword_filter($value, $base_size, $layer_size) {
  // See above for the patterns this matches
  if (! preg_match('/([a-z]*)([\+\-]?)(\d*)([^\d]*)/', $value, $results) ) {
    trigger_error("imagecache_actions had difficulty parsing the string '$value' when calculating position. Please check the syntax.", E_USER_WARNING);
  }
  list($match, $keyword, $plusminus, $value, $unit) = $results;

  #dpm(__FUNCTION__ . " Placing an object $layer_size big on a range of $base_size at a position of $value");  
  #dpm(get_defined_vars());

  return imagecache_actions_calculate_offset($keyword, $plusminus.$value.$unit, $base_size, $layer_size);
}

/**
 * Given two imageapi objects with dimensions, and some positioning values,
 * calculate a new x,y for the layer to be placed at.
 * 
 * This is a different approach to imagecache_actions_keyword_filter() - more
 * like css.
 * 
 * The $style is an array, and expected to have 'top,bottom, left,right'
 * attributes set. These values may be positive, negative, or in %.
 * 
 * % is calculated relative to the base image dimensions.
 * Using % requires that the layer is positioned CENTERED on that location, so
 * some offsets are added to it. 'right-25%' is not lined up with a margin 25%
 * in, it's centered at a point 25% in - which is therefore identical with
 * left+75%
 */
function imagecache_actions_calculate_relative_position($base, $layer, $style) {
  // $textimage should now have its size info available.

  if (isset($style['bottom'])) {
    $ypos = imagecache_actions_calculate_offset('bottom', $style['bottom'], $base->info['height'], $layer->info['height']);
  }
  if (isset($style['top'])) {
    $ypos = imagecache_actions_calculate_offset('top', $style['top'], $base->info['height'], $layer->info['height']);
  }
  if (isset($style['right'])) {
    $xpos = imagecache_actions_calculate_offset('right', $style['right'], $base->info['width'], $layer->info['width']);
  }
  if (isset($style['left'])) {
    $xpos = imagecache_actions_calculate_offset('left', $style['left'], $base->info['width'], $layer->info['width']);
  }
  if (! isset($ypos)) {
    // assume center
    $ypos = ($base->info['height']/2) - ($layer->info['height']/2);
  }
  if (! isset($xpos)) {
    // assume center
    $xpos = ($base->info['width']/2) - ($layer->info['width']/2);
  }
  #dpm(__FUNCTION__ . " Calculated offsets");  
  #dpm(get_defined_vars());

  return array('x' => $xpos, 'y' => $ypos);
}

/**
 * Positive numbers are IN from the edge, negative offsets are OUT.
 * 
 * $keyword, $value, $base_size, $layer_size
 * eg 
 * left,20 200, 100 = 20
 * right,20 200, 100 = 80 (object 100 wide placed 20 px from the right = x=80)
 * 
 * top,50%, 200, 100 = 50 (Object is centered when using %)
 * top,20%, 200, 100 = -10 
 * bottom,-20, 200, 100 = 220
 * right, -25%, 200, 100 = 200 (this ends up just offscreen)
 * 
 */
function imagecache_actions_calculate_offset($keyword, $value, $base_size, $layer_size) {
  $offset = 0; // used to account for dimensions of the placed object
  $direction = 1;
  $base = 0;
  if ($keyword == 'right' || $keyword == 'bottom') {
    $direction = -1;
    $offset = -1 * $layer_size;
    $base = $base_size;
  }
  if ($keyword == 'middle' || $keyword == 'center') {
    $base = $base_size/2;
    $offset = -1 * ($layer_size / 2);
  }

  // handle % values
  if (substr($value, strlen($value)-1, 1) == '%') {
    $value = intval($value / 100 * $base_size);
    $offset = -1 * ($layer_size / 2);
  }
  $value = $base + ($direction * $value);

  #dpm(__FUNCTION__ . " Placing an object $layer_size big on a range of $base_size at a position of $value , $offset");  
  #dpm(get_defined_vars());

  // Add any extra offset to position the item
  return $value + $offset;
}

/**
 * imagecache is conservative with its inclusion of inc files, but sometimes I
 * need to use them - eg crop. This function finds and includes it if needed.
 */
function imagecache_include_standard_actions() {
  $cropaction = imagecache_action_definition('imagecache_crop');
  include_once($cropaction['file']);
}


/**
 * Generate the dynamic text for this image.
 * Was textactions caption - now merged as an option of text2canvas
 * 
 * TODO further code review for safety etc
 * 
 * @param $image object, as provided by imageapi
 * @param $action definition
 * 
 * @return $text Plain or code string to be placed on the imagecache process.
 */
function imagecache_actions_evaluate_text($image, $action) {

  // HOOK_metadata from file attempts to glean info from any direction possible - EXIF, XMP, DB, description.txt
  // @see the meta_* project
  if (!empty($image->source)) {
    $file_metadata = module_invoke_all('metadata_from_file', $image->source);
    #$file_data = (object) $meta;
    // $file_data is an array of namespaced keyed further arrays of values.
    // $file_data['dc:title'] = array('this pic');
    // $title = reset($file_data['dc:title']);
    // It's always an array because there may be conflicting or multiple values at any time.
    
    // $file_data is a simplified, flattened version of the same
    // provided for user convenience because namespaces are scary
    $file_data = (object)array();
    foreach($file_metadata as $key => $val_array) {
      @list($namespace, $shortname) = explode(":", $key);
      if (! $shortname) $shortname = $namespace;
      $shortname = strtolower($shortname);
      if (is_array($val_array)) $file_data->$shortname = array_shift($val_array);
      else $file_data->$shortname = $val_array;
    }
  }

  // Try to load the attached node - if any
  static $panic; #This can trigger recursion! build-load-build-etc
  if ($panic) return;
  $panic = TRUE;
  $node = imagecache_actions_node_from_filepath($image->source, $file_data) ;
  $panic = FALSE;

  // Process the php using drupal_eval (rather than eval), 
  // but with GLOBAL variables, so they can be passed successfully
  $GLOBALS['image'] = $image;
  $GLOBALS['node'] = $node;
  $GLOBALS['file_data'] = $file_data;
  $GLOBALS['file_metadata'] = $file_metadata;

#  global $user_text; $user_text = 'text not set';

/*
  // Wrap the users instructions in a function to support them 
  // returning (incorrectly) an array.
  // Just using eval forced the return value to a string.
  // Instead we wrap their code into a pseudo function, evaluate the function
  // and we can find exactly what they returned

  $command = '<'.'?php  
    $func = create_function(NULL,\' 
      global $node; global $image; global $file_data;
      '. str_replace("'", "\\'",  $action['text'] ) .' 
      ; \'
    ); 
    global $user_text;
    $user_text = $func(); 
    return $user_text; 
  ?'.'>';
*/

  $command = '<'.'?php  
      global $node; global $image; global $file_data; global $file_metadata;
      '. $action['text'] .'; 
      ?'.'>';

  $text = @drupal_eval($command);
  #dpm(array('command' => $command, 'text' => $text, 'user_text' => $user_text));

  // User forgot to flatten or reset() the array value. 
  // Deal with it for them with what they probably wanted. 
#  if (is_array($user_text)) $text = join(", ", array_unique($user_text));

  // Warn about errors in the php code if I can
  if (empty($text) && function_exists('error_get_last') && $last_error = error_get_last()) {
    drupal_set_message("Problem evaluating dynamic text. <br/><code>{$action['text']}</code><br/> ". $last_error['message'], 'error');
  }

  return $text;
}


/**
 * Given only a file filename, track back to see if we can detect the parent
 * node and provide some context info.
 * 
 * This will be different in different cases.
 * Supported :
 * image.module image nodes
 * imagefield cck fields (may be multiple)
 * upload.module attachments 
 * 
 * TODO: image_attach attachments
 * 
 * @param $filepath
 * @param $file_data MAY get some details filled in on it by reference if data
 * was found.
 * 
 * @return a loaded $node object
 */
function imagecache_actions_node_from_filepath($filepath, &$file_data = NULL) {

  // lookup upload.module attachments
  if (module_exists('upload')) {
    $sql = "SELECT nid, f.fid FROM {upload} AS u INNER JOIN {files} AS f ON u.fid = f.fid WHERE f.filepath = '%s'";
    $results = db_query_range($sql, $filepath, 0, 1);
    if ( $row = db_fetch_array($results)) {
      // Return immediately
      $node = node_load($row['nid']);
      // also include the file description
      $file_data = $node->files[$row['fid']];
      return $node;
    }
  }

  // Lookup image.module nodes
  if (module_exists('image')) {
    $sql = "SELECT nid FROM {image} AS i INNER JOIN {files} AS f ON i.fid = f.fid WHERE f.filepath = '%s'";
    if ( $nid = db_result(db_query_range($sql, $filepath, 0, 1))) {
      // Return immediately
      return node_load($nid);
    }
  }


  // Lookup filefield imagefield CCK attachments.
  //
  // Drupal 6 version here based largely on work done by mikeytown2 
  // http://drupal.org/node/363434
  
  // This is a terrible way to retrieve information, but CCK doesn't provide a way to reverse-lookup like this
  // BAD CODE follows
  // If someone could roll these DBlookups into a smaller ball, that would be fun.
  // Due to CCKs use of dynamically created table names .. I don't know how.
  
  // Multiple file ID's might have the same name, get all 
  // (but return just the first successful match)
  $result = db_query("SELECT fid FROM {files} WHERE filepath = '%s'", $filepath);
  $fids = array();
  while ($row = db_fetch_array($result)) {
    $fids[] = $row['fid'];
  }

  if (! empty($fids)) {
    // Find out if any filefield contains this file, and if so, which field
    // and node it belongs to. Required for later access checking.
    // CCK field analysis is in the outer loop, 
    // fids are scanned in the inner loop for a little speed.

    // Get A List Of ALL CCK Fields and look for them individually, 
    // it's the only way we can reverse the lookups
    foreach (content_fields() as $field) {
      // If Field is an Image (imagefield.module) or filefield then
      if ($field['type'] == 'image' || $field['type'] == 'filefield') {
        // Need to do lots of lookups to find out what the storage tables look like.
        // Grab All DB Column Names for that CCK Field
        $db_info = content_database_info($field);
        // Get Content Type DB name - FROM statement
        $tablename = $db_info['table'];
        //Get File ID DB Column Name - WHERE statement
        $fid_column = $db_info['columns']['fid']['column'];

        // Construct a Query that looks for all known fids in one go.
        // eg:
        // SELECT nid FROM content_type_story 
        //   WHERE field_illustration_fid = 77 
        //   OR field_illustration_fid = 99;
        
        $wheres = array();
        $query_args = array();
        foreach ($fids as $fid) {
          $wheres[] = " %s = %d ";
          $query_args[] = $fid_column; 
          $query_args[] = $fid; 
        }

        $result = db_query('SELECT nid FROM {'. $tablename .'} WHERE '. join(' OR ', $wheres), $query_args);
        
        while ($row = db_fetch_array($result)) {
          // This while is a dummy loop - Just break out and return the first matching node. 
          // If more than one node owns this image then ???
          $node = node_load($row['nid']);

          // Add even more info - the description "data" that MAY have been added 
          // to this file on this node using filefield_meta and stuff.
          // Return the data associated specifically with this file also;
          // Do this via the handle on the file_data object we were passed in.
          // Slightly mushed together - I want it to mostly resemble the traditional file attachment object.
          
          // We have the node but lost track of the file in the process.
          // Need to scan again to make sure we got the right one :-{
          if ( $file_fields = $node->{$field['field_name']} ) {
            foreach ($file_fields as $file_field) {
              if ($file_field['fid'] == $fid) {
                $actual_file = $file_field;
              }
            }
            $file_data = (object) array_merge((array)$file_data, $actual_file['data'], $actual_file);

          }
          return $node;
        }
      }
    }
  }
}