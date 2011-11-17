<?php

header('Content-type: text/plain');
$result_php_formatted_string = print_r($result_array, TRUE);

$output = <<<EOS
Request URL
$request_url

JSON format
$result_json_string

PHP format
$result_php_formatted_string
EOS;

//$output =wordwrap($output, 75, "\n", TRUE);
print $output;