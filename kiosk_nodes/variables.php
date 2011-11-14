<?php

$endpoints = array(
  array('name' => 'Nodes',                'url_formatter'=>'latviews_json', 'arguments' => array('url' => 'api/kiosk/0.1/node/json')),
  array('name' => 'Picture books',        'url_formatter'=>'latviews_json', 'arguments' => array('url' => 'api/kiosk/0.1/type/picture-book/json')),
  array('name' => 'Picture books (FULL)', 'url_formatter'=>'kiosk',         'arguments' => array('url' => 'kiosk_caching/kiosk_nodes/endpoint-picture-books.php')),
  array('name' => 'Picture book entries', 'url_formatter'=>'latviews_json', 'arguments' => array('url' => 'api/kiosk/0.1/type/picture-book/entries/json')),
  array('name' => 'Picture, Tagged',      'url_formatter'=>'latviews_json', 'arguments' => array('url' => 'api/kiosk/0.1/type/picture-tagged/json')),
  array('name' => 'Song',                 'url_formatter'=>'latviews_json', 'arguments' => array('url' => 'api/kiosk/0.1/type/song/json')),
);

$api_paths_assoc = array(
  'Nodes'              => array('name' => 'Nodes',                'url' => 'api/kiosk/0.1/node/json'),
  'Picture book'       => array('name' => 'Picture books',        'url' => 'api/kiosk/0.1/type/picture-book/json'),
  'Picture book entry' => array('name' => 'Picture book entries', 'url' => 'api/kiosk/0.1/type/picture-book/entries/json'),
  'LiveAndTell Image'  => array('name' => 'Picture, Tagged',      'url' => 'api/kiosk/0.1/type/picture-tagged/json'),
  'Audio'              => array('name' => 'Song',                 'url' => 'api/kiosk/0.1/type/song/json')
);

// (Retains implicit ordering in the array)
$api_paths = array(
  array('name' => 'Nodes',                'url' => 'api/kiosk/0.1/node/json'),
  array('name' => 'Picture books',        'url' => 'api/kiosk/0.1/type/picture-book/json'),
  array('name' => 'Picture book entries', 'url' => 'api/kiosk/0.1/type/picture-book/entries/json'),
  array('name' => 'Picture, Tagged',      'url' => 'api/kiosk/0.1/type/picture-tagged/json'),
  array('name' => 'Song',                 'url' => 'api/kiosk/0.1/type/song/json')
);
