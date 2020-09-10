<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
         $videalPageName="Inc";  
	include('checklogin.php');
        $mailurl= curPageURL();
        $notable=false;
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        if(sizeof($strvalue)>1)
        {   
        $flagvalue=$strvalue[1];
        $VCFlagValue=$strvalue[1];
        }
        else
        {
        $flagvalue=6;
        $VCFlagValue=6;
        }
        $dealvalue=$strvalue[2];
        $vcflagValue=$strvalue[1];
                 $keyword=($_POST['keywordsearch']);             
                 $companysearch=$_POST['companysearch'];
                 $searchallfield=trim($_POST['searchallfield']);
                $industry=trim($_POST['industry']);
                $incfirmtype=trim($_POST['txtfirmtype']);
                 $status=trim($_POST['statusid']);
               
                 if($resetfield=="chkDefunct")
                { 
                  $_POST['chkDefunct']="";
                  $defunctflag=1;
                  $addDefunctqry="";
                }
                else 
                {
                  $defunctflag=0;
                  $addDefunctqry=" and Defunct=0 ";
                 
                }
                
                 $followon=trim($_POST['followonFund']);
                 $regionIdd=trim($_POST['txtregion']);
                   if($industry >0)
                {
                    $industrysql= "select industry from industry where IndustryId=$industry";
                    if ($industryrs = mysql_query($industrysql))
                    {
                            While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                            {
                                    $industryvalue=$myrow["industry"];
                            }
                    }
                }
   		if($status >0)
		{
		$statussql= "select StatusId,Status from incstatus where StatusId=$status";
    		if ($stagers = mysql_query($statussql))
			{
				While($mysrow=mysql_fetch_array($stagers, MYSQL_BOTH))
				{
					$statusvalue=$mysrow["Status"];
				}
			}
		}
		if($incfirmtype >0)
		{
			$incfirmsql= "select IncFirmTypeId,IncTypeName from incfirmtypes where IncFirmTypeId=$incfirmtype";
    		if ($incrs = mysql_query($incfirmsql))
                {
                        While($myincrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                        {
                                $inctype=$myincrow["IncTypeName"];
                        }
                }
		}
		if($defunctflag==1)
                {   $defunctText= "Excluded Defunct Cos"; }
                else
                {     $defunctText= "Included Defunct Cos"; }
		if($regionId >0)
			{
			$regionSql= "select Region from region where RegionId=$regionId";
					if ($regionrs = mysql_query($regionSql))
					{
						While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$regionvalue=$myregionrow["Region"];
						}
					}
		}
                if($followonFund =="--")
                {
                    $followonFundText="";
                }
                elseif($followonFund=="1")
                {
                    $followonFundText="Follow on Funding";
                }
                elseif($followonFund=="2")
                {
                    $followonFundText="No Funding";
                }

	$topNav = 'Directory';
	include_once('dirnew_header.php');
?>


<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
   
