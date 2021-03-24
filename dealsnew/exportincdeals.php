<?php include_once("../globalconfig.php"); ?>
<?php
 //session_save_path("/tmp");
	//session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{ 
        //Check Session Id 
        $sesID=session_id();
        $emailid=$_SESSION['UserEmail'];
        $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='PE'";
        $resUserLogSel = mysql_query($sqlUserLogSel);
        $cntUserLogSel = mysql_num_rows($resUserLogSel);
        if ($cntUserLogSel > 0){
            $resUserLogSel = mysql_fetch_array($resUserLogSel);
            $logSessionId = $resUserLogSel['sessionId'];
            if ($logSessionId != $sesID){
                header( 'Location: logoff.php?value=caccess' ) ;
            }
        }

function updateDownload($res){
    //Added By JFR-KUTUNG - Download Limit
    $recCount = mysql_num_rows($res);
    $dlogUserEmail = $_SESSION['UserEmail'];
    $today = date('Y-m-d');

    //Check Existing Entry
   $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
   $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
   $rowSelCount = mysql_num_rows($sqlSelResult);
   $rowSel = mysql_fetch_object($sqlSelResult);
   $downloads = $rowSel->recDownloaded;

   if ($rowSelCount > 0){
       $upDownloads = $recCount + $downloads;
       $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
       $resUdt = mysql_query($sqlUdt) or die(mysql_error());
   }else{
       $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','PE','".$recCount."')";
       mysql_query($sqlIns) or die(mysql_error());
   }
}        


