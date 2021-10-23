<?php

class Comments extends Database
{
    public function getComments()
    {
        $sql = "SELECT * FROM comments ORDER BY Id DESC LIMIT 2";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();

        $numRows = $stmt->rowCount();
        if ($numRows > 0) {
            return $results;
        } else {
            #insert error handler
        }
    }
    public function addComment($info)
    {
        $sql = "INSERT INTO `comments` (`author`, `message`) VALUES (?,?)";
        $stmt = $this->connect()->prepare($sql);
        $ex = $stmt->execute([$info['author'], $info['comment']]);
        if ($ex) {
            return true;
        } else {
            return false;
        }
    }

    public function showMoreComments($commentCount)
    {
        $sql = "SELECT * FROM comments ORDER BY Id DESC LIMIT ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$commentCount]);

        $results = $stmt->fetchAll();

        $numRows = $stmt->rowCount();
        if ($numRows > 0) {
            return $results;
        } else {
            #insert error handler
        }
    }
}
