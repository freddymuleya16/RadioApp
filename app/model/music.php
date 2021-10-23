<?php

//echo 1;
class Music extends User{

	

	public function showAllsong(){

		$datas = $this->getAllsong();

		foreach ($datas as $data) {

			echo '<li id="'.$data['Id'].'" song="'.$data['Name'].'"cover="'.$data['Cover'].'"artist="'.$data['Artist'].'">'.$data['Name'].'</li>';


		}
	}

	

	public function showMoreComments($commentCount){
		$sql = "SELECT * FROM comments ORDER BY Id DESC LIMIT ?";
		$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$commentCount]);

    	$results = $stmt->fetchAll();

    	$numRows= $stmt->rowCount();
    	if ($numRows>0) {
      		return $results;
    	}else{
      		#insert error handler
    	}

	}

	public function showsong($tata){

		$datas = $this->getAllsong();
		foreach ($datas as $data) {

			

			 echo "<form action='".URLROOT."users/update/' method='post'><tr>
     	  	  <td data-label='Track No'><input disabled='disabled' type='text' name='id' value=".$data['Id']."></td>
     	  	  <td data-label='Song'><input type='text' name='song' value=".'"'.$data['Name'].'"'."><span id='error_message'>".$tata['song_err']."</span></td>
     	  	  <td data-label='Artist'><input type='text' name='artist' value='".$data['Artist']."'><span id='error_message'>".$tata['artist_err']."</span></td>
     	  	  <td data-label='Cover'><input type='text' name='cover' value=".'"'.$data['Cover'].'"'."><span id='error_message'>".$tata['cover_err']."</span></td>
     	  	  <td data-label='Action'><input type='submit' name='delete' value='Delete'></td>
     	  	  <td data-label='Action'><input type='submit' name='change' value='Change'></td>
     	  </tr></form>";

     	  


		}
	}


	// public function uploadsong(){

	// 	$datas = $this->getAllsong();
	// 	foreach ($datas as $data) {

			

	// 		 echo "<form action='".URLROOT."users/update/' method='post'><tr>
 //     	  	  <td data-label='Track No'><input type='text' name='id' value=".$data['Id']."></td>
 //     	  	  <td data-label='Song'><input type='text' name='song' value=".$data['Name']."></td>
 //     	  	  <td data-label='Artist'><input type='text' name='artist' value=".$data['Artist']."></td>
 //     	  	  <td data-label='Cover'><input type='text' name='cover' value=".$data['Cover']."></td>
 //     	  	  <td data-label='Action'><input type='submit' name='delete' value='Delete'></td>
 //     	  	  <td data-label='Action'><input type='submit' name='change' value='Change'></td>
 //     	  </tr></form>";

     	  


	// 	}
	// }

	public function addComment($info){
		$sql ="INSERT INTO `comments` (`author`, `message`) VALUES (?,?)";
		$stmt = $this->connect()->prepare($sql);
		$ex=$stmt->execute([$info['author'],$info['comment']]);
		if ($ex) {
			return true;
		} else {
			return false;
		}
		
	}


	public function liked($songId){
		$sql="SELECT * FROM Reactions WHERE songId=? AND userId=? AND reaction=?";
        $stmt = $this->connect()->prepare($sql);
        $userId=$_SESSION['id'];
        $stmt->execute([$songId,$userId,1]);

        $numRows = $stmt->rowCount();
        
        
        if(!$numRows>0){

            return true;
        }else{
          
            return false;
        }
	}

	public function disliked($songId){

		$sql="SELECT * FROM reactions WHERE SongId=? AND UserId=? AND Reaction=?";
        $stmt = $this->connect()->prepare($sql);
        $userId=$_SESSION['id'];
        $stmt->execute([$songId,$userId,0]);

        $numRows = $stmt->rowCount();

        if(!$numRows>0){

            return true;
        }else{

            return false;
        }
	}

	public function addLike($songId){
		$sql = "SELECT * FROM song WHERE Id=?";
    	$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$songId]);
		$results = $stmt->fetchAll();
		//var_dump($results);
		$likes=$results[0]['Likes']+1;

		$sql ="UPDATE song SET Likes = ? WHERE Id = ?";
		$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$likes,$songId]);

    	$sql = "INSERT INTO reactions (SongId,userId,Reaction) VALUES (?,?,?)";
    	$stmt=$this->connect()->prepare($sql);
    	$userId=$_SESSION['id'];
    	$stmt->execute([$songId,$userId,1]);

    	return $likes;

	}

	public function addDislike($songId){
		$sql = "SELECT * FROM song WHERE Id=?";
    	$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$songId]);
		$results = $stmt->fetchAll();
		//var_dump($results);
		$dislikes=$results[0]['Dislikes']+1;

		$sql ="UPDATE song SET Dislikes = ? WHERE Id = ?";
		$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$dislikes,$songId]);

    	$sql = "INSERT INTO reactions (SongId,UserId,Reaction) VALUES (?,?,?)";
    	$stmt=$this->connect()->prepare($sql);
    	$userId=$_SESSION['id'];
    	$stmt->execute([$songId,$userId,0]);

      return $dislikes;
    	

	}

	public function removeLike($songId){
		$sql = "SELECT * FROM song WHERE Id=?";
    	$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$songId]);
		$results = $stmt->fetchAll();
		
		$likes=$results[0]['Likes']-1;

		$sql ="UPDATE song SET Likes = ? WHERE Id = ?";
		$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$likes,$songId]);

    	$sql = "DELETE FROM reactions WHERE SongId = ? AND UserId=?";
    	$stmt=$this->connect()->prepare($sql);
    	$userId=$_SESSION['id'];
    	$stmt->execute([$songId,$userId]);

    	return $likes;
	}

	public function removeDislike($songId){
		$sql = "SELECT * FROM song WHERE Id=?";
    	$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$songId]);
		$results = $stmt->fetchAll();
		
		$dislikes=$results[0]['Dislikes']-1;

		$sql ="UPDATE song SET Dislikes = ? WHERE Id = ?";
		$stmt=$this->connect()->prepare($sql);
    	$stmt->execute([$dislikes,$songId]);

    	$sql = "DELETE FROM reactions WHERE SongId = ? AND UserId=?";
    	$stmt=$this->connect()->prepare($sql);
    	$userId=$_SESSION['id'];
    	$stmt->execute([$songId,$userId]);

      

    	echo "<p>".$dislikes."</p>";
	}

	public function getReaction($id){
		$sql = "SELECT * FROM song WHERE Id=?";
      	$stmt=$this->connect()->prepare($sql);
      	$stmt->execute([$id]);

      	$results = $stmt->fetchAll();

      	return $results[0];
	}

	public function getReactors($id,$reaction){
		$sql = "SELECT * FROM reactions WHERE songid=? AND reaction=?";
      	$stmt=$this->connect()->prepare($sql);
      	$stmt->execute([$id,$reaction]);

      	$results = $stmt->fetchAll();
      	$names = array();
      	// print_r($results);
      	foreach ($results as $id) {
      		
      		
      		$sql="SELECT * FROM users WHERE id=?";
         	$stmt = $this->connect()->prepare($sql);
         	$stmt->execute([$id['users_id']]);
         	$users=$stmt->fetchAll();
         	foreach ($users as $key ) {
         		$names[]= $key['f_name']." ".$key['l_name'];
         	}
      	}
      	
      	
      	foreach ($names as $name) {
      		echo $name.'<br>';
      	}
	}


}