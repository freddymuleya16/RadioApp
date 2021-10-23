<?php
class Reaction extends Database
{
    public function getReactors($id, $reaction)
    {
        $sql = "SELECT * FROM reactions WHERE songid=? AND reaction=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id, $reaction]);

        $results = $stmt->fetchAll();
        $names = array();
        // print_r($results);
        foreach ($results as $id) {


            $sql = "SELECT * FROM users WHERE id=?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id['users_id']]);
            $users = $stmt->fetchAll();
            foreach ($users as $key) {
                $names[] = $key['f_name'] . " " . $key['l_name'];
            }
        }


        foreach ($names as $name) {
            echo $name . '<br>';
        }
    }

    public function removeDislike($songId)
    {
        $sql = "SELECT * FROM song WHERE Id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$songId]);
        $results = $stmt->fetchAll();

        $dislikes = $results[0]['Dislikes'] - 1;

        $sql = "UPDATE song SET Dislikes = ? WHERE Id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$dislikes, $songId]);

        $sql = "DELETE FROM reactions WHERE SongId = ? AND UserId=?";
        $stmt = $this->connect()->prepare($sql);
        $userId = $_SESSION['id'];
        $stmt->execute([$songId, $userId]);



        echo "<p>" . $dislikes . "</p>";
    }



    public function liked($songId)
    {
        $sql = "SELECT * FROM Reactions WHERE songId=? AND userId=? AND reaction=?";
        $stmt = $this->connect()->prepare($sql);
        $userId = $_SESSION['id'];
        $stmt->execute([$songId, $userId, 1]);

        $numRows = $stmt->rowCount();


        if (!$numRows > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function disliked($songId)
    {

        $sql = "SELECT * FROM reactions WHERE SongId=? AND UserId=? AND Reaction=?";
        $stmt = $this->connect()->prepare($sql);
        $userId = $_SESSION['id'];
        $stmt->execute([$songId, $userId, 0]);

        $numRows = $stmt->rowCount();

        if (!$numRows > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function addLike($songId)
    {
        $sql = "SELECT * FROM song WHERE Id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$songId]);
        $results = $stmt->fetchAll();
        //var_dump($results);
        $likes = $results[0]['Likes'] + 1;

        $sql = "UPDATE song SET Likes = ? WHERE Id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$likes, $songId]);

        $sql = "INSERT INTO reactions (SongId,userId,Reaction) VALUES (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $userId = $_SESSION['id'];
        $stmt->execute([$songId, $userId, 1]);

        return $likes;
    }

    public function addDislike($songId)
    {
        $sql = "SELECT * FROM song WHERE Id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$songId]);
        $results = $stmt->fetchAll();
        //var_dump($results);
        $dislikes = $results[0]['Dislikes'] + 1;

        $sql = "UPDATE song SET Dislikes = ? WHERE Id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$dislikes, $songId]);

        $sql = "INSERT INTO reactions (SongId,UserId,Reaction) VALUES (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $userId = $_SESSION['id'];
        $stmt->execute([$songId, $userId, 0]);

        return $dislikes;
    }

    public function removeLike($songId)
    {
        $sql = "SELECT * FROM song WHERE Id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$songId]);
        $results = $stmt->fetchAll();

        $likes = $results[0]['Likes'] - 1;

        $sql = "UPDATE song SET Likes = ? WHERE Id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$likes, $songId]);

        $sql = "DELETE FROM reactions WHERE SongId = ? AND UserId=?";
        $stmt = $this->connect()->prepare($sql);
        $userId = $_SESSION['id'];
        $stmt->execute([$songId, $userId]);

        return $likes;
    }
}
