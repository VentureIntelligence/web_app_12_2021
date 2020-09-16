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
		$this->elements["total_profit_loss_for_period"]           = "";
		$this->elements["profit_loss_of_minority_interest"]           = "";

		$this->elements["EmployeeRelatedExpenses"]               = "";
		$this->elements["ForeignExchangeEarningandOutgo"]        = "";
		$this->elements["EarninginForeignExchange"]              = "";
		$this->elements["OutgoinForeignExchange"]                = "";
		$this->elements["AddFinancials"]                = "";
		$this->elements["EBT_before_Priod_period"]              = "";
		$this->elements["Priod_period"]                = "";

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
//echo "sql=="; echo $sql;
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

	function getFieldValue($fields,$where="",$type="num"){
		
		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		$sql.= " WHERE ".$where;

		if($type=="name")
			$this->setFetchMode('ASSOC');
               // print $sql;exit();
		$this->execute($sql);

		$result = array();
		$cont=0;
		if($fields=="*")
			$result=$this->fetch();
		else{
			while ($rs = $this->fetch()) {
				$result[$cont]=$rs;
				$cont++;
			}
		}
		return $result;
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
                //print $sql;
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
        
        function SearchHome_WithCharges($chargewhere,$fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
               
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);
                        $fields.='  ,b.CIN';
		$sql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b";

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		  $limit= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
             
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
                
                $return_array = array();
		 
                $sqlwithcharges = 'SELECT * FROM (SELECT `CIN`,`Date of Charge` dateofcharge,`Charge amount secured` chargeamt,`Charge Holder` chargeholder FROM index_of_charges WHERE   '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  '.$limit;
                
                $this->execute($sqlwithcharges);
                 
                 
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
                
		return $return_array;
          
	}
        
        function SearchHome_WithCharges_cnt($chargewhere,$fields="",$where="",$order="b.SCompanyName asc",$group=""){

		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);
                        //$fields.='  ,b.CIN';
		$sql = "SELECT ".$fields." FROM ".$this->dbName." a ";
                //$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
                
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
             
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
                $return_array = array();
              
                $sqlwithcharges = 'SELECT count(*) as count FROM (SELECT `CIN`,`Date of Charge` dateofcharge,`Charge amount secured` chargeamt,`Charge Holder` chargeholder FROM index_of_charges WHERE   '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  ';
                //print "<br><br>".$sqlwithcharges;
                $this->execute($sqlwithcharges);
                 
                $return_array = $this->fetch();   
                
                if(isset($return_array['count'])){
                    return $return_array['count'];
                }else{
                    return $return_array[0];
                }
          
	}
        
        function SearchHome_WithCharges_totcnt($chargewhere,$fields="",$where="",$order="b.SCompanyName asc",$group="",$maxFYQuery=''){
               

		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
                
		//$sql = "SELECT b.CIN FROM ".$this->dbName." a ,cprofile b";
		$sql = "SELECT b.CIN FROM ".$this->dbName." a";
		//$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		$sql .=  $maxFYQuery;

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
             
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
                
                $sqlwithcharges = 'SELECT count(*) as count FROM (SELECT `CIN` FROM index_of_charges WHERE '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  ';
                //print "<br><br>".$sqlwithcharges;        
                $this->execute($sqlwithcharges);

                
                 
                $return_array = $this->fetch();   
                
                if(isset($return_array['count'])){
                    return $return_array['count'];
                }else{
                    return $return_array[0];
                }
          
	}
        
        function SearchHome_WithChargesExport($chargewhere,$fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
               
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);
                        //$fields.='  ,b.CIN';
		$sql = "SELECT ".$fields." FROM ".$this->dbName." a ";
                //$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		  $limit= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
		//print $sql; exit;
             
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
		
                //$exp="";
                $return_array = array();
              /*  $return_array['exportsql']=$sql;*/
                
                $sqlwithcharges = 'SELECT * FROM (SELECT `CIN`,`Date of Charge` dateofcharge,`Charge amount secured` chargeamt,`Charge Holder` chargeholder FROM index_of_charges WHERE   '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  '.$limit;
                               
		return $sqlwithcharges;
          
	}
        
        function allSearchHomecount($where="",$group="",$maxFYQuery=""){
		
		if(!strlen($where)) $where="";

		/*$sql = "select count(NumberOfCom) from (SELECT a.PLStandard_Id AS NumberOfCom FROM ".$this->dbName." a ,cprofile b";*/
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		$sql = "select count(NumberOfCom) from (SELECT a.PLStandard_Id AS NumberOfCom,max(a.ResultType) as MaxResultType FROM ".$this->dbName." a";
		//$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		$sql .=  $maxFYQuery;

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group.") v1";
                
		//print $sql;
 		//echo '<div style="display:none">';print_r( $sql );echo'</div>';
		$this->execute($sql);
		
		$return_array=$this->fetch();   
                
		return $return_array[0];
          
	}
        
        function SearchHomecount($where="",$group="",$maxFYQuery="",$acrossFlag=''){
    
               
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
		if(!strlen($where)) $where="";
		if( $acrossFlag ) {
			$FYcountField = ', b.FYCount AS FYValue';
		} else {
			$FYcountField = '';
		}
		/*$sql = "select count(NumberOfCom) as NumberOfCom from (SELECT a.PLStandard_Id AS NumberOfCom" . $FYcountField . " FROM ".$this->dbName." a ,cprofile b";*/
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		$sql = "select count(NumberOfCom) as NumberOfCom from (SELECT a.PLStandard_Id AS NumberOfCom,max(a.ResultType) as MaxResultType" . $FYcountField . " FROM ".$this->dbName." a";
		//$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		$sql .=  $maxFYQuery;
                
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group.") v1";
		
		//print $sql;
		//echo '<div style="display:none">';print_r( $sql );echo'</div>';
              
		$this->execute($sql);
		
		$return_array=$this->fetch();   
                
                if(isset($return_array['NumberOfCom'])){
                    return $return_array['NumberOfCom'];
                }else{
                    return $return_array[0];
                }
		
          
	}
        
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
		//print $sql; exit;
              //print "<br><br>".$sql; 
               //echo "<div class='testtttt1DB' style='display:none'>$sql</div>";
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
		//print $sql;
                //$exp="";
                $return_array = array();
              /*  $return_array['exportsql']=$sql;*/
		$this->execute($sql);
		
		//print $this->execute($sql);
		
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
        
        function SearchHomeExport($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
    
               
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$esql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where)) $esql.= " WHERE ".$where;
		if(strlen($group))   $esql.= " GROUP BY ".$group;
		if(strlen($order))   $esql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$esql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
		
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
		//print $esql;
		return $esql;
          
	}
        
        function ExporttoExcel($esql){
            
                //print $esql."<br><br>";
                //exit;
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
               /* echo '<pre>';
                print_r($return_array);l
                echo '</pre>'*/
		return $return_array;
          
	}
        
        function SearchHomeJoin($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client=""){
               
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a  RIGHT JOIN cprofile b ON a.CId_FK = b.Company_Id ";
//		$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

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
        
        function SearchGrowthPerc($OptnlIncomeGrothPercent,$OptnlIncomeGrothYear,$where,$SearchResults,$FieldName){
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
	function radioFinacial($where,$groupby='',$type='name'){
		if(strlen($groupby))   $groupbysql = " GROUP BY ".$groupby;
		$sql = "select * from ".$this->dbName." a INNER JOIN balancesheet b ON a.FY = b.FY AND a.CID_FK = b.CID_FK where ".$where." ".$groupbysql." ORDER BY a.FY DESC";
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

        /*New Ratio Calculation*/
	function NewRatioFinacial($where,$groupby='',$type='name'){
		if(strlen($groupby))   $groupbysql = " GROUP BY ".$groupby;
		$sql = "select * from ".$this->dbName." a INNER JOIN balancesheet_new b ON a.FY = b.FY AND a.CID_FK = b.CID_FK where ".$where." ".$groupbysql." ORDER BY a.FY DESC";
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
        
        /*Export Compare Companies with heads ordered and renamed*/
	function ExportGetCompareCompaniesNew($where,$order,$type="num"){
		$sql = "select SCompanyName,FY,OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR as `Basic EPS (INR)`,DINR as `Diluted EPS (INR)` from ".$this->dbName;
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
        
        function checkfilings($client,$c){
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

    //     function getchargeholderSuggest($where,$order){
	// 	$sql = "select CIN as cin, `Charge Holder` as chargeholder from fd2_index_of_charges ";
	// 	if(strlen($where)) $sql.= " WHERE ".$where;
                
    //             $sql.=" GROUP BY `Charge Holder`  ";
                
	// 	if(strlen($order)) $sql.= " ORDER BY ".$order;
	// 	//$sql.= " LIMIT 0,10";
    //             //print_r($sql); exit;
	// 	$this->execute($sql);
               
	// 	$return_array = array();
	// 	while ($rs = $this->fetch()) {
	// 		$return_array[$rs[0]]=$rs[1];
	// 		$cont++;
	// 	}
                
	// 	return $return_array;
	// }
	function getchargeholderSuggest($where,$order){	
		$sql = "select ID as id,  `Charge Holder` as chargeholder from index_of_charges ";
		if(strlen($where)) $sql.= " WHERE ".$where;
				
				$sql.=" GROUP BY `Charge Holder`  ";
				
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT 0,10";
				//print_r($sql); exit;
		$this->execute($sql);

		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]=$rs[1];
			$cont++;
		}
					
		return $return_array;
	}

	function getcompanySuggest($where,$order){	
		// $sql = "select Company_Id, SCompanyName as companyname, Company_Id as id from cprofile";
		$sql = "select `CIN` as id, `companyName` as companyname  from index_of_charges";
		if(strlen($where)) $sql.= " WHERE ".$where;
				
				$sql.=" GROUP BY `companyName`  ";
				
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT 0,10";
				//print_r($sql); exit;
		$this->execute($sql);

		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]=$rs[1];
			$cont++;
		}
					
		return $return_array;
	}

	function getchargesholderList($field){	
	$sql = "SELECT a1.companyName as company_name, a1.CIN as cin, a1.`Charge Holder` as chargeholder, a1.SRN, a1.`Charge ID` as chargeid, a1.Created_Date, a1.Modified_Date, a1.Address, a1.`Charge amount secured` as amount, a1.`Date_Of_Satisfaction` as dateofcharge FROM index_of_charges as a1 where
		a1.CIN ='".$field."' group by chargeid";
	
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$return_array = array();
		//echo $sql;
		//exit();
		$cont=0;
	if($field=="*")
		$return_array=$this->fetch();
	else{
		while ($rs = $this->fetch()) {
			$return_array[$cont]=$rs;
			$cont++;
		}
	}

	// print_r($return_array);
	// exit();
	 return $return_array;
		
	}
	function getchargesholderListcompany($field){	
		$sql = "SELECT a1.`companyName` FROM index_of_charges as a1 where
			  
			   a1.CIN ='".$field."' group by a1.`companyName`";
		
				$this->setFetchMode('ASSOC');
				$this->execute($sql);
				$return_array = array();
			//echo $sql;
			$cont=0;
		if($field=="*")
			$return_array=$this->fetch();
		else{
			while ($rs = $this->fetch()) {
				// $return_array[$cont]=$rs;
				// $cont++;
				$return_array=$rs;
			}
		}

		//  print_r($return_array);
		//  exit();
		 return $return_array;
			
		}
		

	function getcompanyList($chargewhere,$rows,$pageID,$order){	
//echo $pageID;
		// $sql = "SELECT  a2.Company_Id as id,
		// a2.SCompanyName as company_name FROM index_of_charges as a1,cprofile as a2 where
		// a1.CIN = a2.CIN ".$chargewhere." group by a2.SCompanyName";

		// $sql = "SELECT * FROM (SELECT `CIN` as cin FROM index_of_charges as a1
		// 				WHERE ".$chargewhere." GROUP BY `CIN` ) fcin , 
		// 				(SELECT b.Company_Id as id, b.FCompanyName as company_name,b.CIN FROM plstandard a 
		// 				INNER JOIN cprofile b ON b.Company_Id = a.CId_FK 
		// 				LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id 
		// 				WHERE a.CId_FK = b.Company_Id 
		// 				GROUP BY b.Company_Id ) cp WHERE fcin.`CIN`=cp.`CIN`";
		if($order != ''){
			$order=$order;
		}else{
			$order="order by company_name asc";
		}
		$sql = "SELECT `CIN` as cin,companyName as company_name FROM index_of_charges as a1 WHERE ".$chargewhere." GROUP BY `CIN` ".$order;
					//	echo $sql; 
		 if($rows>0){
			if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
	$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
			}
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$return_array = array();
			$cont=0;
			while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				$cont++;
			}
		 return $return_array;
			
		}
		function getcompanyList_cnt($chargewhere,$rows,$pageID){	
			//echo $pageID;
						// $sql = "SELECT  a2.Company_Id as id,
						// a2.SCompanyName as company_name FROM index_of_charges as a1,cprofile as a2 where
						// a1.CIN = a2.CIN ".$chargewhere." group by a2.SCompanyName";

						// $sql = "SELECT * FROM (SELECT `CIN` FROM index_of_charges as a1
						// WHERE ".$chargewhere." GROUP BY `CIN` ) fcin , 
						// (SELECT b.Company_Id as id, b.SCompanyName as company_name,b.CIN FROM plstandard a 
						// INNER JOIN cprofile b ON b.Company_Id = a.CId_FK 
						// LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id 
						// WHERE a.CId_FK = b.Company_Id 
						// GROUP BY b.Company_Id ) cp WHERE fcin.`CIN`=cp.`CIN`";
						$sql = "SELECT `CIN` as cin,companyName as company_name FROM index_of_charges as a1 WHERE ".$chargewhere." GROUP BY `CIN` ";
						
							$this->setFetchMode('ASSOC');
							$this->execute($sql);
							//echo $sql;
							$return_array = array();
							$cont=0;
							while ($rs = $this->fetch()) {
								$return_array[$cont]=$rs;
								$cont++;
							}
						
						 return $return_array;
							
						}
		

	function getauditornameSuggest($where,$order){
		$sql = "select `auditor_name` as auditor_name from cprofile ";
		if(strlen($where)) $sql.= " WHERE ".$where. " and Permissions1 IN (0,1) AND ListingStatus IN (1,2,3,4) AND UserStatus = 0 AND Industry != '' and State != ''";
                
                $sql.=" GROUP BY `auditor_name`  ";
                
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		//$sql.= " LIMIT 0,10";
               // print_r($sql); exit;
		$this->execute($sql);
               
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[]=$rs[0];
			$cont++;
		}
                
		return $return_array;
	}

	function SearchHomeExportNew($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client="",$maxFYQuery=''){
    
               
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		//$esql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b"; // JAGADEESH
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		$esql = "SELECT ".$fields." FROM ".$this->dbName." a";
		//$esql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
                $esql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		$esql .=  $maxFYQuery;

		if(strlen($where)) $esql.= " WHERE ".$where;
		if(strlen($group))   $esql.= " GROUP BY ".$group;
		if(strlen($order))   $esql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$esql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
		
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
		return $esql;
          
	}
	function fetchCIN($tagsearch, $tagandor){
		
		$tags = ''; 
		$ex_tags = explode(',', $tagsearch);
		if (count($ex_tags) > 0) {
			for ($l = 0; $l < count($ex_tags); $l++) {
				if ($ex_tags[$l] != '') {
					$value = trim(str_replace('tag:', '', $ex_tags[$l]));
					$value = str_replace(" ", "", $value);
					if ($tagandor == 'and') {
						$tags .= " REPLACE(trim(tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
					} else {
						$tags .= " REPLACE(trim(tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
					}
				}
			}
		}
	
		if ($tagandor == 'and') {
			$tagsval = trim($tags, ' and ');
		} else {
			$tagsval = trim($tags, ' or ');
		}


		
		// $sql = "SELECT pec.CINNo as CIN from pecompanies AS pec where ($tagsval) and pec.CINNo != ''";
		$sql = "SELECT cin as CIN from cfs_tag where ($tagsval) and cin != ''";
		$resultCIN = "";
		
		//print "<br><br>".$sql;
		$this->execute($sql);
		$this->setFetchMode('ASSOC');
		while ($rs = $this->fetch()) {
			$resultCIN .="'".$rs['CIN']."'".",";
		}
		$resultCIN = rtrim($resultCIN, ',');
		return $resultCIN;
	}
	function SearchHomeOpt($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client="",$maxFYQuery){
		//if(!strlen($pageID)) $pageID=1;
		//if(!strlen($rows)) $rows=7000; //$rows=7000;
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		/*$sql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b";*/
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		$sql = "SELECT ".$fields." FROM ".$this->dbName." a";
		//$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
		$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		$sql .=  $maxFYQuery;

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
                // print "<br><br>".$sql;
		//print $sql; exit;
                /*if( $rows > 0 ) {*/
                	//print "<br><br>".$sql; 
                /*}*/
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
		//print $sql;
                //$exp="";
                $return_array = array();
              /*  $return_array['exportsql']=$sql;*/
                //echo $sql;
                //echo '<pre>'; print_r( $sql );echo '</pre>';
		$this->execute($sql);
		
		//print $this->execute($sql);
		
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
    //             $innerSQL = "SELECT ".$fields." FROM ".$this->dbName." a";
				// $innerSQL .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
				// $innerSQL .=  $maxFYQuery;

				// if(strlen($where)) $innerSQL.= " WHERE ".$where. " and b.Company_Id = ".$rs['Company_Id']."  and a.ResultType = ".$rs['MaxResultType']."";
				// if(strlen($group))   $innerSQL.= " GROUP BY ".$group;
				// if(strlen($order))   $innerSQL.= " ORDER BY ".$order;
		  //  //      if($rows>0){
		  //  //          if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
				// 	// $innerSQL.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		  //  //      }

    //             $innerSQL = mysql_query($innerSQL);
    //             while ($rowsx=mysql_fetch_array($innerSQL)){
				// 	$return_array[$cont]=$rowsx; 
   	// 			}
				$cont++;
				//echo $cont;
				//echo '<br/>';
				//print_r($rs);
			}
                       
		}
		//echo $cont;
		
		//print $return_array;
		//print_r($return_array);     
                //echo '<pre>'; print_r( $return_array );echo '</pre>';
		return $return_array;
          
	}
        
        function search_operation($search_query){
            
            $this->execute($search_query);
        }
        
	function SearchHome_WithChargesOpt($chargewhere,$fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name",$pageID=1,$rows=0,$client="", $maxFYQuery = ''){
               
		if(!strlen($fields[0])) $fields=array("a.PLStandard_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);
                        //$fields.='  ,b.CIN';
		//$sql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
                $sql = "SELECT ".$fields." FROM ".$this->dbName." a";
		//$sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK " . $maxFYQuery . "";
                $sql .= " INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY ";
		$sql .=  $maxFYQuery;

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
                if($rows>0){
                if((strlen($pageID)>0 || strlen($rows)>0) && $rows!="all" )
		  $limit= " LIMIT ".(($pageID-1)*$rows).",".($rows);
                }
		//print $sql;// exit;
                //print "<br><br>".$sql; 
             
		if($type=="name"){
			$this->setFetchMode('ASSOC');
		}
		
                //$exp="";
                $return_array = array();
                /*  $return_array['exportsql']=$sql;*/
		 
                $sqlwithcharges = 'SELECT * FROM (SELECT `CIN`,`Date of Charge` dateofcharge,`Charge amount secured` chargeamt,`Charge Holder` chargeholder FROM index_of_charges WHERE   '.$chargewhere.'    GROUP BY `CIN` ) fcin , ('. $sql .') cp WHERE fcin.`CIN`=cp.`CIN`  '.$limit;
                //print "<br><br>".$sqlwithcharges; 
                //print "<br><br>".$sqlwithcharges; 
                // $this->execute('SET SQL_BIG_SELECTS=1');
                
                 $this->execute($sqlwithcharges);
                //$this->execute($sql);
		
		//print $this->execute($sql);
		
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
		//pr($return_array);  exit;   
                
		return $return_array;
          
	}

	function updateForex( $cid, $fy, $outgoForeignExchange, $earningForeignExchange, $result_type = '' ) {
		$sql = "UPDATE ".$this->dbName." 
				SET EarninginForeignExchange = " . $earningForeignExchange . ", OutgoinForeignExchange = " . $outgoForeignExchange . " 
				WHERE CId_FK = " . $cid . " AND FY = '" . $fy . "' AND ResultType = " . $result_type. "
				";
		$this->execute($sql);
		if(!($this->error)) {
			return true;
		} else {
			return false;
		}
	}
	function updateEarnings( $cid, $fy, $BINR, $DINR, $result_type = '' ) {
		$sql = "UPDATE ".$this->dbName." 
				SET DINR = " . $DINR . ", BINR = " . $BINR . " 
				WHERE CId_FK = " . $cid . " AND FY = '" . $fy . "' AND ResultType = " . $result_type. "
				";
		$this->execute($sql);
		if(!($this->error)) {
			return true;
		} else {
			return false;
		}
	}

	function getpldata( $cid, $result_type = '' ) {
		$sql = "SELECT * FROM ".$this->dbName." 
				WHERE CId_FK = " . $cid . " AND ResultType = " . $result_type . "
				";
		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[]=$rs;
		}
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