//include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";
				//global $LoginAccess;
				//global $LoginMessage;
			$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
				$dbTypeSV="SV";
                                $dbTypeIF="IF";
                                $dbTypeCT="CT";
                                $companyIdDel=1718772497;
                                $companyIdSGR=390958295;
                                $companyIdVA=38248720;
                                $companyIdGlobal=730002984;
                                $addDelind="";

                                $submitemail=$_POST['txthideemail'];

                                $industry=$_POST['txthideindustryid'];
                                $hideindustrytext=$_POST['txthideindustry'];
                                //echo "<Br>-----------" .$hideindustrytext;
                                $hidestagetext=$_POST['txthidestage'];
                                $stagearr=$_POST['txthidestageid'];
                                $yearafter=$_POST['yearafter'];
                                $yearbefore=$_POST['yearbefore'];
                                $tagsearch      = $_POST['tagsearch'];
                                $tagandor       = $_POST['tagandor'];

                                //echo "<br>--". $hidestagetext;
                                $GetCompId="select dm.DCompId,dc.DCompId from dealcompanies as dc,dealmembers as dm
                                                                        where dm.EmailId='$submitemail' and dc.DCompId=dm.DCompId";

                                if($trialrs=mysql_query($GetCompId))
                                {
                                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                                        {
                                                $compId=$trialrow["DCompId"];
                                        }
                                }
                                 if($compId==$companyIdDel)
                                {
                                  $addDelind = " and (pec.industry=9 or pec.industry=24)";
                                }
                                if($compId==$companyIdSGR)
                                {
                                  $addDelind = " and (pec.industry=3 or pec.industry=24)";
                                }
                                if($compId==$companyIdVA)
                                {
                                  $addDelind = " and (pec.industry=1 or pec.industry=3)";
                                }
                                
                                 if($compId==$companyIdGlobal)
                                        {
                                          $addDelind = " and (pec.industry=24)";
                                        }
                                        
                                        
                                $statusid=$_POST['txthidestageid'];
                                $status=$_POST['txthidestage'];

                                $incfirmtypeid=$_POST['txthidefirmtypeid'];

                                $keyword=$_POST['txthideinvestor'];
                                $keyword =ereg_replace(":"," ",$keyword);

                                //echo "<Br>--" .$keyword;
                                $companysearch=$_POST['txthidecompany'];
                                $companysearch =ereg_replace("-"," ",$companysearch);

                                $searchallfield=$_POST['txthidesearchallfield'];

                                $followonFund=$_POST['txthidefollowonfund'];
                                $followonfundtext=$_POST['txthidefollowonfundvalue'];

                                $defunctflag=$_POST['txthidedefunct'];
                                $defunctflagtext=$_POST['txthidedefunctvalue'];
                                $regionid=$_POST['txthideregion'];
                                $city=$_POST['txthidecity'];
                                
                                $regionvalue=$_POST['txthideregiontext'];
                                $txthidepe      = $_POST['txthidepe'];


                                if($_POST['txtdatefilter']!=''){                                                       
                                $datefilter=  stripslashes($_POST['txtdatefilter']);
                                }
                                else{
                                    $datefilter='';  
                                }


                               // echo "<bR>--- ".$regionid;
                                if($defunctflag==0)
                                { 	$addDefunctqry=" and Defunct=0 " ; }
                                else
                                {       $addDefunctqry=""; }

                                //echo "<bR>---" .$companysearch;

                                $searchtitle="List of Incubator Deals";

                                $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";


				/*echo "<br>Industry Id-----------------**".$hideindustryid;
				echo "<br>Inv type id-----------------**".$invtypevalueid;
				echo "<br>Start Range Value-----------------**".$hiderangeStartValue;
				echo "<br>End Range value-----------------**".$hiderangeEndValue;
				*/
				//echo "<br>start Date-----------------**".$hidedateStartValue;
				//echo "<br>End Date-----------------**".$dateValue;
				//echo "<br>Deal Type---**". $dealtype;
				$addVCFlagqry = " and pec.industry !=15 ";
   				$searchTitle = "List of Incubator Deals";
                $hideWhere = ''; 
                                if (($keyword == "") && ($companysearch=="") && ($industry =="--")  && 	($statusid == "--") && ($followonFund == "--") &&($regionid=="") && ($incfirmtypeid==0) && ($city=='')&& ($yearafter=="") && ($yearbefore=="")  )
				{
                                    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                        $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                         $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                                       $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                         $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }else{
                                         $hideWhere = " ";
                                    }
                                        $companysql = "SELECT pe.IncDealId,pe.IncubateeId,pec.companyname, pec.industry, i.industry,
                                        pec.sector_business,Individual,inc.Incubator,
                                        pe.YearFounded,pec.website, pec.AdCity, pec.region,pec.RegionId,MoreInfor,pe.StatusId,s.Status,FollowonFund, pe.date_month_year,pec.yearfounded,pec.CINNo
                                        FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,incubators as inc, incstatus as s
                                        WHERE $datefilter pec.industry = i.industryid   and inc.IncubatorId=pe.IncubatorId and s.StatusId=pe.StatusId
                                        AND pec.PEcompanyID = pe.IncubateeId  and pe.Deleted=0" .$addVCFlagqry.$addDefunctqry. " ".$addDelind." " . $hideWhere . " order by companyname";
                                        //echo "<br>3 Query for All records" .$companysql;
                                }
                                elseif($searchallfield!="")
                                {
                                    
                                    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                        $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                         $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                                       $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                         $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }else{
                                         $hideWhere = " ";
                                    }
                                                    
                                             $findTag = strpos($searchallfield,'tag:');
                                            $findTags = "$findTag";
                                            // if($findTags == ''){
                                            //     $tagsval = "pec.AdCity LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' or sector_business LIKE '$searchallfield%'
                                            //                         or MoreInfor LIKE '%$searchallfield%'  or Incubator LIKE '%$searchallfield%'";                                    
                                            // }else{
                                            //     $tags = '';
                                            //     $ex_tags = explode(',',$searchallfield);
                                            //     if(count($ex_tags) > 0){
                                            //         for($l=0;$l<count($ex_tags);$l++){
                                            //             if($ex_tags[$l] !=''){
                                            //                 $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                            //                 $tags .= "pec.tags like '%:$value%' or ";
                                            //             }
                                            //         }
                                            //     }
                                            //     $tagsval = trim($tags,' or ');
                                            // }
                                            
                                               // $companysql.="( $tagsval ) AND";

                                            $searchExplode = explode( ' ', $searchallfield );    
                                            foreach( $searchExplode as $searchFieldExp ) {
                                     
                                                          $cityLike .= "pec.AdCity REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                                          $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                                          $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                                          $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                                          $incubatorLike .= "Incubator REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                                          $industryLike .= "i.industry REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                                          $websiteLike .= "pec.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                                          $tagsLike .= "(pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,') and ";
                                                      }
                                                      $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                                                      $cityLike = '('.trim($cityLike,'AND ').')';
                                                      $companyLike = '('.trim($companyLike,'AND ').')';
                                                      $sectorLike = '('.trim($sectorLike,'AND ').')';
                                                      $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
                                                      $incubatorLike = '('.trim($incubatorLike,'AND ').')';
                                                      $industryLike = '('.trim($industryLike,'AND ').')';
                                                      $websiteLike = '('.trim($websiteLike,'AND ').')';
                                              $tagsLike = '('.trim($tagsLike,'AND ').')';
                                                      $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $incubatorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;   
                                            
                                        $companysql="SELECT pe.IncDealId,pe.IncubateeId, pec.companyname, pec.industry, i.industry,
                                        pec.sector_business,Individual,inc.Incubator,
                                         pe.YearFounded,pec.website, pec.AdCity, pec.region,pec.RegionId,MoreInfor,pe.StatusId,s.Status,FollowonFund, pe.date_month_year,pec.yearfounded,pec.CINNo
                                        FROM incubatordeals AS pe, industry AS i,  pecompanies AS pec,incubators as inc,incstatus as s
                                        WHERE $datefilter pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId
                                        and inc.IncubatorId=pe.IncubatorId  and s.StatusId=pe.StatusId
							AND pe.Deleted =0 " .$addVCFlagqry.$addDefunctqry. " ".$addDelind." " . $hideWhere . " AND  ( $tagsval ) GROUP BY pe.IncDealId  order by companyname"; 

                                        //echo "<bR>---" .$companysql;
                                }
				elseif ($companysearch != "")
                                {
                                    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                        $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                         $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                                       $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                         $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }else{
                                         $hideWhere = " ";
                                    }
                                        $companysql="SELECT pe.IncDealId,pe.IncubateeId, pec.companyname, pec.industry, i.industry,
                                        pec.sector_business,Individual,inc.Incubator,
                                         pe.YearFounded,pec.website, pec.AdCity, pec.region,pec.RegionId,MoreInfor,pe.StatusId,s.Status,FollowonFund, pe.date_month_year,pec.yearfounded,pec.CINNo
                                        FROM incubatordeals AS pe, industry AS i,  pecompanies AS pec,incubators as inc,incstatus as s
                                        WHERE $datefilter pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId
                                        and inc.IncubatorId=pe.IncubatorId  and s.StatusId=pe.StatusId
                                        AND pe.Deleted =0 " .$addVCFlagqry.$addDefunctqry. " ".$addDelind." " . $hideWhere . " AND  pec.PECompanyId IN ($companysearch)
                                        order by companyname";
                                        //	echo "<br>Query for company search";
                                        // echo "<br> Company search--" .$companysql;
                                }
				elseif($keyword!="")
                                {
                                    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                        $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                         $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                                       $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                         $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }else{
                                         $hideWhere = " ";
                                    }
                                        $companysql="select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business,
                                        Individual,	inc.Incubator,
                                        pe.YearFounded,pec.website, pec.AdCity, pec.region,pec.RegionId,MoreInfor,pe.StatusId,s.Status,FollowonFund, pe.date_month_year,pec.yearfounded,pec.CINNo
                                        from incubatordeals as pe,pecompanies as pec,industry as i ,incubators as inc,incstatus as s
                                        where $datefilter pec.industry = i.industryid and  inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 and s.StatusId=pe.StatusId
                                        and pec.PECompanyId=pe.IncubateeId " .$addVCFlagqry.$addDefunctqry." ".$addDelind." " . $hideWhere . " AND inc.IncubatorId IN($keyword) order by companyname";

                                        //echo "<br> Investor search- ".$companysql;
                                }

                                elseif (($industry > 0) || ($statusid >0) ||  ($followonFund >=0) || ($regionid> 0) || ($incfirmtypeid >0) || ($city!='') || ($yearafter!="") || ($yearbefore!="") ||  ( $tagsearch !='') )
                                {
                                   /*echo $yearafter;
                                          exit();*/
                                    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                        $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                         $hideWhere = " and pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                                       $hideWhere = " pe.IncDealId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) and ";

                                    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                         $hideWhere = " and pe.IncDealId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                                    }else{
                                         $hideWhere = " ";
                                    }
                                        $companysql = "select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business,
                                        Individual,inc.Incubator,pe.YearFounded,pec.website, pec.AdCity, pec.region,pec.RegionId,MoreInfor,pe.StatusId,s.Status,FollowonFund, pe.date_month_year,pec.yearfounded,pec.CINNo
                                        from incubatordeals as pe, industry as i,pecompanies as pec,incubators as inc,incstatus as s
                                        where $datefilter " . $hideWhere;
                                //	echo "<br> individual where clauses have to be merged ";
                                        if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if ($statusid> 0)
                                        {
                                                $wherestatus = " pe.StatusId =" .$statusid ;
                                                $qryDealTypeTitle="Stage  - ";
                                        }
                                        if($incfirmtypeid>0)
                                        {
                                            $wherefirmtype=" inc.IncFirmTypeId=".$incfirmtypeid;
                                        }
                                        if (($followonFund =="0") || ($followonFund=="1"))
                                        {
                                            $wherefollowonFund = " pe.FollowonFund = ".$followonFund;
                                            $qryDealTypeTitle="Follow on Funding Status  - ";
                                        }
                                        if ($regionid> 0)
                                        {
                                            $whereregion = " pec.RegionId =" .$regionid ;
                                            $qryregionTitle="Region  - ";
                                        }
                                        if($city != "")
                                        {
                                            $whereCity=" pec.city LIKE '".$city."%'";
                                        }
                                        if ($yearafter != '' && $yearbefore == '') {

                                            $whereyearaftersql = " pec.yearfounded >= $yearafter";
                                        }

                                        if ($yearbefore != '' && $yearafter == '') {
                                            $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
                                        }

                                        if ($yearbefore != '' && $yearafter != '') {
                                            $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
                                        }
                                         if($tagsearch !="")
                                        {
                                            $ex_tags = explode(',', $tagsearch);
                                            if (count($ex_tags) > 0) {
                                                for ($l = 0; $l < count($ex_tags); $l++) {
                                                    if ($ex_tags[$l] != '') {
                                                        $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                        $value = str_replace(" ", "", $value);
                                                        //$tags .= "pec.tags like '%:$value%' or ";
                                                        //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                        if ($tagandor == 0) {
                                                            $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                        } else {
                                                            $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                        }
                                                    }
                                                }
                                            }

                                            if ($tagandor == 0) {
                                                $tagsval = trim($tags, ' and ');
                                            } else  {
                                                $tagsval = trim($tags, ' or ');
                                            }

                                        }

                                        if ($whereyearaftersql != "") {
                                            $companysql = $companysql . $whereyearaftersql . " and ";
                                        }
                                        if ($whereyearbeforesql != "") {
                                            $companysql = $companysql . $whereyearbeforesql . " and ";
                                        }
                                        if ($whereyearfoundedesql != "") {
                                            $companysql = $companysql . $whereyearfoundedesql . " and ";
                                        } 
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                        }
                                        if (($wherestatus != ""))
                                        {
                                                $companysql=$companysql . $wherestatus . " and " ;
                                        }
                                        if($wherefirmtype!="")
                                        {
                                          $companysql=$companysql . $wherefirmtype . " and " ;
                                        }
                                        if($wherefollowonFund!="")
                                        {  $companysql=$companysql .$wherefollowonFund. " and "; }
                                        if (($whereregion != ""))
                                        {
                                        $companysql=$companysql . $whereregion . " and " ;
                                        }
                                        if($tagsval!="")
                                        {
                                            $companysql=$companysql ." (".$tagsval . ") and " ;
                                        } 
                                        if($whereCity !="")
                                        {
                                            $companysql=$companysql.$whereCity." and ";
                                        }

                                        $companysql = $companysql . "  i.industryid=pec.industry and
                                        pec.PEcompanyID = pe.IncubateeId and inc.IncubatorId=pe.IncubatorId and
                                        s.StatusId=pe.StatusId and
                                        pe.Deleted=0 " .$addVCFlagqry.$addDefunctqry. " ".$addDelind." order by companyname ";
                                        
