<?php

require_once('../../_config/system-settings.php');
require_once('../../_functions/common.php');
require_once('../../_config/config.php');
require_once('../../_libraries/endpoint_functions/functions.php');
require_once('../../_libraries/endpoint_functions/fixes.php');

// Retrieve picture-book/json.php data
if (isset($_REQUEST['nid'])) {
  $node_nid = $_REQUEST['nid'];
}

$no_reset_cache = FALSE; // i.e. use cached data
$book_url = cached_content_url('picture-book-custom', $node_nid, $no_reset_cache);
$book_string = file_get_contents($book_url);
$book = json_decode($book_string);
$pictures = $book->books[0]->pictures;

foreach ($pictures as $picture_idx => $picture) {
  if (property_exists($picture, 'Examples')) {
    $picture->text = $picture->Examples[0];
  }
  else {
    unset($pictures[$picture_idx]);
  }
  unset($picture->Examples);
  unset($picture->terms);
}

$cards = (object)array('cards' => (array)$pictures);

header('Content-type: application/json');
print json_encode($cards);
