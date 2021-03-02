<?php

class xbrl_insert extends database {
	
	var $elements;
	var $pkName;
	var $dbName;
	
	function xbrl_insert() {

		database::database();	
		
		$this->elements["log_file"] = "";
		$this->elements["cin"]="";
		$this->elements["run_id"]="";
		$this->elements["is_error"]=0;
		$this->elements["view_index"]=0;
		$this->elements["upload_error"]=0;
		$this->elements["file_error"]=0;
		$this->elements["start_upload"]=0;
		$this->elements["isSHP"]=0;
		$this->elements["created_on"]= '';
		$this->elements["xml_type"]= '';
		$this->elements["excel_type"]= '';
		$this->elements["user_id"]= 0;
		$this->elements["user_name"]= '';
		$this->elements["run_type"]= 1;
		$this->elements["run_file"]= '';
		$this->pkName="id";
		$this->dbName="log_table";
		
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

	function update_error( $runID='',$ID='', $viewIndex = '', $logFileName = '' ) {
		$sql = "UPDATE ".$this->dbName." SET is_error = 1, view_index = " . $viewIndex . " where cin='". $ID ."' AND run_id ='" . $runID . "' AND log_file='" . $logFileName . "'";
		$this->execute($sql);
		if(!($this->error))
			return true;	
	}

	function update_upload_error( $runID='',$ID='', $viewIndex = '', $logFileName = '' ) {
		$sql = "UPDATE ".$this->dbName." SET upload_error = 1, view_index = " . $viewIndex . " where cin='". $ID ."' AND run_id ='" . $runID . "' AND log_file='" . $logFileName . "'";
		$this->execute($sql);
		if(!($this->error))
			return true;	
	}

	function update_file_error( $runID='',$ID='', $viewIndex = '', $logFileName = '' ) {
		$sql = "UPDATE ".$this->dbName." SET file_error = 1, view_index = " . $viewIndex . " where cin='". $ID ."' AND run_id ='" . $runID . "' AND log_file='" . $logFileName . "'";
		$this->execute($sql);
		if(!($this->error))
			return true;	
	}

	function update_start_upload( $runID='',$ID='', $viewIndex = '', $logFileName = '' ) {
		$sql = "UPDATE ".$this->dbName." SET start_upload = 1, view_index = " . $viewIndex . " where cin='". $ID ."' AND run_id ='" . $runID . "' AND log_file='" . $logFileName . "'";
		$this->execute($sql);
		if(!($this->error))
			return true;	
	}

	function update_SHP( $runID='',$ID='', $viewIndex = '', $logFileName = '' ) {
		$sql = "UPDATE ".$this->dbName." SET isSHP = 1 where cin='". $ID ."' AND run_id ='" . $runID . "' AND log_file='" . $logFileName . "'";
		$this->execute($sql);
		if(!($this->error))
			return true;	
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

	function selectLog( $ID='', $from_date = '', $to_date = '', $orderby = '', $groupby = '' ) {
		if( !empty( $from_date ) && !empty( $to_date ) ) {
			/*$sql = "select *, cp.Company_Id, au.Firstname, au.Lastname, au.Email from ".$this->dbName." as lt 
					LEFT JOIN cprofile as cp
					ON cp.CIN =  lt.cin
					LEFT JOIN admin_user as au
					ON au.Ident = lt.user_id
					where ( DATE(lt.created_on) BETWEEN '" . $from_date . "' AND '" . $to_date . "' )".$groupby.$orderby;*/
			$sql = "select lt.*,cp.CIN, cp.Company_Id from ".$this->dbName." as lt 
					LEFT JOIN cprofile as cp
					ON cp.CIN =  lt.cin
					where ( DATE(lt.created_on) BETWEEN '" . $from_date . "' AND '" . $to_date . "' )".$groupby.$orderby;
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
		} else if(!empty( $ID )) {
			/*$sql = "select *, cp.Company_Id, au.Firstname, au.Lastname, au.Email from ".$this->dbName." as lt
					LEFT JOIN cprofile as cp
					ON cp.CIN =  lt.cin
					LEFT JOIN admin_user as au
					ON au.Ident = lt.user_id
					where lt.cin='". $ID ."'".$groupby.$orderby;*/
			$sql = "select lt.*,cp.CIN, cp.Company_Id from ".$this->dbName." as lt
					LEFT JOIN cprofile as cp
					ON cp.CIN =  lt.cin
					where lt.cin='". $ID ."'".$groupby.$orderby;
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
		} /*else {
			$sql = "select * from ".$this->dbName." where 1=1";
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
	function updateRestart( $cin = '',$runID = '', $isPLrestate = '') {
		$sql ="UPDATE `log_table` SET `ReState`='".$isPLrestate."' WHERE `cin`='".$cin."' and `run_id`='".$runID."'";
        $this->execute($sql);
	}

}//End of Class
?>