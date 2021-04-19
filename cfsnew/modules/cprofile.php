<?php

class cprofile extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function cprofile() {
		
		database::database();	
		
		$this->elements["SCompanyName"]      = "";
		$this->elements["FCompanyName"]     = "";		
		$this->elements["ParentCompany"]      = "";		
		$this->elements["FormerlyCalled"]      = "";
		$this->elements["Permissions1"]      = "";	
		$this->elements["UserStatus"]      = "";	
		$this->elements["Industry"]      = "";
		$this->elements["Sector"]      = "";
		$this->elements["SubSector"]     = "";		
		$this->elements["BusinessDesc"]      = "";		
		$this->elements["Brands"]      = "";		
		$this->elements["Country"]      = "";
		$this->elements["RegionId_FK"]      = "";
		$this->elements["IncorpYear"]     = "";		
		$this->elements["ListingStatus"]      = "";		
		
		$this->elements["company_status"]      = "";		
		$this->elements["RocCode"]      = "";	
		$this->elements["RegNumber"]      = "";	
		$this->elements["AuthorisedCapital"]      = "";	
		$this->elements["PaidCapital"]      = "";

		$this->elements["StockBSE"]      = "";		
		$this->elements["StockNSE"]      = "";
		$this->elements["IPODate"]      = "";
		$this->elements["AddressHead"]     = "";		
		$this->elements["AddressLine2"]      = "";		
		$this->elements["City"]      = "";		
		$this->elements["State"]      = "";
		$this->elements["Pincode"]      = "";
		$this->elements["AddressCountry"]     = "";		
		$this->elements["Phone"]      = "";		
		$this->elements["Fax"]      = "";		
		$this->elements["Email"]      = "";
		$this->elements["Website"]      = "";
		$this->elements["CEO"]     = "";		
		$this->elements["CFO"]      = "";
                $this->elements["rgthcr"]      = "";
		$this->elements["Profile_Flag"]      = "";
		$this->elements["Added_Date"]    = "";
		$this->elements["DealUrl"]      = "";
		$this->elements["competitorsListed"]      = "";
		$this->elements["competitorsUnListed"]      = "";
		$this->elements["otherCompareListed"]      = "";
		$this->elements["otherCompareUnListed"]      = "";
		$this->elements["FYCount"]      = "";
		$this->elements["GFYCount"]      = "";
		$this->elements["cvid"]      = "";
		$this->elements["CIN"]      = "";
		$this->elements["Total_Income_equal_OpIncome"]      = "";
                $this->elements["Rating_Url"]      = "";

		$this->pkName="Company_Id";
		$this->dbName="cprofile";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();
		
		//print_r($sql);
		
		$this->execute($sql);

		if($this->elements[$this->pkName] == -1) {//added by rajaraman
			$this->execute('SELECT LAST_INSERT_ID() as id');
			$this->setFetchMode('ASSOC');
			$rs = $this->fetch();	
			$this->elements[$this->pkName] = $rs['id'];
		}

		if(!($this->error)) {
			return true;		
		} else {
			return false;
		}
	}
//CFS add profile tag start
	function tagsinput($value,$option){
		
		if($option == 'insert'){
			$sql = 'INSERT INTO cfs_tag(cin, tags) VALUES ("'.$value['CIN'].'","'.$value['tags'].'")';
			
		}else{
			
				$sql = 'UPDATE `cfs_tag` SET `tags`="'.$value['tags'].'" where `cin`="'.$value['CIN'].'"';
			
		}
		//echo $sql;
		//exit();
		$this->execute($sql);
		
		

	 }
	 function tagcininput($cin){
		$sql = 'select * from cfs_tag where '.$cin;
		//echo $sql;
		$this->execute($sql);
		
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array=$rs;
			$cont++;
		}
	   return $return_array;

	}
