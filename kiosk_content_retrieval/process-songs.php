<?php

require_once('../_config/system-settings.php');
require_once('../_config/config.php');
require_once('../_libraries/endpoint_functions/functions.php');
require_once('functions.php');

function process_songs($data_source_url, $results_directory) {

  print "Processing songs\n";
  
  //
  // Retrieve the list of nodes from the data source
  //
  
  $nids = nids_retrieve($data_source_url);
  if (empty($nids)) {
    exit("Could not find NIDs to process");
  }
  
  //
  // Retrieve the songs
  //
  print "Retrieving song data\n";
  $song_data_url = songs_url_prepare($nids);
  $songs = songs_retrieve($song_data_url);

  //
  // RETRIEVE AUDIO
  //
  $audio_ids = array();
  foreach ($songs->songs as &$song) {
    if (!empty($song->songAudio->audioID)) {
      $audio_ids []= $song->songAudio->audioID;
    }
  }
  audio_retrieve($audio_ids, dirpath_songs($results_directory));
  audio_convert($audio_ids, dirpath_songs($results_directory));
  
  //
  // SAVE THE SONG FILE
  //
  
  song_data_save($results_directory, '_data.json', $songs);
  print "Song data saved\n";
  
}

function songs_url_prepare($nids) {
  $nids_query_values = implode('+', $nids);
  $no_reset_cache = 0;
  return $endpoint_url = cached_content_url('song-custom', $nids_query_values, $no_reset_cache);
}

function songs_retrieve($data_url) {
  $data = file_get_contents($data_url);
  if (!empty($data)) {
    $songs = json_decode($data);
    return $songs;
  }
  else {
    exit('Songs not found!');
  }
}

function song_data_save($results_directory, $filename, &$songs_data) {
  $dirpath = dirpath_songs($results_directory);
  if (!file_exists($dirpath)) {
    mkdir($dirpath);
  }
  file_put_contents($dirpath.'/'.$filename, json_encode($songs_data));
  
  // Nothing to return; file saved
}

function dirpath_songs($results_directory) {
  return $results_directory.'/packs_songs';
}
