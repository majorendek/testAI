<?php
/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 17.12.2019

_backupActions.php
*/

//////////////////////////////////////////////////////////////
//////////////// USING       /////////////////////////////////
//////////////////////////////////////////////////////////////

/*
//BACKUP CALL
	try {
		//backupData($action, $table, $arrayIDs, $timestampField);
		backupData("update", "users", array("userid" => "1", "sessionid" => "dsf5sdf4dsf5dsf"), "timestamp");
	} catch (Exception $e) {
		//
	}

wheras

$action is from [insert, update, replace, delete]
$table is one of the table name
$arrayIDs is array of unique identificator to retrieve particular row
*/

//////////////////////////////////////////////////////////////
//////////////// SETTINGS    /////////////////////////////////
//////////////////////////////////////////////////////////////

// SEE config.php
define("SERVER", "production"); //MUST BE DEFINED!!!

//DB BACKUP definition


//production - customers.turnpages.sk
define("DB_HOST", "localhost");
define("DB_USER", "usr_lt_suprs_bck");
define("DB_PASS", "yYbW3uZ8GB");
define("DB_NAME", "lt_superschopnosti_backup");

/*
//rendek.eu
define("DB_HOST", "localhost");
define("DB_USER", "rendekeubackupsu");
define("DB_PASS", "yYbW3uZ8GB");
define("DB_NAME", "rendekeubackupsuperschopnosti");
*/

/*
Databáza: rendekeubackupsuperschopnosti
Hostiteľ: uvdb23.active24.cz
Login: rendekeubackupsu
*/


$acceptedLogTables = array(
	"exercises", 
	"users", 
	"users_log",
	"user_payment"
);


//////////////////////////////////////////////////////////////
//////////////// CLASSES /////////////////////////////////////
//////////////////////////////////////////////////////////////

class Database {
    
    private $dbh;
    private $error;
    private $stmt;
    
