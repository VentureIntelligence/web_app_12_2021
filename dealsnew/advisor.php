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
                $vcflagValue=($AdvisorString[2]!="")?$AdvisorString[2]:0;
                 $flagvalue=($AdvisorString[2]!="")?$AdvisorString[2]:0-1;
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

					$AdvisorSql="select * from advisor_cias where CIAId=$SelCompRef";

				if($pe_exit_advisorflag==1)
				{
                                  //   echo "<br>Inside PE";
				//	$dealpage="dealinfo.php";
                                        $dealpage="dealdetails.php";
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

$invcompaniessql="(SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,dates,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt,peinv.PEId as PEId
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates) 
                   UNION
                   (SELECT  distinct peinv.PEId as PEId,adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,dates,
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
                                        order by dates desc) order by dates desc";


$existcompaniessql= "SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MandAId as PEId
					FROM manda AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac
					WHERE peinv.Deleted=0 " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by DealDate DESC";


$invadvisor_to_investorsql="(SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,dates,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates) 
                              UNION (
					SELECT distinct peinv.PEId as PEId, peinv.PECompanyId,adac.CIAId AS AcqCIAId,c.Companyname,dates,
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
                                        order by peinv.dates desc) order by dates desc";

        $existadvisor_to_investorsql="  SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MandaId  as PEId ,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisoracquirer AS adac
					WHERE peinv.Deleted=0 ".
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by DealDate DESC"

?>


<?php
	$topNav = 'Deals';
        
	include_once($headerurl);
