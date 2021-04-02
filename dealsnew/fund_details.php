<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('checklogin.php');
        $mailurl= curPageURL();
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
            $dealuv=$strvalue[2];
            $ddvalue=$strvalue[3];
        }
        else
        {
            $vcflagValue=0;
            $VCFlagValue=0;
        }

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
        
         $investorId = $strvalue[0];
    $pe_re = 1;
    if ($pe_re == 1) {
        $industryvalue = "!=15";
        $dealpage = "dealdetails.php";
    } elseif ($pe_re == 2) {
        $industryvalue = "=15";
        $dealpage = "redealinfo.php";
    }

    $exportToExcel = 0;
    $TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
    //echo "<br>---" .$TrialSql;
    if ($trialrs = mysql_query($TrialSql)) {
        while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
            $exportToExcel = $trialrow["TrialLogin"];
        }
    }

    //$sql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
    //		c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,inv.*
    //		from peinvestments_investors as peinv_inv,peinvestors as inv,
    //		peinvestments as peinv,pecompanies as c
    //		where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
    //		and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId order by peinv.dates desc";

    $sql = "select * from peinvestors where InvestorId=$investorId";

    $iposql = "select peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,
				c.companyname,c.industry,i.industry as indname,DATE_FORMAT( peinv.IPODate, '%b-%Y' ) as dealperiod,peinv.ExitStatus,inv.*
				from ipo_investors as peinv_inv,peinvestors as inv,
				ipos as peinv,pecompanies as c,industry as i
				where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId and peinv.Deleted=0 and i.industryid=c.industry
				and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId and c.industry $industryvalue";
    //   echo"<bR>---" .$iposql;
   /* $mandasql = "select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
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
    
    
    */
    
        $month1=($_REQUEST['month1'] || ($_REQUEST['month1']!="")) ?  $_REQUEST['month1'] : date('n');
        $year1 = ($_REQUEST['year1'] || ($_REQUEST['year1']!="")) ?  $_REQUEST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
        $month2=($_REQUEST['month2'] || ($_REQUEST['month2']!="")) ?  $_REQUEST['month2'] : date('n');
        $year2 = ($_REQUEST['year2'] || ($_REQUEST['year2']!="")) ?  $_REQUEST['year2'] : date('Y');
    ?>

<?php
  if($dealuv == 0)
  {
	$topNav = 'Deals'; 
       if($VCFlagValue >= 3 && $VCFlagValue <= 5)
       {
           
       include_once('tvheader_search.php');
       }  
       elseif($VCFlagValue=='funds'){
           $topNav = 'Funds'; 
           include_once('fundheader_search.php');
       }
       else{
           include_once('tvindex_search.php');
       }
  }
  else
  {
      $topNav = 'Directory'; 
        include_once('directory_header1.php');  
  }
?>  



