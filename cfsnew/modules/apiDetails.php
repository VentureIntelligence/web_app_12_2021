<?php

class apiDetails extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function apiDetails() {
		
		database::database();	
		
		$this->elements["apiName"]   = "";
		$this->elements["apiURL"]  = "";
		$this->elements["user"]   = "";
		$this->elements["deviceId"]    = "";
		$this->elements["deviceType"]    = "";
		$this->elements["createdAt"]   = "";
		$this->pkName="id";
		$this->dbName="apitracking";
	}
	
// 	
	
    function count($where=""){
        $sql = "select count(".$this->pkName.") as total from ".$this->dbName;
        if(strlen($where))  $sql.= " WHERE ".$where;
        $this->setFetchMode('ASSOC');
        $this->execute($sql);
        $rs = $this->fetch();
        return $rs["total"]; 
    }	
        
        
    
	function getFullList($pageID=1,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("user_id","username");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*') {
            $fields = implode(",", $fields);
        }else {
            $fields = $fields;
        }
			
		$sql = "SELECT DISTINCT ".$fields." FROM ".$this->dbName." ";
		
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		//echo $sql;
		if($type=="name")
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