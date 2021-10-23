<?php

class ResetPassword extends Database
{
    public function removeCode($code)
    {
        $sql = "DELETE FROM resetPassword WHERE code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$code]);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
    public function findCode($code)
    {
        $sql = "SELECT * FROM resetPassword WHERE code=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$code]);

        $numRows = $stmt->rowCount();
        if ($numRows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getEmail($code)
    {
        $sql = "SELECT * FROM resetPassword WHERE code=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$code]);

        $results = $stmt->fetchAll();

        $email = $results[0]['email'];

        return $email;
    }
    public function inputReset($data)
    {
        $sql = "INSERT INTO resetPassword (email, code) VALUES (?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$data['email'], $data['code']]);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function findReset($email)
    {

        $sql = "SELECT * FROM resetPassword WHERE email=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        $numRows = $stmt->rowCount();
        if ($numRows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
