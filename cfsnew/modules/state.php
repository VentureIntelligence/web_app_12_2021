<?php

class state extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function state() {
		
		database::database();	
		
		$this->elements["state_id"]              = "";
		$this->elements["state_CountryID_FK"]      = "";
		$this->elements["state_name"]          = "";
		$this->elements["Flag"]    = "";
		$this->elements["Region"] = "";
		

		$this->pkName="state_id";
		$this->dbName="state";

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

	function getFullList($pageID=1,$rows=300,$fields=array("state_id","state_name"),$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields)) $fields=array("state_id","state_name");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName." ";
		
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
	

	function getState($where,$order){
	 	$sql = "select state_id, state_name from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		$this->execute($sql);
		$return_array = array();
		$this->setFetchMode('num');
		
		$cont=0;
			while ($rs = $this->fetch()) {
				$return_array[$rs[0]]= $rs[1];
				$cont++;
			}
		return $return_array;
	}	
	function getiocState(){
		$sql = "select State from index_of_charges Group by State order by State asc";
		$this->execute($sql);
		$return_array = array();
		$this->setFetchMode('num');
		
	   $cont=0;
		   while ($rs = $this->fetch()) {
			
			   $return_array[$rs[0]]= $rs[0];
			   $cont++;
		   }
		   
	   return $return_array;
   }
   function getiocCity(){
	$sql = "select City from index_of_charges Group by City order by City asc";
	$this->execute($sql);
	$return_array = array();
	$this->setFetchMode('num');
	
   $cont=0;
	   while ($rs = $this->fetch()) {
		
		   $return_array[$rs[0]]= $rs[0];
		   $cont++;
	   }
	   
   return $return_array;
}
        
        
           function getstatefilter($where,$order){
	 	$sql = "select * from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
                //echo $sql."<br><br>";
		$this->execute($sql);
		$return_array ='';
		$cont=0;
                
                while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				$cont++;
			}
                        
		
		return $return_array;
	}
        

}//End of Class
?>