<?php

  require_once('settings.php');

  $form = array(
    'action' => 'form-results.php',
    'elements' => array(
      'handlers' => array(
        array('name' => 'Nodes',                'url' => 'api/kiosk/0.1/node/json'),
        array('name' => 'Picture books',        'url' => 'api/kiosk/0.1/type/picture-book/json'),
        array('name' => 'Picture book entries', 'url' => 'api/kiosk/0.1/type/picture-book/entries/json'),
        array('name' => 'Picture, Tagged',      'url' => 'api/kiosk/0.1/type/picture-tagged/json'),
        array('name' => 'Song',                 'url' => 'api/kiosk/0.1/type/song/json')
      ),
      'default_value_string' => implode('+', explode("\n", file_get_contents('input_files/nids')))
    ),
  );
  
  require_once('templates/form.template.php');
