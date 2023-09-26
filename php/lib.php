<?php


//////////////// DEFINITIONS /////////////////////////////////

require("class.phpmailer.php");
require("config.php");



////////////////   VARIABLES //////////////////////////////
$errorStatus = true;
$errorCode = 0;
$errorMessage = "";
$errorMessageIgnored = "";
$errorNr = 0;


//////////////// MAIL FUNCTIONS SPECIAL ////////////////////

function sendMailRemoveParent($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_removeParent_admin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "REMOVE PARENT ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_removeParent_admin . " >> ". $successString, $myMessage);
}
//
function sendMailRemoveParentToUser($postData, $errorStatus, $errorCode, $errorMessage, $valuesFromDB){
	global $subject_remove_parent;
	global $linkToApp;
	
	if ($valuesFromDB != null){ 
		
			$userEmail = $valuesFromDB["email"];
			$userLogin = $valuesFromDB["login"];
			
			
			$myMessage = '<html><body>';
			$myMessage .= "	<div>Váš profil bol úspešne zmazaný.</div><br>";
			$myMessage .= " <p>";
		
			$myMessage .= '	<table rules="all" style="border-color: #666;" cellpadding="10">';
			$myMessage .= "		<tr style='background: #eee;'><td><strong>Prihlasovacie meno:</strong> </td><td>" . $userLogin . "</td></tr>";
			$myMessage .= "	</table>";
		
			$myMessage .= "	<div><a href='" . $linkToApp . "'>" . $linkToApp . "</a></div><br>";
		
			$myMessage .= " <p>";
			$myMessage .= " <div>S pozdravom, </div><br>";
			$myMessage .= " <div>tím Libera Terra. </div><br>";
			
			
			$myMessage .= "</body></html>";


			//send mail to USER
			mailPHPMailer_LOCAL($userEmail,  $subject_remove_parent,   $myMessage);	
		
	}
	
	// no mail in other way
	
}
//
function sendMailRemoveChild($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_removeChild_admin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "REMOVE CHILD ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_removeChild_admin . " >> ". $successString, $myMessage);
}
//
function sendMailChangeChild($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_changeChild_admin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "CHANGE CHILD ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_changeChild_admin . " >> ". $successString, $myMessage);
}
//
function sendMailChangeParent($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_changeParent_admin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "CHANGE PARENT ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_changeParent_admin . " >> ". $successString, $myMessage);
}
//
function sendMailSignup($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_signup_admin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "SIGNUP ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_signup_admin . " >> ". $successString, $myMessage);
}
//
function sendMailSignupToUser($postData, $errorStatus, $errorCode, $errorMessage, $valuesFromDB){
	global $subject_signup_user;
	global $linkToApp;
	
	if ($valuesFromDB != null){ 
		
			$userEmail = $valuesFromDB["email"];
			$userLogin = $valuesFromDB["login"];
			
			
			$myMessage = '<html><body>';
			$myMessage .= "	<div>Dakujeme za registráciu do superschopností </div><br>";
			$myMessage .= " <p>";
		
			$myMessage .= '	<table rules="all" style="border-color: #666;" cellpadding="10">';
			$myMessage .= "		<tr style='background: #eee;'><td><strong>Prihlasovacie meno:</strong> </td><td>" . $userLogin . "</td></tr>";
			$myMessage .= "	</table>";
		
			$myMessage .= "	<div><a href='" . $linkToApp . "'>" . $linkToApp . "</a></div><br>";
		
			$myMessage .= " <p>";
			$myMessage .= " <div>S pozdravom, </div><br>";
			$myMessage .= " <div>tím Libera Terra. </div><br>";
			
			
			$myMessage .= "</body></html>";


			//send mail to USER
			mailPHPMailer_LOCAL($userEmail,  $subject_signup_user,   $myMessage);	
		
	}
	
	// no mail in other way
	
}
//			
function sendMailForgot($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_forgot_admin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "FORGOT PASSWORD ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_forgot_admin . " >> ". $successString, $myMessage);
}
//
function sendMailForgotToUser($postData, $errorStatus, $errorCode, $errorMessage, $valuesFromDB){
	global $subject_forgot_user;
	global $linkToApp;
	global $linkToChangePassword;
	
	if ($valuesFromDB != null){ 
		
			$userEmail = $valuesFromDB["email"];
			$userLogin = $valuesFromDB["login"];
			$userSession = $valuesFromDB["sessionid"];
			$userPassword = $valuesFromDB["password"];
		
			$emailLinkData = array(
    			'sessionid' => $valuesFromDB["sessionid"],
    			'p' => $valuesFromDB["password"],
			);
			
			$emailLink = $linkToChangePassword . '?' . http_build_query($emailLinkData);
		
		//echo "link = " .$emailLink;
		
			/*
				$myMessage = "Zabudnuté údaje pre prihlasenie: <br>";
				$myMessage .= "========================== <br>";
				$myMessage .= "Web: " . $linkToApp . "<br>";
				$myMessage .= "prihlasovacie meno: ".$userLogin . "<br>";
				$myMessage .= "heslo: ".$userPassword . "<br>";
				$myMessage .= "========================== <br>";
				$myMessage .= "Doporucujeme ihned po prihlásení zmenit heslo! <br><br>";
				$myMessage .= "S pozdravom, <br>";
				$myMessage .= "tím Libera Terra. <br>";
			*/
		
		
		
			$myMessage = '<html><body>';
			$myMessage .= "	<div>Zabudnuté údaje pre prihlasenie: </div><br>";
			$myMessage .= " <p>";
		
			$myMessage .= '	<table rules="all" style="border-color: #666;" cellpadding="10">';
			$myMessage .= "		<tr style='background: #eee;'><td><strong>Prihlasovacie meno:</strong> </td><td>" . $userLogin . "</td></tr>";
			$myMessage .= "		<tr><td><strong>Heslo:</strong> </td><td>" . $userPassword . "</td></tr>";
			$myMessage .= "	</table>";
		
			$myMessage .= "	<div><a href='" . $emailLink . "'>" . $emailLink . "</a></div><br>";
		
			$myMessage .= " <p>";
			$myMessage .= " <div>Doporucujeme ihned po prihlásení zmenit heslo! </div><br><br>";
			$myMessage .= " <div>S pozdravom, </div><br>";
			$myMessage .= " <div>tím Libera Terra. </div><br>";
			
			
			$myMessage .= "</body></html>";


			//send mail to USER
			mailPHPMailer_LOCAL($userEmail,  $subject_forgot_user,   $myMessage);	
		
	}
	
	// no mail in other way
	
}
//
//			
function sendMailAutologin($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_autologin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "AUTLOLOGIN ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_autologin . " >> ". $successString, $myMessage);
}
//
//			
function sendMailAutologinLogged($postData, $errorStatus, $errorCode, $errorMessage, $subjectMessage){
	global $to;
	global $subject_autologin;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "AUTLOLOGIN ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	//send mail to ADMIN
	mailPHPMailer_LOCAL($to,$subject_autologin . " >> ". $successString . " >> " . $subjectMessage, $myMessage);
}
//
function sendMailtest($postData, $errorStatus, $errorCode, $errorMessage){
	global $to;
	global $subject_api_call_progress;
	global $errorMessageIgnored;
	
	$successString = ($errorStatus?"OK":"NOK");
	
	$myMessage = "TEST ";
	$myMessage .= "<HR>";
	
	$myMessage .= "Success: " . $successString . "<br>";
	$myMessage .= "errorCode: ".$errorCode . "<br>";
	$myMessage .= "errorMessage: ".$errorMessage . "<br>";
	$myMessage .= "errorMessageIgnored: ".$errorMessageIgnored . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "POST DATA: <br>" . $postData . "<br>";
	$myMessage .= "<HR>";
	
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";


	mailPHPMailer_LOCAL($to,$subject_api_call_progress . " >> ". $successString, $myMessage);
}




