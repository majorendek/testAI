<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("lib.php");
include("_backupActions.php");


////////////////   VARIABLES //////////////////////////////


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
				
				
						$sessionid = $decodedJSON["data"]["sessionid"];
						
						$exerciseType = $decodedJSON["data"]["exerciseType"];
						$exerciseTimeStart = $decodedJSON["data"]["exerciseTimeStart"];
						$exerciseTimeEnd = $decodedJSON["data"]["exerciseTimeEnd"];
						$exerciseTimeTotalSeconds = $decodedJSON["data"]["exerciseTimeTotalSeconds"];
						$exerciseResultCounter = $decodedJSON["data"]["exerciseResultCounter"];
						$exerciseResultGoodCounter = $decodedJSON["data"]["exerciseResultGoodCounter"];
						$exerciseFull = $decodedJSON["data"]["exerciseFull"];
						
						//resultObject
						$exerciseJSON = $decodedJSON["data"]["exerciseJSON"];
													
						$superschopnostiValuesFromDB = fncPDOSuperschopnosti($sessionid, $exerciseType,$exerciseTimeStart,$exerciseTimeEnd,$exerciseTimeTotalSeconds,$exerciseResultCounter,$exerciseResultGoodCounter,$exerciseFull, $exerciseJSON);
						
						if ($superschopnostiValuesFromDB != null){
								//vsetko je OK
						} else {
								setError(410, "Superschopnosti sa nezapisali.");
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

//MRN - test
	//$exerciseJSONparsed =json_decode($exerciseJSON, true);
	//$testData	= $exerciseJSONparsed["state"];
	$testData	= "";

$resultData = [ 
		'result' => [
				'status' => ($errorStatus)?"OK":"NOK", 
				'code' => $errorCode, 
				'message' => $errorMessage
		],
		'data' => [
		],
		'test' => $testData 
];

//PRODUCTION
echo json_encode($resultData);

//TEST
//echo "<br><br><br>" . json_encode($resultData,JSON_PRETTY_PRINT);

?>