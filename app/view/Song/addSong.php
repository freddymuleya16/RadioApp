<?php
include VIEW . 'header.php';
?>
<br><br>
<div class="wrapper">
	<h3>Upload Song</h3>
	<div id="error_message"></div>
	<div class="form">
		<form action='<?php echo URLROOT; ?>Song/addSong/' method='post' enctype='multipart/form-data'>
			<div class="form">

				<div class="input_field">
					<div class="input">
						<label>Song:</label>
						<input type="file" name="song">
					</div>
					<span id="error_message"><?php echo $data['song_err']; ?></span>
				</div>

				<div class="input_field">
					<input type="text" placeholder="Title" class="input" name="title">
					<span id="error_message"><?php echo $data['title_err']; ?></span>
				</div>

				<div class="input_field">
					<input type="text" placeholder="Artist" class="input" name="artist">
					<span id="error_message"><?php echo  $data['artist_err']; ?></span>
				</div>

				<div class="input_field">
					<div class="input">
						<label>Cover:</label>
						<input type="file" name="cover">
					</div>
					<span id="error_message"><?php echo $data['cover_err']; ?></span>
				</div>

				<input class="btn" type='submit' name='submit' value='Upload Song'>

			</div>
		</form>
	</div>
</div>

<?php
include VIEW . 'footer.php';
?>