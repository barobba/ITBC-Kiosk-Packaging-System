<?php
require_once('drupal.php');
require_once('../../_config/config.php');

$is_key_missing = FALSE;
$keys = array('login_url','name', 'pass', 'path', 'mime_type');
foreach ($keys as $key) {
  if(!array_key_exists($key, $_REQUEST)) {
    $is_key_missing = TRUE;
  }
}
if ($is_key_missing) {

  print <<<EOS
  <form method="post">
    <div>Login URL: <input name="login_url" /></div>
    <div>Username: <input name="name" />, Password: <input name="pass" /></div>
    <div>Request path: <input name="path" /></div>
    <div>Content type: <input name="mime_type" /> (e.g. application/json)</div>
  </form>
EOS;

}
else {

  $login_url  = $_REQUEST['login_url'];
  $login_name = $_REQUEST['name'];
  $login_pass = $_REQUEST['pass'];
  $content_path = $_REQUEST['path'];
  $content_mime_type = $_REQUEST['mime_type'];
  
  // Login and get information from Drupal site
  $DRUPAL = drupal_open($login_url, $login_name, $login_pass);
  $result = drupal_path($DRUPAL, $content_path);
  drupal_close($DRUPAL);

  // Print results
  header('Content-type: '.$content_mime_type);
  print $result;

}
