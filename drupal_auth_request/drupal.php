<?php

function drupal_open($site, $name, $pass) {
  // Perform login
  $info = array();
  $url = $site.'/user/login';
  $login_fields = array(
    'name' => $name,
    'pass' => $pass,
    'form_id' => 'user_login'
  );
  $login_result = http_post_fields($url, $login_fields, array(), array(), $login_result_info);
  $api_options = array_intersect_key($login_result_info, array('cookies' => ''));
  // Return information
  $DRUPAL_TOKEN = array(
    'site' => $site,
    'site_session' => $api_options,
  );
  return $DRUPAL_TOKEN;
}

function drupal_close($DRUPAL) {
  drupal_path($DRUPAL, 'logout');
}

function drupal_path($DRUPAL, $path) {
  $url = $DRUPAL['site'].'/'.$path;
  $options = $DRUPAL['site_session'];
  $result = http_get($url, $options);
  if ($result !== FALSE) {
    $result_array = explode("\r\n\r\n", $result, 2);
    $content = array_pop($result_array);
  }
  else {
    $content = $result;
  }
  return $content;
}
