<?php
$StateWhere = "state_CountryID_FK = 113";
$order7="state_name asc";
$template->assign("state" , $state->getState($StateWhere,$order7));

//pr($authAdmin);

//pr($_SESSION);
/*pr($_COOKIE);

print session_id();*/
//left panel
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$filters=array();

$currentpage = curPageName();
$template->assign("currentpage",$currentpage);

$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount1 = $grouplist->getFullList('','',$fields2,$where2);
$template->assign("grouplimit",$toturcount1);
//pr($toturcount1);

$companylimit = count($authAdmin->user->elements['company']);
$companylimit1 = $companylimit - 1;
//pr($companylimit1);

if($companylimit1 != 0){
	$template->assign("companylimit",$companylimit1);
}else{
    $value='Unlimited';
	$template->assign("companylimit",$value);
}

$template->assign("fdownload",$authAdmin->user->elements['ExDownloadCount']);

//pr($authAdmin->user->elements['Permissions']);
//pr($_REQUEST['permission']);
if($authAdmin->user->elements['Permissions'] == 0){
	$where3 .=  "b.Permissions1  = ".$authAdmin->user->elements['Permissions']." and ";
	//pr($where);
}elseif($authAdmin->user->elements['Permissions'] == 1){
	$where3 .=  "b.Permissions1  = ".$authAdmin->user->elements['Permissions']." and ";
//	pr($where);
}elseif($authAdmin->user->elements['Permissions'] == 2){
	$where3 .=  "b.Permissions1  = 0 and ";
//	pr($where);
}


if($authAdmin->user->elements['CountingStatus'] == 0){
	$where3 .=  "b.UserStatus  = ".$authAdmin->user->elements['CountingStatus']." and";;
	//pr($where);
}elseif($authAdmin->user->elements['CountingStatus'] == 1){
	$where3 .=  "b.UserStatus  = ".$authAdmin->user->elements['CountingStatus']." and";
}elseif($authAdmin->user->elements['CountingStatus'] == 2){
	$where3 .=  "b.UserStatus  = 0 and";
}	

$fields3 = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, b.Company_Id, b.FCompanyName,b.ListingStatus,b.UserStatus","a.TotalIncome","b.FYCount","b.Permissions1","b.SCompanyName");
$where3 .= " a.CId_FK = b.Company_Id"; // Original Where
$group3 = " b.SCompanyName ";
//pr($where3);
/*$SearchResults = $plstandard->SearchHome($fields3,$where3,$order3,$group3);
//pr($SearchResults);
$totcprofile1=count($SearchResults);
//pr($totcprofile1);
$template->assign("totcprofile1",$totcprofile1);

$limitno=$totcprofile1-$toturcount1[3];
$template->assign("limitno",$limitno);*/
//pr($limitno);
$order12 = " SectorName ASC";

$indust = $industries->getIndustries($where10,$order10);

$template->assign("industries" ,$indust);
$template->assign("sectors" , $sectors->getSectors($where12,$order12));

/*Year Starts*/
	for($i=2011; $i>=2006; $i--){
		$test = str_split($i,2);
		//$test = ereg_replace("[^0-9]", "", $i);
		$BYearArry[$test[1]] =  $i;	
	}
	
	for($i=1980; $i<=2013; $i++){
		$BYearArry1[$i] = $i;	
	}
//	pr($BYearArry1);
//	pr($BYearArry);
	$template->assign('selectedYear', $Selectedyear);
	$template->assign('BYearArry', $BYearArry);
	$template->assign('BYearArry1', $BYearArry1);
        
/*Year Ends*/	
if($authAdmin->user->elements['Permissions'] == 0){
	$where41 .=  "Permissions1  = ".$authAdmin->user->elements['Permissions'];
	//pr($where);
}elseif($authAdmin->user->elements['Permissions'] == 1){
	$where41 .=  "Permissions1  = ".$authAdmin->user->elements['Permissions'];
//	pr($where);
}elseif($authAdmin->user->elements['Permissions'] == 2){
	$where41 .=  "(Permissions1  = 0 or Permissions1  = 2)";
//	pr($where);
}	

