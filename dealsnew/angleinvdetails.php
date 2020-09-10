<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('checklogin.php');
    
    $searchString = "Undisclosed";
    $searchString = strtolower($searchString);

    $searchString1 = "Unknown";
    $searchString1 = strtolower($searchString1);

    $searchString2 = "Others";
    $searchString2 = strtolower($searchString2);

    $dbTypeSV = "SV";
    $dbTypeIF = "IF";
    $dbTypeCT = "CT";


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

     
    if($VCFlagValue==2)
    {
            $getTotalQuery= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
            FROM REinvestments AS pe, pecompanies AS pec
            WHERE pec.Industry =15 and pe.Deleted=0
            AND pe.PEcompanyID = pec.PECompanyId ";
            $pagetitle="PE Investments - Real Estate -> Search";
            $stagesql_search="";
             $industrysql="select industryid,industry from industry where industryid =15 ";

    }    
    $investorId = $strvalue[0];

    $pe_re = 1;
    if ($pe_re == 1) {
        $industryvalue = "!=15";
        $dealpage = "angeldealdetails.php";
    } elseif ($pe_re == 2) {
        $industryvalue = "=15";
        $dealpage = "redealinfo.php";
    }

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
              //$industryvalue="!=15";
	$sql="select * from peinvestors where InvestorId=$investorId";
        
        // moorthi 21-05-015
        if($VCFlagValue==2){
        $angInvestmentsql="select peinv_inv.InvestorId,peinv_inv.AngelDealId,peinv.InvesteeId,
								c.companyname,c.industry,i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,inv.*
								from angel_investors as peinv_inv,peinvestors as inv,
								angelinvdeals as peinv,pecompanies as c,industry as i
								where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
								and peinv.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinv.InvesteeId and peinv.Deleted=0
								and c.industry $industryvalue  and i.industryid=c.industry
								order by peinv.DealDate desc";
    }
        //
    
    $Investmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname,
                    peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,AggHide
                   FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                   WHERE peinv.Deleted =0
                   AND c.PECompanyId = peinv.PECompanyId
                   AND c.industry $industryvalue
                   AND i.industryid = c.industry
                   AND peinv_inv.InvestorId =$investorId
                   AND inv.InvestorId = peinv_inv.InvestorId
                   AND peinv.PEId = peinv_inv.PEId
                   AND peinv.PEId NOT
                   IN (

                   SELECT PEId
                   FROM peinvestments_dbtypes AS db
                   WHERE DBTypeId='$dbTypeSV' and hide_pevc_flag=1
                   ) order by peinv.dates desc";
   

    $iposql = "select peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,
                c.companyname,c.industry,i.industry as indname,DATE_FORMAT( peinv.IPODate, '%b-%Y' ) as dealperiod,peinv.ExitStatus,inv.*
                from ipo_investors as peinv_inv,peinvestors as inv,
                ipos as peinv,pecompanies as c,industry as i
                where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId and peinv.Deleted=0 and i.industryid=c.industry
                and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId and c.industry $industryvalue";
    
     //For Angel - Exits
   if($VCFlagValue==2){
    $iposql="select peinv_inv.InvestorId,peinv_inv.AngelDealId,peinv.InvesteeId,
				c.companyname,c.industry,i.industry as indname,
                                DATE_FORMAT( peinv.DealDate, '%b-%Y' ) as dealperiod,inv.Investor
				from angel_investors as peinv_inv,peinvestors as inv,
				angelinvdeals as peinv,pecompanies as c,industry as i
				where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                                and peinv.Deleted=0 and i.industryid=c.industry
				and peinv.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinv.InvesteeId and peinv.Exited=1
                                and c.industry $industryvalue";
    }
    
    //   echo"<bR>---" .$iposql;
    $mandasql = "select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
                c.companyname,c.industry , i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,peinv.ExitStatus,inv.*
                from manda_investors as peinv_inv,peinvestors as inv,
                manda as peinv,pecompanies as c,industry as i
                where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
                and c.industry $industryvalue
                order by DealDate desc";

    $onMgmtSql = "select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
                exe.ExecutiveName,exe.Designation,exe.Company from
                peinvestors as pec,executives as exe,peinvestors_management as mgmt
                where pec.InvestorId=$investorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";

    $SVInvestmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId,
                        DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,AggHide,SPV
                         FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                         WHERE peinv.Deleted =0
                         AND c.PECompanyId = peinv.PECompanyId
                         AND c.industry $industryvalue
                         AND i.industryid = c.industry
                         AND peinv_inv.InvestorId =$investorId
                         AND inv.InvestorId = peinv_inv.InvestorId
                         AND peinv.PEId = peinv_inv.PEId
                         AND peinv.PEId
                         IN (
                         SELECT PEId
                         FROM peinvestments_dbtypes AS db
                         WHERE DBTypeId = '$dbTypeSV'
                         ) order by peinv.dates desc";
    //echo "<br>-- ".$SVInvestmentsql;
    $IFInvestmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod
                          FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND c.industry $industryvalue
                          AND i.industryid = c.industry
                          AND peinv_inv.InvestorId =$investorId
                          AND inv.InvestorId = peinv_inv.InvestorId
                          AND peinv.PEId = peinv_inv.PEId
                          AND peinv.PEId
                          IN (

                          SELECT PEId
                          FROM peinvestments_dbtypes AS db
                          WHERE DBTypeId = '$dbTypeIF'
                          ) order by peinv.dates desc";


    $CTInvestmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod
                          FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND c.industry $industryvalue
                          AND i.industryid = c.industry
                          AND peinv_inv.InvestorId =$investorId
                          AND inv.InvestorId = peinv_inv.InvestorId
                          AND peinv.PEId = peinv_inv.PEId
                          AND peinv.PEId
                          IN (

                          SELECT PEId
                          FROM peinvestments_dbtypes AS db
                          WHERE DBTypeId = '$dbTypeCT'
                          ) order by peinv.dates desc";
//echo "<br>---" .$SVInvestmentsql;
     $followoninvsql="select distinct peinva.InvesteeId,pe.PEId,pe.PECompanyId,c.Companyname,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
                        from angel_investors as peinv_inv,peinvestors as inv,
                       angelinvdeals as peinva,pecompanies as c,industry as i,
                       peinvestments as pe,peinvestments_investors as peinv
                       where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv.InvestorId
                       and peinva.Deleted=0 and i.industryid=c.industry
                       and peinva.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinva.InvesteeId and c.PECompanyId=pe.PECompanyId
                       and peinva.FollowonVCFund=1  and pe.PECompanyId=peinva.InvesteeId and peinv.PEId=pe.PEId
                       and c.industry $industryvalue order by dates desc";
         
    $indSql = "SELECT DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
			FROM peinvestments_investors AS peinv_inv, peinvestors AS inv, pecompanies AS c, peinvestments AS peinv, industry AS i
			WHERE peinv_inv.InvestorId =$investorId
			AND inv.InvestorId = peinv_inv.InvestorId
			AND c.PECompanyId = peinv.PECompanyId
			AND peinv.PEId = peinv_inv.PEId and i.industryid!=15  and peinv.Deleted=0
			AND i.industryid = c.industry order by i.industry";
    //echo "<br>====" .$indSql;

    $stageSql = "select distinct s.Stage,pe.StageId,peinv_inv.InvestorId
                    from peinvestments_investors as peinv_inv,peinvestors as inv,peinvestments as pe,stage as s
                    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                    and pe.PEId=peinv_inv.PEId and s.StageId=pe.StageId order by Stage ";

