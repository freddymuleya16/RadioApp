<?php
class Application
{
	protected $controller = 'homeController';
	protected $action = 'index';
	protected $params = [];

	public function __construct()
	{
		$request = trim($_SERVER['REQUEST_URI'], '/');
		$this->prepareURL();
		// echo $this->controller, '<br>' , $this->action , print_r($this->params);
		if (file_exists(CONTROLLER . $this->controller . '.php')) {
			$this->controller = new $this->controller;
			if (method_exists($this->controller, $this->action)) {
				call_user_func_array([$this->controller, $this->action], $this->params);
			} else {
				echo 'no method ' . $this->action;
			}
		} else {
			echo 'file doesnt exist ' . CONTROLLER . $this->controller . '.php';
		}
	}
	protected function prepareURL()
	{
		$request = trim($_SERVER['REQUEST_URI'], '/');
		if (!empty($request)) {
			$url = explode('/', $request);
			unset($url[0]);
			$this->controller = isset($url[1]) ? $url[1] . 'Controller' : 'homeController';
			$this->action = isset($url[2]) ? $url[2] : 'index';
			unset($url[1], $url[2]);
			$this->params = !empty($url) ? array_values($url) : [];
		}
	}
}
