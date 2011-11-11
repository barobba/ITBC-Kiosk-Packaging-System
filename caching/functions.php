<?php

function is_requesting_cached_data() {
  if (array_key_exists('reset-cache', $_REQUEST) && $_REQUEST['reset-cache'] == 1) {
    return FALSE;
  }
  else {
    return TRUE;
  }
}

// Provide a default token to use as a seed for generating the filename
function default_token_callback() {
  if (is_requesting_cached_data()) {
    $tok = print_r($_REQUEST, TRUE);
  }
  else {
    $req = $_REQUEST;
    unset($req['reset-cache']);
    $tok = print_r($req, TRUE);
  }
  return $tok;
}

// Returns a filepath based on the query string (minus a "reset-cache" key)
function cache_filepath($token_callback = 'default_token_callback') {
  $hash_value = md5($token_callback());
  return "cache/$hash_value.cache";
}

// Returns the cached results, unless otherwise requested (using "reset-cache" key in the query string).
function cached_user_func_array($func, $func_args, $token_callback = 'default_token_callback') {

  // Check whether cache needs to be created
  $cache_file = cache_filepath($token_callback);
  if (!is_requesting_cached_data() || !file_exists($cache_file)) {
    $results = call_user_func_array($func, $func_args);
    file_put_contents($cache_file, $results);
  }

  // Return cached results
  $cache_data = file_get_contents($cache_file); 
  return $cache_data;

}
