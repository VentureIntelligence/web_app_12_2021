<?php

class users extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function users() {
		
		database::database();	
		
		$this->elements["username"]   = "";
		$this->elements["user_password"]   = "";
		$this->elements["firstname"]  = "";
		$this->elements["lastname"]   = "";
		$this->elements["email"]      = "";
		$this->elements["visitcompany"]   = "";
		$this->elements["hear"]       = "";
		$this->elements["address"]    = "";
		$this->elements["token"]      = "";
		$this->elements["usr_flag"]   = "";
		$this->elements["dob"]        = "";
		$this->elements["imagename"]  = "";
		$this->elements["TotalNetworks"]  = "";
		$this->elements["TotalAmtInvst"]  = "";
		$this->elements["stateid_FK"]  = "";		
		$this->elements["countryid_FK"]  = "";
		$this->elements["phone"]  = "";
		$this->elements["zip"]  = "";
		$this->elements["BioInfo"]  = "";
		$this->elements["Visit"] = "";
		$this->elements["GroupList"] = "";
		$this->elements["Permissions"]	=	"";
		$this->elements["CountingStatus"]	=	"";
		$this->elements["expire"]	=	"";
		$this->elements["ExpireDate"]	=	"";
		$this->elements["Industry"]	=	"";
		$this->elements["company"]	=	"";
		$this->elements["SearchVisit"]	=	"";
		$this->elements["ExDownloadCompany"]	=	"";
		$this->elements["ExDownloadCount"]	=	"";
		$this->elements["user_authorized_status"] = "";
		$this->elements["Added_Date"] = "";
        $this->elements["sendmail_cust"] = "";          
		

