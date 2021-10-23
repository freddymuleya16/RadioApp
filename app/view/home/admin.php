<?php
  include VIEW.'header.php';
 //var_dump($data);
?>



 <a class="addbtn" href="<?php  echo URLROOT;?>users/addSong">ADD SONG</a>


<table class="table">
     <thead>
       <tr><th>Track No</th>
       <th>Song</th>
       <th>Artist</th>
       <th>Cover</th>
       
     </tr></thead>
     <tbody>


        <tr class = "Change" data-href="<?php  echo URLROOT;?>users/changeSong/1">
            <td data-label="Track No">1</td>
            <td data-label="Song">I Miss The Days.mp3</td>
            <td data-label="Artist">NF</td>
            <td data-label="Cover">cover1.jpg></td>
            
        </tr>

        <?php $count = 1;foreach ($data as $row):?>

          <tr class = "Change" data-href="<?php  echo URLROOT;?>users/changeSong/<?php  echo $row['Id'];?>">
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