    public function __construct($host, $user, $pass, $dbname)
    {
        // Set DSN
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        //Create a new PDO instance
        try {
            $this->dbh = new PDO($dsn, $user, $pass, $options);
        }
        // Catch any errors
        catch(PDOException $e) {
            $this->error = $e->getMessage();
        }
    }
    
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }
    
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
	
	public function quote($string){ 
		return $this->dbh->quote($string);
	}
    
    public function execute()
    {
        return $this->stmt->execute();
    }
    
    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
    
    /**
     * Transactions allow multiple changes to a database all in one batch.
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }
     
    public function endTransaction()
    {
        return $this->dbh->commit();
    }
    
    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }
    
    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }
}

	
//////////////////////////////////////////////////////////////
//////////////// FUNCTIONS ///////////////////////////////////
//////////////////////////////////////////////////////////////
function backupDataComplete($action, $tableName, $arrayIDs, $timestampField, $queryString){
	global $db_source;
	global $db_backup;
	global $acceptedLogTables;
	

	
	if (in_array($tableName, $acceptedLogTables)) {
    
	
		//SOURCE DB >> make PDO select statement
		$sourceQuery = " SELECT * FROM " . $tableName . " WHERE 1 = 1 ";
			foreach ($arrayIDs as $name => $value) {$sourceQuery .= " AND $name= :$name ";}
			if ($timestampField != ""){
				$sourceQuery .= " ORDER BY $timestampField DESC ";
			}
			
		$db_source->query($sourceQuery);
		//print $db_source."<br>";
	
		//SOURCE DB >> add PDO select values
			foreach ($arrayIDs as $name => $value) {$db_source->bind(':'.$name , $value);}
		$db_source->execute();
		//$db_source->debugDumpParams();		
		
		if ($db_source->rowCount() > 0){
			//SOURCE DB >> retrieve only one result 
			$row = $db_source->single();
				
			//BACKUP DB - make insert statement
			$backupQuery = " INSERT INTO " . $tableName . " ( log_server, log_page, log_action, log_query, log_params ";
				foreach ($row as $name => $value) {$backupQuery .= ", $name ";}
			$backupQuery .= " ) VALUES ( :log_server, :log_page, :log_action,  :log_query, :log_params";
				foreach ($row as $name => $value) {$backupQuery .= ", :$name ";}
			$backupQuery .= " ) ";
			
			$db_backup->query($backupQuery);
			//print $backupQuery."<br>";
			
			//BACKUP DB >> add PDO insert values
				$db_backup->bind(':log_server' , SERVER);
				$db_backup->bind(':log_page' , $_SERVER['REQUEST_URI']);
				$db_backup->bind(':log_action' , $action);
				$db_backup->bind(':log_query' , $queryString);
				$db_backup->bind(':log_params' , $GLOBALS["HTTP_RAW_POST_DATA"]);

				
	
				foreach ($row as $name => $value) {$db_backup->bind(':'.$name , $value);}
			$db_backup->execute();
			
		}
	
	} 
	
}

function backupMultipleDataComplete($action, $tableName, $arrayIDs, $queryString){
	global $db_source;
	global $db_backup;
	global $acceptedLogTables;
	

	
	if (in_array($tableName, $acceptedLogTables)) {
    
	
		//SOURCE DB >> make PDO select statement
		$sourceQuery = " SELECT * FROM " . $tableName . " WHERE 1 = 1 ";
			foreach ($arrayIDs as $name => $value) {$sourceQuery .= " AND $name= :$name ";}
		$db_source->query($sourceQuery);
		//print $db_source."<br>";
	
		//SOURCE DB >> add PDO select values
			foreach ($arrayIDs as $name => $value) {$db_source->bind(':'.$name , $value);}
		$db_source->execute();
		//$db_source->debugDumpParams();		
		
		if ($db_source->rowCount() > 0){
			//SOURCE DB >> retrieve only one result 
			//SOURCE DB >> retrieve all results
			$rows = $db_source->resultset();
			
			foreach ($rows as $row) {
				
					//BACKUP DB - make insert statement
					$backupQuery = " INSERT INTO " . $tableName . " ( log_server, log_page, log_action , log_query, log_params ";
						foreach ($row as $name => $value) {$backupQuery .= ", $name ";}
					$backupQuery .= " ) VALUES ( :log_server, :log_page, :log_action, :log_query, :log_params";
						foreach ($row as $name => $value) {$backupQuery .= ", :$name ";}
					$backupQuery .= " ) ";
					
					$db_backup->query($backupQuery);
					//print $backupQuery."<br>";
					
					//BACKUP DB >> add PDO insert values
						$db_backup->bind(':log_server' , SERVER);
						$db_backup->bind(':log_page' , $_SERVER['REQUEST_URI']);
						$db_backup->bind(':log_action' , $action);
						$db_backup->bind(':log_query' , $queryString);
						$db_backup->bind(':log_params' , $GLOBALS["HTTP_RAW_POST_DATA"]);
				
						//$db_backup->bind(':log_query' , $db_backup->quote($queryString));
						//$db_backup->bind(':log_params' , $db_backup->quote($GLOBALS["HTTP_RAW_POST_DATA"]));
						
						foreach ($row as $name => $value) {$db_backup->bind(':'.$name , $value);}
					$db_backup->execute();
			}
			
		}
	
	} 
	
}


function backupData($action, $tableName, $arrayIDs, $timestampField){
	global $db_source;
	global $db_backup;
	global $acceptedLogTables;
	

	
	if (in_array($tableName, $acceptedLogTables)) {
    
	
		//SOURCE DB >> make PDO select statement
		$sourceQuery = " SELECT * FROM " . $tableName . " WHERE 1 = 1 ";
			foreach ($arrayIDs as $name => $value) {$sourceQuery .= " AND $name= :$name ";}
			if ($timestampField != ""){
				$sourceQuery .= " ORDER BY $timestampField DESC ";
			}
			
		$db_source->query($sourceQuery);
		//print $db_source."<br>";
	
		//SOURCE DB >> add PDO select values
			foreach ($arrayIDs as $name => $value) {$db_source->bind(':'.$name , $value);}
		$db_source->execute();
		//$db_source->debugDumpParams();		
		
		if ($db_source->rowCount() > 0){
			//SOURCE DB >> retrieve only one result 
			$row = $db_source->single();
				
			//BACKUP DB - make insert statement
			$backupQuery = " INSERT INTO " . $tableName . " ( log_server, log_page, log_action ";
				foreach ($row as $name => $value) {$backupQuery .= ", $name ";}
			$backupQuery .= " ) VALUES ( :log_server, :log_page, :log_action ";
				foreach ($row as $name => $value) {$backupQuery .= ", :$name ";}
			$backupQuery .= " ) ";
			
			$db_backup->query($backupQuery);
			//print $backupQuery."<br>";
			
			//BACKUP DB >> add PDO insert values
				$db_backup->bind(':log_server' , SERVER);
				$db_backup->bind(':log_page' , $_SERVER['REQUEST_URI']);
				$db_backup->bind(':log_action' , $action);
				
				foreach ($row as $name => $value) {$db_backup->bind(':'.$name , $value);}
			$db_backup->execute();
			
		}
	
	} 
	
}

function backupMultipleData($action, $tableName, $arrayIDs){
	global $db_source;
	global $db_backup;
	global $acceptedLogTables;
	

	
	if (in_array($tableName, $acceptedLogTables)) {
    
	
		//SOURCE DB >> make PDO select statement
		$sourceQuery = " SELECT * FROM " . $tableName . " WHERE 1 = 1 ";
			foreach ($arrayIDs as $name => $value) {$sourceQuery .= " AND $name= :$name ";}
		$db_source->query($sourceQuery);
		//print $db_source."<br>";
	
		//SOURCE DB >> add PDO select values
			foreach ($arrayIDs as $name => $value) {$db_source->bind(':'.$name , $value);}
		$db_source->execute();
		//$db_source->debugDumpParams();		
		
		if ($db_source->rowCount() > 0){
			//SOURCE DB >> retrieve only one result 
			//SOURCE DB >> retrieve all results
			$rows = $db_source->resultset();
			
			foreach ($rows as $row) {
				
					//BACKUP DB - make insert statement
					$backupQuery = " INSERT INTO " . $tableName . " ( log_server, log_page, log_action ";
						foreach ($row as $name => $value) {$backupQuery .= ", $name ";}
					$backupQuery .= " ) VALUES ( :log_server, :log_page, :log_action ";
						foreach ($row as $name => $value) {$backupQuery .= ", :$name ";}
					$backupQuery .= " ) ";
					
					$db_backup->query($backupQuery);
					//print $backupQuery."<br>";
					
					//BACKUP DB >> add PDO insert values
						$db_backup->bind(':log_server' , SERVER);
						$db_backup->bind(':log_page' , $_SERVER['REQUEST_URI']);
						$db_backup->bind(':log_action' , $action);
						
						foreach ($row as $name => $value) {$db_backup->bind(':'.$name , $value);}
					$db_backup->execute();
			}
			
		}
	
	} 
	
}


function backupDataFirstTime(){
	global $db_source;
	global $db_backup;
	global $acceptedLogTables;
	
	$action = "createFirstTime";
	
	foreach ($acceptedLogTables as $tableName) {
    
		//SOURCE DB >> make PDO select statement
		$sourceQuery = " SELECT * FROM " . $tableName . " WHERE 1 = 1 ";
		$db_source->query($sourceQuery);
		$db_source->execute();
		
		if ($db_source->rowCount() > 0){
			//SOURCE DB >> retrieve all results
			$rows = $db_source->resultset();
			
			foreach ($rows as $row) {
				
				//BACKUP DB - make insert statement
				$backupQuery = " INSERT INTO " . $tableName . " ( log_server, log_page, log_action ";
					foreach ($row as $name => $value) {$backupQuery .= ", $name ";}
				$backupQuery .= " ) VALUES ( :log_server, :log_page, :log_action ";
					foreach ($row as $name => $value) {$backupQuery .= ", :$name ";}
				$backupQuery .= " ) ";
				
				$db_backup->query($backupQuery);
				
				//BACKUP DB >> add PDO insert values
					$db_backup->bind(':log_server' , SERVER);
					$db_backup->bind(':log_page' , $_SERVER['REQUEST_URI']);
					$db_backup->bind(':log_action' , $action);
					
					foreach ($row as $name => $value) {$db_backup->bind(':'.$name , $value);}
				$db_backup->execute();
				
			}
		}

	
	} 
	
}


//////////////////////////////////////////////////////////////
//////////////// MAIN ////////////////////////////////////////
//////////////////////////////////////////////////////////////


//make PDO DB Object
	$db_source = new Database($DBhost, $DBuser, $DBpassword, $DBname);
	$db_backup = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);	

?>