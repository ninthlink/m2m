<?php
// $Id: node.tpl.php,v 1.5 2007/10/11 09:51:29 goba Exp $

?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
<?php $message=drupal_get_messages(); 
if($message['status'][0]){ ?>
<?php if(strpos($message['status'][0],'has been created')!==false) {?> <div style="border:1px solid #000000;background-color:#ffffff;color:#090;font-weight:bold;"><?php }else{?><div style="border:1px solid #000000;background-color:#ffffff;color:#F00;font-weight:bold;"><?php }?>
<?php print $message['status'][0];?>
</div>
<?php }?>
 <div class="productDetailMain">
      <div class="productDetailR">
      <h2>Product Details</h2>
      <div><?php if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?></div>
  <div class="content clear-block">
    <?php print $field_company_rendered; ?>
	<div class="field field-type-text">
      <div class="field-label">Product:&nbsp;</div>
    <div class="field-items">
            <div class="field-item odd">
              <?php print $title ?>       </div>
        </div>
</div>
 <?php
	print $node_title_rendered;
	/*print $field_chipset_model_rendered;
	print $field_modem_technology_rendered;
	print $field_frequncy_bands_rendered;
	print $field_advertised_markets_rendered;
	print $field_commercial_availability_rendered;
	print $field_mounting_rendered;
	print $field_electrical_interface_rendered;
	print $field_dimensions_rendered;
	print $field_weight_rendered;
	print $field_operational_temperature_ra_rendered;
	print $field_control_commands_rendered;
	print $field_gobi_api_rendered;
	print $field_application_processor_rendered;
	print $field_ss_environment_rendered;
	print $field_voice_support_rendered;
	print $field_sms_support_rendered;
	print $field_gps_capabilities_rendered;
	print $field_i2c_rendered;
	print $field_usb_rendered;
	print $field_uart_ports_rendered;
	print $field_max_gpios_rendered;
	print $field_adc_rendered;
	print $field_pwm_rendered;
	print $field_interrupt_pins_rendered;
	print $field_sim_ruim_interface_rendered;
	print $field_sim_ruim_embedded_slots_rendered;
	print $field_security_features_rendered;
	print $field_fota_support_rendered;
	print $field_remote_management_rendered;
	print $field_standard_certifications_rendered;
	print $field_operator_certifications_rendered;*/
	?>
    
  </div>

<p><?php print $field_product_link[0]['view']; ?></p>
<br/>
<?php if ($field_contact_email):?>
    <p><a href="mailto:<?php print $field_contact_email[0][view];?>?subject=Inquiry from M2MSearch.com Regarding <?php print $title;?>" target="_blank">Contact Vendor</a></p>
    <?php endif; ?>
      </div>
      <div class="productDetailL">
        <?php echo l('<div class="backtoSearch"></div>', 'routersearch', array('attributes' => array('title' =>"Back to search results"), 'html' => TRUE));?>
       <div class="productImg">
       <?php if($field_image_rendered) { print $field_image_rendered; }
	         else{     
	   ?>
		     <img src="<?php echo base_path().$directory;?>/images/img1.png" width="221" height="201" alt="Product" />
       <?php }?>
       <div class="productImgR"><?php print $field_product_link[0]['view']; ?> <?php if ($field_contact_email):?> |
    <a href="mailto:<?php print $field_contact_email[0][view];?>?subject=Inquiry from M2MSearch.com Regarding <?php print $title;?>" target="_blank">Contact Vendor</a>
    <?php endif; ?></div>
       </div>
      </div>
    </div>
    
<?php //print $picture ?>

<?php /*if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; */?>

  <?php /*if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif;*/ ?>

  <!--<div class="content clear-block">
    <?php //print $content ?>
  </div>-->

 <!-- <div class="clear-block">
    	<div class="meta">
    <?php /*if ($taxonomy): ?>
      <div class="terms"><?php print $terms ?></div>
    <?php endif;?>
    </div>

    <?php if ($links): ?>
      <div class="links"><?php print $links; ?></div>
    <?php endif;*/ ?>
  </div>
-->
</div>
