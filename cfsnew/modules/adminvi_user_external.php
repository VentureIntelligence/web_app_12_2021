<?php

class adminviuserexternal extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function adminviuserexternal() {
		
		database::database();	
		
		$this->elements["user_name"]      = "";
		$this->elements["password"]      = "";
		$this->elements["email"]     = "";		
		$this->elements["first_name"]      = "";
		$this->elements["last_name"]         = "";
		$this->elements["created_on"]      = "";
		$this->elements["last_login"]    = "";
		$this->elements["is_deleted"]    	 = "";
		$this->elements["is_enabled"]    	 = "";
		$this->elements["external_api_access"] = "";
		$this->elements["admin_api_access"] = "";
		

		$this->pkName="id";
		$this->dbName="adminvi_user_external";

	}
	
	function update($values) {

		$this->elements=$values;

		$this->elements[$this->pkName] = (!strlen($this->elements[$this->pkName]) || $this->elements[$this->pkName]=="") ? -1 : $this->elements[$this->pkName];	

		if ($this->elements[$this->pkName]!=-1) 
			$sql = $this->getUpdateSQL();
		else 
			$sql = $this->getInsertSQL();

		//pr($sql); exit();
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
		if(!strlen($fields[0])) $fields=array("state_id","state_name");
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
		// pr($sql);
		// exit();
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
			$sql = "select * from ".$this->dbName." where ".$this->pkName."=$ID AND is_deleted = 0";
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

	function soft_delete($ID){
	
		if(strlen($ID)){
			
			$sql = "UPDATE " . $this->dbName . " SET is_deleted = 1, usr_flag = 0 WHERE ".$this->pkName."=$ID";
			$rs = $this->execute($sql);
		}
	}
	

	function CheckUserNameExists($username){

            $sql = "select * from ".$this->dbName." where UserName = '".$username."'";

            $qry = mysql_query($sql);
            //$no = mysql_num_rows($qry);
            $res = mysql_fetch_assoc($qry);
            $this->elements = $res;
            return $res;
                    
        //                    $this->setFetchMode('ASSOC');                    
        //                    $this->execute($sql);
        //                    //echo $sql.'<br><br>';
        //                    $rs = $this->fetch();
        //                    
        //                    return $rs; 
		 
	}
	

	function selectByUName($user_name){
	
		if(strlen($user_name)){
			$sql = "select * from ".$this->dbName." where UserName = '".$user_name."' ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}

	function selectByEmail($email){
	
		if(strlen($email)){
			$sql = "select * from ".$this->dbName." where Email = '".$email."' ";
			$this->setFetchMode('ASSOC');
			$this->execute($sql);
			$rs = $this->fetch();
			return $rs; 
		}
	}
	function usernamesuggest($where,$order){
		$sql = "select id,user_name from ".$this->dbName;
	   if(strlen($where)) $sql.= " WHERE ".$where;
	   if(strlen($order)) $sql.= " ORDER BY ".$order;
	   //pr($sql);exit();
	   $this->execute($sql);
	   $return_array = array();
	   while ($rs = $this->fetch()) {
		   $return_array[$rs[0]]= $rs[1];
		   $cont++;
	   }
			  
	   return $return_array;
   }
   function emailsuggest($where,$order){
	$sql = "select id,email from ".$this->dbName;
   if(strlen($where)) $sql.= " WHERE ".$where;
   if(strlen($order)) $sql.= " ORDER BY ".$order;
   //pr($sql);exit();
   $this->execute($sql);
   $return_array = array();
   while ($rs = $this->fetch()) {
	   $return_array[$rs[0]]= $rs[1];
	   $cont++;
   }
		  
   return $return_array;
}
//    function mailcount($where=""){
			
// 	$sql = "select count(*) as total from dealmembers";
// 	if(strlen($where))  $sql.= " WHERE ".$where."";
// 	$result=mysql_query($sql);
// 	$rs =mysql_fetch_array($result);
// 	$sql1 = "select count(*) as total  from malogin_members";
// 	if(strlen($where))  $sql1.= " WHERE ".$where."";
// 	$result1=mysql_query($sql1);
// 	$rs1 =mysql_fetch_array($result1);
// 	//$rs1 = $this->fetch();
// 	$sql2 = "select count(*) as total from RElogin_members";
// 	if(strlen($where))  $sql2.= " WHERE ".$where."";
// 	$result2=mysql_query($sql2);
// 	$rs2 =mysql_fetch_array($result2);
// 	if($rs['total'] >0 || $rs1['total'] >0 || $rs2['total']>0)
// 	{return 1;}
	
	
	
// }	

function mailcount($where=""){
			
	$sql = "select count(*) as total from dealmembers";
	if(strlen($where))  $sql.= " WHERE  EmailId =".$where;
	$result=mysql_query($sql);
	if($rs['total'] ==0){
		$rs =mysql_fetch_array($result);
		$sql1 = "select count(*) as total  from malogin_members";
		if(strlen($where))  $sql1.= " WHERE  EmailId =".$where;
		$result1=mysql_query($sql1);
		$rs1 =mysql_fetch_array($result1);
		if($rs1['total'] ==0){
			$sql2 = "select count(*) as total from RElogin_members";
			if(strlen($where))  $sql2.= " WHERE   EmailId =".$where;
			$result2=mysql_query($sql2);
			$rs2 =mysql_fetch_array($result2);
			if($rs2['total']==0){
				$sql3 = "select count(*) as total from adminvi_user_external";
				if(strlen($where))  $sql3.= " WHERE   email =".$where;
				$result3=mysql_query($sql3);
				$rs3 =mysql_fetch_array($result3);
				if($rs3['total']>0){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 1;
			}
		}else{
			return 1;
		}
	}else{
		return 1;
	}
	//pr($sql3);
	// if($rs['total'] >0 || $rs1['total'] >0 || $rs2['total']>0 || $rs3['total']>0)
	// {return 1;}
	
	
	
}	
	



}//End of Class
?>