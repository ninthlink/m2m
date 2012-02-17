<?php
/**
 * @file views-view-grid.tpl.php
 * Default simple view template to display a rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 * - $class contains the class of the table.
 * - $attributes contains other attributes for the table.
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)) : ?>
  <div class="featured_search_header">
    <h3><?php print $title; ?></h3>
  <?php if(!(count($view->exposed_input['field_featured_product_category_value_many_to_one']) == 1 && $view->exposed_input['field_featured_product_category_value_many_to_one'][0] == $title)){?>
    <a href="#" onClick="var form = $('#views-exposed-form-featured-products-page-1'); form.find('input:checkbox[value!=\'<?php echo str_replace('&', '&amp;', $title);?>\']').attr('checked', false).removeClass('highlight');form.find('.bef-checkboxes input[value=\'<?php echo str_replace('&', '&amp;', $title);?>\']').attr('checked', true).addClass('highlight');form.submit();return false;">View All</a>
    <?php $display_none = TRUE;?>
  <?php }else{
      $display_none = FALSE;
  }?>
  </div>
<?php endif; ?>
<table class="<?php print $class; ?>"<?php print $attributes; ?>>
  <tbody>
    <?php foreach ($rows as $row_number => $columns): ?>
      <?php
        if($display_none && $row_number > 0){
          break;
        }
        $row_class = 'row-' . ($row_number + 1);
        if ($row_number == 0) {
          $row_class .= ' row-first';
        }
        if (count($rows) == ($row_number + 1)) {
          $row_class .= ' row-last';
        }
      ?>
      <tr class="<?php print $row_class; ?><?php echo ($row_number != 0 ? ' row-show-more' : '');?>">
        <?php foreach ($columns as $column_number => $item): ?>
          <td class="<?php print $column_classes[$row_number][$column_number]; ?>">
            <?php print $item; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>