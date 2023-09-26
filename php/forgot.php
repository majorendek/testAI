<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("lib.php");
include("_backupActions.php");


////////////////   VARIABLES //////////////////////////////
$userEmail = "";

$resultSessionId = "";

////////////////   FUNCTIONS //////////////////////////////


//////////////////////////////////////////////////////
////////////////   MAIN //////////////////////////////

//BLOCK ==================================
//JSON & HASH VERIFYCATION (error set 100)


		try {
			
					$stringJSON = file_get_contents("php://input");
					$decodedJSON = json_decode($stringJSON, true);
					
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
							$userEmail = $decodedJSON["data"]["email"];
						
							//client info
							$myCallURL = $decodedJSON["info"]["callURL"];
							
							//server info
							$ip = $_SERVER['REMOTE_ADDR']; 
							$host = gethostbyaddr($ip);
						
							
						$forgotValuesFromDB = fncPDOForgot($userEmail);
						
						if ($forgotValuesFromDB != null){
						
								//everything is OK 
													
						} else {
							
								setError(410, "User doesn't exist.");
								
						}
						
						//close PDO connection
						$PDO->null;
				
				}
			
			} catch(Exception $e) {
					//echo 'Message: ' .$e->getMessage();
					setError(200, "General error TRY - PDO/DB BLOCK");	
			}
			
		}
			

mailPHPMailer_LOCAL("majo.rendek@gmail.com","kua", "ahoj s php");

//SEND MAIL TO ADMIN - ALWAYS
	sendMailForgot($stringJSON, $errorStatus, $errorCode, $errorMessage);

if (!isError()){
	sendMailForgotToUser($stringJSON, $errorStatus, $errorCode, $errorMessage, $forgotValuesFromDB);
}


$resultData = [ 
		'result' => [
				'status' => ($errorStatus)?"OK":"NOK", 
				'code' => $errorCode, 
				'message' => $errorMessage
		],
		'data' => [
		]
		//,'test' =>  $forgotValuesFromDB
];

//PRODUCTION
echo json_encode($resultData);

//TEST
//echo "<br><br><br>" . json_encode($resultData,JSON_PRETTY_PRINT);

?>