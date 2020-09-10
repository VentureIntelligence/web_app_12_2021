<?php 
	include "header.php";
	require_once MODULES_DIR."/state.php";
	$state = new state();
        
        require_once MODULES_DIR."/city.php";
	$city = new city();
        
        if(isset($_GET['getstate']))
        {
             
        $region=$_GET['region'];
        $ex_region = explode(',',$region);
        $region_where = '';
        if(count($ex_region) > 0){
            for($g=0;$g<count($ex_region);$g++){
                $region_where .= " Region='".$ex_region[$g]."' or "; 
            }
            $region_where = trim($region_where, 'or ');
        }
        if($region_where != ''){
            $region_where = ' AND ('.$region_where. ' ) ';
        }
        if($region == null || $region == 'null'){
            $region_where = '';
        }
        $where = "state_CountryID_FK=113 ".$region_where;
        $order= "state_name";
        
	$getstate = $state->getstatefilter($where,$order);
	
       
	echo '';
	for($i=0;$i<count($getstate);$i++)
        {
        ?>
        <option value="<?php echo $getstate[$i][0]; ?>"><?php echo ucwords(strtolower($getstate[$i][2])); ?></option>
        <?php
        }
        echo '';
        }
        
       
        
        
        
         if(isset($_GET['getcity']))
        {
        $state=$_GET['state'];
        $ex_region = explode(',',$state);
        $state_where = '';
        if(count($ex_region) > 0){
            for($g=0;$g<count($ex_region);$g++){
                $state_where .= " city_StateID_FK='".$ex_region[$g]."' or "; 
            }
            $state_where = trim($state_where, 'or ');
        }
        if($state_where != ''){
            $state_where = ' AND ('.$state_where. ' ) ';
        } 
         
        if($state == null || $state == 'null'){
            $state_where = '';
        }     
        $where = "city_CountryID_FK=113 $state_where AND city_name!='Not identified - city' ";
        $order= "";
        $multi_order= " ORDER BY city_order ASC, city_name ASC";
        
	$getstate = $city->getcityfilter($where,$order,$multi_order);
	
       
	echo '';
	for($i=0;$i<count($getstate);$i++)
        {
        ?>
        <option value="<?php echo $getstate[$i][0]; ?>"><?php echo ucwords(strtolower($getstate[$i][1])); ?></option>
        <?php
        }
        echo '';
        }
        
        
        
        
         if(isset($_GET['getcitybyregion']))
        {
        $region=$_GET['region'];
        $ex_region = explode(',',$region);
        $region_where = '';
        if(count($ex_region) > 0){
            for($g=0;$g<count($ex_region);$g++){
                $region_where .= " Region='".$ex_region[$g]."' or "; 
            }
            $region_where = trim($region_where, 'or ');
        }
        if($region_where != ''){
            $region_where = ' AND ('.$region_where. ' ) ';
        } 
        if($region == null || $region == 'null'){
            $region_where = '';
        }
        $where = "state_CountryID_FK='113' $region_where  AND city_name!='Not identified - city'  ";
        $order= "";
        $multi_order= " ORDER BY city_order ASC, city_name ASC";
        
	$getstate = $city->getregionbycityfilter($where,$order,$multi_order);
	
       
	echo '';
	for($i=0;$i<count($getstate);$i++)
        {
        ?>
        <option value="<?php echo $getstate[$i][0]; ?>"><?php echo ucwords(strtolower($getstate[$i][1])); ?></option>
        <?php
        }
        echo '';
        } 
        
        mysql_close(); 
        ?>
