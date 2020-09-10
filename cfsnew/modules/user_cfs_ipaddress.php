<?php

class user_cfs_ipaddress extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function user_cfs_ipaddress() {
		
		database::database();	
		
		$this->elements["group_Id"]      = "";
		$this->elements["ipAddress"]     = "";		
		$this->elements["StartRange"]      = "";		
		$this->elements["EndRange"]      = "";	
		
		$this->pkName="id";
		$this->dbName="user_cfs_ipaddress";

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
        
      

}//End of Class
?>