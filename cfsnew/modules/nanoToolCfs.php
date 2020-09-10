<?php

class nanoToolCfs extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function nanoToolCfs() {
		
		database::database();	
		
		$this->elements["reportTitle"]      = "";
		$this->elements["reportPeriod"]     = "";		
		$this->elements["definition"]      = "";		
		$this->elements["embedCode"]      = "";
		$this->elements["date"]      = "";
                
                
		$this->pkName="id";
		$this->dbName="nanoToolCfs";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();
		
		//print_r($sql);
		//exit;
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

	

	function getFullList(){

		
		$sql = "SELECT * FROM ".$this->dbName." ";
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

	function getFullList_dateFilter($fromDate,$toDate){

		
		$sql = "SELECT * FROM ".$this->dbName." ";
                
                $sql.= " WHERE date between '".$fromDate."' and '".$toDate."'";
                
                //echo $sql; exit;
                
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

	function getOneList($id){

		
		$sql = "SELECT * FROM ".$this->dbName."  WHERE id='$id' ";
		$this->setFetchMode('ASSOC');
		$this->execute($sql);

		$return_array =$this->fetch();
                        
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


	
	function delete($ID){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where ".$this->pkName."=$ID";
			$rs = $this->execute($sql);
			
		}
	}
	

	

}//End of Class
?>