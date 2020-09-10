<?php

class faq extends database {

	var $elements;
	var $pkName;
	var $dbName;

	function faq() {

		database::database();
		$this->elements["question"]    = "";
		$this->elements["answer"]      = "";
		$this->elements["assert"]      = "";
		$this->elements["assert_type"] = "";
		$this->elements["DBtype"]      = "";
		$this->elements["createdDate"] = "";
		$this->elements["updatedDate"] = "";
		$this->elements["status"]      = "";
		$this->elements["assertname"]  = "";
	

		$this->pkName="id";
		$this->dbName="faq";

	}

	/*function update($values) {

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
    }*/
    

	function select() {
		//if( !empty( $runID ) && !empty( $ID ) && !empty( $logfile ) ) {
			$sql = "select * from ".$this->dbName." where DBtype='CFS' AND status ='0' ORDER BY faq_order_no ASC";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
		/*} else if( !empty( $runID ) && !empty( $ID ) ) {
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
		}*/

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