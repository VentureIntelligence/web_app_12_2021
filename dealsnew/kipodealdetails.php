<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        include('checklogin.php');
        

	$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

		$strvalue = explode("/", $value);
		$SelCompRef=$strvalue[0];
		$searchstring=$strvalue[1];
	//$SelCompRef=$value;

  	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
  	pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,
  	pec.website, pec.city, pec.region,pe.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,
          pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,pe.InvestorType, its.InvestorTypeName,Valuation,FinLink,
          Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,ExitStatus
   	FROM ipos AS pe, industry AS i, pecompanies AS pec,investortype as its
  	WHERE pec.industry = i.industryid and pe.IPOId=$SelCompRef  and
  	pec.PEcompanyId = pe.PECompanyId     and its.InvestorType=pe.InvestorType
  	and pe.Deleted=0 order by IPOSize desc,i.industry";
	//echo "<br>".$sql;

	$investorSql="SELECT peinv.IPOId, peinv.InvestorId, inv.Investor,MultipleReturn,InvMoreInfo
	FROM ipo_investors AS peinv, peinvestors AS inv
	WHERE peinv.IPOId =$SelCompRef
	AND inv.InvestorId = peinv.InvestorId";

	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;



?>

<?php
	$topNav = 'Deals'; 
	include_once('kipoheader_search.php');
?>

<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="left-box">

<?php include_once('kiporefine.php');?>

