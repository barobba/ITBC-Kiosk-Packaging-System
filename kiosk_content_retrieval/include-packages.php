<?php

$packages = array(

  'lakota_animals' => array(
    array(
      'name' => 'Animals',
      'description' => 'Lakota animals',
      'data_source_url' => $config['domain'].'/endpoints/selected-nodes/json.php?file=lakota_animals',
      'handlers' => array(
      	'cards',
      ),
    ),
    array(
      'name' => 'Songs',
      'description' => 'This content was picked for the Lakota/Dakota/Nakota Language Summit, for demonstration purposes',
      'data_source_url' => $config['domain'].'/endpoints/selected-nodes/json.php?file=lakota_animal_songs',
      'handlers' => array('songs'),
    ),
    
  ), // end lakota (package)

  
); // end $packages = array()
