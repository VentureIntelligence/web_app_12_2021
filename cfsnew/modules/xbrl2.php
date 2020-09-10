<?php

class xbrl2 extends database {

	var $elements;
	var $pkName;
	var $dbName;

	function xbrl2() {

		database::database();
		$this->elements["CIN"]           = "";
		$this->elements["xml_type"]      = "";
		$this->elements["excel_type"]    = "";
		$this->elements["PL_link"]       = "";
		$this->elements["CF_link"]       = "";
		$this->elements["SHP_link"] 	 = "";
		$this->elements["isXBRL"]	     = "";
		$this->elements["Added_Date"]    = "";
		$this->elements["updated_date"]  = "";
		$this->elements["run_id"]  		 = "";

		$this->pkName="id";
		$this->dbName="xbrl2";

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

		if(!($this->error)) {
			return true;
		} else {
			return false;
		}
    }
    

	function select($runID='',$ID='', $logfile='', $orderby = '') {
		if( !empty( $runID ) && !empty( $ID ) && !empty( $logfile ) ) {
			$sql = "select * from ".$this->dbName." where cin='". $ID ."' AND run_id ='" . $runID . "' AND log_file='" . $logfile . "'";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
		} else if( !empty( $runID ) && !empty( $ID ) ) {
			$sql = "select * from ".$this->dbName." where cin='". $ID ."' AND run_id ='" . $runID . "'";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
		} else if(strlen($ID)){
			$sql = "select * from ".$this->dbName." where cin='". $ID ."'".$orderby;
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
		} else {
			$sql = "select * from ".$this->dbName." where run_id='" . $runID . "'";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
		}
		$cont=0;
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$cont]=$rs;
			$cont++;
		}
		return $return_array;
	}

}//End of Class
?>