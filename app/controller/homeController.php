<?php

class homeController extends controller
{

	
	public function index($id='',$name=''){
		//echo "i am in in". __CLASS__ .'method'.__METHOD__;

		//echo "ID: is ". $id.' and name is : '. $name;
		//var_dump($this->model);

		
		$this->model('music',[]);
		$musicModel= new Music();
		 //var_dump($musicModel->getComments());

		
		$this->view('home\index',[

			'name'=> $name,
			'id'=> $id,
			[$musicModel->getAllsong()],
			[$musicModel->getComments()]

		]);
		
		//$this->model->render1();
		$this->view->render();
		//$this->showLikes('1');
		//$b=new Music;$b->getLikers(1);

	}
	
	

	public function say(){
		new Cheeese;
	}
	public function aboutUS(){
		//echo "i am in in". __CLASS__ .'method'.__METHOD__;

		$this->view('home\aboutUs');
		$this->view->render();
	}

	public function register(){
		//echo "i am in in". __CLASS__ .'method'.__METHOD__;
		redirect('users\register');
		$this->view('home\register',$data);
		$this->view->render();
	}

	public function login(){
		//echo "i am in in". __CLASS__ .'method'.__METHOD__;
		redirect('users\login');
		$this->view('home\login',$data);
		$this->view->render();
	}
	public function contact(){
		//echo "i am in in". __CLASS__ .'method'.__METHOD__;
		redirect('users\contact');
		$this->view('home\contact',$data);
		$this->view->render();
	}

	public function admin(){
		//echo "i am in in". __CLASS__ .'method'.__METHOD__;
		//$this->model('Music',[]);
		//$this->model->render1();
		redirect('users\admin');
		//$this->view('home\admin',$data);

		
		//$this->view->render();
	}

	public function load_comments($commentCount){
		//echo $commentCount;
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
				
				//echo "<script>alert('adding')</script>";
			}else{
				
				echo "<p>".$model->removeLike($songId)."</p>";
				//echo "<script>alert('removed')</script>";
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
    	//echo "<span class='tooltiptext'>";$model->getReactors($id,"LIKE");echo "</span>";
	}

	public function loadDislike($id){
		$this->model('music',[]);
		$model=new Music;

		$row = $model->getReaction($id);

    	echo "<p>".$row['Dislikes']."</p>";
    	
    	//echo "<span class='tooltiptext'>";$model->getReactors($id,"DISLIKE");echo "</span>";
	}
}