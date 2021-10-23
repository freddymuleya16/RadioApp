<?php
require_once '../app/helpers/session_helper.php';

include "../app/config/config.php";

define('ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP',ROOT.'app'.DIRECTORY_SEPARATOR);
define('VIEW',ROOT.'app'.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR);
define('MODEL',ROOT.'app'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR);
define('DATA',ROOT.'app'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR);
define('CORE',ROOT.'app'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR);
define('CONTROLLER',ROOT.'app'.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR);

$modules = [ROOT,APP,VIEW,CORE,MODEL,CONTROLLER,DATA];
$GLOBALS['module'] = [CORE,MODEL,CONTROLLER,VIEW,DATA,ROOT,APP];



set_include_path(get_include_path().PATH_SEPARATOR.implode(PATH_SEPARATOR,$modules));
spl_autoload_extensions('.php');

//var_dump(set_include_path(get_include_path().PATH_SEPARATOR.implode(PATH_SEPARATOR,$modules)));

		spl_autoload_register(function($className){
		$path=search($className);
		//var_dump($path);
		$ext = ".php";
		$fullpath= $path.$className.$ext;

		if (!file_exists($fullpath)) {
			return false;
		} else {
			include_once $fullpath;
		}
		

		
	});



function search($className){
	foreach ($GLOBALS['module'] as $path ){
		
		$ext = ".php";
		$fullpath= $path.$className.$ext;
		//echo $fullpath."<br>";
		if (file_exists($fullpath)) {
			return $path;
		}
	}
}
	

new Application;