if($authAdmin->user->elements['CountingStatus'] == 0){
	if($where41 != ''){
		$where41 .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
	}else{
		$where41 .=  "UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
	}
	//pr($where);
}elseif($authAdmin->user->elements['CountingStatus'] == 1){
	if($where41 != ''){
		$where41 .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
	}else{
		$where41 .=  "UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
	}
}elseif($authAdmin->user->elements['CountingStatus'] == 2){
	if($where41 != ''){
		$where41 .=  " and (UserStatus =0 or UserStatus =1)";
	}else{
		$where41 .=  "(UserStatus =0 or UserStatus =1)";
	}
}
//$matches1 = implode(',', unserialize($authAdmin->user->elements['company']));
//pr($authAdmin->user->elements['company']);
//if(count($matches1) > 0){
	//	if($where4 != ''){
		//	$where4 .=  " and Company_Id IN (".$matches1.")";
		//}else{
			// $where4 .=  " Company_Id IN (".$matches1.")";
		//}
//}


//pr(unserialize($authAdmin->user->elements['Industry']));
//$matches = implode(',', unserialize($authAdmin->user->elements['Industry']));
//pr($matches);
//pr(count($matches));
//if(count($matches) > 0){
	//if($where4 != ''){
		//$where4 .=  " and Industry IN (".$matches.")";
	//}else{
		// $where4 .=  " Industry IN (".$matches.")";
	//}
	//pr($where);
//}

if($where41 != ''){
	$where41 .= " and FYCount != 0";
}else{
	$where41 .= " FYCount != 0";
}
//pr($where41);
$order41 = " SCompanyName ASC";
$test = $cprofile->getCompaniesCompare($where41,$order41);

$test1 = $cprofile->count($where98);
//$test2 = count($test1);
//pr(count($test));
//pr($test);
//pr($where4);
$template->assign("companies" , $test);

//Total No of Companies in the database
//$count1 = 1;
//$result = mysql_query("SELECT * FROM plstandard a ,cprofile b WHERE a.CId_FK = b.Company_Id and a.ResultType=0 GROUP BY b.SCompanyName");
//while($row = mysql_fetch_array($result))
//{
//  $count1++;
//}
//$template->assign("totcprofile2",$count1);
//
////Total No of Companies in the Detailed Financials
//$count = 1;
//$result = mysql_query("SELECT * FROM plstandard a ,cprofile b WHERE a.CId_FK = b.Company_Id and a.ResultType=0 and b.UserStatus = 0 GROUP BY b.SCompanyName");
//while($row = mysql_fetch_array($result))
//{
//  $count++;
//}
//
//$template->assign("companies1",$count);


$template->assign("REQUEST_Answer",$_REQUEST['answer']);
$template->assign("REQUEST",$_REQUEST);
//$ind=$industries->getIndustries($where5,$order5);
//print_r($ind);
//$template->assign("industries" , $ind);
if($_REQUEST['answer']['Industry']!=""){
    $where12 = " IndustryId_FK = ".$_REQUEST['answer']['Industry'];
}
$order6 = "SectorName asc";
$sec=$sectors->getSectors($where12,$order6);
$template->assign("sectors" , $sec);

if(count($_REQUEST)>0 )
{ 
    if ($_REQUEST['answer']['Region']!="") {     
        $region_where = '';
        foreach($_REQUEST['answer']['Region'] as $regions){
            $region_where .=  "  Region = "."'".$regions."' or ";
}
        if(trim($region_where) != ''){
            $region_where = " ( ".trim($region_where,'or ').' ) ';
        }
        $StateWhere = "state_CountryID_FK = 113  AND $region_where" ;         
    }
}
else {
$StateWhere = "state_CountryID_FK = 113";
}

$states=$state->getState($StateWhere,$order7);
$template->assign("state" , $states);

 if ($_REQUEST['answer']['Region']!="" && $_REQUEST['answer']['State']=="") { 
            $region_where = '';
            foreach($_REQUEST['answer']['Region'] as $regions){
                $region_where .= "  region = "."'".$regions."' or";
            }
            if(trim($region_where) != ''){
                $region_where = " ( ".trim($region_where,'or').' ) ';
            }
            $where = "state_CountryID_FK='113' and $region_where  AND city_name!='Not identified - city'  ";
            $order= "";
            $multi_order= " ORDER BY city_order ASC, city_name ASC";
       
            $cities=$city->getregion_by_cityfilter($where,$order, $multi_order);
           // print_r($cities); exit;
            
}
else if ($_REQUEST['answer']['State']!="") { 
    
                $state_where = '';
                foreach($_REQUEST['answer']['State'] as $states){
                    $state_where .=  "  city_StateID_FK = "."'".$states."' or ";
                }
                if(trim($state_where) != ''){
                    $stateWhere = " ( ".trim($state_where,'or ').' ) ';
                }
            
                $order= "";
                $multi_order= " ORDER BY city_order ASC, city_name ASC";
            $cities=$city->getCity($stateWhere,$order, $multi_order);
          
}
else {
$multi_order= " ORDER BY city_order ASC, city_name ASC";
$cities=$city->getCity('','',$multi_order);
}

