<?php
require_once('../../_functions/common.php');
require_once('functions.php');

$filename = get_filename();
$selected_items = get_selected_items($filename);

header('Content-type: application/json');
print json_encode($selected_items);
