<?php
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<?php print $picture ?>

<?php if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>

  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>

<div class="product_column1">

  <!--div class="product_title">
  <h2><?php //print $title; ?></h2>
  </div-->
  <div class="product_image">
  <?php print t($node->field_rout_image[0]['view']); ?>
  </div>
<div class="product_links">
<?php
  if ($node->field_rout_product_link[0]['view']) {
    print t($node->field_rout_product_link[0]['view']);
  }
  else {
    print "Learn More";
  }
?>
   
</div>

</div>

<div class="product_column2">

  <?php print $group_product_details_rendered ?>

<div class="product_links">
<?php
  /*if ($node->field_rout_product_link[0]['view']) {
    print t($node->field_rout_product_link[0]['view']);
  }
  else {
    print "Learn More";
  }*/
?>
  <?php if($node->field_rout_contact_email[0]['view']){?>
    <br /><br /><h3>Contact Vendor</h3>
    <?php $block = module_invoke('webform', 'block_view', 'client-block-677');
    echo $block['content']; ?>
  <?php }?>
</div>

</div>


  <div class="clear-block">
    <div class="meta">
    <?php if ($taxonomy): ?>
      <div class="terms"><?php print $terms ?></div>
    <?php endif;?>
    </div>

  </div>

</div>
