<?php

require_once('../../_config/system-settings.php');
require_once('../../_config/config.php');
require_once('../../_libraries/endpoint_functions/functions.php');
require_once('../../_libraries/endpoint_functions/fixes.php');

$results = array();
if (!isset($_REQUEST['nid'])) {
  exit('Missing "nid" key.');
}

$node_nids = $_REQUEST['nid'];
$node_nids = explode(' ', $node_nids);

foreach ($node_nids as $node_nid) {

  // Get the node
  $song = latget_node($node_nid);

  // Merge the song data to the node
  latmerge_song($song);
  
  // Add the user information to the book
  latmerge_user($song);
  
  // Fix some of the entries
  if (property_exists($song, 'songAudio')) {
    fix_audiotext($song->songAudio);
  }
  
  if (property_exists($song, 'songTranslationAudio')) {
    fix_audiotext($song->songTranslationAudio);
  }
  
  $results []= $song;
}

$results = (object)array('songs' => $results);

header('Content-type: application/json');
print json_encode($results);
