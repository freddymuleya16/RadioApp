<?php
session_start();
	include 'dbh.php';

	if (isset($_POST['commentNewCount'])) {
		
		
		$commentNewCount = $_POST['commentNewCount'];

		$sql = "SELECT * FROM comments ORDER BY id DESC LIMIT  $commentNewCount ";
		$results = mysqli_query($conn,$sql);
		if(mysqli_num_rows($results)){
			while($row = mysqli_fetch_assoc($results)){
				echo "<p>";
				echo $row['author'].": ".$row['message'];
				echo "</p><br>";
			}
		}else{
			echo "there are no comments";
		}

	}

	
	if (isset($_POST['commentP'])) {
		$comment=$_POST['commentP'];
		$author=$_POST['authorP'];

		echo $author.": ".$comment;

		$sql ="INSERT INTO `comments` (`id`, `author`, `message`, `song`) VALUES (NULL, '$author', '$comment', '1')";
		mysqli_query($conn,$sql);


	}


	if (isset($_POST['songId'])) {
		$id = $_POST['songId'];

		//echo "<p>".$id."</p>";
		if(isset($_SESSION['id'])){
			$userId=$_SESSION['id'];
			$sql1="SELECT * FROM `likersanddislikers` WHERE listenerId=$userId  AND songId=$id";
			$results1 = mysqli_query($conn,$sql1);
			if(mysqli_num_rows($results1)){
				echo "<script>loadLikes(".$id.");alert('You have already liked this');</script>";
			}else{
				$sql = "SELECT * FROM music where id=$id";
    			$results = mysqli_query($conn,$sql);
    			$row = mysqli_fetch_assoc($results);

    			$likes=$row['likes']+1;

    			$sql2 ="UPDATE music SET likes = $likes WHERE id = $id";
				mysqli_query($conn,$sql2);
				mysqli_query($conn,"INSERT INTO likersAndDislikers (songId,listernerID,likeOrDislike) VALUES ($id,$userId,'LIKE')");
				echo "<p>".$likes."</p>";
			}
		}else{
    		echo "<script>loadLikes(".$id.");alert('Login To Like');</script>";
    		var_dump($_SESSION['id']);
    	}
	}

	if (isset($_POST['dislikeId'])) {
		$id = $_POST['dislikeId'];

		

		$sql = "SELECT * FROM music where id=$id";
    	$results = mysqli_query($conn,$sql);
    	$row = mysqli_fetch_assoc($results);

    	$dislikes=$row['dislikes']+1;

    	$sql2 ="UPDATE music SET dislikes = $dislikes WHERE id = $id";
		mysqli_query($conn,$sql2);
		echo "<p>".$dislikes."</p>";
	}

	if (isset($_POST['loadLike'])) {
		$id = $_POST['loadLike'];
		
			$sql = "SELECT * FROM music where id=$id";
    		$results = mysqli_query($conn,$sql);
    		$row = mysqli_fetch_assoc($results);
    		echo "<p>".$row['likes']."</p>";
    	

    }


    if (isset($_POST['loadDislike'])) {
		$id = $_POST['loadDislike'];

		

		$sql = "SELECT * FROM music where id=$id";
    	$results = mysqli_query($conn,$sql);
    	$row = mysqli_fetch_assoc($results);

    	echo "<p>".$row['dislikes']."</p>";

    }

	?>