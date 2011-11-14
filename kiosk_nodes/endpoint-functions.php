<?php

function latget_picture_book($book_nid) {
  $book_query = 'http://liveandtell.com/api/kiosk/0.1/type/picture-book/json/'.$book_nid;
  $book = json_decode(file_get_contents($book_query));
  $book = $book->pictureBooks[0]->pictureBook;
  return $book;
}

function latget_picture_book_list($book_nid) {
  $picture_list_query = 'http://liveandtell.com/api/kiosk/0.1/type/picture-book/entries/json/'.$book_nid;
  $picture_list = json_decode(file_get_contents($picture_list_query));
  $picture_list = $picture_list->pictureBookEntries;
  $picture_list_compressed = array();
  foreach ($picture_list as $picture_entry) {
    $picture_list_compressed []= $picture_entry->pictureBook;
  }
  $picture_list = $picture_list_compressed;
  return $picture_list;
}

function latmerge_picture_tags(&$pictures) {
  foreach ($pictures as $index => $picture_entry) {
    $picture_query = 'http://liveandtell.com/api/kiosk/0.1/type/picture-tagged/json/'.$picture_entry->NID;
    $picture = file_get_contents($picture_query);
    $picture = json_decode($picture);
    if (!empty($picture->pictureTagging)) {
      $picture = $picture->pictureTagging[0]->pictureTags;
    }
    else {
      // Skip...maybe need to handle this case
    }
    $pictures[$index] = $picture;
  }
  // Nothing to return; modified input variable
}

function latget_terms(&$pictures) {
  $terms = array();
  foreach ($pictures as $index => $picture_entry) {
    if (property_exists($picture_entry, 'NID')) {
      $term_query = 'http://liveandtell.com/api/kiosk/0.1/type/term/json/'.$picture_entry->NID;
      $terms = json_decode(file_get_contents($term_query));
      $terms = $terms->terms;
      $terms_compressed = array();
      foreach($terms as $term) {
        $terms_compressed []= $term->term;
      }
      $terms = $terms_compressed;
      $pictures[$index]->terms = $terms;
    }
  }
  // Nothing to return; modified input variable
}

function latmerge_picture_media(&$pictures) {
  foreach ($pictures as $index => &$picture_entry) {
    if (property_exists($picture_entry, 'imageNodeReference')) {
      $picture_query = 'http://liveandtell.com/api/kiosk/0.1/custom/picture-references/json/'.$picture_entry->imageNodeReference;
      $picture = file_get_contents($picture_query);
      $picture = json_decode($picture);
      $picture = $picture->pictures[0]->picture;
      $picture_entry = (object)array_merge((array)$picture,(array)$picture_entry);
    }
    else {
      // Skipping for now... maybe need to handle this case
    }
  }
  // Nothing to return; modified input variable
}
