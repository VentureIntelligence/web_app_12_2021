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
		// $this->elements["dealCount"]    = "";
		// $this->elements["companyCount"]    = "";
		// $this->elements["user_id"]    = "";
		$this->elements["createdAt"]    = "";
		$this->pkName="partner_id";
		$this->dbName="news_api_partner";
		// $this->TName="pe_external_api_users";
		$this->TName="news_api_users";
	}
	
// 	
	function getFullList($pageID=1,$fields,$where="",$order="",$type="num"){

        // echo '<pre>';    print_r( $fields);  echo '</pre>';  exit;

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("partner_id","partnerName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="partner_id DESC";
	
		if($fields != '*')
			$fields = implode(",", $fields);


		$sql = "SELECT DISTINCT news_api_partner.partner_id,
								news_api_partner.partnerName, 
								news_api_partner.partner_company,
								news_api_partner.api_type, 
								news_api_partner.partnerType, 
								news_api_partner.validityFrom, 
								news_api_partner.validityTo, 
								news_api_partner.overallCount,
								news_api_partner.createdAt,
								(SELECT COUNT(DISTINCT(apiName)) FROM pe_partner_apitracking
				 WHERE token = news_api_partner.partnerToken 
and apiName in ('/deals/investments/pe','/deals/investments/vc','/deals/investments/social',
'/deals/investments/cleantech','/deals/investments/infrastructure','/deals/exits/pe-manda',
'/deals/exits/pe-publicmarket','/deals/exits/vc-manda','/deals/exits/vc-publicmarket')) AS searchApi,
				 (SELECT COUNT(companyName) FROM pe_partner_apitracking
				 WHERE token = news_api_partner.partnerToken  and companyName IS NOT NULL and apiName in ('/deals/investments/pe/deallist','/deals/investments/vc/deallist','/deals/investments/social/deallist', '/deals/investments/cleantech/deallist','/deals/investments/infrastructure/deallist', '/deals/exits/pe-manda/deallist','/deals/exits/pe-publicmarket/deallist','/deals/exits/vc-manda/deallist', '/deals/exits/vc-publicmarket/deallist')) AS apiTotal,
				 (SELECT COUNT(*) FROM pe_partner_apitracking
				 WHERE token = news_api_partner.partnerToken) AS overallTotal  
				 FROM news_api_partner";

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
        // echo $sql;
        // exit();
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