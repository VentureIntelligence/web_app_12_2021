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
        $dealpage = "dirdetails.php";
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
    ?>

<?php
	$topNav = 'Directory'; 
        include_once('directory_header1.php');      
?>
</form>
<form name="investorDetails" method="post" action="exportinvestorprofile.php">
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg"> 
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
  <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once('pedirrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
  </div>
    </div>
</td>

            <td>
                <div class="result-cnt">
                    
                    <?php if ($rsinvestors = mysql_query($sql)) { ?>
                                <input type="hidden" name="txthideinvestorId" value="<?php echo $investorId;?>" >
                                <input type="hidden" name="hidepeipomandapage" value="5" >
                                <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
                        <?php
                        if ($myrow = mysql_fetch_array($rsinvestors, MYSQL_BOTH)) {

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
                            ?>
                     <div class="list-tab"><ul>
                        <li><a class="postlink"  href="pedirview.php?value=<?php echo $strvalue[1]; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
                        <li class="active"><a id="icon-detailed-view" class="postlink" href="dirdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detailed  View</a></li> 
                        </ul></div> 
<div class="view-detailed">
                           
                          <div class="detailed-title-links"> <h2>  <?php echo $myrow["Investor"]; ?></h2>
                            <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a>
       
                    </div>             
 <div class="profilemain">
 <h2>Investor Profile</h2>
 <div class="profiletable">
  
<ul>
  <?php 
  if ($myrow["Investor"] != "") 
  { ?>                                        
        <li><h4>Investor  </h4><p> <?php echo $myrow["Investor"]; ?></p></li>
  <?php
  }
if ($Address1 != "" || $Address2 != "") 
{ ?>
   <li><h4>Address  </h4><p> <?php echo $Address1; ?><?php if ($Address2 != "") echo "<br/>" . $Address2; ?></p></li>  
   <?php
}
if ($AdCity != "") 
{ ?>
  <li><h4>City     </h4><p><?php echo $AdCity; ?></p></li>
    <?php
    }
     if (($countryname != "") && ($countryname != "--" )) 
  {
  ?>
  <li><h4>Country    </h4><p> <?php echo $countryname; ?></p></li>
   <?php
   }
  if (($Zip != "") || ($Zip > 0)) 
      { ?>
  <li><h4>Zip     </h4><p> <?php echo $Zip; ?></p></li>
   <?php
}
 if (($Tel != "") || ($Tel > 0)) {
   ?>
  <li><h4>Telephone    </h4><p><?php echo $Tel; ?></p></li>
<?php
 } $rsMgmt = mysql_query($onMgmtSql);
        if (mysql_num_rows($rsMgmt) > 0) {
     ?>
    <li><h4>Management</h4><p>

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
        </p>
            <?php
        }
if (trim($Fax) != "") {
    ?>
  <li><h4>Fax   </h4><p><?php echo $Fax; ?> </p></li> 
   <?php
    }
    if (trim($Email) != "") {
    ?>
  <li><h4>Email    </h4><p><?php echo $Email; ?> </p></li> 
   <?php
    }
if (trim($Email) != "") {
    ?>
  <li><h4>Email    </h4><p><?php echo $Email; ?> </p></li> 
   <?php
    }
    if ($yearfounded != "") {
        ?>
   <li><h4>In India Since</h4><p> <?php echo $yearfounded; ?></p></li>
    <?php
    }
if (trim($website) != "") 
  { ?>
  <li><h4>Website    </h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>
   <?php
    }
    //{
    ?>
   </ul>
 
 </div>
 </div>     
 <div class="postContainer postContent masonry-container">	
      <?php
       /* $rsMgmt = mysql_query($onMgmtSql);
        if (mysql_num_rows($rsMgmt) > 0) {
     ?>
    <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/the-rules-of-dada/">
        <h2>Management</h2>

        <table cellpadding="0" cellspacing="0" class="tablelistview">
             <?php
                While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
                    $designation = $mymgmtrow["Designation"];
                    if ($mymgmtrow["Designation"] == "")
                        $designation = "";
                    else
                        $designation =  $mymgmtrow["Designation"];
                    ?>
                        <tr>
                            <td><h4><?php echo $designation; ?></h4> <p><?php echo $mymgmtrow["ExecutiveName"]; ?> </p></td>
                        </tr>
                    <?php }
                    ?>
        </table>
    </div>

            <?php
        }*/
        ?>
  <div  class="work-masonry-thumb col-2">
  <div id="tabsholder2">
        <ul class="tabs">
            <?php                             
        
        //echo "<bR>** ".$InvestmentSql;
            if ($getcompanyinvrs = mysql_query($Investmentsql)) {
                $inv_cnt = mysql_num_rows($getcompanyinvrs);
            }
            if ($inv_cnt > 0) {
            ?>

           <li id="tabz1">PE/VC Investments</li>
            <?php
            }
             if ($getIFcompanyinvrs = mysql_query($IFInvestmentsql))
            {
            $investmentIf_cnt = mysql_num_rows($getIFcompanyinvrs);
            }
            if($investmentIf_cnt > 0 )
            {
           ?>
            <li id="tabzinfrascruture">Infrastructure</li>
             <?php
            }
             
            if ($getCTcompanyinvrs = mysql_query($CTInvestmentsql))
            {
                $investmentct_cnt = mysql_num_rows($getCTcompanyinvrs);
            }    
            if($investmentct_cnt > 0 )
            {
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
                 While ($myInvestrow = mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH)) {
                $companyName = trim($myInvestrow["companyname"]);
                $companyName = strtolower($companyName);
                $compResult = substr_count($companyName, $searchString);
                $compResult1 = substr_count($companyName, $searchString1);
                if ($myInvestrow["AggHide"] == 1)
                    $addTrancheWord = "; Tranche";
                else
                    $addTrancheWord = "";
                if (($compResult == 0) && ($compResult1 == 0)) {
                    ?>
                    <tr><td style="alt">
                            <a href='dircomdetails.php?value=<?php echo $myInvestrow["PECompanyId"].'/'.$VCFlagValue.'/'; ?>' ><?php echo $myInvestrow["companyname"]; ?></a></td>
                    <?php
                } else {
                    ?>
                    <tr><td >
                    <?php echo ucfirst("$searchString"); ?></td>
                    <?php
                }
                ?>
                    <td><?php echo $myInvestrow["indname"]; ?></td><td><a href="<?php echo $dealpage; ?>?value=<?php echo $myInvestrow["PEId"].'/'.$VCFlagValue.'/'; ?>">
                <?php echo $myInvestrow["dealperiod"]; ?></a><?php echo $addTrancheWord; ?></td>


                </tr>
                <?php
            }
              ?>
               
            </tbody>
        </table></div>
             <?php
             }
              if($investmentIf_cnt > 0 )
              {
           ?>
            <div id="contentzinfrascruture" class="tabscontent"> 
            <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                <tbody>
                <?php 
                While($myIFInvestrow=mysql_fetch_array($getIFcompanyinvrs, MYSQL_BOTH))
                {
                $IFcompanyName=trim($myIFInvestrow["companyname"]);
                $IFcompanyName=strtolower($IFcompanyName);
                $compResultaa=substr_count($IFcompanyName,$searchString);
                $compResult1bb=substr_count($IFcompanyName,$searchString1);
                        ?>

                                     <?php
                if(($compResultaa==0) && ($compResult1bb==0))
                {
                ?>
                        <tr><td style="alt">
                        <a href='dircomdetails.php?value=<?php echo $myIFInvestrow["PECompanyId"].'/'.$VCFlagValue.'/'; ?>' ><?php echo $myIFInvestrow["companyname"]; ?></a></td>
                <?php
                }
                else
                {
                ?>
                        <tr><td style="alt">
                        <?php echo ucfirst("$searchString") ;?></td>
                <?php
                }
                ?>
                        <td><?php echo $myIFInvestrow["indname"];?></td><td><a href="<?php echo $dealpage;?>?value=<?php echo $myIFInvestrow["PEId"];?>">
                        <?php echo $myIFInvestrow["dealperiod"];?> </a></td>


                        </tr>
                <?php
                } ?>  

                </tbody>
            </table> </div>
             <?php
             }
              if($investmentct_cnt > 0 )
            {
            ?>                                       
            <div id="contentzcleantech" class="tabscontent"> 
            <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
                <tbody>

                <?php 
                While($myCTInvestrow=mysql_fetch_array($getCTcompanyinvrs, MYSQL_BOTH))
                {
                $CTcompanyName=trim($myCTInvestrow["companyname"]);
                $CTcompanyName=strtolower($CTcompanyName);
                $compResulta=substr_count($CTcompanyName,$searchString);
                $compResult1b=substr_count($CTcompanyName,$searchString1);

                ?>
                <?php
                if(($compResulta==0) && ($compResult1b==0))
                {
                ?>
                <tr><td style="alt">
                <a href='dircomdetails.php?value=<?php echo $myCTInvestrow["PECompanyId"].'/'.$VCFlagValue.'/'; ?>' ><?php echo $myCTInvestrow["companyname"]; ?></a></td>
                <?php
                }
                else
                {
                ?>
                <tr><td style="alt">
                <?php echo ucfirst("$searchString") ;?></td>
                <?php
                }
                ?>
                <td><?php echo $myCTInvestrow["indname"];?></td>
                <td><a href="<?php echo $dealpage;?>?value=<?php echo $myCTInvestrow["PEId"];?>">
                <?php echo $myCTInvestrow["dealperiod"];?> </a></td>


                </tr>
                <?php
                } ?>                                                                                                                       
                </tbody>
                </table></div>
               <?php
             }
            ?>
             
        </div>
    </div>                                                          
 </div>
      <?php
        if ($getSVcompanyinvrs = mysql_query($SVInvestmentsql))
        {
          $investment_cnt = mysql_num_rows($getSVcompanyinvrs);
          if($investment_cnt > 0 )
          {
       ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
        <h2> Social Venture Investments </h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th></tr></thead>
        <tbody>
             <?php 
                While($mySVInvestrow=mysql_fetch_array($getSVcompanyinvrs, MYSQL_BOTH))
                 {
                $SVcompanyName=trim($mySVInvestrow["companyname"]);
                $SVcompanyName=strtolower($SVcompanyName);
                $compResult=substr_count($SVcompanyName,$searchString);
                $compResult1=substr_count($SVcompanyName,$searchString1);
                if($mySVInvestrow["AggHide"]==1)
                {
                      $addTrancheWordSV="; Tranche";
                      $addTrancheWordSV_2="Tranche";
                }
                else
                {
                 $addTrancheWordSV="";
                }
                if($mySVInvestrow["SPV"]==1)
                {
                      $addDebtWordSV="; Debt";
                       $addTrancheWordSV_2="Debt";
                }
                else
                    $addDebtWordSV="";

                        ?>
                                     <?php
                if(($compResult==0) && ($compResult1==0))
                {
                ?>
                        <tr>
                        <td  >
                        <a href='dircomdetails.php?value=<?php echo $mySVInvestrow["PECompanyId"].'/'.$VCFlagValue.'/'; ?>' ><?php echo $mySVInvestrow["companyname"]; ?></a></td>
                <?php
                }
                else
                {
                ?>
                        <tr><td  >
                        <?php echo ucfirst("$searchString") ;?></td>
                <?php
                }
                ?>
                        <td><?php echo $mySVInvestrow["indname"];?></td>
                        <td><a href="<?php echo $dealpage;?>?value=<?php echo $mySVInvestrow["PEId"];?>">
                        <?php echo $mySVInvestrow["dealperiod"];?></a></td>
                           <td> <?php echo $addTrancheWordSV;?><?php echo $addDebtWordSV_2;?></td>


                        </tr>
                <?php
                } ?> 
        </tbody>
        </table>
        </div>
     <?php
          }
        }
        if($rsipoinvestors= mysql_query($iposql))
        {
             $ipo_cnt = mysql_num_rows($rsipoinvestors);
        }
        if($ipo_cnt>0)
        {
      ?>
      <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
        <h2> Exits - IPO</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th><th>Status</th></tr></thead>
        <tbody>
        <?php
            While($ipmyrow=mysql_fetch_array($rsipoinvestors, MYSQL_BOTH))
           {
                 $exitstatusdisplayforIPO="";
                 $exitstatusvalueforIPO=$ipmyrow["ExitStatus"];
                 if($exitstatusvalueforIPO==0)
                 {$exitstatusdisplayforIPO="Partial Exit";}
                 elseif($exitstatusvalueforIPO==1)
                 {  $exitstatusdisplayforIPO="Complete Exit";}
           ?>

                           <tr>
                               <td><a href='dircomdetails.php?value=<?php echo $ipmyrow["PECompanyId"].'/'.$VCFlagValue.'/'; ?>' ><?php echo $ipmyrow["companyname"]; ?></a></td>
                               <td><?php echo $ipmyrow["indname"];?></td>
                               <td><a href='ipodealdetails.php?value=<?php echo $ipmyrow["IPOId"];?>'><?php echo $ipmyrow["dealperiod"];?></a></td> 
                               <td><?php echo $exitstatusdisplayforIPO;?></td>
                           </tr>
               <?php
           }
         ?>
        </tbody>
        </table>
        </div>   
     <?php
        }
        if($rsmandainvestors =mysql_query($mandasql))
        {
            if($mandamyrow1=mysql_fetch_array($rsmandainvestors,MYSQL_BOTH))
            {
   ?>
     <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
        <h2> Exits - M&A </h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Company Name</th><th>Industry Name</th><th>Deal Period</th><th>Status</th></tr></thead>
        <tbody>
        <?php
           if ($getcompanyrs = mysql_query($mandasql))
            {
                While($mandamyrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                {
                  $exitstatusdisplay="";
                  $exitstatusvalue=$mandamyrow["ExitStatus"];
                  if($exitstatusvalue==0)
                  {$exitstatusdisplay="Partial Exit";}
                  elseif($exitstatusvalue==1)
                  {  $exitstatusdisplay="Complete Exit";}
            ?>

                            <tr>
                                <td><a href='dircomdetails.php?value=<?php echo $mandamyrow["PECompanyId"].'/'.$VCFlagValue.'/'; ?>' ><?php echo $mandamyrow["companyname"]; ?></a></td>
                                <td><?php echo $mandamyrow["indname"];?></td>
                                <td><a href='mandadealdetails.php?value=<?php echo $mandamyrow["MandAId"];?>'><?php echo $mandamyrow["dealperiod"];?></a></td> 
                                <td><?php echo $exitstatusdisplay;?></td>
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
                                                                
<div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/tac-3/">
      <h2>More Info</h2>
                                                               
          <table class="tablelistview" cellpadding="0" cellspacing="0">
            <tr>                                                  
                <?php if (trim($firm_type) != "") { ?>
                <td><h4>Firm Type </h4><p><?php echo $firm_type; ?></p></td>
                <?php
                }
                if (trim($other_location) != "") {
                ?>
                 <td><h4>Other Location</h4>Other Location(s)<p><?php echo $other_location; ?>&nbsp;</p></td>
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
               <td><h4>Assets Under Management(US$M)</h4> <p><?php echo $assets_mgmt; ?></p></td>
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
                if(trim($description)!="") 
                {
                ?>
                <td colspan="3"><h4>Description</h4><p><?php echo $description; ?></p></td>
                <?php }
                ?>   
            </tr> </table>
 </div>												 
			</div>            
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
               </div>
        <?php
        }
        }
        ?>
          </td>


       </tr>
     
      </table>
   </div>
    <div class=""></div>


</form>
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
<?php
mysql_close();
    mysql_close($cnx);
    ?>