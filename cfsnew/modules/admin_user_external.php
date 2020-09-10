<?php

class adminuserexternal extends database {
	
	var $elements;
	var $pkName;
	var $dbName;

	function adminuserexternal() {
		
		database::database();	
		
		$this->elements["UserName"]      = "";
		$this->elements["Password"]      = "";
		$this->elements["Firstname"]     = "";		
		$this->elements["Lastname"]      = "";
		$this->elements["Email"]         = "";
		$this->elements["usr_flag"]      = "";
		$this->elements["Added_Date"]    = "";
		$this->elements["usr_type"]    	 = "";
		$this->elements["api_access"]    	 = "";
		$this->elements["external_api_access"] = "";
		

		$this->pkName="Ident";
		$this->dbName="admin_user_external";

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
		$sql = "select Ident,UserName from ".$this->dbName;
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
	$sql = "select Ident,Email from ".$this->dbName;
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
	
function mailcount($where=""){
			
	$sql = "select count(*) as total from users";
	if(strlen($where))  $sql.= " WHERE  email = ".$where;
	$result=mysql_query($sql);
	$rs =mysql_fetch_array($result);
	//$count=mysql_num_rows($result);
	//pr($sql);
	$count=$rs['total'];
	if($count !=''){
		
	if($count==0 )
	{	
		$sql1 = "select count(*) as total  from admin_user_external";
		if(strlen($where))  $sql1.= " WHERE  Email = ".$where;
		$result1=mysql_query($sql1);
		$rs1 =mysql_fetch_array($result1);
		$count1=$rs1['total'];
		
		if($count1>0)
		{
			return 1;
			
		}else{
			return 0;
		}
	}else{
		return 1;
	}
}
	
	
	// pr($rs['total']);
	//  pr($sql);
	//  pr($sql1);
	
	// if($rs['total'] >0 || $rs1['total'] >0 )
	// return 1;
	
	
	
}	



}//End of Class
?>