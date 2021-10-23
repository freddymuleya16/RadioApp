<?php
include VIEW . 'header.php';
?>
<div class="wrapper">
  <h3>Forgot Password</h3>
  <div id="message"><?php echo $data['message']; ?></div>
  <form id="myform" action="<?php echo URLROOT; ?>Account/forgotpassword/" method='post'>
    <div class="form">
      <div class="input_field">
        <input type="text" value="<?php echo $data['email']; ?>" placeholder="Email" class="input" name="email" id="email">
        <span id="error_message"><?php echo $data['email_err']; ?></span>
      </div>
      <input class="login" type="submit" name="submit" value="Send">
  </form>
</div>
<?php
include VIEW . 'footer.php';
?>