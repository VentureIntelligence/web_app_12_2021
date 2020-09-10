<?php

class status extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function status() {
		
		database::database();	
		
		$this->elements["UsrId_FK"]   = "";
		$this->elements["Status"]   = "";

		$this->elements["Added_Date"] = "";
		

		$this->pkName="Ident";
		$this->dbName="status";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();
		$this->execute($sql);

		if($this->elements[$this->pkName] == -1) {//added by prabhu
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
		if(!strlen($fields[0]))$fields=array("user_id","username");
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
	

	function userss($where,$order){
	 	$sql = "select id, username from ".$this->dbName;
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

	function selectByUsername($user_name){
	
		if(strlen($user_name)){

			$sql = "select * from ".$this->dbName." where `username` = '".$user_name."' and usr_flag != 0";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$this->elements = $this->fetch();
			
		}
	}
	
	function selectByUsernameNew($user_name,$password){
	
		if(strlen($user_name)){
			$sql = "select * from ".$this->dbName." where `username` = '".$user_name."' and  user_password =  '".$password."' and usr_flag = 0";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}


	function selectByUName($user_name){
	
		if(strlen($user_name)){
			$sql = "select * from ".$this->dbName." where `username` = '".$user_name."' ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}

	function selectByEmail($email){
	
		if(strlen($email)){
			$sql = "select * from ".$this->dbName." where `email` = '".$email."' ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}



}//End of Class
?>