$template->assign("city" ,$cities);

$fliterlist=array();
$i=0;
if(count($_REQUEST)>0 )
{   
if ($_REQUEST['answer']['Industry']!="")
$fliterlist[$i++]=array('field'=>'Industry','key'=>$_REQUEST['answer']['Industry'],'value'=>$indust[$_REQUEST['answer']['Industry']]);

if ($_REQUEST['answer']['Sector']!="")
$fliterlist[$i++]=array('field'=>'Sector','key'=>$_REQUEST['answer']['Sector'],'value'=>$sec[$_REQUEST['answer']['Sector']]);

if ($_REQUEST['ListingStatus']!="")
$fliterlist[$i++]=array('field'=>'ListingStatus','key'=>$_REQUEST['ListingStatus'],'value'=>"Listed");

if ($_REQUEST['ListingStatus1']!="")
$fliterlist[$i++]=array('field'=>'ListingStatus1','key'=>$_REQUEST['ListingStatus1'],'value'=>"Privately held(Ltd)");

if ($_REQUEST['ListingStatus2']!="")
$fliterlist[$i++]=array('field'=>'ListingStatus2','key'=>$_REQUEST['ListingStatus2'],'value'=>"Partnership");

if ($_REQUEST['ListingStatus3']!="")
$fliterlist[$i++]=array('field'=>'ListingStatus3','key'=>$_REQUEST['ListingStatus3'],'value'=>"Proprietorship");

if ($_REQUEST['answer']['Permissions']==="0")
$fliterlist[$i++]=array('field'=>'Permissions','key'=>$_REQUEST['answer']['Permissions'],'value'=>"PE Backed");

if ($_REQUEST['answer']['Permissions2']=="1")
$fliterlist[$i++]=array('field'=>'Permissions2','key'=>$_REQUEST['answer']['Permissions2'],'value'=>"Non-PE Backed");

if ($_REQUEST['answer']['Region']!=""){
   $im_Region = implode($_REQUEST['answer']['Region'],',');
$fliterlist[$i++]=array('field'=>'Region','key'=>$im_Region,'value'=>$im_Region);
}
if ($_REQUEST['answer']['State']!="")
$fliterlist[$i++]=array('field'=>'State','key'=>$statevalue,'value'=>$statevalue);

if ($_REQUEST['answer']['City']!="")
$fliterlist[$i++]=array('field'=>'City','key'=>$cityvalue,'value'=>$cityvalue);

if ($_REQUEST['answer']['YearGrtr']!="")
$fliterlist[$i++]=array('field'=>'YearGrtr','key'=>$_REQUEST['answer']['YearGrtr'],'value'=>"AFTER ".$BYearArry1[$_REQUEST['answer']['YearGrtr']]);

if ($_REQUEST['answer']['YearLess']!="")
$fliterlist[$i++]=array('field'=>'YearLess','key'=>$_REQUEST['answer']['YearLess'],'value'=>"BEFORE ".$BYearArry1[$_REQUEST['answer']['YearLess']]);

/*
if ($_REQUEST['ResultType']==="0")
$fliterlist[$i++]=array('field'=>'ResultType','key'=>$_REQUEST['ResultType'],'value'=>"Standalone");

if ($_REQUEST['ResultType']==="1")
$fliterlist[$i++]=array('field'=>'ResultType','key'=>$_REQUEST['ResultType'],'value'=>"Consolidated");
*/

//pr($fliterlist);


//left panel

if ($_REQUEST['Crores']=="10000000")
$fliterlist[$i++]=array('field'=>'Crores','key'=>$_REQUEST['Crores'],'value'=>"Fin.In Crores");

if ($_REQUEST['arcossall']!="")
$fliterlist[$i++]=array('field'=>'arcossall','key'=>$_REQUEST['arcossall'],'value'=>"Fin.".$_REQUEST['arcossall']);





// index of charges filters

if(isset($_REQUEST['chargefromdate']) && $_REQUEST['chargefromdate']!='' ){ 
    $fliterlist[$i++]=array('field'=>'#chargefromdate,#chargetodate','key'=>'','value'=>'Charge Date');
}
if(isset($_REQUEST['chargefromamount']) && $_REQUEST['chargefromamount']!='' ){ 
    $fliterlist[$i++]=array('field'=>'#chargefromamount,#chargetoamount','key'=>'','value'=>'Charge Amount');
}
if(isset($_REQUEST['chargeholdertest']) && $_REQUEST['chargeholdertest']!='' ){
    $fliterlist[$i++]=array('field'=>'#chargeholder','key'=>'','value'=>'Charge Holder');
}
if(isset($_REQUEST['auditorname']) && $_REQUEST['auditorname']!='' ){
    $fliterlist[$i++]=array('field'=>'#auditorname','key'=>'','value'=>'Auditor Name');
}
if(isset($_REQUEST['chargeaddress']) && $_REQUEST['chargeaddress']!=''){ 
    $fliterlist[$i++]=array('field'=>'#chargeaddress','key'=>'','value'=>'Charge Address');
}
if(isset($_REQUEST['answer']['City']) && $_REQUEST['answer']['City']!=''){ 
    $fliterlist[$i++]=array('field'=>'#city','key'=>'','value'=>'City');
}
if(isset($_REQUEST['tagsearch_auto']) && $_REQUEST['tagsearch_auto']!=''){ 
    $tagsearch = "tag:" . trim($_REQUEST['tagsearch_auto']);
    $fliterlist[$i++]=array('field'=>'#tagsearch_auto','key'=>'','value'=>$tagsearch);
}



}

