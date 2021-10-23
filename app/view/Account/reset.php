<?php
include VIEW . 'header.php';
?>

<div class="wrapper">
  <h3>Reset</h3>
  <div id="error_message"></div>
  <form id="myform" action="<?php echo URLROOT; ?>Account/reset/<?php echo $data['code']; ?>" method='post'>
    <div class="form">
      <div class="input_field">
        <input type="password" value="<?php echo $data['password']; ?>" placeholder="Password" class="input" name="password" id="password">
        <span id="error_message"><?php echo $data['password_err']; ?></span>
      </div>
      <div class="input_field">
        <input type="password" value="<?php echo $data['password2']; ?>" placeholder="Confirm Password" class="input" name="password2" id="c_password">
        <span id="error_message"><?php echo $data['password2_err']; ?></span>
      </div>
      <input class="login" type="submit" name="submit" value="Reset">
  </form>
</div>
</div>
<?php
include VIEW . 'footer.php';
?>