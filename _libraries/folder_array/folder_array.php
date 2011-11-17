<?php

function folder_array($filepath) {
  print "Traversing directory tree:\n";
  return _folder_array_recurse($filepath, $filepath);
}

function _folder_array_recurse($filename, $filepath) {
  
  print $filepath."\n";
  
  $is_dir = is_dir($filepath);
  if ($is_dir) {
    $folders = array();
    $folder_contents = scandir($filepath);
    foreach ($folder_contents as $sub_filename) {
      if ($sub_filename != '.' && $sub_filename != '..') {
        $folders[$sub_filename] = _folder_array_recurse($sub_filename, $filepath.'\\'.$sub_filename);
      }
      else {
        // skipping . and ..
      }
    }
    return $folders;
  }
  else {
    return $filename;
  }
  
}
