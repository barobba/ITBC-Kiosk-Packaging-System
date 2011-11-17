<?php

require_once('../_config/system-settings.php');
require_once('../_config/config.php');
require_once('../_libraries/endpoint_functions/functions.php');

// TODO: Generate index.html file for navigating pages 

function process_coloring_pages($data_source_url, $results_directory) {

  print "Processing coloring pages\n";
  
  // Retrieve the list of nodes from the data source
  $nids = file_get_contents($data_source_url);
  $nids = json_decode($nids);
  foreach ($nids as $nid) {

    // RETRIEVE BOOK DATA
    print "Retrieving book data\n";
    $book_nid = $nid;
    $book_data_url = book_url_prepare($book_nid);
    $book = book_retrieve($book_data_url);
    book_data_save($book, $results_directory, '_data.json', $book);
    print "Book data saved\n";
    
    // RETRIEVE PICTURES
    print "Retrieving pictures\n";
    foreach ($book->pictures as $picture) {
      
      if (empty($picture->pictureURL)) {
        continue;
      }

      $filename = explode('/', $picture->pictureURL);
      $filename = array_pop($filename);
      if (!empty($filename)) {
        
        print "Retrieving picture $picture->pictureURL\n";
        $picture_data = file_get_contents($picture->pictureURL);
        print "Retrieval finished\n";
    
        $file_array = explode('.', $filename);
        $file_ext = array_pop($file_array);
        $filepath = dirpath_coloring_pages($results_directory, $book).'/'.$picture->NID.'.'.$file_ext;
        print "Saving picture $filepath\n";
        file_put_contents($filepath, $picture_data);
        print "Saved picture\n";

        // GENERATE COLORING PAGE
        print "Creating coloring page from picture\n";
        $outfile = dirpath_coloring_pages($results_directory, $book).'/'.$picture->NID.'-COLORING.'.$file_ext;
        `/usr/local/bin/convert $filepath -resize 700x700 $outfile`;
        `/usr/local/bin/convert $filepath -define convolve:scale='!' -define morphology:compose=Lighten -morphology Convolve 'Sobel:>' $outfile`;
        `/usr/local/bin/convert $outfile -colorspace Gray -equalize -threshold 75% -negate $outfile`;
        print "Finished creating coloring page\n";
        
        // GENERATE THUMBNAIL
        $outfile_thumb = dirpath_coloring_pages($results_directory, $book).'/'.$picture->NID.'-THUMB.'.$file_ext;
        `/usr/local/bin/convert $filepath -thumbnail 100x100 $outfile_thumb`;
                
      }
      else {
        print_r('Could not parse this URL: '.$pictureURL);
      }
      
    } // end foreach 
    print "Finished retrieving pictures\n";
    
  } // end foreach
  print "Finished processing coloring pages\n";
  
}

function book_url_prepare($book_nid) {
  $no_reset_cache = 0;
  return $endpoint_url = cached_content_url('picture-book-custom', $book_nid, $no_reset_cache);
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

function book_data_save(&$BOOK, $results_directory, $filename, &$book_data) {
  if (!file_exists(dirpath_coloring_pages($results_directory, $BOOK))) {
    mkdir(dirpath_coloring_pages($results_directory, $BOOK));
  }
  file_put_contents(dirpath_coloring_pages($results_directory, $BOOK).'/'.$filename, json_encode($book_data));
  
  // Nothing to return; file saved
}

function dirpath_coloring_pages($results_directory, $book) {
  return $results_directory.'/packs_coloring_pages/'.$book->NID;
}
