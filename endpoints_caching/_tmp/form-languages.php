<?php

  require_once('settings.php');

  $form = array(
    'action' => 'form-results.php',
    'elements' => array(
      'handlers' => array(
        array('name' => 'Target language (the second language, being taught)', 'url' => 'api/kiosk/0.1/category/language/json'),
      ),
    ),
  );
  
  require_once('templates/form.template.php');
