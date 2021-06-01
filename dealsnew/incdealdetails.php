<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
    $tagandor=$_POST['tagandor'];
    $tagradio=$_POST['tagradio'];
    $yearafter=trim($_POST['yearafter']);
    $yearbefore=trim($_POST['yearbefore']);
         $videalPageName="Inc";  
	include('checklogin.php');
        $mailurl= curPageURL();
        $notable=false;
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        if(sizeof($strvalue)>1)
        {   
        $flagvalue=$strvalue[1];
        $VCFlagValue=$strvalue[1];
        }
        else
        {
        $flagvalue=6;
        $VCFlagValue=6;
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
        
                 $keyword=($_POST['keywordsearch']);             
                 $investorauto=$_POST['investorauto'];
                 
                 $companysearch=$_POST['companysearch'];
                 $companyauto=$_POST['companyauto'];
                 
                 $searchallfield=trim($_POST['searchallfield']);
                $industry=trim($_POST['industry']);

                if($resetfield=="tagsearch") {

                   /* $_POST['tagsearch']="";
                    $_POST['tagsearch_auto'] = "";
                    $tagsearch = "";
                    $tagkeyword = "";*/
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
                $incfirmtype=trim($_POST['txtfirmtype']);
                 $status=trim($_POST['statusid']);
               
                 if($resetfield=="chkDefunct")
                { 
                  $_POST['chkDefunct']="";
                  $defunctflag=1;
                  $addDefunctqry="";
                }
                else 
                {
                  $defunctflag=0;
                  $addDefunctqry=" and Defunct=0 ";
                 
                }
                if($resetfield=="yearfounded")
                { 
                    $_POST['yearafter']="";
                    $_POST['yearbefore']="";
                    $yearafter="";
                    $yearbefore="";
                   
                }
                else 
                {
                    $yearafter=trim($_POST['yearafter']);
                    $yearbefore=trim($_POST['yearbefore']);
                    if($yearafter != NULL && $yearafter !='' && $yearbefore != NULL && $yearbefore !=''){
                        $searchallfield='';
                    }

                }
                if($resetfield=="followonFund")
                { 
                 $_POST['followonFund']="";
                 $followon="";
                }
                else 
                {
                 $followon=trim($_POST['followonFund']);
                }
                 $regionId=$regionIdd=trim($_POST['txtregion']);
                 $city=trim($_POST['citysearch']);
                   if($industry >0)
                {
                    $industrysql= "select industry from industry where IndustryId=$industry";
                    if ($industryrs = mysql_query($industrysql))
                    {
                            While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                            {
                                    $industryvalue=$myrow["industry"];
                            }
                    }
                }
   		if($status >0)
		{
		$statussql= "select StatusId,Status from incstatus where StatusId=$status";
    		if ($stagers = mysql_query($statussql))
			{
				While($mysrow=mysql_fetch_array($stagers, MYSQL_BOTH))
				{
					$statusvalue=$mysrow["Status"];
				}
			}
		}
		if($incfirmtype >0)
		{
			$incfirmsql= "select IncFirmTypeId,IncTypeName from incfirmtypes where IncFirmTypeId=$incfirmtype";
    		if ($incrs = mysql_query($incfirmsql))
                {
                        While($myincrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                        {
                                $inctype=$myincrow["IncTypeName"];
                        }
                }
		}
		if($defunctflag==1)
                {   $defunctText= "Excluded Defunct Cos"; }
                else
                {     $defunctText= "Included Defunct Cos"; }
		if($regionIdd >0)
			{
			$regionSql= "select Region from region where RegionId=$regionIdd";
					if ($regionrs = mysql_query($regionSql))
					{
						While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$regionvalue=$myregionrow["Region"];
						}
					}
		}
        
                
                
             if($_POST['month1']!='' && $_POST['year1']!='' && $_POST['month2']!='' && $_POST['year2']!=''){
                    
                    $sdatevalueDisplay1 = returnMonthname($_POST['month1']) ." ".$_POST['year1'];
                    $edatevalueDisplay2 = returnMonthname($_POST['month2']) ."  ".$_POST['year2'];                    
                }
                else{
                    //$sdatevalueDisplay1='';                      
                    $sdatevalueDisplay1 = returnMonthname(date('n')) ." ".date('Y', strtotime(date('Y')." -1  Year"));
                    $edatevalueDisplay2 = returnMonthname(date('n')) ."  ".date('Y'); 
                }
                 if($followon=="--")
                    $followonFund="--";
                    $followonFundText="";
                if($followon==1){
                    $followonFund='1';
                    $followonFundText="Follow on Funding";
                } elseif($followon==2){
                    $followonFund='0';
                    $followonFundText="No Funding";
                }
?>

<?php
	
        if($strvalue[3]=='Directory'){
            
            $dealvalue=$strvalue[2];
            $topNav = 'Directory'; 
            include_once('dirnew_header.php');
        }else{
            $topNav = 'Deals'; 
            include_once('incdeal_header.php');
        }
	
?>
<div id="container" >
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-top:6px;">
<tr>
    <td class="left-td-bg">
 <div class="acc_main" style="margin-top:-10px;">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
 <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once('increfine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
<!--     <input type="hidden" name="pe_checkbox" id="pe_checkbox" value="<?php echo $pe_checkbox; ?>" />-->
     
<!--     <input type="hidden" name="pe_hide_companies" id="pe_hide_companies" value="<?php echo $hideCompanyFlag; ?>" />-->
<?php if($_POST['all_checkbox_search']==1){ ?>
    <input type="hidden" name="pe_company" id="pe_company" value="" />
    
<?php }else{ ?>
    
<!--    <input type="hidden" name="pe_company" id="pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />-->
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
		//	$SelCompRef=$value;
		$strvalue = explode("/", $value);
                $SelCompRef=$strvalue[0];
		$searchstringhighlight=$strvalue[1];
		
		
		//GET PREV NEXT ID
		$prevNextArr = array();
		$prevNextArr = $_SESSION['resultId'];
                $coscount = $_SESSION['coscount'];
		
		$currentKey = array_search($SelCompRef,$prevNextArr);
		$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
		$nextKey = $currentKey+1;
		
		
	//	echo "<Br>---" .$SelCompRef;
		$exportToExcel=0;
                $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
                //echo "<br>---" .$TrialSql;
                if($trialrs=mysql_query($TrialSql))
                {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                                $studentOption=$trialrow["Student"];
                        }
                }


               // print_r($_POST);
  	$sql="SELECT pe.IncubateeId, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business,
            pec.website, pec.AdCity,
            pec.region,MoreInfor,pe.IncubatorId,inc.Incubator,pec.RegionId,
            pe.StatusId,pec.yearfounded,Individual,s.Status ,FollowonFund,DATE_FORMAT( date_month_year, '%M-%Y' ) as dt,pec.CINNo
            FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,
            incubators as inc,incstatus as s
            WHERE pec.industry = i.industryid
            AND pec.PEcompanyID = pe.IncubateeId and pe.Deleted=0 and pec.industry !=15
            and pe.IncDealId=$SelCompRef and s.StatusId=pe.StatusId
            and inc.IncubatorId=pe.IncubatorId ";
	//echo "<br>********".$sql;
  	if ($companyrs = mysql_query($sql))
        {
           ?>
		
	<?php
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
                    
                    if($myrow["Individual"]==1)
                    {
                            $openBracket="(";
                            $closeBracket=")";
                    }
                    else
                    {
                            $openBracket="";
                            $closeBracket="";
                    }
                    $regionId=$myrow["RegionId"];
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
                    {
                        $regiontext=$myrow["Region"];
                    }

                    if($myrow["CINNo"] != ''){

                        $cinno = $myrow["CINNo"];
                    }else{
                        $cinno = 0;
                    }

                    if($myrow["yearfounded"] >0)
                            $yearfded=$myrow["yearfounded"];
                    else
                            $yearfded="";

                    if($myrow["FollowonFund"]==1)
                    {    $followonFunding="Yes";}
                    else
                    {    $followonFunding="No";}

                    $industryId=$myrow["industryId"];
                     $moreinfor=$myrow["MoreInfor"];
                     $string = $moreinfor;
	          //echo "<Br>---" .$searchstringhighlight;
                    if($searchstringhighlight!="")
                    {
                        /*** an array of words to highlight ***/
                        $words = array($searchstringhighlight);
                        //$words="warrants convertible";
                        /*** highlight the words ***/
                        $moreinfor =  highlightWords($string, $words);
                    }
            }
  }
?>			
<td class="profile-view-left" style="width:100%;">
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

        <div class="result-title">

                <?php if(!$_POST)
                    {   
                    ?>
            <h2>
            <?php
            /*if($studentOption==1 || $exportToExcel==1)
            {*/
         ?>
              <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos) </span> 
            <?php   /*} 
            else 
            {
          ?>
                 <span class="result-no"> XXX Results Found</span> 
            <?php
            } */
            ?>
            <span class="result-for">  for Incubation Investments</span>
            </h2>
           <div class="title-links">
                                
                <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                <?php 

                if(($exportToExcel==1))
                     {
                     ?>

                                         <input class="export_new exlexport" type="button"  value="Export" name="showdeal">
                     <?php
                     }
                 ?>
             </div>     

             <ul class="result-select">
                                <li>
                    Jan 18-Jan  19 <a onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                                <li class="result-select-close"><a href="incindex.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                             </ul>     

            <?php 
            }
            else 
            {
               ?>
            <h2>
             <?php
            /*if($studentOption==1 || $exportToExcel==1)
            {*/
         ?>
              <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos) </span> 
            <?php   /*} 
            else 
            {
          ?>
                 <span class="result-no"> XXX Results Found</span> 
            <?php
            }*/ 
            ?>
            <span class="result-for">  for Incubation Investments</span>
            </h2>
             <div class="title-links">
                                
                <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                <?php 

                if(($exportToExcel==1))
                     {
                     ?>

                                         <input class="export_new exlexport" type="button"  value="Export" name="showdeal">
                     <?php
                     }
                 ?>
             </div>  
            <?php if(($industry >0 && $industry!=null && $industry!="--")
                    ||($status>0 && $status!="--")
                    ||($defunctflag==0)
                    ||($incfirmtype >0 && $incfirmtype !="")
                    ||($followonFund!="--" && $followonFund!="")
                    ||($regionIdd>0 && $regionIdd!="" && $regionIdd!=NULL)
                    ||($keyword!=" " && $keyword!="")
                    ||($companysearch!=" " && $companysearch!="")
                    ||($searchallfield!="")
                    ||($sdatevalueDisplay1!="") ){ $cls="mt-list-tab"; ?>
            <ul class="result-select">
                <?php
                // echo "<bR>--**" .$followonVCFund."adsasd".$followonVCFundText;
                 //echo $queryDisplayTitle;
               if($industry >0 && $industry!=null && $industry!="--"){ ?>
                <li><?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php }
                if($status>0 && $status!="--"){ ?>
                <li><?php echo $statusvalue; ?><a  onclick="resetinput('statusid');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($defunctflag==1){ ?>
                <li><?php echo "Exclude Defunct Cos"; ?><a  onclick="resetinput('chkDefunct');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($incfirmtype >0 && $incfirmtype !=""){ ?>
                <li><?php echo $inctype; ?><a  onclick="resetinput('txtfirmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($followonFund!="--" && $followonFund!=""){ ?>
                <li><?php echo $followonFundText;?><a  onclick="resetinput('followonFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php }  if($regionIdd>0 && $regionIdd!="" && $regionIdd!=NULL ){ ?>
                <li><?php echo $regionvalue;?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } 
                if($city!=""){ $drilldownflag=0; ?>
                    <li> 
                        <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
              <?php }  if($keyword!=" " && $keyword!=""){ ?>
                <li><?php echo $investorauto?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($companysearch!=" " && $companysearch!=""){ ?>
                <li><?php echo $companyauto?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($searchallfield!=""){ ?>
                <li>
                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } if($sdatevalueDisplay1!=""){ ?>
                <li>
                    <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?> <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } 
                 if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                      <li> 
                                         <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } 
                if($tagsearch!=""){ ?>
               <!--  <li>
                    <?php echo "tag:".$tagsearch;?> <a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li> -->
                 <?php $tagarray = explode(",",$tagsearch); 
             foreach ($tagarray as $key=>$value){  ?>
                  <li>
                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?> 
                <?php }
                $_POST['resetfield']="";
                foreach($_POST as $value => $link) 
                { 
                    if($link == "" || $link == "--" || $link == " ") 
                    { 
                        unset($_POST[$value]); 
                    } 
                }
                 $cl_count = count($_POST);
                if($cl_count >= 4)
                {
                ?>
                <li class="result-select-close"><a href="incindex.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                <?php
                }
                ?>
             </ul>
                    <?php }else { $cls="mt-list-tab-directory";} } ?>
  </div>
        
    
    <div class="list-tab <?php echo ($cls!="")?$cls:"mt-list-tab-directory"; ?>" style="margin-top:93px !important;"><ul>
            <li><a class="postlink"  href="incindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="incdealdetails.php?value=<?php echo $SelCompRef;?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>"><i></i> Detail View</a></li> 
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
                    <p>Checkout this deal - <?php echo $myrow["companyname"]; ?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this deal - <?php echo $myrow["companyname"]; ?> - in Venture Intelligence"  />
                    <input type="hidden" name="basesubject" id="basesubject" value="Deal" />
            </div>
            <div class="entry">
                    <h5>Link</h5>
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
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
                    <input type="text" name="toaddress_fc" id="toaddress_fc"  value="database@ventureintelligence.com"/>
            </div>
            <div class="entry">
                    <h5>Subject*</h5>
                    <p>Request for financials linking</p>
                    <input type="hidden" name="subject_fc" id="subject_fc" value="Request for financials linking"  />
            </div>
            <div class="entry">
                    <h5>Link</h5>
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message_fc" id="message_fc" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail_fc" id="useremail_fc" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailfnbtn" />
                <input type="button" value="Cancel" id="cancelfnbtn" />
            </div>

        </form>
    </div>  
    <div class="view-detailed"> 
         <!--div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]; ?></h2-->
             <div class="detailed-title-links"><h2> <A class="postlink" href='companydetails.php?value=<?php echo $myrow["IncubateeId"];?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="incdealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $VCFlagValue;?>/">< Previous</a><?php } ?> 
        <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="incdealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $VCFlagValue;?>/"> Next > </a>  <?php } ?>
                    </div>
        <div class="postContainer postContent masonry-container">
  <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                     <?php
                                
                                 if (is_null($myrow["dt"]))
		                 { $yearfded=""; }
		                 else
				  { $yearfded=$myrow["dt"]; }
                                  
                                
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";
				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
				<td width="120"><h4>Company</h4> <p> <?php echo $openDebtBracket;?><?php echo $openBracket;?><A class="postlink" href='companydetails.php?value=<?php echo $myrow["IncubateeId"].'/'.$flagvalue.'/';?>' >
				<?php echo rtrim($myrow["companyname"]);?></a><?php echo $closeBracket;?><?php echo $closeDebtBracket;?>
				</p></td>
		<?php
				}
				else
				{
					$webdisplay="";
		?>
				<td  ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>
                               <?php if($myrow["industry"]!="") { ?><td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td>  <?php } ?>
                        </tr>
                        <tr><?php if($myrow["sector_business"]!="") { ?><td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td><?php } if(trim($myrow["AdCity"])!="") { ?><td><h4>City</h4> <p><?php echo  $myrow["AdCity"];?></p></td><?php } ?>
                        <tr><?php if($regiontext!="") { ?><td><h4>Region</h4> <p><?php echo ($regiontext)?$regiontext:"-";?></p></td><?php } if($webdisplay!="") { ?><td colspan="2"><h4>Website</h4> <p style="word-break: break-all;"><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></p>	</td><?php } ?></tr>
                        <tr><?php if(rtrim($myrow["Incubator"])!="") { ?><td ><h4>Incubator</h4> <p><A href='incubatordetails.php?value=<?php echo $myrow["IncubatorId"].'/'.$VCFlagValue;?>' >
												<?php echo rtrim($myrow["Incubator"]);?></a></p>	</td> <?php } ?>
                          <?php
                                 if ($yearfded!="") { 
                                 ?>
                       <td colspan="2"><h4>Deal Date</h4> <p><?php echo $yearfded;?></p>	</td></tr>
                                 <?php } ?>
                        
                        <tr><?php if($myrow["Status"]!="") { ?><td ><h4>Status</h4> <p><?php echo $myrow["Status"] ;?></p></td><?php } if($followonFunding!="") { ?><td ><h4>Follow on Funding</h4> <p><?php echo $followonFunding;?></p></td> <?php } ?></tr>
                       
                     
                    </table>
                    </div> 
        
        
        
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a href="mailto:database@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                              </p></td></tr></table>
                                                                 
        </div>
   
    </div>
    </div>
<?php include('dealcompanydetails.php'); ?>   
</td></tr></tbody>

</table>
 
</div>
    </form>
    <form name=incubatordeal id="incubatordeal" method="post" action="exportincdealinfo.php">
      <input type="hidden" name="txthideIncDealId" value="<?php echo $SelCompRef;?>" >
      <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" > 
      <input type="hidden" name="txthidecompanyname" value="<?php echo $myrow["companyname"];?>" >
      <input type="hidden" name="txthideDealdate" value="<?php echo $yearfded;?>" > 
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
                   $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                  function resetinput(fieldname)
                {
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  hrefval= 'incindex.php';
                  $("#pesearch").attr("action", hrefval);
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
                $("#incubatordeal").submit();
                return false;
            });*/

            $('.exlexport').click(function(){ 
                jQuery('#maskscreen').fadeIn();
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
                                    
                                    $("#incubatordeal").submit();
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
                            data: { to : $("#toaddress").val(),subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
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
                                alert("There was some problem sending mail..");
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
<style>
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
           window.open('<?php echo BASE_URL;?>cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
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
<?php include('backbuttondisable.php'); ?>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
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
        $portArray = array( '80', '443' );
        if ($_SERVER["HTTPS"] == "on") {$URL .= "s";}
        $URL .= "://";
        if (!in_array( $_SERVER["SERVER_PORT"], $portArray)) {
         $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
         $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        $pageURL=$URL."&scr=EMAIL";
        return $pageURL;
       }
mysql_close();
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
