<?php
/**
 * Implementation of hook_views_data_alter()
 */

function custom_m2m_views_data_alter(&$cache) {
  $cache['node']['custom_m2m'] = array(
    //'group' => 'Custom M2M',
    'title' => t('Custom M2M'),
    'help' => t('Find nodes with the same company as the user'),
    'filter' => array(
      'handler' => 'custom_m2m_filter_handler',
    ),
  );
  
  return $cache;
}

/**
 * Implementation of hook_views_handlers
 */
function custom_m2m_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'custom_m2m').'/inc',
    ),
    'handlers' => array(
      'custom_m2m_filter_handler' => array(
        'parent' => 'views_handler_filter',
      ),
    ),
  );
}