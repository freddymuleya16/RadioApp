<?php

class View
{
	protected $view_file;
	protected $view_data;

	public function __construct($view_file, $view_data)
	{
		$this->view_file = $view_file;
		$this->view_data = $view_data;
		$this->render();
	}
	public function render()
	{
		if (file_exists(VIEW . $this->view_file . '.php')) {
			$data = $this->view_data;
			include VIEW . $this->view_file . '.php';
		}
	}
	public function getAction()
	{
		return (explode('\\', $this->view_file)[1]);
	}
}
