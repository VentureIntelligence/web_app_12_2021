<?php
  require_once("reconfig.php");
        
        require_once("../dbconnectvi.php");
        error_reporting(1);
        $Db = new dbInvestments();
  
        $videalPageName="REInv";
        include ('checklogin.php');
       
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
         $newValue = $strvalue[1];
     
         $_SESSION['backtofund']=$_REQUEST['value'];
         
        $sqltype = "select * from fundType where focus='Stage' AND dbtype='RE' "; 
        $sqltype2 = "SELECT `RETypeId`,`REType` FROM realestatetypes";
        $sqlfundstatus = "select * from fundRaisingStatus";
        $sqlfundClosed = "select * from fundCloseStatus";
        $sqlcapitalsrc = "select * from fundCapitalSource";
          
                $fundid = $strvalue[3]; 
                
                $fu_de2 = mysql_fetch_array( mysql_query("SELECT id,moreInfo FROM fundRaisingDetails  WHERE id='$fundid' ")) ; 
                    
                    $fu_de = mysql_fetch_array( mysql_query("SELECT * FROM fundRaisingDetails  fd 
                    LEFT JOIN fundNames fn ON fd.fundName=fn.fundId  
                    LEFT JOIN REinvestors re ON fd.investorId = re.InvestorId
                    LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                    LEFT JOIN realestatetypes fti ON  fd.REsector=fti.RETypeId 
                    LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                    LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                   
                    WHERE fd.id='$fundid' ")) ;
                            
                    function fun_ty($futyid)       {
                     $e = mysql_fetch_array( mysql_query("SELECT * FROM fundType WHERE id='$futyid' "));
                        return $e['fundTypeName'];                
                    }
                    
                    
                    function fun_in($futyid)       {
                     $e = mysql_fetch_array( mysql_query("SELECT `industryid`,`industry` FROM reindustry WHERE industryid='$futyid' "));
                        return $e['industry'];                
                    }
                    

                     function cap_sor($cap_sor)             {
                        $e = mysql_fetch_array( mysql_query("SELECT * FROM fundCapitalSource WHERE id='$cap_sor' "));
                           return $e['source'];                 
                    }

	$defpage=$vcflagValue;
        $investdef=1;
        $stagedef=1;
        $topNav='Fund-details';
        
        $exportToExcel = 0;
    $TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
    //echo "<br>---" .$TrialSql;
    if ($trialrs = mysql_query($TrialSql)) {
        while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
            $exportToExcel = $trialrow["TrialLogin"];
        }
    }
    
	include_once('reindex_search.php');
?>
   
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
<td class="left-td-bg" >
      <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('funds_refine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>
</div>
</td>
	<!-- you can put content here -->


        <td class="profile-view-left" style="width:100%;">
<!--                <div class="result-cnt" style='width:auto; position: relative;'>-->
                    <div style='padding: 20px; position: relative'>
                    <!--div class="result-title">
                       <div class="title-links " id="exportbtn"></div>
                       <br><br/->
                    </div-->
                    <div class="title-links">
                                
                            <input class="senddeal" type="button" id="senddeal" value="Send this Fund Raising info to your colleague" name="senddeal">
                             <?php 

                            if(($exportToExcel==1))
                                 {
                                 ?>
                                     <span id="exportbtn">  <input class="export" type="button" id="expshowdeals" value="Export" name="showdeals">  </span>
                                 <?php
                                 }
                             ?>
                    </div>
                    
                                
                      
                     <div class="list-tab mt-list-tab-directory"><ul>
<!--                        <li><a class="postlink"  href="angelindex.php?value=<?php echo $strvalue[1]; ?>"  id="icon-grid-view"><i></i> List  View</a></li>-->
                        
                                <li ><a id="icon-detailed-view"  class="postlink" href="refunds.php" ><i></i>List View</a></li> 
                        
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
                <p>Checkout this funds- <?php  if($fu_de["fundName"]){ echo $fu_de["fundName"];} else { echo $fu_de["fundManager"]; } ?>  - in Venture Intelligence</p>
                <input type="hidden" name="subject" id="subject" value="Checkout this funds-  <?php  if($fu_de["fundName"]){ echo $fu_de["fundName"];} else { echo $fu_de["fundManager"]; } ?>  - in Venture Intelligence"  />
        </div>
        <div class="entry">
                <h5>Message</h5>
                <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />    <input type="hidden" name="userMail" id="useremail" value="<?php echo $_SESSION['REUserEmail']; ?>"  /> </p>
        </div>
        <div class="entry">
            <input type="button" value="Submit" id="mailbtn" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

</div>                 
<div class="view-detailed">
    
   
                           
<div class="detailed-title-links">   <?php  if($fu_de["fundName"]){ echo "<h2>".$fu_de["fundName"]."</h2>";} else if($fu_de["fundManager"]) { echo "<h2>".$fu_de["fundManager"]."</h2>"; } ?>
    
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
   
     <?php if( $_SESSION['totresu'] == $strvalue[4] && $strvalue[4]>1) { ?> 
     <a  class="postlink" id="previous" href="fund_details.php?value=<?php echo $_SESSION['fundfirsttolast'][$nav_previous]; ?>">< Previous</a> <?php } ?>
     
     <?php if( $_SESSION['totresu'] == $strvalue[4] && $strvalue[4]==1) { ?> 
     <a  class="postlink" id="previous" href="refunds.php" > < Back</a> <?php } ?>
    
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
           
            <?php if(fun_ty($fu_de["REsector"])!= NULL ) { ?>
            <li> <h4>Sector  </h4><p>   <?php $name = $fu_de["REType"];  $name=($name!="")?$name:"Other";  echo $name ; ?> </p></li> 
            <?php } ?>
            
            
            
            <li><h4> Size  </h4><p> <?php echo ($fu_de["size"]!=0) ? $fu_de["size"] : "-";?> </p></li> 
           
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
                            $investordetail = mysql_fetch_array(mysql_query (" SELECT InvestorId,Investor FROM REinvestors WHERE InvestorId='$fu_de[investorId]' ") );
                            ?>
                            
                            <p><a class="postlink" href="reinvestordetails.php?backtofund&value=<?php echo $fu_de['investorId'] ?>/"><?php echo  $investordetail['Investor']?></a><br> </p>
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
       
                    
                    
                    
                    <div class="overview-cnt mt-trend-tab">
        
                       <div class="showhide-link" id="trendnav" style="z-index: 100000"> </div>
                            
                       </div>
          </td>
          
          
          
</tr>
</table>
</div>
</form>



<form name="companyDisplay" id="companyDisplay" method="post" action="exportredealinfo.php">
    <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>">
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>">
</form>


<div class=""></div>
</div>


<form name="funddetails" id="funddetails"  method="post" action="ajax_funddetails_export.php">
        <input type="hidden" name="fundid" value="<?php echo $fundid ?>">
    </form> 

 <script type="text/javascript">
    /*$(".export").click(function(){
        $("#companyDisplay").submit();
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
                                    hrefval= 'ajax_refunddetails_export.php';
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
</script>

           <div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
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

// mysql_close();
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
        initExport();
        return false; 
     });
    
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
</script> 


 <script src="hopscotch.js"></script>
    <script src="demo.js"></script>
      <script type="text/javascript" >
    $(document).ready(function(){       
    
     <?php
    if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){ ?> 
     hopscotch.startTour(tour, 18);   
     <?php }  ?>
           
           
           
            //// multi select checkbox hide
    $('.ui-multiselect').attr('id','uimultiselect');  
    
    $("#uimultiselect, #uimultiselect span").click(function() {
        if(demotour==1)
                {  showErrorDialog("To follow the guide"); $('.ui-multiselect-menu').hide(); }     
    });
    
             
           });
           
        </script>
        <?php  mysql_close();   ?>