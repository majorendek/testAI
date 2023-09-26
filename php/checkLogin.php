<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("lib.php");
include("_backupActions.php");


////////////////   VARIABLES //////////////////////////////
$login = "";
$isExtern = "";

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
						//data
						$function = $decodedJSON["data"]["function"];
						$checkFunction = $decodedJSON["data"]["checkFunction"];
						$sessionid = $decodedJSON["data"]["sessionid"];
							
						//server info
						$ip = $_SERVER['REMOTE_ADDR']; 
						$host = gethostbyaddr($ip);
						
						if ($sessionid == "liberaterraFree"){
						
							$login = "Test";
						
						} else {
						
							$valuesFromDB = fncPDOcheckLogin($sessionid);
						
							if ($valuesFromDB == null){
								
									setError(510, "Session id is invalid.");
									
							} else {
								
									$firstName = $valuesFromDB["firstname"];
									$lastName = $valuesFromDB["lastname"];
									
									if (!is_null($valuesFromDB['userid_extern'])){
										$isExtern = "yes";
									}
									
									if ($firstName != "" || $lastName != ""){
										$login = $firstName . " " . $lastName;
									} else {
										$login = $valuesFromDB["login"];
									}
							}
								
							
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
	//sendMaillogin($stringJSON, $errorStatus, $errorCode, $errorMessage);

$resultData = [ 
		'result' => [
				'status' => ($errorStatus)?"OK":"NOK", 
				'code' => $errorCode, 
				'message' => $errorMessage
		],
		'data' => [
				'login' => $login,
				'extern' => $isExtern
		]
];

//PRODUCTION
echo json_encode($resultData);

//TEST
//echo "<br><br><br>" . json_encode($resultData,JSON_PRETTY_PRINT);

?>