<!-- -->

 <?php
                $fundid = $strvalue[3]; 
                
                $fu_de2 = mysql_fetch_array( mysql_query("SELECT id,moreInfo FROM fundRaisingDetails  WHERE id='$fundid' ")) ; 
                        
                    $fu_de = mysql_fetch_array( mysql_query("SELECT * FROM fundRaisingDetails  fd 
                    LEFT JOIN fundNames fn ON fd.fundName = fn.fundId 
                    LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                    LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                    LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                    LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                    LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                   
                    WHERE fd.id='$fundid' ")) ;
                 
                            
                    function fun_ty($futyid)       {
                     $e = mysql_fetch_array( mysql_query("SELECT * FROM fundType WHERE id='$futyid' "));
                        return $e['fundTypeName'];                
                    }

                     function cap_sor($cap_sor)             {
                        $e = mysql_fetch_array( mysql_query("SELECT * FROM fundCapitalSource WHERE id='$cap_sor' "));
                           return $e['source'];                 
                    }
     ?>


<!-- -->

<div id="container" class="details-cont" >
    
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php 
if($dealuv == 0)
{
    if($VCFlagValue>=3 && $VCFlagValue<=5)
    {
    include_once('svrefine.php');
    }
    elseif($VCFlagValue=='funds'){
        
        $sqltype = "select * from fundType where focus='Stage'  AND dbtype='PE' "; 
        $sqltype2 = "select * from fundType where focus='Industry'";
        $sqlfundstatus = "select * from fundRaisingStatus";
        $sqlfundClosed = "select * from fundCloseStatus";
        $sqlcapitalsrc = "select * from fundCapitalSource";
        include_once('funds_refine.php');
    }
    else{
        include_once('refine.php');
    }
  }
  else
  {
       
      include_once('pedirrefine.php');
      }
?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
    </div>
</td>


            <td class="profile-view-left" style="width:100%;">
                <div class="result-cnt funds-tab">
                    <!--div class="result-title">
                       <div class="title-links " id="exportbtn"></div>
                       <br><br/->
                    </div-->
                    <div class="title-links">
                                
                            <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                             <?php 

                            if(($exportToExcel==1))
                                 {
                                 ?>
                                     <span id="exportbtn">  <a class="export" id="expshowdeals" name="showdeals">Export</a></span>
                                 <?php
                                 }
                             ?>
                    </div>
                    <?php // if ($rsinvestors = mysql_query($sql)) { ?>
                                
                        <?php
                       /* if ($myrow = mysql_fetch_array($rsinvestors, MYSQL_BOTH)) {

                            $Address1 = $myrow["Address1"];
                            $Address2 = $myrow["Address2"];
                            $AdCity = $myrow["City"];
                            $Zip = $myrow["Zip"];
                            $Tel = $myrow["Telephone"];
                            $Fax = $myrow["Fax"];
                            $Email = $myrow["Email"];
                            $website = $myrow["website"];
                            $description = $myrow["Description"];
                            $yearfounded = $myrow["yearfounded"];
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
                            $AddInfo = $myrow["AdditionalInfor"];
                            $comment = $myrow["comment"];
                            $txtcountryid = $myrow["countryid"];
                            $countrysql = "select country from country where countryid='$txtcountryid'";
                            if ($rscountry = mysql_query($countrysql)) {
                                While ($mycountryrow = mysql_fetch_array($rscountry, MYSQL_BOTH)) {
                                    $countryname = $mycountryrow["country"];
                                }
                            }
                            $google_sitesearch = "https://www.google.co.in/search?q=" . $myrow["Investor"] . "+site%3Alinkedin.com";
                            $investorurl=  urlencode($myrow["Investor"]);
                            $investor_newssearch="https://www.google.co.in/search?q=".$investorurl."+site:ventureintelligence.com/ddw/";
                           */
                        ?>
                     <div class="list-tab mt-list-tab-directory"><ul>
<!--                        <li><a class="postlink"  href="angelindex.php?value=<?php echo $strvalue[1]; ?>"  id="icon-grid-view"><i></i> List  View</a></li>-->
                        
                                <li ><a id="icon-grid-view"  class="postlink" href="funds.php" ><i></i>List View</a></li> 
                        
                            <!--li class="active"><a id="icon-detailed-view" class="postlink" href="fund.php?value=<?php echo $investorId;?>" ><i></i>List View</a></li>--> 
                              
                                <!-- dealdetails.php?value=<?php echo $ddvalue."/".$vcflagValue;?> // --> 
                             <li class="active"><a id="icon-detailed-view" class="postlink" href="javascript::" ><i></i> Detail View</a></li>
                            
                       
                       
                        </ul></div> 
   <div class="lb" id="popup-box">
    <div class="title">Send this to your Colleague</div>
    
        <div class="entry">
                <label> To</label>
                <input type="text" name="toaddress" id="toaddress"  />
        </div>
        <div class="entry">
                <h5>Subject</h5>
                <p>Checkout this deal- <?php  if($fu_de["fundName"]){ echo $fu_de["fundName"];} else { echo $fu_de["fundManager"]; } ?>  - in Venture Intelligence</p>
                <input type="hidden" name="subject" id="subject" value="Checkout this deal-  <?php  if($fu_de["fundName"]){ echo $fu_de["fundName"];} else { echo $fu_de["fundManager"]; } ?>  - in Venture Intelligence"  />
        </div>
        <div class="entry">
                <h5>Message</h5>
                <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
        </div>
        <div class="entry">
            <input type="button" value="Submit" id="mailbtn" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

</div>                 
<div class="view-detailed">
    
   
                           
<div class="detailed-title-links"> <h2>  <?php  if($fu_de["fundName"]){ echo $fu_de["fundName"];} else { echo $fu_de["fundManager"]; } ?></h2>
    
    <?php if( ! isset($strvalue[4]) ) { ?>
     <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a> 
    <?php } ?>
    
    
    <?php if( isset($strvalue[4]) ) { ?>
        <?php
                $nav = $strvalue[4];
                $nav_next = $nav+1;
                $nav_previous = $nav-1;
        ?>
     
    <?php if( $_SESSION['totresu'] != $strvalue[4] && $_SESSION['totresu'] > $strvalue[4] && $strvalue[4]>1) { ?> 
     <a  class="postlink" id="previous" href="fund_details.php?value=<?php echo $_SESSION['fundfirsttolast'][$nav_previous]; ?>">< Previous</a> <?php } ?>
   
     <?php if( $_SESSION['totresu'] == $strvalue[4]) { ?> 
     <a  class="postlink" id="previous" href="fund_details.php?value=<?php echo $_SESSION['fundfirsttolast'][$nav_previous]; ?>">< Previous</a> <?php } ?>
    
    <?php if( $_SESSION['totresu']>1 && $_SESSION['totresu'] > $strvalue[4]) { ?>  <a  class="postlink" id="next" href="fund_details.php?value=<?php echo $_SESSION['fundfirsttolast'][$nav_next]; ?>">Next ></a> <?php } ?>
    <?php } ?>
    
    
    
       <?php// echo $_SESSION['fundfirsttolast']; ?>
</div>
    
     <div class="profilemain">
         <div class="profiletable" >
              <h2>Fund Details </h2>
         
         
              
            <ul>
            
                           
                
            <?php if ($fu_de["fundName"] != "") { ?> <li><h4>fund Name  </h4><p> <?php echo $fu_de["fundName"]; ?></p></li> <?php  } ?>
            <?php if ($fu_de["fundManager"] != "") { ?> <li><h4>fund Manager  </h4><p> <?php echo $fu_de["fundManager"]; ?></p></li> <?php  } ?>
           
            <?php if(fun_ty($fu_de["fundTypeStage"])!= NULL || fun_ty($fu_de["fundTypeIndustry"])!=NULL ) { ?>
            <li> <h4>fund type  </h4><p>   <?php 
            if(fun_ty($fu_de["fundTypeStage"])) { echo "<span style='background: #E5E1D5;padding: 2px 7px;margin-right: 5px;'>".fun_ty($fu_de["fundTypeStage"])."</span>";} 
            if(fun_ty($fu_de["fundTypeIndustry"])) { echo fun_ty($fu_de["fundTypeIndustry"]);}  ?> </p></li> 
            <?php } ?>
            
            
            <li><h4> Target Size  </h4><p> <?php echo ($fu_de["size"]!=0) ? $fu_de["size"] : "-";?> </p></li>

            <?php
            if( $fu_de["amount_raised"] != 0 || !empty( $fu_de["amount_raised"] ) ) {
            ?>
            <li><h4> Amount raised  </h4><p> <?php echo ($fu_de["amount_raised"]!=0) ? $fu_de["amount_raised"] : "-";?> </p></li> 
            <?php
            }
            ?> 
           
          <li> <h4>fund Status  </h4><p>   <?php echo ($fu_de["fundStatus"]=="Closed") ? $fu_de["closeStatus"] : $fu_de["fundStatus"];?></p></li>  
          <?php if ( cap_sor($fu_de["capitalSource"]) != "") { ?> <li><h4>Capital Source  </h4><p> <?php echo cap_sor($fu_de["capitalSource"]); ?></p></li> <?php  } ?>
         
         <?php if ($fu_de["fundDate"] != "") { ?> <li><h4>Date  </h4><p> <?php echo $newDate = date("M-Y", strtotime($fu_de["fundDate"]));  ?></p></li> <?php  } ?>
         <?php if ($fu_de["launchDate"] != "") { ?> <li><h4>Launch Date  </h4><p> <?php echo $newDate = date("M-Y", strtotime($fu_de["launchDate"]));  ?></p></li> <?php  } ?>

                
          </ul>
              
              
              
         </div>
         
      
     </div>
    
  <div style="width:80%; margin: 1% 0 2% 0;overflow: hidden;">
           
           
      <?php  if ($strvalue[0] > 0) { ?>
             <div style='width:26%; float:left;'>                
               
                 <div class="profilemain" >
                  <h2>Investor Info</h2>
                   
                   <table cellpadding="0" cellspacing="0" class="tablelistview" style='background: #fff'>
                    <tbody>
                    <tr><td>
                            <?php
                            $investordetail = mysql_fetch_array(mysql_query (" SELECT InvestorId,Investor FROM peinvestors WHERE InvestorId='$fu_de[investorId]' ") );
                            ?>
                            <?php 
                              if ($fu_de["hideaggregate"] == 1) {
                                  $openBracket = "(";
                                  $closeBracket = ")";
                              } else {
                                  $openBracket = "";
                                  $closeBracket = "";
                              }
                            ?>
                            <!-- <p><a class="" target="_blank" href="dirdetails.php?value=<?php echo $fu_de['investorId'] ?>/0/101"><?php echo  $investordetail['Investor']?></a><br> </p> -->
                            <p><?php echo $openBracket; ?><a class="" target="_blank" href="dirdetails.php?value=<?php echo $fu_de['investorId'] ?>/0/101"><?php echo  $investordetail['Investor']?></a> <?php echo $closeBracket; ?><br> </p>
<!--                      </td>  <td><h4>Investor Type</h4><p>Co-Investment</p></td>       -->
                             </tr>
     
                    </tbody>
                    </table>  
                  </div>               
                 
                 
                 </div>
            <?php } ?>  
      
      
            <?php if($fu_de2["moreInfo"]) {?>    
             <div style='width:35%; margin-left: 2%; float:left;'>
                 <div class="profilemain" >
                  <h2>More info</h2>
                  <p style="padding:2%"><?php echo $fu_de2["moreInfo"];?> </p>
                  </div>
                 </div>
             <?php } ?>
      
      
             <?php if($fu_de["source"]) {?> 
             <div style='width:35%; margin-left: 2%; float:left;'>
                 <div class="profilemain" > 
                     <h2>source</h2>
                  <p style="padding:2%">
                         <a href="<?php echo $fu_de["source"];?>" target="_blank"><?php echo $fu_de["source"];?></a> 
                       
                  </p>
                  </div>
             </div>
             <?php } ?>
    </div> 
    
     
    
    
      </div>
        <?php
        // }
        // }
        ?>
          </td>
       </tr>
      </table>
   </div>
</form>
<form name="investorDetails" id="investorDetails" method="post" action="exportinvestorprofile.php">
    <input type="hidden" name="txthideinvestorId" value="<?php echo $strvalue[0];?>" >
    <input type="hidden" name="hidepeipomandapage" value="5" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    <div class=""></div>
       <?php
        if(($exportToExcel==1))
        {
        ?>
<!--                        <span style="float:right" class="one">
                            <input class ="export" type="submit" id="expshowdealsbtn"  value="Export" name="showdeals">
                        </span>
                    <script type="text/javascript">
                        $('#exportbtn').html('<input class ="export exlexport" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                    </script>-->
        <?php
        }
        ?>
</form>


 <form name="funddetails" id="funddetails"  method="post" action="ajax_funddetails_export.php">
        <input type="hidden" name="fundid" value="<?php echo $fundid ?>">
    </form> 

 <script type="text/javascript">
			
           /* $('#expshowdeals,.exlexport').click(function(){ 
                    hrefval= 'exportinvestorprofile.php';
            $("#investorDetails").attr("action", hrefval);
            $("#investorDetails").submit();
            return false;
            });*/
    
                $('#expshowdeals').click(function(){ 
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });

                $('#expshowdealsbtn').click(function(){ 
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
                                   // alert('test');
                                    hrefval= 'ajax_funddetails_export.php';
                                    $("#funddetails").attr("action", hrefval);
                                    $("#funddetails").submit();
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
                data: { to : $("#toaddress").val(),subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
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


<script type="text/javascript">
		
                $("a.postlink").live('click',function(){
                  
                    $('<input>').attr({
                    type: 'hidden',
                    id: 'foo',
                    name: 'searchallfield',
                    value:'<?php echo $searchallfield; ?>'
                    }).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                              
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
</script> 
