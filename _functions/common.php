<?php

function property_clone(&$to, $from, $property) {
  if (property_exists($from, $property)) {
    $to->$property = $from->$property;
  }
}

function dump_html($var) {
  print_r($var);
}

function dump_plain($var) {
  header('Content-type: text/plain');
  print_r($var);
}

function dump_json($var) {
  header('Content-type: application/json');
  print json_encode($var);
}

function assoc_or_die($key, $var, $msg) {
  if (isset($var[$key])) {
    return $var[$key];
  }
  else {
    exit($msg);
  }
}
