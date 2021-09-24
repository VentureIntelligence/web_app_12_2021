<?php include_once("../globalconfig.php"); ?>
<?php
    require_once("maconfig.php");
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    include ('machecklogin.php');
    $mailurl= curPageURL();	
    $notable=false;


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
<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: -10px;">
<tr>
 
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

    // echo $sql; exit;
		
		if ($companyrs = mysql_query($sql))
		{  ?>
                     
                        
                    <?php if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
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
                        $linkedIn=$myrow["linkedIn"];
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
                    <?php 
                    /*- if ($accesserror==1){?>
                    <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php" target="_blank">Click here</a></b></div>
                    <?php
                    exit; 
                    } */
                    $ma_industries = explode(',', $_SESSION['MA_industries']);
                    if(!in_array($AcIndustry,$ma_industries)){

                        echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
                        exit;
                    }
                    ?>                               
            <div class="result-title">    
                <?php 
                if(($exportToExcel==1))
                   {
                   ?>
                        <div class="title-links" style="margin-top: -15px;">
                                 <input class="senddeal" type="button" id="senddeal" value="Send this Acquirer profile to your colleague" name="senddeal"> 
                                 <input class="export" type="button"  value="Export" name="showprofile">
                        </div><br>

                   <?php
                   }
                ?>   
            </div>
    <div class="list-tab mt-list-tab" style="margin-top: 55px !important;"><ul>
            <li><a  href="<?php echo $actionlink; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" href="madealdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
            </ul></div> 	
    <div class="view-detailed"> 
         <div class="detailed-title-links"> <h2>  <?php echo $myrow["Acquirer"]; ?></h2>
         <?php     $backlink=$_SERVER["HTTP_REFERER"];
    if ($backlink!='') {?> <a  class="postlink" id="previous" href="<?php echo $backlink; ?>">< Back</a><?php } ?> 
    </div>
                        
    <div class="profilemain">
        <h2>Acquirer Info  </h2>
        <div class="profiletable" style="position:  relative;">
            
    <?php 
    //echo "dddddddddddddddd".$linkedIn;
    if($linkedIn!=''){ 
         
        $url = $linkedIn;
        $keys = parse_url($url); // parse the url
        $path = explode("/", $keys['path']); // splitting the path
        $companyid = (int)end($path); // get the value of the last element  
    ?>
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
                        }
                        else
                        {
                             $('#lframe').hide();
                             $('#lframe1').hide();
                             $('#loader').hide();
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
               var url ="/company-search:(companies:(id,website-url))?keywords=<?php echo $myrow["Acquirer"] ?>";

                console.log(url);
            
                IN.API.Raw(url).result(function(response) {   
                   
                   // console.log(response);  
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
                   
                   var inHTML='../dealsnew/loadlinkedin.php?data_id='+idvalue;
                    var inHTML2='../dealsnew/linkedprofiles.php?data_id='+idvalue;
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
                   console.log(error);
                   $('#lframe').hide();
                   $('#lframe1').hide();
                   $('#loader').hide(); });
          }


        </script>
   
    <div  id="sample" style="padding:10px 10px 0 0;">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
    </div>

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
   <div class="fl" style="padding:10px 10px 0 0;"><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div>  
       <?php 
        }
    } ?>
            <ul>
                <?php if($myrow["Acquirer"]!=""){ ?><li><h4>Acquirer</h4><p><?php  echo $myrow["Acquirer"];?></p></li> <?php }?>
                 <?php if($acquirerIndustry!=""){ ?><li><h4>Industry (Acquirer)</h4><p><?php echo $acquirerIndustry;?></p></li> <?php }?>
                 <?php if($website!=""){ ?><li><h4>Website</h4> <p><a href='<?php echo $website; ?>' target="_blank"><?php echo  $website; ?></a></p></li> <?php }?>
                 <?php if(ltrim($strIndustry)!=""){ ?><li><h4> Industry (Existing Targets')</h4><p><?php echo ltrim($strIndustry);?></p></li> <?php }?>
                 
                 <?php if ($linkedinSearchDomain != "")   {  ?>
                <li id="viewlinkedin_loginbtn" style="display: none"><h4>View LinkedIn Profile  </h4><p><script type="in/Login"></script></p></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php
    
         if ($getcompanyinvrs = mysql_query($mandasql))
                {
                     $comp_cnt = mysql_num_rows($getcompanyinvrs);
                }
                if($comp_cnt>0)
                {
    ?>
        <div class="postContainer postContent masonry-container">
            <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <!-- <h2>Acquirer Details</h2> -->
                    <h2>List of Deals</h2>
                    <table width="100%" cellpadding="0" cellspacing="0" class="tableview">
                    <tbody> 
                     <tr><th style="border-bottom:none;"><h4>Targets</h4></th></tr>
                    <?php

                            if ($getcompanyinvrs = mysql_query($mandasql))
                            {
                            While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
                            {
                            $companyName=trim($myInvestrow["companyname"]);
                                    $companyName=strtolower($companyName);
                                    $compResult=substr_count($companyName,$searchString);
                                    $compResult1=substr_count($companyName,$searchString1);
                                    /*if(($compResult==0) && ($compResult1==0))
                                    {
                                        echo $myInvestrow["companyname"];
                                    }
                                    else
                                    {
                                         echo ucfirst("$searchString") ;
                                    }*/
                            ?>
                                            <!-- (<?php echo $myInvestrow["indname"];?>; <a href="madealdetails.php?value=<?php echo $myInvestrow["MAMAId"];?>">
                                            <?php echo $myInvestrow["dealperiod"];?> </a>)<br> -->
                                             <tr>   <td>  <span><?php if(($compResult==0) && ($compResult1==0)){echo $myInvestrow["companyname"]." ";}else{echo ucfirst("$searchString")." ";}?></span>(<?php echo $myInvestrow["indname"];?>; <a href="madealdetails.php?value=<?php echo $myInvestrow["MAMAId"];?>">
                                            <?php echo $myInvestrow["dealperiod"];?> </a>)</td></tr> 
                            <?php
                            }
                            }
                          ?>
                         
                    </table>
            </div>   </div>	
        
        <?php
                }
                ?>       
</div>
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
                <p>Checkout this profile - <?php echo rtrim($myrow["Acquirer"]);?> - in Venture Intelligence</p>
                  <input type="hidden" name="subject" id="subject" value="Checkout this profile - <?php echo rtrim($myrow["Acquirer"]);?> - in Venture Intelligence"  />
                  <input type="hidden" name="basesubject" id="basesubject" value="Acquirer profile" />
        </div>
        <div class="entry">
                <h5>Link</h5>
                <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['MAUserEmail']; ?>"  /> </p>
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
</td>
</tr>
</table>
 
</div>
</form>
<form name=companyDisplay id="companyDisplay" method="post" action="exportacquirerProfile.php">
     <input type="hidden" name="txthideAcqId" value="<?php echo $AcqId;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>

<div class=""></div>

</div>
 <style>
    #popup-box{
        top: 6%;
    }
    .entry p{
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>

 <script type="text/javascript">
     
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
                /*$(".export").click(function(){
                    
                     $("#companyDisplay").submit();
                     return false;
                });*/

                $('.export').click(function(){ 
        
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
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

                    if (currentRec < remLimit){
                        $("#companyDisplay").submit();
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
<script src="hopscotch.js"></script>
    <script src="demo.js"></script>
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
                data: { to : $("#toaddress").val(), subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
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
