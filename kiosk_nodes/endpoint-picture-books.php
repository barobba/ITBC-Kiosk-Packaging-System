<?php

require_once('settings.php');
require_once('endpoint-functions.php');
require_once('endpoint-fixes.php');

$results = array();
if (!isset($_REQUEST['nid'])) {
  exit('Missing "nid" key.');
}
$book_nids = explode(' ', $_REQUEST['nid']);
foreach ($book_nids as $book_nid) {

  // Get book
  $book_nid = $_REQUEST['nid'];
  $book = latget_picture_book($book_nid);
  
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