//                                        echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
//                                        exit();
                                }
                                else
                                {
                                        echo "<br> Invalid input selection ";
                                        $fetchRecords=false;
                                }


//mail sending

//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
													dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
													dm.EmailId='$submitemail' AND dc.Deleted =0";

			if ($totalrs = mysql_query($checkUserSql))
			{

				$cnt= mysql_num_rows($totalrs);
				//echo "<Br>mail count------------------" .$hidesearchon;
				if ($cnt==1)
				{

					While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
					{
						if( date('Y-m-d')<=$myrow["ExpiryDate"])
						{

								$OpenTableTag="<table border=1 cellpadding=1 cellspacing=0 ><td>";
								$CloseTableTag="</table>";


								$headers  = "MIME-Version: 1.0\n";
								$headers .= "Content-type: text/html;
								charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";

								/* additional headers
								$headers .= "Cc: sow_ram@yahoo.com\r\n"; */

								$RegDate=date("M-d-Y");
								$to="arun.natarajan@gmail.com,arun@ventureintelligence.com";
								//$to .="sowmyakvn@gmail.com";

									$subject="Incbuator Deals - $searchdisplay";
									$message="<html><center><b><u>  $searchdisplay - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
									<tr><td width=1%>Status</td><td width=99%>$status</td></tr>
									<tr><td width=1%>Status</td><td width=99%>$defunctflagtext</td></tr>
									<tr><td width=1%>Follow on funding</td><td width=99%>$followonFundText</td></tr>
									<tr><td width=1%>Incubator</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company/Sector</td><td width=99%>$companysearch</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";

								mail($to,$subject,$message,$headers);
								//header( 'Location: http://www.ventureintelligence.com/deals/cthankyou.php' ) ;


						}
						elseif($myrow["ExpiryDate"] >= date('y-m-d'))
						{
							$displayMessage= $TrialExpired;
							$submitemail="";
							$submitpassword="";

						}
					}
				}
				elseif ($cnt==0)
				{
					$displayMessage= "Invalid Login / Password";
					$submitemail="";
							$submitpassword="";

				}
			}
	//	}


 $sql=$companysql;
