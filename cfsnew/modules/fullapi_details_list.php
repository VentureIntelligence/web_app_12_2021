<?php
// fullapi_details_list
class fullapi_details_list extends database {
	
	var $elements;
	var $pkName;
	var $dbName;
	var $TName;

	function fullapi_details_list() {
		
		database::database();	
		
		$this->elements["userName"]   = "";
		$this->elements["user_company"]  = "";
		$this->elements["userType"]   = "";
		$this->elements["userToken"]    = "";
		$this->elements["validityFrom"]    = "";
		$this->elements["validityTo"]    = "";
		$this->elements["serachCount"]    = "";
		$this->elements["apiCount"]    = "";
		$this->elements["user_id"]    = "";
		$this->elements["createdAt"]    = "";
		$this->pkName="fullapi_user_id";
		$this->dbName="fullapi_user";
		$this->TName="external_fullapi_users";
	}
	
// 	
	function getFullList($pageID=1,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("fullapi_user_id","userName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="fullapi_user_id DESC";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		//$sql = "SELECT * FROM ".$this->dbName." ";
		$sql = "SELECT DISTINCT fullapi_user.fullapi_user_id,
								fullapi_user.userName, 
								fullapi_user.user_company, 
								fullapi_user.userType, 
								fullapi_user.validityFrom, 
								fullapi_user.validityTo, 
								fullapi_user.serachCount, 
								fullapi_user.apiCount, 
								fullapi_user.user_status, 
				(SELECT COUNT(DISTINCT(companyName)) FROM fullapi_tracking
				 WHERE userToken = fullapi_user.userToken and (companyName !='')) AS searchApi,
				 (SELECT COUNT(*) FROM fullapi_tracking
				 WHERE userToken = fullapi_user.userToken) AS apiTotal FROM fullapi_user";
				 
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
        //echo $sql;
        //exit();
		if($type=="userName")
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
	
	function getUserDetails($fullapi_user_id){
		$sql = "SELECT * FROM   ".$this->dbName." WHERE `fullapi_user_id`='".$fullapi_user_id."'";
            $this->setFetchMode('ASSOC');
            $this->execute($sql);
            $return_array = $this->fetch();
			//print_r($return_array);
			//exit();
			return $return_array;
	}

	function getExternalDetails($user_id){
		$sql = "SELECT * FROM   ".$this->TName." WHERE `fullapi_user_id`='".$user_id."'";
		
		$this->setFetchMode('ASSOC');
            $this->execute($sql);
            $return_array = $this->fetch();
			// print_r($return_array);
			// exit();
			return $return_array;
	}

}
//End of Class

?>