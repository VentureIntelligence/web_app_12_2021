<?php

class balancesheet extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function balancesheet() {
		
		database::database();	
		
		$this->elements["CID_FK"]            = "";
		$this->elements["IndustryId_FK"]        = "";
		$this->elements["ShareCapital"]          = "";
		$this->elements["ShareApplication"]          = "";		
		$this->elements["ReservesSurplus"] = "";		
		$this->elements["TotalFunds"]          = "";		
		$this->elements["SecuredLoans"]               = "";
		$this->elements["UnSecuredLoans"]               = "";
		$this->elements["LoanFunds"]             = "";
		$this->elements["OtherLiabilities"]                 = "";		
		$this->elements["DeferredTax"]         = "";		
		$this->elements["SourcesOfFunds"]                  = "";		
		$this->elements["GrossBlock"]                  = "";
		$this->elements["LessAccumulated"]                  = "";
		$this->elements["NetBlock"]                   = "";
		$this->elements["CapitalWork"]                   = "";
		$this->elements["FixedAssets"]          = "";
		$this->elements["IntangibleAssets"]                 = "";
		$this->elements["OtherNonCurrent"]                   = "";
		$this->elements["Investments"]                 = "";
		$this->elements["DeferredTaxAssets"]          = "";		
		$this->elements["SundryDebtors"] = "";		
		$this->elements["CashBankBalances"]          = "";		
		$this->elements["Inventories"]               = "";
		$this->elements["LoansAdvances"]             = "";
		$this->elements["OtherCurrentAssets"]                 = "";		
		$this->elements["CurrentAssets"]         = "";		
		$this->elements["CurrentLiabilities"]                   = "";
		$this->elements["Provisions"]                  = "";		
		$this->elements["CurrentLiabilitiesProvision"]                  = "";
		$this->elements["NetCurrentAssets"]                  = "";
		$this->elements["ProfitLoss"]                  = "";
		$this->elements["Miscellaneous"]                  = "";
		$this->elements["TotalAssets"]                  = "";
		$this->elements["FY"]                   = "";
		$this->elements["Added_Date"]          = "";
		$this->elements["ResultType"]                 = "";

		$this->pkName="BalanceSheet_Id";
		$this->dbName="balancesheet";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();

		$this->execute($sql);

		//pr($sql);
		
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
		if(!strlen($fields[0]))$fields=array("balancesheet_Id");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		if(strlen($where)) $sql.= "WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

		if($type=="name")
			$this->setFetchMode('ASSOC');
		
		//echo $sql;
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