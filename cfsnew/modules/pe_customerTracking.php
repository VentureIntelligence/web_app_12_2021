<?php

class customerTracking extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function customerTracking() {
		
		database::database();	
		
		$this->elements["username"]   = "";
		$this->elements["fromAddress"]  = "";
		$this->elements["toAddress"]   = "";
		$this->elements["message"]    = "";
		$this->elements["createdAt"]    = "";
		$this->pkName="id";
		$this->dbName="pe_customer_request";
	}
	
// 	
	
      
        
        
       

	function getFullList($pageID=1,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("user_id","username");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT * FROM ".$this->dbName." ";
		
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