//echo "<br>---" .$sql;exit();
 //execute query
 $result = @mysql_query($sql)
     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
 
 updateDownload($result);

 //if this parameter is included ($w=1), file returned will be in word format ('.doc')
 //if parameter is not included, file returned will be in excel format ('.xls')
 	if (isset($w) && ($w==1))
 	{
 		$file_type = "msword";
 		$file_ending = "doc";
 	}
 	else
 	{
 		$file_type = "vnd.ms-excel";
 		$file_ending = "xls";
	}
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=inc_deals.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");

 /*    Start of Formatting for Word or Excel    */



 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	if ($Use_Title == 1)
 	{
 		echo("$title\n");
 	}

 	/*echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");*/

 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
    echo "Company"."\t";
    echo "CIN"."\t";
	echo "Year Founded"."\t";
	echo "Industry"."\t";
	echo "Sector"."\t";
	echo "City"."\t";
	echo "Region"."\t";
	echo "Website"."\t";
        echo "Date"."\t";
	echo "Incubator"."\t";
	echo "Status"."\t";
	echo "Follow on  Funding"."\t";
	echo "More Details"."\t";


 print("\n");

 /*print("\n");*/
 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */

 $searchString="Undisclosed";
 $searchString=strtolower($searchString);
  $searchStringDisplay="Undisclosed";

 $searchString1="Unknown";
 $searchString1=strtolower($searchString1);

 $searchString2="Others";
 $searchString2=strtolower($searchString2);


     while($row = mysql_fetch_row($result))
     {
        //print_r($row);
         //set_time_limit(60); // HaRa
         $schema_insert = "";
         $IncDealId=$row[0];
		$companyName = $row[2];
		if($row[6]==1)
		{
			$openBracket="(";
			$closeBracket=")";
		}
		else
		{
			$openBracket="";
			$closeBracket="";
		}

		$regionId=$row[12]; //regionid
		if($regionId>0)
		{
			$getRegionSql="select Region from region where RegionId=$regionId";
			if ($rsregion = mysql_query($getRegionSql))
			{
				While($regionrow=mysql_fetch_array($rsregion, MYSQL_BOTH))
				{
					$regiontext=$regionrow["Region"];
				}
			}
		}
		else
			{$regiontext=$row[11]; // Region
		}



		if($row[18] >0)
			$yearfounded=$row[18];
		else
		$yearfounded="";


		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);
		//echo $compResult;
		if($compResult==0)
		{
          	$schema_insert .= $openBracket .$row[2].$closeBracket .$sep;
           $webdisplay=$row[9];
         }
		 else
		{
			$schema_insert .= $searchStringDisplay.$sep;
			 $webdisplay="";
		}
        $schema_insert .= $row[19].$sep; //Year Founded
          $schema_insert .= $yearfounded.$sep; //Year Founded
          $schema_insert .= $row[4].$sep; //industry
	      $schema_insert .= $row[5].$sep; //sector
          $schema_insert .= $row[10].$sep; //city
          $schema_insert .= $regiontext.$sep;
     	$schema_insert .= $webdisplay.$sep;
        
       
        if($row[17]!='0000-00-00'){
        $date = date('M-Y', strtotime($row[17]));
        }else{
        $date =' ';
        }
        
        $schema_insert .= $date.$sep;      //date
        
        $schema_insert .= $row[7].$sep;      //incubator
      $schema_insert .= $row[15].$sep;  //status
      	if($row[16]==1)
		{    $followonFunding="Obtained"; }
		else
		{    $followonFunding="None"; }
		$schema_insert .= $followonFunding.$sep;
      $schema_insert .= $row[13].$sep;  //Moreinfor

	    // $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert .= ""."\n";
 		//following fix suggested by Josue (thanks, Josue!)
 		//this corrects output in excel when table fields contain \n or \r
 		//these two characters are now replaced with a space
 		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
         $schema_insert .= "\t";
         print(trim($schema_insert));
         print "\n";
     }

    print "\n";
    print "\n";
    print "\n";
    print "\n";
    print "\n";
    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
    print("\n");
    print("\n");

//		}
//else
//	header( 'Location: http://www.ventureintelligence.com/pelogin.php' ) ;
    }
mysql_close();
    mysql_close($cnx);
    ?>


