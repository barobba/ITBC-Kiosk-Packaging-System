<a href="<?php print $_SERVER['HTTP_REFERER'] ?>">Back</a>

<h3>Request</h3>
<div><?php print $request_themed ?></div>

<h3>JSON format</h3>
<div style="font-family: courier; border: 1px solid black; background-color: rgb(230,230,230); padding: 1em"><?php print htmlentities($result_json_string) ?></div>

<h3>PHP format</h3>
<div><pre><?php print htmlentities(print_r($result_array, TRUE)) ?></pre></div>
