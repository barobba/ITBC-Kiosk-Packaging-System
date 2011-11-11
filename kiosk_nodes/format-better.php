<?php
require_once('../caching/functions.php');
require_once('functions.php');

$results = cache_get_contents('input_files/nids');
$results = json_decode($results);

$better = array();
foreach ($results as $nid => $result) {
  $better[$nid] = $result->nodes[0]->node;
}

header('Content-type: text/plain');
print_r($better);
