<?php 

    error_reporting(0);

    include "header.php";
	
    require_once MODULES_DIR."/cprofile.php";
    $cprofile = new cprofile();

     require_once MODULES_DIR."/grouplist.php";
    $grouplist = new grouplist();

//		print $key;
    $NotFound = "No Result Found for you Search !..";
    if (preg_match('/[\'^£$%*()}{@#~?><>,|=_+¬]/', $_POST['queryString'])) {
        echo json_encode(array());
        exit;
    }
    $searchStrings = explode( ' ', $_POST['queryString'] );
    /*$where = "(FCompanyName LIKE "."'%".$_POST['queryString']."%' or SCompanyName LIKE "."'%".$_POST['queryString']."%')";
    $where .= " and  (Industry  != '' and  State  != '') ";*/

    if( count( $searchStrings ) > 1 ) {
        $joinStr = '^'.implode( '.*[[:space:]]+', $searchStrings );
        // `FCompanyName` REGEXP '^pri.*[[:space:]]+lim.*[[:space:]]+test.*' or `SCompanyName` REGEXP '^pri.*[[:space:]]+lim.*' or `FCompanyName` REGEXP '^lim.*[[:space:]]+pri.*' or `SCompanyName` REGEXP '^lim.*[[:space:]]+pri.*'
        $where = "FCompanyName REGEXP '".$joinStr."'";
        $brand_where1 = "( SCompanyName REGEXP '".$joinStr."' )";
    } else {
        //$where = "FCompanyName LIKE "."'%".$_POST['queryString']."%' or SCompanyName LIKE "."'%".$_POST['queryString']."%'";
       // $where = "FCompanyName REGEXP '^".$searchStrings[0]."' or FCompanyName REGEXP '[[:space:]]+".$searchStrings[0]."'";
        $where = "( FCompanyName REGEXP '^".$searchStrings[0]."' or FCompanyName REGEXP '[[:space:]]+".$searchStrings[0]."' ) " ;
        $brand_where1 = "( SCompanyName REGEXP '^".$searchStrings[0]."' or SCompanyName REGEXP '[[:space:]]+".$searchStrings[0]."' )";
    }
    // $where .= " and  Industry  != '' and  State  != '' ";
    // $brand_where1 .= " and  Industry  != '' and  State  != '' ";

    /*$where .= " and  (Industry  != '' and  State  != '') ";
    $brand_where1 .= " and  (Industry  != '' and  State  != '') ";*/
    
    $group = $grouplist->select($authAdmin->user->elements['GroupList']);

    /*VI5-T587 Bug: CFS Sector specific user able to see all companies*/
    if($group['Industry'] != ""){
        $where .= " and  Industry  != '' and  State  != '' and Industry IN (".$group['Industry'].")";
        $brand_where1 .= " and  Industry  != '' and  State  != '' and Industry IN (".$group['Industry'].")";
    } else {
        $where .= " and  Industry  != '' and  State  != '' ";
        $brand_where1 .= " and  Industry  != '' and  State  != '' ";
    }
    
    if($group['Permissions'] == 0){
            $where .=  " and Permissions  = ".$authAdmin->user->elements['Permissions'];
            $brand_where1 .=  " and Permissions  = ".$authAdmin->user->elements['Permissions'];
            //pr($where);
    }else if($group['Permissions'] == 1){
            $where .=  " and Permissions  = ".$authAdmin->user->elements['Permissions'];
            $brand_where1 .=  " and Permissions  = ".$authAdmin->user->elements['Permissions'];
    //	pr($where);
    }    
		
    if($authAdmin->user->elements['CountingStatus'] == 0){
            $where .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
            $brand_where1 .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
            //pr($where);
    }elseif($authAdmin->user->elements['CountingStatus'] == 1){
            $where .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
            $brand_where1 .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
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
    $limit = " LIMIT 0,10";
    $brand_limit = " LIMIT 0,3";
    $Companies = $cprofile->getCompaniesAutoSuggest($where,$order,$limit);
    $jsonarray=array();
    if(array_keys($Companies)){
            foreach($Companies as $id => $name) {
               // $jsonarray[]=array('countryname'=>addslashes($name),'countryid'=>$id, 'category'=>''); // special character in top autosuggest
               $jsonarray[]=array('countryname'=>$name,'countryid'=>$id, 'category'=>'');
                $companyID[] = (int)$id;
            }
    }else{
            //$html.="[]";
    }

    if( !empty( $companyID ) ) {
        $companyID = implode( ',', $companyID);    
        $brand_where = "Company_Id NOT IN (" . $companyID . ") AND " . $brand_where1;
    } else {
        $brand_where = $brand_where1;
    }
    $Companies_brand = $cprofile->getCompaniesAutoSuggest_brand($brand_where,$order,$brand_limit);
    if(array_keys($Companies_brand)){
        foreach($Companies_brand as $comp_brand) {
            //$bname = addslashes($comp_brand[ 'FCompanyName' ]) . ' - ' . addslashes($comp_brand[ 'SCompanyName' ]);
            //$jsonarray[]=array('countryname'=>addslashes($bname),'countryid'=>$comp_brand[ 'id' ], 'category'=>'---------------'); // special character in top autosuggest
            $bname = $comp_brand[ 'FCompanyName' ] . ' - ' . $comp_brand[ 'SCompanyName' ];
            $jsonarray[]=array('countryname'=>$bname,'countryid'=>$comp_brand[ 'id' ], 'category'=>'---------------');
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