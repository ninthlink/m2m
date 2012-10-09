<?php

function qclickthru_settings_form() {
	$url = 'http://' .$_SERVER['HTTP_HOST'];
  $form['qclickthru_redirect_url'] = array(
     '#type' => 'textfield',
     '#title' => t('Enter the redirect url for the acknowledgement application.'),
     '#default_value' => variable_get('qclickthru_redirect_url', "http://qtiack12.iskoot.com/ack/agreement/review?referer=$url"),
     '#size' => 140,
     '#maxlength' => 140,
     '#weight' => -10
   );

  $form['qclickthru_ack_check'] = array(
      '#type' => 'checkbox',
      '#title' => t('Check the QTI_ACK cookie.'),
      '#default_value' => variable_get('qclickthru_ack_check', TRUE),
      '#description' => t('If checked, users who dont have the QTI_ACK cookie will be logged out.  It is highly recommended that this be set the same as the qsessions QTI_ACK cookie variable.'),
      '#weight' => -4
    );

  return system_settings_form($form);
}