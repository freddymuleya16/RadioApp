<?php

class User extends database
{
  public function findUser($email)
  {
    $sql = "SELECT * FROM user WHERE Email=?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$email]);

    $numRows = $stmt->rowCount();

    if ($numRows > 0) {
      return true;
    } else {
      return false;
    }
  }
  public function registerUser($data)
  {
    $sql = "INSERT INTO `user` ( `FirstName`, `LastName`, `Phone`, `Email`, `Password`, `IsActive`) VALUES ( :name, :surname, :phone, :email, :password, :IsActive)";
    $stmt = $this->connect()->prepare($sql);
    $ex = $stmt->execute([
      ':name' => $data['name'],
      ':surname' => $data['surname'],
      ':phone' => $data['phone'],
      ':email' => $data['email'],
      ':password' => $data['password'],
      ':IsActive' => $data['IsActive']
    ]);

    $stmt = null;
    if ($ex) {
      return true;
    } else {
      return false;
    }
  }
  public function getUser($email, $password)
  {
    $sql = "SELECT * FROM user WHERE Email=?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$email]);

    $results = $stmt->fetchAll();

    $hash = $results[0]['Password'];
    if (password_verify($password, $hash)) {
      return $results;
    } else {
      return false;
    }
  }
  public function resetPassword($data)
  {
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$data['password'], $data['email']]);

    if ($stmt) {
      return true;
    } else {
      return false;
    }
  }
}
