<?php

$endpoints = array(
  'node' => array(
  	'name'          => 'Nodes',
  	'url_formatter' =>'latviews_json',
  	'arguments'     => array('url' => 'api/kiosk/0.1/node/json')
  ),
  'picture-book' => array(
  	'name' => 'Picture books',        
  	'url_formatter'=>'latviews_json', 
  	'arguments' => array('url' => 'api/kiosk/0.1/type/picture-book/json')
  ),
  'picture-book-custom' => array(
  	'name' => 'Picture books (CUSTOM)', 
  	'url_formatter'=>'kiosk',         
  	'arguments' => array('url' => 'endpoints/picture-books/json.php')
  ),
  'picture-book-entries' => array(
    'name' => 'Picture book entries', 
    'url_formatter'=>'latviews_json', 
    'arguments' => array('url' => 'api/kiosk/0.1/type/picture-book/entries/json')
  ),
  'picture-tagged' => array(
  	'name' => 'Picture, Tagged',      
  	'url_formatter'=>'latviews_json', 
  	'arguments' => array('url' => 'api/kiosk/0.1/type/picture-tagged/json')
  ),
  'picture-references' => array(
  	'name' => 'Picture URLs',      
  	'url_formatter'=>'latviews_json', 
    'arguments' => array('url' => 'api/kiosk/0.1/custom/picture-references/json')
  ),
  'song' => array(
  	'name' => 'Song',                 
  	'url_formatter'=>'latviews_json', 
  	'arguments' => array('url' => 'api/kiosk/0.1/type/song/json')
  ),
  'song-custom' => array(
  	'name' => 'Songs (CUSTOM)', 
  	'url_formatter'=>'kiosk',         
  	'arguments' => array('url' => 'endpoints/songs/json.php')
  ),
  'cards-custom' => array(
  	'name' => 'Playing cards (CUSTOM)', 
  	'url_formatter'=>'kiosk',         
  	'arguments' => array('url' => 'endpoints/cards/json.php')
  ),
  'term' => array(
  	'name'          => 'Node terms',
  	'url_formatter' =>'latviews_json',
  	'arguments'     => array('url' => 'api/kiosk/0.1/type/term/json')
  ),
  'users' => array(
  	'name'          => 'Users',
  	'url_formatter' =>'latviews_json',
  	'arguments'     => array('url' => 'api/kiosk/0.1/users/json')
  ),
);
