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

		$this->elements["EmployeeRelatedExpenses"]               = "";
		$this->elements["ForeignExchangeEarningandOutgo"]        = "";
		$this->elements["EarninginForeignExchange"]              = "";
		$this->elements["OutgoinForeignExchange"]                = "";
		$this->elements["AddFinancials"]                = "";

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
        
        function countJnCprofile($where=""){

		$sql = "select count(".$this->dbName.".".$this->pkName.") as total from ".$this->dbName;
                $sql.= " INNER JOIN cprofile  on(".$this->dbName.".CId_FK = cprofile.Company_Id) ";
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

/*	function SearchHome($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name"){
		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows))  $rows=50; //$rows=250000;
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";

		if($fields != '*')
			$fields = implode(",", $fields);

		if(!true){

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b ,balancesheet c";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where)) $sql.= " WHERE ".$where;
		}

		else{
			// ------------------------------------------------
			$sql = "SELECT ".$fields. ",d.FCompanyName AS AWS, d.FCompanyName AS COMPANYNAME FROM ".$this->dbName." a";

			// convert multiple Tables in (FROM) into many JOIN

			if(strlen($where)){

			$pieces = explode("and", $where);

			//print_r( $pieces);

			$aa = array();
			$bb = array();
			$cc = array();

			foreach($pieces as $str){

				if (strpos($str,' a.') !== false)
					array_push($aa, $str);

				else if (strpos($str,' b.') !== false)
					array_push($bb, $str);

				else if (strpos($str,' c.') !== false)
					array_push($cc, $str);
			}

			$aa = implode(" AND ", $aa);
			$bb = implode(" AND ", $bb);
			$cc = implode(" AND ", $cc);


			if (!empty($bb))
				$new = " INNER JOIN cprofile b ON " .$bb;
			if (!empty($cc))
				$new .= " INNER JOIN balancesheet c ON " .$cc;

			$new .=" LEFT JOIN filings d ON d.FCompanyName = b.FCompanyName";

			if (!empty($aa))
				$new .= " WHERE " . $aa;



			$sql .= $new;
			//print $sql;


			}
			// ------------------------------------------------

		}




		//if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

		//print $sql;
		//print "<br>";

		if($type=="name")
			$this->setFetchMode('ASSOC');

		print $sql;


		//$this->execute("SET SQL_BIG_SELECTS=1");  //Set it before your main query


		$this->execute($sql);
		//print $this->execute($sql);
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

		//print $sql;
		//print "<br>";
		return $return_array;




	}

*/
        
function SearchHome($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
               
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
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
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
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
				
                            if($client!=""){

                               $filing=$this->checkfilings($client,($rs['FCompanyName']));
                               $rs['filing']=$filing;
                            } 
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
        function SearchHomeWithFiling($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
               
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
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
                if($rows>0){
                if(strlen($pageID)>0 || strlen($rows)>0)
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
		//print $sql;
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
//		print $sql;
		$this->execute($sql);
		
		//print $this->execute($sql);
		$return_array = array();
		$cont=0;
              
		if($fields=="*")
			$return_array=$this->fetch();
		else{
                 
			while ($rs = $this->fetch()) {
				
                            if($client!=""){
                               $filing=$this->checkfilings($client,($rs['FCompanyName']));
                               $rs['filing']=$filing;
                            }
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

	/*Export Finacial with both pl standard and balancesheet*/

	function exportFinacial($CID,$type="num"){
		//$sql = "select b.SCompanyName,a.FY,a.OptnlIncome,a.OtherIncome,a.TotalIncome,a.OptnlAdminandOthrExp,a.OptnlProfit,a.EBITDA,a.Interest,a.EBDT,a.Depreciation,a.EBT,a.Tax,c.ShareCapital,c.ReservesSurplus,c.ShareApplication,c.ReservesSurplus,c.TotalFunds,c.SecuredLoans,c.UnSecuredLoans,c.LoanFunds,c.OtherLiabilities,c.DeferredTax,c.SourcesOfFunds,c.GrossBlock,c.LessAccumulated,c.NetBlock,c.CapitalWork,c.FixedAssets,c.IntangibleAssets,c.OtherNonCurrent,c.Investments,c.DeferredTaxAssets,c.SundryDebtors,c.CashBankBalances,c.Inventories,c.LoansAdvances,c.OtherCurrentAssets,c.CurrentAssets,c.CurrentLiabilities,c.Provisions,c.CurrentLiabilitiesProvision,c.NetCurrentAssets,c.ProfitLoss,c.Miscellaneous,c.TotalAssets from ".$this->dbName." a ,cprofile b ,balancesheet c where a.CId_FK IN (".implode(',',$CID).") AND a.CId_FK = b.Company_Id ";
		//$sql = "select b.SCompanyName,a.FY,a.OptnlIncome,a.OtherIncome,a.TotalIncome,a.OptnlAdminandOthrExp,a.OptnlProfit,a.EBITDA,a.Interest,a.EBDT,a.Depreciation,a.EBT,a.Tax,c.ShareCapital,c.ReservesSurplus,c.ShareApplication,c.ReservesSurplus,c.TotalFunds,c.SecuredLoans,c.UnSecuredLoans,c.LoanFunds,c.OtherLiabilities,c.DeferredTax from ".$this->dbName." a ,cprofile b ,balancesheet c where a.CId_FK IN (".implode(',',$CID).") AND a.CId_FK = b.Company_Id ";
		$sql = "select c.SCompanyName,a.FY,a.OptnlIncome,a.OtherIncome,a.TotalIncome,a.OptnlAdminandOthrExp,a.OptnlProfit,a.EBITDA,a.Interest,a.EBDT,a.Depreciation,a.EBT,a.Tax,b.ShareCapital,b.ReservesSurplus,b.ShareApplication,b.ReservesSurplus,b.TotalFunds,b.SecuredLoans,b.UnSecuredLoans,b.LoanFunds,b.OtherLiabilities,b.DeferredTax from ".$this->dbName." a INNER JOIN balancesheet b ON (a.FY = b.FY AND a.CID_FK = b.CID_FK) INNER JOIN cprofile c ON (b.CId_FK = c.Company_Id) where a.CId_FK IN (".implode(',',$CID).")";
		//$sql = "select b.SCompanyName,a.FY,a.OptnlIncome from ".$this->dbName." a ,cprofile b where a.CId_FK IN (".implode(',',$CID).") AND a.CId_FK = b.Company_Id ";
		if(mysql_num_rows(mysql_query($sql))==0){
			$sql = "select c.SCompanyName,a.FY,a.OptnlIncome,a.OtherIncome,a.TotalIncome,a.OptnlAdminandOthrExp,a.OptnlProfit,a.EBITDA,a.Interest,a.EBDT,a.Depreciation,a.EBT,a.Tax,a.PAT from ".$this->dbName." a INNER JOIN cprofile c ON (a.CId_FK = c.Company_Id) where a.CId_FK IN (".implode(',',$CID).")";
		}
		if($type=="name")
			$this->setFetchMode('ASSOC');

		//pr($sql);

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

	/*Ratio Calculation*/
	function radioFinacial($where){
		$sql = "select * from ".$this->dbName." a INNER JOIN balancesheet b ON a.FY = b.FY AND a.CID_FK = b.CID_FK where ".$where;
		if($type=="name")
			$this->setFetchMode('ASSOC');

		//pr($sql);
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


	/*Export Compare Companies*/

	function ExportGetCompareCompanies($where,$order,$type="num"){
		$sql = "select SCompanyName,FY,OptnlIncome,OptnlIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,OtherIncome,TotalIncome,BINR,DINR from ".$this->dbName;
		$sql.= " INNER JOIN cprofile b on  (CId_FK = b.Company_Id) ";

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT 0,10";
		if($type=="name")
			$this->setFetchMode('ASSOC');
		//pr($sql);
		$this->execute($sql);


		$return_array = array();
		$cont=0;
		if($fields=="*")
			$return_array=$this->fetch();
		else{
			while ($rs = $this->fetch()) {
				$return_array[$cont]= $rs;
				$cont++;
			}
		}
		return $return_array;
	}
        function checkfilings($client,$c)
        {
          $bucket = $GLOBALS['bucket'];

            $iterator = $client->getIterator('ListObjects', array(
                'Bucket' => $bucket,
                'Prefix' => $GLOBALS['root'] . $c
            ));
            foreach($iterator as $object){
                return "true";
                break;
            }
            return "false";
        }

}//End of Class
?>