$finstr="";
$finsearcharray=array('Revenue','EBITDA','EBDT','EBT','Net Profit','Total Debt','Networth','Capital Employed');
$finsfilterarray=array('Fin.Rev','Fin.EBITDA','Fin.EBDT','Fin.EBT','Fin.N_Profit','Fin.Total_Debt','Fin.Networth','Fin.Capital_Employed');
//echo count($_REQUEST['answer']['SearchFieds']);
if(count($_REQUEST['answer']['SearchFieds'])>0)
{
    for($j=0;$j<count($_REQUEST['answer']['SearchFieds']);$j++)
    {
        if($_REQUEST['answer']['SearchFieds'][$j]!=""){
       $gtr=$_REQUEST['Grtr_'.$j];
       $les=$_REQUEST['Less_'.$j];
       $finstr=$finstr.'<tr ><th>'.$finsearcharray[$_REQUEST['answer']['SearchFieds'][$j]].'<input  type="hidden"  name="answer[SearchFieds][]" id="answer[SearchFieds][]" value="'.$_REQUEST['answer']['SearchFieds'][$j].'" /></th><td> <input  type="text" name="Grtr_'.$j.'" id="Grtr_'.$j.'" value="'.$gtr.'" />  </td><td><input  type="text" name="Less_'.$j.'" id="Less_'.$j.'" value="'.$les.'" />  </td></tr>';
        $fliterlist[$i++]=array('field'=>'SearchFieds','key'=>$j,'value'=>$finsfilterarray[$_REQUEST['answer']['SearchFieds'][$j]].'('.$gtr.'-'.$les.')');}
    }
    $template->assign("finfieldshtml",$finstr);
}
if ($_REQUEST['YOYCAGR']=="gacross")
$fliterlist[$i++]=array('field'=>'YOYCAGR','key'=>$_REQUEST['YOYCAGR'],'value'=>"Grw.ALL YEARS");


if ($_REQUEST['YOYCAGR']=="gAnyOf")
$fliterlist[$i++]=array('field'=>'YOYCAGR','key'=>$_REQUEST['YOYCAGR'],'value'=>"Grw.ANY YEARS");


if ($_REQUEST['YOYCAGR']=="CAGR")
$fliterlist[$i++]=array('field'=>'YOYCAGR','key'=>$_REQUEST['YOYCAGR'],'value'=>"Grw.CAGR");

