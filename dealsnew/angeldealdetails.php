<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
  $tagandor=$_POST['tagandor'];
  $tagradio=$_POST['tagradio'];
  $invandor=$_POST['invandor'];
  $invradio=$_POST['invradio'];
  $yearafter=trim($_POST['yearafter']);
  $yearbefore=trim($_POST['yearbefore']);
  $listallcompany = $_POST['listallcompanies'];
	include ('checklogin.php');
         $videalPageName="AngelInv";  
         /* T-962 */
         $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
         $CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
         $mailurl= $CurPageURL;
          /* T-962 */
       // $mailurl= curPageURL();
        $notable=false;
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
        }
        else
        {
            $vcflagValue=2;
            $VCFlagValue=2;
        }
//========================================junaid==============================================================
        if( isset( $_POST[ 'pe_checkbox_disbale' ] ) ) {
            $pe_checkbox = $_POST[ 'pe_checkbox_disbale' ];
        } else {
            $pe_checkbox = '';
        }

        if( isset( $_POST[ 'pe_checkbox_company' ] ) ) {
            $pe_company = $_POST[ 'pe_checkbox_company' ];
        } else {
            $pe_company = '';
        }

         if( isset( $_POST[ 'hide_company_array' ] ) ) {
            $hideCompanyFlag = $_POST[ 'hide_company_array' ];
        } else {
            $hideCompanyFlag = '';
        }
//==============================================================================================================
        $resetfield=$_POST['resetfield'];
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {   
           // echo "1";
            if($getyear!="")
            {
                $month1= 01;
                $year1 = $getyear;
                $month2= 12;
                $year2 = $getyear;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
            }
            else if($getsy !='' && $getey !='')
            {
                $month1= 01;
                $year1 = $getsy;
                $month2= 12;
                $year2 = $getey;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
                //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
            }
            else
            {
                // $month1= date('n', strtotime(date('Y-m')." -2   month")); 
                // $year1 = date('Y');
                // $month2= date('n');
                // $year2 = date('Y'); 
                // if($type==1)
                // {
                //     $fixstart=1998;
                //     $startyear =  $fixstart."-01-01";
                //     $fixend=date("Y");
                //     $endyear = $endyear = date("Y-m-d");
                // }
                // else 
                // {
                //     $fixstart=2009;
                //     $startyear =  $fixstart."-01-01";
                //     $fixend=date("Y");
                //     $endyear = date("Y-m-d");
                // }
                if($type == 1)
                {
                    $month1= date('n', strtotime(date('Y-m')." - 1   month")); 
                    $year1 = date('Y');
                    $month2= date('n');
                    $year2 = date('Y'); 
                    $fixstart=1998;
                    $startyear =  $fixstart."-01-01";
                    $fixend=date("Y");
                    $endyear = date("Y-m-d");
                }
                else 
                {
                    $month1= date('n');
                    $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                    $month2= date('n');
                    $year2 = date('Y');
                    $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                    $startyear =  $fixstart."-".$month1."-01";
                    $fixend=date("Y");
                    $endyear = date("Y-m-d"); 
                }
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
         //   echo "2";
            if($resetfield=="period")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }
            elseif ($resetfield=="searchallfield")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="")
            {
                if(trim($_POST['searchallfield'])!=""){
                    if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
             $month1=01; 
             $year1 = 1998;
             $month2= date('n');
             $year2 = date('Y');
                    }else{
                        $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
                }
                if(trim($_POST['keywordsearch'])!=""  || trim($_POST['companysearch'])!=""){
                    $month1=01; 
                    $year1 = 1998;
                    $month2= date('n');
                    $year2 = date('Y');
                }
            }
            else
            {
             $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month"));
             $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
             $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
        if($resetfield=="yearfounded")
        { 
            $_POST['yearafter']="";
            $_POST['yearbefore']="";
            $yearafter="";
            $yearbefore="";
            emptyhiddendata();
        }
        else 
        {
            $yearafter=trim($_POST['yearafter']);
            $yearbefore=trim($_POST['yearbefore']);
            if($yearafter != NULL && $yearafter !='' && $yearbefore != NULL && $yearbefore !=''){
                $searchallfield='';
            }

        }
       
         if($resetfield=="keywordsearch")
            { 
             // $_POST['keywordsearch']="";
             // $keyword="";
             // $keywordhidden="";
             //  $investorauto='';
              $investorarray = explode(',', $_POST['investorauto_sug']);
              $pos = array_search($_POST['resetfieldid'], $investorarray);
              $keyword = $investorarray;
              unset($keyword[$pos]);
              $keyword = implode(',', $keyword);
              $_POST['investorauto_sug'] = $keyword;
              $keywordhidden = $keyword;
              $investorauto = $keyword;


              $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
                      
                             $sql_investorauto_sug_Exe=mysql_query($sql_investorauto_sug);
                // print_r($getInvestorSql_Exe);
                 $response =array(); 
                 $invester_filter="";
                $i = 0;
                
                if(mysql_num_rows($sql_investorauto_sug_Exe)>0){
                    
                
                 While($myrow = mysql_fetch_array($sql_investorauto_sug_Exe,MYSQL_BOTH)){
                         
                   $response[$i]['id']= $myrow['id'];
                   $response[$i]['name']= $myrow['name'];
                   if($i!=0){
                   
                       $invester_filter.=",";
                       $invester_filter_id .= ",";
                   }
                      $invester_filter.=$myrow['name'];
                      $invester_filter_id .= $myrow['id'];
                  $i++;
                  
                 }
                 
                }
                
                $investorsug_response= json_encode($response);

            }
            else 
            {
             $keyword=trim($_POST['investorauto_sug']);
             $keywordhidden=trim($_POST['keywordsearch']);
              $investorauto=$_POST['investorauto_sug'];
            
            $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
            
                   $sql_investorauto_sug_Exe=mysql_query($sql_investorauto_sug);
      // print_r($getInvestorSql_Exe);
       $response =array(); 
       $invester_filter="";
      $i = 0;
      
      if(mysql_num_rows($sql_investorauto_sug_Exe)>0){
          
      
       While($myrow = mysql_fetch_array($sql_investorauto_sug_Exe,MYSQL_BOTH)){
               
         $response[$i]['id']= $myrow['id'];
         $response[$i]['name']= $myrow['name'];
         if($i!=0){
         
             $invester_filter.=",";
             $invester_filter_id .= ",";
         }
            $invester_filter.=$myrow['name'];
            $invester_filter_id .= $myrow['id'];
        $i++;
        
       }
       
      }
      
      $investorsug_response= json_encode($response);
            }

            $keywordhidden =ereg_replace(" ","-",$keywordhidden);

             if($resetfield=="companysearch")
            { 
             $_POST['companysearch']=" ";
             $companysearch=" ";
             $companyauto='';
            }
            else 
            {
             $companysearch=trim($_POST['companysearch']);
             $companyauto=$_POST['companyauto'];
            }
             $companysearchhidden=ereg_replace(" ","_",$companysearch);

            if($resetfield=="searchallfield")
            { 
             $_POST['searchallfield']="";
             $searchallfield="";
            }
            else 
            {
             $searchallfield=trim($_POST['searchallfield']);
            }

            $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);

             if($resetfield=="industry")
            { 
             // $_POST['industry']="";
             // $industry=0;
              $pos = array_search($_POST['resetfieldid'], $_POST['industry']);
              $industry = $_POST['industry'];
              unset($industry[$pos]);
            }
            else 
            {
             $industry=$_POST['industry'];
             if($industry!='--' && $industry!='' && count($industry) >0){
                $searchallfield='';
            }
            }

             if($resetfield=="followonVCFund")
            { 
             $_POST['followonVCFund']="";
             $followonVC="--";
            }
            else 
            {
             $followonVC=trim($_POST['followonVCFund']);
             if($followonVC!='--' && $followonVC!=''){
                $searchallfield='';
            }
            }

            if($followonVC=="--")
                $followonVCFund="--";
            if($followonVC==1)
                $followonVCFund=1;
            elseif($followonVC==2)
            {
                $followonVCFund=3;
            }
             if($resetfield=="exitedstatus")
            { 
             $_POST['exitedstatus']="";
             $exitvalue="--";
            }
            else 
            {
             $exitvalue=trim($_POST['exitedstatus']);
             if($exitvalue!='--' && $exitvalue!=''){
                $searchallfield='';
            }
            }
            if($exitvalue=="--")
                $exited="--";
            elseif($exitvalue==1)
                $exited=1;
            elseif($exitvalue==2)
                $exited=3;

            if($resetfield=="txtregion")
            {
             //$_POST['txtregion']="";
                $pos = array_search($_POST['resetfieldid'], $_POST['txtregion']);
    
                $txtregion = $_POST['txtregion'];
                unset($txtregion[$pos]);
            }
            else 
            {
             $txtregion=$_POST['txtregion'];
                if($txtregion!='--' && count($txtregion) > 0){
                $searchallfield='';
            }
            }


            if($resetfield=="citysearch")
                {
             $_POST['citysearch']="";
            }
            else 
                        {
             $citysearch=trim($_POST['citysearch']);
             /*if($citysearch!='--'){
                $searchallfield='';
            }*/
                        }
