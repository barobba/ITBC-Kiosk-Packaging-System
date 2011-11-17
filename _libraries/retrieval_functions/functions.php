<?php

function audio_retrieve($audio_ids, $local_path) {

  // Connect
  $audio_host_domain = $GLOBALS['config']['audio_host']['domain'];
  $CONN = ssh2_connect($audio_host_domain, 22);
  if (!$CONN) {
    print "COULD NOT CONNECT!\n";
    return;
  }

  // Authenticate
  $audio_host_name = $GLOBALS['config']['audio_host']['name'];
  $audio_host_pass = $GLOBALS['config']['audio_host']['pass'];
  if (!ssh2_auth_password($CONN, $audio_host_name, $audio_host_pass)) {
    print "COULD NOT AUTHENTICATE!\n";
    return;
  }
  
  // Initialize SFTP
  $SFTP = ssh2_sftp($CONN);
  
  foreach ($audio_ids as $audio_id) {
    print "Retrieving $audio_id\n";
    
    $audio_host_path = $GLOBALS['config']['audio_host']['path'];
    $remote_filepath = $audio_host_path.'/'.$audio_id.'.flv';
    $audio_data = file_get_contents("ssh2.sftp://{$SFTP}/".$remote_filepath);
    
    $local_filepath = $local_path.'/'.$audio_id.'.flv';
    file_put_contents($local_filepath, $audio_data);
    
  }
  print "Finished retrieving audio \n";
}

function audio_convert($audio_ids, $local_path) {
  foreach ($audio_ids as $audio_id) {
    print "Converting audio\n";
    $file_input = $local_path.'/'.$audio_id.'.flv';
    $file_output = $local_path.'/'.$audio_id.'.ogg';
    if (PHP_OS == 'WINNT') {
    	print `c:\\program files\\ffmpeg2theora\\ffmpeg2theora.exe $file_input -o $file_output` . "\n";
    }
    else {
    	print `/usr/local/bin/ffmpeg2theora $file_input -o $file_output` . "\n";
    }
  }
  print "Finished converting audio\n";
}