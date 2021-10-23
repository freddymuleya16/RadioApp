<?php
	$action = $this->getAction();
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo SITENAME; ?></title>
  <script type="text/javascript">var URLROOT = "<?php  echo URLROOT;?>";</script>
	<link rel="stylesheet" href="<?php  echo URLROOT;?>public/css/styles.css">
  <script type="text/javascript" src='<?php  echo URLROOT;?>public/js/jquery.js'></script>  
  <script type="text/javascript" src="<?php  echo URLROOT;?>public/js/validate.js"></script>
  <script type="text/javascript" src="<?php  echo URLROOT;?>public/js/radio.js"></script>
  <script type="text/javascript" src="<?php  echo URLROOT;?>public/js/jqueryDB.js"></script>
  <script type="text/javascript" src="<?php  echo URLROOT;?>public/js/manipulate.js"></script>
  <script type="text/javascript" src="<?php  echo URLROOT;?>public/js/changeSong.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script>
    $(function(){
      $(".hamburger").click(function(){
        $(".nav-bar-right").toggleClass("active");
      });
      $("#hide_popup").click(function(){
        $(".popup").toggleClass("active");
      });
    });
  </script>
</head>
<body>

  <div class="header">
  <div class="nav-bar">
    
    <div class="nav-bar-left">
      <a href="<?php  echo URLROOT;?>home/index"><?php echo SITENAME; ?></a>
    </div>
    <div class="hamburger"><i class="fas fa-bars"></i></div>
    <div class="nav-bar-right">
      <ul>
        <li><a href="<?php  echo URLROOT;?>home/index" <?php echo ($action == 'index' ? 'class="active"' : '');?> >home</a></li>
        <li><a href="<?php  echo URLROOT;?>home/aboutUs" <?php echo ($action == 'aboutUS' ? 'class="active"' : '');?>>about</a></li>
        <li <?php echo (isLoggedIn())?"style='display:none;'":""; ?>><a href="<?php  echo URLROOT;?>users/login" <?php echo ($action == 'login' ? 'class="active"' : '');?>>login</a></li>
        <li <?php echo (!isLoggedIn())?"style='display:none;'":""; ?>><a href="<?php  echo URLROOT;?>users/logout" <?php echo ($action == 'logout' ? 'class="active"' : '');?>>logout</a></li>
        <li <?php echo (!isAdmin())?"style='display:none;'":""; ?>><a href="<?php  echo URLROOT;?>users/admin" <?php echo ($action == 'admin' ? 'class="active"' : '');?>>Admin</a></li>
        <li <?php echo (isLoggedIn())?"style='display:none;'":""; ?>><a href="<?php  echo URLROOT;?>users/register" <?php echo ($action == 'register' ? 'class="active"' : '');?>>Register</a></li>
        <li><a href="<?php  echo URLROOT;?>home/contact" <?php echo ($action == 'contact' ? 'class="active"' : '');?>>contact</a></li>
      </ul>
    </div>
  </div>
  
</div>

