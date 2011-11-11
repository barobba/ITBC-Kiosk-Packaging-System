<?php

require_once('../caching/functions.php');
require_once('functions.php');

// Retrieve node content
$nids = file_get_contents('nids');
$nids = explode("\n", $nids);
$results = cached_user_func_array('lat_node_data_retrieve', array($nids));

// Print results
header('Content-type: application/json');
print $results;
