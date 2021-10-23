<?php

class SongController extends Controller{
    public function changeSong($id)
    {
        if (!isAdmin()) {
            redirect('home\index');
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $data = [
                    "song" => trim($_POST["title"]),
                    "cover" => trim($_POST["Cover"]),
                    "artist" => trim($_POST["artist"]),
                    "action" => "",
                    "song_err" => "",
                    "title_err" => "",
                    "artist_err" => "",
                    "cover_err" => ""
                ];
                $data['id'] = $id;
                
                $musicFile = new Song();

                $ex = $musicFile->updateSong($data);
                if ($ex) {
                    $this->view('Song\index', $data);
                    //$this->model('Music', $data);
                   // 
                } else {
                    echo "something went wrong";
                }
            } else {
                $data = [
                    "song_err" => "",
                    "title_err" => "",
                    "artist_err" => "",
                    "cover_err" => ""
                ];
                //$this->model('user', $data);
                $musicFile = new Song();
                $data = array_merge($musicFile->getSong($id)[0], $data);
                $this->view('Song\changeSong', $data);
                //
            }
        }
    }

    public function deleteSong($id, $confirm = false)
    {
        if ($confirm) {
            if (!isAdmin()) {
                redirect('home\index');
            } else {

                //$this->model('user', []);
                $musicFile = new Song();
                $data = $musicFile->getSong($id)[0];

                $isDeleted = $musicFile->DeleteSong($data['Id']);
                if ($isDeleted || true) {
                    $ex = $this->deletefile($data['Name']);
                    if ($ex || true) {

                        $this->flash("Deleted", $data['Name'] . " has been Successfully deleted", URLROOT . 'Song\index');
                    } else {
                        $this->flash("Error", $data['Name'] . " deleted from file manager but not in database please delete from database manually", URLROOT . 'Song\index');
                    }
                } else {
                    $this->flash("Error", $data['Name'] . " Either song has already deleted or title was changed before delete button was clicked please refresh browser ", URLROOT . 'Song\admin');
                }
            }
        } else {
            //$this->model('user', []);
            $musicFile = new Song();
            $data = $musicFile->getSong($id)[0];
            $this->warning("Warning", "Confirm Deletion of " . $data['Name'], "users\deleteSong\\" . $id . '\\' . true);
        }
    }

    public function addSong()
    {
        if (!isAdmin()) {
            redirect('home\index');
        } else {

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //data from the form is put in an array
                $data = [
                    "song" => $_FILES["song"],
                    "title" => str_replace("'", "", trim($_POST["title"])),
                    "artist" => str_replace("'", "", trim($_POST["artist"])),
                    "cover" => $_FILES["cover"],

                    "song_err" => "",
                    "title_err" => "",
                    "artist_err" => "",
                    "cover_err" => ""
                ];

                if (empty($data["song"])) {
                    $data["song_err"] = "Choose a song";
                }

                if (empty($data["title"])) {
                    $data["title_err"] = "Enter title";
                } elseif (strlen($data["title"]) < 2) {
                    $data["title_err"] = "Title too short";
                }

                if (empty($data["artist"])) {
                    $data["artist_err"] = "Enter artist";
                } elseif (strlen($data["artist"]) < 1) {
                    $data["artist_err"] = "Artist too short";
                }

                if (empty($data["cover"])) {
                    $data["cover_err"] = "Choose a cover";
                }


                $data["song_err"] = $this->prepareFile($data['song'], 'music', $data['title']);
                if (!empty($data['cover']['name'])) {
                    $data["cover_err"] = $this->prepareFile($data['cover'], 'img/covers', $data['title']);
                }
                if (empty($data['song_err']) && empty($data['cover_err']) && empty($data['title_err']) && empty($data['artist_err'])) {
                    $song = $data['song'];
                    $fileExt1 = explode('.', $song['name']);
                    $fileActualExt1 = strtolower(end($fileExt1));
                    $allow = array('jpg', 'jpeg', 'png', 'mp3');


                    if (!in_array($fileActualExt1, $allow)) {
                        $fileActualExt1 = 'mp3';
                    }
                    $song1 = $data['title'] . '.' . $fileActualExt1;




                    if (!empty($data['cover']['name'])) {
                        $cover = $data['cover'];
                        $fileExt2 = explode('.', $cover['name']);
                        $fileActualExt2 = strtolower(end($fileExt2));
                        $cover1 = $data['title'] . '.' . $fileActualExt2;
                    } else {
                        $cover1 = "cover1.jpg";
                    }


                    
                    $a = new Song();
                    $a->UploadSong($song1, $data['artist'], $cover1);
                    $this->flash("Success", "New song Successfully Added to playlist", URLROOT . 'users\admin');
                } else {


                    $this->view('Song\addSong', $data);
                    //
                }
            } else {
                $data = [
                    "song" => "",

                    "title" => "",

                    "artist" => "",

                    "cover" => "",
                    "song_err" => "",
                    "title_err" => "",
                    "artist_err" => "",
                    "cover_err" => ""

                ];

                $this->view('Song\addSong', $data);
                //
            }
        }
    }



    public function upload()
    {
        if (!isAdmin()) {
            redirect('home\index');
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //data from the form is put in an array
                $data = [
                    //"id" => trim($_POST["id"]),
                    "song" => trim($_POST["song"]),
                    "cover" => trim($_POST["cover"]),
                    "artist" => trim($_POST["artist"]),
                    "action" => "",

                    "song_err" => "",
                    "title_err" => "",
                    "artist_err" => "",
                    "cover_err" => ""

                ];

                if (isset($_POST["delete"])) {
                    $data['action'] = "DELETE";
                    $this->model('user', $data);
                    $musicFile = new Song();
                    //$ex = $musicFile->DeleteSong($data['id']);
                    $isDeleted = $this->deletefile($data['song']);
                    if ($isDeleted) {
                        $ex = $musicFile->DeleteSong($data['id']);
                        if ($ex) {

                            $this->flash("Deleted", $data['song'] . " has been Successfully deleted", URLROOT . 'Song\index');
                            
                        } else {
                            $this->flash("Error", $data['song'] . " deleted from file manager but not in database please delete from database manually", URLROOT . 'Song\index');
                            
                        }
                    } else {
                        $this->flash("Error", $data['song'] . " Either song has already deleted or title was changed before delete button was clicked please refresh browser ", URLROOT . 'Song\index');
                       
                    }
                } else {

                    if (empty($data["song"])) {
                        $data["song_err"] = "Enter song";
                    } elseif (strlen($data["song"]) < 1) {
                        $data["song_err"] = "Song too short";
                    }

                    if (empty($data["artist"])) {
                        $data["artist_err"] = "Enter artist";
                    } elseif (strlen($data["artist"]) < 1) {
                        $data["artist_err"] = "Artist too short";
                    }

                    if (empty($data["cover"])) {
                        $data["cover_err"] = "Choose a cover";
                    }

                    if (empty($data['song_err']) && empty($data['artist_err']) && empty($data['cover_err'])) {

                        $fileExt = explode('.', $data['song']);
                        $fileActualExt = strtolower(end($fileExt));

                        $allow = array('jpg', 'jpeg', 'png', 'mp3');


                        if (!in_array($fileActualExt, $allow)) {
                            $data['song'] = $data['song'] . ".mp3";
                        }

                        $fileExt2 = explode('.', $data['cover']);
                        $fileActualExt2 = strtolower(end($fileExt2));

                        $allow2 = array('jpg', 'jpeg', 'png', 'mp3');


                        if (!in_array($fileActualExt2, $allow2)) {
                            $data['cover'] = $data['cover'] . ".jpg";
                        }


                        $data['action'] = "UPDATE";
                       
                        $musicFile = new Song();
                        $ex = $musicFile->updateSong($data);
                        if ($ex) {
                            $this->view('Song\index', $data);
                            //$this->model('Music', $data);
                            //$this->model->render1();
                            //
                        } else {
                            echo "something went wrong";
                        }
                    } else {

                        $this->view('Song\index', $data);
                        //$this->model('Music', $data);
                        //$this->model->render1();
                        //
                    }
                }
            } else {
                redirect('Song/addSong');
            }
        }
    }

    private function prepareFile($file, $folder, $title)
    {
        if (!isAdmin()) {
            redirect('home/index');
        } else {
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allow = array('jpg', 'jpeg', 'png', 'mp3');

            var_dump($fileActualExt);
            if (in_array($fileActualExt, $allow)) {

                if ($fileError == 0) {
                    if ($fileSize < 100000000) {
                        $fileNameNew = $title . '.' . $fileActualExt;
                        $fileDestination = ROOT . '/public/media/' . $folder . '/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        return "";
                    } else {
                        return "your file is too big";
                    }
                } else {
                    return "error uploading file";
                }
            } else {
                $fileActualExt = "mp3";
                if ($fileError == 0) {
                    if ($fileSize < 100000000) {
                        $fileNameNew = $title . '.' . $fileActualExt;
                        $fileDestination = ROOT . '/public/media/' . $folder . '/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        return "";
                    } else {
                        return "your file is too big";
                    }
                } else {
                    return "error uploading file";
                }
            }
        }
    }
    public function index()
    {
        if (isAdmin()) {
            //$this->model('music', []);
            $music = new Song();
            $data = $music->getAllsong();
            $this->view('Song\index', $data);
            //
        } else {
            
            redirect('home/index');
        }
    }

    private function deletefile($file)
    {
        $path = ROOT . "public\media\music/" . $file;

        if (unlink($path)) {
            return true;
        } else {
            return false;
        }
    }

}