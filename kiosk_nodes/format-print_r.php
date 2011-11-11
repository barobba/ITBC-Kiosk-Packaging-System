<?php
require_once('../caching/functions.php');
require_once('functions.php');

$results = cache_get_contents('input_files/nids');
$results = json_decode($results);

header('Content-type: text/plain');
print_r($results);
