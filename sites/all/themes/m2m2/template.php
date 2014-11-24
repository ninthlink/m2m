<?php
// $Id: template.php,v 1.16.2.1 2009/02/25 11:47:37 goba Exp $

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function phptemplate_body_class($left, $right) {
  if ($left != '' && $right != '') {
    $class = 'sidebars';
  }
  else {
    if ($left != '') {
      $class = 'sidebar-left';
    }
    if ($right != '') {
      $class = 'sidebar-right';
    }
  }

  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .'</div>';
  }
}

/**
 * Allow themable wrapping of all comments.
 */
function phptemplate_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div>';
  }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function phptemplate_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function phptemplate_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function phptemplate_get_ie_styles() {
  global $language;

  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/fix-ie.css" />';
  if ($language->direction == LANGUAGE_RTL) {
    $iecss .= '<style type="text/css" media="all">@import "'. base_path() . path_to_theme() .'/fix-ie-rtl.css";</style>';
  }

  return $iecss;
}

/**
 * This is a one by one clone of the core theme_menu_item() function that allows
 * custom theming of the site map page items.
 *
 * Generate the HTML output for a menu item and submenu.
 *
 * @ingroup themeable
 */
function phptemplate_site_map_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  if(preg_match('/^<[^>]+active/', $link)){
    return;
  }
  $class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  if (!empty($extra_class)) {
    $class .= ' '. $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active-trail';
  }
  return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
}

function phptemplate_content_view_multiple_field($items, $field, $values) {
  $output = '<div class="field-item">';
  $i = 0;
  foreach ($items as $item) {
    if (!empty($item) || $item == '0') {
	  if ( $i > 0 ) $output .= ', ';
	  $output .= $item;
//      $output .= '<div class="field-item field-item-'. $i .'">'. $item .'</div>';
      $i++;
    }
  }
  $output .= '</div>';
  return $output;
}
function m2m2_text_formatter_default($element){
  if($element['#field_name'] == 'field_company'){
    $company_users = array();
    $company = $element['#item']['value'];
    $result = db_query('SELECT n.uid, n.title FROM {node} n JOIN {users_roles} ur ON n.uid=ur.uid JOIN {content_field_company} cfc ON n.nid=cfc.nid WHERE n.type="profile" AND ur.rid=3 AND cfc.field_company_value="%s" AND n.uid <> 1;', $company);
    while ($u = db_fetch_object($result)) {
      $company_users[] = l($u->title, 'user/'.$u->uid);
    }
    $return = ($allowed = _text_allowed_values($element)) ? $allowed : $element['#item']['safe'];
    if(!empty($company_users)){
      $return .= theme('item_list', $company_users);
    }
    return $return;
  }
  return ($allowed = _text_allowed_values($element)) ? $allowed : $element['#item']['safe'];
}