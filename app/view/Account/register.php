<?php
include VIEW . 'header.php';
?>
<script type="text/javascript">
  function validatee() {
    document.getElementById("myform").submit();
  }
</script>
<div class="wrapper">
  <h3>Registration</h3>
  <form id="myform" action="<?php echo URLROOT; ?>Account/register/" method='post'>
    <div class="form">
      <div class="input_field">
        <input type="text" value="<?php echo $data['name']; ?>" placeholder="Name" class="input" name="name" id="name">
        <span class='err' id="error_message"><?php echo $data['name_err']; ?></span>
      </div>
      <div class="form">
        <div class="input_field">
          <input type="text" value="<?php echo $data['surname']; ?>" placeholder="Last Name" class="input" name="l_name" id="l_name">
          <span id="error_message"><?php echo $data['surname_err']; ?></span>
        </div>
        <div class="form">
          <div class="input_field">
            <input type="text" value="<?php echo $data['phone']; ?>" placeholder="Phone Number" class="input" name="phone" id="phone">
            <span id="error_message"><?php echo $data['phone_err']; ?></span>
          </div>
          <div class="input_field">
            <input type="text" value="<?php echo $data['email']; ?>" placeholder="Email" class="input" name="email" id="email">
            <span id="error_message"><?php echo $data['email_err']; ?></span>
          </div>
          <div class="input_field">
            <input type="password" value="<?php echo $data['password']; ?>" placeholder="Password" class="input" name="password" id="password">
            <span id="error_message"><?php echo $data['password_err']; ?></span>
          </div>
          <div class="input_field">
            <input type="password" value="<?php echo $data['password2']; ?>" placeholder="Confirm Password" class="input" name="c_password" id="c_password">
            <span id="error_message"><?php echo $data['password2_err']; ?></span>
          </div>
          <input type="submit" class="login">Redister</input>
  </form>
</div>
</div>
<?php
include VIEW . 'footer.php';
?>