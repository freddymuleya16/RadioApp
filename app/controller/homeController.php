<?php
class homeController extends controller
{
	
	public function index($id = '', $name = '')
	{
		$newSongModel = new Song();
		
		$newCommentsModel = new Comments();

		$this->view('home\index', [
			'name' => $name,
			'id' => $id,
			'songs'=>[$newSongModel->getAllsong()],
			'comments' =>[$newCommentsModel->getComments()]

		]);
	}
	public function aboutUS()
	{
		$this->view('home\aboutUs');
		
	}

	public function register($data = [])
	{
		redirect('Account\register');
	}

	public function login($data = [])
	{
		redirect('Account\login');
	}
	

	public function admin()
	{
		redirect('Account\admin');
	}

	public function load_comments($commentCount)
	{
		//$this->model('music', []);
		$model = new Comments();
		$comments = $model->showMoreComments($commentCount);
		foreach ($comments as $row) {
			echo "<p>";
			echo $row['Author'] . ": " . $row['Message'];
			echo "</p><br>";
		}
	}

	public function submitComment()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$info = [
				"author" => trim($_POST["author"]),
				"comment" => trim($_POST["comment"])
			];
			//$this->model('music', []);
			$model = new Comments();
			$ex = $model->addComment($info);
			if ($ex) {
				echo $info['author'] . ": " . $info['comment'];
			} else {
				echo "Ooops something went wrong";
			}
		}
	}

	public function addLike($songId)
	{
		if (!isLoggedIn()) {
			echo "<a href=".URLROOT."users/login>LOGIN</a>";
		} else {
			$this->model('music', []);
			$model = new Reaction;

			if ($model->liked($songId)) {
				return $model->addLike($songId);
			} else {
				return $model->removeLike($songId) ;
			}
		}
	}
	public function addDislike($songId)
	{
		if (!isLoggedIn()) {
			echo "<a href=".URLROOT."users/login>LOGIN</a>";
		} else {
			//$this->model('music', []);
			$model = new Reaction();

			if ($model->disliked($songId)) {
				return $model->addDislike($songId);
			} else {
				$model->removeDislike($songId);
			}
		}
	}

	public function loadLike($id)
	{
		$model = new Song();
		$row = $model->getReaction($id);
		echo $row['Likes'];
	}

	public function loadDislike($id)
	{
		$model = new Song;
		$row = $model->getReaction($id);
		echo $row['Dislikes'] ;
	}
	public function contact()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'name' => trim($_POST["name"]),
                'email' => trim($_POST["email"]),
                'phone' => trim($_POST["phone"]),
                'message' => trim($_POST["message"]),

                'name_err' => "",
                'email_err' => "",
                'phone_err' => "",
                'message_err' => ""
            ];

            if (isLoggedIn()) {
                $data = [
                    'name' => trim($_SESSION["name"]),
                    'email' => trim($_SESSION["email"]),
                    'phone' => trim($_SESSION["phone"]),
                    'message' => trim($_POST["message"]),

                    'name_err' => "",
                    'email_err' => "",
                    'phone_err' => "",
                    'message_err' => ""
                ];
            }


            //we validate the data
            if (empty($data["name"])) {
                $data["name_err"] = "Enter name";
            } elseif (strlen($data["name"]) < 2) {
                $data["name_err"] = "Name too short";
            }

            if (empty($data["email"])) {
                $data["email_err"] = "Enter email";
            } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                $data["email_err"] = "Invalid Email";
            }

            if (empty($data["phone"])) {
                $data["phone_err"] = "Enter Phone number";
            } elseif (strlen($data["phone"]) < 10) {
                $data["phone_err"] = "Invalid number";
            } elseif (!is_numeric($data["phone"])) {
                $data["phone_err"] = "Invalid number";
            }
            if (empty($data["message"])) {
                $data["message_err"] = "Enter message";
            } elseif (strlen($data["name"]) < 10) {
                $data["message_err"] = "Message too short";
            }

            if (empty($data['message_err']) && empty($data['phone_err']) && empty($data['email_err']) && empty($data['name_err'])) {
                $this->model('user', $data);
                $inputMessage = new user;
                $sendmessage = $this->sendEmail("freddymuleya16@gmail.com", "Message From " . SITENAME, 'Name: ' . $data['name'] . '<br>Phone number: ' . $data['phone'] . '<br>Email: ' . $data['email'] . '<br>Message: ' . $data['message']);
                if (/*$inputMessage->saveMessage($data)*/$sendmessage) {
                    $this->flash("Message Sent", SITENAME . " has recieved your message and an appropriate responce will be sent to " . $data['email'], URLROOT . "home/index");
                } else {
                    $this->flash("Message Not Sent", "Error occured please try again", URLROOT . "users/contact");
                }
            } else {
                $this->view('home\contact', $data);
                
            }
        } else {
            $data = [
                'name' => "",
                'email' => "",
                'phone' => "",
                'message' => "",

                'name_err' => "",
                'email_err' => "",
                'phone_err' => "",
                'message_err' => ""
            ];
            $this->view('home\contact', $data);
            
        }
		
    }
	
}
