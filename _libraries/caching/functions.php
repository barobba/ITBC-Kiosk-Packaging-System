<?php

// Returns a filepath based on the query string (minus a "reset-cache" key)
function generate_cache_name($cache_name) {
  return md5($cache_name);
}

// Returns the cached results, unless otherwise requested (using "reset-cache" key in the query string).
function cached_user_func_array($cache_name, $func, $func_args, $reset_cache = FALSE) {
  
  // Check whether cache needs to be created
  $cache_filename = generate_cache_name($cache_name);
  $cache_filepath = "cache/$cache_filename.cache";
  if ($reset_cache || !file_exists($cache_filepath)) {
    $results = call_user_func_array($func, $func_args);
    file_put_contents($cache_filepath, $results);
  }

  // Return cached results
  $cache_data = file_get_contents($cache_filepath);
  return $cache_data;

}