//       if(($resetfield=="period" &&  $_POST) ||  $searchallfield!="")
//        { 
//        $month1="--";
//        $year1 = "--";
//        $month2="--";
//        $year2 = "--";
//        $_POST['month1']=$_POST['month2']=$_POST['year1']=$_POST['year2']="";
//        }
//        else 
//        {
//        $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
//        $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
//        $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
//        $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
//        }

        $notable=false;
        //$vcflagValue=$_POST['txtvcFlagValue'];
        //echo "<br>FLAG VALIE--" .$vcflagValue;
        $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
        $splityear1=(substr($year1,2));
        $splityear2=(substr($year2,2));

        if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
        {	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
                $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                $wheredates1= "";
        }
            $datevalueDisplay1= $sdatevalueDisplay1;
            $datevalueDisplay2= $edatevalueDisplay2;

            $wherefollowonVCFund="";
            $whereexited="";
            $whereregion="";
            $wherecity="";

            if(isset($_REQUEST['searchallfield_other'])){
            $searchallfield=$_REQUEST['searchallfield_other'];
            $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
            }
        
        if(isset($_POST['searchTagsField'])){
        $searchallfield=$_POST['searchTagsField'];
        $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                        $month1=01; 
                        $year1 = 1998;
                        $month2= date('n');
                        $year2 = date('Y');
        }

        
        if($resetfield=="tagsearch") {
            $arrayval=explode(",",$_POST['tagsearch']);
            $pos = array_search($_POST['resetfieldid'], $arrayval);
            $tagsearch = $arrayval;
            unset($tagsearch[$pos]);
            $tagsearch = implode(",",$tagsearch);
            if($tagsearch == ""){
            $tagandor = 0;
            }else{
                 $tagsearcharray = explode(',', $tagsearch);
            $response = array();
            $tag_filter = "";
            $i = 0;

            foreach ($tagsearcharray as $tagsearchnames) {
                $response[$i]['name'] = $tagsearchnames;
                $response[$i]['id'] = $tagsearchnames;
                $i++;
            }

            if ($response != '') {
                $tag_response = json_encode($response);
            } else {
                $tag_response = 'null';
            }
            }
           /* $_POST['tagsearch']="";
            $_POST['tagsearch_auto'] = "";
            $tagsearch = "";
            $tagkeyword = "";*/
            
        } else if($_POST['tagsearch']  && $_POST['tagsearch'] !='') {
            
            
            $tagsearch = $_POST['tagsearch'];
            $tagkeyword = $_POST['tagsearch'];
            $tagsearcharray = explode(',',$tagsearch);
            $response =array(); 
            $tag_filter="";
            $i = 0;

            foreach ($tagsearcharray as $tagsearchnames){ 
                $response[$i]['name']= $tagsearchnames;
                $i++;
            } 

            if($response != '')
            {
                $tag_response = json_encode($response);
            }
            else{
                $tag_response = 'null';
            }
        }

            if($industry !='' && count($industry))
            {
                $indusSql = $industryvalue = '';
                foreach($industry as $industrys)
                {
                    $indusSql .= " IndustryId=$industrys or ";
                }
                $indusSql = trim($indusSql,' or ');
                $industrysql= "select industry,industryid from industry where $indusSql";

                if ($industryrs = mysql_query($industrysql))
                {
                    While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                    {
                            $industryvalue.=$myrow["industry"].',';
                            $industryvalueid .= $myrow["industryid"] . ',';
                    }
                }
                $industryvalue=  trim($industryvalue,',');
                $industryvalueid = trim($industryvalueid, ',');
                $industry_hide = implode($industry,',');
            }
            
         if($followonVCFund =="--")
            {
                $followonVCFundText=="";
            }
            elseif($followonVCFund=="1")
            {
                $followonVCFundText="Follow on Funding";
            }
            elseif($followonVCFund=="3")
            {
                $followonVCFundText="No Funding";
            }
        if($exited =="--")
        {
            $exitedText="";
        }
        elseif($exited=="1")
        {
            $exitedText="Exited";
        }
        elseif($exited=="3")
        {
            $exitedText="Not Exited";

        }
        if($txtregion =="--")
            {
                $regionText="";
            }
            else
            {
               // $regionText="Region";
                if(count($txtregion) >0)
                {
                    $region_Sql = $regionvalue = '';
                    foreach($txtregion as $regionIds)
                    {
                        $region_Sql .= " RegionId=$regionIds or ";
            }
                    $roundSqlStr = trim($region_Sql,' or ');
                    
                     $regionSql= "select Region,RegionId from region where $roundSqlStr";
                    if ($regionrs = mysql_query($regionSql))
                    {
                            While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                            {
                                    $regionvalue .= $myregionrow["Region"].', ';
                                    $regionvalueId .= $myregionrow["RegionId"] . ', ';
                            }
                    }
                    $regionText = trim($regionvalue,', ');
                    $region_hide = implode($txtregion, ',');
		}
            }
            if($citysearch =="--")
            {
                $cityText="";
            }
            else
            {
                $cityText=$citysearch;
            }
   ?>

