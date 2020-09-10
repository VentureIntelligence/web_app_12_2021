<?php 

    error_reporting(0);

    include "header.php";
	
    require_once MODULES_DIR."/cprofile.php";
    $cprofile = new cprofile();

     require_once MODULES_DIR."/grouplist.php";
    $grouplist = new grouplist();

//		print $key;
    $NotFound = "No Result Found for you Search !..";
    $where = "(FCompanyName LIKE "."'%".$_POST['queryString']."%' or SCompanyName LIKE "."'%".$_POST['queryString']."%')";
    $where .= " and  (Industry  != '' and  State  != '') ";

    $group = $grouplist->select($authAdmin->user->elements['GroupList']);

    if($group['Permissions'] == 0){
            $where .=  " and Permissions  = ".$authAdmin->user->elements['Permissions'];
            //pr($where);
    }else if($group['Permissions'] == 1){
            $where .=  " and Permissions  = ".$authAdmin->user->elements['Permissions'];
    //	pr($where);
    }    
		
    if($authAdmin->user->elements['CountingStatus'] == 0){
            $where .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
            //pr($where);
    }elseif($authAdmin->user->elements['CountingStatus'] == 1){
            $where .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
    }	

    if($authAdmin->user->elements['company'] != ''){
            //$matches1 = implode(',', unserialize($authAdmin->user->elements['company']));
            //pr($authAdmin->user->elements['company']);
            //if(count($matches1) > 0){
                    //$where .=  " and b.Company_Id IN (".$matches1.")";
                    //pr($where);
            //}
    }
    if($authAdmin->user->elements['Industry'] != ''){
            //pr(unserialize($authAdmin->user->elements['Industry']));
            //$matches = implode(',', unserialize($authAdmin->user->elements['Industry']));
            //pr($matches);
            //pr(count($matches));
            //if(count($matches) > 0){
                    //	$where .=  " and b.Industry IN (".$matches.")";
                    //pr($where);
            //}
    }
    $where4 .= " and FYCount != 0";
    $Companies = $cprofile->getCompaniesAutoSuggest($where,$order);
    $jsonarray=array();
    if(array_keys($Companies)){
            foreach($Companies as $id => $name) {
                    $jsonarray[]=array('countryname'=>addslashes($name),'countryid'=>$id);
            }
    }else{
            //$html.="[]";
    }	
    echo json_encode($jsonarray);
?>
<?php
/*   $db = new mysqli('DB_HOST', 'USERNAME' ,'PASSWORD', 'DATABASE_NAME');
	
	if(!$db) {
	
		echo 'Could not connect to the database.';
	} else {
	
		if(isset($_POST['queryString'])) {
			$queryString = $db->real_escape_string($_POST['queryString']);
			
			if(strlen($queryString) >0) {

				$query = $db->query("SELECT country FROM countries WHERE country LIKE '$queryString%' LIMIT 10");
				if($query) {
				echo '<ul>';
					while ($result = $query ->fetch_object()) {
	         			echo '<li onClick="fill(\''.addslashes($result->country).'\');">'.$result->country.'</li>';
	         		}
				echo '</ul>';
					
				} else {
					echo 'OOPS we had a problem :(';
				}
			} else {
				// do nothing
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
*/?>
<?php
/*  	$con = mysql_connect("ventureintelligence.ipowermysql.com","cpslogin","Cps$2010");
	mysql_select_db("cps", $con);
	if($_POST['queryString']!=''){
		$result1 = mysql_query("SELECT `Company Name`,`CIN` FROM `cin_detail` WHERE `Company Name` LIKE '$queryString%' order by `Company Name` LIMIT 0,20");
		$html .= '<ul>';
			while($result = mysql_fetch_array($result1)){
				$html.="<li style='cursor:pointer;'onClick='fill(\"".addslashes($result['Company Name'])."\"),fillHidden(\"".$result['CIN']."\")';>".$result['Company Name']."</li>";
			}
			if(mysql_num_rows($result1)==0){
				$html.="<li>".$NotFound."</li><style type='text/css'>#finreq{display:block;}</style>";
			}	
		echo $html."</ul>";
	}  */
?>