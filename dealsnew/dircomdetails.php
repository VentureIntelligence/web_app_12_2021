<?php include_once("../globalconfig.php"); ?>
<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('checklogin.php');
        
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
        
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        //echo "<br>*".$value;
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $pe_re=$strvalue[1];
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
        }
        else
        {
            $vcflagValue=0;
            $VCFlagValue=0;
        }
        
            $dealvalue=$strvalue[2];
           if($VCFlagValue==0)
            {
                    $getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                    FROM peinvestments AS pe, pecompanies AS pec
                    WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
                    AND pec.industry !=15 and pe.AggHide=0 and
                    pe.PEId NOT
                            IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId ='SV'
                            AND hide_pevc_flag =1
                            )";
                    $pagetitle="PE Investments -> Search";
                    $stagesql_search = "select StageId,Stage from stage ";
                    $industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
                // echo "<br>***".$industrysql;
            }
            elseif($VCFlagValue==1)
            {
               $getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                    FROM peinvestments AS pe, stage AS s ,pecompanies as pec
                    WHERE s.VCview =1 and  pe.amount<=20 and pec.industry !=15 and pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId
                    and pe.Deleted=0
                    and
                    pe.PEId NOT
                            IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  'SV'
                            AND hide_pevc_flag =1
                            )  ";
                    $pagetitle="VC Investments -> Search";
                    $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
                     $industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";

                    //echo "<Br>---" .$getTotalQuery;
            }
            elseif($VCFlagValue==2)
            {
                    $getTotalQuery= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                    FROM REinvestments AS pe, pecompanies AS pec
                    WHERE pec.Industry =15 and pe.Deleted=0
                    AND pe.PEcompanyID = pec.PECompanyId ";
                    $pagetitle="PE Investments - Real Estate -> Search";
                    $stagesql_search="";
                     $industrysql="select industryid,industry from industry where industryid =15 ";

            }

                //$SelCompRef = $value;
		//$pe_re= 1;

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

               /* $sql="SELECT pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
                                stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
                                c.country,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,linkedin_companyname
                                FROM industry AS i,pecompanies AS pec,country as c
                                WHERE pec.industry = i.industryid and c.countryid=pec.countryid
                                 AND  pec.PECompanyId=$SelCompRef";*/
                
                $sql="SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, pec.Email, pec.AdditionalInfor, linkedin_companyname,CINNo
                FROM pecompanies pec
                LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                WHERE pec.PECompanyId =$SelCompRef";
                                 //pe.PEId, peinvestments AS pe and pe.PECompanyId=pec.PECompanyId";

                $company_link_Sql ="select * from pecompanies_links where PECompanyId=$SelCompRef";
	//	echo "<br>".$sql;

		if(($pe_re==0) || ($pe_re==1) || ($pe_re==2) || ($pe_re==3) || ($pe_re==4) || ($pe_re==5) ||($pe_re==6) || ($pe_re==7) || ($pe_re==8) || ($pe_re==9) || ($pe_re==10))
		{
			$investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
			peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";

			$dealpage="dealinfo.php";
			$invpage="investordetails.php";
		//	echo "<br>0 1 _________________".$investorSql;
                }else{
                    $dealpage="incdealdetails.php";
                    $invpage="incubatordetails.php";
		}

		/*elseif(($pe_re==3) || ($pe_re==4))// PE-ipo 3 , VCIPOs-4
		{
			$investorSql="select pe.IPOId as DealId,peinv.IPOId,peinv.InvestorId,inv.Investor,DATE_FORMAT( IPODate, '%b-%Y' ) as dt from
			ipos as pe, ipo_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.IpoId=pe.IpoId and inv.InvestorId=peinv.InvestorId  and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15";

			$dealpage="diripodetails.php";
			$invpage="investordetails.php";
			echo "<Br>3 4 ---" .$investorSql;
		}

		elseif(($pe_re==5) ||($pe_re==6)) // manda
		{
			$investorSql="select pe.MandAId as DealId,peinv.MandAId,peinv.InvestorId,inv.Investor,DATE_FORMAT( DealDate, '%b-%Y' ) as dt from
			manda as pe, manda_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.MandAId=pe.MandAId and inv.InvestorId=peinv.InvestorId  and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15";

			$dealpage="mandadealdetails.php";
			$invpage="investordetails.php";
		//	echo "<br>5 6 ______________ ";$investorSql;
		}
                elseif(($pe_re==8) || ($pe_re==9) || ($pe_re==10))  //social venture investments ,  clenatech, infrastructure , query is same as peinvestor
		{

			$investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
			peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";
			$dealpage="dirdealdetails.php";
			$invpage="investordetails.php";
		//        echo "<br>8  9 10 _________________".$investorSql;
		}*/
		//echo "<br>--" .$investorSql;
                //elseif($pe_re==2) // incubatees
		//{
                $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator FROM
                `incubatordeals` as pe, incubators as inc WHERE IncubateeId =$SelCompRef
                and pe.IncubatorId= inc.IncubatorId ";

                
		//   echo "<bR>2 ---" .$investorSql;
		//}
		$onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
		exe.ExecutiveName,exe.Designation,exe.Company from
		pecompanies as pec,executives as exe,pecompanies_board as bd
		where pec.PECompanyId=$SelCompRef and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";
		//echo "<Br>Board-" .$onBoardSql;

		$onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
				exe.ExecutiveName,exe.Designation,exe.Company from
				pecompanies as pec,executives as exe,pecompanies_management as mgmt
		where pec.PECompanyId=$SelCompRef and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
		//echo "<Br>Board-" .$onMgmtSql;


		//$maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
		//	DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId
		//	FROM manda AS pe, industry AS i, pecompanies AS pec WHERE  i.industryid=pec.industry
		//	AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$SelCompRef order by dt desc";

	
                $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,
			DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus
			FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv
                         WHERE  i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$SelCompRef
			and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId
                        order by DealDate desc ";
                       // echo "<br>-- ".$maexitsql;

		$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
				IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
				FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                 WHERE  i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$SelCompRef
                        and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId
                         order by IPODate desc";
                          // echo "<br>-- ".$ipoexitsql;



		$angelinvsql="SELECT pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor
				FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
   	                        angel_investors as peinv,peinvestors as inv
                                 WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                                 pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=$SelCompRef
                                 and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";
                                // echo "<Br>---" .$angelinvsql;
		
                $company_link_Sql ="select * from pecompanies_links where PECompanyId=$SelCompRef";
                
                
	