<?php 
	
        $tour='Allow';
	
        if($strvalue[3]=='Directory'){
            
            $dealvalue=$strvalue[2];
            $topNav = 'Directory'; 
            include_once('dirnew_header.php');
        }else{
            $topNav = 'Deals'; 
            //include_once('angelheader_search.php');
            include_once('angeldeal_header.php');
        }
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" style="margin-top:-10px">
<tr>

<td class="left-td-bg">
      <div class="acc_main" style="margin-top:10px;">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
 <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once('angelrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
     <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
<!--     <input type="hidden" name="pe_checkbox" id="pe_checkbox" value="<?php echo $pe_checkbox; ?>" />-->
<input type="hidden" name="pe_hide_companies" id="pe_hide_companies" value="<?php echo $hideCompanyFlag; ?>" />
<?php if($_POST['all_checkbox_search']==1){ ?>
    <input type="hidden" name="pe_company" id="pe_company" value="" />
    
<?php }else{ ?>
    
    <input type="hidden" name="pe_company" id="pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<?php } ?>
<input type="hidden" name="hide_pe_company" id="hide_pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<input type="hidden" name="uncheckRows" id="uncheckRows" value="<?php echo $_POST['pe_checkbox_disbale']; ?>" /> 
<input type="hidden" name="full_uncheck_flag" id="full_uncheck_flag" value="<?php echo $_POST['all_checkbox_search']; ?>" />

<?php if($_POST['real_total_inv_deal']!=''){ ?>
    <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php echo $_POST['real_total_inv_deal']; ?>" />
<?php }
if($_POST['real_total_inv_company']!='') { ?>
    <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php echo $_POST['real_total_inv_company']; ?>" />
<?php }

/*if($_POST['all_checkbox_search']==1){ */?>
    
<input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php echo $_POST['total_inv_deal']; ?>">
<input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php echo $_POST['total_inv_company']; ?>">

<?php //} 

if($_POST['pe_checkbox_enable']!=''){ ?>
    <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo $_POST['pe_checkbox_enable']; ?>">
<?php }
?>
 </div></div>
</td>

 <?php
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
		$strvalue = explode("/", $value);
		$SelCompRef=$strvalue[0];
		$searchstring=$strvalue[1];
		
		//GET PREV NEXT ID
		$prevNextArr = array();
		$prevNextArr = $_SESSION['resultId'];
                $coscount = $_SESSION['coscount'];
                $totalcount = $_SESSION['totalcount'];
		
		$currentKey = array_search($SelCompRef,$prevNextArr);
		$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
		$nextKey = $currentKey+1;

		$exportToExcel=0;
                $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
                //echo "<br>---" .$TrialSql;
                if($trialrs=mysql_query($TrialSql))
                {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                        }
                }

         //print_r($_POST);
	//$SelCompRef=$value;
  	$sql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business,
	     DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website, pec.city,pec.RegionId,pe.AngelDealId,
	     Comment,MoreInfor,r.Region,MultipleRound,FollowonVCFund,Exited,   pe.Link,pec.CINNo
	     FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec, region as r
	     WHERE pec.industry = i.industryid
	     AND pec.PEcompanyID = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15
	     and pe.AngelDealId=$SelCompRef and r.RegionId=pec.RegionId ";
	     
	//echo "<br>********".$sql;

	$investorSql="select peinv.AngelDealId,peinv.InvestorId,inv.Investor from angel_investors as peinv,
		peinvestors as inv where peinv.AngelDealId=$SelCompRef and inv.InvestorId=peinv.InvestorId ";
	//echo "<Br>Investor".$investorSql;

  	if ($companyrs = mysql_query($sql))
		{
	?>
		

		<?php
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
      $DealDate = $myrow["dt"];

			if($myrow["MultipleRound"]==1)
			{
				$multipleround="Yes";
			}
			else
			{
				$multipleround="No";
			}      
			if($myrow["FollowonVCFund"]==1)
			{    $followonFunding="Yes";}
			else
			{    $followonFunding="No";}
			if($myrow["Exited"]==1)
			{    $exitedstatus="Yes"; }
			else
			{    $exitedstatus="No";}
                        $hide_agg = $myrow["AggHide"];
	      	
		//echo "<bR>---".$valuationdata;
                        
                    $industryId=$myrow["industryId"];
                    $moreinfor=$myrow["MoreInfor"];
                    $string = $moreinfor;
                    /*** an array of words to highlight ***/
                    $words = array($searchstring);
                    //$words="warrants convertible";
                    /*** highlight the words ***/
                    $moreinfor =  highlightWords($string, $words);

                    $col6=$myrow["Link"];
                    $linkstring=str_replace('"','',$col6);
                    $linkstring=explode(";",$linkstring);      
                    
                    if($myrow["CINNo"] != ''){
                        $cinno = $myrow["CINNo"];
                    }else{
                        $cinno = 0;
                    }
                }
            }
				
