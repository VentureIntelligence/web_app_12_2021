<?php include_once("../globalconfig.php"); ?>
<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('machecklogin.php');
	$mailurl= curPageURL();	
        $notable=false;
        print_r($_POST);
        
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
        
	$topNav = 'Deals'; 
	include_once('maheader_search.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 </form>
 <form name=companyDisplay method="post" action="exportacquirerProfile.php">
 <?php
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $SelCompRef=$value;
	$AcqId=	$value;
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
					
  	$sql="select ac.*,c.country from acquirers as ac,country as c
         where AcquirerId=$AcqId and ac.CountryId=c.countryid ";

	$mandasql="select peinv.MAMAId,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,peinv.AcquirerId,
                    peinv.PECompanyId,c.companyname,c.industry,i.industry as indname,inv.*
                    from acquirers as inv,mama as peinv,pecompanies as c,industry as i
                    where inv.AcquirerId=$AcqId and peinv.AcquirerId=inv.AcquirerId
                    and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
                    and c.industry $industryvalue
                    order by DealDate desc";
        
	$indSql= " SELECT DISTINCT i.industry AS ind, c.industry
		FROM pecompanies AS c, mama AS peinv, industry AS i
		WHERE peinv.AcquirerId =$AcqId
		AND c.PECompanyId = peinv.PECompanyId
		AND i.industryid !=15
		AND i.industryid = c.industry
		ORDER BY i.industry";
        
        $strIndustry="";
	if($rsInd= mysql_query($indSql))
	{
		While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
		{
			$strIndustry=$strIndustry.", ".$myIndrow["ind"];
		}
		$strIndustry =substr_replace($strIndustry, '', 0,1);
	}
		
		if ($companyrs = mysql_query($sql))
		{  ?>
                      <input type="hidden" name="txthideAcqId" value="<?php echo $AcqId;?>" >
                      <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
                        
                    <? if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
                    {
                        
                       $AcIndustry=$myrow["IndustryId"];

			$Address1=$myrow["Address"];
			$Address2=$myrow["Address1"];
			$sector=$myrow["Sector"];
			$AdCity=$myrow["CityId"];
			$stockcode=$myrow["StockCode"];
			$Zip=$myrow["Zip"];
			$Tel=$myrow["Telephone"];
			$Fax=$myrow["Fax"];
			$Email=$myrow["Email"];
			$website=$myrow["Website"];
			$country=$myrow["country"];
			$other_location=$myrow["OtherLocations"];
			$AddInfo=$myrow["AdditionalInfor"];
		;

			$acqIndustrySql="select industry from industry where industryid=".$AcIndustry;
			if ($rsindrow = mysql_query($acqIndustrySql))
			{
				if($myindrow=mysql_fetch_array($rsindrow,MYSQL_BOTH))
				{
					$acquirerIndustry=$myindrow["industry"];
				}
			}

			$onMgmtSql="select pec.AcquirerId,mgmt.AcquirerId,mgmt.ExecutiveId,
							exe.ExecutiveName,exe.Designation,exe.Company from
							acquirers as pec,executives as exe,acquirer_management as mgmt
					where pec.AcquirerId=$AcqId and mgmt.AcquirerId=pec.AcquirerId and exe.ExecutiveId=mgmt.ExecutiveId";


	     
                        }
		}
	 ?>
            <td class="profile-view-left" style="width:100%;">
                <div class="result-cnt"> 
                                    <?php/*- if ($accesserror==1){?>
                                    <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php" target="_blank">Click here</a></b></div>
                        <?php
                                exit; 
                                } */
                        ?>                               
             
                <?php 
                if(($exportToExcel==1))
                   {
                   ?>
                                   <div class="title-links">
                                                   <input class="export" type="submit"  value="Export" name="showprofile">
                                   </div><br>

                   <?php
                   }
              ?>  
    <div class="list-tab mt-list-tab"><ul>
            <li><a class="postlink"  href="<?php echo $actionlink; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="madealdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
            </ul></div> 	
    <div class="view-detailed"> 
         <div class="detailed-title-links"> <h2>  <?php echo $myrow["Acquirer"]; ?></h2>
         <?php     $backlink=$_SERVER["HTTP_REFERER"];
    if ($backlink!='') {?> <a  class="postlink" id="previous" href="<?php echo $backlink; ?>">< Back</a><?php } ?> 
    </div>
     <?php if($myrow["Acquirer"]!="" || $acquirerIndustry!="" || $website!="" ||  ltrim($strIndustry)!="") { ?>                   
    <div class="profilemain">
        <h2>Acquirer Info  </h2>
        <div class="profiletable">
            <ul>
                <li><h4>Acquirer</h4><p><?php  echo $myrow["Acquirer"];?></p></li>
                <li><h4>Industry (Acquirer)</h4><p><?php echo $acquirerIndustry;?></p></li>
                <li><h4>Website</h4> <p><a href=<?php echo $website; ?> target="_blank"><?php echo  $website; ?></a></p></li>
                <li><h4> Industry (Existing Targets')</h4><p><?php echo ltrim($strIndustry);?></p></li>
            </ul>
        </div>
    </div>
    <?php
     }
         if ($getcompanyinvrs = mysql_query($mandasql))
                {
                     $comp_cnt = mysql_num_rows($getcompanyinvrs);
                }
                if($comp_cnt>0)
                {
    ?>
        <div class="postContainer postContent masonry-container">
            <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Acquirer Details</h2>
                    <table width="100%" cellpadding="0" cellspacing="0" class="tableview">
                    <tbody> 
                     <tr><td><h4>Targets</h4><p> 
                    <?php

                            if ($getcompanyinvrs = mysql_query($mandasql))
                            {
                            While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
                            {
                            $companyName=trim($myInvestrow["companyname"]);
                                    $companyName=strtolower($companyName);
                                    $compResult=substr_count($companyName,$searchString);
                                    $compResult1=substr_count($companyName,$searchString1);
                                    if(($compResult==0) && ($compResult1==0))
                                    {
                                        echo $myInvestrow["companyname"];
                                    }
                                    else
                                    {
                                         echo ucfirst("$searchString") ;
                                    }
                            ?>
                                            (<?php echo $myInvestrow["indname"];?>; <a href="madealdetails.php?value=<?php echo $myInvestrow["MAMAId"];?>">
                                            <?php echo $myInvestrow["dealperiod"];?> </a>)<br>
                            <?php
                            }
                            }
                          ?>
                          </p></td></tr>   
                    </table>
            </div>   </div>	
        
        <?php
                }
                ?>       
</div>
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
                  hrefval= 'maindex.php';
                  $("#pesearch").attr("action", hrefval);
                  $("#pesearch").submit();
                    return false;
                }
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