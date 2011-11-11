<?php
require_once('settings.php');
require_once('../caching/functions.php');
require_once('variables.php');

// Prepare URL
// TODO: This might want to be handled with a callback to abstract the way URLs are created (given an array of arguments)
if (!isset($_REQUEST['path'])) {
  exit('The "path" form option is missing.');
}
$request_array = array();
$request_domain = 'http://liveandtell.com';
$request_array []= $request_domain;
$path = $_REQUEST['path'];
$request_array []= $path;
if (isset($_REQUEST['source'])) {
  $source = $_REQUEST['source'];
  $request_args = $_REQUEST['source-'.$source];
  $request_array []= $request_args;
}
$request_url = implode('/', $request_array);
$request = "<a href='$request_url'>$request_url</a>";

// Results
$result = cached_user_func_array('file_get_contents', array($request_url));
$result_array = json_decode($result);

// For the PHP format, wherever there's a node NID, replace it with the appropriate call (given it's type)
// Naive case:
/*
function node_data_link($nid, $type) {
  // First:
  //   Change API path
  //   Change "source" to "type-value"
  //   Change "source-type-value" to "NID"
  // Then:
  //   Refresh page with new values
}
foreach ($result_array->nodes as $node_head) {
  $node = $node_head->node;
  $node->NID = node_data_link($node->NID, $node->type);
  switch($node->type) {
    case 'Picture book':
      break;
    case 'Picture book entry':
      break;
    case 'LiveAndTell Image':
      break;
    case 'Audio':
      break;
  }
}
*/

?>

<a href="<?php print $_SERVER['HTTP_REFERER'] ?>">Back</a>

<h3>Request</h3>
<div><?php print $request ?></div>

<h3>JSON format</h3>
<div style="font-family: courier; border: 1px solid black; background-color: rgb(230,230,230); padding: 1em"><?php print htmlentities($result) ?></div>

<h3>PHP format</h3>
<div><pre><?php print htmlentities(print_r(json_decode($result), TRUE)) ?></pre></div>
