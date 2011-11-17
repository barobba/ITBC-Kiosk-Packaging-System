<?php

function get_selected_items($filename) {
  $filepath = 'selections/' . $filename;
  $selected_items = file_get_contents($filepath);
  convert_line_endings($selected_items);
  convert_to_array($selected_items);
  return $selected_items;
}

function get_filename() {
  if (empty($_REQUEST)) {
    $filename = 'nids';
  }
  elseif (isset($_REQUEST['file'])) {
    $request = $_REQUEST['file'];
    $filename = 'list_of_selected_' . $request;
  }
  else {
    exit('Invalid option(s) for returning node NIDs.');
  }
}

function convert_line_endings(&$text) {
  $text = str_replace("\r\n", "\n", $text);
}

function convert_to_array(&$text) {
  $text = explode("\n", $text);
}
