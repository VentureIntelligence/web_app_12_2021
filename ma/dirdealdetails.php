<?php
        require_once("maconfig.php");
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('machecklogin.php');
	$mailurl= curPageURL();	
        $notable=false;
        $drilldownflag=1;
       $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);

        $searchString3="Individual";
        $searchString3=strtolower($searchString3);
        //$searchString3ForDisplay=$searchString3;

        $searchString4="PE Firm(s)";
        $searchString4ForDisplay="PE Firm(s)";
        $searchString4=strtolower($searchString4);               
        
       // print_r($_POST);
        
	$topNav = 'Directory'; 
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $exvalue=  explode("/",$value);
        $SelCompRef=$exvalue[0];
        $dealvalue=$exvalue[1];
	include_once('madir_header.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 
 <?php
		
        //GET PREV NEXT ID
        $prevNextArr = array();
        $prevNextArr = $_SESSION['resultId'];

        $currentKey = array_search($SelCompRef,$prevNextArr);
        $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
        $nextKey = $currentKey+1;
	
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
					
  	$sql="SELECT pe.PECompanyId, pec.companyname,pe.Stake, pec.industry as industryId, i.industry, pec.sector_business,
        pec.countryid as TargetCountryId,pec.city as TargetCity,
        Amount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt,DATE_FORMAT(ModifiedDate,'%m/%d/%Y %H:%i:%s') as modifieddate,
        pec.website,c.country as TargetCountry, pe.MAMAId,pe.Comment,MoreInfor,pe.MADealTypeId,
        dt.MADealType,pe.AcquirerId,ac.Acquirer,pe.Asset,pe.hideamount,pe.Link,
        pe.uploadfilename,pe.source,pe.Valuation,pe.FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
        FROM mama AS pe, industry AS i, pecompanies AS pec,
        madealtypes as dt,acquirers as ac,country as c
        WHERE  i.industryid=pec.industry and c.countryid=pec.countryid
        AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MAMAId=$SelCompRef
        and dt.MADealTypeId=pe.MADealTypeId and ac.AcquirerId=pe.AcquirerId";
	//echo "<br>********".$sql;
        
        $advcompanysql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advinv,
	advisor_cias as cia where advinv.MAMAId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;
		$industryId='';
		if ($companyrs = mysql_query($sql))
		{  
                     
                        
                    if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
                    {
                        
                        $industryId=$myrow["industryId"];
                        $uploadname=$myrow["uploadfilename"];
			$currentdir=getcwd();
			$target = $currentdir . "../uploadmamafiles/" . $uploadname;

			$file = "../uploadmamafiles/" . $uploadname;

			$acquirerId=$myrow["AcquirerId"];
			$finlink=$myrow["FinLink"];
		//	echo "<br>---" .$acquirerId;
			$getAcquirerCityCountrySql = "select ac.CityId,ac.countryid,co.country from acquirers as ac,
			country as co where ac.AcquirerId=$acquirerId  and co.countryid=ac.CountryId";
		//	echo "<br>----" .$getAcquirerCityCountrySql;
                        if($cityrs=mysql_query($getAcquirerCityCountrySql))
                        {
                                if($mycityrow=mysql_fetch_array($cityrs,MYSQL_BOTH))
                                {
                                        $Acquirercityname=$mycityrow["CityId"];
                                        $Acquirercountryname=$mycityrow["country"];
                                }
                        }

                        $acquirerName=trim($myrow["Acquirer"]);
                        $acquirerName=strtolower($acquirerName);
                        $compResult3=substr_count($acquirerName,$searchString);
                        $compResult4=substr_count($acquirerName,$searchString4);
                        $compResult5=substr_count($acquirerName,$searchString3); //checking_for Individual string

                        //echo "<Br>--" .$compResult5;

                        $companyName=trim($myrow["companyname"]);
                        $companyName=strtolower($companyName);
                        $compResult=substr_count($companyName,$searchString);
                        $compResult1=substr_count($companyName,$searchString1);

                        if($myrow["Asset"]==1)
                        {
                                $openBracket="(";
                                $closeBracket=")";
                        }
                        else
                        {
                                $openBracket="";
                                $closeBracket="";
                        }
                        if($myrow["Amount"]==0)
                                $hideamount="";
                        elseif($myrow["hideamount"]==1)
                                $hideamount="";
                        else
                                $hideamount=$myrow["Amount"];

                        if($myrow["Stake"]==0)
                                $hidestake="";
                        else
                                $hidestake=$myrow["Stake"];

                        $moreinfor = $myrow["MoreInfor"];
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

                        if($myrow["target_listing_status"]=="L")
                              $target_listing_stauts_display="Listed";
                        elseif($myrow["target_listing_status"]=="U")
                              $target_listing_stauts_display="Unlisted";

                        if($myrow["acquirer_listing_status"]=="L")
                              $acquirer_listing_stauts_display="Listed";
                        elseif($myrow["acquirer_listing_status"]=="U")
                              $acquirer_listing_stauts_display="Unlisted";
                //	echo "<br>".$moreinfor;
                //echo "<br>".$searchstring;

                                /*** an array of words to highlight ***/
                                $words = array($searchstring);
                                //$words="warrants convertible";
                                /*** highlight the words ***/
                                $moreinfor =  highlightWords($moreinfor, $words);


                                $col6=$myrow["Link"];
                                $linkstring=str_replace('"','',$col6);
                                $linkstring=explode(";",$linkstring);


                        $webdisplay="";
                        if(($compResult==0) && ($compResult1==0))
                        {
                                $webdisplay=$myrow["website"];
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
                  
                    $ma_industries = explode(',', $_SESSION['MA_industries']);
                    if(!in_array($industryId,$ma_industries)){

                        echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
                        exit;
                    } 
            ?>                               
    <div class="result-title"> 
        
        <?php if(!$_POST){ ?> 
                               <?php 
                             
                               if(($exportToExcel==1))
                                    {
                                    ?>
                                                    <div class="title-links">
                                                                    <input class="export" type="button"  value="Export" name="showdeal">
                                                    </div><br>

                                    <?php
                                    }
                               
                                   }
                                   else 
                                   { ?> 
                                  
                                 <?php 
                                 if(($exportToExcel==1))
                                    {
                                    ?>
                                                    <div class="title-links">
                                                                    <input class="export" type="button"  value="Export" name="showprofile">
                                                    </div><br>

                                    <?php
                                    }
                               }?>
        
    </div><br><br><br>
    <div class="list-tab "><ul>
            <li><a class="postlink"  href="pedirview.php?value=<?php echo $dealvalue;?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="dirdealdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
            </ul></div> 	
    <div class="view-detailed"> 
         <div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]; ?></h2>
            <a  class="postlink" id="previous" href="javascript: history.go(-1)">< Back</a>
        </div> 
                        
  <div class="profilemain">
                <h2>Deals Info  <span style="float: right;font-size: 12px;font-weight: normal;">Updated on : <?php echo $myrow["modifieddate"];?></span> </h2>
                <div class="profiletable">

               <ul>

                 <li><h4>Deal Amount(US$M)</h4><p><?php
                    if($hideamount >0)
                    {
                        echo $hideamount;
                    }
                    else
                    {
                     echo "--";
                    }?></p></li>
                 <li><h4>Stake (%)</h4><p><?php echo $hidestake;?></p></li>
                 <li><h4>Deal Type</h4><p><?php echo $myrow["MADealType"];?></p></li>
                 <li><h4>Date</h4><p><?php echo  $myrow["dt"];?></p></li>
                 <?php
                    if($dec_company_valuation >0)
                    {
                    ?>
                    <li><h4> Company Valuation - Enterprise Value (INR Cr)</h4><p><?php echo $dec_company_valuation;?></p></li>
                    <?php
                    }

                    if($dec_revenue_multiple >0)
                    {
                    ?>
                    <li><h4>Revenue Multiple (based on Equity Value)</h4><p><?php echo $dec_revenue_multiple ;?></p></li>
                    <?php
                    }

                    if($dec_ebitda_multiple >0)
                    {
                    ?>
                    <li><h4>EBITDA Multiple (based on Equity Value)</h4><p><?php echo $dec_ebitda_multiple ;?></p></li>
                    <?php
                    }

                    if($dec_pat_multiple >0)
                    {
                    ?>
                   <li><h4>PAT Multiple (based on Equity Value)</h4><p><?php echo $dec_pat_multiple ;?></p></li>
                    <?php
                    }
                    if(trim($myrow["Valuation"])!="")
                    {
                    ?>
                    <li><h4>Valuation (More Info)</h4><p>			
                    <?php

                    foreach($valuationdata as $valdata)
                    {
                            if($valdata!="")
                            {
                                    print nl2br($valdata);
                            }
                    }
                    }
                    ?></p></li>
                  </ul>

                </div>
                </div>
    
        <div class="postContainer postContent masonry-container">
            <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                     <?php
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";
				$finlink=$myrow["FinLink"];
				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
				<td width="120"><h4>Company</h4> <p><?php echo $openBracket;?><?php echo rtrim($myrow["companyname"]);?><?php echo $closeBracket ; ?>
				</p></td>
		<?php
				}
				else
				{
					$webdisplay=$myrow["website"];
		?>
				<td  ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>
                        <?php if($target_listing_stauts_display!=""){ ?><td><h4>Company Type</h4> <p><?php echo $target_listing_stauts_display;?></p></td><?php } ?></tr>
                        <tr><?php if($myrow["industry"]!=""){ ?><td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td>
                        <?php } if($myrow["sector_business"]!=""){ ?><td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td><?php } ?></tr>
                        <tr><?php if($myrow["TargetCity"]!=""){ ?><td><h4>City (Target)</h4> <p><?php echo $myrow["TargetCity"];?></p></td>
                        <?php } if($myrow["TargetCountry"]!=""){ ?><td><h4>Country (Target)</h4> <p><?php echo $myrow["TargetCountry"];?></p></td><?php } ?></tr>
                        <?php if($myrow["website"]!=""){ ?><tr><td colspan="2"><h4>Website</h4> <p><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo  $myrow["website"]; ?></a></td></tr> <?php } ?>
                       <?php  foreach ($linkstring as $linkstr)
					{
						if(trim($linkstr)!=="")
						{ $showlink=1;
                                                }
                                        }
					?> 
                          <?php if($showlink==1){ ?> <tr><td colspan="2"><h4>Links</h4> <p style="word-break: break-all;">
                                <?php
					 foreach ($linkstring as $linkstr)
					{
						if(trim($linkstr)!=="")
						{
					?>
						<a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a>
				<?php
						}
					}
				?>   
                       </p>	</td></tr> <?php } ?>
                     
                    </table>
            </div>
      <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Acquirer Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody>
                        <tr><td><h4>Acquirer</h4><p>
                        <?php  if(($compResult3==0) &&  ($compResult4==0) &&  ($compResult5==0))
                         {
         ?>
                         <b>
                         <a class="postlink" href='diracquirer.php?value=<?php echo $myrow["AcquirerId"];?>/<?php echo $dealvalue;?>' >
                         <?php echo rtrim($myrow["Acquirer"]);?>
                         </a>
                         </b>
         <?php
                         }
                         elseif($compResult4==1)
                         {
                                 $webdisplay="";
         ?>
                         <b><?php echo ucfirst("$searchString4ForDisplay") ;?></b>
         <?php
                         }
                         elseif($compResult3==1)
                         {
                                         $webdisplay="";
                         ?>
                            <b><?php echo ucfirst("$searchString") ;?></b>
                         <?php
                         }
                         elseif($compResult5==1)
                         {
                                         $webdisplay="";
                         ?>
                                         <b><?php echo ucfirst("$searchString3") ;?></b>
                         <?php
                         }
                         ?>
			</td>
                         <?php if($acquirer_listing_stauts_display!=""){ ?><td><h4>Acquirer Company Type</h4><p><?php echo $acquirer_listing_stauts_display ;?></p><?php } ?></td></tr>

                        <tr> <?php if($Acquirercityname!=""){ ?><td><h4>City (Acquirer)</h4><p><?php echo $Acquirercityname;?></p></td>
                        <?php } if($Acquirercountryname!=""){ ?><td><h4>Country (Acquirer)</h4><p><?php echo $Acquirercountryname;?></p></td> <?php } ?>
                        </tr>               
                         </tbody>
                    </table>
                    </div>   
            <?php
            if($rscomp= mysql_query($advcompanysql))
                {
                     $comp_cnt = mysql_num_rows($rscomp);
                }
                if($comp_cnt>0)
                {
                 ?>
             <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Advisor Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody>       
                    <tr><td><h4>Advisor Target</h4><p>
                                
                    <?php
                            if ($getcompanyrs = mysql_query($advcompanysql))
                            {
                            While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                            {
                    ?>

                            <A class="postlink" href='diradvisor.php?value=<?php echo $myadcomprow["CIAId"];?>/<?php echo $dealvalue;?>' >
                            <?php echo $myadcomprow["cianame"]; ?> (<?php echo $myadcomprow["AdvisorType"];?>)
                            </a><br>
                    <?php
                            }
                            }
                    ?>
               </p></td></tr>
                    <?php
             
		
                if($rsinvcomp= mysql_query($adacquirersql))
                {
                     $compinv_cnt = mysql_num_rows($rsinvcomp);
                }

                if($compinv_cnt>0)
                {
                    ?>
                    <tr><td><h4>Advisor - Acquirer</h4><p>
                    <?php
                              if ($getinvestorrs = mysql_query($adacquirersql))
                              {
                              While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                              {
                      ?>
                              <A href='maadvisor.php?value=<?php echo $myadinvrow["CIAId"];?>' >
                              <?php echo $myadinvrow["cianame"]; ?> (<?php echo $myadinvrow[3];?>)
                              </a><br>
                      <?php
                              }
                              }
                      ?>
                    </p></td></tr>
                    <?php
                }
				?> </tbody>
                    </table>
                    </div>  
                   <?php
                }?>
           <?php if($dec_company_valuation >0 || $dec_revenue_multiple >0 || $dec_ebitda_multiple > 0 || $dec_pat_multiple > 0 || trim($myrow["Valuation"])!=""){?>
<!--     		<div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>Exits Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                  		 <?php
							if($dec_company_valuation >0)
							{
							?>
							<tr><td><h4>Company Valuation - Equity - Post Money (INR Cr) 
							</h4><p><?php echo $dec_company_valuation ;?></p></td>
							 <?php
							}
						
							if($dec_revenue_multiple >0)
							{
							?>
							<td><h4>&nbsp;Revenue Multiple (based on Equity Value / Market Cap)
							</h4><p><?php echo $dec_revenue_multiple ;?></p></td>
							 <?php
							}
						
							if($dec_ebitda_multiple >0)
							{
							?>
							<td ><h4>&nbsp;EBITDA Multiple (based on Equity Value)
							</h4><p><?php echo $dec_ebitda_multiple ;?></p></td></tr>
							 <?php
							}
						
							if($dec_pat_multiple >0)
							{
							?>
							<tr><td ><h4>PAT Multiple (based on Equity Value)
							 </h4><p><?php echo $dec_pat_multiple ;?></p></td>
							 <?php
							}
							
							?>
						<?php if(trim($myrow["Valuation"])!="")
						{
						?>
						<td ><h4>&nbsp;Valuation (More Info)
						 </h4><p>
						
						<?php
							foreach($valuationdata as $valdata)
							{
								if($valdata!="")
								{
						?>
						   <?php print nl2br($valdata);?><br/>
						<?php
								}
							}
						?>
						</p></td></tr>
						<?php
						}
						?>
                  </table>
           </div>     -->
    	   <?php } ?>   
          	
           <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-MandA&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like and we will revert with the data points as available.
                              </p></td></tr></table>
           </div>
                </div>	
                
                
</div>



    </div>
  
</td>

 

</tr>
</table>
 
</div>
</form>
<form name=companyDisplay id="companyDisplay" method="post" action="exportMA.php">
      <input type="hidden" name="txthideMAMAId" value="<?php echo $SelCompRef;?>" >
      <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>

<div class=""></div>

</div>
 

 <script type="text/javascript">
                 $("a.postlink").click(function(){
                  
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
                function resetinput(fieldname)
                {
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  hrefval= 'index.php';
                  $("#pesearch").attr("action", hrefval);
                  $("#pesearch").submit();
                    return false;
                }
                 $('.export').click(function(){ 
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();   
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
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
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
       $("#companyDisplay").submit();
       $('#preloading').fadeOut(1000);  
        
    });
    
    $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
                                        
</script> 
<?php mysql_close(); ?>