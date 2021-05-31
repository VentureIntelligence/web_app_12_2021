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
        
	$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $exvalue=  explode('/', $value);
        $SelCompRef=$exvalue[0];
        $dealvalue=$exvalue[1];
        
        if($dealvalue!=''){
            $topNav = 'Directory'; 
            include_once('madir_header.php');
        }else{
	$topNav = 'Deals'; 
	include_once('maheader_search.php');
        }
	
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 
 <?php
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $SelCompRef=$value;
	$dealpage="madealdetails.php";
        //GET PREV NEXT ID
        $prevNextArr = array();
        $prevNextArr = $_SESSION['resultId'];

        $currentKey = array_search($SelCompRef,$prevNextArr);
        $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
        $nextKey = $currentKey+1;
	
       $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,malogin_members as dm
        where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
//echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                }
        }

            $AdvisorSql="select * from advisor_cias where CIAId=$SelCompRef";

            $advisor_to_companysql="
            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
            DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId
            FROM mama AS peinv, pecompanies AS c,  advisor_cias AS cia,
            mama_advisorcompanies AS adac
            WHERE peinv.Deleted=0
             AND c.PECompanyId = peinv.PECompanyId
            AND adac.CIAId = cia.CIAID
            AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$SelCompRef order by DealDate";

            $advisor_to_investorsql="
            SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MAMAId  ,c.Companyname,
            DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
            FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia,
            mama_advisoracquirer AS adac
            WHERE peinv.Deleted=0  AND c.PECompanyId = peinv.PECompanyId
            AND adac.CIAId = cia.CIAID
            AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$SelCompRef order by DealDate";
        
            
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
            }
                ?>
     
		
    <td class="profile-view-left" style="width:100%;">
        <div class="result-cnt">                               
        <div class="result-title">    
            <?php 
            if(($exportToExcel==1))
               {
               ?>            
                    <div class="title-links" style="margin-top: -15px !important;">           
                        <input class="senddeal" type="button" id="senddeal" value="Send this Advisor profile to your colleague" name="senddeal"> 
                        <input class="export" type="button"  value="Export" name="showprofile"></span>
                    </div>
               <?php
               }
          ?>   
            <div class="overview-cnt"></div>
        </div>
            
    <div class="list-tab mt-list-tab" style="margin-top: 85px !important;"><ul>
            <li><a class="postlink"  href="<?php echo $actionlink; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="madealdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
            </ul></div> 
            <div class="lb" id="popup-box" style="top:100px">
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
    <div class="view-detailed">  
         <div class="detailed-title-links"> <h2>  <?php echo $advisorname; ?></h2>
		<?php $backlink=$_SERVER["HTTP_REFERER"];
    if ($backlink!='') {?> <a  class="postlink" id="previous" href="<?php echo $backlink; ?>">< Back</a><?php } ?> 
    </div>
          <div class="profilemain">
        <h2>Advisor Info  </h2>
        <div class="profiletable">
            <ul>
                <li><h4>Advisor</h4><p><?php  echo $advisorname;?></p></li>
                <?php 
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
                               var url ="/company-search:(companies:(id,website-url))?keywords=<?php echo $compname ?>";

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
    </div>
         <div class="postContainer postContent masonry-container">
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to Targets</h2>
                    <table width="100%" cellpadding="0" cellspacing="0" class="tableview">
                    <tbody> 
                     <tr><td><p>
                      <?php
                    if ($getcompanyrs = mysql_query($advisor_to_companysql))
                    {
                            $AddOtherAtLastc="";
                            $AddUnknowUndisclosedAtLastc="";
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
                                  echo $myInvrow["Companyname"];?>
                                    ( <a href="<?php echo $dealpage;?>?value=<?php echo $myInvrow["MAMAId"];?>">
                                                    <?php echo $myInvrow["dt"];?> </a>)<br>
                            <?php
                            }
                            elseif(($Result==1) || ($Result1==1) || ($iResult2vRes2==1))
                            {
                                    $AddUnknowUndisclosedAtLastc= ucfirst("$searchString");
                                    $dealidc=$myInvrow["MAMAId"];
                                    $dtdisplayc=$myInvrow["dt"];
                            }
                    }

                    if($AddUnknowUndisclosedAtLastc!="") {
                         echo $AddUnknowUndisclosedAtLasct; ?>
                            (<a href="<?php echo $dealpage;?>?value=<?php echo $dealidc;?>">
                                                    <?php echo $dtdisplayc;?></a>) <br>
                <?php
                }

                    }
            ?>
               </p>
                </td>
            </tr>  
                    </table>
            </div>  
         
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to Acquirer</h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
        <tr><td><p>
                  <?php
                    if ($getcompanyrs = mysql_query($advisor_to_investorsql))
                    {
                            $AddOtherAtLast="";
                            $AddUnknowUndisclosedAtLast="";
                            While($myInvestrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                            {
                            //$AddOtherAtLast="";
                            $companyname1=trim($myInvestrow["Companyname"]);
                            $companyname1=strtolower($companyname1);

                            $Result=substr_count($companyname1,$searchString);
                            $Result1=substr_count($companyname1,$searchString1);
                            $Result2=substr_count($companyname1,$searchString2);

                            if(($Result==0) && ($Result1==0) && ($Result2==0))
                            {
                    echo $myInvestrow["Companyname"]; ?>

                                    ( <a href="<?php echo $dealpage;?>?value=<?php echo $myInvestrow["MAMAId"];?>">
                                                    <?php echo $myInvestrow["dt"];?> </a>)<br>
                            <?php
                            }

                            elseif(($Result==1) || ($Result1==1) || ($iResult2vRes2==1))
                            {
                              $AddUnknowUndisclosedAtLast= ucfirst("$searchString");
                              $dealid=$myInvestrow["MAMAId"];
                                    $dtdisplay=$myInvestrow["dt"];
                            }
                          }


                            if($AddUnknowUndisclosedAtLast!="")
                            {
                                     echo $AddUnknowUndisclosedAtLast; ?>
                                    (<a href="<?php echo $dealpage;?>?value=<?php echo $dealid;?>">
                                                            <?php echo $dtdisplay;?></a>)<br>
                          <?php
                          }
                    }
                        ?>
               </p>
                </td>
            </tr>
       </tbody>
       </table>
        </div>
         <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>More Info</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
            <tbody>
             <tr><td>
             <p>For contact details of transaction advisory firms, download the Investment Bank Directory <a target="_blank" href="../ibdirectory_submit.php">here</a></p>
                 </td>
             </tr>
            </tbody>
        </table>
        </div>
         </div>	
            
</div>
    </div>
</td>
</tr>
</table>
 
</div>
</form>
<form name=companyDisplay id="companyDisplay" method="post" action="exportmaadvisor.php">
    <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>

<div class=""></div>

</div>
 
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
        $portArray = array( '80', '443' );
        if ($_SERVER["HTTPS"] == "on") {$URL .= "s";}
        $URL .= "://";
        if (!in_array( $_SERVER["SERVER_PORT"], $portArray)) {
        $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
        $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        $pageURL=$URL."&scr=EMAIL";
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
<?php mysql_close(); ?>