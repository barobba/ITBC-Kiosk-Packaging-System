<?php

// Returns a filepath based on the query string (minus a "reset-cache" key)
function cache_filepath() {
  $is_requesting_cached_data = !array_key_exists('reset-cache', $_REQUEST);
  if ($is_requesting_cached_data) {
    $tok = print_r($_REQUEST, TRUE);
    $filepath = 'cache/'.md5($tok);
  }
  else {
    unset($_REQUEST['reset-cache']);
    $tok = print_r($_REQUEST, TRUE);
    $filepath = 'cache/'.md5($tok);
  }
  return $filepath;
}

// Returns the cached results, unless otherwise requested (using "reset-cache" key in the query string).
function cached_user_func_array($func, $func_args) {

  // Check whether cache needs to be created
  $is_requesting_cached_data = !array_key_exists('reset-cache', $_REQUEST);
  if (!$is_requesting_cached_data || !file_exists(cache_filepath())) {
    $results = call_user_func_array($func, $func_args);
    file_put_contents(cache_filepath(), json_encode($results));
  }

  // Return cached results
  $cache_data = file_get_contents(cache_filepath()); 
  return $cache_data;

}
