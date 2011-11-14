<?php

require_once('settings.php');

// Given NID
if (!isset($_REQUEST['nid'])) {
  exit('Missing "nid" parameter.');
}
$book_nid = $_REQUEST['nid'];

// Retrieve book data
$endpoint_url  = '';
$endpoint_url .= 'http://api.itbcbuffalo.com/kiosk_nodes/form-results.php?endpoint_idx=2&source=type-list&reset-cache=0&format=json&source-type-list=';
$endpoint_url .= $book_nid;
$book_data = file_get_contents($endpoint_url);
$book = json_decode($book_data);
$book = $book->books[0];

$dirpath = 'coloring_books/'.$book->NID;
if (!file_exists($dirpath)) {
  mkdir($dirpath);
}
file_put_contents('coloring_books/'.$book->NID.'/_data.json', $book_data);

// Retrieve pictures
foreach ($book->pictures as $picture) {

  if (empty($picture->pictureURL)) {
    continue;
  }
  
  header('Content-type: text/plain');
  
  $filename = explode('/', $picture->pictureURL);
  $filename = array_pop($filename);
  if (!empty($filename)) {
    $file_ext = array_pop(explode('.', $filename));
    $filepath = $dirpath.'/'.$picture->NID.'.'.$file_ext;
    $picture_data = file_get_contents($picture->pictureURL);
    file_put_contents($filepath, $picture_data);
    
    $outfile = $dirpath.'/'.$picture->NID.'-COLORING.'.$file_ext;
    `convert $filepath -define convolve:scale='50%!' -bias 50% \
           \( -clone 0 -morphology Convolve Sobel:0 \) \
           \( -clone 0 -morphology Convolve Sobel:90 \) \
           -delete 0 -solarize 50% -level 50,0% \
           +level 0,70% -gamma 0.5 -compose plus -composite  -gamma 2 \
           -auto-level $outfile`;
    
  }
  else {
    print_r('Could not parse this URL: '.$pictureURL);
  }
  
} 

// Convert pictures


// Provide index.html file for navigating pages


