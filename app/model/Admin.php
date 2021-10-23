<?php

class Admin extends database
{

    public function findAdmin($email)
    {
        $sql = "SELECT * FROM admin WHERE Email=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        $numRows = $stmt->rowCount();


        if ($numRows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAdmin($email, $password)
    {

        $sql = "SELECT * FROM admin WHERE Email=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        $results = $stmt->fetchAll();

        $hash = $results[0]['Password'];
        echo $hash;

        if (password_verify($password, $hash)) {

            return $results;
        } else {
            return false;
        }
    }
}
