<?php

class sectors extends database {
	
	var $elements;
	var $pkName;
	var $dbName;
	
	function sectors() {

		database::database();	
		
		$this->elements["SectorName"] = "";
		$this->elements["IndustryId_FK"]="";
		$this->elements["Added_Date"] = "";
		$this->elements["naics_code"] = "";

		$this->pkName="Sector_Id";
		$this->dbName="sectors";
		
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

	function getFullList($pageID=1,$rows=300,$fields=array("Sector_Id","SectorName"),$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields)) $fields=array("Sector_Id","SectorName");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName;
		
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
			
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
	
   function count($where=""){
			
		$sql = "select count(".$this->pkName.") as total from ".$this->dbName;
		if(strlen($where))  $sql.= " WHERE ".$where;
		//pr($sql);
		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$rs = $this->fetch();
		return $rs["total"]; 
	}	


	function getSectors($where,$order){
		$sql = "select Sector_Id, SectorName, IndustryId_FK from ".$this->dbName;
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
	function getSectorslist($where,$order){
		$sql = "select Sector_Id, SectorName, IndustryId_FK from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
                
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			//pr($rs);
			$return_array[$cont]= $rs[0];
			$cont++;
		}
		return $return_array;
	}	
	
        function getsingleSectors($where,$order){
		$sql = "select Sector_Id, SectorName, IndustryId_FK, naics_code from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$this->execute($sql);
		$return_array = array();
                $cont=0;
		while ($rs = $this->fetch()) {
			$return_array[$cont]= $rs[1];
			$cont++;
		}
		return $return_array;
	}

	function getSectorsNaicsCode($where){
		$sql = "select Sector_Id, SectorName, naics_code, IndustryId_FK from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$this->execute($sql);
		$return_array = array();
		while( $rs = $this->fetch() ) {
			$return_array[] = $rs[2];	
		}
		return $return_array;
	}

	function updatenaicscode( $sector_id = '', $Industry = '', $naics_code = '' ) {
		$update = "UPDATE ".$this->dbName." SET naics_code = '" . $naics_code . "' WHERE Sector_Id = " . $sector_id . " AND IndustryId_FK = '" . $Industry . "'";
		$this->execute($update);
		return true;
	}
	
}//End of Class
?>