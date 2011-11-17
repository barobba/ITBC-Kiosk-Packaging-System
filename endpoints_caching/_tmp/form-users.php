<?php

  require_once('settings.php');

  $form = array(
    'action' => 'form-results.php',
    'elements' => array(
      'handlers' => array(
        array('name' => 'Users', 'url' => 'api/kiosk/0.1/users/json'),
      ),
    ),
  );
  
  require_once('templates/form.template.php');
