<?php

class adminusermodule extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function adminusermodule() {
		
		database::database();	
		
		$this->elements["module"]      = "";
		$this->elements["admin_permission"]      = "";
		$this->elements["intern_permission"]     = "";
		$this->pkName="id";
		$this->dbName="admin_user_module";

	}
		

	function select($ID){
		if(strlen($ID)){
			$sql = "select * from ".$this->dbName." where ".$this->pkName."=$ID";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$this->elements = $this->fetch();
		}
	}	

	function selectByType($user_type = ''){
		if( $user_type == 2 ) {
			$where = " where intern_permission = 1";
		} else if( $user_type == 1 ) {
			$where = " where admin_permission = 1";
		} else {
			$where = ' where 1=1';
		}
		$sql = "select module, id from ".$this->dbName. $where;
		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$cont = 0;
		$return_array = array();
		while ( $rs = $this->fetch() ) {
			$return_array[$cont]=$rs[ 'module' ];
			$cont++;
		}
		return $return_array; 
	}
}//End of Class
?>