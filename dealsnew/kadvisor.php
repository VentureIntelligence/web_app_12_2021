<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        include('checklogin.php');
        $companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
        
                $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
		$AdvisorString = explode("/", $value);
                
                //format is  PE - pe/vc , manda - pe/vc , SV - 1(as of now)
		$SelCompRef=$AdvisorString[0];
		$pe_exit_advisorflag=$AdvisorString[1];
		$pe_vc_flag=$AdvisorString[2];
                $vcflagValue=$AdvisorString[2];

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
		$exportToExcel1=0;
                $TrialSql1="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,malogin_members as dm
                where dm.EmailId='$maemailid' and dc.DCompId=dm.DCompId";
                //echo "<br>---" .$TrialSql;
                if($trialrs1=mysql_query($TrialSql1))
                {
                        while($trialrow1=mysql_fetch_array($trialrs1,MYSQL_BOTH))
                        {
                                $exportToExcel1=$trialrow1["TrialLogin"];
                        }
                }

					$AdvisorSql="select Cianame from advisor_cias where CIAId=$SelCompRef";

				if($pe_exit_advisorflag==1)
				{
                                  //   echo "<br>Inside PE";
				//	$dealpage="dealinfo.php";
                                        $dealpage="dealdeatails.php";
                                        $headerurl="tvheader_search.php";
					if($pe_vc_flag==0)
                                        {       
                                                
						$addVCFlagqry="";
						$pagetitle="PE Advisors";
					}
					elseif($pe_vc_flag==1)
					{
                                            
						$addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
						$pagetitle="VC Advisors";
					}
                                        $tdtitle =" Investors";

				 $advisor_to_companysql="
					SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt,peinv.PEId as PEId
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates";
                                        

					$advisor_to_investorsql="
					SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates";

				}
	//echo "<br>********----company".$advisor_to_companysql;
	//echo "<br>*******-----Investor".$advisor_to_investorsql;

				if($pe_exit_advisorflag==2)
				{
                                     //  echo "<br>Inside M&A";
				//	$dealpage="mandadealinfo.php";
                                        $dealpage="mandadealdetails.php";
                                        $headerurl="mandaheader_search.php";
					if($pe_vc_flag==0)
					{
						$addVCFlagqry="";
						$pagetitle="M&A Exits - PE Advisors";
					}
					elseif($pe_vc_flag==1)
					{
						$addVCFlagqry = "and VCFlag=1 ";
						$pagetitle="M&A Exits -  VC Advisors";
					}
					$tdtitle =" Acquirer";
					 $advisor_to_companysql="
					SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MandAId as PEId
					FROM manda AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac
					WHERE peinv.Deleted=0 " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by Cianame";

					$advisor_to_investorsql="
					SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MandaId  as PEId ,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisoracquirer AS adac
					WHERE peinv.Deleted=0 ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by dt";
                        	}
                        	
                        	if($pe_exit_advisorflag==3)
				{
                                     //   echo "<br>Inside SV";
                                         //SV investments
					//$dealpage="dealinfo.php";
                                        $headerurl="tvheader_search.php";
                                        $dealpage="dealdetails.php";
					//echo "<bR>&&&&&".$pe_vc_flag;
					if($pe_vc_flag==3)
					{
						$addVCFlagqry="";
						$pagetitle="SV Advisors";
						$dbtype="SV";
                                          // echo "<bR>$$$".$pe_vc_flag;
					}
					if($pe_vc_flag==4)
					{
						$addVCFlagqry="";
						$pagetitle="CT Advisors";
						$dbtype="CT";
                                          // echo "<bR>$$$".$pe_vc_flag;
					}
					if($pe_vc_flag==5)
					{
						$addVCFlagqry="";
						$pagetitle="IF Advisors";
						$dbtype="IF";
                                          // echo "<bR>$$$".$pe_vc_flag;
					}
					//elseif($pe_vc_flag==1)
					//{
					//	$addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
					//	$pagetitle="VC Advisors";
					//}
				       $tdtitle =" Investors";

					$advisor_to_companysql="
					SELECT  distinct peinv.PEId as PEId,adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 
                                        
                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        )
                                        order by dates desc";

					$advisor_to_investorsql="
					SELECT distinct peinv.PEId as PEId, peinv.PECompanyId,adac.CIAId AS AcqCIAId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 

                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        )
                                        order by peinv.dates desc";


                                        //echo "<br>********company".$advisor_to_companysql;
                                       // echo "<br>*******Investor".$advisor_to_investorsql;
				}
                                if($pe_exit_advisorflag==4)
				{
                                      // echo "<br>Inside MAMA";
					$dealpage="meracqdetail.php";
					 $headerurl="tvheader_search.php";
                                         $dealpage="dealdetails.php";
					if($pe_vc_flag==1)
					{
						$addVCFlagqry="";
						$pagetitle="M&A Advisors";
					}

					$tdtitle =" Acquirer";
					$advisor_to_companysql="
					SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId as PEId
					FROM mama AS peinv, pecompanies AS c,  advisor_cias AS cia,
					mama_advisorcompanies AS adac
					WHERE peinv.Deleted=0 " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$SelCompRef order by DealDate";

					$advisor_to_investorsql="
					SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MAMAId  as PEId ,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia,
					mama_advisoracquirer AS adac
					WHERE peinv.Deleted=0 ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$SelCompRef order by DealDate";
				
                        	}

