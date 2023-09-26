<?php

	/*
	autor: Marian Rendek
	date: 26.10.2022
	
	Poznamky:
	---------
		"public_key" -> vygenerovane ( "LT_" + HEX(10) )
		"hash" -> sha256( private_key + public_key + action + userID + date )

		neverejne:
		private_key -> "LT_16a427b568c16b14d465"
		secretPhrase -> "LT_817a1d767b48decf64e7"

		HEX(N)
		https://www.browserling.com/tools/random-hex

		SHA256
		https://emn178.github.io/online-tools/sha256.html

		OPENSSL CRYPTO
		https://stackoverflow.com/questions/41222162/encrypt-in-php-openssl-and-decrypt-in-javascript-cryptojs
		https://github.com/sytelus/CryptoJS

		AUTOLOGIN -> default akcia
	
*/

error_reporting(E_ALL ^ E_NOTICE); 

////////////////////////////// -------- INCLUDES
require("php/lib.php");
//$hashPasswordPortal


////////////////////////////// -------- VARIALBLES
$myStartTime = microtime(true);

$gVersion = "20221026MR";

$hashPasswordPortal = "LT_16a427b568c16b14d465";    //for JSON authorisation use or privateKey
$gSecretPhrase = "LT_817a1d767b48decf64e7"; 				//for POST DATA encryption/decryption


////////////////////////////// -------- FUNCIONS

