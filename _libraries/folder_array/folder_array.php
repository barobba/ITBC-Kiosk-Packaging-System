<?php

function folder_array($filepath) {
  return _folder_array_recurse($filepath, $filepath);
}

function _folder_array_recurse($filename, $filepath) {
  // NOTE: "IS_DIR()" WASN'T WORKING ON LINUX (OR POSSIBLY PHP VERSION).
  if (is_file($filepath)) {
    // BASIS CASE
    return $filename;
  }
  else {
    // RECURSIVE CASE
    $folders = array();
    $folder_contents = scandir($filepath);
    foreach ($folder_contents as $sub_filename) {
      // Skip the . and ..
      if ($sub_filename == '.' || $sub_filename == '..') {
        continue;
      }
      $folders[$sub_filename] = _folder_array_recurse($sub_filename, $filepath.'/'.$sub_filename);
    }
    return $folders;
  }
}
