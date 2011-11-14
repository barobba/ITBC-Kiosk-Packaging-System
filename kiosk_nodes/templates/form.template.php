<?php

  // Verify form title
  if (!isset($form['title'])) {
    $form['title'] = 'Caching system';
  }

  // Prepare API path options
  $path_items = array();
  foreach ($form['elements']['endpoints'] as $index => $endpoint) {
    $path_name = $endpoint['name'];
    $path_items []= "<li><input type='radio' name='endpoint_idx' value='$index' />$path_name</li>";
  }
  $path_items = implode('', $path_items);

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<form method="GET" action="<?php print $form['action'] ?>">

  <h3><?php print $form['title'] ?></h3>
  
  <div><strong>Requests:</strong></div>
  <ul>
    <?php print $path_items ?>
  </ul>
  
  <div><strong>Values:</strong></div>
  <ul>
    <?php if(isset($form['elements']['default_value_string'])): ?>
    <li>
      <input id="source-use-list" type="radio" name="source" value="use-list" checked /> Prepared values
      <input type="hidden" name="source-use-list" value="<?php print $form['elements']['default_value_string'] ?>" />
      <div><?php print $form['elements']['default_value_string'] ?></div>
      <br />
    </li>
    <?php endif; ?>
    
    <li>
      <div><input id="source-type-list" type="radio" name="source" value="type-list" /> Custom values</div>
      <div><textarea name="source-type-list" onFocus="$('#source-type-list').attr('checked', true)"></textarea></div>
      <br />
    </li>
  </ul>
  
  <div><strong>Use cached content</strong></div>
  <ul>
    <li><input type="radio" name="reset-cache" value="0" checked /> Yes</li>
    <li><input type="radio" name="reset-cache" value="1" /> No</li>
  </ul>

  <div><strong>Representation</strong></div>
  <ul>
    <li><input type="radio" name="format" value="info-html" checked /> Information page (HTML)</li>
    <li><input type="radio" name="format" value="info-plain" /> Information page (plain text)</li>
    <li><input type="radio" name="format" value="json" /> JSON</li>
  </ul>
  
  <input type="Submit" value="Submit" />
  
</form>
