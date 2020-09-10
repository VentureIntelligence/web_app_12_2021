<?php

include_once MODULES_DIR."ezSQL/ez_sql_core.php";
// Include ezSQL database specific component
include_once MODULES_DIR."ezSQL/ez_sql_mysql.php";

class database {
	 
	var $db;
	var $connected = false;
	var $error = NULL;
	var $error_type = "";
	var $fetchMode = "ROW";	
	var $result;
	// define file pointer
	var $fp = null;



	// Connect to database 
	function database() { //echo DB_SERVER.DB_USER.DB_PASSWORD;die;
            
			$this->db = @mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
			if(mysql_error()) {
				$this->error = mysql_error();
			} else {
				if(@mysql_select_db(DB_DATABASE_NAME)){                                       
					$this->connected = true;
                                }
				else {
					$this->error = mysql_error();
                                }
			}
			$this->db_n = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_DATABASE_NAME,DB_SERVER);
		print $this->error;
	
	}//Function Ends

//////////////////////////////////////////////////////////////////////////////////////////////////	
	// Same to Execute the query
	function executeNew($sql,$cachetime=0,$cachedir="") {
		//Rajaraman
		if($cachetime){	
			$this->db_n->cache_queries = true;
			$this->db_n->use_disk_cache = true;
			$this->db_n->cache_timeout = intval($cachetime); // Note: this is hours
			if($cachedir)
				$this->db_n->cache_dir = $cachedir;
			else
				$this->db_n->cache_dir = MAIN_APP_DIR.'abc';
		}else{
			$this->db_n->cache_queries = false;
			$this->db_n->use_disk_cache = false;
		}
		// FETCH MODE 
		if($this->fetchMode == 'ASSOC'){
			$this->result = $this->db_n->get_results($sql , ARRAY_A);
		}else {
			$this->result = $this->db_n->get_row($sql, ARRAY_N);
		}	
	}		
	// Set New Fetch Mode.
	function fetchNew() {
		return $this->result;
	}	
	// Set New Fetch Mode.
	function setFetchModeNew($value) {
		$this->fetchMode = $value;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////		
	function execute($sql) {
            //echo 'eeeee'.$sql;
		$this->sql = $sql;
	//	$this->lwrite($sql);
		$this->result = @mysql_query($this->sql);
                
		$this->error = mysql_error();
              
		//if( $this->error) echo $statement."<br/>".$this->error;
		
		//$this->QueryDisplay($this->sql);
	}   
	function fetch() {
		
		if($this->fetchMode == 'ASSOC')
			return @mysql_fetch_assoc($this->result);
		else {
			return @mysql_fetch_row($this->result);
		}	
	}	
	// Set Fetch Mode.
	function setFetchMode($value) {
		$this->fetchMode = $value;
	}
	
	// Return the Update Sql
	function getUpdateSQL() {
	
		$values = " ";
		foreach($this->elements as $fieldname => $value) {
			if($this->pkName != $fieldname) {
				$values = $values."`".$fieldname."` = '".addslashes($value)."', ";
			}
		}
		$values = substr($values,0,-2);
		$sql ="UPDATE `".$this->dbName."` SET ".$values." WHERE `".$this->pkName."` = ".$this->elements[$this->pkName];
		return $sql;
		
	}
	
	// Return the Insert Sql
	function getInsertSQL() {

		$fields = "(";
		$values = "(";
		foreach($this->elements as $fieldname => $value) {
			if($this->pkName != $fieldname) {
				$fields = $fields."`".$fieldname."`, ";
				$values = $values."'".addslashes($value)."', ";
			}
		}
		$fields = substr($fields,0,-2).")";
		$values = substr($values,0,-2).")";
		
		$sql ="INSERT INTO `".$this->dbName."` ".$fields." VALUES ".$values; 
		return $sql;
	}
		
	// Gets the first column of the first row
	function getOne($statement) {
		$fetch_row = mysql_fetch_row(mysql_query($statement));
		$result = $fetch_row[0];
		if(mysql_error()) {
			return null;
		} else {
			return $result;
		}
	}
	
	// Return true if there was an error
	function isError() {
		return (!empty($this->error)) ? true : false;
	}
	
	// Return the error
	function getError() {
		return $this->error;
	}	
		
	// Fetch num rows
	function numRows() {
		return mysql_num_rows($this->result);
	}
	
	// Fetch row
	function fetchRow() {
		return mysql_fetch_array($this->result);
	}
	
	function fetchAssoc() {
		return mysql_fetch_assoc($this->result);
	}
		
	// Disconnect from the database
	function disconnect() {
		mysql_close();
		$this->db = NULL;
		$this->connected = NULL;
		$this->error = NULL;
		$this->error_type = NULL;
		$this->fetchMode = NULL;	
		$this->result = NULL;			
	}
	//sql log file start by rajaraman
	function lwrite($message){
		// if file pointer doesn't exist, then open log file
		if (!$this->fp) $this->lopen();
		// define script name
		$script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
		$ip=$_SERVER['REMOTE_ADDR'];
		// define current time
		$time = date('H:i:s');
		// write current time, script name and message to the log file
		fwrite($this->fp, "$time ($script_name) ($ip) $message\n");
	}
	function lopen(){
		// define log file path and name
		$lfile = MAIN_PATH.APP_NAME."/logs/sqllogfile34.txt";
		// define the current date (it will be appended to the log file name)
		$today = date('Y-m-d');
		// open log file for writing only; place the file pointer at the end of the file
		// if the file does not exist, attempt to create it
		$this->fp = fopen($lfile . '_' . $today, 'a') or exit("Can't open $lfile!");
	}
	//sql log file
	
	
	function QueryDisplay($sql){
		print "&nbsp;&nbsp;".$sql."<br>";
	
	}
	
	function adminConfig_select($ID){
		if(strlen($ID)){
			$sql = "select * from admin_config  where conf_id =".$ID;
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$return_array = array();
			$return_array=$this->fetch();
			return $return_array;
		}
	}

	
}
?>