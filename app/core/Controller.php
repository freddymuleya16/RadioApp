<?php

class Controller{
	protected $view;
	protected $model;

	public function view($viewName,$data=[]){
		$this->view = new View($viewName,$data);
		return $this->view;
	}

	public function model($model,$data=[]){
		
		$this->model = new Model($model,$data);
		return $this->model;
	}
	public function flash($name = '', $message = '', $class = '#'){
		$data=[
			'name'=>$name,
			'message'=>$message,
			'class'=>$class
		];
	  $this->view("inc\popUp",$data);
	  $this->view->render();
	}

	public function warning($name = '', $message = '', $class = '#'){
		$data=[
			'name'=>$name,
			'message'=>$message,
			'class'=>URLROOT.$class
		];
	  $this->view("inc\warning",$data);
	  $this->view->render();
	}
}
