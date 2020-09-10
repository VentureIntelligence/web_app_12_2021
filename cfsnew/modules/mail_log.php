<?php

class mail_log extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function mail_log() {
		
		database::database();	
		
		$this->elements["companyId"]      = "";
		$this->elements["from_address"]     = "";		
		$this->elements["to_address"]      = "";		
		$this->elements["cc_address"]      = "";
		$this->elements["bcc_address"]      = "";
		$this->elements["textMessage"]      = "";	
		$this->elements["message"]      = "";	
		
		$this->pkName="id";
		$this->dbName="mail_log";

	}
	
	function update($values) {
                
		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();
               // echo $sql."<br><br>";
//                exit;
		$this->execute($sql);

		if($this->elements[$this->pkName] == -1) {//added by rajaraman
			$this->execute('SELECT LAST_INSERT_ID() as id');
			$this->setFetchMode('ASSOC');
			$rs = $this->fetch();	
			$this->elements[$this->pkName] = $rs['id'];
		}

		if(!($this->error))
			return true;		
	}
        
        
    function delete($deletebygroup){
	
		if(strlen($deletebygroup)){
			
			$sql = "delete from ".$this->dbName." where  $deletebygroup ";
                      // echo $sql."<br><br>";
			$rs = $this->execute($sql);
			
		}
	}
        
    function listAll(){
		
		if(strlen($ID)){
			$sql = "select * from ".$this->dbName;
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$this->elements = $this->fetch();
		}
	}  

}//End of Class
?>