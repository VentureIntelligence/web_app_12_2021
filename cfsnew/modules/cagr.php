<?php

class cagr extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function cagr() {
		
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
		$this->elements["CAGRYear"]             = "";
		

		$this->elements["Added_Date"]    = "";
		$this->elements["ResultType"]   = "";

		$this->pkName="CAGR_Id";
		$this->dbName="cagr";

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

		if(!($this->error)) {
			return true;		
		} else {
			return false;
		}
	}

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
	
	function SearchHome($fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("a.CAGR_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a , cprofile b";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
//		print $sql;
		if($type=="name")
			$this->setFetchMode('ASSOC');
		$this->execute($sql);

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
		//pr($return_array);
		return $return_array;
	}

                function SearchHomeGrowth($fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("c.CAGR_Id,c.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." c , cprofile b,plstandard a";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
                if(strlen($order))   $sql.= " ORDER BY a.FY DESC ";
                
                 if(strlen($order))
                    $sql = "select * from (".$sql.") as t1 GROUP BY ".$group." order by ".$order;
                
                if($rows>0){
                   
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
                
		//print "<br>CAGR=".$sql;
                echo "<div class='' style='display:none'>$sql</div>";
		if($type=="name")
			$this->setFetchMode('ASSOC');
		$this->execute($sql);
                //mysql_query($sql) or die(mysql_error());
                

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
		//pr($return_array);
		return $return_array;
	}
        
        
        
        
           function SearchHomeGrowth_WithCharges($chargewhere,$fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("c.CAGR_Id,c.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." c ,plstandard a";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
                if(strlen($order))   $sql.= " ORDER BY a.FY DESC ";
                
                 if(strlen($order))
                    $sql = "select * from (".$sql.") as t1 GROUP BY ".$group." order by ".$order;
                
                if($rows>0){
                   
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$limit= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
                
	
                
		if($type=="name")
			$this->setFetchMode('ASSOC');
	
                //mysql_query($sql) or die(mysql_error());
                $sqlwithcharges = 'SELECT * FROM (SELECT `CIN`,`Date of Charge` dateofcharge,`Charge amount secured` chargeamt,`Charge Holder` chargeholder FROM fd2_index_of_charges WHERE   '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  '.$limit;

                	//print "<br><br>CAGRwithcharge = " .$sqlwithcharges; 
                       // exit;
                        
                	$this->execute($sqlwithcharges);
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
		//pr($return_array);
		return $return_array;
	}
        
        
        
          function SearchHomeGrowth_WithCharges_cnt($chargewhere,$fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("c.CAGR_Id,c.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
//		if($fields != '*')
//			$fields = implode(",", $fields);

		$sql = "SELECT b.SCompanyName, b.CIN FROM ".$this->dbName." c ,plstandard a";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
                //if(strlen($order))   $sql.= " ORDER BY a.FY DESC ";
                
                 if(strlen($group))
                    $sql = "select * from (".$sql.") as t1 GROUP BY ".$group;
                 
                 
//                 if(strlen($order))
//                    $sql = $order." order by ".$order;
                
                if($rows>0){
                   
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$limit= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
                
	
                
		if($type=="name")
			$this->setFetchMode('ASSOC');
	
                //mysql_query($sql) or die(mysql_error());
               $sqlwithcharges = 'SELECT count(*) as count FROM (SELECT `CIN` FROM fd2_index_of_charges WHERE   '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  '.$limit;

                	//print "<br><br><br>count = " .$sqlwithcharges; 
                        //exit;
                        
                	$this->execute($sqlwithcharges);
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
		//pr($return_array);
		return $return_array;
	}
        
        function SearchHomeExport1($fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("c.CAGR_Id,c.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." c ,plstandard a";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
                if(strlen($order))   $sql.= " GROUP BY b.Company_Id ORDER BY a.FY DESC ";
                
                 if(strlen($order))
                    $sql = "select * from (".$sql.") as t1 group by ".$group." order by ".$order;
                
                if($rows>0){
                   
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
		
		//pr($return_array);
		return $sql;
	}
        
        
        
        
        function SearchHomeExport1_WithCharges($chargewhere,$fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("c.CAGR_Id,c.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);
                        $fields.='  ,b.CIN';

		$sql = "SELECT ".$fields." FROM ".$this->dbName." c ,plstandard a";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
                if(strlen($order))   $sql.= " ORDER BY a.FY DESC ";
                
                 if(strlen($order))
                    $sql = "select * from (".$sql.") as t1 group by ".$group." order by ".$order;
                
                if($rows>0){
                   
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
		
                
               $sqlwithcharges = 'SELECT * FROM (SELECT `CIN`,`Date of Charge` dateofcharge,`Charge amount secured` chargeamt,`Charge Holder` chargeholder FROM fd2_index_of_charges WHERE   '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  '.$limit;
              // echo "<br>".$sqlwithcharges;
		return $sqlwithcharges;
	}
        
        function SearchHomeExport($fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("a.CAGR_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$esql = "SELECT ".$fields." FROM ".$this->dbName." a , cprofile b";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $esql.= " WHERE ".$where;
		if(strlen($group))   $esql.= " GROUP BY ".$group;
		if(strlen($order))   $esql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$esql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
//		print $sql;
		if($type=="name")
			$this->setFetchMode('ASSOC');
		//print $esql;
		return $esql;
	}
        function ExporttoExcel($esql){
            
                //print $esql;
		$this->execute($esql);
		
		//print $this->execute($sql);
		$return_array = array();
		$cont=0;
                
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
		return $return_array;
          
	}
	function CheckUserNameExists($username){
		if(strlen($username)){
			$sql = "select * from ".$this->dbName." where `UserName` = '".$username."'";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$this->elements = $this->fetch();
		}
	}


	function getCompanies($where,$order){
		$sql = "select Company_Id, FCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}

	function getCompaniesAutoSuggest($where,$order){
		$sql = "select Company_Id, FCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT 0,10";
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}
	
	

	function getCompaniesCompare($where,$order){
		$sql = "select Company_Id, SCompanyName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}
	
	function deleteCompany($ID){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where CId_FK = $ID";
			$rs = $this->execute($sql);
			
		}
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

  	function SearchHomeGrowth_cnt($fields="",$where="",$order="FCompanyName asc",$group=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("c.CAGR_Id,c.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";

		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." c ,plstandard a";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
                if(strlen($order))   $sql.= " GROUP BY b.Company_Id ORDER BY a.FY DESC ";
                
                 if(strlen($order))
                    $sql = "SELECT t1.PLStandard_Id AS NumberOfCom,t1.MaxResultType from (".$sql.") as t1 GROUP BY ".$group." order by ".$order;
        
        $sql = "SELECT count(NumberOfCom) from (" . $sql . ") v1";
        //print "<br>CAGR=".$sql;
                
		$this->execute($sql);
		
		$return_array=$this->fetch();   
                
		return $return_array[0];
	}

	function SearchHomeGrowthOpt($fields="",$where="",$order="FCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
//		if(!strlen($pageID)) $pageID=1;
//		if(!strlen($rows))  $rows=7000;
		if(!strlen($fields[0])) $fields=array("c.CAGR_Id,c.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." c ,plstandard a";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where))   $sql.= " WHERE ".$where;
                if(strlen($order))   $sql.= " GROUP BY b.Company_Id ORDER BY a.FY DESC ";
                
                 if(strlen($order))
                    $sql = "select * from (".$sql.") as t1 GROUP BY ".$group." order by ".$order;
                
                if($rows>0){
                   
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
                
		//print "<br>CAGR=".$sql;
                
		if($type=="name")
			$this->setFetchMode('ASSOC');
		$this->execute($sql);
                //mysql_query($sql) or die(mysql_error());
                

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

  //               $innerSQL = "SELECT ".$fields." FROM ".$this->dbName." c ,plstandard a";
  //               $innerSQL .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		// //$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		// if(strlen($where))   $innerSQL.= " WHERE ".$where. " and b.Company_Id = ".$rs['Company_Id']."  and a.ResultType = ".$rs['MaxResultType']."";
  //               if(strlen($order))   $innerSQL.= " GROUP BY b.Company_Id ORDER BY a.FY DESC ";
                
  //                if(strlen($order))
  //                   $innerSQL = "select * from (".$innerSQL.") as t1 GROUP BY ".$group." order by ".$order;
                
  //               if($rows>0){
                   
  //               if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		// $innerSQL.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
  //               }
                /*$innerSQL = mysql_query($innerSQL);
                while ($rowsx=mysql_fetch_array($innerSQL)){
					$return_array[$cont]=$rowsx; 
   				}*/
				//print_r($return_array[$cont]);
				$cont++;
				//echo $cont;
				//echo '<br/>';
				//print_r($rs);
			}
                       
		}
		//pr($return_array);
		return $return_array;
	}

	function deleteCompanyWithType($ID, $result_type){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where CId_FK = " . $ID . " AND ResultType = " . $result_type;
			$rs = $this->execute($sql);
			
		}
	}

}//End of Class
?>