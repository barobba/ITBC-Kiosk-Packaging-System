<?php

function folder_array($filepath) {
  print "Traversing directory tree:\n";
  return _folder_array_recurse($filepath, $filepath);
}

function _folder_array_recurse($filename, $filepath) {
  
  print $filepath."\n";
  
  // NOTE: "IS_DIR()" WASN'T WORKING ON LINUX (OR POSSIBLY PHP VERSION).
  if (!opendir($filepath)) {
    // BASIS CASE
    print "It's a file\n";
    return $filename;
  }
  else {
    // RECURSIVE CASE
    print "It's a directory\n";
    $folders = array();
    $folder_contents = scandir($filepath);
    foreach ($folder_contents as $sub_filename) {

      // Skip the . and ..
      if ($sub_filename == '.' || $sub_filename == '..') {
        continue;
      }
      
      $folders[$sub_filename] = _folder_array_recurse($sub_filename, $filepath.'\\'.$sub_filename);
      
    }
    return $folders;
  }
  
}
