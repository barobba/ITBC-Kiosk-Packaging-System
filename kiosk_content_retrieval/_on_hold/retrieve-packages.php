<?php

/**
 * INCLUDES
 */
require_once('../config.php');
require_once('settings.php');
require_once('book-functions.php');

/**
 * BEGIN PRINTING
 */
header('Content-type: text/plain');
print "Beginning of script\n";

/**
 * CHECK REQUIREMENTS
 */
if (!isset($_REQUEST['nid'])) {
  exit('Missing "nid" parameter.');
}

/**
 * RETRIEVE BOOK DATA
 */
print "Retrieving book data\n";
$book_nid = $_REQUEST['nid'];
$book_data_url = book_url_prepare($book_nid);
$book = book_retrieve($book_data_url);
book_data_save($book, '_data.json', $book);
print "Book data saved\n";

/**
 * RETRIEVE PICTURES
 */
print "Retrieving pictures\n";
foreach ($book->pictures as $picture) {

  if (empty($picture->pictureURL)) {
    continue;
  }
  
  $filename = explode('/', $picture->pictureURL);
  $filename = array_pop($filename);
  if (!empty($filename)) {
    
    print "Retrieving picture $picture->pictureURL\n";
    $picture_data = file_get_contents($picture->pictureURL);
    print "Retrieval finished\n";

    $file_array = explode('.', $filename);
    $file_ext = array_pop($file_array);
    $filepath = dirpath($book).'/'.$picture->NID.'.'.$file_ext;
    print "Saving picture $filepath\n";
    file_put_contents($filepath, $picture_data);
    print "Saved picture\n";
    
    $outfile = dirpath($book).'/'.$picture->NID.'-COLORING.'.$file_ext;
    $command = "convert $filepath -contrast-stretch 15% -threshold 50% $outfile";
    print "Image processing file with: $command\n";
    print `$command`;
    print "Image processing finished\n";
    
  }
  else {
    print_r('Could not parse this URL: '.$pictureURL);
  }
  
} 
print "Finished retrieving pictures\n";
// Convert pictures

/**
 * Generate index.html file for navigating pages
 */

print "done\n";
