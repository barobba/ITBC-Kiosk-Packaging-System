<?php

require_once('../caching/functions.php');

// URL
$domain = 'http://liveandtell.com';
$path = $_REQUEST['path'];
$source = $_REQUEST['source'];
$nids = $_REQUEST['source-'.$source];
$request_url = "$domain/$path/$nids";
$request = "<a href='$request_url'>$request_url</a>";

// Results
$result = cached_user_func_array('file_get_contents', array($request_url));

?>

<h3>Request</h3>
<div><?php print $request ?></div>

<h3>JSON format</h3>
<div style="font-family: courier; border: 1px solid black; background-color: rgb(230,230,230); padding: 1em"><?php print htmlentities($result) ?></div>

<h3>PHP format</h3>
<div><pre><?php print htmlentities(print_r(json_decode($result), TRUE)) ?></pre></div>