function isToday($time) // midnight second
{
    return (strtotime($time) === strtotime('today'));
}
//
function getRandomHex($num_bytes=4) {
  return bin2hex(openssl_random_pseudo_bytes($num_bytes));
}
//
function CryptoJSAesEncrypt($passphrase, $plain_text){

    $salt = openssl_random_pseudo_bytes(256);
    $iv = openssl_random_pseudo_bytes(16);
    //on PHP7 can use random_bytes() istead openssl_random_pseudo_bytes()
    //or PHP5x see : https://github.com/paragonie/random_compat

    $iterations = 999;  
    $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

    $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

    $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));
    return json_encode($data);
}
//
function CryptoJSAesDecrypt($passphrase, $jsonString){

    $jsondata = json_decode($jsonString, true);
    try {
        $salt = hex2bin($jsondata["salt"]);
        $iv  = hex2bin($jsondata["iv"]);          
    } catch(Exception $e) { return null; }

    $ciphertext = base64_decode($jsondata["ciphertext"]);
    $iterations = 999; //same as js encrypting 

    $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

    $decrypted= openssl_decrypt($ciphertext , 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

    return $decrypted;

}



////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// -------- MAIN

//BLOCK ==================================
//JSON & HASH VERIFYCATION (error set 100)
		try {
									
					//$stringJSON = file_get_contents("php://input");
					$stringPostJSON = $_POST['data'];
					
					$stringJSON = CryptoJSAesDecrypt($gSecretPhrase, $stringPostJSON);
					
					$decodedJSON = json_decode($stringJSON, true);
				
					$publicKey =  $decodedJSON["authorize"]["public_key"];
					$hashJSON = $decodedJSON["authorize"]["hash"];
					$action = $decodedJSON["data"]["action"];
					$userID = $decodedJSON["data"]["userID"];
					$date = $decodedJSON["data"]["date"];
					
					//$extraInfo =  hash('sha256', $hashPassword.$publicKey.$action.$userID);
					
					if (hash('sha256', $hashPasswordPortal.$publicKey.$action.$userID.$date) != $hashJSON) {	
						setError(101, "Invalid hash in JSON");	
					} 
										
		} catch(Exception $e) {
					//echo 'Message: ' .$e->getMessage();
					setError(100, "General error TRY - JSON BLOCK (" . $e->getMessage() .  ")  ");	
		}


//SPECIAL MAJO
if ($action == "majo"){
	resetErrors();
}


//BLOCK ==================================
//PDO - DB CONNECT (error set 200)
		if (!isError()){
			try {
				
				if (!connectDB_PDO()){
						setError(201, "Cannot connect to DB");
				}
				
			} catch(Exception $e) {
					//echo 'Message: ' .$e->getMessage();
					setError(100, "General error TRY - PDO / DB BLOCK (" . $e->getMessage() .  ")  ");		
			}
			
		}

	
		if (!isError()){
			
			//check DATE or SPECIAL
			if (isToday($date) || ($action == "majo")){
				
				
				
				//get parameter
				//$userID
				$usertype = "";
				$session = getRandomHex(6);
				
				
						try {
						
								$sql = "SELECT * FROM users WHERE userid_extern = ? AND active = 1";
								
								$stmt = $PDO->prepare($sql);
								$stmt->execute([$userID]);			
								$result = $stmt->fetch();
								
								if ($result){
								
									//print_r($result);
									//$result["type"] //teacher, parent, child
									//$result["userid"]
									
									
// START JAVASCRIPT

/*

							<script src="./libs/client.min.js"></script>
							<script src="./modules/general/calls.js"></script>
								
							<script type = "text/javascript"/>

															
											var myCallURL = location.href;		
											var myClient = new ClientJS();
											
																with (myClient) {
																
																		//JSON	
																		var postJSON =  { 
																				    	"data" : { 
																				        "id" : <?php echo $result["userid"]; ?>
																				    	},
																				    	"info" : {
																				    		"callURL" : myCallURL,
																				    		"getOS" : getOS(),
																				    		"getOSVersion" : getOSVersion(),
																				    		"getBrowser" : getBrowser(),
																				    		"getBrowserVersion" : getBrowserVersion(),
																				    		"getEngine" : getEngine(),
																				    		"getDevice" : getDevice(),
																				    		"getDeviceType" : getDeviceType(),
																				    		"getDeviceVendor" : getDeviceVendor(),
																				    		"getUserAgent" : getUserAgent(),
																				    		"getCurrentResolution" : getCurrentResolution(),
																				    		"getColorDepth" : getColorDepth(),
																				    	}
																						};
																}
																
																fncCalls_ajaxPostJSON(gURL_PHP_logData,JSON.stringify(postJSON), "", "");
														
							</script>
							
*/
								
	// END JAVASCRIPT
								
										$sqlUpdate = "UPDATE users SET sessionid='$session', sessiontimestamp=NOW() WHERE userid = ?";
										$stmtUpdate = $PDO->prepare($sqlUpdate);
										$stmtUpdate->execute([$result["userid"]]);			
										$updateCount = $stmtUpdate->rowCount();
										
											if ($updateCount == 1){
												//OK
												$usertype = $result["type"];
												
											} else {
												//NOK	
												setError(330, "I cannot set session for userid_extern (" . $userID .  ")  ");
											}
										
								
								} else {
									//no user in DB
								 	setError(340, "No user in DB with userid_extern (" . $userID .  ")  ");
								}
						
						} catch (PDOexception $e) {
							//echo 'Message: ' .$e->getMessage();
							setError(350, "PDO exception (" . $e->getMessage() .  ")  ");
						}
				
				
			} else {
			
				setError(301, "DATE ERROR - NOT TODAY (" . $date .  ")  ");		
				
			}
			
			
		}



//close PDO connection
		$PDO->null;
		
		//redirect link
		if (!isError()){
			
				if ($usertype != ""){
				
					//echo "Všetko je v poriadku. Stránka nie je implementovaná.";
					
					
						if ($usertype == "teacher"){
							
								//SUCCESS as TEACHER
								sendMailAutologinLogged($stringJSON, $errorStatus, $errorCode, $errorMessage, " TEACHER logged");
							
								header("Location: https://customers.turnpages.sk/liberaterra/apps/test/modules/teacher/teacher.html?sessionid=" . $session );
								
						}	else if ($usertype == "parent"){
							
								//SUCCESS as PARENT
								sendMailAutologinLogged($stringJSON, $errorStatus, $errorCode, $errorMessage, " PARENT logged");
							
								header("Location: https://customers.turnpages.sk/liberaterra/apps/test/modules/dashboard/dashboard.html?sessionid=" . $session );
								
						} else if ($usertype == "child"){
							
								//SUCCESS as CHILD
								sendMailAutologinLogged($stringJSON, $errorStatus, $errorCode, $errorMessage, " CHILD logged");
							
								header("Location: https://customers.turnpages.sk/liberaterra/apps/test/modules/test/testStart.html?sessionid=" . $session );
								
						} else {
							
								//mail user type error
								sendMailAutologin($stringJSON, false, "1010", "User has not defined type (teacher, parent or child)");
							
						}
						
					
				
				} else {
							
						//mail user type not exists	
						sendMailAutologin($stringJSON, false, "1010", "User has no type (teacher, parent or child)");
				}
				
		} else {
			
			//mail error to log in (send also errors)
			sendMailAutologin($stringJSON, $errorStatus, $errorCode, $errorMessage);
	
			echo "Nastal problém s automatickým prihlásením do modulu, prosím kontaktujte administrátora. (" . $errorMessage . ")";
			echo $stringJSON;
			
		}

	//exit();
