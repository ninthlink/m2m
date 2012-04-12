<?php
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>
<script type="text/javascript">
  function toggle_devices(view_details){
    if(view_details){
      $('#device_details').show();
      $('#results').hide();
    }else{
      $('#device_details').hide();
      $('#results').show();
    }
  }
  function show_grid(){
    $('div.view-content').hide();
    $('div.view div.attachment').show();
    $('div.view div.attachment div.view-content').show();
    $('.grid-view').addClass('active');
    $('.list-view').removeClass('active');
    view_type = 'thumbs';
  }
  function hide_grid(){
    $('div.view div.attachment').hide();
    $('div.view-content').show();
    $('.grid-view').removeClass('active');
    $('.list-view').addClass('active');
    view_type = 'list';
  }
  $(document).ready(function(){
    if(view_type == 'thumbs'){
      show_grid();
    }else{
      hide_grid();
    }
    $('.view-content .field-content a').click(function() {
      $('#devicehere').load($(this).attr('href')+" #main_content", function() {
        toggle_devices(true);
      });
      return false;
    });
  });
</script>

<div class="<?php print $classes; ?>">
  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <div id="results">

    <div class="view-display-mode-tabs">
      <a href="#" id="list-view-link" class="list-view" onClick="if(!$(this).hasClass('active')){hide_grid();}return false;">List</a>
      <a href="#" id="grid-view-link" class="grid-view" onClick="if(!$(this).hasClass('active')){show_grid();}return false;">Thumbs</a>
    </div>

    <?php if ($attachment_before): ?>
      <div class="attachment attachment-before">
        <?php print $attachment_before; ?>
      </div>
    <?php endif; ?>

    <?php if ($rows): ?>
       <div class="view-content">

      <?php print $rows; ?>

      <?php if ($pager): ?>
        <div class="pager-bottom">
          <?php print $pager; ?>
        </div>
      <?php endif; ?>

      </div>
    <?php elseif ($empty): ?>
      <div class="view-empty">
        <?php print $empty; ?>
      </div>
    <?php endif; ?>


    <?php if ($attachment_after): ?>
      <div class="attachment attachment-after">
        <?php print $attachment_after; ?>
      </div>
    <?php endif; ?>

    <?php if ($more): ?>
      <?php print $more; ?>
    <?php endif; ?>

    <?php if ($footer): ?>
      <div class="view-footer">
        <?php print $footer; ?>
      </div>
    <?php endif; ?>

    <?php if ($feed_icon): ?>
      <div class="feed-icon">
        <?php print $feed_icon; ?>
      </div>
    <?php endif; ?>

  </div>

  <div id="device_details" style="display:none;">
    <div class="backtosearch"><a href="#" onClick="toggle_devices(false);return false;">Back to Results</a></div>
    <div id="devicehere"></div>
  </div>

</div> <?php /* class view */ ?>