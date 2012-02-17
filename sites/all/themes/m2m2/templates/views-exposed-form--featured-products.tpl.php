<?php
/**
 * @file views-exposed-form.tpl.php
 *
 * This template handles the layout of the views exposed filter form.
 *
 * Variables available:
 * - $widgets: An array of exposed form widgets. Each widget contains:
 * - $widget->label: The visible label to print. May be optional.
 * - $widget->operator: The operator for the widget. May be optional.
 * - $widget->widget: The widget itself.
 * - $button: The submit button for the form.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($q)): ?>
  <?php
    // This ensures that, if clean URLs are off, the 'q' is added first so that
    // it shows up first in the URL.
    print $q;
  ?>
<?php endif; ?>
<div class="views-exposed-form">
  <div class="views-exposed-widgets clear-block">
    <?php foreach ($widgets as $id => $widget): ?>
      <div class="views-exposed-widget views-widget-<?php print $id; ?>">
        <?php if (!empty($widget->label)): ?>
          <label for="<?php print $widget->id; ?>">
            <?php print $widget->label; ?>
          </label>
        <?php endif; ?>
        <?php if (!empty($widget->operator)): ?>
          <div class="views-operator">
            <?php print $widget->operator; ?>
          </div>
        <?php endif; ?>
        <div class="views-widget">
          <?php print $widget->widget; ?>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="views-exposed-widget views-submit-button">
      <?php print $button; ?>
    </div>
  </div>
</div>
<style>
    #views-exposed-form-featured-products-page-1 .bef-checkboxes {margin-top:150px;}
</style>
<script>
  function toggle_devices(view_details){
    if(view_details){
      $('#device_details').show();
      $('#results').hide();
    }else{
      $('#device_details').hide();
      $('#results').show();
    }
  }
  $(document).ready(function(){
    if($('#views-exposed-form-featured-products-page-1 .bef-checkboxes input:checked').length == 0){
        $('#edit-field-featured-product-category-value-many-to-one-all').attr('checked', 'checked');
    }
    $('#edit-field-featured-product-category-value-many-to-one-all').unbind('click');
    $('#edit-field-featured-product-category-value-many-to-one-all').removeAttr('name');
    $('#edit-field-featured-product-category-value-many-to-one-all').click(function(){
        var form = $('#views-exposed-form-featured-products-page-1');
        form.find('.bef-checkboxes input[id != "edit-field-featured-product-category-value-many-to-one-all"]:checkbox:checked').removeAttr("checked");
        form.submit();
    });
    $('#views-exposed-form-featured-products-page-1 .bef-checkboxes input[id != "edit-field-featured-product-category-value-many-to-one-all"]:checkbox').change(function(){
        if($(this).attr('checked')){
            $('#edit-field-featured-product-category-value-many-to-one-all').removeAttr('checked');
        }
    });
  });
</script>