<?php
  include VIEW.'header.php';
?>

<div class='wrapper popup'>
    <h1><?php echo $data['name']; ?></h1>
    <p><?php echo $data['message']; ?></p>
     <div class='btn' id='hide_popup active' ><a href='javascript:history.back()'>CANCEL</a></div>
     <div class='btn' id='hide_popup active' ><a href='<?php echo $data['class']; ?>'>CONFIRM</a></div>
  </div>

<?php
  include VIEW.'footer.php';
?>