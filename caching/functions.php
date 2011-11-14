<?php

function is_requesting_cached_data() {
  if (!isset($_REQUEST['reset-cache']) || $_REQUEST['reset-cache'] != 1) {
    return TRUE;
  }
  else {
    return FALSE;
  }
}

// Provide a default token to use as a seed for generating the filename
function default_token_callback() {
  if (isset($_REQUEST['reset-cache'])) {
    $req = $_REQUEST;
    unset($req['reset-cache']);
    $tok = print_r($req, TRUE);
  }
  else {
    $tok = print_r($_REQUEST, TRUE);
  }
  return $tok;
}

// Returns a filepath based on the query string (minus a "reset-cache" key)
function generate_cache_name($token_callback = 'default_token_callback') {
  return md5($token_callback());
}



// Returns the cached results, unless otherwise requested (using "reset-cache" key in the query string).
function cached_user_func_array($func, $func_args, $token_callback = 'default_token_callback') {

  // Check whether cache needs to be created
  $cache_name = generate_cache_name($token_callback);
  $cache_filepath = "cache/$cache_name.cache";
  if (!is_requesting_cached_data() || !file_exists($cache_filepath)) {
    $results = call_user_func_array($func, $func_args);
    file_put_contents($cache_filepath, $results);
  }

  // Return cached results
  $cache_data = file_get_contents($cache_filepath); 
  return $cache_data;

}




/*
// Returns the cached results, unless otherwise requested (using "reset-cache" key in the query string).
function cached_user_func_array($func, $func_args, $token_callback = 'default_token_callback') {

  // Check whether cache needs to be created
  $cache_name = generate_cache_name($token_callback);
  $cache_filepath = "cache/$cache_name/cache.json";
  if (!is_requesting_cached_data() || !file_exists($cache_filepath)) {
    $results = call_user_func_array($func, $func_args);
    if (!file_exists("cache/$cache_name")) {
      mkdir("cache/$cache_name");
    }
    file_put_contents($cache_filepath, $results);
  }

  // Return cached results
  $cache_data = file_get_contents($cache_filepath); 
  return $cache_data;

}
*/
