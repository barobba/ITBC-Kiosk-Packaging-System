<?php

  // Verify form title
  if (!isset($form['title'])) {
    $form['title'] = 'Caching system';
  }

  // Prepare API path options
  $path_items = array();
  foreach ($form['elements']['handlers'] as $path) {
    $path_name = $path['name'];
    $path_url = $path['url'];
    $path_items []= "<li><input type='radio' name='path' value='$path_url' />$path_name</li>";
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
  
  <div><strong>Reset cache</strong></div>
  <ul>
    <li><input type="radio" name="reset-cache" value="0" checked /> No</li>
    <li><input type="radio" name="reset-cache" value="1" /> Yes</li>
  </ul>
  
  <input type="Submit" value="Submit" />
  
</form>
