<?php

require_once('../../_config/system-settings.php');
require_once('../../_config/config.php');
require_once('../../_libraries/endpoint_functions/functions.php');
require_once('../../_libraries/endpoint_functions/fixes.php');

$results = array();
if (!isset($_REQUEST['nid'])) {
  exit('Missing "nid" key.');
}
$book_nids = explode(' ', $_REQUEST['nid']);
foreach ($book_nids as $book_nid) {
  
  // Get the node
  $book = latget_node($book_nid);
  
  // Merge the book data to the node
  latmerge_picture_book($book);
  
  // Add the user information to the book
  latmerge_user($book);
  
  // Get book entries
  $picture_list = latget_picture_book_list($book_nid);
  $book->pictures = $picture_list;
  
  // Add picture-tagging-nodes & pictures
  latmerge_picture_tags($book->pictures);
  latmerge_picture_media($book->pictures);
  fix_pictures($book->pictures);
  
  // Add terms
  latget_terms($book->pictures);
  
  // Fix some of the entries
  fix_audiotext($book->descriptionAudio);
  
  $results []= $book;
}

$results = (object)array('books' => $results);

header('Content-type: application/json');
print json_encode($results);