//GET PREV NEXT ID
$prevNextArr = array();
$prevNextArr = $_SESSION['resultCompanyId'];
//print_r($prevNextArr);

$currentKey = array_search($SelCompRef,$prevNextArr);
$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
$nextKey = $currentKey+1;

	$topNav = 'Directory';
	include_once('dirnew_header.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%"  style="margin-top:-10px;" >
<tr><?php
if($dealvalue==101)
{
 ?>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;"> 
<?php include_once('newdirrefine.php');?>
        

     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
    </div>
</td>
    <?php
}
?>
<td>
    
<div class="result-cnt">
    <div class="result-title ">
        <div class="title-links">
                                
            <input class="senddeal" type="button" id="senddeal" value="Send this company profile to your colleague" name="senddeal">
            <?php 

            if(($exportToExcel==1))
                 {
                 ?>
                        <span id="exportbtn"></span>

                 <?php
                 }
             ?>
        </div>
        
                   <?php
               // echo $sql;
//                if ($companyrs = mysql_query($sql))
//		{
                   $companyrs = mysql_query($sql);
                   
                     if($companyrs)
                    {
        
                        // echo "<br><br>dsfadfdgdfgdfgdfgdfgdfgfddf";
                         
                        if(isset($_REQUEST['angelco_only'])){
                               $angelco_compID=$SelCompRef;
                             
                           } 
                           
                         else if(mysql_num_rows($companyrs)>0){ 
                             
                            $myrow=mysql_fetch_array($companyrs,MYSQL_BOTH);

                            $angelco_compID=$myrow["angelco_compID"];
                            $compname=$myrow["companyname"];
                            $industry=$myrow["industry"];
                            $sector=$myrow["sector_business"];
                            $website=$myrow["website"];
                            $Address1=$myrow["Address1"];
                            $Address2=$myrow["Address2"];
                            $AdCity=$myrow["AdCity"];
                            $Zip=$myrow["Zip"];
                            $finlink=$myrow["FinLink"];
                            $uploadname=$myrow["uploadfilename"];
                            $currentdir=getcwd();
                            $target = $currentdir . "../uploadmamafiles/" . $uploadname;
                            $file = "../uploadmamafiles/" . $uploadname;

                            $OtherLoc=$myrow["OtherLocation"];
                            $Country=$myrow["country"];
                            $Tel=$myrow["Telephone"];
                            $Fax=$myrow["Fax"];
                            $Email=$myrow["Email"];
                            $AddInfo=$myrow["AdditionalInfor"];
                            $stockcode=$myrow["stockcode"];
                            $yearfounded=$myrow["yearfounded"];
                            $website=$myrow["website"];
                            $linkedin_compname=$myrow["linkedin_companyname"];
                           // echo "<bR>^^^^^^^^*********^^^^^^^^^^^^^^^^" .$linkedin_compname;
                            if($myrow["CINNo"] != ''){
                                $cinno = $myrow["CINNo"];
                            }else{
                                $cinno = 0;
                            }
                            $companyName=trim($myrow["companyname"]);
                            $companyName=strtolower($companyName);
                            $compResult=substr_count($companyName,$searchString);
                            $compResult1=substr_count($companyName,$searchString1);
                            $compResult2=substr_count($companyName,$searchString2);
                            $webdisplay="";
                            $google_sitesearch="https://www.google.co.in/search?q=".$companyName."+site%3Alinkedin.com";
                            $google_sitesearch_mgmt="";
                            $companyurl=  urlencode($companyName);
                            $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";
                        //$linkedin_url="http://www.linkedin.com/company/".$companyName; }

			//if($linkedin_compname!="")
			//{ 	$linkedin_url="http://www.linkedin.com/company/".$linkedin_compname; }


			//echo "<br>----" .$linkedin_url;
                        
                        }
                        if(($compResult==0) && ($compResult1==0))
	    		{
	    			$webdisplay=$website;
    
                            if(!$_POST){
                                   // echo $VCFlagValue;
                                if($VCFlagValue==0)
                                { ?>
                                           
                                    <h2>
                                    <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                    <span class="result-for">for PE Directory</span>
                                    <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                    </h2>             
                            <?php }
                                else
                                {?>
                                    <h2>
                                    <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                    <span class="result-for">for VC Directory</span>
                                    <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                    </h2>
                            <?php } ?>
                                
                    <?php }
                            else 
                            {
                                   if($VCFlagValue==0)
                                   { ?>
                                        <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                           <span class="result-for">for PE Directory</span>
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                        </h2>  
                                <?php }
                                    else
                                    {?>
                                        <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                            <span class="result-for">for VC Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                        </h2>
                                 <?php } ?>
                        <?php } ?> 
    </div><br><br><br>
    <div class="list-tab"><ul>
        <li><a class="postlink"  href="pedirview.php?value=<?php echo $strvalue[1]; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
        <li class="active"><a id="icon-detailed-view" class="postlink" href="dirdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail  View</a></li> 
        </ul></div> 
    <div class="lb" id="popup-box">
        <div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject</h5>
                    <p>Checkout this profile- <?php echo $compname; ?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this profile- <?php echo $compname; ?> - in Venture Intelligence"  />
            </div>
            <div class="entry">
                    <h5>Message</h5>
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
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
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message_fc" id="message_fc" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail_fc" id="useremail_fc" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailfnbtn" />
                <input type="button" value="Cancel" id="cancelfnbtn" />
            </div>

        </form>
    </div> 
    <div class="view-detailed">
        
         <?php
    
    if(mysql_num_rows($companyrs)>0){  ?>
        
     <div class="detailed-title-links"> 
         
         <h2>  <?php echo $compname; ?></h2>
         
         
         
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="dircomdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $pe_re;?>/<?php echo $dealvalue; ?>">< Previous</a><?php } ?> 
        <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="dircomdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $pe_re;?>/<?php echo $dealvalue; ?>"> Next > </a>  <?php } ?>
                    </div>

    
    <?php } ?>    
        
            <!-- new -->
  <?php
  
  if($angelco_compID !=''){
      
      
    $profileurl ="https://api.angel.co/1/startups/$angelco_compID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
      
    //role=founder&
    $roleurl ="https://api.angel.co/1/startups/$angelco_compID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
   
    $profilejson = file_get_contents($profileurl);
    $profile = json_decode($profilejson);
    
    
    $rolejson = file_get_contents($roleurl);
    $roles = json_decode($rolejson);
    $roles = $roles->startup_roles;
    
    echo "<pre>";
  // print_r($profile);
    echo "</pre>";
    
  }
  ?>
     
            
    
            
    <div class="com-wrapper">
	<section class="com-cnt-sec">
    	<header>
    		<h3>Company Profile</h3>
         </header>
            
         <?php  if($angelco_compID !='' && $profile->id > 0){ ?>
         <div class="com-col">
              <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
         <div class="com-sec-lg bor-top-cnt">
         	<div class="co-home-ground border-btm pad-top-no">
            	<img src="<?php echo $profile->logo_url ?>" alt="<?php echo $profile->name ?>">
                <address class="fl">
                	<strong> <?php echo $profile->name ?> </strong>
                    <span> <?php echo $profile->high_concept ?> </span>
                    <p>
<!--                        Mumbai · Specialty Foods · Food Processing · South East Asia-->
                        <?php
                        $places ='';
                        foreach ( $profile->locations as $locations){
                            $places .=$locations->display_name." - ";
                        }
                        
                        foreach ( $profile->markets as $markets){
                            $places .=$markets->display_name." - ";
                        }
                        
                        echo rtrim($places,'- ');
                        
                        ?>
                    
                    </p>
                </address>
            </div>
             
           <?php if($profile->product_desc) { ?>
            <div class="com-pro-cnt border-btm">
            	<h3 class="com-sub-title">Product</h3>
                <p> <?php echo $profile->product_desc ?> </p>
            </div>
           <?php } ?>  
             
             
            <?php 
            $rolescount=0;
            foreach ($roles as $ro) {  if($ro->role == 'founder') { $rolescount++; } }
            
            if($rolescount > 0) { ?> 
            <div class="com-founder-cnt border-btm no-bor">
            	<h3 class="com-sub-title">FOUNDER</h3>
                
                <?php foreach ($roles as $ro) {  
                    if($ro->role == 'founder') { 
//                            echo "<pre>";
//                            print_r($ro);
//                            echo "</pre>";
                ?>
                <div class="fonder-detail-com">
                	<img src="<?php echo $ro->tagged->image ?>" alt="<?php echo $ro->tagged->name ?>">
                    <div class="fon-det-sec fl">
                    	<h4 class="founder-name-com"><?php echo $ro->tagged->name ?></h4>
                        <span><?php echo $ro->title ?></span>
                        <p><?php echo $ro->tagged->bio ?></p>
                    </div>
                </div>
                <?php } } ?> 
                
            </div>
             <?php } ?> 
             
            </div>
           
         </div>
        <?php } ?>
            
             
            <?php if(mysql_num_rows($companyrs)>0){ ?>
            
         <div class="com-col">
             <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
         	<div class="com-address-cnt bor-top-cnt">

                    <div>
                        <span style="float:right;text-decoration: underline;font-size: 18px;color:#624C34;font-weight: bolder;cursor:pointer;" id="allfinancial">Financials</span>
                    </div>

                    <?php 
                    if ($myrow["Investor"] != "") 
                    { ?>                                        

                          <div class="com-add-li">
                                          <h6>Investor</h6>
                                      <span><?php echo $myrow["Investor"]; ?></span>
                          </div>
                    <?php
                    }
                    if($industry!="")
                  {
                  ?>

                          <div class="com-add-li">
                              <h6>INDUSTRY</h6>
                          <span> <?php echo $industry;?></span>
                          </div>

                  <?php }
                  if($sector!="")
                  {
                  ?>
                          <div class="com-add-li">
                             <h6>SECTOR</h6>
                          <span><?php echo $sector;?></span>
                          </div>

                  <?php }
                  if($stockcode!="")
                  {
                  ?>
                          <div class="com-add-li">
                             <h6>STOCK CODE</h6>
                          <span><?php echo $stockcode;?></span>
                          </div>
                  <?php }
                   if ($Address1 != "" || $Address2 != "")  
                   { ?>
                                        <div class="com-add-li">
                                          <h6>ADDRESS</h6>
                                      <span> <?php echo $Address1; ?><?php if ($Address2 != "") echo "<br/>" . $Address2; ?></span>
                                  </div>


                     <?php
                  }
                  if ($AdCity != "") 
                  { ?>
                                      <div class="com-add-li">
                                          <h6>CITY</h6>
                                      <span><?php echo $AdCity; ?></span>
                                  </div>


                      <?php
                      }
                      if(($Country!="")&&($Country!="--" ))
                      {
                    ?>
                                  <div class="com-add-li">
                                          <h6>COUNTRY</h6>
                                      <span> <?php echo $Country; ?></span>
                                  </div>

                     <?php
                     }
                    if (($Zip != "") || ($Zip > 0)) 
                        { ?>
                                  <div class="com-add-li">
                                          <h6>ZIP</h6>
                                      <span><?php echo $Zip; ?></span>
                                  </div>

                     <?php
                  }
                   if (($Tel != "") || ($Tel > 0)) {
                     ?>
                                  <div class="com-add-li">
                                          <h6> TELEPHONE</h6>
                                      <span><?php echo $Tel ?></span>
                                  </div>
                  <?php
                   } ?>
                   
                    
                    <?php
                   
                   if(($Fax!="")|| ($Fax>0)) 
                  {
                  ?>
                                  <div class="com-add-li">
                                          <h6>FAX</h6>
                                      <span><?php echo $Fax; ?></span>
                                  </div>
                  <?php }
                  if (trim($Email) != "") {
                      ?>
                                  <div class="com-add-li">
                                          <h6>EMAIL</h6>
                                      <span><?php echo $Email; ?></span>
                                  </div>
                     <?php
                      }

                      if ($yearfounded != "" && $yearfounded >0) {
                          ?>
                                  <div class="com-add-li">
                                          <h6>YEAR FOUNDED </h6>
                                      <span><?php echo $yearfounded; ?></span>
                                  </div>

                      <?php
                      }
                  if(trim($OtherLoc)!="") 
                  {
                  ?>
                                  <div class="com-add-li">
                                          <h6>OTHER LOC</h6>
                                      <span><?php echo $OtherLoc; ?></span>
                                  </div>

                  <?php }
                  if (trim($website) != "") 
                    { ?>
                                  <div class="com-add-li">
                                          <h6>WEBSITE</h6>
                                      <span><a href="<?php echo $website; ?>" target="_blank"> Click Here  </a> </span>
                                  </div>

                     <?php
                      }

                      if ($company_newssearch != "") 
                    { 
                    ?>
                                  <div class="com-add-li">
                                          <h6>NEWS</h6>
                                      <span> <a href="<?php echo $company_newssearch; ?>"  target="_blank"> Click Here </a> </span>
                                  </div>

                     <?php
                      }?> 


                    <?php 
                    
                     if($linkedIn!=''){          
                        $url = $linkedIn;
                        $keys = parse_url($url); // parse the url
                        $path = explode("/", $keys['path']); // splitting the path
                        $companyid = (int)end($path); // get the value of the last element  
                     }
                    
//                    if ($companyid != "") 
//                    {  
                        ?>
                                  <div class="com-add-li"  id="viewlinkedin_loginbtn" style="display: none">
                                          <h6>VIEW LINKEDIN PROFILE</h6>
                                      <span><script type="in/Login"></script></span>
                                  </div>

                  <!--  <li id="viewlinkedin_loginbtn" style="display: none"><h4>  </h4><p><script type="in/Login"></script></p></li>-->
                    <?php 
//                     }
  
                    
                    if (trim($AddInfo) != "") 
                    { ?>
                                      <div class="com-add-li" >
                                          <h6>ADDITIONAL INFORMATION </h6>
                                      <span><?php echo $AddInfo; ?></span>
                                  </div>


                     <?php
                      } ?>
                    <div style="clear:both"></div>
                    <div>
        <?php if($rsMgmt= mysql_query($onMgmtSql))
        {
             $mgmt_cnt = mysql_num_rows($rsMgmt);
        }
        if($mgmt_cnt>0)
        {   
        ?>

         <div  class="work-masonry-thumb  com-inv-sec   col-2" style="float:left" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Top Management</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th></tr></thead>
        <tbody>
             <?php
                if($rsMgmt= mysql_query($onMgmtSql))
                //{
                While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                        {
                                $desig="";
                                $desig=$mymgmtrow["Designation"];
                                if(trim($desig)=="")
                                        $desig="";
                                else
                                        $desig=", ".$mymgmtrow["Designation"];
                ?>
                <tr><td style="alt"><?php echo $mymgmtrow["ExecutiveName"]; ?></td>
                    <td><?php echo $mymgmtrow["Designation"]; ?></td>
                <!--  <td>
                <?php 
                        $google_sitesearch_mgmt="https://www.google.co.in/search?q=".$companyName." ".$mymgmtrow["ExecutiveName"]."+site%3Alinkedin.com";
                        ?>
                        <a target="_blank" href="<?php echo $google_sitesearch_mgmt; ?>" ><img src="images/icon-in.png" width="25" height="24" alt="" /></a></td>-->
                </tr>
                <?php
                        }

                       
                ?>
     </tbody>
        </table> 
            </div>
        <?php
        } ?>
             <?php 
            
    if($rsBoard= mysql_query($onBoardSql))
    {
         $board_cnt = mysql_num_rows($rsBoard);
    }
    if($board_cnt>0)
    {
    ?>
      <div  class="work-masonry-thumb  com-inv-sec   col-2" style="float:left" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Investor Board Member</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th> <th>LinkedIn</th></tr></thead>
        <tbody>
            <?php

                While($myboardrow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
                {
                        $desig="";
                        $desig=$myboardrow["Designation"];
                        if(strlen(trim($desig))==0)
                                $desig="";
                        else
                                $desig=", ".$myboardrow["Designation"];
                        $comp=$myboardrow["Company"];
                        if(strlen(trim($comp))==0)
                                $comp="";
                        else
                                $comp=", ".$myboardrow["Company"];

        ?>
        <tr><td style="alt"><?php echo $myboardrow["ExecutiveName"];?></td>
        <td>
           
            <?php 
            echo $myboardrow["Designation"];
             if($myboardrow["Designation"]!="" && $myboardrow["Company"]!=""){ echo ","; } ?>
            <?php echo $myboardrow["Company"]; ?></td>
        <td>
        <?php
                $google_sitesearch_board="https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$desig.$comp. "+site%3Alinkedin.com";
                                                                ?>
                <a target="_blank" href="<?php echo $google_sitesearch_board; ?>" >
                <?php echo $myboardrow["ExecutiveName"];?></a>
        </td></tr>
        <?php
                }
                //}
                ?>  
     </tbody>
        </table> 
         </div>
        <?php
        } ?>
                    </div>           
            </div>
        
         </div>
                 
                 
                  <!-- LINKED IN START -->
                  
                     <?php 
                    //echo "dddddddddddddddd".$linkedIn;
                     if($linkedIn!=''){ 

                     $url = $linkedIn;
                     $keys = parse_url($url); // parse the url
                     $path = explode("/", $keys['path']); // splitting the path
                     $companyid = (int)end($path); // get the value of the last element  

                    ?>
                     <div class="com-col linkedindiv" style="display: none">
                      <div class="linked-com">
                    <div class="linkedin-bg">

                    <script type="text/javascript" > 

                        $(document).ready(function () {
                            $('#lframe,#lframe1').on('load', function () {
                    //            $('#loader').hide();

                            });
                        });

                        function autoResize(id){
                            var newheight;
                            var newwidth;

                            if(document.getElementById){
                                newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
                                newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
                            }

                            document.getElementById(id).height= (newheight) + "px";
                            document.getElementById(id).width= (newwidth) + "px";
                        }
                    </script>

                    <script type="text/javascript" src="//platform.linkedin.com/in.js"> 
                        api_key:65623uxbgn8l
                        authorize:true
                        onLoad: onLinkedInLoad
                        </script>
                        <script type="text/javascript" > 
                        var idvalue=<?php echo $companyid; ?>;

                        function onLinkedInLoad() {
                           $("#viewlinkedin_loginbtn").hide(); 
                           var profileDiv = document.getElementById("sample");

                                    if(idvalue)
                                    {                          
                                        $("#lframe").css({"height": "220px"});
                                        $("#lframe1").css({"height": "300px"});

                                        var inHTML='loadlinkedin.php?data_id='+idvalue;
                                        var inHTML2='linkedprofiles.php?data_id='+idvalue;
                                        $('#lframe').attr('src',inHTML);
                                        $('#lframe1').attr('src',inHTML2);
                                         $('.linkedindiv').show();
                                    }
                                    else
                                    {
                                         $('#lframe').hide();
                                         $('#lframe1').hide();
                                         $('#loader').hide();
                                          $('.linkedindiv').hide();
                                    }

                          }

                    </script>

                    <div  id="sample" style="padding:10px 10px 0 0;">

                        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
                    </div>

                    <input type="hidden" name="dataId" id="dataId" >

                 </div>
                   <div class="fl" style="padding:10px 10px 0 0;">
                   <iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> 

                    </div>
                      </div>


                     <?php }
                     else{

                     $linkedinSearchDomain=  str_replace("http://www.", "", $webdisplay); 
                       $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
                        if(strrpos($linkedinSearchDomain, "/")!="")
                        {
                           $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
                        }
                    if($linkedinSearchDomain!=""){ ?>
                <!--     <img src="images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;">-->
                  <div class="com-col linkedindiv"  style="display: none">
                      <div class="linked-com">
                  <div class="linkedin-bg">

                    <script type="text/javascript" > 

                    $(document).ready(function () {
                        $('#lframe,#lframe1').on('load', function () {
                //            $('#loader').hide();

                        });
                    });

                function autoResize(id){
                    var newheight;
                    var newwidth;

                    if(document.getElementById){
                        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
                        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
                    }

                    document.getElementById(id).height= (newheight) + "px";
                    document.getElementById(id).width= (newwidth) + "px";
                }
                 </script>



                        <script type="text/javascript" src="//platform.linkedin.com/in.js"> 
                        api_key:65623uxbgn8l
                        authorize:true
                        onLoad: LinkedAuth
                        </script>
                        <script type="text/javascript" > 
                        var idvalue;
                         //document.getElementById("sa").textContent='asdasdasd'; 

                        function LinkedAuth() {
                            if(IN.User.isAuthorized()==1){
                               $("#viewlinkedin_loginbtn").hide();      
                            }
                            else {
                                 $("#viewlinkedin_loginbtn").show();   
                            }

                            IN.Event.on(IN, "auth", onLinkedInLoad);

                          } 

                        function onLinkedInLoad() {
                           $("#viewlinkedin_loginbtn").hide(); 
                           var profileDiv = document.getElementById("sample");

                               //var url = "/companies?email-domain=<?php echo $linkedinSearchDomain ?>";
                               var url ="/company-search:(companies:(id,website-url,name,logo_url))?keywords=<?php echo $linkedinSearchDomain ?>";


                                IN.API.Raw(url).result(function(response) {   

                                    //console.log(response['companies']['values'].length);                  
                                    //console.log(response['companies']['values'][0]['id']);
                                    //console.log(response['companies']['values'][0]['websiteUrl']);
                                    var searchlength = response['companies']['values'].length;

                                    var domain='';
                                    var website = '<?php echo $linkedinSearchDomain?>';

                                    for(var i=0; i<searchlength; i++){

                                        if(response['companies']['values'][i]['websiteUrl']){
                                            domain = response['companies']['values'][i]['websiteUrl'].replace('www.','');
                                            domain = domain.replace('http://','');
                                            domain = domain.replace('/','');
                                            if(domain == website){
                                                idvalue = response['companies']['values'][i]['id'];
                                                break;
                                            }
                                        }
                                    }


                                    if(idvalue)
                                    {                          
                                        $("#lframe").css({"height": "220px"});
                                        $("#lframe1").css({"height": "300px"});

                                        var inHTML='loadlinkedin.php?data_id='+idvalue;
                                        var inHTML2='linkedprofiles.php?data_id='+idvalue;
                                        $('#lframe').attr('src',inHTML);
                                        $('#lframe1').attr('src',inHTML2);
                                        $('.linkedindiv').show();
                                    }
                                    else
                                    {
                                         $('#lframe').hide();
                                         $('#lframe1').hide();
                                         $('#loader').hide();
                                          $('.linkedindiv').hide();
                                    }

                                    //  profileDiv.innerHtml=inHTML;
                                    //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                                }).error( function(error){
                                   $('#lframe').hide();
                                   $('#lframe1').hide();
                                   $('#loader').hide(); 
                                    $('.linkedindiv').hide();
                               
                               });
                               
                          }


                        </script>

                    <div  id="sample" style="padding:10px 10px 0 0;">

                        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
                    </div>

                    <input type="hidden" name="dataId" id="dataId" >

                 </div>
                   <div class="fl" style="padding:10px 10px 0 0;">
                   <iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div>  
                       
                       
                    </div>
                      </div>
                       <?php } 

                    }
                   ?>
                  
                  <!-- LINKED IN END -->
                  
                 
          
            <?php } ?>
            
    </section>   
        
        
        
        
         <section class="com-cnt-sec" id="investments-all">
        
        
        <?php
         $rolescount2=0;
         foreach ($roles as $ro) {  if($ro->role == 'past_investor' || $ro->role == 'current_investor') { $rolescount2++; } }
        
        
        if(mysql_num_rows($companyrs)>0 || $rolescount2>0  ){ ?>
            
                
    	<header>
        	<h3>INVESTMENTS</h3>
        </header>
         <div class="com-col" id="ventureInvestment">
        <?php } ?>
        
         <div style="margin:0 15px">
            <div class="company-cnt-sec">
                 <span class="">INVESTMENTS from Our Database</span>
                 <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
            <div class="vicomp-cnt">
            </div></div>
            </div>
          
          
          
          
    <div class="postContainer postContent masonry-container bor-top-cnt">
        <?php
        $investor_cnt=0;
        if($investorSql!="")
        {
        if($getcompanyrs= mysql_query($investorSql))
        {
            $investor_cnt = mysql_num_rows($getcompanyrs);
        }
        }
        if($investor_cnt>0)
        {

        ?>  
    <div  class="work-masonry-thumb  com-inv-sec   col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>PE/VC Investors</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
            <thead><tr><th>Investor Name</th> <th>Deal Period</th></tr></thead>
                <tbody>
                <?php
                    While($myInvestorrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                    {
                            $Investorname=trim($myInvestorrow["Investor"]);
                            $Investorname=strtolower($Investorname);
                            $invResult=substr_count($Investorname,$searchString);
                            $invResult1=substr_count($Investorname,$searchString1);
                            $invResult2=substr_count($Investorname,$searchString2);
                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                            {
                               $addTrancheWord="";
                               $addDebtWord="";
                                if(($pe_re==0) || ($pe_re==1) || ($pe_re==8) )
                                {
                                    if($myInvestorrow["AggHide"]==1)
                                        $addTrancheWord="; Tranche";
                                    else
                                        $addTrancheWord="";
                                }
                                else
                                    $addTrancheWord="";
                                    if($myInvestorrow["SPV"]==1)
                                        $addDebtWord="; Debt";
                                    else
                                        $addDebtWord="";

            ?>
        <?php $deal=0; ?>
        <tr><td style="alt"><a href='<?php echo $invpage;?>?value=<?php echo $myInvestorrow["InvestorId"].'/'.$VCFlagValue.'/' . $dealvalue. '/' . $topNav;?>' ><?php echo $myInvestorrow["Investor"]; ?></a></td>
            <td><a href="dealdetails.php?value=<?php echo $myInvestorrow["DealId"].'/'.$VCFlagValue.'/' . $dealvalue. '/' . $topNav;?>"><?php echo $myInvestorrow["dt"];?></a><?php echo $addTrancheWord;?><?php echo $addDebtWord;?></td>                                                          
 <?php 
      }
       } 
?>  
    </tbody>
    </table> 
    </div>
 <?php
    }
    if($incrs= mysql_query($incubatorSql))
        {
             $incubator_cnt = mysql_num_rows($incrs);
        }
        if($incubator_cnt>0)
        {
            While($incrow=mysql_fetch_array($incrs, MYSQL_BOTH))
            {
                $incubator=$incrow["Incubator"];
                $incubatorId=$incrow["IncubatorId"];
            }
    ?>   
    
   <div  class="work-masonry-thumb  com-inv-sec   col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
    <h2>Incubators</h2>
    <table cellpadding="0" cellspacing="0" class="tablelistview">
        <tr><td> <p><a href='incubatordetails.php?value=<?php echo $incubatorId.'/'.$VCFlagValue;?>' > <?php echo $incubator;?> </a></p> </td></tr>
    </table>
    </div>                         
    <?php
    }?>
            <?php
         if($rsipoexit= mysql_query($ipoexitsql))
        {
             $ipoexit_cnt = mysql_num_rows($rsipoexit);
        }
        if($rsmandaexit= mysql_query($maexitsql))
        {
             $mandaexit_cnt = mysql_num_rows($rsmandaexit);
        }
        if(($ipoexit_cnt>0)||($mandaexit_cnt>0 ))
        {

        ?>                                                 
            <div  class="work-masonry-thumb  com-inv-sec   col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
            <h2>PE/VC Exits</h2>
            <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
            <thead><tr><th>Deal Type</th><th>Investor(s)</th> <th>Deal Period</th> <th>Status</th></tr></thead>
            <tbody>
                 <?php
                        //if($rsipoexit= mysql_query($ipoexitsql))
                        //{
                        While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
                        {
                          $exitstatusvalueforIPO=$ipoexitrow["ExitStatus"];
                          if($exitstatusvalueforIPO==0)
                           {$exitstatusdisplayforIPO="Partial Exit";}
                          elseif($exitstatusvalueforIPO==1)
                          {  $exitstatusdisplayforIPO="Complete Exit";}
                        ?>
                       <tr><td style="alt">IPO</td><td><?php echo $ipoexitrow["Investor"];?></td>

                        <td> <a href='ipodealdetails.php?value=<?php echo $ipoexitrow["IPOId"].'/'.$VCFlagValue.'/'. $dealvalue. '/' . $topNav;?>'><?php echo $ipoexitrow["dt"];?></a></td>

                        <td><?php echo $exitstatusdisplayforIPO;?></td>
                        </tr>


                        <?php
                                }

                                if($rsmandaexit= mysql_query($maexitsql))
                        //{
                        While($mymandaexitrow=mysql_fetch_array($rsmandaexit, MYSQL_BOTH))
                        {
                          $exitstatusvalue=$mymandaexitrow["ExitStatus"];
                          if($exitstatusvalue==0)
                           {$exitstatusdisplay="Partial Exit";}
                          elseif($exitstatusvalue==1)
                          {  $exitstatusdisplay="Complete Exit";}
                        ?>

                        <tr><tr><td style="alt"><!--M&A--> <?php echo $mymandaexitrow["DealType"] ?></td><td><?php echo $mymandaexitrow["Investor"];?></td>

                        <td> <a href='mandadealdetails.php?value=<?php echo $mymandaexitrow["MandAId"].'/'.$VCFlagValue;?>'><?php echo $mymandaexitrow["dt"];?></a></td>

                        <td><?php echo $exitstatusdisplay;?></td>
                        </tr>
                        <?php
                        } 
                       ?>  
            </tbody>
            </table> 
            </div>
         <?php
            }
            
       /*
        if($myrow["uploadfilename"]!="" || mysql_num_rows($company_link_Sql)>0 )
        {   
        ?>

        <div  class="work-masonry-thumb  com-inv-sec   col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>FINANCIALS INFO</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <tbody>
<!--             <?php

              //  if($finlink!="")
              //  {
                ?>
                    <tr><td ><h4>Link for Financials
                            </h4><p style="word-break: break-all;"><a target="_blank" href=<?php //echo $finlink; ?> ><?php //echo $finlink; ?></a></p></td></tr>

                <?php
              //  } 
                ?>-->
                
                
<?php                 
if($myrow["uploadfilename"]!="")
{
        ?>
                <tr><td  ><h4>Financials </h4>
                <?php
                if($exportToExcel==1)
                 {
                 ?>
                            <td><a href=<?php echo $file;?> target="_blank" > Click here </a>
                            <Br />
                            <a href="<?php echo GLOBAL_BASE_URL; ?>cfsnew/comparers.php"target="_blank">Click Here to compare with other companies in CFS database</a>
                             </td>

                             </tr>
                 <?php
                 }
                else
                 {
                 ?>
                             <td>&nbsp;Paid Subscribers can view a link to the co. financials here </td> </tr>
                 <?php
                  }
                 ?>
               
        <?php
} 
        ?>
        
        
        
        <!-- pecompany links -->
         <?php if(mysql_num_rows($company_link_Sql)>0){ ?>
        <tr> <td><h4> Links & Comments </h4></td><td>
  
         <?php while($com_links_com = mysql_fetch_array($company_link_Sql)) { ?>
         <p style="font-weight: normal;margin:2px  0 8px;line-height: 20px;"><a href='<?php echo $com_links_com['Link']?> ' target="_blank" style="font-weight: bold;"> <?php echo $com_links_com['Link']?>  </a> <br> <?php echo $com_links_com['Comment']?>  </p> 
        <?php } ?>
         </td></tr>
        <?php } ?>
        <!-- end pecompany links -->
        
     </tbody>
        </table> 
        </div>   
        <?php
        }*/
      ?>
    
    
    
 <?php
        if($rsangel= mysql_query($angelinvsql))
            {
                 $angel_cnt = mysql_num_rows($rsangel);
            }
            if($angel_cnt>0)
            {                   
        ?>
        
         <div   class="work-masonry-thumb  com-inv-sec   col-2 masonry-brick" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
            <h2>Angel Investments</h2>
            <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
            <thead><tr><th>Investor Name</th> <th>Deal Period</th></tr></thead>
            <tbody>
             <?php

                While($angelrow=mysql_fetch_array($rsangel, MYSQL_BOTH))
                {
                  $Investorname=trim($angelrow["Investor"]);
                $Investorname=strtolower($Investorname);

                $invRes=substr_count($Investorname,$searchString);
                        $invRes1=substr_count($Investorname,$searchString1);
                        $invRes2=substr_count($Investorname,$searchString2);


                        if(($invRes==0) && ($invRes1==0) && ($invRes2==0))
                        {

?>
<tr><td style="alt"><a href='angleinvdetails.php?value=<?php echo $angelrow["InvestorId"].'/'.$VCFlagValue;?>' ><?php echo $angelrow["Investor"]; ?></a></td>

                        <td> <a href="angeldealdetails.php?value=<?php echo $angelrow["AngelDealId"].'/'.$VCFlagValue;?>">
                                                <?php echo $angelrow["dt"];?></a></td></tr>

<?php
                        }
                        elseif(($invRes==1) || ($invRes1==1) || ($invRes2==1))
                        {
                          $AddUnknowUndisclosedAtLast=$angelrow["Investor"];
                          $dealid=$angelrow["AngelDealId"];
                                $dtdisplay=$angelrow["dt"];
                        }
                        elseif($invRes2==1)
                        {
                          $AddOtherAtLast=$angelrow["Investor"];
                          $dealid=$angelrow["AngelDealId"];
                          $dtdisplay1=$angelrow["dt"];
                          }

                }

            // if($AddUnknowUndisclosedAtLast!="")
            //{
              ?>
            </tbody>
            </table> 
           
            </div>
           

           
    <?php
            } ?>
         
         </div>	
        </div>
         
         
         
         
         
        
        
        
        <!-- Angel Only Start -->
      
        <?php 
            
            
            if($rolescount2 > 0) { ?> 
            
        <div class="com-col" style="padding: 20px">
             
            <div class="investment-cnt-com">
                <div class="company-cnt-sec">
             <span >INVESTORS from previous rounds</span>
             <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
             </div>
                 <?php foreach ($roles as $ro) {  
                    if($ro->role == 'past_investor' || $ro->role == 'current_investor') { ?>
                <div class="com-investment-profile">
                    
                    <?php if($ro->tagged->image) { ?>
                    <img src="<?php echo $ro->tagged->image ?>" alt="<?php echo $ro->tagged->name ?>">
                    <?php }elseif($ro->tagged->thumb_url) { ?>
                    <img src="<?php echo $ro->tagged->thumb_url ?>" alt="<?php echo $ro->tagged->name ?>">
                    <?php } ?>
                    
                    
                    <div class="inver-pro-sec">
                         <?php
                        $InvQuery = mysql_query("SELECT InvestorId FROM peinvestors where angelco_invID='".$ro->tagged->id."' LIMIT 1"); 
                        $Invcount = mysql_num_rows($InvQuery);
                        if($Invcount>0) {
                            $Invalue = mysql_fetch_array($InvQuery);
                        ?>
                        <h5><a href="angleinvdetails.php?value=<?php echo $Invalue['InvestorId'];?>/2"><?php echo $ro->tagged->name ?></a></h5>
                         <?php } else { ?>
                        <h5><a href="angleinvdetails.php?value=<?php echo $ro->tagged->id?>/2&angelco_only"><?php echo $ro->tagged->name ?></a></h5>
                        <?php } ?>
                        
                        <?php if($ro->role == 'past_investor'){?>
                        <span style="font-size: 14px;font-weight: bold;"> Past Investor </span>
                        <?php } else if($ro->role == 'current_investor'){?>
                        <span style="font-size: 14px;font-weight: bold;"> Current Investor </span>
                        <?php } ?>
                        
                        <p>
                            <?php  if($ro->tagged->bio) { echo $ro->tagged->bio; } elseif($ro->tagged->high_concept){ echo $ro->tagged->high_concept; } ?>
                        </p>
                    </div>
                </div>
                 <?php } } ?>

            </div>
           
         </div>
            
        <?php } ?>
        
                   
        <!-- Angel Only Start -->
        
        
        
         
    </section>
        
        
        
    </div>        
    <!-- new -->        
        
        
        
        
        
        
        
        
       
  
 </div> 
                                                         
      <?php
                        }
                  //  }
                }
                    ?>                       
  </div>
    <?php
            if(($exportToExcel==1) && (!isset($_REQUEST['angelco_only'])))
            {
            ?>
                            <span style="float:right; position: relative; right: 16px;" class="one">
                                     <input class ="export_new" type="button" id="expshowdealsbtn"  value="Export" name="showdeals">
                            </span>
                        <script type="text/javascript">
                            $('#exportbtn').html('<input class ="export_new" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                        </script>
            <?php
            }
    ?>
</td></tr></table>
</div>
</div>
</form>
    <form name="companyDisplay"  id="companyDisplay" method="post" action="exportcompanyprofile.php">
        <input type="hidden" name="txthideCompanyId" value="<?php echo $SelCompRef;?>" >
        <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    </form>
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
         
    });
    $(document).on('click','#pop_menu li',function(){
           window.open('<?php echo BASE_URL; ?>cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
    });
   
    $(document).on('click','#allfinancial',function(){
             
            $(".popup_main").show();
            $('body').css('overflow', 'hidden');
            
    });
</script>
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


<script type="text/javascript">
     
     
     $(document).ready(function() {
        var ventureInvestment =  $( "#ventureInvestment" ).has( "td" ).length ;
        if(ventureInvestment==0){ $( ".vicomp-cnt" ).hide() ;   }
        
        
        
           var investmentsAll =  $( "#investments-all" ).has( "td" ).length ;
        if(investmentsAll==0 && ventureInvestment==0){ $( "#investments-all" ).hide() ;   }
             
        
     });
     
     </script>
     
     
<script type="text/javascript" >
    
     $("a.postlink").click(function () {

        hrefval = $(this).attr("href");

        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;

    });
    
    /*$(".export").click(function(){
        $("#companyDisplay").submit();
    });*/
    
    $('.export').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
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

                            $("#companyDisplay").submit();
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
                    data: { to : $("#toaddress").val(), subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
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
<style>
    
     .com-investment-profile{
        width: 33%
    }
    .bor-top-cnt{
        border-top: 1px solid #e4e4e4;
        clear: both;
        padding-top: 10px;
    }
    .mar-top {
        margin: 0px 15px 10px;
}
</style>
<?php
mysql_close();
    mysql_close($cnx);
    ?>