//////////////// MAIL FUNCTIONS GENERAL ////////////////////

function spyMail($myVarName, $myVarValue){
	global $to;

	$myTo =  $to;	
	$mySubject = "DEBUG MAIL ".$_SERVER["SERVER_NAME"]." [".getTimeStamp()."]";

	$myMessage = "Debug data from: ";
	$myMessage .= "<HR>";
	$myMessage .= $myVarName.": ".$myVarValue;
	$myMessage .= "<HR>";
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	mailPHPMailer_LOCAL($myTo, $mySubject , $myMessage);

}


function mailDataError($myErrorStr, $myValuesArray){
	global $to;

	$myValuesList = implode("|<BR>", $myValuesArray);
	
	$myTo =  $to;
	$mySubject = "*** DATA ERROR MAIL ".$_SERVER["SERVER_NAME"]." [".getTimeStamp()."]";

	$myMessage = "***** DATA ERROR OCCURED *****";
	$myMessage .= "<HR>";
	$myMessage .= "Script: ".$_SERVER["SERVER_NAME"]."".$_SERVER['PHP_SELF']."<HR>";	
	$myMessage .= "Error: ".$myErrorStr."<HR>";
	$myMessage .= "Values: <BR>".$myValuesList."<HR>";		
	$myMessage .= "<HR>";
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	mailPHPMailer_LOCAL($myTo,$mySubject, $myMessage);

}
//
function mailSQLError($mySQL, $myValuesArray, $myException){
	global $to;
	
	$myLine = $myException->getLine();
	$myErrorMsg = $myException->getMessage();
	$myTrace = $myException->__toString();
	$myValuesList = implode("<BR>", $myValuesArray);
	
	$myTo =  $to;
	$mySubject = "*** SQL ERROR MAIL ".$_SERVER["SERVER_NAME"]." [".getTimeStamp()."]";

	$myMessage = "***** SQL ERROR OCCURED *****";
	$myMessage .= "<HR>";
	$myMessage .= "Script: ".$_SERVER["SERVER_NAME"]."".$_SERVER['PHP_SELF']."<br>";	
	$myMessage .= "Line: ".$myLine."<br>";
	$myMessage .= "SQL: ".$mySQL."<HR>";
	$myMessage .= "Error: ".$myErrorMsg."<HR>";
	$myMessage .= "Values: <BR>".$myValuesList."<HR>";	
	$myMessage .= "Trace: ".$myTrace."<br>";	
	$myMessage .= "<HR>";
	$myMessage .= "Date and time: ". getTimeStamp() . "<br>";
	$myMessage .= "Domain [call]: ". $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]<br>";
	$myMessage .= "Remote IP: ". $_SERVER["REMOTE_ADDR"]."<br>";

	mailPHPMailer_LOCAL($myTo,$mySubject, $myMessage);

}
//
function mailPHPMailer_LOCAL($to, $subject, $message){
	global $bccAlways;
	global $fromEmail;
	global $fromName;
	global $subjecAlways;
	

	//SENDER
	$mail = new PHPMailer();
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Encoding = 'base64';

	$myToListArray = explode(",", $to);
	$mySize = count($myToListArray);
	for ($i = 0; $i < $mySize; $i++){
		$mail->AddAddress($myToListArray[$i]);
	}
	
	//HEADERS
	$mail->Sender = $fromEmail;
	$mail->From     =  $fromEmail;
	$mail->FromName =  $fromName;
	
	

	//ALWAYS TO BCC
	$mail->addBCC($bccAlways);	
	

	//SUBJECT + MESSAGE
	$mail->Subject = $subjecAlways.$subject;
	$mail->Body    =  $message ;
	$mail->AltBody = "This is a HTML mail";

	$mail->WordWrap = 50;
		
	//SEND
	if(!$mail->send()) {
		//echo 'Message was not sent.';
		//echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
		//echo 'Message has been sent.';
	}

}


