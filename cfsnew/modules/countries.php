<?php

class countries extends database {
	
	var $elements;
	var $pkName;
	var $dbName;
	
	function countries() {

		database::database();	
		
		$this->elements["Country_Id"] = "";
		$this->elements["Country_Name"] = "";
		$this->elements["Country_Code"] = "";
		$this->elements["Country_Icode"] = "";
		$this->elements["Country_Capital"] = "";
		$this->elements["NationalitySingular"] = "";
		$this->elements["NationalityPlural"] = "";
		$this->elements["Currency"] = "";
		$this->elements["CurrencyCode"] = "";

		$this->pkName="Country_Id";
		$this->dbName="countries";
		
		$this->AreaTable=NEW_AREA_TABLE;//by anega prabhu for table name changed on 16.08.10

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();

		$this->execute($sql);

		if(!($this->error))
			return true;		
	}

	function getFullList($pageID=1,$rows=300,$fields=array("Country_Id","Country_Name"),$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields)) $fields=array("Country_Id","Country_Name");
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
	
	function getCountries($where,$order){
		$sql = "select Country_Id, Country_Name from ".$this->dbName;
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
	
	
	function getCountryList($where){
		$sql = "select * from ".$this->dbName;
		if(strlen($where))  $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
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

	function getAlphabetCountry($where){
		$sql = "select * from ".$this->dbName;
		if(strlen($where))  $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
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
        function getsinglecountry($where){
		$sql = "select Country_Id, CONCAT(UCASE(MID(LCASE(Country_Name),1,1)),MID(LCASE(Country_Name),2)) AS Country_Name from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
                //print $sql;
		$this->execute($sql);
		$return_array = array();
                $cont=0;
		while ($rs = $this->fetch()) {
			$return_array[$cont]= $rs[1];
			$cont++;
		}
		return $return_array;
	}
	
	
}//End of Class
?>