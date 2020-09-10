<?php

class shp extends database {

	var $elements;
	var $pkName;
	var $dbName;

	function shp() {

		database::database();

		$this->elements["CId_FK"]       = "";
		$this->elements["CIN"]       	= "";
		$this->elements["FY"]          	= "";
		$this->elements["Shp_Name"] 	= "";
		$this->elements["Shp_Type"]		= "";
		$this->elements["Start_Value"]  = "";
		$this->elements["End_Value"]	= "";
		$this->elements["Added_Date"]   = "";
		$this->elements["Updated_Date"] = "";

		$this->pkName="shp_id";
		$this->dbName="shp";

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
    
    function getFullList($pageID=1,$rows=300,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("shp_id","SCompanyName");
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