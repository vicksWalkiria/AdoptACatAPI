<?php

require '../../config/config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

$user_name = $_GET['user_name'];
$password = $_GET['password'];


if(strlen($user_name) == 0 || strlen($password) == 0)
{
 	$response = array("code" => "400", "data" => "You must provide valid params");

}
else
{
	$sql = 'SELECT id FROM users WHERE user_name like "'.$user_name.'" AND password like "'.$password.'"';
	$db= new db();
	$database = $db->connectionDB();
	$result = $database->query($sql);
	$users = $result ->fetchAll(PDO::FETCH_OBJ);
	if(count($users) > 0)
	{

		$id = $users[0]->id;
		// PHASE #3 modification => return user_id
		$response = array("code" => "200", "data" => array("message" =>"OK", "token" => $db->generateToken($id), "user_id" => $id)); 
	}
	else
	{
		$response = array("code" => "401", "data" => array("message" =>"UNAUTHORIZED - Invalid username or password"));
	}
}

$db = null;
$database = null;

echo json_encode($response);