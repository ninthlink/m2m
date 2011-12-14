<?php
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$return = menu_execute_active_handler();
$success = 1;
global $user;
if($user->uid==1){
$sql="SELECT node.nid AS nid,
   node_data_field_image.field_image_fid AS node_data_field_image_field_image_fid,
   node_data_field_image.field_image_list AS node_data_field_image_field_image_list,
   node_data_field_image.field_image_data AS node_data_field_image_field_image_data,
   node.type AS node_type,
   node.vid AS node_vid,
   node.title AS node_title,
   node_data_field_company.field_company_value AS node_data_field_company_field_company_value,
   node_data_field_company.delta AS node_data_field_company_delta,
   node_data_field_image.field_frequncy_bands_value AS node_data_field_image_field_frequncy_bands_value,
   node_data_field_image.field_commercial_availability_value AS node_data_field_image_field_commercial_availability_value,
   node_data_field_image.field_voice_support_value AS node_data_field_image_field_voice_support_value,
   node_data_field_image.field_sms_support_value AS node_data_field_image_field_sms_support_value,
   node_data_field_image.field_gps_capabilities_value AS node_data_field_image_field_gps_capabilities_value,
   node_data_field_image.field_advertised_markets_value AS node_data_field_image_field_advertised_markets_value,
   node_data_field_image.field_electrical_interface_value AS node_data_field_image_field_electrical_interface_value,
   node_data_field_image.field_dimensions_value AS node_data_field_image_field_dimensions_value,
   node_data_field_image.field_weight_value AS node_data_field_image_field_weight_value,
   node_data_field_image.field_operational_temperature_ra_value AS node_data_field_image_field_operational_temperature_ra_value,
   node_data_field_image.field_chipset_model_value AS node_data_field_image_field_chipset_model_value,
   node_data_field_image.field_control_commands_value AS node_data_field_image_field_control_commands_value,
   node_data_field_image.field_application_processor_value AS node_data_field_image_field_application_processor_value,
   node_data_field_image.field_ss_environment_value AS node_data_field_image_field_ss_environment_value,
   node_data_field_image.field_voice_support_value AS node_data_field_image_field_voice_support_value,  
   node_data_field_image.field_sms_support_value AS node_data_field_image_field_sms_support_value,
   node_data_field_image.field_gps_capabilities_value AS node_data_field_image_field_gps_capabilities_value, 
   node_data_field_image.field_i2c_value AS node_data_field_image_field_i2c_value,
   node_data_field_image.field_spi_value AS node_data_field_image_field_spi_value,
   node_data_field_image.field_usb_value AS node_data_field_image_field_usb_value, 
   node_data_field_image.field_uart_ports_value AS node_data_field_image_field_uart_ports_value,
   node_data_field_image.field_max_gpios_value AS node_data_field_image_field_max_gpios_value,
   node_data_field_image.field_adc_value AS node_data_field_image_field_adc_value,
   node_data_field_image.field_pwm_value AS node_data_field_image_field_pwm_value,
   node_data_field_image.field_interrupt_pins_value AS node_data_field_image_field_interrupt_pins_value,
   node_data_field_image.field_sim_ruim_interface_value AS node_data_field_image_field_sim_ruim_interface_value, 
   node_data_field_image.field_sim_ruim_embedded_slots_value AS node_data_field_image_field_sim_ruim_embedded_slots_value,
   node_data_field_image.field_security_features_value AS node_data_field_image_field_security_features_value,
   node_data_field_image.field_fota_support_value AS node_data_field_image_field_fota_support_value,
   node_data_field_image.field_remote_management_value AS node_data_field_image_field_remote_management_value,
   node_data_field_image.field_standard_certifications_value AS node_data_field_image_field_standard_certifications_value,
   node_data_field_image.field_website_url AS node_data_field_image_field_website_url,
   node_data_field_image.field_contact_email_value AS node_data_field_image_field_contact_email_value,
   node_data_field_image.field_gobi_api_value AS node_data_field_image_field_gobi_api_value, 
   node_data_field_image.field_mounting_value AS node_data_field_image_field_mounting_value,
   node_revisions.format AS node_revisions_format,
   node.created AS node_created
 FROM {node} node 
 LEFT JOIN {content_type_device} node_data_field_image ON node.vid = node_data_field_image.vid
 LEFT JOIN {content_field_company} node_data_field_company ON node.vid = node_data_field_company.vid
 LEFT JOIN {node_revisions} node_revisions ON node.vid = node_revisions.vid
 WHERE node.type in ('device') AND node.status='1' GROUP BY nid ORDER BY node_created DESC";
    $rec = db_query($sql) or die (mysql_error());
   
//    $num_fields = mysql_num_fields($rec);
   
   $headers_field=array('Company','Product','Modem technology','Frequncy bands','Advertised markets','Commercial Availability','Electrical interface','Dimensions','Weight','Operational temperature range','Chipset model','Control commands','Application processor','Supported software environments','Voice support','SMS support','GPS capabilities','I2C','SPI','USB','UART ports','Max GPIOs','ADC','PWM','Interrupt pins','SIM / RUIM interface','SIM / RUIM embedded slots','Security features','FOTA support','Remote management','Standard Certifications','Operator Certifications','Website','Contact email','Gopi API','Mounting');
    for($i = 0; $i < count($headers_field); $i++ ) {
        $header .= $headers_field[$i]."\t";
	}   
    while($row = db_fetch_array($rec))  {
		$row_val=array();
		 $sql_company=db_query("select field_company_value from drpl_node n, drpl_content_field_company c where n.nid='$row[nid]' AND n.nid=c.nid");
		$option_company1=array();
		while($row_company=db_fetch_array($sql_company)){
			$option_company1[]=$row_company['field_company_value'];	
		}
		$var1=rtrim(implode(",",$option_company1));
		//	$common=array_intersect($option_company1,$option_company);	
 	    //  if($user->uid==$row->node_uid || count($common)){
		$sql_modem=db_query("select field_modem_technology_value from drpl_content_field_modem_technology m where m.nid='$row[nid]'");
		$option_modem=array();
		while($row_modem=db_fetch_array($sql_modem)){
			$option_modem[]=$row_modem['field_modem_technology_value'];	
		}
		$var2=rtrim(implode(",",$option_modem));
		$sql_operator=db_query("select field_operator_certifications_value from drpl_content_field_operator_certifications o where o.nid='$row[nid]'");
		$option_operator=array();
		while($row_operator=db_fetch_array($sql_operator)){
			$option_operator[]=$row_operator['field_operator_certifications_value'];
		}
		$var3=rtrim(implode(",",$option_operator));
		
        $line = '';

		$row_val[]=$var1;
		$row_val[]=$row['node_title'];
		$row_val[]=$var2;
		$row_val[]=$row['node_data_field_image_field_frequncy_bands_value'];
		$row_val[]=$row['node_data_field_image_field_advertised_markets_value'];
		$row_val[]=$row['node_data_field_image_field_commercial_availability_value'];
		$row_val[]=$row['node_data_field_image_field_electrical_interface_value'];
		$row_val[]=$row['node_data_field_image_field_dimensions_value'];
		
		$row_val[]=$row['node_data_field_image_field_weight_value'];
		$row_val[]=$row['node_data_field_image_field_operational_temperature_ra_value'];
		$row_val[]=$row['node_data_field_image_field_chipset_model_value'];
		$row_val[]=$row['node_data_field_image_field_control_commands_value'];
		$row_val[]=$row['node_data_field_image_field_application_processor_value'];

		$row_val[]=$row['node_data_field_image_field_ss_environment_value'];
		$row_val[]=$row['node_data_field_image_field_voice_support_value'];
		$row_val[]=$row['node_data_field_image_field_sms_support_value'];
		$row_val[]=$row['node_data_field_image_field_gps_capabilities_value'];
		$row_val[]=$row['node_data_field_image_field_i2c_value'];

		$row_val[]=$row['node_data_field_image_field_spi_value'];
		$row_val[]=$row['node_data_field_image_field_usb_value'];
		$row_val[]=$row['node_data_field_image_field_uart_ports_value'];
		$row_val[]=$row['node_data_field_image_field_max_gpios_value'];
		$row_val[]=$row['node_data_field_image_field_adc_value'];

		$row_val[]=$row['node_data_field_image_field_pwm_value'];
		$row_val[]=$row['node_data_field_image_field_interrupt_pins_value'];
		$row_val[]=$row['node_data_field_image_field_sim_ruim_interface_value'];
		$row_val[]=$row['node_data_field_image_field_sim_ruim_embedded_slots_value'];
		$row_val[]=$row['node_data_field_image_field_security_features_value'];
		
		$row_val[]=$row['node_data_field_image_field_fota_support_value'];
		$row_val[]=$row['node_data_field_image_field_remote_management_value'];
		$row_val[]=$row['node_data_field_image_field_standard_certifications_value'];
		$row_val[]=$var3;
		$row_val[]=$row['node_data_field_image_field_website_url'];
		
		$row_val[]=$row['node_data_field_image_field_contact_email_value'];
		$row_val[]=$row['node_data_field_image_field_gobi_api_value'];
		$row_val[]=$row['node_data_field_image_field_mounting_value'];
//		$row_val[]=$row['node_data_field_image_field_sim_ruim_embedded_slots_value'];
	//	$row_val[]=$row['node_data_field_image_field_security_features_value'];

				
		
        foreach($row_val as $value) {                                           
            if((!isset($value)) || ($value == "")){
                $value = "\t";
            }else{
                $value = str_replace( '"' , '""' , $value );
                $value = '"' . $value . '"' . "\t";
            }
            $line .= $value;
        }
        $data .= trim( $line ) . "\n";
    }
   
    $data = str_replace("\r" , "" , $data);
   
    if ($data == "")
    {
        $data = "\n No Record Found!n";                       
    }
   
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=reports.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data";
	}else{
		
	echo "<h2>Access Denied</h2>";	
	}
?>