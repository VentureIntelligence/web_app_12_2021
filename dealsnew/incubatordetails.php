<?php
        require("../dbconnectvi.php");
	$Db = new dbInvestments();
         include('checklogin.php');
	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);

        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);

	$incbuatorId=$strvalue[0];
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
            $flagvalue=$strvalue[1];
        }
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
        $sql="select i.*,incftype.IncTypeName from incubators as i,incfirmtypes as incftype where IncubatorId=$incbuatorId and incftype.IncFirmTypeId=i.IncFirmTypeId";
    
	$topNav = 'Deals'; 
	include_once('incheader_search.php');
?>     


<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

 <td class="left-td-bg">
      <div class="acc_main">
          <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
<div id="panel" style="display:block; overflow:visible; clear:both;">

<?php 

       include_once('increfine.php');
?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
      </div>
</td>
</form>
<form name="incubatordetails" method="post" action="exportincubatorprofile.php">

<td class="profile-view-left" style="width:100%;">
    <div class="result-cnt"> 
			<?php if ($accesserror==1){?>
                        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
            <?php
                    exit; 
                    } 
            ?>                               
                        <div class="result-title" > 
               
                        <?php
		if(($exportToExcel==1))
		{
		?>
				<span style="float:left;" class="one" >  <input class="senddeal" type="button" id="senddeal" value="Send this incubator profile to your colleague" name="senddeal">
                                    <input style="margin-left: 5px;" type="submit" class="export_new"  value="Export" name="showprofile">
				</span>

		<?php
		}
		?>
    </div>
     <?php if ($rsinvestors = mysql_query($sql))
                            { ?>
                                <input type="hidden" name="txthideincubatorid" value="<?php echo $incbuatorId;?>" >
		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
                        <?php
                        if($myrow=mysql_fetch_array($rsinvestors,MYSQL_BOTH))
                        {
                                $incubatorname=$myrow["Incubator"];
                                $incType=$myrow["IncTypeName"];
                                $Address1=$myrow["Address1"];
                                $Address2=$myrow["Address2"];
                                $AdCity=$myrow["City"];
                                $Zip=$myrow["Zip"];
                                $Tel=$myrow["Telephone"];
                                $Fax=$myrow["Fax"];
                                $Email=$myrow["Email"];
                                $website=$myrow["website"];
                                $no_funds=$myrow["FundsAvailable"];
                                $AddInfo=$myrow["AdditionalInfor"];
                                $management=$myrow["Management"];
                                $google_sitesearch="https://www.google.co.in/search?q=".$incubatorname."+site%3Alinkedin.com";
                        ?>
                            
                     <br><br><br><br><div class="list-tab"><ul>
                        <li class="active"><a id="icon-detailed-view" class="postlink" href="dealdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
                        </ul></div> 
<div class="view-detailed"> 
         <div class="detailed-title-links"> <h2> <?php echo $incubatorname;?></h2>
                            <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a>
       
                    </div>
                        
  <div class="profilemain">

 <h2>Incubator Profile</h2>
 <div class="profiletable" style="position:  relative;">
      <?php $linkedinSearchDomain=  str_replace("http://www.", "", $website); 
       $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
        if(strrpos($linkedinSearchDomain, "/")!="")
        {
           $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
        }
    if($linkedinSearchDomain!=""){ ?>
     <img src="images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;">
  <div class="linkedin-bg">

     <script type="text/javascript" > 
            
            $(document).ready(function () {
        $('#lframe,#lframe1').on('load', function () {
            $('#loader').hide();
            
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


   
        <script type="text/javascript" src="//platform.linkedin.com/in.js">
        api_key:65623uxbgn8l
        onLoad: onLinkedInLoad
        </script>
        <script type="text/javascript" > 
        var idvalue;
         //document.getElementById("sa").textContent='asdasdasd'; 
        function onLinkedInLoad() {
           var profileDiv = document.getElementById("sample");

               var url = "/companies?email-domain=<?php echo $linkedinSearchDomain ?>";

                console.log(url);
            
                IN.API.Raw(url).result(function(response) {   

                    console.log(response);
                    //var id = response.id;
                   // alert(id);
                    console.log(response._total);
                    var arrayValues=response.values;
                    console.log(arrayValues);

                    var value=arrayValues[0];
                    console.log(value);
                    console.log(value.id);
                    console.log(value.name);
                    idvalue=value.id;
                    if(idvalue)
                    {
                    //$('#dataId').val(idvalue);
                    //var inHTML = '<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                   var inHTML='loadlinkedin.php?data_id='+idvalue;
                    var inHTML2='linkedprofiles.php?data_id='+idvalue;
                    $('#lframe').attr('src',inHTML);
                    $('#lframe1').attr('src',inHTML2);
                    }
                    else
                        {
                             $('#lframe').hide();
                             $('#lframe1').hide();
                             $('#loader').hide();
                        }
                        
                    //  profileDiv.innerHtml=inHTML;
                    //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                }).error( function(error){
                    
                   $('#lframe').hide();
                   $('#lframe1').hide();
                   $('#loader').hide(); });
          }


        </script>
    <div  id="sample" style="padding:10px 10px 0 0;">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="220"></iframe>
    </div>

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
   <div class="fl" style="padding:10px 10px 0 0;"><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="300" ></iframe></div>  
       <?php } ?>
                <ul>
                 <?php 
                  if($incType!="") { ?>                                        
                        <li><h4>Firm Type  </h4><p> <?php echo $incType;?></p></li>
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
                  if (($Zip != "") || ($Zip > 0)) 
                      { ?>
                  <li><h4>Zip     </h4><p> <?php echo $Zip; ?></p></li>
                   <?php
                }
                 if (($Tel != "") || ($Tel > 0)) {
                   ?>
                  <li><h4>Telephone    </h4><p><?php echo $Tel; ?></p></li>
                <?php
                 }
                if (trim($Email) != "") {
                    ?>
                  <li><h4>Email    </h4><p><?php echo $Email; ?> </p></li> 
                   <?php
                    }
                  if($no_funds!="") 
                  { ?>
                  <li><h4>Funds Available    </h4><p><?php echo $no_funds;?></a></p></li>
                   <?php
                    } if((trim($management)!="") && ($management!= " "))
                  { ?>
                  <li><h4>Management    </h4><p><?php echo $management;?></p></li>
                   <?php
                    }?>
                    
                  
                   </ul>
 
 </div>
 </div> 
    
 <div class="postContainer postContent masonry-container">
     
  
     <?php
     $Investmentsql="select inc.IncDealId,inc.IncubatorId,inc.IncubateeId,pec.Companyname,inc.Individual,i.industry AS indname,DATE_FORMAT( date_month_year, '%M-%Y' ) as dt
					from incubatordeals as inc, pecompanies as pec,industry AS i  where inc.IncubatorId=$incbuatorId and 
                                        inc.IncubateeId=pec.PEcompanyId and i.industryid = pec.industry order by Companyname";
                                   if($getcompanyinvrs= mysql_query($Investmentsql))
				   {
				     $inv_cnt = mysql_num_rows($getcompanyinvrs);
				     }
				     if($inv_cnt >0)
				     {
     ?>
     <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Incubatee</h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Company Name</th><th>Industry Name</th> <th class="deal-period">Deal Period</th> </tr></thead>
      <tbody>
           <?php
                        While($ipmyrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
                        {

                                if($ipmyrow["Individual"]==1)
                                {
                                        $openBracket="(";
                                        $closeBracket=")";
                                }
                                else
                                {
                                        $openBracket="";
                                        $closeBracket="";
                                }


                        ?>
                <tr>
                   <td>
                 
                           <?php echo $openBracket ; ?><a href='incdealdetails.php?value=<?php echo $ipmyrow["IncDealId"];?>' ><?php echo $ipmyrow["Companyname"]; ?></a>
                  <?php echo $closeBracket ; ?><br/>               
                      
                         
          
               
                </td>
                <td>
                 <a href='incdealdetails.php?value=<?php echo $ipmyrow["IncDealId"];?>' > <?php echo $ipmyrow["indname"]; ?></a>
                </td>
                 <td>
                  <a href='incdealdetails.php?value=<?php echo $ipmyrow["IncDealId"];?>' ><?php echo $ipmyrow["dt"]; ?></a>
                </td>
               
              </tr>
             <?php
                              }
                        ?>
       </tbody>
       </table>
        </div>
                                     <?php } ?>
     
     
        <?php if(($AddInfo!="") && ($AddInfo!=" ")) { ?>
     <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Additional Information</h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
        <tr>
            <td><p><?php echo $AddInfo;?></p></td> 
        </tr>
       </tbody>
       </table>
     </div>
    <?php } ?>
</div>                                        
</div> 
  
    
    <div class="lb" id="popup-box">
    <div class="title">Send this to your Colleague</div>
    
        <div class="entry">
                <label> To</label>
                <input type="text" name="toaddress" id="toaddress"  />
        </div>
        <div class="entry">
                <h5>Subject</h5>
                <p>Checkout this profile - <?php echo  $incubatorname; ?> - in Venture Intelligence</p>
                <input type="hidden" name="subject" id="subject" value="Checkout this profile - <?php echo  $incubatorname; ?> - in Venture Intelligence"  />
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
                
            <?php
	    mysql_close();
    mysql_close($cnx);
    ?>