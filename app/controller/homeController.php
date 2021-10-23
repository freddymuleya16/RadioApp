<?php
class homeController extends controller
{
	public function index($id='',$name=''){
		
		$this->model('music',[]);
		$musicModel= new Music();
		
		$this->view('home\index',[
			'name'=> $name,
			'id'=> $id,
			[$musicModel->getAllsong()],
			[$musicModel->getComments()]

		]);
		$this->view->render();
	}
	public function say(){
		new Cheeese;
	}
	public function aboutUS(){
		$this->view('home\aboutUs');
		$this->view->render();
	}

	public function register(){
		redirect('users\register');
		$this->view('home\register',$data);
		$this->view->render();
	}

	public function login(){
		redirect('users\login');
		$this->view('home\login',$data);
		$this->view->render();
	}
	public function contact(){
		redirect('users\contact');
		$this->view('home\contact',$data);
		$this->view->render();
	}

	public function admin(){
		redirect('users\admin');
		}

	public function load_comments($commentCount){
		$this->model('music',[]);
		$model = new Music;
		$comments=$model->showMoreComments($commentCount);
		foreach ($comments as $row) {
			echo "<p>";
			echo $row['Author'].": ".$row['Message'];
			echo "</p><br>";
		}
	}

	public function submitComment(){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
	        $info = [
	            "author" => trim($_POST["author"]),
	            "comment" => trim($_POST["comment"])
	        ];
	        $this->model('music',[]);
		$model = new Music;
			$ex=$model->addComment($info);
			if($ex){
				echo $info['author'].": ".$info['comment'];
			}else{
				echo "Ooops something went wrong";
			}
		}
	}

	public function addLike($songId){
		if (!isLoggedIn()) {
			echo "<a href=".URLROOT."users/login>LOGIN</a>";
		}else{
			$this->model('music',[]);
			$model=new Music;

			if($model->liked($songId)){
				echo "<p>".$model->addLike($songId)."</p>";
			}else{
				echo "<p>".$model->removeLike($songId)."</p>";
			}
		}
	}
	public function addDislike($songId){
		if (!isLoggedIn()) {
			echo "<a href=".URLROOT."users/login>LOGIN</a>";
		}else{
			$this->model('music',[]);
			$model=new Music;

			if($model->disliked($songId)){
				
				echo "<p>".$model->addDislike($songId)."</p>";
			}else{
				$model->removeDislike($songId);
			}
		}
	}

	public function loadLike($id){
		$this->model('music',[]);
		$model=new Music;
		$row = $model->getReaction($id);
    	echo "<p>".$row['Likes']."</p>";
	}

	public function loadDislike($id){
		$this->model('music',[]);
		$model=new Music;
		$row = $model->getReaction($id);
    	echo "<p>".$row['Dislikes']."</p>";
	}
}