?>
<td class="profile-view-left" style="width:100%;">
<!--T-962-->
<div class="result-cnt">
		<?php if ($accesserror==1){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php
        exit; 
        } 
            $pe_industries = explode(',', $_SESSION['PE_industries']);
            if(!in_array($industryId,$pe_industries)){

                echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
                exit;
            } 
        ?>                               
               <?php
                if(($industry >0 && $industry!=null)||($yearafter!= "" || $yearbefore != "")||( $followonVC!="")||($exited !="--" && $exited !="")||($txtregion != "--" && $txtregion != "")||($citysearch !="--" && $citysearch !="")||($datevalueDisplay1!="")||($companysearch!="" && $companysearch!=" ")||($searchallfield!="" && $searchallfield!=" ")||($keyword!="" && $keyword!=" ")||($tagsearch!='')){              
             if($_POST)
                    {   
                    ?>
        <div class="result-title" style="padding: 20px 0 30px;">
                  
                            
                               <h2>
                                   <?php
                                   /*if($studentOption==1 || $exportToExcel==1)
                                        {*/
                                     ?>
                                          <span class="result-no"><?php echo $totalcount;//count($prevNextArr); ?> Results Found (across <?php if($coscount !=''){echo  $coscount;}elseif($_POST['total_inv_company']!="" && $searchallfield !=''){echo $_POST['total_inv_company'];}else{echo $_POST['real_total_inv_company'];} ?> cos) </span> 
                                <?php   /*} 
                                        else 
                                        {
                                      ?>
                                             <span class="result-no"> XXX Results Found</span> 
                                   <?php
                                        }*/
                                        ?>
                              <span class="result-for"> for Angel Investments</span> 
                              </h2>
                              
           <div class="title-links">
                               
                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                    <?php 

                    if(($exportToExcel==1))
                         {
                         ?>

                                               <input class="export_new exlexport" type="submit"  value="Export" name="showdeal">


                         <?php
                         }
                     ?>
               </div> 
                               
                <?php if($datevalueDisplay1!=""){  ?>
                                    <div class="result-title" style="padding: 20px 0 10px;">
                                          <ul class="result-select" style="max-width:1440;">
                                              <li> 
                                                <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          </ul>
                <?php } 
                                
                }
                                   else 
                                   { ?> 
                                   <div class="result-title" style="padding: 20px 0 10px;">
                              <h2>
                                   <?php
                                   /*if($studentOption==1 || $exportToExcel==1)
                                        {*/
                                     ?>
                                          <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php if($coscount !=''){echo  $coscount;}elseif($_POST['total_inv_company']!="" && $searchallfield !=''){echo $_POST['total_inv_company'];}else{echo $_POST['real_total_inv_company'];} ?> cos) </span> 
                                <?php   /*} 
                                        else 
                                        {
                                      ?>
                                             <span class="result-no"> XXX Results Found</span> 
                                   <?php
                                        }*/
                                        ?>
                              <span class="result-for"> for Angel Investments</span> 
                              <span class="result-amount" id="show-total-amount">  </span> </h2>
                              
                   <?php 
               ?>
                <div class="title-links">

                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                    <?php 

                    if(($exportToExcel==1))
                         {
                         ?>

                                               <input class="export_new exlexport" type="submit"  value="Export" name="showdeal">


                         <?php
                         }
                     ?>
               </div>   
 
            
            <ul  class="result-select">
                   <?php
                if($industry >0 && $industry!=null){ ?>
               <?php 
                                    $industryarray = explode(",",$industryvalue); 
                                    $industryidarray = explode(",",$industryvalueid); 
                                    foreach ($industryarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                <?php } 
                if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                  <li> 
                     <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php }  
                if($followonVC!="--" && $followonVC!=""){ ?>
                    <li title="followonVc">
                        <?php echo $followonVCFundText ?> <a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                <?php } if($exited !="--" && $exited !=""){ ?>
                    <li  title="Exited">
                        <?php echo $exitedText?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                <?php } 
                if ($txtregion != "--" && $txtregion != "") {?>
                           <!--  <li>
                            <?php echo $regionText ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                             <?php $regionarray = explode(",",$regionText); 
                               $regionidarray = explode(",",$regionvalueId);
                                    foreach ($regionarray as $key=>$value){  if($value!=''){?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('txtregion','<?php echo $regionidarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php }} ?>
                                  <?php }
                if($citysearch !="--" && $citysearch !=""){ ?>
                    <li>
                        <?php echo $cityText?><a  onclick="resetinput('citysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                <?php } 
                if($datevalueDisplay1!=""){ ?>
                <li > 
                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('month1,year1,month2,year2');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } if($keyword!="" && $keyword!=" ") { ?>
                <?php 
                                    $investerarray = explode(",",$invester_filter); 
                                    $investeridarray = explode(",",$invester_filter_id); 
                                    foreach ($investerarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('keywordsearch',<?php echo $investeridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                <?php }
               if($companysearch!="" && $companysearch!=" "){ ?>
                <li> 
                    <?php echo $companyauto?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } 
                  if($searchallfield!="" && $searchallfield!=" "){ ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                  <?php } if($tagsearch!=''){ ?>
                <!-- <li> 
                   <?php echo "tag:".$tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li> -->
                 <?php $tagarray = explode(",",$tagsearch); 
             foreach ($tagarray as $key=>$value){  ?>
                  <li>
                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } }?> 
             </ul>
             <?php }}else{  if(!$_POST)
                    {   
                    ?>
        <div class="result-title" style="padding: 20px 0 30px;">
                  
                            
                               <h2>
                                   <?php
                                   /*if($studentOption==1 || $exportToExcel==1)
                                        {*/
                                     ?>
                                          <span class="result-no"><?php echo $totalcount;//count($prevNextArr); ?> Results Found (across <?php if($coscount !=''){echo  $coscount;}elseif($_POST['total_inv_company']!="" && $searchallfield !=''){echo $_POST['total_inv_company'];}else{echo $_POST['real_total_inv_company'];} ?> cos) </span> 
                                <?php   /*} 
                                        else 
                                        {
                                      ?>
                                             <span class="result-no"> XXX Results Found</span> 
                                   <?php
                                        }*/
                                        ?>
                              <span class="result-for"> for Angel Investments</span> 
                              </h2>
                              
           <div class="title-links">
                               
                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                    <?php 

                    if(($exportToExcel==1))
                         {
                         ?>

                                               <input class="export_new exlexport" type="submit"  value="Export" name="showdeal">


                         <?php
                         }
                     ?>
               </div> 
                               
                <?php if($datevalueDisplay1!=""){  ?>
                                    <div class="result-title" style="padding: 20px 0 10px;">
                                          <ul class="result-select" style="max-width:1440;">
                                              <li> 
                                                <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          </ul>
                <?php } 
                                
                }
                                   else 
                                   { ?> 
                                   <div class="result-title" style="padding: 20px 0 30px;">
                              <h2>
                                   <?php
                                   /*if($studentOption==1 || $exportToExcel==1)
                                        {*/
                                     ?>
                                          <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php if($coscount !=''){echo  $coscount;}elseif($_POST['total_inv_company']!="" && $searchallfield !=''){echo $_POST['total_inv_company'];}else{echo $_POST['real_total_inv_company'];} ?> cos) </span> 
                                <?php   /*} 
                                        else 
                                        {
                                      ?>
                                             <span class="result-no"> XXX Results Found</span> 
                                   <?php
                                        }*/
                                        ?>
                              <span class="result-for"> for Angel Investments</span> 
                              <span class="result-amount" id="show-total-amount">  </span> </h2>
                              
                   <?php 
               ?>
                <div class="title-links">

                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                    <?php 

                    if(($exportToExcel==1))
                         {
                         ?>

                                               <input class="export_new exlexport" type="submit"  value="Export" name="showdeal">


                         <?php
                         }
                     ?>
               </div>   
 
                 <?php
                                   }
             } ?>
           
                                
                              
        </div>

    
    <div class="list-tab mt-list-tab"><ul>
            <li><a class="postlink"  href="angelindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="angeldealdetails.php?value=<?php echo $SelCompRef."/".$vcflagValue;?>" ><i></i> Detail  View</a></li> 
            </ul></div> 
      <div class="lb" id="popup-box" style="top:100px;">
	<div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To*</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject*</h5>
                    <p>Checkout this deal - <?php echo rtrim($myrow["companyname"]);?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this deal - <?php echo rtrim($myrow["companyname"]);?> - in Venture Intelligence"  />
                    <input type="hidden" name="basesubject" id="basesubject" value="Deal" />
            </div>
            <div class="entry">
                    <h5>Link</h5>
                    <p><?php  echo $CurPageURL; ?>   <input type="hidden" name="message" id="message" value="<?php  echo $CurPageURL; ?>" />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                    <h5>Your Message</h5><span style='float:right;'>Words left: <span id="word_left">200</span></span>
                    <textarea name="ymessage" id="ymessage" style="width: 374px; height: 57px;" placeholder="Enter your text here..." val=''></textarea>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn" />
                <input type="button" value="Cancel" id="cancelbtn" />
            </div>

        </form>
    </div>
    <div class="lb" id="popup-box-financial">
        <div class="title">Send this to Venture</div>
        <form>
        <div class="entry">
               <label> To*</label>
               <input type="text" name="toaddress_fc" id="toaddress_fc"  value="research@ventureintelligence.com"/>
        </div>
        <div class="entry">
               <h5>Subject*</h5>
               <p>Request for financials linking</p>
               <input type="hidden" name="subject_fc" id="subject_fc" value="Request for financials linking"  />
        </div>
        <div class="entry">
               <h5>Link</h5>
               <p><?php  echo $CurPageURL; ?>   <input type="hidden" name="message_fc" id="message_fc" value="<?php  echo $CurPageURL; ?>"  />   <input type="hidden" name="useremail_fc" id="useremail_fc" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
        </div>
        <div class="entry">
           <input type="button" value="Submit" id="mailfnbtn" />
           <input type="button" value="Cancel" id="cancelfnbtn" />
        </div>

        </form>
    </div>  
    <div class="view-detailed"> 
         <div class="detailed-title-links"> <h2> <A href='companydetails.php?value=<?php echo $myrow["InvesteeId"];?>/<?php echo $vcflagValue;?>' >
				<?php echo rtrim($myrow["companyname"]);?></a></h2>
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="angeldealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $vcflagValue;?>">< Previous</a><?php } ?> 
        <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="angeldealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $vcflagValue;?>"> Next > </a>  <?php } ?>
        </div> 

<!--div class="alert-note">Note: Target/Company in () indicates tranche rather than a new round. Target/Company in indicates a debt investment. Not included in aggregate data.</div></div-->
  <?php if($exitedstatus!="" || $followonFunding!="" || $multipleround!="" || $myrow["dt"]!="") { ?>
    <div class="profilemain">
    <h2>Deal Info  </h2>
    <div class="profiletable">

        <ul>
          <?php if(mysql_num_rows(mysql_query($investorSql))>0){ ?>
            <li><h4>Investors</h4>
                <p>
                   <?php
					if ($getcompanyrs = mysql_query($investorSql))
					{
						$AddOtherAtLast="";
						$AddUnknowUndisclosedAtLast="";
					While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
	      			{
	      				//$AddOtherAtLast="";
	      				$Investorname=trim($myInvrow["Investor"]);
	      				$Investorname=strtolower($Investorname);

	      				$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{
	      		?>
					
                                        <?php if ($myInvrow["InvestorId"]==9 || $hide_agg==1) { ?>
                                        <?php echo $myInvrow["Investor"]; ?>
                                        <?php } else { ?>
                                        <a class="postlink" href='angleinvdetails.php?value=<?php echo $myInvrow["InvestorId"].'/'.$vcflagValue.'/';?>' ><?php echo $myInvrow["Investor"]; ?></a>
                                        <?php } ?>
                                        
                                        <br />
                            <?php
						}
						elseif(($invResult==1) || ($invResult1==1))
							$AddUnknowUndisclosedAtLast=$myInvrow["Investor"];
						elseif($invResult2==1)
						{
							$AddOtherAtLast=$myInvrow["Investor"];
						}

					}
					}
				?>
					<?php echo $AddUnknowUndisclosedAtLast; ?>

					<?php echo $AddOtherAtLast; ?>
                </p></li>
          <?php } ?>
         <?php if($exitedstatus!="") {  ?> <li><h4>Exited ?</h4><p><?php echo $exitedstatus;?></p></li> <?php } ?>
         <?php if($followonFunding!="") {  ?> <li><h4>VC Funded</h4><p><?php echo $followonFunding;?></p></li> <?php } ?>
         <?php if($multipleround!="") {  ?> <li><h4>Multiple Angel Rounds</h4><p><?php echo $multipleround;?></p></li> <?php } ?>
         <?php if($myrow["dt"]!="") {  ?> <li><h4>Date</h4><p><?php echo  $myrow["dt"];?></p></li> <?php } ?>
       </ul>

    </div>
  </div> <?php } ?>
<div class="postContainer postContent masonry-container">
  <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                    <?php
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";
				
				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
				<td width=40% ><h4>Company Name</h4><p>&nbsp;<a class="postlink" href='companydetails.php?value=<?php echo $myrow["InvesteeId"];?>/<?php echo $vcflagValue;?>' target="_blank" >
				<?php echo rtrim($myrow["companyname"]);?></a>
				</p></td>
		<?php
				}
				else
				{
					$webdisplay="";
		?>
				<td width=40% ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>
                       <?php if($myrow["industry"]!="") { ?><td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td> <?php } ?> </tr>
                        <tr>  <?php if($myrow["sector_business"]!="") { ?> <td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td>  <?php } ?>
                              <?php if($myrow["city"]!="") { ?> <td><h4>City</h4> <p><?php echo  $myrow["city"];?></p></td> <?php } ?> </tr>
                        <tr>  <?php if($myrow["Region"]!="") { ?> <td><h4>Region</h4> <p><?php echo $myrow["Region"];?></p></td> <?php } ?> </tr>
                        <tr>  <?php if($webdisplay!="") { ?><td colspan="2"><h4>Website</h4> <p style="word-break: break-all;"><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></td> <?php } ?> </tr> 
                     
                    </table>
                    </div>  
                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-Angel Inv&body=<?php echo $mailurl;?> ">
                                      Click Here</a>  to request more details (financials, valuations, etc.) to the extent available for this deal
                              </p></td></tr></table>                                          
                    </div>
                </div>	
    </div>     
<?php include('dealcompanydetails.php'); ?>   
                
</div>
<!--/table>
	
				<?php
					if(($exportToExcel==1))
					{
					?>
							<span style="float:center" class="one">
								<input type="submit"  value="Click Here To Export" name="showdeal">
							</span>

					<?php
					}
					?>
				
</td></tr></tbody!-->

</td>
</tr>
</table>
 
</div>
<style>
/*T-962 */
.result-title {
    margin-top: -10px;
    padding: 20px 0 22px;
}
.result-select{
    /* border:1px solid transparent !important; */
    margin: 5px 0 0px 0 !important;
}
/*T-962 */
div.token-input-dropdown-facebook{
    z-index: 999;
}
.popup_content ul.token-input-list-facebook{
    height: 39px !important;
    width: 537px !important;
}
.popup_main
{
        position: fixed;
        left:0;
        top:0px;
        bottom:0px;
        right:0px;
        background: rgba(2,2,2,0.5);
        z-index: 999;
}
.popup_box
{
	width:70%;
	height: 0;
	position: relative;
	left:0px;
	right:0px;
	bottom:0px;
	top:35px;
	margin: auto;
	
}

.pop_menu ul li {
    margin-right: 0;
    background: #413529;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: rgba(255,255,255,1);
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
}

.pop_menu ul li:first-child {
    margin-right: 0;
    background: #ffffff;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: #413529;
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
    border:1px solid #413529;
}
.popup_content
{
	background: #ececec;
        border:3px solid #211B15;
}
.popup_form
{
	width:700px;
	border:1px solid #d5d5d5;
	background: #fff;
	height: 40px;
}
.popup_dropdown
{
	 width: 155px;
	 margin:0px;
	 border: none;
	 height: 40px;
	 -webkit-appearance: none;
	 -moz-appearance: none;
	 appearance: none;
	 background: url("images/polygon1.png") no-repeat 95% center;
	 padding-left: 17px;
	 cursor: pointer;
	 font-size: 14px;
}
.popup_text
{
	width:538px;
	border: none;
	border-left:1px solid #d5d5d5;
	padding-left: 17px;
	box-sizing: border-box;
	height: 40px;
	font-size: 16px;
	float: right;
}
.auto_keywords
{
	position: absolute;
	top: 106px;
	width:537px;
	background: #fff;
        border:1px solid #d5d5d5;
        border-top: none;
        display: none;
}
.auto_keywords ul
{
	line-height: 25px;
	font-size: 16px;
}

.auto_keywords ul li
{
 padding-left: 20px; 
 cursor:pointer;
}
.auto_keywords ul li a
{
  text-decoration: none;
  color: #414141;
}
.auto_keywords ul li:hover
{
   background: #f2f2f2;                                 
}
.popup_btn
{
	text-align: center;
	padding: 33px 0 50px;
	
}
.popup_cancel
{
	background: #d5d5d5;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #767676;
	text-decoration: none;
	margin-right: 16px;
	font-size: 16px;
	display: none;
	
}
.popup_btn input[type="button"]
{
	background: #a27639;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #fff;
	text-decoration: none;
	font-size: 16px;
	float: right;

}
.popup_close
{
    color: #fff;
    right: 0px;
    font-size: 20px;
    position: absolute;
    top: 1px;
    width: 15px;
    background: #413529;
    text-align: center;
}
.popup_close a
{
	color: #fff;
	text-decoration: none;
	cursor: pointer;
}
.popup_searching
{
	width:538px;
	float: right;
        position: relative;
}
div.token-input-dropdown{
        z-index: 999 !important;
}

.detail-table-div { display:block; float:left; overflow:hidden;border:1px solid #B3B3B3;}
.detail-table-div table{ border-top:0 !important; border-bottom:0 !important; width:auto !important; margin:0 !important;  }
.detail-table-div th{background:#E5E5E5; text-align:right !important;}
.detail-table-div td{ background:#fff; min-width:130px; text-align:right !important;}
/*.detail-table-div th:first-child {    max-width: 280px; text-align:left !important;
    min-width: 280px;  background:#C9C2AF;}*/
.detail-table-div th:first-child {    max-width: 240px; text-align:left !important;min-width: 240px;  background:#C9C2AF;padding:8px;}
.detail-table-div td:first-child {    max-width: 240px; text-align:left !important;min-width: 240px; background:#E0D8C3;}
.detail-table-div td { padding:8px;}
    
.tab-res{ display:block; overflow-y:hidden !important; overflow:auto; border:1px solid #B3B3B3; margin:10px 0 !important;}
.tab-res table{ border-top:0 !important; border-bottom:1px solid #B3B3B3; border-right:1px solid #B3B3B3; width:auto !important; margin:0 !important;  }
.tab-res th{background:#E5E5E5; text-align:right !important;}
.tab-res td{ background:#fff; min-width:150px; text-align:right !important;padding:8px; border-right: 1px solid #b3b3b3;}
.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
    border-right: 1px solid #b3b3b3;
    text-align: left;
    padding: 8px;
    font-weight: bold;
}

.tab-res th {
    background: #E5E5E5;
    text-align: right !important;
}
detail-table-div table thead th:last-child {
    border-right: 0 !important;
}

.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
}

@media (max-width:1500px){
    .popup_content {
        background: #ececec;
        height: 500px;
        overflow-y: auto;
    }
    .popup_main {
        top: 45px;
    }
    
}

@media (max-width:1025px){
       .popup_content {
            height: 500px;
        }
        .popup_main {
            top: 80px;
        }
        
}
@media (min-width:780px){
       
    .list_companyname{
        margin-left:160px !important;
    }
}
@media (min-width:1280px){
       
    .list_companyname{
        margin-left:250px !important;
    }
}
@media (min-width:1439px){
       
    .list_companyname{
        margin-left:340px !important;
    }
}
@media (min-width:1639px){
       
    .list_companyname{
        margin-left:520px !important;
    }
}

@media (min-width:1921px){
    
    .popup_content
    {
        background: #ececec;
        height: 600px;
        overflow-y: auto;
    }
    
}
    

/* Styles */


</style>
<div class="popup_main" id="popup_main" style="display:none;">
    
<div class="popup_box">
<!--  <h1 class="popup_header">Financial Details</h1>-->
  <span class="popup_close"><a href="javascript: void(0);">X</a></span>
  <div class="popup_content" id="popup_content">

</div>

</div>	
<script>    
   
    $(document).ready(function(){
         // Tag Search
var tagsearchval = $('#tagsearch').val();
if(tagsearchval == ''){
    $('.acc_trigger.helptag').removeClass('active').next().hide();
}
// Tag search
        $('.popup_close a').click(function(){
            $(".popup_main").hide();
            $('body').css('overflow', 'scroll');
         });
         
         
         var cin = '<?php echo $cinno; ?>';
         $.ajax({
            url: 'pecfs_financial.php',
             type: "POST",
            data: { cin : cin,queryString:'INR' },
            success: function(data){
                $('#popup_content').html($.parseJSON(data))
                        
            },
            error:function(){
                jQuery('#preloading').fadeOut();
                alert("There was some problem sending mail...");
            }

        });
        
         
    });
    $(document).on('click','#pop_menu li',function(){
           window.open('<?php echo BASE_URL; ?>cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
    });
   /* $(document).on('click','#popup_main',function(e) {
    
        var subject = $("#popup_content"); 
        //alert(e.target.id);
        
        if(e.target.id !== null || e.target.id !== '')
        {
            
            $(".popup_main").hide();
        }
    });*/
    $(document).on('click','#allfinancial',function(){
             
            $(".popup_main").show();
            $('body').css('overflow', 'hidden');
    });
</script>
</form>
<form name=companyDisplay id="companyDisplayAngel" method="post" action="exportangeldealinfo.php">
    <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    <input type="hidden" name="txthidecompanyname" value="<?php echo $myrow["companyname"];?>" >
    <input type="hidden" name="txthideDealdate" value="<?php echo $DealDate;?>" >
</form>
<div class=""></div>

</div>

 <script type="text/javascript">
     
      $(document).ready(function() {
        $("#ymessage").on('keydown', function() {
            var words = this.value.match(/\S+/g).length;
            var character = this.value.length;
            
            if (words == 201) {
                
                $("#ymessage").attr('maxlength',character);
            }
            if(words > 200){
                 alert("Text reached above 200 words");
            }
            else {
                $('#word_left').text(200-words);
            }
        });
     });
     
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);

                    if($(this).attr("target")=='_blank') 
					{ 
						$("#pesearch").attr("target", "_blank");
					}  else {
                        $("#pesearch").attr("target", "_self");
                    }

                    $("#pesearch").submit();
                    return false;
                    
                });
                  function resetinput(fieldname)
                {

               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                //  alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }

                function resetmultipleinput(fieldname,fieldid)
                {
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
            /*$('.exlexport').click(function(){ 
             
            $("#companyDisplay").submit();
            return false;
            });*/


            $('.exlexport').click(function(){ 
                
                jQuery('#maskscreen').fadeIn(1000);
                jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });

            $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
            $('#cancelbtn').click(function(){ 

               jQuery('#popup-box').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
           function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
            function checkEmail() {

                var email = $("#toaddress").val();
                    if (email != '') {
                        var result = email.split(",");
                        for (var i = 0; i < result.length; i++) {
                            if (result[i] != '') {
                                if (!validateEmail(result[i])) {

                                    alert('Please check, `' + result[i] + '` email addresses not valid!');
                                    email.focus();
                                    return false;
                                }
                            }
                        }
                }
                else
                {
                    alert('Please enter email address');
                    email.focus();
                    return false;
                }
                return true;
            }
                
            function initExport(){
                    $.ajax({
                        url: 'ajxCheckDownload.php',
                        dataType: 'json',
                        success: function(data){
                            var downloaded = data['recDownloaded'];
                            var exportLimit = data.exportLimit;
                            var currentRec = 1;

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                            if (currentRec <= remLimit){

                                $("#companyDisplayAngel").submit();
                                jQuery('#preloading').fadeOut();
                            }else{
                                jQuery('#preloading').fadeOut();
                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                            }
                        },
                        error:function(){
                            jQuery('#preloading').fadeOut();
                            alert("There was some problem exporting...");
                        }

                    });
                }

                $('#mailbtn').click(function(){ 

                    if(checkEmail())
                    {


                    $.ajax({
                        url: 'ajaxsendmail.php',
                         type: "POST",
                        data: { to : $("#toaddress").val(),subject : $("#subject").val(),basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
                        success: function(data){
                                if(data=="1"){
                                     alert("Mail Sent Successfully");
                                    jQuery('#popup-box').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);

                            }else{
                                jQuery('#popup-box').fadeOut();   
                                jQuery('#maskscreen').fadeOut(1000);
                                alert("Try Again");
                            }
                        },
                        error:function(){
                            jQuery('#preloading').fadeOut();
                            alert("There was some problem sending mail...");
                        }

                    });
                    }

                });
                
            $('#mailfnbtn').click(function(e){ 
                e.preventDefault();

                    $.ajax({
                        url: 'ajaxsendmail.php',
                         type: "POST",
                        data: { to : $("#toaddress_fc").val(), subject : $("#subject_fc").val(), message : $("#message_fc").val() , userMail : $("#useremail_fc").val() , toventure : 1 },
                        success: function(data){
                                if(data=="1"){
                                     alert("Mail Sent Successfully");
                                    jQuery('#popup-box-financial').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);

                            }else{
                                jQuery('#popup-box-financial').fadeOut();   
                                jQuery('#maskscreen').fadeOut(1000);
                                alert("Try Again");
                            }
                        },
                        error:function(){
                            jQuery('#preloading').fadeOut();
                            alert("There was some problem sending mail...");
                        }

            });

            return false;
        });
            </script>
            
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
 <script>
     $(document).on('click','#agreebtn',function(){
         $('#popup-box-copyrights').fadeOut();   
        $('#maskscreen').fadeOut(1000);
        $('#preloading').fadeIn();   
        initExport();
        return false; 
     });
    
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
</script>  
<?php include('backbuttondisable.php'); ?>
</body>
</html>

<?php
	function returnMonthname($mth)
		{
			if($mth==1)
				return "Jan";
			elseif($mth==2)
				return "Feb";
			elseif($mth==3)
				return "Mar";
			elseif($mth==4)
				return "Apr";
			elseif($mth==5)
				return "May";
			elseif($mth==6)
				return "Jun";
			elseif($mth==7)
				return "Jul";
			elseif($mth==8)
				return "Aug";
			elseif($mth==9)
				return "Sep";
			elseif($mth==10)
				return "Oct";
			elseif($mth==11)
				return "Nov";
			elseif($mth==12)
				return "Dec";
	}
function writeSql_for_no_records($sqlqry,$mailid)
 {
 $write_filename="pe_query_no_records.txt";
 //echo "<Br>***".$sqlqry;
					$schema_insert="";
					//TRYING TO WRIRE IN EXCEL
								 //define separator (defines columns in excel & tabs in word)
									 $sep = "\t"; //tabbed character
									 $cr = "\n"; //new line

									 //start of printing column names as names of MySQL fields

										print("\n");
										 print("\n");
									 //end of printing column names
									 		$schema_insert .=$cr;
									 		$schema_insert .=$mailid.$sep;
											$schema_insert .=$sqlqry.$sep;
										        $schema_insert = str_replace($sep."$", "", $schema_insert);
									    $schema_insert .= ""."\n";

									 		if (file_exists($write_filename))
											{
												//echo "<br>break 1--" .$file;
												 $fp = fopen($write_filename,"a+"); // $fp is now the file pointer to file
													 if($fp)
													 {//echo "<Br>-- ".$schema_insert;
														fwrite($fp,$schema_insert);    //    Write information to the file
														  fclose($fp);  //    Close the file
														// echo "File saved successfully";
													 }
													 else
														{
														echo "Error saving file!"; }
											}

							         print "\n";

 }
 function highlightWords($text, $words)
 {

         /*** loop of the array of words ***/
         foreach ($words as $worde)
         {

                 /*** quote the text for regex ***/
                 $word = preg_quote($worde);
                 /*** highlight the words ***/
                 $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
         }
         /*** return the text ***/
         return $text;
 }

 	function return_insert_get_RegionIdName($regionidd)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select Region from region where RegionId=$regionidd";

                if ($rsgetInvestorId = mysql_query($getRegionIdSql))
		{
			$regioncnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($regioncnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$regionIdname = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionIdname;
				}
			}
		}
		$dbregionlink.close();
	}
function curPageURL() {
 $URL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $URL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pageURL=$URL."&scr=EMAIL";
 return $pageURL;
}
?>
<script type="text/javascript" >

    $("#panel").animate({width: 'toggle'}, 200); 
    $(".btn-slide").toggleClass("active"); 
    if ($('.left-td-bg').css("min-width") == '264px') {
    $('.left-td-bg').css("min-width", '36px');
    $('.acc_main').css("width", '35px');
    }
    else {
    $('.left-td-bg').css("min-width", '264px');
    $('.acc_main').css("width", '264px');
    }    
    
    $(document).on('click','#financial_data',function(){
            jQuery('#maskscreen').fadeIn(1000);
            jQuery('#popup-box-financial').fadeIn();   
            return false;
        });
        $('#cancelfnbtn').click(function(){ 
                     
            jQuery('#popup-box-financial').fadeOut();   
            jQuery('#maskscreen').fadeOut(1000);
            return false;
        });
</script>

<?php
mysql_close();
    mysql_close($cnx);
    ?>