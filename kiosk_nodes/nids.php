<?php

// Prints the list of nodes as a JSON array
header('Content-type: application/json');
print json_encode(explode("\n", file_get_contents('nids')));
