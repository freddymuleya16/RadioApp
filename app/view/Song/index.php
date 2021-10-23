<?php
  include VIEW.'header.php';
 //var_dump($data);
?>
 <a class="addbtn" href="<?php  echo URLROOT;?>Song/addSong">ADD SONG</a>
<table class="table">
     <thead>
       <tr><th>Track No</th>
       <th>Song</th>
       <th>Artist</th>
       <th>Cover</th>
     </tr></thead>
     <tbody>
        <?php $count = 1;foreach ($data as $row):?>
          <tr class = "Change" data-href="<?php  echo URLROOT;?>Song/changeSong/<?php  echo $row['Id'];?>">
            <td data-label="Track No"><?php  echo $count++;?></td>
            <td data-label="Song"><?php  echo $row['Name'];?></td>
            <td data-label="Artist"><?php  echo $row['Artist'];?></td>
            <td data-label="Cover"><?php  echo $row['Cover'];?></td>
        </tr>
        <?php endforeach;?>
     </tbody>
   </table>

<?php
  include VIEW.'footer.php';
?>