</td>
</form>
 <form name=ipodealinfo method="post" action="exportipo.php">
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
		<input type="hidden" name="txthideIPOId" value="<?php echo $SelCompRef;?>" >
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
			$moreinfo_returns="";
			$selling_investors_value="";
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
                        $investor_sale_value=$myrow["InvestorSale"];
                        if($investor_sale_value==1)
                           $investor_sale_display="Yes";
                        else
                           $investor_sale_display="No";
                        if($myrow["Company_Valuation"]<=0)
                           $dec_company_valuation=0.00;
                        else
                           $dec_company_valuation=$myrow["Company_Valuation"];
                        if($myrow["Sales_Multiple"]<=0)
                            $dec_sales_multiple=0.00;
                        else
                            $dec_sales_multiple=$myrow["Sales_Multiple"];

                       	if($myrow["EBITDA_Multiple"]<=0)
                            $dec_ebitda_multiple=0.00;
                        else
                            $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];
                       	if($myrow["Netprofit_Multiple"]<=0)
                            $dec_netprofit_multiple=0.00;
                        else
                            $dec_netprofit_multiple=$myrow["Netprofit_Multiple"];

                        if(($myrow["SellingInvestors"]!=""))
                        { 
                          //echo "<br>**";
                          $selling_investors_value=$myrow["SellingInvestors"];}
                        else
                        {$selling_investors_value=""; }
                       $valuation=$myrow["Valuation"];
		       if($valuation!="")
		       {      $valuationdata = explode("\n", $valuation);      }
                        $finlink=$myrow["FinLink"];
                        //echo "<bR>--" .$finlink;
			if($myrow["hideamount"]==1)
			{
				$hideamount="--";
			}
			else
			{
				$hideamount=$myrow["IPOSize"];
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
                        if(($moreinfo_returns=="")&& ($moreinfo_returns==" "))
                        {
                          $moreinfo_returns="";
                        }

			$investmentdeals=$myrow["InvestmentDeals"];
			if($investmentdeals!="")
			{
				$words = array($searchstring);
				$investmentdeals =  highlightWords($investmentdeals, $words);
			}
                        $iposize=$myrow["IPOAmount"];
                        if($iposize<=0)
                        { $iposize="";}
                        $ipovaluation=$myrow["IPOValuation"];
                        if($ipovaluation<=0)
                        {  $ipovaluation="";}

	      	        $col6=$myrow["Link"];
			$linkstring=str_replace('"','',$col6);
			$linkstring=explode(";",$linkstring);

			$estimatedirrvalue=$myrow['EstimatedIRR'];
			$estimatedirrvalue=trim($estimatedirrvalue);
			
			$exitstatusvalue=$myrow["ExitStatus"];
                        if($exitstatusvalue==0)
                            $exitstatusdisplay="Partial";
                        elseif($exitstatusvalue==1)
                            $exitstatusdisplay="Complete";
                        else
                            $exitstatusdisplay="";
		     ?>
<td>

<div class="result-cnt">



<div class="result-title">

                <?php if(!$_POST)
                    {
                    if($VCFlagValue==0)
                       {
                       ?>
                               <h2><?php echo @mysql_num_rows($companyrs); ?> results for PE-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
                       elseif($VCFlagValue==1) {
                           ?>
                           <h2><?php echo @mysql_num_rows($companyrs); ?> results for VC-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
               ?>
                  <?php 
                  }
                   else 
                   {
                       if($VCFlagValue=="0")
                       {
                       ?>
                               <h2><?php echo @mysql_num_rows($companyrs); ?> results for PE-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
                       elseif($VCFlagValue=="1") {
                           ?>
                           <h2><?php echo @mysql_num_rows($companyrs); ?> results for VC-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
               ?>
            <ul>
                <?php
                // echo "<bR>--**" .$followonVCFund."adsasd".$followonVCFundText;
                 //echo $queryDisplayTitle;
                if($industry >0 )
                    echo "<li>".$industryvalue."</li>";
                if($investorType !="--" && $investorType !="")
                    echo "<li>".$invtypevalue."</li>";
                if($investorSale==1)
                        echo "<li>Investor Sale</li>";
                if($exitstatusdisplay!="")
                         echo  "<li>".$exitstatusdisplay."</li>";
                if($datevalueDisplay1!="")
                        echo "<li>".$datevalueDisplay1. "-" .$datevalueDisplay2."</li>";
                if(($txtfrm>=0) && ($txtto>0))
                        echo "<li>".$txtfrm. "-" .$txtto."</li>";
                if($keyword!=" ")
                        echo "<li>".$keyword."</li>";
                if($advisorsearch!="")
                        echo "<li>".$advisorsearch."</li>";
                if($companysearch!=" ")
                    echo "<li>".$companysearch."</li>";
                
                if($searchallfield!="")
                    echo "<li>".$searchallfield."</li>";



                
                
                
                ?>
             </ul>
             <?php } ?>
        </div>
  
        <div class="list-tab"><ul>
            <li><a class="postlink"  href="kipoindex.php?value=<?php echo $VCFlagValue; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="kipodealdetails.php?value=<?php echo $SelCompRef;?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>" ><i></i> Detailed  View</a></li> 
            </ul>
        </div>  
    <div class="view-detailed">
        <div class="detailed-title-links"><h2>  <?php echo $myrow["companyname"]; ?></h2>
            <?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="kipodealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $flagvalue;?>/">< Previous</a><?php } ?> 
            <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="kipodealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $flagvalue;?>/"> Next > </a>  <?php } ?>
        </div> 

        <div class="profilemain">
             <h2>Deals Info  </h2>
             <div class="profiletable">
                <ul>
                    <li><h4>IPO Size (US $M)</h4><p><?php echo $hideamount;?></p></li>
                    <li><h4>IPO Price (Rs.)</h4><p><?php echo $iposize;?></p></li>
                    <li><h4>IPO Valuation (US $M)</h4><p><?php echo $ipovaluation;?></p></li>
                    <li><h4>Deal Period</h4><p><?php echo  $myrow["IPODate"];?></p></li>
                  <!--  <li><h4></h4><p></p></li> -->
                    
                </ul>
            </div>
        </div>
    
    
    
      <div class="postContainer postContent masonry-container"> 
       <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Company Info</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
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
                <td><h4>Company</h4>
                    <p><A class="postlink" href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>' ><?php echo rtrim($myrow["companyname"]);?></a></p>
                </td>
            <?php
                }
                else
                {
                    $webdisplay="";
            ?>
                <td><h4>Company</h4><p><?php echo ucfirst("$searchString") ;?></p>
                </td>
            <?php
                }
            ?></tr>
           <tr><td><h4>Industry</h4><p><?php echo $myrow["industry"];?></p></td>
        </tr>
        <tr><td><h4>Website</h4><p><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></p></td></tr>
        </tbody>
        </table>
        </div>
        
        
          
      
 
    
        
    
        
            

         
      <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investment Details</h2>    
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
            <td><p style="word-break: break-all;"><?php print nl2br($investmentdeals) ;?></p></td>
        </tr>
        </tbody>
        </table> 
        </div>
       <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>More Details(Overall IPO)</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
           <td><p><?php print nl2br($hidemoreinfor) ;?></p></td>
        </tr>
        </tbody>
        </table>
        </div>
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>More Info</h2>    
        <table cellpadding="0" cellspacing="0"  class="tableview">
        <tbody> <?php
            if($dec_company_valuation >0)
            {
            ?>
              <tr><td><h4>Company Valuation (INR Cr) </h4><p><?php echo $dec_company_valuation ;?></p></td></tr>
             <?php
            }

            if($dec_sales_multiple >0)
            {
            ?>
              <tr><td ><h4>Sales Multiple </h4><p><?php echo $dec_sales_multiple ;?></p></td></tr>
             <?php
            }

            if($dec_ebitda_multiple >0)
            {
            ?>
              <tr><td ><h4>EBITDA Multiple </h4><p><?php echo $dec_ebitda_multiple ;?></p></td></tr>
             <?php
            }

            if($dec_netprofit_multiple >0)
            {
            ?>
              <tr><td ><h4>Netprofit Multiple </h4><p ><?php echo $dec_netprofit_multiple ;?></p></td></tr>
             <?php
            }

            if(trim($myrow["Valuation"])!="")
            {
              $valdata=$myrow["Valuation"];
            ?>
            <tr><td><b>Valuation (More Info)</b></td>
                <td>
                       <p><?php print nl2br($valdata);?></p></tr>
                </td>
            </tr>
        <?php
        }

        if($finlink!="")
        {
        ?>
            <tr><td ><h4>Link for Financials</h4><p style="word-break: break-all;"><a target="_blank" href=<?php echo $finlink; ?> ><?php echo $finlink; ?></a></p></td>

        <?php
        }?>
        </tbody>
        </table>
    </div>
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investor Info</h2>    
        <table cellpadding="0" cellspacing="0"  class="tableview">
        <tbody>
            <tr>
                <td ><h4>Investors<h4>
                     <p>
                    <?php
                            if ($getcompanyrs = mysql_query($investorSql))
                            {
                                    $AddOtherAtLast="";
                                    $AddUnknowUndisclosedAtLast="";
                                    $bool_returnFlag=0;
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
                    </p>
                </td>
            </tr>
            <tr><td><h4>Investor Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td></tr>
            <tr><td><h4>Exit Status </h4><p><?php echo $exitstatusdisplay ;?></p></td></tr>
            <tr><td><h4>Investor Sale in IPO?</h4><p><?php echo $investor_sale_display ;?></p></td></tr>
            <?php
             if(($selling_investors_value!="") && ($selling_investors_value!="  "))
             {
             ?>
            <tr><td><h4>Selling Investors</h4><p><?php print nl2br($selling_investors_value);?></p></td></tr>
            <?php
             } ?>
            <?php 
       if(sizeof($linkstring)>0) 
       { 
       ?> 
            <tr><td><h4>Link</h4>
                    <p>
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
        <h2>Return Info</h2>    
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <?php
        if(($estimatedirrvalue!=" ") && ($estimatedirrvalue!=""))
        {
        ?>
            <tr><td ><h4>Estimated Returns </h4><p><?php echo $estimatedirrvalue;?></p></td></tr>
        <?php
        } ?>
        
        <?php
        $invStringArrayCount=count($invReturnString);
        if($bool_returnFlag==1)  //to display the title ifandonlyif atleast one investor has mutliplereturn value >0
         {
        ?>
            <tr ><td><h4>Return Mutliple</h4>
                 <p> 
                    <?php
                      for($i=0;$i<$invStringArrayCount;$i++)
                      {
                      //echo "<br>^^^^^".$invReturnString;
                      $invStringToSplit=$invReturnString[$i];
                       $invString  =explode(",",$invStringToSplit);
                       $investorName=$invString[0];
                       $returnValue=$invString[1];
                       $investormoreinfo=$invMoreInfoString[$i];
                   //echo "<br>****".$invString[1];

                        if($returnValue>0)
                        {
                  ?>
                        <b><?php echo $investorName;?> </b>, <?php echo $returnValue;?>x
                         <br />
                          <?php
                           if( trim($investormoreinfo!="") && ($investormoreinfo!=" "))
                           {
                            echo ($investormoreinfo) ;
                           }
                         ?>

                        

                  <?php echo "<br/>";
                      }
                      }
                  ?>
                 </p>
                 </td>
              </tr>
                        
                 <?php
			$invStringArrayCount=count($invReturnString);

			if($bool_returnFlag==1)  //to display the title ifandonlyif atleast one investor has mutliplereturn value >0
                         {
                        ?>
                          <tr><td ><h4>Return Mutliple</h4><p>
                            <?php
			      for($i=0;$i<$invStringArrayCount;$i++)
			      {
                              //echo "<br>^^^^^".$invReturnString;
                              $invStringToSplit=$invReturnString[$i];
                               $invString  =explode(",",$invStringToSplit);
                               $investorName=$invString[0];
                               $returnValue=$invString[1];
                               $investormoreinfo=$invMoreInfoString[$i];
                           //echo "<br>****".$invString[1];

                                if($returnValue>0)
                                {
                          ?>
                             	
  				<b><?php echo $investorName;?> </b>, <?php echo $returnValue;?>x
                                 <br />
                                  <?php
                                   if( trim($investormoreinfo!="") && ($investormoreinfo!=" "))
                                   {
                                    echo ($investormoreinfo) ;
                                   }
                                 ?>

                                

                          <?php echo "<br/>";
                              }
                              }
                          ?>
                          </p>
                          </td></tr>
                  <?php
                         }   ?>    
                        
          <?php
                 } 
                 if(trim($moreinfo_returns!="") && ($moreinfo_returns!=" "))
                {
                ?>
                <tr><td ><h4>More Info (Returns)</h4><p><?php print nl2br($moreinfo_returns);?></p></td></tr>
                <?php
                 } ?>

                
                
                
        </tbody>
        </table>
        </div>
      </div>
   </div>  

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


 

                </td> 
        <?php }} ?>
</tr>

</table>
       
    </div>
</td>

</tr>
</table>
 
</div>
<div class=""></div>

</div>
</form>
    <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
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

    ?>
