<?php  


class Model{

	protected $model_file;
	protected $model_data;

	public function __construct($model_file,$model_data){
		$this->model_file = $model_file;
		$this->model_data = $model_data;

		$this->render1();
	}

	public function render1(){


		if(file_exists(MODEL.$this->model_file.'.php')){
			$data = $this->model_data;
			include MODEL.$this->model_file.'.php';
			
		}else{
			echo MODEL.$this->model_file.'.php does not exist';
		}
	}
}