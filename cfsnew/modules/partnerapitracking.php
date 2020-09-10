<?php

class apitracking extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function apitracking() {
		
		database::database();	
		
		$this->elements["apiName"]   = "";
		$this->elements["apiURL"]  = "";
		$this->elements["user"]   = "";
		$this->elements["deviceId"]    = "";
		$this->elements["deviceType"]    = "";
		$this->elements["companyName"]    = "";
		$this->elements["createdAt"]   = "";
		$this->pkName="id";
		$this->dbName="partner_apitracking";
	}
	
// 	
	
        
       function userCount() {
		$sql = "SELECT count(user) FROM ".$this->dbName." ";
		$this->execute($sql);
	   } 
        
        
       

	function getFullList($pageID=1,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("id","apiName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		//echo $sql;
		if($type=="apiName")
			$this->setFetchMode('ASSOC');
		
		$this->execute($sql);

		$return_array = array();
		$cont=0;
		if($fields=="*")
			$return_array=$this->fetch();
		else{
			while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				$cont++;
			}
		}
		return $return_array;
	}

        
    
	
        
        



}//End of Class
?>