<?php

require_once('../_config/system-settings.php');
require_once('../_config/config.php');
require_once('../_libraries/endpoint_functions/functions.php');
require_once('functions.php');

function process_cards($data_source_url, $results_directory) {

  print "Processing cards\n";
  
  // Retrieve the list of nodes from the data source
  $nids = nids_retrieve($data_source_url);
  if (empty($nids)) {
    exit("Could not find NIDs to process");
  }
  
  foreach ($nids as $nid) {
    
    if (empty($nid)) {
      continue;
    }
    print "$nid\n";

    // RETRIEVE CARD DATA
    print "Retrieving card data\n";
    
    $card_nid = $nid;
    $card_data_url = cards_url_prepare($card_nid);
    $cards = cards_retrieve($card_data_url);
    if (empty($cards->cards)) {
      print "Nothing to print...\n";
      continue;
    }

    // MAKE SURE DIRECTORY EXISTS
    $dirpath = dirpath_cards($results_directory, $nid);
    if (!file_exists($dirpath)) {
      mkdir($dirpath);
    }

    // RETRIEVE PICTURES
    print "Retrieving pictures\n";
    foreach ($cards->cards as &$picture) {
      
      if (empty($picture->pictureURL)) {
        print "No picture URL...skipping.";
        continue;
      }
      
      $filename = explode('/', $picture->pictureURL);
      $filename = array_pop($filename);
      if (empty($filename)) {
        print "Cannot find filename...skipping.";
        continue;
      }

      // Get the file extension
      $file_array = explode('.', $filename);
      $file_ext = array_pop($file_array);

      // SPECIAL CASE: CREATE THIS SPECIAL FILENAME FOR THE JAVASCRIPT
      // APPLICATION TO USE (UNIFIED FILE NAMING).
      $picture->pictureFilename = $picture->NID.'.'.$file_ext;
      $filepath = $dirpath.'/'.$picture->pictureFilename;
      
      if (!file_exists($filepath)) {
        // File isn't already saved, so retrieve and save picture
        print "Retrieving picture $picture->pictureURL\n";
        $picture_data = file_get_contents($picture->pictureURL);
        print "Retrieval finished\n";
        print "Saving picture $filepath\n";
        file_put_contents($filepath, $picture_data);
        print "Saved picture\n";
      }
      else {
        print "Already downloaded picture.\n";
      }
      
      $outfile = $dirpath.'/'.$picture->NID.'-COLORING.'.$file_ext;
      if (file_exists($filepath) && !file_exists($outfile)) {
        // GENERATE COLORING PAGE
        print "Creating coloring page from picture\n";
        `/usr/local/bin/convert $filepath -resize 700x700 $outfile`;
        `/usr/local/bin/convert $filepath -define convolve:scale='!' -define morphology:compose=Lighten -morphology Convolve 'Sobel:>' $outfile`;
        `/usr/local/bin/convert $outfile -colorspace Gray -equalize -threshold 75% -negate -statistic Maximum 2x2 $outfile`;
        print "Finished creating coloring page\n";
      }
      else {
        print "Already generated coloring page, or input file missing.\n";
      }
        
      $outfile_thumb = $dirpath.'/'.$picture->NID.'-THUMB.'.$file_ext;
      if (file_exists($filepath) && !file_exists($outfile_thumb)) {
        // GENERATE THUMBNAIL
        `/usr/local/bin/convert $filepath -thumbnail 100x100 $outfile_thumb`;
      }
      else {
        print "Already generated thumbnail, or input file missing.";
      }
      
    } // end foreach picture
    print "Finished retrieving pictures\n";
    
    
    //
    // RETRIEVE AUDIO
    //
    
    $audio_ids = array();
    foreach ($cards->cards as &$picture) {
      if (!empty($picture->text->example->audioID)) {
        $audio_ids []= $picture->text->example->audioID;
      }
      if (!empty($picture->text->translation->audioID)) {
        $audio_ids []= $picture->text->translation->audioID;
      }
      
    }
    audio_retrieve($audio_ids, $dirpath);
    audio_convert($audio_ids, $dirpath);
    
    
    //
    // SAVE THE CARD FILE
    //
    
    card_data_save($dirpath, '_data.json', $cards);
    print "Card data saved\n";
    
  } // end foreach nid
  print "Finished processing cards\n";
  
}

function cards_url_prepare($nid) {
  $no_reset_cache = 0;
  return $endpoint_url = cached_content_url('cards-custom', $nid, $no_reset_cache);
}

function cards_retrieve($data_url) {
  $data = file_get_contents($data_url);
  if (!empty($data)) {
    $cards = json_decode($data);
    return $cards;
  }
  else {
    exit('Cards not found!');
  }
}

function card_data_save($dirpath, $filename, &$cards_data) {
  file_put_contents($dirpath.'/'.$filename, json_encode($cards_data));
  // Nothing to return; file saved
}

function dirpath_cards($results_directory, $nid) {
  if (!is_string($nid)) {
    print "NOT A STRING\n";
    print_r($nid);
  }
  return $results_directory.'/packs_cards/'.$nid;
}
