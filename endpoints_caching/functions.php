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




/**
 * I THINK THE FOLLOWING FUNCTIONS ARE UNUSED...
 */

/*

function lat_retrieve_nodes($nids) {
  $domain = 'http://liveandtell.com';
  $path = $_REQUEST['path'];
  $nid_list = implode('+', $nids);
  $url = "$domain/$path/$nid_list";
  $contents = file_get_contents($url);
  return $contents;
}

function lat_retrieve_nodes_individually($node_nids) {
  $domain = 'http://liveandtell.com';
  $path = $_REQUEST['path'];
  $nodes = array();
  foreach ($node_nids as $nid) {
    $url = "$domain/$path/$nid";
    $contents = file_get_contents($url);
    $nodes = array_merge($nodes, json_decode($contents)->nodes);
  }
  return json_encode((object)array('nodes' => $nodes));
}

function cache_get_contents($filepath) {
  $nids = explode("\n", file_get_contents($filepath));
  return cached_user_func_array('lat_retrieve_nodes', array($nids));
}
*/
 