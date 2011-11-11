<?php
require_once('../caching/functions.php');
require_once('functions.php');

header('Content-type: application/json');
print cache_get_contents('input_files/nids');
