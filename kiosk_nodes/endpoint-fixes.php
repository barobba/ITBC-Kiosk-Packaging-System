<?php

function strip_newlines($text) {
  return str_replace(array("\r","\n","\r\n"), '', $text);
}

function strip_extra_whitespace($text) {
  return preg_replace('/\s\s+/', ' ', $text);
}

function scrape_example_audio_code($example) {
  $parts = explode('<object', $example);
  if (count($parts) > 1) {
    return '<object'.$parts[1];
  }
  else {
    return '';
  }
}

function scrape_example_audio_id($example) {
  $code = scrape_example_audio_code($example);
  if (!empty($code)) {
    $code = explode("filename=", $code);
    $code = explode("'", $code[1]);
    return $code[0];
  }
  else {
    return '';
  }
}

function scrape_example_text($example) {
  $parts = explode('<object', $example);
  return $parts[0];
}

function fix_audiotext(&$audiotext) {
  $fixed = array();
  $fixed['original'] = strip_extra_whitespace(strip_newlines($audiotext));
  $fixed['audioCode'] = scrape_example_audio_code($fixed['original']);
  $fixed['audioID'] = scrape_example_audio_id($fixed['original']);
  $fixed['text'] = scrape_example_text($fixed['original']);
  $audiotext = (object)$fixed;
  // Nothing to return; input variable was modified 
}

function fix_bilingual_audiotext(&$bilingual) {
  
  $fixed = $bilingual;
  
  // Strip top
  $top_str = '<div class="sentence"><span class="label">Sentence: </span>';
  $fixed = str_replace($top_str, '', $fixed);
  
  // Strip bottom
  //$end_str = '</div>';
  $fixed = substr($fixed, 0, strlen($fixed) - 6);
  
  // Split down the middle
  $mid_str = '</div><div class="translation"><span class="label">Translation: </span>';
  $fixed = explode($mid_str, $fixed);
  
  // Fix audiotext 
  fix_audiotext($fixed[0]);
  fix_audiotext($fixed[1]);
  
  $bilingual = $fixed;
  
  // Nothing to return; input variable was modified
}

function fix_picture_xml(&$picture) {
  if (property_exists($picture, 'pictureTagsXML')) {
    $picture->pictureTagsXML = html_entity_decode($picture->pictureTagsXML);
    $picture->pictureTagsXML = strip_extra_whitespace(strip_newlines($picture->pictureTagsXML));
    // Nothing to return; input variable was modified 
  }
}

function fix_pictures(&$pictures) {
  
  // Fix XML
  foreach ($pictures as &$picture) {
    fix_picture_xml($picture);
  }
  
  // Fix Example text
  foreach ($pictures as &$picture) {
    if (property_exists($picture, 'Examples') && !empty($picture->Examples)) {
      if (is_object($picture->Examples)) {
        foreach ($picture->Examples as $index => &$example) {
          fix_bilingual_audiotext($example);
        }
      }
      else {
        fix_bilingual_audiotext($picture->Examples);
        $picture->Examples = (object)array($picture->Examples);
      }
    }
  }
  
}
