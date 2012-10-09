<?php

function qsession_settings_form() {
  $form['qsession_cookie_domain'] = array(
     '#type' => 'textfield',
     '#title' => t('Enter the cookie domain for the QSESSION cookie.'),
     '#default_value' => variable_get('qsession_cookie_domain', $GLOBALS['cookie_domain']),
     '#size' => 40,
     '#maxlength' => 120,
     '#weight' => -10
   );

  $form['qsession_ack_check'] = array(
      '#type' => 'checkbox',
      '#title' => t('Check the QTI_ACK cookie.'),
      '#default_value' => variable_get('qsession_ack_check', TRUE),
      '#description' => t('If checked, users who dont have the QTI_ACK cookie will be logged out.'),
      '#weight' => -4
    );

  return system_settings_form($form);
}