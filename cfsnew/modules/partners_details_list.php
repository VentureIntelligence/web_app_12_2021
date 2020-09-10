<?php

class partners_details_list extends database {
	
	var $elements;
	var $pkName;
	var $dbName;
	var $TName;

	function partners_details_list() {
		
		database::database();	
		
		$this->elements["partnerName"]   = "";
		$this->elements["partner_company"]  = "";
		$this->elements["partnerType"]   = "";
		$this->elements["partnerToken"]    = "";
		$this->elements["validityFrom"]    = "";
		$this->elements["validityTo"]    = "";
		$this->elements["serachCount"]    = "";
		$this->elements["apiCount"]    = "";
		$this->elements["user_id"]    = "";
		$this->elements["createdAt"]    = "";
		$this->pkName="partner_id";
		$this->dbName="api_partner";
		$this->TName="external_api_users";
	}
	
// 	
	function getFullList($pageID=1,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("partner_id","partnerName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		//$sql = "SELECT * FROM ".$this->dbName." ";
		$sql = "SELECT DISTINCT api_partner.partner_id,
								api_partner.partnerName, 
								api_partner.partner_company, 
								api_partner.partnerType, 
								api_partner.validityFrom, 
								api_partner.validityTo, 
								api_partner.serachCount, 
								api_partner.apiCount, 
								api_partner.partner_status, 
				(SELECT COUNT(DISTINCT(companyName)) FROM partner_apitracking
				 WHERE partnerToken = api_partner.partnerToken and (companyName !='')) AS searchApi,
				 (SELECT COUNT(*) FROM partner_apitracking
				 WHERE partnerToken = api_partner.partnerToken) AS apiTotal FROM api_partner";
				 
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
        //echo $sql;
        //exit();
		if($type=="partnerName")
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
	
	function getPartnerDetails($partner_id){
		$sql = "SELECT * FROM   ".$this->dbName." WHERE `partner_id`='".$partner_id."'";
            $this->setFetchMode('ASSOC');
            $this->execute($sql);
            $return_array = $this->fetch();
			//print_r($return_array);
			//exit();
			return $return_array;
	}

	function getExternalDetails($user_id){
		$sql = "SELECT * FROM   ".$this->TName." WHERE `user_id`='".$user_id."'";
            $this->setFetchMode('ASSOC');
            $this->execute($sql);
            $return_array = $this->fetch();
			//print_r($return_array);
			
			return $return_array;
	}

}
//End of Class

?>