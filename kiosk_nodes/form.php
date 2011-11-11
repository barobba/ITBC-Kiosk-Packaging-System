<?php

  // Get list of NIDs
  $nids = implode('+', explode("\n", file_get_contents('input_files/nids')));

  // Get list of paths
  $paths = array(
    array('name' => 'Nodes',                'url' => 'api/kiosk/0.1/node/json'),
    array('name' => 'Picture books',        'url' => 'api/kiosk/0.1/type/picture-book/json'),
    array('name' => 'Picture book entries', 'url' => 'api/kiosk/0.1/type/picture-book/entries/json'),
    array('name' => 'Picture, Tagged',      'url' => 'api/kiosk/0.1/type/picture-tagged/json'),
    array('name' => 'Song',                 'url' => 'api/kiosk/0.1/type/song/json')
  );
  $path_items = array();
  foreach ($paths as $path) {
    $path_name = $path['name'];
    $path_url = $path['url'];
    $path_items []= "<li><input type='radio' name='path' value='$path_url' />$path_name</li>";
  }
  $path_items = implode('', $path_items);

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<form method="GET" action="form_result.php">

  <h3>Cache Kiosk Files</h3>
  
  <div><strong>Path:</strong></div>
  <ul>
    <?php print $path_items ?>
  </ul>
  
  <div><strong>Nodes:</strong></div>
  <ul>
    <li>
      <input id="source-use-list" type="radio" name="source" value="use-list" checked /> Use list
      <input type="hidden" name="source-use-list" value="<?php print $nids ?>" />
      <div><?php print $nids ?></div>
      <br />
    </li>
    <li>
      <div><input id="source-type-value" type="radio" name="source" value="type-value" /> Type value</div>
      <div><input name="source-type-value" onFocus="$('#source-type-value').attr('checked', true)" /></div>
      <br />
    </li>
    <li>
      <div><input id="source-type-list" type="radio" name="source" value="type-list" /> Type list</div>
      <div><textarea name="source-type-list" onFocus="$('#source-type-list').attr('checked', true)"></textarea></div>
      <br />
    </li>
  </ul>
  
  <div><strong>Reset cache</strong></div>
  <ul>
    <li><input type="radio" name="reset-cache" value="0" checked /> No</li>
    <li><input type="radio" name="reset-cache" value="1" /> Yes</li>
  </ul>
  
  <input type="Submit" value="Submit" />
  
</form>