//echo "<br>--" .$stageSql;

    $strIndustry = "";
    $strStage = "";
    if ($rsInd = mysql_query($indSql)) {
        While ($myIndrow = mysql_fetch_array($rsInd, MYSQL_BOTH)) {
            $strIndustry = $strIndustry . ", " . $myIndrow["ind"];
        }
        $strIndustry = substr_replace($strIndustry, '', 0, 1);
    }

    if ($rsStage = mysql_query($stageSql)) {
        While ($myStageRow = mysql_fetch_array($rsStage, MYSQL_BOTH)) {
            $strStage = $strStage . ", " . $myStageRow["Stage"];
        }
        $strStage = substr_replace($strStage, '', 0, 1);
    }

    //echo "<br>".$sql;
    ?>

<?php
	$topNav = 'Deals'; 
	include_once('angelheader_search.php');
?>     


<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
    
 <td class="left-td-bg" >
     <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once('angelrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>	
</div>
     </div>
</td>   
</form>
 
<form name="investorDetails" id="investorDetails" method="post" action="angelinvestorexport.php">

<td class="profile-view-left" style="width:100%;">
   <br> <div class="title-links" style="position: relative; right: 16px; margin-bottom: 10px;">           
        <br>  <input class="senddeal" type="button" id="senddeal" value="Send this investor profile to your colleague" name="senddeal">    
        <?php 
            if(($exportToExcel==1))
                 {
                 ?>
                        <span id="exportbtn" style="margin-left: 5px;"></span>
                 <?php
                 }
             ?>
   </div><br><br>
    <div class="result-cnt">
                    <?php 
                    if ($rsinvestors = mysql_query($sql)) { 
                       ?> 
                        
                   
                                <input type="hidden" name="txthideinvestorId" value="<?php echo $investorId;?>" >
                                <input type="hidden" name="hidepeipomandapage" value="5" >
                                <input type="hidden" name="txthidepevalue" value="<?php echo $VCFlagValue; ?>" >
                                <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
                                
                    <?php             }
                    ?>
                        <?php
                       $rsinvestors = mysql_query($sql);

                        if (isset($_REQUEST['angelco_only'])) { 
                            $angelco_invID = $strvalue[0];
                        } else if (mysql_num_rows($rsinvestors) > 0) {
                            
                            
                              $myrow = mysql_fetch_array($rsinvestors, MYSQL_BOTH);
                             
                                
                             if($myrow["angelco_invID"]>0){
                                 $angelco_invID = $myrow["angelco_invID"];
                             }else{
                                 $angelco_invID ='';
                             }
                             
                             
                             
                           $Address1=$myrow["Address1"];
                            $Address2=$myrow["Address2"];
                            $AdCity=$myrow["City"];
                            $Zip=$myrow["Zip"];
                            $Tel=$myrow["Telephone"];
                            $Fax=$myrow["Fax"];
                            $Email=$myrow["Email"];
                            $website=$myrow["website"];
                            
                            $description = $myrow["Description"];
                            $yearfounded=$myrow["yearfounded"];
                            $no_employees = $myrow["NoEmployees"];
                            $firm_type = $myrow["FirmType"];
                            $other_location = $myrow["OtherLocation"];
                            $assets_mgmt = $myrow["Assets_mgmt"];
                            $already_invested = $myrow["AlreadyInvested"];
                            $preferred_stage = ltrim($strStage);  //$myrow["PreferredStage"];
                            $limited_partners = $myrow["LimitedPartners"];
                            $no_funds = $myrow["NoFunds"];
                            $no_activefunds = $myrow["NoActiveFunds"];
                            $min_investment - $myrow["MinInvestment"];
                            $comment = $myrow["comment"];
                            $txtcountryid = $myrow["countryid"];
                            
                            $AddInfo=$myrow["AdditionalInfor"];
                            $keycontact=$myrow["KeyContact"];
                            $google_sitesearch="https://www.google.co.in/search?q=".$myrow["Investor"]."+site%3Alinkedin.com";
                            $countrysql = "select country from country where countryid='$txtcountryid'";
                        
                            if ($rscountry = mysql_query($countrysql)) {
                                While ($mycountryrow = mysql_fetch_array($rscountry, MYSQL_BOTH)) {
                                    $countryname = $mycountryrow["country"];
                                }
                            }
                            $google_sitesearch = "https://www.google.co.in/search?q=" . $myrow["Investor"] . "+site%3Alinkedin.com";
                            
                            }
                            ?>
                     <div class="list-tab"><ul>
                        <li><a class="postlink"  href="angelindex.php?value=<?php echo $strvalue[1]; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
                        <li class="active"><a id="icon-detailed-view" class="postlink" href="angeldealdetails.php?value=<?php echo $_GET['value'].'/'.$vcflagValue;?>" ><i></i> Detailed View</a></li> 
                        </ul></div> 
    <div class="lb" id="popup-box">
	<div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To*</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject*</h5>
                    <p>Checkout this profile - <?php echo $myrow["Investor"]; ?> - in Venture Intelligence</p>
                    <input type="hidden" name="basesubject" id="basesubject" value="Investor profile" />
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
<div class="view-detailed">
    
    
    

                        <!-- new -->
                            <?php
                            if ($angelco_invID != '') {


                                $profileurl = "https://api.angel.co/1/users/$angelco_invID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&include_details=investor"; 

                                //role=founder&
                                $roleurl = "https://api.angel.co/1/users/$angelco_invID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";

                                $profilejson = file_get_contents($profileurl);
                                $profile = json_decode($profilejson);


                                $rolejson = file_get_contents($roleurl);
                                $roles = json_decode($rolejson);
                                $roles = $roles->startup_roles;

                                //echo "<pre>";
                                //print_r($roles);
                                //echo "</pre>";
                            }
                            ?>
                        
                        
                        <div class="detailed-title-links"> <?php if(!isset($_REQUEST['angelco_only']) && $angelco_invID==''){ ?> <h2>  <?php echo $myrow["Investor"]; ?></h2> <?php } ?>
                        <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a>

                      </div>             
       
                        
                        <div class="com-wrapper">
                            
                            <?php if ($angelco_invID != '') { ?>
<!--                            <section class="com-cnt-sec inv-bg-white">
                                <div class="inv-detail-pos"">
                                    <span class="fl inv-detail-avt"><?php if ($profile->image) { ?> <img src="<?php echo $profile->image ?>" > <?php } ?></span>
                                    <h2> <?php if ($profile->name) {  echo $profile->name; } ?></h2> 
                                    <p> <?php if ($profile->bio) {   echo $profile->bio;   } ?></p>

                                </div>  

                            </section>-->
                            <?php } ?>
                            
                                <section class="com-cnt-sec" id="investorProfile">
                                    
                                    <?php if ($angelco_invID != '') { ?>
                                <header>
                                    <h3 class="fl">Investor Profile</h3>
                                    <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
                                </header>
                                    
                                <div class="com-col">
                                    
                                <div class="inv-detail-pos" style="padding: 10px 20px 40px;">
                                    <span class="fl inv-detail-avt" style="padding-right: 20px;"><?php if ($profile->image) { ?> <img src="<?php echo $profile->image ?>" > <?php } ?></span>
                                    <h2 style="font-size: 36px;"> <?php if ($profile->name) {  echo $profile->name; } ?></h2> 
                                    <p  style="font-size: 21px;"> <?php if ($profile->bio) {   echo $profile->bio;   } ?></p>

                                </div>  
                                    
                                    
                                    <div class="com-sec-lg">
                                        <table class="inv-pro-table">
                                            <tbody>
                                                
                                                    
                        <?php
                        if ($angelco_invID != '' && count($roles) > 0) {
                            $founder = array();
                            foreach ($roles as $f) {
                                if ($f->role == 'founder') {
                                    $founder[] = $f->startup->name;
                                }
                            }
                            
                            if(count($founder)>0){
                                echo "<tr><td><span>Founder</span></td><td>";
                                echo implode(", ", $founder);
                                echo "</td></tr>";
                            }
                            
                            
                            //DSG Growth, DSG Consumer Partners, Beacon India Private Equity Fund 
                        }
                        ?>
                                                
                        <?php
                        if ($angelco_invID != '' && count($roles) > 0) {
                            $employee = array();
                            foreach ($roles as $e) {
                                if ($e->role == 'employee') {
                                    $employee[] = $e->startup->name;
                                }
                            }
                            
                             if(count($employee)>0){
                                echo "<tr><td><span>Employee</span></td><td>";
                                echo implode(", ", $employee);
                                echo "</td></tr>";
                            }
                           
                            //Bain & Company, Reuters Venture Capital 
                        }
                        ?>
                                                  
                                               

                        <?php
                        if ($angelco_invID != '' && count($roles) > 0) {
                            $past_investor = array();
                            foreach ($roles as $i) {
                                if ($i->role == 'past_investor') {
                                    $past_investor[] = $i->startup->name;
                                }
                            }
                           
                             if(count($past_investor)>0){
                                echo "<tr><td><span>Investor</span></td><td>";
                                echo implode(", ", $past_investor);
                                echo "</td></tr>";
                            }
                            // Cleartrip, Vouch Financial, Navdy, Birdi, Authy, Faraday Bicycles, Rockbot, Weaved, Gil Penchina Backers Fund I, Onfleet, AngelList Syndicates Fund I, SkyKick, Lenda, RedMart, Airdog, Recarga.com, Chope, ZipDial, GOQii, OYO Rooms, EkStop, Doonya, Indian Home Gourmet Pvt., Bakers Circle, Exito Gourmet, 7 more...</td>
                        }
                        ?>

                                                
                                                
                        <?php
                        if ($angelco_invID != '' && count($profile->skills) > 0) {
                            $skills = array();
                            foreach ($profile->skills as $s) {
                                if ($s->display_name) {
                                    $skills[] = $s->display_name;
                                }
                            }
                           
                            if(count($skills)>0){
                                echo "<tr><td><span>Skills</span></td><td>";
                                echo implode(", ", $skills);
                                echo "</td></tr>";
                            }
                            // Private Equity, Venture Capital, Consumer Businesses
                        }
                        ?>
                                                    
                                              
                        <?php
                        if ($angelco_invID != '' && count($profile->locations) > 0) {
                            $locations = array();
                            foreach ($profile->locations as $l) {
                                if ($l->display_name) {
                                    $locations[] = $l->display_name;
                                }
                            }
                            
                             if(count($locations)>0){
                                echo "<tr><td><span>Locations</span></td><td>";
                                echo implode(", ", $locations);
                                echo "</td></tr>";
                            }
                            
                           
                            // Bain & Company, Reuters Venture Capital
                        }
                        ?>
                                                   
                                               
                        <?php
                        if ($angelco_invID != '' && count($profile->investor_details->markets) > 0) {
                            $markets = array();
                            foreach ($profile->investor_details->markets as $m) {
                                if ($m->display_name) {
                                    $markets[] = $m->display_name;
                                }
                            }
                           
                             if(count($markets)>0){
                                echo "<tr><td><span>Markets</span></td><td>";
                                echo implode(", ", $markets);
                                echo "</td></tr>";
                            }
                            // Bain & Company, Reuters Venture Capital
                        }
                        ?>
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pro-inve-exp">
                                        
                                       
                                                        <?php if (count($profile->investor_details->investments) > 0) {
                                                                echo "<p><span>Experience</span>";
                                                                echo count($profile->investor_details->investments)." Confirmed Investments ·";
                                                                if ($profile->investor_details->average_amount) {
                                                                echo $profile->investor_details->average_amount;
                                                                }
                                                             echo "</p>";
                                                            }
                                                        ?>
                                        
                                    </div>
                                </div>
                                    
                                    <?php } ?> 
                                    
                                <?php if(!isset($_REQUEST['angelco_only'])) { ?>  
                                    
                                <div class="com-col">
                                    <div class="table-sec">
                                        <table class="inv-pro-table">






                                                        <?php
                                                        if ($myrow["Investor"] != "") {
                                                            ?>                                        

                                                <tr>
                                                    <td><span>Investor Name</span></td>
                                                    <td><?php echo $myrow["Investor"]; ?></td>
                                                </tr>
                                                            <?php
                                                        }
                                                        if (trim($Address1) != "" || trim($Address2) != "") {
                                                            ?>
                                                <tr>
                                                    <td><span>Address</span></td>
                                                    <td><?php echo $Address1; ?><?php if ($Address2 != "") echo "<br/>" . $Address2; ?></td>
                                                </tr>
    <?php
}
if ($AdCity != "") {
    ?>
                                                <tr>
                                                    <td><span>City</span></td>
                                                    <td><?php echo $AdCity; ?></td>
                                                </tr>
    <?php
}
if (($countryname != "") && ($countryname != "--" )) {
    ?>
                                                <tr>
                                                    <td><span>Country</span></td>
                                                    <td><?php echo $countryname; ?></td>
                                                </tr>  
    <?php
}
if (($Zip != "") || ($Zip > 0)) {
    ?>
                                                <tr>
                                                    <td><span>Zip</span></td>
                                                    <td><?php echo $Zip; ?></td>
                                                </tr>  
    <?php
}
if (($Tel != "") || ($Tel > 0)) {
    ?>
                                                <tr>
                                                    <td><span>Telephone</span></td>
                                                    <td><?php echo $Tel; ?></td>
                                                </tr>  
    <?php }
?>
                                            <?php
                                            $rsMgmt = mysql_query($onMgmtSql);
                                            if (mysql_num_rows($rsMgmt) > 0) {
                                                ?>
                                                <tr>
                                                    <td><span>Management</span></td>
                                                    <td>

                                                <?php
                                                While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
                                                    $designation = $mymgmtrow["Designation"];
                                                    if ($mymgmtrow["Designation"] == "")
                                                        $designation = "";
                                                    else
                                                        $designation = $mymgmtrow["Designation"];
                                                    ?>
        <?php echo $mymgmtrow["ExecutiveName"]; ?> ( <?php echo $designation; ?> ) <br/>
                                                <?php }
                                                ?>
                                                    </td>
                                                </tr>        
                                                <?php
                                            }
                                            ?>
<?php if (trim($Email) != "") {
    ?>
                                                <tr>
                                                    <td><span>Email</span></td>
                                                    <td><?php echo $Email; ?></td>
                                                </tr>  
    <?php
}

if ($yearfounded != "") {
    ?>
                                                <tr>
                                                    <td><span>In India Since</span></td>
                                                    <td><?php echo $yearfounded; ?></td>
                                                </tr>   
                                                <?php
                                            }
                                            if (trim($website) != "") {
                                                ?>
                                                <tr>
                                                    <td><span>Website</span></td>
                                                    <td><a href=<?php echo $website; ?> target="_blank"> Click Here </a></td>
                                                </tr>  
                                                        <?php
                                                    }
                                                    if ($investor_newssearch != "") {
                                                        ?>
                                                <tr>
                                                    <td><span>News</span></td>
                                                    <td><a href=<?php echo $investor_newssearch; ?> target="_blank">Click Here</a></td>
                                                </tr>  
    <?php
}
//{
?>


                                            <?php if ($linkedinSearchDomain != "") {
                                                ?>
    <!--  <li id="viewlinkedin_loginbtn" style="display: none"><h4>View LinkedIn Profile  </h4><p><script type="in/Login"></script></p></li>-->
                                                <tr style="display: none">
                                                    <td><span>View LinkedIn Profile</span></td>
                                                    <td><script type="in/Login"></script></td>
                                                </tr>  
                                            <?php } ?>








                                        </table>
                                        
                                        
                                        
                                        
                                        <div>
<?php
//echo "dddddddddddddddd".$linkedIn;
if ($linkedIn != '') {

    $url = $linkedIn;
    $keys = parse_url($url); // parse the url
    $path = explode("/", $keys['path']); // splitting the path
    $companyid = (int) end($path); // get the value of the last element  
    ?>
                                    <div class="linkedin-bg">

                                        <script type="text/javascript" >

                                            $(document).ready(function () {
                                                $('#lframe,#lframe1').on('load', function () {
                                                    //            $('#loader').hide();

                                                });
                                            });

                                            function autoResize(id) {
                                                var newheight;
                                                var newwidth;

                                                if (document.getElementById) {
                                                    newheight = document.getElementById(id).contentWindow.document.body.scrollHeight;
                                                    newwidth = document.getElementById(id).contentWindow.document.body.scrollWidth;
                                                }

                                                document.getElementById(id).height = (newheight) + "px";
                                                document.getElementById(id).width = (newwidth) + "px";
                                            }
                                        </script>

                                        <script type="text/javascript" src="http://platform.linkedin.com/in.js">
                                            api_key:65623uxbgn8l
                                                    authorize:true
                                            onLoad: onLinkedInLoad
                                        </script>
                                        <script type="text/javascript" >
                                            var idvalue =<?php echo $companyid; ?>;
                                            //alert(idvalue);
                                            function onLinkedInLoad() {
                                                $("#viewlinkedin_loginbtn").hide();
                                                var profileDiv = document.getElementById("sample");

                                                if (idvalue)
                                                {
                                                    $("#lframe").css({"height": "220px"});
                                                    $("#lframe1").css({"height": "300px"});

                                                    var inHTML = 'loadlinkedin.php?data_id=' + idvalue;
                                                    var inHTML2 = 'linkedprofiles.php?data_id=' + idvalue;
                                                    $('#lframe').attr('src', inHTML);
                                                    $('#lframe1').attr('src', inHTML2);
                                                }
                                                else
                                                {
                                                    $('#lframe').hide();
                                                    $('#lframe1').hide();
                                                    $('#loader').hide();
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

<?php
} else {

    $linkedinSearchDomain = str_replace("http://www.", "", $website);
    $linkedinSearchDomain = str_replace("http://", "", $linkedinSearchDomain);
    if (strrpos($linkedinSearchDomain, "/") != "") {
        $linkedinSearchDomain = substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
    }
    if ($linkedinSearchDomain != "") {
        ?>
        <!--<img src="images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;">-->
                                        <div class="linkedin-bg">

                                            <script type="text/javascript" >

                                                $(document).ready(function () {
                                                    $('#lframe,#lframe1').on('load', function () {
                                       //            $('#loader').hide();

                                                    });
                                                });

                                                function autoResize(id) {
                                                    var newheight;
                                                    var newwidth;

                                                    if (document.getElementById) {
                                                        newheight = document.getElementById(id).contentWindow.document.body.scrollHeight;
                                                        newwidth = document.getElementById(id).contentWindow.document.body.scrollWidth;
                                                    }

                                                    document.getElementById(id).height = (newheight) + "px";
                                                    document.getElementById(id).width = (newwidth) + "px";
                                                }
                                            </script>



                                            <script type="text/javascript" src="http://platform.linkedin.com/in.js">
                                               api_key:65623uxbgn8l
                                                       authorize:true
                                               onLoad: LinkedAuth
                                            </script>
                                            <script type="text/javascript" >
                                                var idvalue;
                                                //document.getElementById("sa").textContent='asdasdasd'; 

                                                function LinkedAuth() {
                                                    if (IN.User.isAuthorized() == 1) {
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
                                                    var url = "/company-search:(companies:(id,website-url))?keywords=<?php echo $myrow["Investor"] ?>";

                                                    console.log(url);

                                                    IN.API.Raw(url).result(function (response) {

                                                        console.log(response);
                                                        //console.log(response['companies']['values'].length);                  
                                                        //console.log(response['companies']['values'][0]['id']);
                                                        //console.log(response['companies']['values'][0]['websiteUrl']);
                                                        var searchlength = response['companies']['values'].length;

                                                        var domain = '';
                                                        var website = '<?php echo $linkedinSearchDomain ?>';

                                                        for (var i = 0; i < searchlength; i++) {

                                                            if (response['companies']['values'][i]['websiteUrl']) {
                                                                domain = response['companies']['values'][i]['websiteUrl'].replace('www.', '');
                                                                domain = domain.replace('http://', '');
                                                                domain = domain.replace('/', '');
                                                                if (domain == website) {
                                                                    idvalue = response['companies']['values'][i]['id'];
                                                                    console.log(idvalue);
                                                                    break;
                                                                }
                                                            }
                                                        }


                                                        if (idvalue)
                                                        {
                                                            $("#lframe").css({"height": "220px"});
                                                            $("#lframe1").css({"height": "300px"});

                                                            var inHTML = 'loadlinkedin.php?data_id=' + idvalue;
                                                            var inHTML2 = 'linkedprofiles.php?data_id=' + idvalue;
                                                            $('#lframe').attr('src', inHTML);
                                                            $('#lframe1').attr('src', inHTML2);
                                                        }
                                                        else
                                                        {
                                                            $('#lframe').hide();
                                                            $('#lframe1').hide();
                                                            $('#loader').hide();
                                                        }

                                                        //  profileDiv.innerHtml=inHTML;
                                                        //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                                                    }).error(function (error) {
                                                        console.log(error);
                                                        $('#lframe').hide();
                                                        $('#lframe1').hide();
                                                        $('#loader').hide();
                                                    });
                                                }


                                            </script>

                                            <div  id="sample" style="padding:10px 10px 0 0;">

                                                <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
                                            </div>

                                            <input type="hidden" name="dataId" id="dataId" >

                                        </div>
                                        <div class="fl" style="padding:10px 10px 0 0;"><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div>  <?php }
                        }
?>
                           
</div>

                                        
                                        
                                        
                                    </div>
                                    <img src="img/co-sec-logo.png" class="fr pad-20" alt="vi">
                                </div>
                                    
                                 <?php } ?>    
                                    
                            </section>
                            
                            
                            
                            
                            
                            <section class="com-cnt-sec investor-sec mar-10 " id="ventureInvestment" style="width:100%">   	
                                <header>
                                    <h3 class="fl">Investments</h3>
                                    <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
                                </header>
                                <div class="com-col">
                                    <div class="inv-cnt">
                                        <div class="inv-com-name">


                                            <?php
                                            if ($getcompanyinvrs = mysql_query($Investmentsql)) {
                                                $inv_cnt = mysql_num_rows($getcompanyinvrs);
                                            }
                                            if ($getIFcompanyinvrs = mysql_query($IFInvestmentsql)) {
                                                $investmentIf_cnt = mysql_num_rows($getIFcompanyinvrs);
                                            }
                                            if ($getCTcompanyinvrs = mysql_query($CTInvestmentsql)) {
                                                $investmentct_cnt = mysql_num_rows($getCTcompanyinvrs);
                                            }

                                            if ($getANGLcompInv = mysql_query($angInvestmentsql)) {
                                                $angelinv_cnt = mysql_num_rows($getANGLcompInv);
                                            }

                                            if ($inv_cnt > 0 || $investmentIf_cnt > 0 || $investmentct_cnt > 0 || $angelinv_cnt > 0) {
                                                ?>
                                                <div  class="work-masonry-thumb col-2 for-nai">


                                                    <div id="tabsholder2">
                                                        <ul class="tabs">
    <?php
    if ($inv_cnt > 0) {
        ?>

                                                                <li id="tabz1">PE/VC Investments</li>
        <?php
    } else if ($angelinv_cnt > 0) {
        ?>
                                                                <li id="tabz1">Investments</li>
        <?php
    }

    if ($investmentIf_cnt > 0) {
        ?>
                                                                <li id="tabzinfrascruture">Infrastructure</li>
                                                    <?php
                                                }


                                                if ($investmentct_cnt > 0) {
                                                    ?>
                                                                <li id="tabzcleantech">Cleantech</li>
                                                    <?php
                                                }
                                                ?>

                                                        </ul>
                                                        <div class="contents marginbot">
                                                <?php
                                                if ($inv_cnt > 0) {
                                                    ?>

                                                                <div id="contentz1" class="tabscontent"> 
                                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                                                        <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                                                                        <tbody>
        <?php

          $addTrancheWordtxt = "";

        While ($myInvestrow = mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH)) {

            $companyName = trim($myInvestrow["companyname"]);
            $companyName = strtolower($companyName);
            $compResult = substr_count($companyName, $searchString);
            $compResult1 = substr_count($companyName, $searchString1);
            if ($myInvestrow["AggHide"] == 1) {
                $addTrancheWord = "; NIA";
                $addTrancheWordtxt = $addTrancheWord;
            } else
                $addTrancheWord = "";
            if (($compResult == 0) && ($compResult1 == 0)) {
                ?>
                                                                                    <tr><td style="alt">
                                                                                            <a href='dircomdetails.php?value=<?php echo $myInvestrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $myInvestrow["companyname"]; ?></a></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                                    <tr><td style="alt">
                                                                        <?php echo ucfirst("$searchString"); ?></td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                                    <td><?php echo $myInvestrow["indname"]; ?></td><td><a href="<?php echo $dealpage; ?>?value=<?php echo $myInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>">
                                                                    <?php echo $myInvestrow["dealperiod"]; ?></a><?php echo $addTrancheWord; ?></td>


                                                                                </tr>
                                                                    <?php
                                                                }
                                                                ?>

                                                                        </tbody>
                                                                    </table>
                                                                     <?php if($addTrancheWordtxt == "; NIA"){ ?>
                                                                            <p class="note-nia">*NIA - Not Included for Aggregate</p>
                                                                        <?php }?>

                                                                  </div>
                                                                <?php
                                                            } else if ($angelinv_cnt > 0) {
                                                                ?>

                                                                <div id="contentz1" class="tabscontent"> 
                                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                                                        <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                                                                        <tbody>
                                                                            <?php
                                                                            While ($myInvestrow = mysql_fetch_array($getANGLcompInv, MYSQL_BOTH)) {
                                                                                $companyName = trim($myInvestrow["companyname"]);
                                                                                $companyName = strtolower($companyName);
                                                                                $compResult = substr_count($companyName, $searchString);
                                                                                $compResult1 = substr_count($companyName, $searchString1);
                                                                                if (($compResult == 0) && ($compResult1 == 0)) {
                                                                                    ?>
                                                                                    <tr><td style="alt">
                                                                                            <a href='dircomdetails.php?value=<?php echo $myInvestrow["InvesteeId"] . '/' . $vcflagValue . '/' . $dealvalue; ?>' ><?php echo $myInvestrow["companyname"]; ?></a></td>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <tr><td >
                <?php echo ucfirst("$searchString"); ?>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                    <td><?php echo $myInvestrow["indname"]; ?></td><td><a href="angeldirdetails.php?value=<?php echo $myInvestrow["AngelDealId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>">
                                                                                        <?php echo $myInvestrow["dealperiod"]; ?></a></td>	</tr>
                                                                                        <?php
                                                                                }
                                                                                ?>

                                                                        </tbody>
                                                                    </table></div>

        <?php
    }

    if ($investmentIf_cnt > 0) {
        ?>
                                                                <div id="contentzinfrascruture" class="tabscontent"> 
                                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                                                        <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                                                                        <tbody>
                                                                <?php
                                                                While ($myIFInvestrow = mysql_fetch_array($getIFcompanyinvrs, MYSQL_BOTH)) {
                                                                    $IFcompanyName = trim($myIFInvestrow["companyname"]);
                                                                    $IFcompanyName = strtolower($IFcompanyName);
                                                                    $compResultaa = substr_count($IFcompanyName, $searchString);
                                                                    $compResult1bb = substr_count($IFcompanyName, $searchString1);
                                                                    ?>

                                                                                <?php
                                                                                if (($compResultaa == 0) && ($compResult1bb == 0)) {
                                                                                    ?>
                                                                                    <tr><td style="alt">
                                                                                            <a href='dircomdetails.php?value=<?php echo $myIFInvestrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $myIFInvestrow["companyname"]; ?></a></td>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <tr><td style="alt">
                                                                                    <?php echo ucfirst("$searchString"); ?></td>
                <?php
            }
            ?>
                                                                                    <td><?php echo $myIFInvestrow["indname"]; ?></td><td><a href="<?php echo $dealpage; ?>?value=<?php echo $myIFInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>">
                                                                                    <?php echo $myIFInvestrow["dealperiod"]; ?> </a></td>


                                                                                </tr>
                                                                                        <?php }
                                                                                    ?>  

                                                                        </tbody>
                                                                    </table> </div>
                                                                                        <?php
                                                                        }
                                                                        if ($investmentct_cnt > 0) {
                                                                            ?>                                       
                                                                <div id="contentzcleantech" class="tabscontent"> 
                                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                                                        <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                                                                        <tbody>

                                                                <?php
                                                                While ($myCTInvestrow = mysql_fetch_array($getCTcompanyinvrs, MYSQL_BOTH)) {
                                                                    $CTcompanyName = trim($myCTInvestrow["companyname"]);
                                                                    $CTcompanyName = strtolower($CTcompanyName);
                                                                    $compResulta = substr_count($CTcompanyName, $searchString);
                                                                    $compResult1b = substr_count($CTcompanyName, $searchString1);
                                                                    ?>
            <?php
            if (($compResulta == 0) && ($compResult1b == 0)) {
                ?>
                                                                                    <tr><td style="alt">
                                                                                            <a href='dircomdetails.php?value=<?php echo $myCTInvestrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $myCTInvestrow["companyname"]; ?></a></td>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <tr><td style="alt">
                                                                                    <?php echo ucfirst("$searchString"); ?></td>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                    <td><?php echo $myCTInvestrow["indname"]; ?></td>
                                                                                    <td><a href="<?php echo $dealpage; ?>?value=<?php echo $myCTInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>">
            <?php echo $myCTInvestrow["dealperiod"]; ?> </a></td>


                                                                                </tr>
                                                                                    <?php }
                                                                                ?>                                                                                                                       
                                                                        </tbody>
                                                                    </table></div>
                                                                                    <?php
                                                                            }
                                                                            ?>

                                                        </div>
                                                    </div>                                                          
                                                </div> <?php } ?>
                                            
                                            
                               
                                             <?php
                                                    if ($getfollowinvrs = mysql_query($followoninvsql)) {
                                                        $investmentfollow_cnt = mysql_num_rows($getfollowinvrs);

                                                        if ($investmentfollow_cnt > 0) {
                                                            ?>
                                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                        <h2> Follow on Investments </h2>
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Deal Period</th></tr></thead>
                                            <tbody>

                                                                <?php
                                                                While ($myfollowInvestrow = mysql_fetch_array($getfollowinvrs, MYSQL_BOTH)) {
                                                                    ?>
                                                    <tr><td style="alt">
                                                            <a href='dircomdetails.php?value=<?php echo $myfollowInvestrow["InvesteeId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $myfollowInvestrow["Companyname"]; ?></a></td>

                                                        <td><a href="<?php echo $dealpage; ?>?value=<?php echo $myfollowInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>">
                                                                    <?php echo $myfollowInvestrow["dealperiod"]; ?></a></td>


                                                    </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
        <?php
    }
}
?>
                                            
                                            
                                            
                                          <?php
                                        if ($getSVcompanyinvrs = mysql_query($SVInvestmentsql)) {
                                            $investment_cnt = mysql_num_rows($getSVcompanyinvrs);
                                            if ($investment_cnt > 0) {
                                                ?>
                                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                        <h2> Social Venture Investments </h2>
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                                            <tbody>
                                                            <?php

                                                            $addSocialTrancheWordtxt = "";

                                                            While ($mySVInvestrow = mysql_fetch_array($getSVcompanyinvrs, MYSQL_BOTH)) {
                                                                $SVcompanyName = trim($mySVInvestrow["companyname"]);
                                                                $SVcompanyName = strtolower($SVcompanyName);
                                                                $compResult = substr_count($SVcompanyName, $searchString);
                                                                $compResult1 = substr_count($SVcompanyName, $searchString1);
                                                                if ($mySVInvestrow["AggHide"] == 1) {
                                                                    $addTrancheWordSV = "; NIA";
                                                                    $addTrancheWordSV_2 = "NIA";
                                                                    $addSocialTrancheWordtxt = $addTrancheWordSV;
                                                                } else {
                                                                    $addTrancheWordSV = "";
                                                                }
                                                                if ($mySVInvestrow["SPV"] == 1) {
                                                                    $addDebtWordSV = "; Debt";
                                                                    $addTrancheWordSV_2 = "Debt";
                                                                } else
                                                                    $addDebtWordSV = "";
                                                                ?>
                                                                    <?php
                                                                    if (($compResult == 0) && ($compResult1 == 0)) {
                                                                        ?>
                                                        <tr>
                                                            <td  >
                                                                <a href='dircomdetails.php?value=<?php echo $mySVInvestrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $mySVInvestrow["companyname"]; ?></a></td>
                <?php
            } else {
                ?>
                                                        <tr><td  >
                <?php echo ucfirst("$searchString"); ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                        <td><?php echo $mySVInvestrow["indname"]; ?></td>
                                                        <td><a href="<?php echo $dealpage; ?>?value=<?php echo $mySVInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>">
                                                    <?php echo $mySVInvestrow["dealperiod"]; ?></a></td>
                                                        <td> <?php echo $addTrancheWordSV; ?><?php echo $addDebtWordSV_2; ?></td>


                                                    </tr>
            <?php }
        ?> 
                                            </tbody>
                                        </table>
                                        <?php if($addSocialTrancheWordtxt == "; NIA"){ ?>
                                            <p class="note-nia">*NIA - Not Included for Aggregate</p>
                                        <?php }?>
                                        
                                    </div>
                                    <?php
                                }
                            }
                            if ($rsipoinvestors = mysql_query($iposql)) {
                                $ipo_cnt = mysql_num_rows($rsipoinvestors);
                            }
                            if ($ipo_cnt > 0) {
                                ?>
    <?php if ($VCFlagValue == 2) { // FOR Exits - Angel - variable names need to change  ?> 
                                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                        <h2> Exits</h2>
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                                            <tbody>
                                                <?php
                                                While ($ipmyrow = mysql_fetch_array($rsipoinvestors, MYSQL_BOTH)) {
                                                    $exitstatusdisplayforIPO = "";
                                                    $exitstatusvalueforIPO = $ipmyrow["ExitStatus"];
                                                    if ($exitstatusvalueforIPO == 0) {
                                                        $exitstatusdisplayforIPO = "Partial Exit";
                                                    } elseif ($exitstatusvalueforIPO == 1) {
                                                        $exitstatusdisplayforIPO = "Complete Exit";
                                                    }
                                                    ?>

                                                    <tr>
                                                        <td><a href='dircomdetails.php?value=<?php echo $ipmyrow["InvesteeId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $ipmyrow["companyname"]; ?></a></td>
                                                        <td><?php echo $ipmyrow["indname"]; ?></td>
                                                        <td><a href='angeldirdetails.php?value=<?php echo $ipmyrow["AngelDealId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>'><?php echo $ipmyrow["dealperiod"]; ?></a></td> 

                                                    </tr>
                                        <?php
                                    }
                                    ?>
                                            </tbody>
                                        </table>
                                    </div>   
                                <?php } else { ?>
                                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                        <h2> Exits - IPO</h2>
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th><th>Status</th></tr></thead>
                                            <tbody>
        <?php
        While ($ipmyrow = mysql_fetch_array($rsipoinvestors, MYSQL_BOTH)) {
            $exitstatusdisplayforIPO = "";
            $exitstatusvalueforIPO = $ipmyrow["ExitStatus"];
            if ($exitstatusvalueforIPO == 0) {
                $exitstatusdisplayforIPO = "Partial Exit";
            } elseif ($exitstatusvalueforIPO == 1) {
                $exitstatusdisplayforIPO = "Complete Exit";
            }
            ?>

                                                    <tr>
                                                        <td><a href='dircomdetails.php?value=<?php echo $ipmyrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $ipmyrow["companyname"]; ?></a></td>
                                                        <td><?php echo $ipmyrow["indname"]; ?></td>
                                                        <td><a href='diripodetails.php?value=<?php echo $ipmyrow["IPOId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>'><?php echo $ipmyrow["dealperiod"]; ?></a></td> 
                                                        <td><?php echo $exitstatusdisplayforIPO; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>   
                                            <?php } ?>
                                            <?php
                                        }
                                        if ($rsmandainvestors = mysql_query($mandasql)) {
                                            if ($mandamyrow1 = mysql_fetch_array($rsmandainvestors, MYSQL_BOTH)) {
                                                ?>
                                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                        <h2> Exits - M&A </h2>
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th><th>Status</th></tr></thead>
                                            <tbody>
                                                    <?php
                                                    if ($getcompanyrs = mysql_query($mandasql)) {
                                                        While ($mandamyrow = mysql_fetch_array($getcompanyrs, MYSQL_BOTH)) {
                                                            $exitstatusdisplay = "";
                                                            $exitstatusvalue = $mandamyrow["ExitStatus"];
                                                            if ($exitstatusvalue == 0) {
                                                                $exitstatusdisplay = "Partial Exit";
                                                            } elseif ($exitstatusvalue == 1) {
                                                                $exitstatusdisplay = "Complete Exit";
                                                            }
                                                            ?>

                                                        <tr>
                                                            <td><a href='dircomdetails.php?value=<?php echo $mandamyrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>' ><?php echo $mandamyrow["companyname"]; ?></a></td>
                                                            <td><?php echo $mandamyrow["indname"]; ?></td>
                                                            <td><a href='dirmandadetails.php?value=<?php echo $mandamyrow["MandAId"] . '/' . $VCFlagValue . '/' . $dealvalue; ?>'><?php echo $mandamyrow["dealperiod"]; ?></a></td> 
                                                            <td><?php echo $exitstatusdisplay; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>  
                                    <?php
                                }
                            }
                            ?>    
                                            
                                            
                                    
                                <div  class="work-masonry-thumb col-3 moreinfobox" href="http://erikjohanssonphoto.com/work/tac-3/">
                                <h2>More Info</h2>

                                <table class="tablelistview" cellpadding="0" cellspacing="0">
                                    <tr>                                                  
<?php if (trim($firm_type) != "") { ?>
                                            <td><h4>Firm Type </h4><p><?php echo $firm_type; ?></p></td>
                                            <?php
                                        }
                                        if (trim($other_location) != "") {
                                            ?>
                                            <td><h4>Other Location(s)</h4><p><?php echo $other_location; ?>&nbsp;</p></td>
                                            <?php
                                        }
                                        if (trim($preferred_stage) != "") {
                                            ?>
                                            <td><h4>Stage of funding</h4><p><?php echo $preferred_stage; ?>&nbsp;</p></td>

    <?php
}
?>
                                    </tr><tr>
<?php
if (trim($assets_mgmt) != "") {
    ?>
                                            <td><h4>Assets Under Management (US$M)</h4> <p><?php echo $assets_mgmt; ?></p></td>
                                             <!--<tr><td width=20%><b>&nbsp;Already Invested (US$ Million)</b></td><td  width=30%>&nbsp;<?php echo $already_invested; ?>&nbsp;</td></tr> -->
                                            <?php
                                        }
                                        if (trim($limited_partners) != "") {
                                            ?>
                                            <td><h4>Limited partners</h4><p><?php echo $limited_partners; ?></p></td>
    <?php
}
if (trim($strIndustry) != "") {
    ?>
                                            <td><h4>Industry  (Existing Investments)</h4><p><?php echo $strIndustry; ?></p></td>
                                            <?php
                                        }
                                        ?>
                                    </tr><tr>
                                        <?php
                                        if (trim($no_funds) != "") {
                                            ?>
                                            <td><h4>Number of Funds</h4><p><?php echo $no_funds; ?></p></td>
                                            <?php
                                        }

                                        if (trim($min_investment) != "") {
                                            ?>
                                            <td><h4>Minimum Investment Size (US$ Million)</h4><p><?php echo $min_investment; ?></p></td>
    <?php
}
if (trim($AddInfo) != "") {
    ?>
                                            <td><h4>Additional Information</h4><p><?php echo $AddInfo; ?></p></td>
                                            <?php
                                        }
                                        ?>                                                                                                   
                                    </tr><tr>
                            <?php
                            if (trim($description) != "") {
                                ?>
                                            <td colspan="3"><h4>Description</h4><p><?php echo $description; ?></p></td>
                            <?php }
                            ?>   
                                    </tr> </table>
                            </div>
                                            
                            <script type="text/javascript">
			
          
                            $(document).ready(function() {
                                          var moreinfobox =  $( ".moreinfobox" ).has( "td" ).length ;
                                          if(moreinfobox==0){
                                                $( ".moreinfobox" ).hide() ;
                                          }
                            });
                            
                            
                            </script>
                                            
                                            
<?php
While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
    $designation = $mymgmtrow["Designation"];
    if ($mymgmtrow["Designation"] == "")
        $designation = "";
    else
        $designation = $mymgmtrow["Designation"];
    ?>
                                
                                            
                                
                                            
                                            
                                            <tr>
                                    <td><h4><?php echo $designation; ?></h4> <p><?php echo $mymgmtrow["ExecutiveName"]; ?> </p></td>
                                </tr>
                                        <?php }
                                        ?>
                            
                        </div>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </section>
                            
                     
                            
                              <?php if ($angelco_invID != '') { ?>
                           
                            <section class="com-cnt-sec investor-sec mar-10"  id="angelInvestment" style="width:100%" >
                                <header>
                                    <h3 class="fl">Funding</h3>
                                    <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
                                </header>
                                <div class="com-col">
                                    <div class="fun-li-cnt">
                                    <?php
                                    if ($angelco_invID != '' && count($roles) > 0) {

                                        foreach ($roles as $f) {
                                            if ($f->role == 'past_investor') {
                                                ?>

                                                    <div class="inv-funding-li">
                                                        <img src="<?php echo $f->startup->thumb_url ?>" alt="dsg">
                                                        <div class="inv-lf-li">
                                                              <h5><a href="<?php echo $f->startup->angellist_url ?>" target="_blank"><?php echo $f->startup->name ?></a></h5>
                                                            <p><?php echo $f->startup->high_concept ?></p>
                                                <!--    <span>Founder, Managing Director</span>-->
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>




                                        <!--            <div class="inv-funding-li">
                                                        <img src="img/dsg.png" alt="dsg">
                                                        <div class="inv-lf-li">
                                                                <h5>DSG Consumer Partners</h5>
                                                            <p>Consumer focused investment company.</p>
                                                            <span>Founder, Managing Director</span>
                                                        </div>
                                                    </div>-->

                                    </div>
                                </div>
                            </section>
                              <?php } ?>
                        
                            </div>  
    
    
    
    
    
    
    
    
    
    
    
    
    
                           

                    
               </div>
        <?php
       // }
      //  }
        ?>
         
</td>


       </tr>
     
      </table>
   </div>
    <div class=""></div>


</form>

 <?php //echo $exportToExcel;
			if(!isset($_REQUEST['angelco_only']) && ($exportToExcel==1))
			{
			?>
					<span style="float:right; position: relative; right: 16px;" class="one">
                                            <input class ="export_new" type="button" id="expshowdealsbtn" value="Export" name="showdeals">
                                        </span>
                                    <script type="text/javascript">
					$('#exportbtn').html('<input class ="export_new" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                                    </script>
			<?php
			}
			?>
 <script type="text/javascript">
     
     
     $(document).ready(function() {
        var ventureInvestment =  $( "#ventureInvestment" ).has( "td" ).length ;
        if(ventureInvestment==0){ $( "#ventureInvestment" ).hide() ;   }
        
        
         var investorProfile =  $( "#investorProfile" ).has( "td" ).length ;
        if(investorProfile==0){ $( "#investorProfile" ).hide() ;   }
        
        
        var angelInvestment =  $( "#angelInvestment" ).has( "h5" ).length ;
        if(angelInvestment==0){ $( "#angelInvestment" ).hide() ;   }
        
        
     });
     
     
			
           /* $('#expshowdeals,.exlexport').click(function(){ 
                    hrefval= 'exportcompanyprofile.php';
            $("#companyDisplay").attr("action", hrefval);
            $("#companyDisplay").submit();
            return false;
            });*/
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
             
            $('#expshowdeals').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });

                $('#expshowdealsbtn').click(function(){ 
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
                                    //hrefval= 'exportinvdeals.php';
                                    //$("#pelisting").attr("action", hrefval);
                                    $("#investorDetails").submit();
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
                data: { to : $("#toaddress").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
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
</body>
</html>

<?php

function returnMonthname($mth) {
    if ($mth == 1)
        return "Jan";
    elseif ($mth == 2)
        return "Feb";
    elseif ($mth == 3)
        return "Mar";
    elseif ($mth == 4)
        return "Apr";
    elseif ($mth == 5)
        return "May";
    elseif ($mth == 6)
        return "Jun";
    elseif ($mth == 7)
        return "Jul";
    elseif ($mth == 8)
        return "Aug";
    elseif ($mth == 9)
        return "Sep";
    elseif ($mth == 10)
        return "Oct";
    elseif ($mth == 11)
        return "Nov";
    elseif ($mth == 12)
        return "Dec";
}

function writeSql_for_no_records($sqlqry, $mailid) {
    $write_filename = "pe_query_no_records.txt";
    //echo "<Br>***".$sqlqry;
    $schema_insert = "";
    //TRYING TO WRIRE IN EXCEL
    //define separator (defines columns in excel & tabs in word)
    $sep = "\t"; //tabbed character
    $cr = "\n"; //new line
    //start of printing column names as names of MySQL fields

    print("\n");
    print("\n");
    //end of printing column names
    $schema_insert .=$cr;
    $schema_insert .=$mailid . $sep;
    $schema_insert .=$sqlqry . $sep;
    $schema_insert = str_replace($sep . "$", "", $schema_insert);
    $schema_insert .= "" . "\n";

    if (file_exists($write_filename)) {
        //echo "<br>break 1--" .$file;
        $fp = fopen($write_filename, "a+"); // $fp is now the file pointer to file
        if ($fp) {//echo "<Br>-- ".$schema_insert;
            fwrite($fp, $schema_insert);    //    Write information to the file
            fclose($fp);  //    Close the file
            // echo "File saved successfully";
        } else {
            echo "Error saving file!";
        }
    }

    print "\n";
}

function highlightWords($text, $words) {

    /*     * * loop of the array of words ** */
    foreach ($words as $worde) {

        /*         * * quote the text for regex ** */
        $word = preg_quote($worde);
        /*         * * highlight the words ** */
        $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
    }
    /*     * * return the text ** */
    return $text;
}

function return_insert_get_RegionIdName($regionidd) {
    $dbregionlink = new dbInvestments();
    $getRegionIdSql = "select Region from region where RegionId=$regionidd";

    if ($rsgetInvestorId = mysql_query($getRegionIdSql)) {
        $regioncnt = mysql_num_rows($rsgetInvestorId);
        //echo "<br>Investor count-- " .$investor_cnt;

        if ($regioncnt == 1) {
            While ($myrow = mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH)) {
                $regionIdname = $myrow[0];
                //echo "<br>Insert return investor id--" .$invId;
                return $regionIdname;
            }
        }
    }
    $dbregionlink . close();
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
<style>
    .work-masonry-thumb.col-2,.work-masonry-thumb.col-3{
        width: 48%;
        float: left;
        margin:10px;
    }
    .inv-lf-li{
            width: 75%;
            min-height: 100px;
    }
    .note-nia {
        position: absolute;
        margin-top: 5px;
        font-size: 13px;
        margin-bottom: 0px;
    }
    .for-nai{
        margin-bottom: 30px;
    }
</style>
<?php
mysql_close();
    mysql_close($cnx);
    ?>