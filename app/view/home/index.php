<?php
include VIEW . 'header.php';
?>
<div id="container">
  <div class='tabs'><button id="tab1">PLAYER</button><BUTTON id='tab2'>PLAYLIST</BUTTON><button id="tab3">Comments</button></div>
  <div id="player_tab1">
    <div id="audio-image" class='cover'>
    </div>
  </div>
  <div id="audio-player">
    <div id="player_tab2">
      <div id="audio-info">
        <div id='numDislikes'></div><img id="unlikeBtn" src="<?php echo URLROOT; ?>public\media\img\unlike.png"><span class="ide" style="display: none;"></span><span class="artist"></span> - <span class="title"></span><img id="likeBtn" src="<?php echo URLROOT; ?>public\media\img\like.png">
        <div id='numLikes'></div>
      </div>
      <input id="volume" type="range" min="0" max="10" value="5" />
      <br>
      <div class="clearfix"></div>
      <div id="tracker">
        <div id="progressBar">
          <span id="progress"></span>
        </div>
        <span id="duration"></span>
      </div>
      <div class="clearfix"></div>
      <div id="buttons">
        <span>
          <button id="prev"></button>
          <button id="play"></button>
          <button id="pause"></button>
          <button id="stop"></button>
          <button id="next"></button>
        </span>
      </div>
    </div>
    <div id="playlist_tab">
      <ul id="playlist" class="hidden">
        <?php
        foreach ($data['songs'][0] as $datas) {
          echo "<li song='" . $datas['Name'] . "'id='" . $datas['Id'] . "'cover='" . $datas['Cover'] . "'artist='" . $datas['Artist'] . "'>" . $datas['Name'] . "</li>";
        }
        ?>
    </div>
    <div id="comments_tab">
      <input type="hidden" id="author" value="<?php echo (isset($_SESSION['name'])) ? $_SESSION['name'] : 'Annonymouse' ?>">
      <input type="text" placeholder="Write a comment" name="comment" id='comment'><input type="submit" id="commentbtn" value="Comment">
      <div id='comments'>
        <h3>Comments</h3>
        <p id="submitComment"></p><br>
        <div id="commentOld">
          <?php
          foreach ($data['comments'][0] as $datas) {
            echo '<p>';
            echo $datas['Author'] . ": " . $datas['Message'];
            echo '</p><br>';
          }
          ?>
        </div>
        <h5 id="load">Load more Comments</h5>
      </div>
    </div>
  </div>
</div>

<?php
include VIEW . 'footer.php';
?>