//////////////// HASH FUNCTIONS ////////////////////

function makeSessionID(){
	$mySessionLength = 64;
	$mySession = "vvr_";
    $myCharactersAll = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $myLen = strlen($myCharactersAll);
    for ($i = 0; $i < $mySessionLength; $i++) {
        $mySession = $mySession.$myCharactersAll[rand(0, $myLen - 1)];
    }
	return $mySession;
}

function makeActivationID(){
	$mySessionLength = 128;
	$mySession = "vva_";
    $myCharactersAll = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $myLen = strlen($myCharactersAll);
    for ($i = 0; $i < $mySessionLength; $i++) {
        $mySession = $mySession.$myCharactersAll[rand(0, $myLen - 1)];
    }
	return $mySession;
}

//////////////// DATE FUNTIONS /////////////////////////////////

function getTimeStamp(){
	$today = getdate();
	$day = $today['mday'];
	$month = $today['mon'];
	$year = $today['year'];
	$hour = $today['hours'];
	$minute = $today['minutes'];
	$seconds = $today['seconds'];
	if ($day < 10)  $day = '0'.$day;
	if ($month < 10)  $month = '0'.$month;
	if ($hour < 10)  $hour = '0'.$hour;
	if ($minute < 10)  $minute = '0'.$minute;
	if ($seconds < 10)  $seconds = '0'.$seconds;
	$datetime = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$seconds;
	return $datetime;
}


//////////////// STRING FUNTIONS /////////////////////////////////

function parseSpecialXMLchars($myStr){
	$myXMLStr = utf8_encode($myStr);
return $myXMLStr;
}

function parseSpecialXMLcharsBack($myXMLStr){
	$myStr = utf8_decode($myXMLStr);
return $myStr;
}

function cleanUpSQLStr($mySQLStr){
	$myStr = str_replace("'","`",$mySQLStr);
	$myStr = str_replace(";","",$myStr);
return $myStr;
}


function cleanUpHTMLStr($myHTMLStr){
	$myStr = $myHTMLStr;
	$myStr = str_replace("<p>"," ",$myStr);
	$myStr = str_replace("</p>"," ",$myStr);
return $myStr;
}


function formatMoney($myValue){
	$myValueP = str_replace (".", "", $myValue);
	$myValueP = str_replace (",", ".", $myValueP);
	return number_format($myValueP, 2, ',', '.');
}


