<?php
/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 15.12.2019

config.php
*/

////////////////   GENERAL ////////////////////////////////////////////

	$hashPassword = "63ecd87c72ef8828c1491e2f594cedb9"; //for JSON authorisation use (md5 hash pre frazu "maros")

	$ROOT_PATH = $_SERVER["DOCUMENT_ROOT"];
	$domain = $_SERVER["SERVER_NAME"]." [".$_SERVER['PHP_SELF']."]";
	$sessionIDTimeout = 60*60; // 1 hour

////////////////   CROSS DOMAIN HEADERs //////////////////////////////

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST, GET26");
	header('Access-Control-Allow-Credentials: true');
	header("Access-Control-Allow-Headers: Content-Type, x-requested-with");

	header('Content-Type: application/json');


////////////////   DATABASE ///////////////////////////////////////////

	//production - customers.turnpages.sk

	$DBhost = "localhost";
	$DBuser = "usr_lt_test@customers.turnpages.sk";
	$DBpassword = "6bvhBO5RAU";
	$DBname = "lt_testing";

/*		
	// rendek.eu
	$DBhost = "localhost";
	$DBuser = "rendekeutesting";
	$DBpassword = "6bvhBO5RAU";
	$DBname = "rendekeutesting";
*/

/* 

//// SCRIPT for TEST DB

START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `rendekeutesting`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `url` text DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `host` varchar(50) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL,
  `os_version` varchar(20) DEFAULT NULL,
  `browser` varchar(20) DEFAULT NULL,
  `browser_version` varchar(30) DEFAULT NULL,
  `engine` varchar(20) DEFAULT NULL,
  `engine_version` varchar(20) DEFAULT NULL,
  `device` varchar(20) DEFAULT NULL,
  `device_vendor` varchar(20) DEFAULT NULL,
  `resolution` varchar(20) DEFAULT NULL,
  `color_depth` varchar(20) DEFAULT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `clientId` bigint(20) DEFAULT NULL,
  `testName` varchar(256) DEFAULT NULL,
  `testTimeStart` varchar(50) DEFAULT NULL,
  `testTimeEnd` varchar(50) DEFAULT NULL,
  `testTimeTotalSeconds` int(11) DEFAULT NULL,
  `testResultCounter` int(11) DEFAULT NULL,
  `testResultGoodCounter` int(11) DEFAULT NULL,
  `testAnswers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `testCode` varchar(256) DEFAULT NULL,
  `testDefinition` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;



*/


	$DataBase_host = $DBhost;
	$DataBase_user = $DBuser;
	$DataBase_password = $DBpassword;
	$DataBase_name = $DBname;
	$PDO = NULL;

////////////////  MAIL //////////////////////////////////////////////

  //production
	$to = "marian.rendek.company@gmail.com";
	$bccAlways = "marian.rendek.company@gmail.com";
	
	//link to webpage
	$linkToApp = "http://customers.turnpages.sk/liberaterra/apps/test/modules/login/login.html";
	$linkToChangePassword = "http://customers.turnpages.sk/liberaterra/apps/test/modules/admin/changePassword.html";

	//subject  
	$subjecAlways = "[LiberaTerra Testing]  ";

	//CALL API
	$subject_forgot_admin = " FORGOT ";	
	$subject_forgot_user = " Zabudnuté prihlasovacie údaje ";	
		
	$subject_signup_admin = " SIGNUP ";	
	$subject_signup_user = " Vaša registrácia rodica do superschopností  ";	
		
	$subject_changeParent_admin = " CHANGE PARENT ";
	$subject_removeParent_admin = " REMOVE PARENT ";	
	$subject_remove_parent = " Zmazanie profilu rodica ";	
	
		
	$subject_changeChild_admin = " CHANGE CHILD ";	
	$subject_removeChild_admin = " REMOVE CHILD ";	
	
	//autologin
	$subject_autologin = " AUTOLOGIN ";	
		
	//mail debug/info
	$subjectHeaders = "";
  $subject_error = $subjectHeaders . "Debug/Error/Info ";

	//headers
	$fromEmail = "testing_info@".$_SERVER["SERVER_NAME"];
	$fromName = "Libera Terra - TEST"
	

?>