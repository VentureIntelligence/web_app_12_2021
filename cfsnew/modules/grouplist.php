<?php

class grouplist extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function grouplist() {
		
		database::database();	
		
		$this->elements["G_Name"]      = "";
		$this->elements["VisitLimit"]     = "";		
		$this->elements["ExLimit"]      = "";		
		$this->elements["SubLimit"]      = "";	
		$this->elements["Used"]      = "";
		$this->elements["Create_Date"]     = "";		
		$this->elements["ExCount"]      = "";		
		$this->elements["SubCount"]      = "";		
                $this->elements["poc"]      = "";
                $this->elements["Permissions"]      = "";
                $this->elements["Industry"]      = "";
                $this->elements["expiry_date"]      = "";
                $this->elements["api_access"]      = "";
				$this->elements["mobile_app_access"]      = "";
				$this->elements["admin_api_access"]    	 = "";
		
		$this->pkName="Group_Id";
		$this->dbName="grouplist";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();

                //echo $sql;
                //exit;
		$this->execute($sql);

		if($this->elements[$this->pkName] == -1) {//added by rajaraman
			$this->execute('SELECT LAST_INSERT_ID() as id');
			$this->setFetchMode('ASSOC');
			$rs = $this->fetch();	
			return $this->elements[$this->pkName] = $rs['id'];
                        
		}

		if(!($this->error))
			return true;		
	}





        function updateIp($values){
            $this->elements=$values;
            $this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	
            $this->dbName = "user_cfs_ipaddress";
            
            $sqlDelCompIp = "DELETE FROM `user_cfs_ipaddress` WHERE `group_Id`='".$this->elements['group_Id']."'";
            $this->execute($sqlDelCompIp);
            
            for($i=0;$i<count($this->elements['ipAddress']);$i++){
                $ipAddress  = $this->elements['ipAddress'][$i];
                $startRng   = $this->elements['StartRange'][$i];
                $endRng     = $this->elements['EndRange'][$i];
                
                if ($ipAddress!=''){
                    $sql = "INSERT INTO `user_cfs_ipaddress` (`group_Id`,`ipAddress`,`StartRange`,`EndRange`) VALUES ('".$this->elements['group_Id']."','".$ipAddress."','".$startRng."','".$endRng."')";
                    $this->execute($sql);
                }
            }
            
            if(!($this->error))
		return true;
        }
        
        function getGroupIP($group_Id){
            $sql = "SELECT * FROM   `user_cfs_ipaddress` WHERE `group_Id`='".$group_Id."'";
            $this->execute($sql);

		$return_array = array();
		//$return_array=$this->fetch();
                $cont=0;
                while ($rs = $this->fetch()) {
                        $return_array[$cont]=$rs;
                        $cont++;
                }
		return $return_array;
                    
        }
        
        function getGroupEmail($groupId){
            $sql = "SELECT poc FROM   ".$this->dbName." WHERE `group_Id`='".$groupId."'";
            $this->setFetchMode('ASSOC');
            $this->execute($sql);
            $return_array = $this->fetch();
            return $return_array;
        }
        
	function getFullList($pageID=1,$rows=300,$fields=array("*"),$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields)) $fields=array("*");
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
		//pr($sql);
		$this->execute($sql);

		$return_array = array();
		$cont=0;
		if($fields!="*")
			$return_array=$this->fetch();
		else{
			while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				$cont++;
			}
		}
		 //pr($return_array);
		return $return_array;
               
	}


        function getFullListwithusercount($pageID=1,$rows=300,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		//if(!strlen($fields)) $fields=array("*");
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
		//pr($sql);
                //exit;
		$this->execute($sql);

		$return_array = array();
		$cont=0;
		
			while ($rs = $this->fetch()) {
				 $return_array[$cont]=$rs;
				$cont++;
			}
		
		 // pr($return_array); exit;
                 return $return_array;
               
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

	function select($ID){
		if(strlen($ID)){
			$sql = "select * from ".$this->dbName." where ".$this->pkName."=$ID";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			return $this->elements = $this->fetch();
		}
	}
	
	
       
	
	
	function delete($ID){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where ".$this->pkName."=$ID";
			$rs = $this->execute($sql);
			
		}
	}
	
	function getGroup($where){
		$sql = "select Group_Id,G_Name from ".$this->dbName;
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

        
        function groupnamesuggest($where,$order){
		$sql = "select Group_Id,G_Name from ".$this->dbName;
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
        
        
	/* Funtion for  updateAPIAccess */ 

	function updateAPIAccess($values) { 
		$sqlUpdateAPIAccess = "update grouplist set api_access=".$values['api_access'].",admin_api_access= ".$values['admin_api_access']."
		 WHERE `Group_Id`='".$values['Group_Id']."'";
        $this->execute($sqlUpdateAPIAccess);
		if(!($this->error))
			return true; 
	}



}//End of Class
?>