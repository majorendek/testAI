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
																		    	
						$userid = $decodedJSON["data"]["userid"];
						$email = $decodedJSON["data"]["email"];
						$username = $decodedJSON["data"]["username"];

						$userPasswordNew = $decodedJSON["data"]["wenrowssap"];
						$sessionid = $decodedJSON["data"]["sessionid"];
						
						$valuesFromDB = fncPDOChangeParent($userid, $email, $username, $sessionid, $userPasswordNew);

						if ($valuesFromDB != null){
								
								$resultDataUserid = $valuesFromDB["userid"];
								//$resultDataFirstname = $valuesFromDB["firstname"];
								//$resultDataLastname = $valuesFromDB["lastname"];
								$resultDataType = $valuesFromDB["type"];
								$resultSessionId = $valuesFromDB["sessionid"];
								
								fncPDOUserLog($valuesFromDB["userid"],$myCallURL,$myOs,$myOsVersion,$myBrowser,$myBrowserVersion,$myEngine,$myDevice,$myDeviceType,$myDeviceVendor,$myUserAgent,$myResolution,$myColorDepth,$ip,$host);
								
								if ($resultDataType == 'parent'){
									$resultDataNrOfChildren = fncPDOGetNrOfChildren($resultDataUserid);
								}
										
						} else {
								setError(810, "Cannot change parent");
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
	sendMailChangeParent($stringJSON, $errorStatus, $errorCode, $errorMessage);
	

$resultData = [ 
		'result' => [
				'status' => ($errorStatus)?"OK":"NOK", 
				'code' => $errorCode, 
				'message' => $errorMessage
		],
		'data' => [
		//	'userid' => $resultDataUserid,
		//	'firstname' => $resultDataFirstname,
		//	'lastname' => $resultDataLastname,
			'type' => $resultDataType,
			'children' => $resultDataNrOfChildren,
			'sessionid' => $resultSessionId,
		]
];

//PRODUCTION
echo json_encode($resultData);

//TEST
//echo "<br><br><br>" . json_encode($resultData,JSON_PRETTY_PRINT);

?>