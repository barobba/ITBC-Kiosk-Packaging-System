<?php

function dump($data) {
  //header('Content-type: text/plain');
  print '<pre>'.htmlentities(print_r($data, TRUE)).'</pre>';
}

function book_url_prepare($book_nid) {
  $domain = $GLOBALS['conf']['domain'];
  $endpoint_url = 'http://'.$domain.'/kiosk_nodes/form-results.php?endpoint_idx=2&source=type-list&reset-cache=1&format=json&source-type-list='.$book_nid;
  return $endpoint_url;
}

function book_retrieve($book_data_url) {
  $book_data = file_get_contents($book_data_url);
  if (!empty($book_data)) {
    $book = json_decode($book_data);
    $book = $book->books[0];
    return $book;
  }
  else {
    exit('Book not found!');
  }
}

function book_data_save(&$BOOK, $filename, &$book_data) {
  if (!file_exists(dirpath($BOOK))) {
    mkdir(dirpath($BOOK));
  }
  file_put_contents(dirpath($BOOK).'/'.$filename, $book_data);
  
  // Nothing to return; file saved
}

function dirpath($book) {
  return 'coloring_books/'.$book->NID;
}
