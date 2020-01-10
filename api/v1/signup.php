<?php

require '../../config/config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

$user_name = $_REQUEST['user_name'];
$password = $_REQUEST['password'];

if(strlen($user_name) == 0 || strlen($password) == 0)
{
 	$response = array("code" => "400", "data" => "You must provide valid params");

}
else
{
	$sql = 'SELECT id FROM users WHERE user_name like "'.$user_name.'"';
	$db= new db();
	$database = $db->connectionDB();
	$result = $database->query($sql);
	$users = $result ->fetchAll(PDO::FETCH_OBJ);
	if(count($users) > 0)
	{
		$response = array("code" => "400", "data" => array("message" =>"BAD REQUEST - User already exists")); 
	}
	else
	{
		$db= new db();
		$db = $db->connectionDB();
		$sentence = $db->prepare("INSERT INTO users (user_name, password) VALUES (?, ?)");
		$sentence->bindParam(1, $user_name);
		$sentence->bindParam(2, $password);
		$sentence->execute();			
		$response = array("code" => "200", "data" => array("message" =>"OK"));
	}
}

$db = null;
$database = null;

echo json_encode($response);