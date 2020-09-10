<?php

class city extends database {
	
	var $elements;
	var $pkName;
	var $dbName;
	
	function city() {

		database::database();	
		
		$this->elements["city_id"] = "";
		$this->elements["city_CountryID_FK"] = "";
		$this->elements["city_name"] = "";
		$this->elements["city_StateID_FK"] = "";
		$this->elements["Flag"] = "";
		

		$this->pkName="city_id";
		$this->dbName="city";
		
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

	function getFullList($pageID=1,$rows=300,$fields=array("city_id","city_name"),$where="",$order="",$type="num"){

		if(!strlen($pageID)) $pageID=1;
		if(!strlen($rows)) $rows=20;
		if(!strlen($fields)) $fields=array("city_id","city_name");
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
	
	
	function getCity($where="",$order="",$multi_order=''){
	 	$sql = "select city_id, CONCAT(UCASE(MID(LCASE(city_name),1,1)),MID(LCASE(city_name),2)) AS city_name from ".$this->dbName;
		if(strlen($where))  $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
		if(strlen($multi_order)) $sql.= " $multi_order";
		if(strlen($order)==0 && strlen($multi_order)==0){
			$sql.= " ORDER BY TRIM(city_name) ASC";
		}
                //echo "<div style='display:none'>$sql</div>";
		$this->execute($sql);
		$return_array = array();
		$this->setFetchMode('num');
		$cont=0;
                while ($rs = $this->fetch()) {
                    if($rs[1]!='Not identified - city'){
                        $return_array[$rs[0]]= ucwords($rs[1]);
                        $cont++;
                    }
                }
		return $return_array;
	}	

	function getCityList($where,$order){
		$sql = "select * from ".$this->dbName;
		if(strlen($where))  $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order;
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
        function getsinglecity($where){
		$sql = "select city_id, CONCAT(UCASE(MID(LCASE(city_name),1,1)),MID(LCASE(city_name),2)) AS city_name from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
                //print $sql;
		$this->execute($sql);
		$return_array = array();
                $cont=0;
		while ($rs = $this->fetch()) {
			$return_array[$cont]= $rs[1];
			$cont++;
		}
		return $return_array;
	}

        
         function getcityfilter($where,$order,$multi_order=''){
	 	$sql = "select city_id,city_name from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order. " ASC";
		if(strlen($multi_order)) $sql.= " $multi_order";
                //echo $sql."<br><br>";
               // exit();
		$this->execute($sql);
		$return_array ='';
		$cont=0;
                
                while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				$cont++;
			}
                        
		//print_r($return_array);
		return $return_array;
	}
        
        
          function getcityfilterSuggest($where,$order){
		$sql = "select city_id,city_name from ".$this->dbName;
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order. " ASC";
                //echo $sql."<br><br>";
               // exit();
		$this->execute($sql);
		$return_array = array();
		while ($rs = $this->fetch()) {
			$return_array[$rs[0]]= $rs[1];
			$cont++;
		}
		return $return_array;
	}
        
        
         function getregionbycityfilter($where,$order,$multi_order=''){
	 	$sql = "select city_id,city_name from ".$this->dbName. "  INNER JOIN state ON city.city_StateID_FK=state.state_id";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order. " ASC";
		if(strlen($multi_order)) $sql.= " $multi_order";
                //echo $sql."<br><br>";
               // exit();
		$this->execute($sql);
		$return_array ='';
		$cont=0;
                
                while ($rs = $this->fetch()) {
				$return_array[$cont]=$rs;
				$cont++;
			}
                        
		//print_r($return_array);
		return $return_array;
	}

        
          
        
        function getregion_by_cityfilter($where,$order,$multi_order=''){
	 	$sql = "select city_id,city_name from ".$this->dbName. "  INNER JOIN state ON city.city_StateID_FK=state.state_id";
		if(strlen($where)) $sql.= " WHERE ".$where;
		if(strlen($order)) $sql.= " ORDER BY ".$order. " ASC";
		if(strlen($multi_order)) $sql.= " $multi_order";
               // echo "<div style='display:none'>".$sql."<br><br></div>";
               // exit();
		$this->execute($sql);
		$return_array = array();
		$this->setFetchMode('num');
		$cont=0;
			while ($rs = $this->fetch()) {
				
					$return_array[$rs[0]]= ucwords(strtolower($rs[1]));
					$cont++;
				
			}
		return $return_array;
	}
                
                
	
}//End of Main Class
?>