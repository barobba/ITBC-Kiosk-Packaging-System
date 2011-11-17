<?php

function cached_content_url($request_handler_name, $request, $reset_cache = 1) {
  $url = $GLOBALS['config']['domain'] . '/endpoints_caching/form-results.php'
       . '?endpoint_idx=' . $request_handler_name
       . '&source=type-list'
       . '&source-type-list=' . $request
       . '&reset-cache=' . $reset_cache
       . '&format=json';
  return $url;
}

function latget_node($node_nid) {
  $node_query = cached_content_url('node', $node_nid);
  $node = file_get_contents($node_query);
  if ($node) {
    $node = json_decode($node);
    $node = $node->nodes[0]->node;
    return $node;
  }
  else {
    exit("Could not retrieve node given NID ($node_nid).");
  }
}

function latmerge_song(&$node) {
  $song_query = cached_content_url('song', $node->NID);
  $song = file_get_contents($song_query);
  $song = json_decode($song);
  $song = $song->nodes[0]->node;
  $node = (object)array_merge((array)$node,(array)$song);
  // Nothing to return; modified input variable
}


function latmerge_picture_book(&$node) {
  $book_query = cached_content_url('picture-book', $node->NID);
  $book = file_get_contents($book_query);
  $book = json_decode($book);
  if (isset($book->pictureBooks[0])) {
    $book = $book->pictureBooks[0]->pictureBook;
    $node = (object)array_merge((array)$node, (array)$book);
  }
  // Nothing to return; modified input variable
}

function latget_picture_book_list($book_nid) {
  $picture_list_query = cached_content_url('picture-book-entries', $book_nid);
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
    $picture_query = cached_content_url('picture-tagged', $picture_entry->NID);
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
      $term_query = cached_content_url('term', $picture_entry->NID);
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
      $picture_query = cached_content_url('picture-references', $picture_entry->imageNodeReference);
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

function latmerge_user(&$node) {
  if (isset($node->uid)) {
    $user_query = cached_content_url('users', $node->uid);
    $user_query_results = file_get_contents($user_query);
    $user_query_results = json_decode($user_query_results);
    $user = $user_query_results->users[0]->user;
    $node->user = $user;
  }
  // Nothing to return; modified input variable
}
