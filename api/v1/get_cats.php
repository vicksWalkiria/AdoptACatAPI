<?php

require '../../config/config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

$user_id = $_GET['user_id'];
$token = $_GET['token'];
$adoption = $_GET['adoption'];

$db= new db();
if(strlen($user_id) == 0 || strlen($token) == 0 || strlen($adoption) == 0)//|| !$db->isTokenValid($user_id, $token))
{
 	$response = array("code" => "400", "data" => "You must provide valid params");
}
else
{
	$sql = 'SELECT * FROM cats WHERE adoption = '.$adoption;
	$db= new db();
	$database = $db->connectionDB();
	$result = $database->query($sql);
	$cats = $result ->fetchAll(PDO::FETCH_OBJ);
	$response = array("code" => "200", "data" => array("cats" =>$cats, "token" => $db->generateToken($user_id))); 
}

$db = null;
$database = null;

echo json_encode($response);