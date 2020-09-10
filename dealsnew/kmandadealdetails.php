<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        include('checklogin.php');
        

	$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	//$SelCompRef=$value;
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $flagvalue=$strvalue[1];
        $searchstring=$strvalue[2];

                
               
               



//$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
//				 DealAmount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,
//				 pe.MandAId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
//				 peinv.MandAId,peinv.InvestorId,inv.Investor,pe.DealTypeId,dt.DealType,pe.AcquirerId,ac.Acquirer
//				 		 FROM manda AS pe, industry AS i, pecompanies AS pec,
//						 manda_investors as peinv,dealtypes as dt,acquirers as ac,
//					  	peinvestors as inv
//						 WHERE  i.industryid=pec.industry
//						 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MandAId=$SelCompRef
//						 and inv.InvestorId=peinv.InvestorId and peinv.MandAId=$SelCompRef and pe.MandAId=peinv.MandAId and
//						 dt.DealTypeId=pe.DealTypeId and ac.AcquirerId=pe.AcquirerId";

  	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 DealAmount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,
				 pe.MandAId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
				pe.DealTypeId,dt.DealType,pe.InvestmentDeals,pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,it.InvestorTypeName,
				uploadfilename,source,Valuation,FinLink, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus
				 		 FROM manda AS pe, industry AS i, pecompanies AS pec,
						 dealtypes as dt,investortype as it
					  	 WHERE  i.industryid=pec.industry
						 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MandAId=$SelCompRef
						 and dt.DealTypeId=pe.DealTypeId and it.InvestorType=pe.InvestorType";
	//echo "<br>".$sql;

		$AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
		where peinv.MandAId=$SelCompRef and ac.AcquirerId=peinv.AcquirerId";

		$investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,peinv.MultipleReturn,InvMoreInfo from manda_investors as peinv,
		peinvestors as inv where peinv.MandAId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
		//echo "<br>".$investorSql;


	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisoracquirer as advinv,
	advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;



?>

