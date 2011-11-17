<?php

require_once('variables.php');
require_once('../_config/config.php');

/**
 * URL FORMATTERS
 */

function url_formatter_latviews_json($args) {
  $request_array = array();
  $request_array []= 'http://liveandtell.com';
  $request_array []= $args['url'];
  $request_array []= $args['source_string'];
  return implode('/', $request_array);
}

function url_formatter_kiosk($args) {
  $request_array = array();
  $request_array []= $GLOBALS['config']['domain'];
  $request_array []= $args['url'];
  $request = implode('/', $request_array);
  $request .= '?nid='.urlencode($args['source_string']);
  return $request;
}

/**
 * RETURNS THE RESULT OF A FORMATTER
 */

function api_request_prepare() {
  
  $endpoints = $GLOBALS['endpoints'];
  
  // Prepare the args
  $endpoint_idx = $_REQUEST['endpoint_idx'];
  $endpoint_args = $endpoints[$endpoint_idx]['arguments'];
  if (isset($_REQUEST['source'])) {
    $source = $_REQUEST['source'];
    $source_string = $_REQUEST['source-'.$source];
    $source_string = str_replace(array("\n", "\r", "\r\n"), '', $source_string);
    $endpoint_args ['source_string']= $source_string;
  }
  
  // Call the function
  $function = 'url_formatter_'.$endpoints[$endpoint_idx]['url_formatter'];
  return $function($endpoint_args);
  
}
