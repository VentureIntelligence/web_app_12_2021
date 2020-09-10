<?php

class industries extends database {
	
	var $elements;
	var $pkName;
	var $dbName;
	
	function industries() {

		database::database();	
		
		$this->elements["IndustryName"] = "";
		$this->elements["Added_Date"] = "";

		$this->pkName="Industry_Id";
		$this->dbName="industries";
		
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
	
	
	function getIndustries($where,$order){
             
		 $sql = "select Industry_Id, IndustryName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY".$order;
		$sql.= " ORDER BY IndustryName";
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}	
        
        
        function getIndustriesname($where){
		 $sql = "select Industry_Id AS id, IndustryName AS name from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		$sql.= "  ORDER BY IndustryName";
                
		 $this->execute($sql);
//                print_r($rr); echo "<br><br><br>";
               $return_array = array();
               $cont=0;
		while ($rs = $this->fetch()) {
//			$return_array["id"]= $rs[0];
//                        $return_array["name"]= $rs[1];
                        
                        $return_array[$cont]=array('id' => $rs[0],  'name' =>$rs[1]  );
                        
			$cont++;
		}
		return $return_array;
	}

        function getsingleIndustries($where,$order){
		 $sql = "select Industry_Id, IndustryName from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY".$order;
		$sql.= " ORDER BY IndustryName";
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