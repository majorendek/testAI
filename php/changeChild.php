<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("lib.php");
include("_backupActions.php");


////////////////   VARIABLES //////////////////////////////

$userid = 0;
$email = "";
$username = "";
$userPasswordNew = "";
$sessionid = "";

$resultDataUserid = "";
//$resultDataFirstname = "";
//$resultDataLastname = "";
$resultDataType = ""; // 'parent' or 'child'
$resultDataNrOfChildren = 0;
$resultSessionId = "";

////////////////   FUNCTIONS //////////////////////////////


//////////////////////////////////////////////////////
////////////////   MAIN //////////////////////////////

//BLOCK ==================================
//JSON & HASH VERIFYCATION (error set 100)


		try {
			
					$stringJSON = file_get_contents("php://input");
					$decodedJSON = json_decode($stringJSON, true);
					
					/*
					$publicKey =  $decodedJSON["authorize"]["public_key"];
					$hashJSON = $decodedJSON["authorize"]["hash"];
			
					if (!password_verify($hashPassword.$publicKey, $hashJSON)) {	
						setError(110, "Invalid hash in input JSON");	
					} 
					*/
					
		} catch(Exception $e) {
					//echo 'Message: ' .$e->getMessage();
					setError(100, "General error TRY - JSON VERIFYCATION BLOCK");	
		}


//BLOCK ==================================
//PDO - DB CONNECT (error set 200)

		if (!isError()){
			
			try {
				if (!connectDB_PDO()){
						
						setError(210, "Cannot connect to DB");
						
				} else {
																		    	
						$parentid = $decodedJSON["data"]["parentid"];
						$userid = $decodedJSON["data"]["userid"];
						$firstname = $decodedJSON["data"]["firstname"];
						$lastname = $decodedJSON["data"]["lastname"];
						$username = $decodedJSON["data"]["username"];

						$userPasswordNew = $decodedJSON["data"]["wenrowssap"];
						$class = $decodedJSON["data"]["class"];
						
						$valuesFromDB = fncPDOChangeChild($parentid, $userid, $firstname, $lastname, $username, $userPasswordNew, $class);

						if ($valuesFromDB == null){
								setError(810, "Child is not changed.");
						}			
					
						//close PDO connection
						$PDO->null;
				
				}
			
			} catch(Exception $e) {
					//echo 'Message: ' .$e->getMessage();
					setError(200, "General error TRY - PDO/DB BLOCK");	
			}
			
		}
			

//SEND MAIL
	sendMailChangeChild($stringJSON, $errorStatus, $errorCode, $errorMessage);
	

$resultData = [ 
		'result' => [
				'status' => ($errorStatus)?"OK":"NOK", 
				'code' => $errorCode, 
				'message' => $errorMessage
		]
];

//PRODUCTION
echo json_encode($resultData);

//TEST
//echo "<br><br><br>" . json_encode($resultData,JSON_PRETTY_PRINT);

?>