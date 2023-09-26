<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("lib.php");
include("_backupActions.php");


////////////////   VARIABLES //////////////////////////////
$sessionid ="";

$resultJSONData = "";
$resultSessionId = "";
$resultInclog = 0;

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
				
						//check session
						$sessionid = $decodedJSON["data"]["sessionid"];
						$valuesFromDB = fncPDOcheckLogin($sessionid);
						
						if ($valuesFromDB == null){
						
								setError(710, "Session id is invalid.");
								
						} else {
							
								$resultDataUserid = $valuesFromDB["userid"];
								$resultSessionId = $valuesFromDB["sessionid"];
								$resultInclog = $valuesFromDB["inclog"];
								
								
								//retieve last TEST for user
								$jsonFromDB = fncPDOgetLastTest($resultDataUserid);
							
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
		'data' => $jsonFromDB
		
];

//PRODUCTION
echo json_encode($resultData);

//TEST
//echo "<br><br><br>" . json_encode($resultData,JSON_PRETTY_PRINT);

?>