?>
</form>
<form name="advisorprofile" id="advisorprofile" method="post" action="exportadvisor.php">
<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
 <?php

  	if($advisorrs=mysql_query($AdvisorSql))
		{
			while($advisorrow=mysql_fetch_array($advisorrs,MYSQL_BOTH))
			{
				$advisorname=$advisorrow["cianame"];
                                 $advisorid=$advisorrow["CIAId"];
                                 $website=$advisorrow["website"];
                                 $advisortype=$advisorrow["AdvisorType"];
                                 $advisortype=($advisortype=="T")?("Transaction Advisor"):(($advisortype=="L")?"Legal Advisor":"");
                                 $address=$advisorrow["address"];
                                 $city  =$advisorrow["city"];
                                 $country=$advisorrow["country"];
                                 $phoneno=$advisorrow["phoneno"];
                                 $contactperson=$advisorrow["contactperson"];
                                 $designation   =$advisorrow["designation"];
                                 $emailid=$advisorrow["email"];
                                 $linkedIn=$advisorrow["linkedin"];
			}
        
	?>
		<input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >

		<input type="hidden" name="hidepeexitflag" value="<?php echo $pe_exit_advisorflag;?>" >
		<input type="hidden" name="hidevcflagValue" value="<?php echo $pe_vc_flag;?>" >

		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >

		
<td>

<div class="result-cnt">

  
    <!--div class="result-title result-title-nofix">
            <div class="title-links " id="exportbtn"></div> 
    </div-->
    <div class="title-links">           
                            <input class="senddeal" type="button" id="senddeal" value="Send this advisor profile to your colleague" name="senddeal"> 
                            <span id="exportbtn"></span>
                        </div>
         <br/><br>            
<div class="list-tab">
        <ul>
                <li class="active"><a id="icon-detailed-view" class="postlink" href="" ><i></i> Detail  View</a></li> 
        </ul>
</div> 
<div class="lb" id="popup-box">
                        <div class="title">Send this to your Colleague</div>
                        <form>
                            <div class="entry">
                                    <label> To*</label>
                                    <input type="text" name="toaddress" id="toaddress"  />
                            </div>
                            <div class="entry">
                                    <h5>Subject*</h5>
                                    <p>Checkout this profile - <?php echo rtrim($advisorname);?> - in Venture Intelligence</p>
                                    <input type="hidden" name="subject" id="subject" value="Checkout this profile - <?php echo rtrim($advisorname);?> - in Venture Intelligence"  />
                                    <input type="hidden" name="basesubject" id="basesubject" value="Advisor profile" />
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
    
    <div class="detailed-title-links"><h2><?php echo rtrim($advisorname);?></h2>
    <?php 
    $backlink=$_SERVER["HTTP_REFERER"];
    if ($backlink!='') {?> <a  class="postlink" id="previous" href="<?php echo $backlink; ?>">< Back</a><?php } ?> 
    </div>
     <?php  if($advisortype!="" || $website!=""){ ?>
     <div class="profilemain">
 <h2>Advisor Profile</h2>
 <div class="profiletable" style="position:  relative;">
<ul>
      <?php 
  if ($advisortype != "") 
  { ?>                                        
        <li><h4>Advisor Type  </h4><p> <?php echo $advisortype; ?></p></li>
  <?php
  }
if (trim($address) != "") 
  { ?>
  <li><h4>Address    </h4><p><?php echo $address; ?></p></li>
   <?php
    }
if (trim($city) != "") 
  { ?>
  <li><h4>City    </h4><p><?php echo $city; ?></p></li>
   <?php
    }
if (trim($country) != "") 
  { ?>
  <li><h4>Country    </h4><p><?php echo $country; ?></p></li>
   <?php
    }
if (trim($phoneno) != "") 
  { ?>
  <li><h4>Phone No.    </h4><p><?php echo $phoneno; ?></p></li>
   <?php
    }
if (trim($website) != "") 
  { ?>
  <li><h4>Website    </h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>
   <?php
    }
if (trim($contactperson) != "") 
  { ?>
  <li><h4>Contact Person    </h4><p><?php echo $contactperson; ?></p></li>
   <?php
    }
if (trim($designation) != "") 
  { ?>
  <li><h4>Designation    </h4><p><?php echo $designation; ?></p></li>
   <?php
    }
if (trim($emailid) != "") 
  { ?>
  <li><h4>Email ID    </h4><p><?php echo $emailid; ?></p></li>
   <?php
    }
    ?>

   </ul>
     <!-- LINKED IN START -->
                  
                     <?php 
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

                    <script type="text/javascript" src="http://platform.linkedin.com/in.js"> 
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

      $linkedinSearchDomain=  str_replace("http://www.", "", $website); 
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


   
         <script type="text/javascript" src="http://platform.linkedin.com/in.js">
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
                               var url ="/company-search:(companies:(id,website-url))?keywords=<?php echo $advisorname ?>";

                console.log(url);
            
                IN.API.Raw(url).result(function(response) {   
                   
                                    console.log(response);  
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
                                console.log(idvalue);
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
                   console.log(error);
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
  
 </div>
     </div> <?php } ?>
    <div class="postContainer postContent masonry-container">
        <?php
        if ($getcompanyrs = mysql_query($invcompaniessql))
        {
             $comp_cnt = mysql_num_rows($getcompanyrs);
        }
        if($comp_cnt>0)
        { 
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to company(Investment)</h2>
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
                                            ( <a href="dirdealdetails.php?value=<?php echo $myInvrow["PEId"];?>">
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
        <?php
        }
       if ($getcompanyrs = mysql_query($existcompaniessql))
       {
             $exist_cnt = mysql_num_rows($getcompanyrs);
       }
        if($exist_cnt>0)
        { 
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to company (Exit)</h2>
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
                                            ( <a href="mandadealdetails.php?value=<?php echo $myInvrow["PEId"];?>">
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
        <?php
        }
        if ($getcompanyrs = mysql_query($existadvisor_to_investorsql))
        {
             $existadvisor_cnt = mysql_num_rows($getcompanyrs);
        }
        if($existadvisor_cnt>0)
        { 
        ?>
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
                                            ( <a href="mandadealdetails.php?value=<?php echo $myInvestrow["PEId"];?>">
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
        <?php
        }
       if ($getcompanyrs = mysql_query($invadvisor_to_investorsql))
       {
             $invadvisor_cnt = mysql_num_rows($getcompanyrs);
       }
        if($invadvisor_cnt>0)
        {
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to <?php echo "Investor"?></h2>
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
                                            ( <a href="dirdealdetails.php?value=<?php echo $myInvestrow["PEId"];?>">
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
        <?php
        }
        ?>
    </div>
    
            <?php
					if(($exportToExcel==1) || ($exportToExcel1==1))
					{
					?>
							<span style="float:right" class="one">
                                                            <input type="submit" class="export" id="expshowdealsbtn"  value="Export" name="showdeal">
							</span>
                                                         <script type="text/javascript">
                                                                $('#exportbtn').html(' <input type="submit" class="export"  value="Export" id="expshowdeals" name="showdeal">');
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
             
             
             
            /* $('#expshowdeals').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });

                $('#expshowdealsbtn').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });*/

                 $('#expshowdeals').click(function(){ 
                
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();   
                    return false;

                });
                
                $('#expshowdealsbt').click(function(){ 
                    /*jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;*/

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
                                    //hrefval= 'exportinvdeals.php';
                                    //$("#pelisting").attr("action", hrefval);
                                    $("#advisorprofile").submit();
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
                    alert("There was some problem sending mail...");
                }

            });
            }

        });
</script> 
<?php mysql_close(); ?>