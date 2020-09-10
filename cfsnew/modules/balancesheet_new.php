<?php

class balancesheet_new extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function balancesheet_new() {
		
		database::database();	
		
		$this->elements["CID_FK"]            = "";
		$this->elements["IndustryId_FK"]        = "";
		$this->elements["ShareCapital"]          = "";
		$this->elements["ReservesSurplus"]          = "";		
		$this->elements["TotalFunds"] = "";		
		$this->elements["ShareApplication"]          = "";		
		$this->elements["N_current_liabilities"]               = "";
		$this->elements["L_term_borrowings"]               = "";
		$this->elements["O_long_term_liabilities"]             = "";
		$this->elements["L_term_provisions"]                 = "";		
		$this->elements["T_non_current_liabilities"]         = "";		
		$this->elements["Current_liabilities"]                  = "";		
		$this->elements["S_term_borrowings"]                  = "";
		$this->elements["Trade_payables"]                  = "";
		$this->elements["O_current_liabilities"]                   = "";
		$this->elements["S_term_provisions"]                   = "";
		$this->elements["T_current_liabilities"]          = "";
		$this->elements["T_equity_liabilities"]                 = "";
		$this->elements["Assets"]                   = "";
		$this->elements["N_current_assets"]                 = "";
		$this->elements["Fixed_assets"]          = "";		
		$this->elements["Tangible_assets"] = "";		
		$this->elements["Intangible_assets"]          = "";		
		$this->elements["T_fixed_assets"]               = "";
		$this->elements["N_current_investments"]             = "";
		$this->elements["Deferred_tax_assets"]                 = "";		
		$this->elements["L_term_loans_advances"]         = "";		
		$this->elements["O_non_current_assets"]                   = "";
		$this->elements["T_non_current_assets"]                  = "";		
		$this->elements["Current_assets"]                  = "";
		$this->elements["Current_investments"]                  = "";
		$this->elements["Inventories"]                  = "";
		$this->elements["Trade_receivables"]                  = "";
		$this->elements["Cash_bank_balances"]                  = "";
                $this->elements["S_term_loans_advances"]                  = "";
                $this->elements["O_current_assets"]                  = "";
                $this->elements["T_current_assets"]                  = "";
                $this->elements["Total_assets"]                  = "";
		$this->elements["FY"]                   = "";
		$this->elements["Added_Date"]          = "";
		// $this->elements["ResultType"]                 = "";

		$this->pkName="BalanceSheet_Id";
		$this->dbName="balancesheet_new";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	
                
		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();
              // echo $sql."<br><br>"; 
              // exit;
		 $this->execute($sql);

		
		
		if($this->elements[$this->pkName] == -1) {//added by rajaraman
			$this->execute('SELECT LAST_INSERT_ID() as id');
			$this->setFetchMode('ASSOC');
			$rs = $this->fetch();	
			$this->elements[$this->pkName] = $rs['id'];
		}

		if(!($this->error)){
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

	function getFullList($pageID=1,$rows=300,$fields,$where="",$order="",$type="num",$groupby=""){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("balancesheet_Id");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		if(strlen($where)) $sql.= "WHERE ".$where;
		if(strlen($groupby))   $sql.= " GROUP BY ".$groupby;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

		if($type=="name")
			$this->setFetchMode('ASSOC');
                
                //print "<br><br>".$sql;
                mysql_query("set sql_big_selects=1");
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
        
        function getFullList_withoutPL($pageID=1,$rows=300,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("balancesheet_Id");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a  ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		if(strlen($where)) $sql.= "WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

		if($type=="name")
			$this->setFetchMode('ASSOC');
                
                //print "<br><br>".$sql;
                mysql_query("set sql_big_selects=1");
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

	function deleteCompany($ID){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where CId_FK = $ID";
			$rs = $this->execute($sql);
			
		}
	}
	function deleteBalancesheet($ID,$resultType){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where CId_FK = $ID and ResultType='$resultType'";
			$rs = $this->execute($sql);
			
		}
	}
	
	function SearchHome($fields="",$where="",$order="b.SCompanyName asc",$group="",$type="name"){
		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=250000;
		if(!strlen($fields[0])) $fields=array("a.balancesheet_Id,a.OptnlIncome");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
		
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a ,cprofile b";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";

		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		if(strlen($group))   $sql.= " GROUP BY ".$group;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);
		
		//print $sql;
		if($type=="name")
			$this->setFetchMode('ASSOC');
		
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
				$cont++;
			}
		}
		return $return_array;
	}
	


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