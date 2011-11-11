<?php

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
