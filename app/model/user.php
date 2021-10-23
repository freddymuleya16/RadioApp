<?php

class User extends database{


	public function findUser($email){
        $sql="SELECT * FROM user WHERE Email=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        $numRows = $stmt->rowCount();
        
        
          if($numRows>0){
            return true;
          }else{
            return false;
          }
        
    }

    public function findAdmin($email){
        $sql="SELECT * FROM admin WHERE Email=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        $numRows = $stmt->rowCount();
        
        
          if($numRows>0){
            return true;
          }else{
            return false;
          }
        
    }
    public function findReset($email){
        
        $sql="SELECT * FROM resetPassword WHERE email=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        $numRows = $stmt->rowCount();
        
        
          if($numRows>0){
            return true;
          }else{
            return false;
          }
        
    }

    public function registerUser($data){
      $sql="INSERT INTO `user` ( `FirstName`, `LastName`, `Phone`, `Email`, `Password`, `IsActive`) VALUES ( :name, :surname, :phone, :email, :password, :IsActive)";
      $stmt = $this->connect()->prepare($sql);
       $ex = $stmt->execute([
        ':name'=>$data['name'],
        ':surname'=>$data['surname'],
        ':phone'=>$data['phone'],
        ':email'=>$data['email'],
        ':password'=>$data['password'],
        ':IsActive'=>$data['IsActive']
      ]);

      $stmt=null;
      if($ex){
        return true;
      }else{
        return false;
      }
    }

    public function getUser($email,$password){
      $sql = "SELECT * FROM user WHERE Email=?";
      $stmt=$this->connect()->prepare($sql);
      $stmt->execute([$email]);

      $results = $stmt->fetchAll();
      
      $hash=$results[0]['Password'];
      if(password_verify($password, $hash)){
        return $results;
      }else{
        return false;
      }
    } 

    

	public function getAllsong(){
		$sql = "SELECT * FROM song";
    $stmt=$this->connect()->prepare($sql);
    $stmt->execute();

		$results = $stmt->fetchAll();

		$numRows= $stmt->rowCount();
		if ($numRows>0) {
			return $results;
		}else{
			#insert error handler
		}
	}

  public function getsong($id){
    $sql = "SELECT * FROM song WHERE Id=?";
    $stmt=$this->connect()->prepare($sql);
    $stmt->execute([$id]);

    $results = $stmt->fetchAll();

    $numRows= $stmt->rowCount();
    if ($numRows>0) {
      return $results;
    }else{
      #insert error handler
    }
  }


	public function UploadSong($song,$artist,$cover){
      $sql= "INSERT INTO song (name, artist, cover) VALUES (?,?,?)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$song,$artist,$cover]);

      if($stmt){
        return true;
      } else{
        return false;
      }
    }



public function DeleteSong($id){
  $sql = "DELETE FROM song WHERE Id = ?";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$id]);

  if($stmt){
    return true;
  }else{
    return false;
  }
}

public function updateSong($data){
  $sql = "UPDATE song SET Name = ?, Artist = ?, Cover = ? WHERE Id = ?";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$data['song'],$data['artist'],$data['cover'],$data['id']]);

  if($stmt){
    return true;
  }else{
    return false;
  }
}


public function getComments(){
    $sql = "SELECT * FROM comments ORDER BY Id DESC LIMIT 2";
    $stmt=$this->connect()->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll();

    $numRows= $stmt->rowCount();
    if ($numRows>0) {
      return $results;
    }else{
      #insert error handler
    }
  }

  public function inputReset($data){

     $sql= "INSERT INTO resetPassword (email, code) VALUES (?,?)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$data['email'],$data['code']]);

      if($stmt){
        return true;
      } else{
        return false;
      }

  }


public function getEmail($code){
      $sql = "SELECT * FROM resetPassword WHERE code=?";
      $stmt=$this->connect()->prepare($sql);
      $stmt->execute([$code]);

      $results = $stmt->fetchAll();
      
      $email=$results[0]['email'];
     
        return $email;
      
    }

  public function findCode($code){
    $sql="SELECT * FROM resetPassword WHERE code=?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$code]);

    $numRows = $stmt->rowCount();
  
  
    if($numRows>0){
      return true;
    }else{
      return false;
    }

  }

  public function resetPassword($data){
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$data['password'],$data['email']]);

    if($stmt){
      return true;
    }else{
      return false;
    }
  }

  public function removeCode($code){
    $sql = "DELETE FROM resetPassword WHERE code = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$code]);

    if($stmt){
      return true;
    }else{
      return false;
    }
  }

  public function saveMessage($data){
    $sql = "INSERT INTO message(name,email,phone,message) VALUES(?,?,?,?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([
      $data['name'],
      $data['email'],
      $data['phone'],
      $data['message']
    ]);

    if($stmt){
      return true;
    }else{
      return false;
    }
  }

  public function getAdmin($email,$password){

      $sql = "SELECT * FROM admin WHERE Email=?";
      $stmt=$this->connect()->prepare($sql);
      $stmt->execute([$email]);

      $results = $stmt->fetchAll();
      
      $hash=$results[0]['Password'];
      echo $hash;

      if(password_verify($password, $hash)){

        return $results;
      }else{
        return false;
      }
    } 

}