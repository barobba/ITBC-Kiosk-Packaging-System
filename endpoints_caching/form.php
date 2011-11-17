<?php

  require_once('../_config/system-settings.php');
  require_once('../_config/config.php');
  require_once('variables.php');
  
  $form = array(
    'action' => 'form-results.php',
    'elements' => array(
      'endpoints' => $endpoints,
      'default_value_string' => implode('+', explode("\n", file_get_contents($config['domain'].'/endpoints/selected-nodes/json.php?file=nids')))
    ),
  );
  
  require_once('templates/form.template.php');