// T975 RATIO BASED
$ratiostr="";
$ratiosearcharray=array('Current Ratio','Quick Ratio','Debt Equity Ratio','RoE','RoA','Asset Turnover Ratio','EBITDA Margin. (%)','PAT Margin. (%)', 'Contribution margin. (%)');
$ratiofilterarray=array('Rat.Current Ratio','Rat.Quick Ratio','Rat.Debt Equity Ratio','Rat.RoE','Rat.RoA','Rat.Asset Turnover Ratio','Rat.EBITDA Margin','Rat.PAT Margin', 'Rat.Contribution margin');


if(count($_REQUEST['answer']['RatioSearchFieds'])>0)
{
    $ratio_feilds = array();
    for($j=0;$j<count($_REQUEST['answer']['RatioSearchFieds']);$j++)
    {
        if($_REQUEST['answer']['RatioSearchFieds'][$j]!=""){
            $gtr=$_REQUEST['RGrtr_'.$j];
            $les=$_REQUEST['RLess_'.$j];
            $ratiostr=$ratiostr.'<tr ><th>'.$ratiosearcharray[$_REQUEST['answer']['RatioSearchFieds'][$j]].'<input  type="hidden"  name="answer[RatioSearchFieds][]" id="answer[RatioSearchFieds][]" value="'.$_REQUEST['answer']['RatioSearchFieds'][$j].'" /></th><td> <input  type="text" class="rfvalid" name="RGrtr_'.$j.'" id="RGrtr_'.$j.'" value="'.$gtr.'" />  </td><td><input  type="text" class="rfvalid" name="RLess_'.$j.'" id="RLess_'.$j.'" value="'.$les.'" />  </td></tr>';
            $fliterlist[$i++]=array('field'=>'RatioSearchFieds','key'=>$j,'value'=>$ratiofilterarray[$_REQUEST['answer']['RatioSearchFieds'][$j]].'('.$gtr.'-'.$les.')');
        }
        $ratio_feilds[] = $_REQUEST['answer']['RatioSearchFieds'][$j]; 
    }
    // print_r($ratio_feilds);
    $template->assign("ratiofieldshtml",$ratiostr);
    $template->assign("ratio_feilds",$ratio_feilds);
}

if ($_REQUEST['arcossallr']!="")
$fliterlist[$i++]=array('field'=>'arcossallr','key'=>$_REQUEST['arcossallr'],'value'=>"Rat.".$_REQUEST['arcossallr']);
// T975 END

$grostr="";
$growsearcharray=array('Revenue','EBITDA','EBDT','EBT','Net Profit','Across all','In any of');
$growfilterarray=array('Grw.Revenue','Grw.EBITDA','Grw.EBDT','Grw.EBT','Grw.Net Profit','Grw.Across all','Grw.In any of');
//echo count($_REQUEST['answer']['SearchFieds']);
if(count($_REQUEST['answer']['GrowthSearchFieds'])>0)
{
    for($j=0;$j<count($_REQUEST['answer']['GrowthSearchFieds']);$j++)
    {
         if($_REQUEST['answer']['GrowthSearchFieds'][$j]!=""){
       $gtr=$_REQUEST['GrothPerc_'.$j];
       $les=$_REQUEST['Less_'.$j];
       $grostr=$grostr.'<tr ><th>'.$growsearcharray[$_REQUEST['answer']['GrowthSearchFieds'][$j]].'<input  type="hidden"  name="answer[GrowthSearchFieds][]" id="answer[GrowthSearchFieds][]" value="'.$_REQUEST['answer']['GrowthSearchFieds'][$j].'" /></th><td> <input  type="text" name="GrothPerc_'.$j.'" id="Grtr_'.$j.'" value="'.$gtr.'" />  </td><td>
           <select id="NumYears_'.$j.'" name="NumYears_'.$j.'">
           <option value="2" '.(($_REQUEST['NumYears_'.$j]==2)?'selected':"").'>2</option>
           <option value="3" '.(($_REQUEST['NumYears_'.$j]==3)?'selected':"").'>3</option>
           <option value="4" '.(($_REQUEST['NumYears_'.$j]==4)?'selected':"").'>4</option>
           <option value="5" '.(($_REQUEST['NumYears_'.$j]==5)?'selected':"").'>5</option></select>  </td></tr>';
       
       $fliterlist[$i++]=array('field'=>'GrowthSearchFieds','key'=>$j,'value'=>$growfilterarray[$_REQUEST['answer']['GrowthSearchFieds'][$j]].'('.$gtr.'%)');
         }
    }
    $template->assign("growthfieldshtml",$grostr);
}
$template->assign("fliters",$fliterlist);



?>
