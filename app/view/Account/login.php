<?php
  include VIEW.'header.php';
?>

<div class="wrapper">
  <h3>Login</h3>
  <div id="error_message"></div>
  <form id="myform" action="<?php  echo URLROOT;?>Account/login/" method='post'>
  <div class="form">
    <div class="input_field">
      <input type="text" value="<?php echo $data['email']; ?>" placeholder="Email" class="input"name="email" id="email">
      <span id="error_message"><?php echo $data['email_err']; ?></span>
    </div>
    <div class="input_field">
      <input type="password" value="<?php echo $data['password']; ?>" placeholder="Password" class="input" name="password" id="password">
      <a class='forgotpassword' href="<?php  echo URLROOT;?>Account/forgotpassword/">Forgot password</a>
      <span id="error_message"><?php echo $data['password_err']; ?></span>
    </div>
      <input class="login" type="submit" name="submit" value="Login">
    </form>
  </div>
</div>
<?php
include VIEW . 'footer.php';
?>