<?php

class cashflow extends database {

	var $elements;
	var $pkName;
	var $dbName;

	function cashflow() {

		database::database();

		$this->elements["CId_FK"]               	= "";
		$this->elements["IndustryId_FK"]        	= "";
		$this->elements["CashflowApplicable"]       = "";
		$this->elements["NetPLBefore"]          	= "";
		$this->elements["CashflowFromOperation"] 	= "";
		$this->elements["NetcashUsedInvestment"]	= "";
		$this->elements["NetcashFromFinance"]   	= "";
		$this->elements["NetIncDecCash"]			= "";
		$this->elements["EquivalentBeginYear"]      = "";
		$this->elements["EquivalentEndYear"]        = "";
		$this->elements["FY"]                   	= "";
		$this->elements["Added_Date"]           	= "";
		$this->elements["ResultType"]           	= "";
		$this->elements["updated_date"]           	= "";

		$this->pkName="cashflow_id";
		$this->dbName="cash_flow";

	}

	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];
        
		if ($this->elements[$this->pkName]!=-1)
			$sql = $this->getUpdateSQL();
		else
			$sql = $this->getInsertSQL();
//echo "sql=="; echo $sql;exit();
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
    
    function getFullList($pageID=1,$rows=300,$fields,$where="",$order="",$type="num",$groupby=""){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("cashflow_id");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";

		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK ";
		//$sql.= " INNER JOIN cprofile b on(CId_FK = b.Company_Id) ";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($groupby))   $sql.= " GROUP BY ".$groupby;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

		if($type=="name")
			$this->setFetchMode('ASSOC');
                //print $sql;exit();
		$this->execute($sql);

		$return_array = array();
		$cont=0;
		if($fields=="*"){
			$return_array=$this->fetch();
		}
		else{
			while ($rs = $this->fetch()) {
				
				$return_array[$cont]=$rs;
				$cont++;
			}
		}
		return $return_array;
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
}//End of Class
?>