		$this->pkName="user_id";
		$this->dbName="users";

	}
	
	function update($values) {

		$this->elements=$values;

		$dealmemberemailsql= mysql_query("SELECT EmailId FROM dealmembers where `EmailId` = '".$this->elements["username"]."'");
		$mamemberemailsql= mysql_query("SELECT EmailId FROM malogin_members where `EmailId` = '".$this->elements["username"]."'");
		$rememberemailsql= mysql_query("SELECT EmailId FROM RElogin_members where `EmailId` = '".$this->elements["username"]."'");

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) {
			$sql = $this->getUpdateSQL();
		
		//update dealsmember
		if(mysql_num_rows($dealmemberemailsql)==1){
	    	
		$dealmembersql= "UPDATE `dealmembers` SET `Passwrd`='".md5($_POST["Password"])."' WHERE `EmailId` = '".$this->elements["username"]."'";
		}
		//update M&Amember
		if(mysql_num_rows($mamemberemailsql)==1){
		    
			$mamembersql= "UPDATE `malogin_members` SET `Passwrd`='".md5($_POST["Password"])."' WHERE `EmailId` = '".$this->elements["username"]."'";
		}
		//update REmember
		if(mysql_num_rows($rememberemailsql)==1){
		    	
			$remembersql= "UPDATE `RElogin_members` SET `Passwrd`='".md5($_POST["Password"])."' WHERE `EmailId` = '".$this->elements["username"]."'";
		}
	}
		else {
			$sql = $this->getInsertSQL();
               //echo $sql."<br><br>"; exit;
		}
		$this->execute($sql);
		$this->execute($dealmembersql);
		$this->execute($mamembersql);
		$this->execute($remembersql);

		if($this->elements[$this->pkName] == -1) {//added by prabhu
			$this->execute('SELECT LAST_INSERT_ID() as id');
			$this->setFetchMode('ASSOC');
			$rs = $this->fetch();	
			$this->elements[$this->pkName] = $rs['id'];
		}

		if(!($this->error))
			return true;		
	}
        
        
        function updateIp($values){
            $this->elements=$values;
            $this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	
            $this->dbName = "user_cfs_ipaddress";
            
            $sqlDelCompIp = "DELETE FROM `user_cfs_ipaddress` WHERE `user_id`='".$this->elements['user_id']."'";
            $this->execute($sqlDelCompIp);
            
            for($i=0;$i<count($this->elements['ipAddress']);$i++){
                $ipAddress  = $this->elements['ipAddress'][$i];
                $startRng   = $this->elements['StartRange'][$i];
                $endRng     = $this->elements['EndRange'][$i];
                
                if ($ipAddress!=''){
                    $sql = "INSERT INTO `user_cfs_ipaddress` (`user_id`,`ipAddress`,`StartRange`,`EndRange`) VALUES ('".$this->elements['user_id']."','".$ipAddress."','".$startRng."','".$endRng."')";
                    $this->execute($sql);
                }
            }
            
            if(!($this->error))
		return true;
        }
        
        function getUserIP($user_Id){
            $sql = "SELECT * FROM   `user_cfs_ipaddress` WHERE `user_id`='".$user_Id."'";
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

        
        
        function getFullList_withgroupname($pageID=1,$rows=300,$fields,$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields[0]))$fields=array("user_id","username");
		if(!strlen($where)) $where="";
		if(!strlen($order)) $order="";
	
		if($fields != '*')
			$fields = implode(",", $fields);

		$sql = "SELECT ".$fields." FROM ".$this->dbName."  LEFT JOIN grouplist ON grouplist.Group_Id=users.GroupList  ";
		
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order))   $sql.= " ORDER BY ".$order;
		$sql.= " LIMIT ".(($pageID-1)*$rows).",".($rows);

		if($type=="name")
			$this->setFetchMode('ASSOC');
		
		$this->execute($sql);
                //echo $sql;
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
        
        function count_withgroupname($where=""){
			
		$sql = "select count(".$this->pkName.") as total from ".$this->dbName."  LEFT JOIN grouplist ON grouplist.Group_Id=users.GroupList  ";;
		if(strlen($where))  $sql.= " WHERE ".$where;
		$this->setFetchMode('ASSOC');
		$this->execute($sql);
		$rs = $this->fetch();
		return $rs["total"]; 
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
			return $this->elements = $this->fetch();
		}
	}
	
	function updatepermission($Groupid,$permission){               
	
			$sql = "update ".$this->dbName." SET usr_flag=".$permission." where GroupList=".$Groupid;
                        //echo $sql."<br><br>";
			$this->execute($sql);
			 
	}
        
        
	function delete($ID){
	
		if(strlen($ID)){
			
			$sql = "delete from ".$this->dbName." where ".$this->pkName."=$ID";
                        //echo $sql;
                        //exit;
                        
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

        function usernamesuggest($where,$order){
	 	$sql = "select user_id, username from ".$this->dbName;
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
        
        

	function selectByUsername($user_name){
	
		if(strlen($user_name)){
			
			$sql = "select * from ".$this->dbName." where username= '".$user_name."' and usr_flag != 0";
			//print_r($sql);
			$this->setFetchMode('ASSOC');
			$test = $this->execute($sql);
			//print_r($test);
			$this->elements = $this->fetch();
			
		}
	}
	
	function selectByUsernameNew($user_name,$password){
	
		if(strlen($user_name)){
			$sql = "select * from ".$this->dbName." where username = '".$user_name."' and user_password = '".$password."' and usr_flag = 1 ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}


	function selectByUName($user_name){
	
		if(strlen($user_name)){
			$sql = "select * from ".$this->dbName." where username = '".$user_name."'";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
                        //echo $sql.'<br><br>';
			$rs = $this->fetch();
                        /*echo '<pre>';
                        print_r($rs);
                        echo '</pre>';*/
			return $rs; 
		}
	}

	function selectByEmail($email){
	
		if(strlen($email)){
			$sql = "select * from ".$this->dbName." where email = '".$email."' ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}


	function selectByUNameOrEmail($user_name){
	
		if(strlen($user_name)){
			$sql = "select * from ".$this->dbName." where username = '".$user_name."' or email = '".$user_name."'";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
                       // echo $sql.'<br><br>';
			$rs = $this->fetch();
			return $rs; 
		}
	}

	function selectByVisitCompany($user_id){
	
		if(strlen($user_id)){
			$sql = "select * from ".$this->dbName." where user_id = '".$user_id."' ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}
        
        function sum_searchBygroup($group_id){
	
		if(strlen($group_id)){
			$sql = "select sum(SearchVisit) as SearchVisit_sum from ".$this->dbName." where GroupList = '".$group_id."' ";
			$this->setFetchMode('ASSOC');
                        
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}

	function sum_userBygroup($group_id){
	
		if(strlen($group_id)){
			$sql = "select GROUP_CONCAT( username ) as users from ".$this->dbName." where GroupList = '".$group_id."' ";
			$this->setFetchMode('ASSOC');
                        
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}

	function sum_searchByUsers($group_id){
	
		if(strlen($group_id)){
			$sql = "select count(id) as SearchVisit_count from search_operations where user_id IN ($group_id) and CFS=1 ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}


}//End of Class
?>