<?php

function property_clone(&$to, $from, $property) {
  if (property_exists($from, $property)) {
    $to->$property = $from->$property;
  }
}
