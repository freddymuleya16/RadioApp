<?php

class Message extends Database
{
    public function saveMessage($data)
    {
        $sql = "INSERT INTO message(name,email,phone,message) VALUES(?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['message']
        ]);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