<?php
	$topNav = 'Deals'; 
	include_once('kmandaheader_search.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg"><div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide">Slide Panel</a></div> 
 <div  id="panel">
<div class="left-box">

<?php include_once('kmandarefine.php');?>
 <input type="hidden" name="resetfield" value="" id="resetfield"/>

</td>
</form>
 <form name="mandadealinfo" method="post" action="exportmanda.php">
     <?php
	 //GET PREV NEXT ID
	$prevNextArr = array();
	$prevNextArr = $_SESSION['resultId'];
	
	$currentKey = array_search($SelCompRef,$prevNextArr);
	$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
	$nextKey = $currentKey+1;
	 
  	if ($companyrs = mysql_query($sql))
        {      
	?>
		<input type="hidden" name="txthideMandAId" value="<?php echo $SelCompRef;?>" >
		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
                <?php
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
                $hideamount="";
                $hidemoreinfor="";
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
			if($myrow["hideamount"]==1)
			{
				$hideamount="--";
			}
			else
			{
				$hideamount=$myrow["DealAmount"];
			}

			if($myrow["hidemoreinfor"]==1)
			{
				$hidemoreinfor="--";
			}
			else
			{
				$hidemoreinfor=$myrow["MoreInfor"];
	      	        }

			if($hidemoreinfor!="--")
			{
				$string = $hidemoreinfor;
				/*** an array of words to highlight ***/
				$words = array($searchstring);
				//$words="warrants convertible";
				/*** highlight the words ***/
				$hidemoreinfor =  highlightWords($string, $words);
			}
			$moreinfo_returns=$myrow["MoreInfoReturns"];
                        
			if(trim($moreinfo_returns=="") || trim($moreinfo_returns==" "))
                        {
                           $moreinfo_returns="";
                        }

			$investmentdeals=$myrow["InvestmentDeals"];
			if($investmentdeals!="")
			{
				$words = array($searchstring);
				$investmentdeals =  highlightWords($investmentdeals, $words);
			}


                $col6=$myrow["Link"];
                $linkstring=str_replace('"','',$col6);
                $linkstring=explode(";",$linkstring);
                $estimatedirrvalue=$myrow['EstimatedIRR'];

                $finlink=$myrow["FinLink"];
                $valuation=$myrow["Valuation"];
		if($valuation!="")
		{
		    $valuationdata = explode("\n", $valuation);
		}

		if($myrow["Company_Valuation"]<=0)
                    $dec_company_valuation=0.00;
                else
                    $dec_company_valuation=$myrow["Company_Valuation"];
                if($myrow["Revenue_Multiple"]<=0)
                    $dec_revenue_multiple=0.00;
                else
                    $dec_revenue_multiple=$myrow["Revenue_Multiple"];

               	if($myrow["EBITDA_Multiple"]<=0)
                    $dec_ebitda_multiple=0.00;
                else
                    $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];
               	if($myrow["PAT_Multiple"]<=0)
                    $dec_pat_multiple=0.00;
                else
                    $dec_pat_multiple=$myrow["PAT_Multiple"];
                    $exitstatusvalue=$myrow["ExitStatus"];

                if($exitstatusvalue==0)
                    $exitstatusdisplay="Partial";
                elseif($exitstatusvalue==1)
                    $exitstatusdisplay="Complete";
                else
                    $exitstatusdisplay="";

                $uploadname=$myrow["uploadfilename"];
                $currentdir=getcwd();
                $target = $currentdir . "../uploadmamafiles/" . $uploadname;
                $file = "../uploadmamafiles/" . $uploadname;

            if ($getAcquirerSql = mysql_query($AcquirerSql))
                    {
                        While($myAcquirerrow=mysql_fetch_array($getAcquirerSql, MYSQL_BOTH))
                            {
                                  $AcquirerDisplay=$myAcquirerrow["Acquirer"];
                                  $Acquirer=$myAcquirerrow["Acquirer"];
                                  $AcquirerId=$myAcquirerrow["AcquirerId"];
                                  $Acquirer=strtolower($Acquirer);
                                  $AcqResult=substr_count($Acquirer,$searchString);
                                  $AcqResult1=substr_count($Acquirer,$searchString1);
                                  $AcqResult2=substr_count($Acquirer,$searchString2);
                            }
                    } ?>
<td class="profile-view-left" style="width:100%;">

<div class="result-cnt">
    
<div class="result-title">

                <?php if(!$_POST)
                    {
                    if($value=="0-1")
                       {
                       ?>
                           <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for Exit Via Public Market Sales </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a>
                       <?php }
                       elseif($value=="0-0") {
                           ?>
                           <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for PE Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                       <?php } 
                      elseif ($value="1-0") { ?>
                           <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for  VC Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                      <?php }
               ?>
                  <?php 
                  }
                   else 
                   {
                        if($value=="0-1")
                       {
                       ?>
                               <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for Exit Via Public Market Sales </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a>
                       <?php }
                       elseif($value=="0-0") {
                           ?>
                             <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for PE Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                       <?php } 
                         elseif ($value="1-0") { ?>
                             <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for  VC Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                         <?php }
               ?>
            <ul>
                <?php
                if($industry >0 && $industry!=null){ ?>
                <li title="Industry">
                                    <?php echo $industryvalue; ?> <a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($dealtype!="--"){ ?>
                                <li title="Dealtype">
                                    <?php echo $dealtypevalue; ?> <a  onclick="resetinput('dealtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li title="Investor type"> 
                                    <?php echo $invtypevalue; ?> <a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($exitstatusdisplay!="") { ?>
                                <li title="Exit Display "> 
                                    <?php echo $exitstatusdisplay;?> <a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if($advisorsearchstring_legal!=" ") { ?>
                                <li title="Legal Advisor"> 
                                    <?php echo $advisorsearchstring_legal?> <a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans!=" "){ ?>
                                <li title="Transatactional Advisor"> 
                                    <?php echo $advisorsearchstring_trans?> <a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($datevalueDisplay1!=""){ ?>
                                <li title="Period"> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?> <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if(($txtfrm>=0) && ($txtto>0)) { ?>
                                <li title="Return Multiple"> 
                                    <?php echo $txtfrm. "-" .$txtto?> <a  onclick="resetinput('returnmultiple');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($companysearch!=" "){ ?>
                                <li title="Company Search"> 
                                    <?php echo $companysearch;?> <a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($investorsearch!=" "){ ?>
                                <li title="Investor" > 
                                    <?php echo $investorsearch;?> <a  onclick="resetinput('investorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ ?>
                                <li title="Others"> 
                                <?php echo $searchallfield ; ?> <a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } ?>
             </ul>
             <?php } ?>
       
     <?php
            if(($exportToExcel==1))
            {
            ?>
                    <div class="title-links"><input type="submit"  value="Export" name="showmandadeal"></div>
                  
            <?php
            }
?>   
 </div>  

 <div class="list-tab"><ul>
            <li><a class="postlink"  href="<?php echo $searchTitle; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="kmandadealdetails.php?value=<?php echo $SelCompRef;?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>" ><i></i> Detailed  View</a></li> 
            </ul>
        </div>   


<div class="view-detailed">
        <div class="detailed-title-links"><h2> <A  href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
            <?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="mandadealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $flagvalue;?>/">< Previous</a><?php } ?> 
            <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="mandadealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $flagvalue;?>/"> Next > </a>  <?php } ?>
        </div> 

        <div class="profilemain">
             <h2>Deals Info  </h2>
             <div class="profiletable">
                  <ul>
                    <li><h4>IPO Size (US $M)</h4><p><?php echo $hideamount;?></p></li>
                    <li><h4>Deal Type </h4><p><?php echo $myrow["DealType"];?></p></li>
                    <li><h4>Exit Status</h4><p><?php echo $exitstatusdisplay ;?></p></li>
                    <li><h4>Deal Period</h4><p><?php echo  $myrow["dt"];?></p></li>
                    <li><h4>Acquirer</h4>
                        <p><?php
                                if(($AcqResult==0) && ($AcqResult1==0) && ($AcqResult2==0))
                                                 echo  $AcquirerDisplay;
                                else
                                                 echo $searchStringDisplay;
                                ?>
                        </p>
                    </li>
                 </ul>
             </div>
        </div>
    
    <div class="postContainer postContent masonry-container">
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
            <h2>Company Info</h2>
            <table cellpadding="0" cellspacing="0" width="100%"  class="tableview">
            <tbody>
            <tr><td ><h4>Company</h4>
                    <p><A class="postlink" href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>' ><?php echo rtrim($myrow["companyname"]);?></a>
                    </p></td>
            </tr>
            <tr><td><h4>Sector </h4><p><?php echo $myrow["sector_business"];?></p></td></tr>
            <tr><td><h4>Industry</h4><p><?php echo $myrow["industry"];?></p></td></tr>
            <tr><td><h4>Website</h4><p style="word-break: break-all;"><a  href=<?php echo $myrow["website"]; ?> target="_blank"><?php echo $myrow["website"]; ?></a></p></td></tr></tbody>
            </table>
        </div>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investor & Advisor Info</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
            <tr>
                <td><h4>Investors</h4><p style="word-break: break-all;">
                    <?php
				if ($getcompanyrs = mysql_query($investorSql))
				{
					$AddOtherAtLast="";
					$AddUnknowUndisclosedAtLast="";
				While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
				{
					$Investorname=trim($myInvrow["Investor"]);
					$Investorname=strtolower($Investorname);
                        		$invResult=substr_count($Investorname,$searchString);
					$invResult1=substr_count($Investorname,$searchString1);
					$invResult2=substr_count($Investorname,$searchString2);

					if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
					{
                                          if($myInvrow["MultipleReturn"]>0)
                                          {  $bool_returnFlag=1;}
                                          $invReturnString[]=$myInvrow["Investor"].",".$myInvrow["MultipleReturn"];
                                          $invMoreInfoString[]=$myInvrow["InvMoreInfo"];
	      		?>

                    <a class="postlink" href='investordetails.php?value=<?php echo $myInvrow["InvestorId"].'/'.$VCFlagValue.'/';?>' ><?php echo $myInvrow["Investor"]; ?></a><br />
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
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td><h4>Investor Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td>
            </tr>
            
            <tr>
                <td ><h4>Advisor - Seller</h4>
                    <p>
                   <?php
					if ($getcompanyrs = mysql_query($advcompanysql))
					{
					While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
					{
				?>

                    <A class="postlink" href='advisor.php?value=<?php echo $myadcomprow["CIAId"];?>/2/<?php echo $flagvalue?>' >
					<?php echo $myadcomprow["cianame"]; ?></a>  (<?php echo $myadcomprow["AdvisorType"];?>)<br />
                    <?php
                                    
                            }
                            }
                    ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            
               <tr>
                <td ><h4>Advisor - Buyer</h4><p>
                   <?php
					if ($getinvestorrs = mysql_query($adacquirersql))
					{
					While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
					{
				?>

                    <A class="postlink" href='advisor.php?value=<?php echo $myadinvrow["CIAId"];?>/2/<?php echo $flagvalue?>' >
					<?php echo $myadinvrow["cianame"]; ?></a>  (<?php echo $myadinvrow["AdvisorType"];?>)<br />
                    <?php
                                    
                            }
                            }
                    ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                                        </p>
                </td>
            </tr>
            
            <tr><td ><h4>More Details</h4><p><?php print nl2br($hidemoreinfor);?></p></td></tr>
           
            <?php 
       if(sizeof($linkstring)>0) 
       { 
       ?> 
        <tr>
            <td><b>Link</b><p>
         <?php  foreach ($linkstring as $linkstr)
                { 
                    if(trim($linkstr)!=="")
                    {
                ?>
          <a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a><br/>
          
                    <?php } } ?>
                </p>
          </td>
        </tr>
          <?php } ?> 
            </tbody>
            </table>
        </div>
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investment Details</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
            <td colspan="2"><p><?php print nl2br($investmentdeals) ;?></p></td>
        </tr>
        <?php
                        if($dec_company_valuation >0)
                        {
                        ?>
                        <tr><td ><h4>&nbsp;Company Valuation (INR Cr) </h4><p><?php echo $dec_company_valuation ;?></p></td></tr>
                         <?php
                        }

                        if($dec_revenue_multiple >0)
                        {
                        ?>
                        <tr><td><h4>&nbsp;Revenue Multiple </h4><p><?php echo $dec_revenue_multiple ;?></p></td></tr>
                         <?php
                        }

                        if($dec_ebitda_multiple >0)
                        {
                        ?>
                        <tr><td ><h4>&nbsp;EBITDA Multiple </h4><p><?php echo $dec_ebitda_multiple ;?></p></td></tr>
                         <?php
                        }

                        if($dec_pat_multiple >0)
                        {
                        ?>
                        <tr><td><h4>&nbsp;PAT Multiple </h4><p><?php echo $dec_pat_multiple ;?></p></td></tr>
                         <?php
                        } ?>
                        
                         <?php
            
            if(trim($myrow["Valuation"])!="")
			{
			?>
			<tr><td ><h4>&nbsp;Valuation (More Info)</h4><p>

			<?php
			    foreach($valuationdata as $valdata)
			    {
				if($valdata!="")
				{
			?>
			  <?php print nl2br($valdata);?> <br/>
			<?php
				}
			    }
                            ?></p> </td></tr> <?php
			}
                      ?>
                        
                     <?PHP  if($finlink!="")
			{
			?>
                        <tr><td ><h4>&nbsp;Link for Financials</h4><p><a target="_blank" href=<?php echo $finlink; ?> ><?php echo $finlink; ?></a></p></td>

			<?php
			}
                      if($myrow["uploadfilename"]!="")
			{

				?>

					<tr><td ><h4>&nbsp;Financials</h4>
                                        <?php
                                         if($exportToExcel==1)
                                         {
                                         ?>
                                                <p><a href=<?php echo $file;?> target="_blank" > Click here </a> </p> </td> </tr>
                                         <?php
                                         }
                                         else
                                         {
                                         ?>
                                                <p>Paid Subscribers can view a link to the co. financials here </p> </td> </tr>
                                         <?php
                                          }
                                         ?>
					<!--<tr><td width=20% valign=top><b>&nbsp;Source</b></td>
					<td width=30% >&nbsp;<?php echo  $myrow["source"];?></td></tr>  -->

				<?php

			} ?>
        </tbody>
        </table> 
        
        
        </div>
        
        
        
    </div>
 
    
</div>
            
</tr>


 

</tbody>
                </table> 
        <?php }} ?>

       
    </div>

 
<div class=""></div>

</form>
</body>
 <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
            </script>
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
