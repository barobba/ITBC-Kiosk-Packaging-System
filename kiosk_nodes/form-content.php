<?php

  require_once('variables.php');
  require_once('settings.php');
  
  $form = array(
    'action' => 'form-results.php',
    'elements' => array(
      'endpoints' => $endpoints,
      'default_value_string' => implode('+', explode("\n", file_get_contents('input_files/nids')))
    ),
  );
  
  require_once('templates/form.template.php');