?>



<?php 

$invcompaniessql="(SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt,peinv.PEId as PEId
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates) 
                   UNION
                   (SELECT  distinct peinv.PEId as PEId,adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 
                                        
                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        )
                                        order by dates desc)";


$existcompaniessql= "SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MandAId as PEId
					FROM manda AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac
					WHERE peinv.Deleted=0 " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by Cianame";


$invadvisor_to_investorsql="(SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates) 
                              UNION (
					SELECT distinct peinv.PEId as PEId, peinv.PECompanyId,adac.CIAId AS AcqCIAId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 

                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        )
                                        order by peinv.dates desc)";

        $existadvisor_to_investorsql="  SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MandaId  as PEId ,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisoracquirer AS adac
					WHERE peinv.Deleted=0 ".
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by dt"

?>


<?php
	$topNav = 'Deals';
        
	include_once($headerurl);
?>
</form>
<form name=advisorprofile method="post" action="exportadvisor.php">
<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
 <?php

  	if($advisorrs=mysql_query($AdvisorSql))
		{
			while($advisorrow=mysql_fetch_array($advisorrs,MYSQL_BOTH))
			{
				$advisorname=$advisorrow["Cianame"];
			}
        
	?>
		<input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >

		<input type="hidden" name="hidepeexitflag" value="<?php echo $pe_exit_advisorflag;?>" >
		<input type="hidden" name="hidevcflagValue" value="<?php echo $pe_vc_flag;?>" >

		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >

		
<td>

<div class="result-cnt">

  
    <div class="result-title">
                    <div class="title-links " id="exportbtn"></div>                   
    </div>
    
    
<!--div class="result-title"><h2>794 results for</h2> <ul><li>PE Investments <!--<a href="#"><img src="images/icon-close.png" width="9" height="8" border="0"/>--></a></li> <!--<li>Industry: All <a href="#"><img src="images/icon-close.png" width="9" height="8" border="0" /></a></li> <li>Sector: All <a href="#"><img src="images/icon-close.png" width="9" height="8" border="0" /></a></li> <li>Last 2 Months <a href="#"><img src="images/icon-close.png" width="9" height="8" border="0" /></a></li>> </ul> <h2> No. of Deals - 32     Value (US$ M) - 456</h2>

<div class="alert-note">Note: Target/Company in () indicates tranche rather than a new round. Target/Company in indicates a debt investment. Not included in aggregate data.</div></div-->



 

<div class="list-tab"><ul>
         <?php  
         if($AdvisorString[1]==2) 
            {
             ?>
        <li><a class="postlink"  href="angelindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
        <?php
        }
        else if($AdvisorString[1]==0 || $AdvisorString[1]==1) 
     {
     ?>
        <li><a class="postlink"  href="index.php"  id="icon-grid-view"><i></i> List  View</a></li>
        <?php
    }
    else if($AdvisorString[1]==3 || $AdvisorString[1]==4 || $AdvisorString[1]==5 )
    {
    ?>
        <li><a class="postlink"  href="svindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
        <?php
        }
        ?>
        <li class="active"><a id="icon-detailed-view" class="postlink" href="" ><i></i> Detail  View</a></li> 
        </ul></div> 


 <div class="view-detailed">
    <div class="detailed-title-links"><h2><?php echo rtrim($advisorname);?></h2></div>
    <div class="postContainer postContent masonry-container">
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor in Investments</h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
        <tr>
           <td><p>
                    <?php
				if ($getcompanyrs = mysql_query($invcompaniessql))
                                {
                                        $AddOtherAtLast="";
                                        $AddUnknowUndisclosedAtLast="";
                                        While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                {
                                        //$AddOtherAtLast="";
                                        $companyname=trim($myInvrow["Companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($pe_exit_advisorflag==4)
                                            {
                                              ?>
                                            <?php echo $myInvrow["Companyname"]; ?>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                            <a href='companydetails.php?value=<?php echo $myInvrow["PECompanyId"];?>' ><?php echo $myInvrow["Companyname"]; ?></a>
                                            <?php
                                            }
                                            ?>
                                            ( <a href="<?php echo $dealpage;?>?value=<?php echo $myInvrow["PEId"];?>">
                                                            <?php echo $myInvrow["dt"];?> </a>)
                                                            <BR/>
                                        <?php
                                        }
                                        else
                                                {
                                                        $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
               </p>
                </td>
            </tr>
       </tbody>
       </table>
        </div>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor in Exists</h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
        <tr>
           <td><p>
                    <?php
				if ($getcompanyrs = mysql_query($existcompaniessql))
                                {
                                        $AddOtherAtLast="";
                                        $AddUnknowUndisclosedAtLast="";
                                        While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                {
                                        //$AddOtherAtLast="";
                                        $companyname=trim($myInvrow["Companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($pe_exit_advisorflag==4)
                                            {
                                              ?>
                                            <?php echo $myInvrow["Companyname"]; ?>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                            <a href='companydetails.php?value=<?php echo $myInvrow["PECompanyId"];?>' ><?php echo $myInvrow["Companyname"]; ?></a>
                                            <?php
                                            }
                                            ?>
                                            ( <a href="<?php echo $dealpage;?>?value=<?php echo $myInvrow["PEId"];?>">
                                                            <?php echo $myInvrow["dt"];?> </a>)
                                                            <BR/>
                                        <?php
                                        }
                                        else
                                                {
                                                        $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
               </p>
                </td>
            </tr>
       </tbody>
       </table>
        </div>
        
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to <?php echo "Acquirer";?></h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
            <tr><td><p>
                    <?php
				if ($getcompanyrs = mysql_query($existadvisor_to_investorsql))
                                    {
                                            $AddOtherAtLast="";
                                            $AddUnknowUndisclosedAtLast="";
                                            While($myInvestrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                            {
                                            //$AddOtherAtLast="";
                                            $companyname1=trim($myInvestrow["Companyname"]);
                                            $companyname1=strtolower($companyname);

                                            $Result=substr_count($companyname1,$searchString);
                                            $Result1=substr_count($companyname1,$searchString1);
                                            $Result2=substr_count($companyname1,$searchString2);

                                            if(($Result==0) && ($Result1==0) && ($Result2==0))
                                            {
                                           
                                        ?>        
                                            <a href='companydetails.php?value=<?php echo $myInvestrow["PECompanyId"];?>' ><?php echo $myInvestrow["Companyname"]; ?></a>
                                            ( <a href="<?php echo $dealpage;?>?value=<?php echo $myInvestrow["PEId"];?>">
                                            <?php echo $myInvestrow["dt"];?> </a>)
                                                            <BR/>
                                        <?php
                                        }
                                        else
                                                {
                                                      $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to <?php echo "Investors"?></h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
            <tr><td><p>
                    <?php
				if ($getcompanyrs = mysql_query($invadvisor_to_investorsql))
                                    {
                                            $AddOtherAtLast="";
                                            $AddUnknowUndisclosedAtLast="";
                                            While($myInvestrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                            {
                                            //$AddOtherAtLast="";
                                            $companyname1=trim($myInvestrow["Companyname"]);
                                            $companyname1=strtolower($companyname);

                                            $Result=substr_count($companyname1,$searchString);
                                            $Result1=substr_count($companyname1,$searchString1);
                                            $Result2=substr_count($companyname1,$searchString2);

                                            if(($Result==0) && ($Result1==0) && ($Result2==0))
                                            {
                                           
                                        ?>        
                                            <a href='companydetails.php?value=<?php echo $myInvestrow["PECompanyId"];?>' ><?php echo $myInvestrow["Companyname"]; ?></a>
                                            ( <a href="<?php echo $dealpage;?>?value=<?php echo $myInvestrow["PEId"];?>">
                                            <?php echo $myInvestrow["dt"];?> </a>)
                                                            <BR/>
                                        <?php
                                        }
                                        else
                                                {
                                                      $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
    
            <?php
					if(($exportToExcel==1) || ($exportToExcel1==1))
					{
					?>
							<span style="float:right" class="one">
                                                            <input type="submit" class="export"  value="Export" name="showdeal">
							</span>
                                                         <script type="text/javascript">
                                                                $('#exportbtn').html(' <input type="submit" class="export"  value="Export" id="showdeal" name="showdeal">');
                                                        </script>

					<?php
					}
					?>
 </div>
</td>
        




        <?php } ?>
</tr>

</table>
       
    </div>

 
<div class=""></div>

</form>
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


    ?>
