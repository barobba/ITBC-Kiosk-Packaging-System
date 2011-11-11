<?php

function lat_url_prepare($nid) {
  return 'http://liveandtell.com/api/kiosk/0.1/node/json/'.$nid;
}

function lat_node_data_retrieve($node_nids) {
  $nodes = array();
  foreach ($node_nids as $nid) {
    $url = lat_url_prepare($nid);
    $contents = file_get_contents($url);
    $nodes [$nid]= json_decode($contents);
  }
  return $nodes;
}