//CFS add profile tag end
	function getFullListAdmin($pageID=1,$rows=300,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("Company_Id","SCompanyName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		
//	print $sql;
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

	function getFullList($pageID=1,$rows=500,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=500;
		if(!strlen($fields[0]))$fields=array("Company_Id","SCompanyName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		$sql.= " LEFT JOIN industries b on(Industry = b.Industry_Id) ";
		$sql.= " LEFT JOIN countries c on(AddressCountry = c.Country_Id) ";
		$sql.= " LEFT JOIN city d on(City = d.city_id) ";
		$sql.= " LEFT JOIN state e on(	State = e.state_id) ";
		$sql.= " LEFT JOIN sectors f on(Sector  = f.Sector_Id) ";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		
//	print $sql;
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

         function getFullIndustry($pageID=1,$rows=100,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=100;
		if(!strlen($fields[0]))$fields=array("Company_Id","SCompanyName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		$sql.= " INNER JOIN industries b on(Industry = b.Industry_Id) ";
		$sql.= " INNER JOIN countries c on(Country = c.Country_Id) ";
		$sql.= " INNER JOIN city d on(City = d.city_id) ";
		$sql.= " INNER JOIN state e on(	State = e.state_id) ";
		$sql.= " INNER JOIN sectors f on(Sector  = f.Sector_Id) ";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		
	//print $sql;
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

	function getFullListNew($pageID=1,$rows=3000,$fields=array("*"),$where="",$order="",$type="name"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields)) $fields=array("*");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		
		if($type=="name")
			$this->setFetchMode('ASSOC');
//		pr($sql);
		$this->execute($sql);

		$return_array = array();
		$cont=0;
		if($fields!="*")
			$return_array=$this->fetch();
		else{
			while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				$cont++;
			}
		}
		return $return_array;
	}

	function count($where=""){
			
		$sql = "select count(".$this->pkName.") as total from ".$this->dbName;
		if(strlen($where))  $sql.= " WHERE ".$where;
		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$rs = $this->fetch();
		return $rs["total"]; 
	}	

	function select($ID){
		if(strlen($ID)){
			$sql = "select * from ".$this->dbName." where ".$this->pkName."=$ID";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$this->elements = $this->fetch();
		}
	}
	
	
	function delete($ID){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where ".$this->pkName."=$ID";
			$rs = $this->execute($sql);
			
		}
	}
	

	function CheckUserNameExists($username){
		if(strlen($username)){
			$sql = "select * from ".$this->dbName." where username = '".$username."'";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$this->elements = $this->fetch();
		}
	}
	
	function CheckCinExists($where=""){	
		$sql = "select count(".$this->pkName.") as total from ".$this->dbName;
		if(strlen($where))  $sql.= " WHERE ".$where;
		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$rs = $this->fetch();
		return $rs["total"]; 
	}

	function getCompanies($where,$order){
		$sql = "select Company_Id, FCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$sql.=" ORDER BY `Added_Date` DESC";
		//print_r($sql);
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}

	function getCompaniesAutoSuggest($where,$order,$limit = ''){
		$sql = "select Company_Id, FCompanyName, SCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		if( !empty( $limit ) ) $sql .= $limit;
		//$sql.= " LIMIT 0,10";
		$this->execute($sql);
		$return_array = array();
		//echo $sql;
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}

	function getCompaniesAutoSuggest_brand($where,$order,$limit = ''){
		$sql = "select Company_Id, FCompanyName, SCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		if( !empty( $limit ) ) $sql .= $limit;
		//$sql.= " LIMIT 0,10";
		/*echo $sql;
		exit;*/
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[]= array( 'id' => $rs[0], 'FCompanyName' => $rs[1], 'SCompanyName' => $rs[2] );
			$cont++;
		}
		return $return_array;
	}

	
        // function getCompaniesAutoSuggest_name_cin($slt,$where,$order){
        // $sql = "select Company_Id, ".$slt." from ".$this->dbName;
        // if(strlen($where)) $sql.= " WHERE ".$where;
        // if(strlen($order)) $sql.= " ORDER BY ".$order;
        // //$sql.= " LIMIT 0,10";
        // //print_r($sql);
        // $this->execute($sql);
        // $return_array = array();
        // while ($rs = $this->fetch()) {
        //         $return_array[$rs[0]]= $rs[1];
        //         $cont++;
        // }
        // return $return_array;
        // }

		function getCompaniesAutoSuggest_name_cin($slt,$where,$order){
	        $sql = "select Company_Id, ".$slt." from ".$this->dbName;
	        if(strlen($where)) $sql.= " WHERE ".$where;
	        if(strlen($order)) $sql.= " ORDER BY ".$order;
	        //$sql.= " LIMIT 0,10";
	        //print_r($sql);
	        $this->execute($sql);
	        $name_cin_array = array();
	        while ($rs = $this->fetch()) {
	                $name_cin_array[$rs[0]]= $rs[1];
	                if($slt == "CIN, Old_CIN" && $rs[2] != ""){
						array_push($name_cin_array,$rs[2]);
					}
	                $cont++;
	        }
	        return $name_cin_array;
        }
		function getCompaniesAutoSuggest_name_cinno($slt,$where,$order){
	        $sql = "select Company_Id, ".$slt." from ".$this->dbName;
	        if(strlen($where)) $sql.= " WHERE ".$where;
	        if(strlen($order)) $sql.= " ORDER BY ".$order;
	        //$sql.= " LIMIT 0,10";
	       // print_r($sql);exit();
	        $this->execute($sql);
	        $name_cin_array = array();
	        while ($rs = $this->fetch()) {
				if($rs[2] != "")
				{
	                $cin_array_name[$rs[0]]= $rs[1];
				}else
				{
	                $cin_array_name[$rs[0]]= $rs[1];
					array_push($name_cin_array,$cin_array_name);
				}	
				//print_r($cin_array_name[$rs[0]]);exit();
	                if($slt == "CIN, Old_CIN" && $rs[2] != ""){
						$cin_array[$rs[0]]= $rs[2];
						array_push($name_cin_array,$cin_array,$cin_array_name);

					}
	                $cont++;
	        }					
			//exit();
	        return $name_cin_array;
        }

	function getCompaniesCompare($where,$order){
		$sql = "select Company_Id, SCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= ucwords(strtolower($rs[1]));
			$cont++;
		}
		return $return_array;
	}
        
        function getCompaniesCompareJson($where,$order){
		$sql = "select Company_Id, SCompanyName,FCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$this->execute($sql);
               
		$return_array = array();
                $return_array_cons = array();
		while ($rs = $this->fetch()) {
			//$return_array[$rs[0]]= ucwords(strtolower($rs[1]));
                        $return_array['id']=$rs[0];
                        $return_array['label']=$rs[1];
                        $return_array['value']=$rs[1];
                        array_push($return_array_cons,$return_array);
			$cont++;
		}
		return $return_array_cons;
	}
        
        function getcomdetails($where){
		$sql = "select Permissions1, ListingStatus ,City,Website,IncorpYear from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		$this->execute($sql);
               
		$return_array = array();
                $return_array_cons = array();
		while ($rs = $this->fetch()) {
			//$return_array[$rs[0]]= ucwords(strtolower($rs[1]));
                        $return_array['listingstatus']=$rs[1];
                        $return_array['permission1']=$rs[0];
                        $return_array['city']=$rs[2];
                        $return_array['website']=$rs[3];
                        $return_array['IncorpYear']=$rs[4];
                        array_push($return_array_cons,$return_array);
			$cont++;
		}
		return $return_array_cons;
	}

        function updateFetchedUrl($companyId,$fetchurl){
            $sql ="UPDATE `cprofile` SET `google_fetched_website`='".$fetchurl."' WHERE `Company_Id`='".$companyId."'";
            $this->execute($sql);
        }
        
        function getcomdetails_allfiled($where){
		$sql = "select Permissions1, ListingStatus ,City,Website,IncorpYear,BusinessDesc,AddressHead,AddressCountry,Phone,CEO,CFO,auditor_name,Email,AddressLine2 from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		$this->execute($sql);
               
		$return_array = array();
                $return_array_cons = array();
		while ($rs = $this->fetch()) {
			//$return_array[$rs[0]]= ucwords(strtolower($rs[1]));
                        $return_array['listingstatus']=$rs[1];
                        $return_array['permission1']=$rs[0];
                        $return_array['city']=$rs[2];
                        $return_array['website']=$rs[3];
                        $return_array['IncorpYear']=$rs[4];
                        $return_array['BusinessDesc']=$rs[5];
                        $return_array['AddressHead']=$rs[6];
                        $return_array['AddressCountry']=$rs[7];
                        $return_array['Phone']=$rs[8];
                        $return_array['CEO']=$rs[9];
                        $return_array['CFO']=$rs[10];
                        $return_array['auditor_name']=$rs[11];
                        $return_array['Email']=$rs[12];
                        $return_array['AddressLine2']=$rs[13];
                        array_push($return_array_cons,$return_array);
			$cont++;
		}
		return $return_array_cons;
	}

	function getforexbycin( $cin = '', $resultType = '' ) {
		$sql = "select FCompanyName, SCompanyName, Company_Id
				FROM cprofile
				WHERE CIN = '" . $cin . "'";
 		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$rs = $this->fetch();

		$sel = "SELECT FY, OutgoinForeignExchange, EarninginForeignExchange, ResultType
				FROM plstandard
				WHERE plstandard.CId_FK = " . $rs[ 'Company_Id' ] . "  AND plstandard.ResultType = " . $resultType . "
				ORDER BY FY DESC";
		$this->setFetchMode('ASSOC');
		$this->execute($sel);
		$numRows = $this->numRows();
		if( $numRows > 0 ) {
			while( $res = $this->fetch() ) {
				$result[ 'FY' ][] = $res;
			}	
		} else {
			$result[ 'FY' ] = array();
		}
		
		$result[ 'company_fname' ] = $rs[ 'FCompanyName' ];
		$result[ 'company_sname' ] = $rs[ 'SCompanyName' ];
		$result[ 'company_id' ] = $rs[ 'Company_Id' ];
		$result[ 'ResultType' ] = $resultType;
		return $result;
	}

	function getCompaniesCIN($where,$order,$limit = ''){
		$sql = "select CIN, FCompanyName, SCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		if( !empty( $limit ) ) $sql .= $limit;
		//$sql.= " LIMIT 0,10";
		$this->execute($sql);
		$return_array = array();
		//echo $sql;
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}

	function getearnningsbycin( $cin = '', $resultType = '' ) {
		$sql = "select FCompanyName, SCompanyName, Company_Id
				FROM cprofile
				WHERE CIN = '" . $cin . "'";
 		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$rs = $this->fetch();

		$sel = "SELECT FY, BINR, DINR, ResultType
				FROM plstandard
				WHERE plstandard.CId_FK = " . $rs[ 'Company_Id' ] . "  AND plstandard.ResultType = " . $resultType . "
				ORDER BY FY DESC";
		$this->setFetchMode('ASSOC');
		$this->execute($sel);
		$numRows = $this->numRows();
		if( $numRows > 0 ) {
			while( $res = $this->fetch() ) {
				$result[ 'Earnings' ][] = $res;
			}	
		} else {
			$result[ 'Earnings' ] = array();
		}
		
		$result[ 'company_fname' ] = $rs[ 'FCompanyName' ];
		$result[ 'company_sname' ] = $rs[ 'SCompanyName' ];
		$result[ 'company_id' ] = $rs[ 'Company_Id' ];
		$result[ 'ResultType' ] = $resultType;
		return $result;
	}
	function getcomCIN($where){
			$sql = "select CIN from ".$this->dbName;
			if(strlen($where)) $sql.= " WHERE ".$where;
			$this->execute($sql);
			//echo $sql;
			$result = array();$cont=0;
			while ($rs = $this->fetch()) {
				$result['CIN']=$rs[0];
				$cont++;
			}
			return $result;
		}

		function getrunType($where){
			$sql = "select min(run_type) FROM log_table ";
			$sql.= " WHERE ".$where;
			$sql.= " GROUP BY cin";
			//echo $sql;
			$this->execute($sql);
			$result = array();$cont=0;
			while ($rs = $this->fetch()) {
				$result['run_type']=$rs[0];
				$cont++;
			}
			return $result;
		}
		function updateRestart( $cin = '', $isPLrestate = '') {
		$sql ="UPDATE `cprofile` SET `ReState`='".$isPLrestate."' WHERE `CIN`='".$cin."'";
        $this->execute($sql);
	}
	// CFS Dashboard Analitics
	function getcfsdashboard(){
	
		$sql_revenue_min_max = "select MIN(RFY), MAX(RFY) from cfs_dashboard_analytics";
		$this->execute($sql_revenue_min_max);
		$revenue_min_max = $this->fetch();
		$RFY_MIN = round($revenue_min_max[0]/10000000, 2);
		$RFY_MAX = round($revenue_min_max[1]/10000000, 2);
		$minvalue = 0;
		$maxvalue=10000000000000000;
		$RFY = " and cfs_original.RFY  BETWEEN ".$minvalue." and ".$maxvalue;
		$sql_xbrl_PEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics as cfs_original where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) and cfs_original.is_xbrl = 'XBRL' and cfs_original.is_PEBacked = 1".$RFY;
		$this->execute($sql_xbrl_PEBacked);
		$xbrl_PEBacked_count = $this->fetch();

		$sql_xbrl_nonPEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics as cfs_original where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) and cfs_original.is_xbrl = 'XBRL' and cfs_original.is_PEBacked = 0".$RFY;
		$this->execute($sql_xbrl_nonPEBacked);
		$xbrl_nonPEBacked_count = $this->fetch();
		
		$sql_nonxbrl_PEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics as cfs_original where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) and cfs_original.is_xbrl = 'NON-XBRL' and cfs_original.is_PEBacked = 1".$RFY;
		$this->execute($sql_nonxbrl_PEBacked);
		$nonxbrl_PEBacked_count = $this->fetch();

		$sql_nonxbrl_nonPEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics as cfs_original where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) and cfs_original.is_xbrl = 'NON-XBRL' and cfs_original.is_PEBacked = 0".$RFY;
		$this->execute($sql_nonxbrl_nonPEBacked);
		$nonxbrl_nonPEBacked_count = $this->fetch();

		
		$xbrl_pebacked_nonpebacked_total = $xbrl_PEBacked_count[0] + $xbrl_nonPEBacked_count[0];
		$nonxbrl_pebacked_nonpebacked_total = $nonxbrl_PEBacked_count[0] + $nonxbrl_nonPEBacked_count[0];
		$xbrl_nonxbrl_pebacked_total = $xbrl_PEBacked_count[0] + $nonxbrl_PEBacked_count[0];
		$xbrl_nonxbrl_nonpebacked_total = $xbrl_nonPEBacked_count[0] + $nonxbrl_nonPEBacked_count[0];
		$total = $xbrl_pebacked_nonpebacked_total + $nonxbrl_pebacked_nonpebacked_total;
		
		$cfsdashboard = array(
				"xbrl_PEBacked_count"=>$xbrl_PEBacked_count[0],
				"xbrl_nonPEBacked_count"=>$xbrl_nonPEBacked_count[0],
				"nonxbrl_PEBacked_count"=>$nonxbrl_PEBacked_count[0],
				"nonxbrl_nonPEBacked_count"=>$nonxbrl_nonPEBacked_count[0],
				"xbrl_pebacked_nonpebacked_total"=>$xbrl_pebacked_nonpebacked_total,
				"nonxbrl_pebacked_nonpebacked_total"=>$nonxbrl_pebacked_nonpebacked_total,
				"xbrl_nonxbrl_pebacked_total"=>$xbrl_nonxbrl_pebacked_total,
				"xbrl_nonxbrl_nonpebacked_total"=>$xbrl_nonxbrl_nonpebacked_total,
				"total"=>$total,
				"rfy_min"=>$RFY_MIN,
				"rfy_max"=>$RFY_MAX
			);

		
		return $cfsdashboard;
	}
	// CFS Dashboard Analytics
	function getcfsdashboardIndustries(){
		$minvalue = 0;
		$maxvalue=10000000000000000;
		$RFY = " cfs_original.RFY  BETWEEN ".$minvalue." and ".$maxvalue;
		// Industry Details 
		$sql_industries = "select DISTINCT IndustryName, count(DISTINCT company_id) as comcount from cfs_dashboard_analytics as cfs_original
        where".$RFY." and cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) 
		and cfs_original.IndustryName != '' group by IndustryName";
        $this->execute($sql_industries);
		$cont=0;
		while ($sql_industries = $this->fetch()) {
			$result[] = ['iname'=> $sql_industries[0],'comcount' => $sql_industries[1]];
			$cont++;
		}
		return $result;
	}


}//End of Class
?>