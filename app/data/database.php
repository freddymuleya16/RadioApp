<?php

class database{
	private $servername = SERVERNAME;
	private $username = USERNAME;
	private $password = PASSWORD;
	private $dbname = DBNAME;

	private $stmt;
	private $SQL;

	
	public function connect(){
		
		$dsn = 'mysql:host=' . $this->servername.';dbname='.$this->dbname;
		$options = array (
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		try{
			$pdo = new PDO($dsn,$this->username,$this->password,$options);
			//$pdo->setAttribute(,);
			return $pdo;
		}catch(Exception $e){
			error_log($e->getMessage());
			exit("Check Error log");
		}
				
	}

}