</form>
<form name="incubatordeal" id="incubatordeal"  method="post" action="exportincdealinfo.php">
 <?php
                $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
		//	$SelCompRef=$value;
		$strvalue = explode("/", $value);
                $SelCompRef=$strvalue[0];
		$searchstringhighlight=$strvalue[1];
		
		
		//GET PREV NEXT ID
		$prevNextArr = array();
		$prevNextArr = $_SESSION['incubateedealId'];
		
		$currentKey = array_search($SelCompRef,$prevNextArr);
		$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
		$nextKey = $currentKey+1;
		
		
	//	echo "<Br>---" .$SelCompRef;
		$exportToExcel=0;
                $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
                //echo "<br>---" .$TrialSql;
                if($trialrs=mysql_query($TrialSql))
                {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                                $studentOption=$trialrow["Student"];
                        }
                }


               // print_r($_POST);
  	$sql="SELECT pe.IncubateeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                pec.website, pec.AdCity,
                pec.region,MoreInfor,pe.IncubatorId,inc.Incubator,pec.RegionId,
                pe.StatusId,pec.yearfounded,Individual,s.Status ,FollowonFund,DATE_FORMAT( date_month_year, '%M-%Y' ) as dt
                FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,
                incubators as inc,incstatus as s
                WHERE pec.industry = i.industryid
                AND pec.PEcompanyID = pe.IncubateeId and pe.Deleted=0 and pec.industry !=15
                and pe.IncDealId=$SelCompRef and s.StatusId=pe.StatusId
                and inc.IncubatorId=pe.IncubatorId ";
	//echo "<br>********".$sql;
  	if ($companyrs = mysql_query($sql))
        {
           ?>
		<input type="hidden" name="txthideIncDealId" value="<?php echo $SelCompRef;?>" >
		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
	<?php
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
			if($myrow["Individual"]==1)
			{
				$openBracket="(";
				$closeBracket=")";
			}
			else
			{
				$openBracket="";
				$closeBracket="";
			}
			$regionId=$myrow["RegionId"];
			if($regionId>0)
			{
				$getRegionSql="select Region from region where RegionId=$regionId";
				if ($rsregion = mysql_query($getRegionSql))
				{
					While($regionrow=mysql_fetch_array($rsregion, MYSQL_BOTH))
					{
						$regiontext=$regionrow["Region"];
					}
				}
			}
			else
				{$regiontext=$myrow["Region"];
			}


			if($myrow["yearfounded"] >0)
				$yearfded=$myrow["yearfounded"];
			else
				$yearfded="";
				
			if($myrow["FollowonFund"]==1)
			{    $followonFunding="Yes";}
			else
			{    $followonFunding="No";}

                         $moreinfor=$myrow["MoreInfor"];
                         $string = $moreinfor;
	          //echo "<Br>---" .$searchstringhighlight;
	          if($searchstringhighlight!="")
	          {
			/*** an array of words to highlight ***/
			$words = array($searchstringhighlight);
			//$words="warrants convertible";
			/*** highlight the words ***/
			$moreinfor =  highlightWords($string, $words);
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
        ?>

        <div class="result-title">
            
                <?php if(!$_POST)
                    {   
                    ?>
            <h2>
            <?php
            if($studentOption==1 || $exportToExcel==1)
            {
         ?>
              <span class="result-no"><?php echo count($prevNextArr); ?> Results Found</span> 
            <?php   } 
            else 
            {
          ?>
                 <span class="result-no"> XXX Results Found</span> 
            <?php
            } 
            ?>
            <span class="result-for">  for Incubation Investments</span>
            </h2>
           <?php
            if(($exportToExcel==1))
            {
            ?>
                            <div class="title-links">
                                  <input class="senddeal" type="button" id="senddeal" value="Send this profile to your colleague" name="senddeal">
                                    <input class="export" type="button"  value="Export" name="showdeal">
                            </div>

            <?php
            }
            ?>               
            <?php 
            }
            else 
            {
               ?>
            <h2>
             <?php
            if($studentOption==1 || $exportToExcel==1)
            {
         ?>
              <span class="result-no"><?php echo count($prevNextArr); ?> Results Found</span> 
            <?php   } 
            else 
            {
          ?>
                 <span class="result-no"> XXX Results Found</span> 
            <?php
            } 
            ?>
            <span class="result-for">  for Incubation Investments</span>
            </h2>
            <?php
            if(($exportToExcel==1))
            {
            ?>
                            <div class="title-links">
                                  <input class="senddeal" type="button" id="senddeal" value="Send this profile to your colleague" name="senddeal">
                                            <input class="export" type="button"  value="Export" name="showdeal">
                            </div>

            <?php
            }
            
            ?> 
            <?php if(($industry >0 && $industry!=null && $industry!="--")
                    ||($status>0 && $status!="--")
                    ||($defunctflag==0)
                    ||($incfirmtype >0 && $incfirmtype !="")
                    ||($followonFund!="--" && $followonFund!="")
                    ||($regionIdd>0 && $regionIdd!="" && $regionIdd!=NULL)
                    ||($keyword!=" " && $keyword!="")
                    ||($companysearch!=" " && $companysearch!="")
                    ||($searchallfield!="")){ $cls="mt-list-tab"; ?>
                    <?php }else { $cls="mt-list-tab-directory";} } ?>
  </div>
        
    
    <div class="list-tab <?php echo ($cls!="")?$cls:"mt-list-tab-directory"; ?>"><ul>
            <li><a class="postlink"  href="pedirview.php?value=<?php echo $searchstringhighlight;?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="dirincinfo.php?value=<?php echo $SelCompRef;?>/<?php echo $searchstringhighlight;?>/<?php echo $dealvalue;?>"><i></i> Detail View</a></li> 
            </ul></div> 	
    <div class="view-detailed"> 
         <!--div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]; ?></h2-->
             <div class="detailed-title-links"><h2> <A class="postlink" href='companydetails.php?value=<?php echo $myrow["IncubateeId"];?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="dirincinfo.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $vcflagValue."/".$dealvalue;?>/">< Previous</a><?php } ?> 
        <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="dirincinfo.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $vcflagValue."/".$dealvalue;?>/"> Next > </a>  <?php } ?>
                    </div>
        <div class="postContainer postContent masonry-container">
  <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                     <?php
                                
                                 if (is_null($myrow["dt"]))
		                 { $yearfded=""; }
		                 else
				  { $yearfded=$myrow["dt"]; }
                                  
                                
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";
				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
				<td width="120"><h4>Company</h4> <p> <?php echo $openDebtBracket;?><?php echo $openBracket;?><A class="postlink" href='dircomdetails.php?value=<?php echo $myrow["IncubateeId"].'/'.$vcflagValue.'/'.$dealvalue;?>' >
				<?php echo rtrim($myrow["companyname"]);?></a><?php echo $closeBracket;?><?php echo $closeDebtBracket;?>
				</p></td>
		<?php
				}
				else
				{
					$webdisplay="";
		?>
				<td  ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>
                               <?php if($myrow["industry"]!="") { ?><td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td>  <?php } ?>
                        </tr>
                        <tr><?php if($myrow["sector_business"]!="") { ?><td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td><?php } if(trim($myrow["AdCity"])!="") { ?><td><h4>City</h4> <p><?php echo  $myrow["AdCity"];?></p></td><?php } ?>
                        <tr><?php if($myrow["region"]!="") { ?><td><h4>Region</h4> <p><?php echo ($myrow["region"])?$myrow["region"]:"-";?></p></td><?php } if($webdisplay!="") { ?><td colspan="2"><h4>Website</h4> <p style="word-break: break-all;"><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></p>	</td><?php } ?></tr>
                        <tr><?php if(rtrim($myrow["Incubator"])!="") { ?><td ><h4>Incubator</h4> <p><A href='dirincdetails.php?value=<?php echo $myrow["IncubatorId"].'/'.$vcflagValue.'/'.$dealvalue;?>' >
												<?php echo rtrim($myrow["Incubator"]);?></a></p>	</td> <?php } ?>
                          <?php
                                 if ($yearfded!="") { 
                                 ?>
                       <td colspan="2"><h4>Deal Date</h4> <p><?php echo $yearfded;?></p>	</td></tr>
                                 <?php } ?>
                        
                        <tr><?php if($myrow["Status"]!="") { ?><td ><h4>Status</h4> <p><?php echo $myrow["Status"] ;?></p></td><?php } if($followonFunding!="") { ?><td ><h4>Follow on Funding</h4> <p><?php echo $followonFunding;?></p></td> <?php } ?></tr>
                       
                     
                    </table>
                    </div> 
        
        
        
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                              </p></td></tr></table>
                                                                 
        </div>
   
    </div>
    </div>
				<?php
					if(($exportToExcel==1))
					{
					?>
<!--							<span style="float:center" class="one">
									<input class="export" type="submit"  value="Export" name="showdeal">
							</span>-->
					<?php
					}
					?>

</td></tr></tbody>

</table>
 <div class="lb" id="popup-box">
    <div class="title">Send this to your Colleague</div>
    <form>
        <div class="entry">
                <label> To</label>
                <input type="text" name="toaddress" id="toaddress"  />
        </div>
        <div class="entry">
                <h5>Subject</h5>
                <p>Checkout this profile- <?php echo $myrow["companyname"]; ?> - in Venture Intelligence</p>
                <input type="hidden" name="subject" id="subject" value="Checkout this profile- <?php echo $myrow["companyname"]; ?> - in Venture Intelligence"  />
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
</div>
<div class=""></div>

</div>
</form>
   <script type="text/javascript">
                $("a.postlink").click(function(){
                   $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                  function resetinput(fieldname)
                {
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  hrefval= 'incindex.php';
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
</script> 
<script>
    $('.export').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });

           
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

                        $("#incubatordeal").submit();
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
        
        
</script>
