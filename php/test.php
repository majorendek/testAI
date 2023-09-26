<?php


/*
$hashPassword = "6miVqN2PASSyht5p";
$publicKey = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(32/strlen($x)) )),1,32); //generate 32 characters

$hash = password_hash($hashPassword.$publicKey, PASSWORD_DEFAULT);



$loginInput = "majo.rendek@gmail.com";
$login = password_hash($hashPassword.$loginInput, PASSWORD_DEFAULT);;

$passwordInput = "majo007";
$password = password_hash($hashPassword.$passwordInput, PASSWORD_DEFAULT);;


$postData = [
		'authorize' => [
								    'public_key' => $publicKey,
								    'hash' => $hash
								 ],
		'data' => [
								   "login" => $login,
								   "password" => $password,
		] //end data	
				 
]; //end postData
*/

$login = "rendekm";
$password = "majo007";

$postData = [
		'data' => [
				"login" => $login,
				"password" => $password,
		] //end data	
				 
]; //end postData




header('Content-Type: application/json');
echo json_encode($postData, JSON_PRETTY_PRINT);



/*
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://www.rendek.eu/liberaterra/apps/superschopnosti/php/login.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$jsonResponse = curl_exec($ch);

curl_close($ch);

//$response = json_decode($jsonResponse, true);
//print_r($response);

//PRETTY PRINT
header('Content-Type: text/javascript');
echo json_encode(json_decode($jsonResponse), JSON_PRETTY_PRINT);
//echo $jsonResponse;
*/


?>
