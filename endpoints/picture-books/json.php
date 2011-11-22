<?php
/*

  Picture book
  |
  +--> Picture entries
       |
       +--> Picture tagging node
            |
            +--> Picture media (uploaded, or reference)
            |
            +--> Tags
            
  Picture entries      -> Picture book
  Picture entries      -> Picture tagging node 
  Picture tagging node -> Picture media (uploaded, or reference)
  Picture tags         -> Picture tagging node

1. The first request is to get the picture book.
2. The second request is to get the entries in the book.
3. The third request is to get each individual picture tagging node
4. The fourth request is to get the pictures
5. The fifth request is to get the tags

*/


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
  
  
  
  
  //
  // 1. Retrieving the picture book information
  //
  
  // Get the node
  $book = latget_node($book_nid);
  
  // Merge the book data to the node
  latmerge_picture_book($book);

  // Fix the audio in the picture book description (if any)
  fix_audiotext($book->descriptionAudio);
  
  // Add the user information to the book
  latmerge_user($book);
  
  
  
  
  //
  // 2. Retrieving the picture book entries
  //
  
  // Get book entries
  $picture_list = latget_picture_book_list($book_nid);
  $book->pictures = $picture_list;
  
  
  
  
  //
  // 3. Retrieving the picture tagging node
  //
  
  latmerge_picture_tags($book->pictures);
  
  
  
  
  //
  // 4. Retrieving picture media
  //
  
  latmerge_picture_media($book->pictures);
  fix_pictures($book->pictures);

  
  
  
  //
  // 5. Retrieving pictures tagging tags
  //
  
  // Add terms
  //latget_terms($book->pictures);
  
  $results []= $book;
}

$results = (object)array('books' => $results);

header('Content-type: application/json');
print json_encode($results);