//////////////// DB FUNTIONS /////////////////////////////////
function connectDB_PDO(){
	
	global $DataBase_host;
	global $DataBase_user;
	global $DataBase_password;
	global $DataBase_name;
	global $PDO;
	
	$myDBConnectSuccess = true;

	try {
		$PDO = new PDO("mysql:dbname=".$DataBase_name.";host=".$DataBase_host, $DataBase_user, $DataBase_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
		} catch (PDOException $ex) {
			//echo 'Connection failed: ' . $ex->getMessage();
			$myDBConnectSuccess = false;
		}

	if ($myDBConnectSuccess){
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
		
	return $myDBConnectSuccess;
}


//////////////// ERRORS /////////////////////////
function setError($inputCode, $inputMessage){
	global $errorStatus, $errorCode, $errorMessage, $errorNr;
	
	$errorStatus = false;
	$errorCode = $inputCode;
	$errorMessage = $inputMessage;			
	$errorNr++;
	
}
//
function resetErrors(){
	global $errorStatus, $errorCode, $errorMessage, $errorNr;
	
	$errorStatus = true;
	$errorCode = 0;
	$errorMessage = "";
	$errorMessageIgnored = "";
	$errorNr = 0;
	
}
//
function addErrorIgnored($inputCode, $inputMessage){
	global $errorStatus, $errorCode, $errorMessage, $errorMessageIgnored, $errorNr;
	
	//$errorStatus = false;
	//$errorCode = $inputCode;
	//$errorMessage = $inputMessage;
	$errorMessageIgnored = $errorMessageIgnored . "\n<br> " . $inputCode . " ==>> " . $inputMessage;
	$errorNr++;
	
}

function isError(){
	global $errorStatus;
	
	return (!$errorStatus);
}


//////////////// API TESTING /////////////////////////

//
function fncPDOTestResults($sessionid, $testName,$startTime,$endTime,$duration,$nrOfQuestions,$goodAnswers,$clientId,$JSON,$testCode){
	global $PDO;
	global $sessionIDTimeout;
	
	try {
			
			$sql = "SELECT * FROM users WHERE sessionid = ? AND active = 1";
			
			$stmt = $PDO->prepare($sql);
			$stmt->execute([$sessionid]);			
			$result = $stmt->fetch();
			
			if ($result){
				
				$userid = $result["userid"];
				
				//log inlog
				$sql = "INSERT INTO results (`userid`, `clientId`, `testName`,`testTimeStart`,`testTimeEnd`,`testTimeTotalSeconds`,`testResultCounter`,`testResultGoodCounter`,`testAnswers`,`testCode`) VALUES (?,?,?,?,?,?,?,?,?,?)";
				
				if ($PDO->prepare($sql)->execute([$userid, $clientId, $testName,$startTime, $endTime,$duration,$nrOfQuestions,$goodAnswers,$JSON,$testCode])){
					//$testNr = $PDO->lastInsertId();
				}
				
			} else {
				
				//log inlog
				$sql = "INSERT INTO results (`clientId`, `testName`,`testTimeStart`,`testTimeEnd`,`testTimeTotalSeconds`,`testResultCounter`,`testResultGoodCounter`,`testAnswers`,`testCode`) VALUES (?,?,?,?,?,?,?,?,?)";
				
				if ($PDO->prepare($sql)->execute([$clientId, $testName,$startTime, $endTime,$duration,$nrOfQuestions,$goodAnswers,$JSON,$testCode])){
					//$testNr = $PDO->lastInsertId();
				}
			}
	
	} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(1, "This is error from fncPDOTestResults, Error is: " . $e-> getmessage());
	}	 		

}
//
function fncPDOClientLog($myCallURL,$myOs,$myOsVersion,$myBrowser,$myBrowserVersion,$myEngine,$myDevice,$myDeviceType,$myDeviceVendor,$myUserAgent,$myResolution,$myColorDepth,$ip,$host){
	global $PDO;
	
	$clientID = 0;
	
	try {
			//log inlog
			$sql = "INSERT INTO client (`url`, `ip`,`host`,`os`,`os_version`,`browser`,`browser_version`,`engine`,`engine_version`,`device`,`device_vendor`,`resolution`,`color_depth`,`user_agent`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			
			if ($PDO->prepare($sql)->execute([$myCallURL, $ip,$host, $myOs,$myOsVersion,$myBrowser,$myBrowserVersion,$myEngine,$myDeviceType,$myDevice,$myDeviceVendor,$myResolution,$myColorDepth, $myUserAgent])){
				$clientID = $PDO->lastInsertId();
			}
			
	} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(1, "This is error from fncPDOClientLog, Error is: " . $e-> getmessage());
	}	 		
	
	
	return $clientID;

}
//
function fncPDOChangeParent($userid, $email, $username, $sessionid, $userPasswordNew){
	global $PDO;
	
	try {
		
						$sql = "SELECT * FROM users WHERE userid = ? and sessionid = ? AND active = 1";
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$userid, $sessionid]);
						$result = $stmt->fetch();
												
							if ($result){
		
									$emailOld = $result["email"];
									$userid = $result["userid"];
		
									//$sessionid = uniqid();
		
										//update session id
										$sqlUpdate = "UPDATE users SET email=?, login=?, password=? WHERE userid=?";
										
										if ($PDO->prepare($sqlUpdate)->execute([$email, $username, $userPasswordNew, $userid])){
											//backup login
											//backupDataComplete("update", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
											
											$result['emailOld'] = $emailOld;
											$result['email'] = $email;
											$result['password'] = $userPasswordNew;
											
										}
						
									return $result;			
							
							} else {
		
								//user doesn't exists in DB or session is not correct
								return null;
							}
			
		} catch (PDOexception $e) {

		  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChangeParent, Error is: " . $e-> getmessage());
		}	 		 		
		

		return null;
	
}
//
function fncPDORegisterParent($email, $username, $userPasswordNew){
	global $PDO;
	
	try {
		
						$sql = "SELECT * FROM users WHERE email = ? or login = ?";
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$email, $username]);
						$result = $stmt->fetch();
												
							if (!$result || $result["active"] == 0){
		
								$sessionid = uniqid();
								$sqlInsert = 0;
								
								
								if (!$result) {
									//insert new parent
									$sqlInsert = "INSERT INTO users (login, email, password, type, sessionid, sessiontimestamp) VALUES (?,?,?, 'parent', ?, CURRENT_TIMESTAMP)";
									$stmt = [$username, $email, $userPasswordNew, $sessionid];
								} else {
									$sqlInsert = "UPDATE users SET login = ?, email = ?, password = ?, sessionid = ?,sessiontimestamp = CURRENT_TIMESTAMP, active = 1 WHERE email = ? or login = ?";
									$stmt = [$username, $email, $userPasswordNew, $sessionid, $email, $username];
								}
								
								if ($PDO->prepare($sqlInsert)->execute($stmt) ){

									//select new user
									$sqlUser = "SELECT * FROM users WHERE email = ?";
			
									$stmtUser  = $PDO->prepare($sqlUser);
									$stmtUser->execute([$email]);
						
									$resultUser = $stmtUser->fetch();

												if ($resultUser){
	
															$userid = $resultUser["userid"];
													
															//backup login
															//backupDataComplete("insert", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
													
															return $resultUser;
													
												} else {
																										
													setError(700, "User is not correctly set (email='$email')");
												}
												
								}
				
							} else {
								
								//user already exists in DB
								return null;
							}
			
		} catch (PDOexception $e) {

				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncLoginPDO, Error is: " . $e-> getmessage());
		}	 		 		
		

		return null;
	
}
//
function fncPDOChangePassword($userPasswordOld, $userPasswordNew, $sessionid){
	global $PDO;
	
	$sql = "SELECT * FROM users WHERE sessionid = ? and password = ?  AND active = 1";
	
	try {
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$sessionid, $userPasswordOld]);
			
						$result = $stmt->fetch();
						
							if ($result){
								$sessionid = uniqid();
								$userid = $result["userid"];
			
	
								//update session id
								$sqlUpdate = "UPDATE users SET password=?, sessionid=?, sessiontimestamp=CURRENT_TIMESTAMP WHERE userid=?  AND active = 1";
								
								if ($PDO->prepare($sqlUpdate)->execute([$userPasswordNew, $sessionid, $userid])){
									//backup login
									//backupDataComplete("update", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
									
									$result['sessionid'] = $sessionid;
									$result['password'] = $userPasswordNew;
									
								}
					
					
								return $result;			
								
							} else {
								
								//no user in DB
								return null;
							}
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChangePassword, Error is: " . $e-> getmessage());
		}	 		 		
		
		return null;
	
	
	
}
//
function fncPDORegisterChild($parentid, $firstname, $lastname, $username, $userPasswordNew, $class){
	global $PDO;
	
	try {
		
						$sql = "SELECT * FROM users WHERE login = ?";
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$username]);
						$result = $stmt->fetch();
												
							if (!$result || $result["active"] == 0){
		
								$sessionid = uniqid();
								$sqlInsert = 0;
								
								if (!$result) {
									//insert new parent
									$sqlInsert = "INSERT INTO users (parentid, firstname, lastname, login, password, class, type) VALUES (?,?,?,?,?,?, 'child')";
									$stmt = [$parentid, $firstname, $lastname, $username, $userPasswordNew, $class];
								} else {
									$sqlInsert = "UPDATE users SET parentid = ?, firstname = ?, lastname = ?, password = ?, class = ?, active = 1 WHERE login = ?";
									$stmt = [$parentid, $firstname, $lastname, $userPasswordNew, $class, $username];
								}
								if ($PDO->prepare($sqlInsert)->execute($stmt) ){
						
									//select new user
									$sqlUser = "SELECT * FROM users WHERE login = ?";
			
									$stmtUser  = $PDO->prepare($sqlUser);
									$stmtUser->execute([$username]);
						
									$resultUser = $stmtUser->fetch();
									

												if ($resultUser){
	
															$userid = $resultUser["userid"];
															
															//delete all exist exercises									
															$sqlInsert = "DELETE FROM exercises WHERE userid = ?";
															$stmt = [$userid];
															$PDO->prepare($sqlInsert)->execute($stmt);
													
															//backup login
															//backupDataComplete("insert", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
													
															return $resultUser;
													
												} else {
																										
													setError(700, "User is not correctly set (email='$email')");
												}
												
								}
				
							} else {
								
								//user already exists in DB
								return null;
							}
			
		} catch (PDOexception $e) {

				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncLoginPDO, Error is: " . $e-> getmessage());
		}	 		 		
		

		return null;
	
}
//
//
function fncPDORemoveParent($parentid){
	global $PDO;
	
		try {
		
						$sql = "SELECT * FROM users WHERE userid = ? AND active = 1";
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$parentid]);
						$result = $stmt->fetch();
												
							if ($result){
								
								$sqlUpdate = "UPDATE users SET active = 0, inclog = 0 WHERE userid = ?";
								
								if ($PDO->prepare($sqlUpdate)->execute([$parentid]) ){
								
										//backup remove parent
										//backupDataComplete("update", "users", array("userid" => $parentid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$parentid')");
								
										
											//remove all children
											$sqlUpdateChildren = "UPDATE users SET active = 0, inclog = 0 WHERE parentid = ?";
											
											
											if ($PDO->prepare($sqlUpdateChildren)->execute([$parentid]) ){
												//backup remove children
												//backupDataComplete("update", "users", array("parentid" => $parentid), "sessiontimestamp", "INSERT INTO users (`parentid`) VALUES ('$parentid')");
											}
									
											return $result;
																	
								} else {
									//update is not performed	
									return null;
									
								}
								
							} else {
								
								//user not exists in DB
								return null;
							}
		
		} catch (PDOexception $e) {

				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChangeChild, Error is: " . $e-> getmessage());
		}	 		 		
		

		return null;

}
//
function fncPDORemoveChild($parentid, $userid){
	global $PDO;
	
		try {
		
						$sql = "SELECT * FROM users WHERE userid = ? AND parentid = ? AND active = 1";
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$userid, $parentid]);
						$result = $stmt->fetch();
												
							if ($result){
								
								$sqlUpdate = "UPDATE users SET active = 0, inclog = 0 WHERE userid = ?";
								
								if ($PDO->prepare($sqlUpdate)->execute([$userid]) ){
								
										//backup remove
										//backupDataComplete("update", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
								
										
											//get session id from parent
											$sqlParent = "SELECT * FROM users WHERE userid = ? AND active = 1";
			
											$stmtParent  = $PDO->prepare($sqlParent);
											$stmtParent->execute([$parentid]);
											$resultParent = $stmtParent->fetch();
																	
												if ($resultParent){
													
													return $resultParent;
													
												}
																	
								} else {
									//update is not performed	
									return null;
									
								}
								
							} else {
								
								//user not exists in DB
								return null;
							}
		
		} catch (PDOexception $e) {

				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChangeChild, Error is: " . $e-> getmessage());
		}	 		 		
		

		return null;

}
//
function fncPDOChangeChild($parentid, $userid, $firstname, $lastname, $username, $userPasswordNew, $class){
	global $PDO;
	
	try {
		
						$sql = "SELECT * FROM users WHERE userid = ? AND parentid = ? AND active = 1";
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$userid, $parentid]);
						$result = $stmt->fetch();
												
							if ($result){
								
									$sqlUpdate = "UPDATE users SET firstname = ?, lastname = ?, login = ?, password = ?, class = ?, inclog = 0 WHERE userid = ?";
									
							
								if ($PDO->prepare($sqlUpdate)->execute([$firstname, $lastname, $username, $userPasswordNew, $class, $userid]) ){
								
										//backup login
										//backupDataComplete("update", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
								
										return "OK";
												
								}
				
							} else {
								
								//user not exists in DB
								return null;
							}
			
		} catch (PDOexception $e) {

				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChangeChild, Error is: " . $e-> getmessage());
		}	 		 		
		

		return null;
	
}
//
function fncPDOLogin($userLogin){
	global $PDO;
	
	
		$sql = "SELECT * FROM users WHERE (login = ? or email = ?) AND active = 1";
		
		try {
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$userLogin,$userLogin]);
			
						$result = $stmt->fetch();
						
						//print_r($result);						
						
							if ($result){
							
							
								$sessionid = uniqid();
								$userid = $result["userid"];
			
								//update session id
								$sqlUpdate = "UPDATE users SET sessionid=?, sessiontimestamp=CURRENT_TIMESTAMP WHERE userid=?";
								
								if ($PDO->prepare($sqlUpdate)->execute([$sessionid, $userid])){
									//backup login
									////backupDataComplete("update", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
									
									$result['sessionid'] = $sessionid;
									
								}
						
								return $result;			
								
							} else {
								
								//no user in DB
								return null;
							}
			
		} catch (PDOexception $e) {
				  
				  echo "Error is: " . $e-> getMessage();	   
				  
				  setError(0, "This is error from fncLoginPDO, Error is: " . $e-> getmessage());
		}	 		 		
		
		return null;
	
}
//
function fncPDOChildIncLog($userId, $inclog){
	global $PDO;
	
	
		$sql = "UPDATE users SET inclog = ? WHERE userid = ? AND active = 1";
	
		try {
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$inclog+1,$userId]);
			
						$result = $stmt->fetch();
							if ($result){							
					
								return "update";			
								
							} else {
								
								//no user in DB
								return null;
							}
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncLoginPDO, Error is: " . $e-> getmessage());
		}	 		 		
		
		return null;
	
}
//
function fncPDOUserLog($userid,$myCallURL,$myOs,$myOsVersion,$myBrowser,$myBrowserVersion,$myEngine,$myDevice,$myDeviceType,$myDeviceVendor,$myUserAgent,$myResolution,$myColorDepth,$ip,$host){
	global $PDO;
	
	try {
			//log inlog
			$sql = "INSERT INTO users_log (`userid` , `url`, `ip`,`host`,`os`,`os_version`,`browser`,`browser_version`,`engine`,`engine_version`,`device`,`device_vendor`,`resolution`,`color_depth`,`user_agent`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			
			if ($PDO->prepare($sql)->execute([$userid,$myCallURL, $ip,$host, $myOs,$myOsVersion,$myBrowser,$myBrowserVersion,$myEngine,$myDeviceType,$myDevice,$myDeviceVendor,$myResolution,$myColorDepth, $myUserAgent])){
				
				//backup inlog
				////backupDataComplete("insert", "users_log", array("userid" => $userid), "timestamp", "INSERT INTO users_log (`userid`) VALUES ('$userid')");
				
			}
			
	} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(1, "This is error from fncUserLogPDO, Error is: " . $e-> getmessage());
	}	 		

}
//
function fncPDOcheckLogin($sessionid){
	global $PDO;
	global $sessionIDTimeout;
	
	try {
			
					$sql = "SELECT * FROM users WHERE sessionid = ? AND active = 1";
					
					$stmt = $PDO->prepare($sql);
					$stmt->execute([$sessionid]);			
					$result = $stmt->fetch();
					
					if ($result){
						if ((strtotime($result["sessiontimestamp"]) + ($sessionIDTimeout) >= time()) || ($sessionid == "liberaterraFree") ){
							return $result;
						} else {
						 	setError(400, "Session timestamp expired!");
						}
					} else {
						//no sessionid in DB
					 	return null;
					}
			
	} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(3, "This is error from fncCheckLoginPDO, Error is: " . $e-> getmessage());
	}
	return null;
}
//
function fncPDOcheckLoginExternUser($externuserid){
	global $PDO;
	global $sessionIDTimeout;
	
	try {
			
					$sql = "SELECT * FROM users WHERE userid_extern = ? AND active = 1";
					
					$stmt = $PDO->prepare($sql);
					$stmt->execute([$externuserid]);			
					$result = $stmt->fetch();
					
					if ($result){
						
						//MAJO urob
						$sessionid = uniqid();
						$userid = $result["userid"];
			
							//update session id
							$sqlUpdate = "UPDATE users SET sessionid=?, sessiontimestamp=CURRENT_TIMESTAMP WHERE userid=?";
								
							if ($PDO->prepare($sqlUpdate)->execute([$sessionid, $userid])){
								//backup login
								//backupDataComplete("update", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
							}
								
							$result["sessionid"] = $sessionid;
							
							return $result;			
						
					} else {
						//no userid_extern in DB
					 	return null;
					}
			
	} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(3, "This is error from fncCheckLoginPDO, Error is: " . $e-> getmessage());
	}
	return null;
}
//
function fncPDOgetLastTest($userid){
	global $PDO;
	global $sessionIDTimeout;
	
	try {
			
			$sql = "SELECT exerciseJSON FROM exercises WHERE userid = ? ORDER BY timestamp DESC LIMIT 1;";
			
			$stmt = $PDO->prepare($sql);
			$stmt->execute([$userid]);			
			$result = $stmt->fetch();
			
			if ($result){
					return $result["exerciseJSON"];
			} else {
				//no exerciseJSON in DB
			 	return "";
			}
			
	} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(3, "This is error from fncCheckLoginPDO, Error is: " . $e-> getmessage());
	}
	return "";
}
//
function fncPDOGetSchoolType($userid){
	global $PDO;
	
		$sql = "SELECT cl.classType FROM classes cl, users_to_classes ucl WHERE cl.classid = ucl.classid AND ucl.userid = ?";
	
		try {
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$userid]);
			
						$result = $stmt->fetch();
						
							if ($result){
								return $result["classType"];		
							} else {
								return '';
							}
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(5, "This is error from fncPDOGetSchoolType, Error is: " . $e-> getmessage());
		}	 		 		
		
		return 0;
}
//
function fncPDOGetNrOfChildren($parentid){
	global $PDO;
	
		$sql = "SELECT count(*) as counter FROM users WHERE parentid = ? AND active = 1";
	
		try {
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$parentid]);
			
						$result = $stmt->fetch();
						
							if ($result){
								return $result["counter"];		
							} else {
								return 0;
							}
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(2, "This is error from fncPDOGetNrOfChildren, Error is: " . $e-> getmessage());
		}	 		 		
		
		return 0;
}
//
function fncPDOForgot($userEmail){
	global $PDO;
	
	
		$sql = "SELECT * FROM users WHERE email = ? AND active = 1";
	
		try {
			
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$userEmail]);
			
						$result = $stmt->fetch();
						
							if ($result){
								$sessionid = uniqid();
								$userid = $result["userid"];
			
								//update session id
								$sqlUpdate = "UPDATE users SET sessionid=?, sessiontimestamp=CURRENT_TIMESTAMP WHERE userid=?";
								
								if ($PDO->prepare($sqlUpdate)->execute([$sessionid, $userid])){
									//backup login
									//backupDataComplete("update", "users", array("userid" => $userid), "sessiontimestamp", "INSERT INTO users (`userid`) VALUES ('$userid')");
								}
								
								
								$result["sessionid"] = $sessionid;
								
								return $result;			
								
							} else {
								
								//no user in DB
								return null;
							}
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOForgot, Error is: " . $e-> getmessage());
		}	 		 		
		
		return null;
	
}
//
//
function fncPDOStudentsExerciseData($parentSessionID) {
	global $PDO;
	
	try {
						// get parent id
						$sql = "SELECT userid FROM users WHERE sessionid = ? AND active = 1";
						
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$parentSessionID]);
			
						$result = $stmt->fetch();
						
						if($result){
						
										// get children ids
										$sql = "SELECT u.userid, u.firstname, u.lastname, c.classname FROM users u, users_to_classes uc, classes c WHERE c.teacherid = ? AND u.active = 1 AND u.userid=uc.userid AND c.classid = uc.classid";
										$stmt  = $PDO->prepare($sql);
										$stmt->execute([$result["userid"]]);
										
										
										$result = $stmt->fetchAll();					
										
										if($result){
										
											// get children data
											$childrenData = array();
											
											foreach($result as $row) {
											   	$sql = "SELECT * FROM results WHERE userid = ? ORDER BY timestamp DESC";
											   	
											   	$stmt  = $PDO->prepare($sql);
													$stmt->execute([$row["userid"]]);
													
													if ($row["userid"]){					
														$childrenData[$row["userid"]] = array('firstName' => $row["firstname"], 'lastname' => $row["lastname"], 'classname' => $row["classname"], 'data' => $stmt->fetchAll());
													}
											}	
											
											return $childrenData;
											
										} else {
											return null;
										}					
												
						} else {
							return null;
						}
						
						
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChildData, Error is: " . $e-> getmessage());
		}	 		 		
}
//
function fncPDOChildTestData($parentSessionID) {
	global $PDO;
	
		try {
						// get parent id
						$sql = "SELECT userid FROM users WHERE sessionid = ? AND active = 1";
						
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$parentSessionID]);
			
						$result = $stmt->fetch();
						
						if($result){
						
							// get children ids
							$sql = "SELECT userid, firstname, class FROM users WHERE parentid = ? AND active = 1";
							
							$stmt  = $PDO->prepare($sql);
							$stmt->execute([$result["userid"]]);
							
							$result = $stmt->fetchAll();					
							
							if($result){
							
								// get children data
								$childrenData = array();
								
								for ($i = 0; $i < 3; $i++) {
								   	$sql = "SELECT * FROM results WHERE userid = ? ORDER BY timestamp DESC";
								   	
								   	$stmt  = $PDO->prepare($sql);
										$stmt->execute([$result[$i]["userid"]]);
										
										if ($result[$i]["userid"])								
											$childrenData[$result[$i]["firstname"]] = $stmt->fetchAll();
								}	
								
								
								return $childrenData;
								
							} else {
								return null;
							}							
						} else {
							return null;
						}
						
						
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChildData, Error is: " . $e-> getmessage());
		}	 		 		
}
//
function fncPDOChildUserData($parentSessionID) {
	global $PDO;
	
	try {
						// get parent id
						$sql = "SELECT userid,email,login FROM users WHERE sessionid = ? AND active = 1";
						
						$stmt  = $PDO->prepare($sql);
						$stmt->execute([$parentSessionID]);
			
						$resultParent = $stmt->fetch();
						if($resultParent){
						
							// get children ids
							$sql = "SELECT * FROM users WHERE parentid = ? AND active = 1";
							
							$stmt  = $PDO->prepare($sql);
							$stmt->execute([$resultParent["userid"]]);
							
							$dataResult = [];  
							
							$result = $stmt->fetchAll();
							
							for ($i = 0; $i < count($result); $i++) {
							 	  $dataResult[$result[$i]["firstname"]] = $result[$i];
							}
							
							$dataResult["parent"] = $resultParent;
							
							return $dataResult;
											
						} else {
							return null;
						}
						
						
			
		} catch (PDOexception $e) {
				  // echo "Error is: " . $e-> etmessage();	   
				  setError(0, "This is error from fncPDOChildData, Error is: " . $e-> getmessage());
		}	 		 		
}

?>