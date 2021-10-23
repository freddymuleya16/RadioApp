<?php
  include VIEW.'header.php';

?>
   <br><br>
   <div class="wrapper">
   	<h3>Update Song</h3>
  <div id="error_message"></div>
   	<div class="form">
   <form action='<?php  echo URLROOT;?>Song/changeSong/<?php echo $data['Id']; ?>' method='post' enctype='multipart/form-data'>
   	<div class="form">
   		<div class="input_field">
	      <input type="text" placeholder="Title" class="input" name="title" value="<?php echo $data['Name']; ?>" >
	      <span id="error_message"><?php echo $data['title_err']; ?></span>
	    </div>
   		<div class="input_field">
	      <input type="text" placeholder="Artist" class="input" name="artist" value="<?php echo $data['Artist']; ?>" >
	      <span id="error_message"><?php echo  $data['artist_err']; ?></span>
	    </div>
      <div class="input_field">
        <input type="text" placeholder="Cover" class="input" name="Cover" value="<?php echo $data['Cover']; ?>">
        <span id="error_message"><?php echo $data['title_err']; ?></span>
      </div>
   		<input class="btn" type='submit' name='submit' value='Update Song'><a  class="dlt" href="<?php  echo URLROOT;?>Song/deleteSong/<?php echo $data['Id']; ?>"> Delete Song</a>
   	</div>
   </form>
</div>
</div>

<?php
  include VIEW.'footer.php';
?>


