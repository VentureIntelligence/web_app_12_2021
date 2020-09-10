<?php

class plstandard extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function plstandard() {
		
		database::database();	
		
		$this->elements["CId_FK"]               = "";
		$this->elements["IndustryId_FK"]        = "";
		$this->elements["OptnlIncome"]          = "";
		$this->elements["OtherIncome"]          = "";		
		$this->elements["OptnlAdminandOthrExp"] = "";		
		$this->elements["OptnlProfit"]          = "";		
		$this->elements["EBITDA"]               = "";
		$this->elements["Interest"]             = "";
		$this->elements["EBDT"]                 = "";		
		$this->elements["Depreciation"]         = "";		
		$this->elements["EBT"]                  = "";		
		$this->elements["Tax"]                  = "";
		$this->elements["PAT"]                  = "";
		$this->elements["FY"]                   = "";
		$this->elements["TotalIncome"]          = "";
		$this->elements["BINR"]                 = "";
		$this->elements["DINR"]                 = "";
		
		

		$this->elements["Added_Date"]           = "";
		$this->elements["ResultType"]           = "";

		$this->pkName="PLStandard_Id";
		$this->dbName="plstandard";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();

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

	function getFullList($pageID=1,$rows=300,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("PLStandard_Id","SCompanyName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

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
	
	function getFullListFinancials($pageID=1,$rows=300,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=2000;
		if(!strlen($fields[0]))$fields=array("a.PLStandard_Id","a.SCompanyName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a ";
		$sql.= " INNER JOIN cprofile b on(a.CId_FK = b.Company_Id) ";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

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

	function deleteCompany($ID){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where CId_FK = $ID";
			$rs = $this->execute($sql);
			
		}
	}
	
	function SearchHome($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name"){
		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=7000;
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		
		//print $sql;
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
		//print $sql;
		$this->execute($sql);
		
		//print $this->execute($sql);
		$return_array = array();
		$cont=0;
		if($fields=="*")
			$return_array=$this->fetch();
		else{
			while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				//print_r($return_array[$cont]);
				$cont++;
				//echo $cont;
				//echo '<br/>';
				//print_r($rs);
			}
		}
		//echo $cont;
		
		//print $return_array;
		//print_r($return_array);
		return $return_array;
	}
	function SearchHomeNew($fields="",$where="",$order="",$group="",$type="name"){
		
		$sql = "SELECT a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.Company_Id,b.FCompanyName,b.ListingStatus,a.TotalIncome,b.FYCount AS FYValue,b.Permissions1, b.SCompanyName FROM plstandard a ,cprofile b";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group)) $sql.= " GROUP BY ".$group;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$result = mysql_query($sql);
		$return_array = array();
		$cont1 = 0;
		//echo count(mysql_num_rows($result));
		while ($rs = mysql_fetch_array($result)) {
			$return_array[$cont1] = $rs;
			//print $return_array[$cont1];
			$cont1++;
			//print_r($rs);
		}
		//print_r($return_array);
		return $return_array;
	}	

function SearchGrowthPerc($OptnlIncomeGrothPercent,$OptnlIncomeGrothYear,$where,$SearchResults,$FieldName,$_REQUEST){
//			print $OptnlIncomeGrothYear.$FieldName;exit;
			$Date = getdate();
			$CurYear = 11;//substr($Date["year"],-2);
			$UserYears = $CurYear - $OptnlIncomeGrothYear;
			
			$numbers = range($CurYear, $UserYears);
			$countnumItems = count($numbers);
			foreach ($numbers as $number) {
				if($n+1 == $countnumItems) {
					$Years .= $number;
				}else{
					$Years .= $number.",";
				}
				$n++;
			}
			for($i=0;$i<$OptnlIncomeGrothYear;$i++){
				$OrignalValue = $SearchResults[$i][$FieldName];
				$GivenPercValue = ($SearchResults[$i+1][$FieldName] * $OptnlIncomeGrothPercent ) / 100;//Chk if original diff 1500000 gtthan given % Value 900000 so Fetch Values
				$FinalGivenPercValue = $GivenPercValue + $SearchResults[$i+1][$FieldName];
				//print "<br>".$FinalGivenPercValue."<br>"; print "hrere";
					//			print "<br>".$OrignalValue."<br>";
					if($_REQUEST['PercentCommonandor'] == "and"){
						if($FinalGivenPercValue <= $OrignalValue){
						//	print "<br>".$i."And - true<br>";
							$where .= " AND a.FY IN($Years)  AND a.CId_FK = ".$SearchResults[$i]['CId_FK'];
							$group = " a.CId_FK ";
						}else{
						//	print "<br>".$i."And - false<br>";
							$where = " ";
						}
					}else if($_REQUEST['PercentCommonandor'] == "or"){	
						if($FinalGivenPercValue <= $OrignalValue){
						//	print "<br>".$i."OR -true<br>".$test;
							$i = $OptnlIncomeGrothYear-1;
							/*if($i == 0 && $test == " " || $test == 0){
								$where .= "   a.FY IN($Years)  AND a.CId_FK = ".$SearchResults[$i]['CId_FK'];
							}else{*/
								$where = "  b.ListingStatus = 0 and a.CId_FK = b.Company_Id AND a.FY IN($Years)  AND a.CId_FK = ".$SearchResults[$i]['CId_FK'];
							//}	
							$group = " a.CId_FK ";
						}else{
						//	print "<br>".$i."OR -false<br>";
							$where = " ";
							$test = $i;
						}//If Ends
					}//If Ends
			}//For Ends
		return $where;	

}// Function SearchGrowthPerc Ends 



	function GetCompareCompanies($where,$order,$type="num"){
		$sql = "select * from ".$this->dbName;
		$sql.= " INNER JOIN cprofile b on  (CId_FK = b.Company_Id) ";
		
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT 0,10";
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