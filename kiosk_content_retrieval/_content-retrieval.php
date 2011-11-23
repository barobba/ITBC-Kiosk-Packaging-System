<?php

require_once('../_functions/common.php');
require_once('../_config/system-settings.php');
require_once('../_config/config.php');
require_once('../_libraries/folder_array/folder_array.php');
require_once('../_libraries/endpoint_functions/functions.php');

// TODO: Allow package information to come from other sources, such as POST data or endpoints. 
require_once('include-packages.php');

require_once('process-cards.php');
require_once('process-songs.php');

$result = '';
if (empty($_REQUEST)) {
  // Nothing requested, so return a list of valid options
  $groups = array_keys($packages);
  $result = '';
  $result .= '<h2>Here are the available "data sources"</h2>';
  $result .= '<p>Group names:</p><ul>';
  $result .= '<li>'.implode('<br />', $groups).'</li>';
  $result .= '</ul><p>Use this format for the query string: ?group=[GROUP_NAME].</p>';
  dump_html($result);
  exit();
}
else {
  if (array_key_exists('group', $_REQUEST)) {
  
    // Get the group name
    $group_name = $_REQUEST['group'];
  
    // Make sure a folder exists for placing the results
    $results_directory = 'results/results_for_'.$group_name; 
    if (!file_exists($results_directory)) {
      mkdir($results_directory);
    }
    
    // Process all the packages in the chosen group
    $group = $packages[$group_name];
    foreach ($group as $package) {
      foreach ($package['handlers'] as $handler) {

        // Make sure the folder exists for placing the results
        // TODO: Abstract checking & making directories into a generic function
        // TODO: Place this call with the respective handler function
        $handler_directory = $results_directory.'/packs_'.$handler; 
        if (!file_exists($handler_directory)) {
          mkdir($handler_directory);
        }
        
        // Run the handler
        $function = 'process_'.$handler;
        $data_source = $package['data_source_url']; 
        verbose("Starting handler: $function");
        $function($data_source, $results_directory);
        
        // Add a directory tree (_files.json)
        $files_json = folder_array($handler_directory);
        $files_json = json_encode($files_json);
        file_put_contents($handler_directory.'/_files.json', $files_json);
        
      }
    }
    
    /*
    // Zip up the package
    // COMMENTED OUT, BECAUSE COMPRESSION CAN OCCUR FOR THE ENTIRE GAME...NOT JUST THE PACKS
    // TODO: MAKE THIS AN OPTION
    if (PHP_OS == 'WINNT') {
      `compact $results_directory`;
    }
    else {
      `tar -cvzf $results_directory.tar.gz $results_directory`;
    }
    */
    
  }
  else {
    // Do nothing...don't work
  }
}
