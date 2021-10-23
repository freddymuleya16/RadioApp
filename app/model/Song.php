<?php
class Song extends Database
{
    public function getAllsong()
    {
        $sql = "SELECT * FROM song";
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

    public function getsong($id)
    {
        $sql = "SELECT * FROM song WHERE Id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);

        $results = $stmt->fetchAll();

        $numRows = $stmt->rowCount();
        if ($numRows > 0) {
            return $results;
        } else {
            #insert error handler
        }
    }
    public function UploadSong($song, $artist, $cover)
    {
        $sql = "INSERT INTO song (name, artist, cover) VALUES (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$song, $artist, $cover]);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
    public function DeleteSong($id)
    {
        $sql = "DELETE FROM song WHERE Id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSong($data)
    {
        $sql = "UPDATE song SET Name = ?, Artist = ?, Cover = ? WHERE Id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$data['song'], $data['artist'], $data['cover'], $data['id']]);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function getReaction($id)
    {
        $sql = "SELECT * FROM song WHERE Id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);

        $results = $stmt->fetchAll();

        return $results[0];
    }
}
