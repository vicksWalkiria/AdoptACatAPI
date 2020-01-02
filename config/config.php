<?php

class db{
	private $dbHost = 'localhost';
	private $dbUser = "root";
	private $dbPass ="tx?n>gAe@Z#2i;f";
	private $dbName = "adoptACat";

	//connection

	public function connectionDB()
	{
		$mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName;charset=utf8";
		$dbConnection = new PDO($mysqlConnect,$this->dbUser, $this->dbPass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}

	public function generateToken($id)
	{
	//Generate a random string.
		$token = openssl_random_pseudo_bytes(64);
	//Convert the binary data into hexadecimal representation.
		$token = bin2hex($token);
		$sql = 'UPDATE users SET token = \''.$token. '\' WHERE id = '.$id;
		try{
			$db= new db();
			$db = $db->connectionDB();
			$affected_rows = $db->prepare($sql);
			$affected_rows->execute();
			if($affected_rows->rowCount() <= 0){
				return "error1";
			}	
		}catch(PDOException $e)
		{
			$response = array("code" => "500", "data" => $e->getMessage());
			print_r($response);
		}
		finally
		{
			$result = null;
			$db = null;
		}

		return $token;
	}
}