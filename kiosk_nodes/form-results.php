<?php
require_once('settings.php');
require_once('../caching/functions.php');
require_once('variables.php');
require_once('functions.php');

// Prepare request URL
if (!isset($_REQUEST['endpoint_idx'])) {
  exit('The "path" form option is missing.');
}
  
  
$request_url = api_request_prepare();
$request_themed = "<a href='$request_url'>$request_url</a>";

// Retrieve results
$result_json_string = cached_user_func_array('file_get_contents', array($request_url));
$result_array = json_decode($result_json_string);

if (isset($_REQUEST['format'])) {
  $format = $_REQUEST['format'];
}
else {
  $format = 'info-html';
}

// Display the template
switch($format) {
  case 'json':
    require_once('templates/form-result-json.php');
    break;
  case 'info-html':
    require_once('templates/form-result-info-html.php');
    break;
  case 'info-plain':
    require_once('templates/form-result-info-plain.php');
    break;
  default:
    require_once('templates/form-result-info-html.php');
    break;
}
