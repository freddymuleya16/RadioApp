<?php
  include VIEW.'header.php';
?>
<div class="wrapper">
  <h3>Contact Us</h3>
  <div id="error_message"></div>
  <form id="myform" action="<?php  echo URLROOT;?>home/contact/" method='post'>
  <div class="form">
    <div class="input_field">
      <input type="<?php echo (!isLoggedIn())?'text':'hidden'?>" value="<?php echo $data['name']; ?>" placeholder="Your name" class="input" name="name" >
      <span id="error_message"><?php echo $data['name_err']; ?></span>
    </div>
    <div class="input_field">
      <input type="<?php echo (!isLoggedIn())?'email':'hidden'?>" value="<?php echo $data['email']; ?>" placeholder="Your Email" class="input" name="email">
      <span id="error_message"><?php echo $data['email_err']; ?></span>
    </div>
    <div class="input_field">
      <input type="<?php echo (!isLoggedIn())?'text':'hidden'?>" value="<?php echo $data['phone']; ?>" placeholder="Your phone" class="input"name="phone">
      <span id="error_message"><?php echo $data['phone_err']; ?></span>
    </div>
     <div class="input_field">
      <textarea type="textarea" cols='50' rows='4' wrap='soft' value="" placeholder="Your message" class="input" name="message"><?php echo $data['message']; ?></textarea>
      <span id="error_message"><?php echo $data['message_err']; ?></span>
    </div>
      <input class="login" type="submit" name="submit" value="Send">
    </form>
  </div>
</div>
<?php
  include VIEW.'footer.php';
?> 