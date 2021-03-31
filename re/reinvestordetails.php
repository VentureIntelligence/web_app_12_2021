<?php
        require_once("reconfig.php");
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('checklogin.php');
    
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);

        //print_r($_POST);

        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        $investorId=$strvalue[0];
        

        $pe_re= 2;
        if($pe_re==1)
        {
                $industryvalue="!=15";
                $dealpage="dealdetails.php";
        }
        elseif($pe_re==2)
        {
                //$industryvalue="=15";
                $dealpage="redealdetails.php";
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {   
           // echo "1";
            if($getyear!="")
            {
                $month1= 01;
                $year1 = $getyear;
                $month2= 12;
                $year2 = $getyear;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
            }
            else if($getsy !='' && $getey !='')
            {
                $month1= 01;
                $year1 = $getsy;
                $month2= 12;
                $year2 = $getey;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
                //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
            }
            else
            {
                $month1= 01;
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                $month2= date('n');
                $year2 = date('Y');
                $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
            }
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            if($resetfield=="period")
            {
             $month1= 01; 
             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")|| ($resetfield=="sectorsearch") ||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= 01; 
             $year1 =  date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
            {
            
             $month1=01; 
             $year1 = 1998;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : 01;
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));;
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
        }
        
        $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,RElogin_members as dm
        where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                }
        }

        $sql="select * from REinvestors where InvestorId=$investorId";

            $iposql="select peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,
                                    c.companyname,DATE_FORMAT( peinv.IPODate, '%b-%Y' ) as dealperiod,inv.*
                                    from REipo_investors as peinv_inv,REinvestors as inv,
                                    REipos as peinv,REcompanies as c
                                    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId and peinv.Deleted=0
                                    and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId and c.industry $industryvalue";
    //	echo "<br>--------" .$iposql;

            $mandasql="select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
                                    c.companyname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,inv.*
                                    from REmanda_investors as peinv_inv,REinvestors as inv,
                                    REmanda as peinv,REcompanies as c
                                    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                            and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                            and c.industry $industryvalue
                            order by DealDate desc";

            $onMgmtSql="select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
                                            exe.ExecutiveName,exe.Designation,exe.Company from
                                            REinvestors as pec,executives as exe,REinvestors_management as mgmt
                    where pec.InvestorId=$investorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";
    //echo "<br>---" .$sql;

            $indSql= " SELECT DISTINCT i.industry as ind, peinv.IndustryId, peinv_inv.InvestorId
                            FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
                            WHERE peinv_inv.InvestorId =$investorId
                            AND inv.InvestorId = peinv_inv.InvestorId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND peinv.PEId = peinv_inv.PEId
                            AND i.industryid = peinv.IndustryId  order by i.industry";
                            //and c.industry $industryvalue
                            //echo "<br>====" .$indSql;

            $stageSql= "select distinct s.REType,pe.StageId,peinv_inv.InvestorId
    from REinvestments_investors as peinv_inv,REinvestors as inv,REinvestments as pe,realestatetypes as s
    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
    and pe.PEId=peinv_inv.PEId and s.ReTypeId=pe.StageId and REType!='' order by REType ";
            
            $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
                                              c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,SPV,inv.*
                                              from REinvestments_investors as peinv_inv,REinvestors as inv,
                                              REinvestments as peinv,REcompanies as c
                                              where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                                              and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                                              and c.industry $industryvalue and c.PECompanyId=peinv.PECompanyId
                                              order by peinv.dates desc";

    //echo "<br>--" .$stageSql;

    $strIndustry="";
    $strStage="";
    if($rsInd= mysql_query($indSql))
    {
            While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
            {
                    $strIndustry=$strIndustry.", ".$myIndrow["ind"];
            }
            $strIndustry =substr_replace($strIndustry, '', 0,1);
    }

    if( $rsStage= mysql_query($stageSql))
            {
                    While($myStageRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
                    {
                            $strStage=$strStage.", ".trim($myStageRow["REType"]);
                    }
                    $strStage =substr_replace(trim($strStage), '', 0,1);
            }

 if($strvalue[1]==0) 
    {
        $listviewurl="reindex.php";
        $headerurl="reheader_search.php";
        $refineurl="rerefine.php"; 
    } 
    else if($strvalue[1]==1 )
    {
        $listviewurl="reipoindex.php";
        $headerurl="reipoheader_search.php";
        $refineurl="reiporefine.php";
    }
     else if($strvalue[1]==2 )
        {
            $listviewurl="remandaindex.php?value=2";
            $headerurl="remandaheader_search.php";
            $refineurl="remandarefine.php";
        }
    ?>
<?php
	$topNav = 'Deals';
         $tour_reinve_page = 'reinvestordetails';
	include_once($headerurl);
?>    
 <input type="hidden" name="resetfield" value="" id="resetfield"/>


   
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg"> 
 <div class="acc_main">
 <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
<div id="panel" style="display:block; overflow:visible; clear:both;">
<?php 
       include_once($refineurl);  
?>
   
    
 </div>
 </div>
</td>

            <td class="profile-view-left" style="width:100%;">
                <div class="result-cnt">
                    
                   <!--div class="result-title result-title-fix"> <div class="title-links " id="exportbtn"></div> </div-->
                    <?php if ($rsinvestors = mysql_query($sql)) { ?>
                                
                       <?php
		if($myrow=mysql_fetch_array($rsinvestors,MYSQL_BOTH))
		{

			$Address1=$myrow["Address1"];
			$Address2=$myrow["Address2"];
			$AdCity=$myrow["City"];
			$Zip=$myrow["Zip"];
			$Tel=$myrow["Telephone"];
			$Fax=$myrow["Fax"];
			$Email=$myrow["Email"];
			$website=$myrow["website"];
                        $linkedIn=$myrow["linkedIn"];
			//echo "<Br>______________".$website;
			$description=$myrow["Description"];
			$yearfounded=$myrow["yearfounded"];
			$no_employees=$myrow["NoEmployees"];
			$firm_type=$myrow["FirmType"];
			$other_location=$myrow["OtherLocation"];
			$assets_mgmt=$myrow["Assets_mgmt"];
			$already_invested=$myrow["AlreadyInvested"];
			$preferred_stage= ltrim($strStage);  //$myrow["PreferredStage"];
			$limited_partners=$myrow["LimitedPartners"];
			$no_funds=$myrow["NoFunds"];
			$no_activefunds=$myrow["NoActiveFunds"];
			$min_investment-$myrow["MinInvestment"];
			$AddInfo=$myrow["AdditionalInfor"];
			$comment=$myrow["comment"];
                    
                        if(!$_POST){?>
                           <div class="title-links">           
                            <input class="senddeal" type="button" id="senddeal" value="Send this investor profile to your colleague" name="senddeal"> 
                            <span id="exportbtn"></span>
                        </div><br><br>     
                        <!--div class="title-links " id="exportbtn"></div><br><br-->

                     <?php            
                     }
                       else 
                       {  ?> 
                            <div class="title-links">           
                            <input class="senddeal" type="button" id="senddeal" value="Send this investor profile to your colleague" name="senddeal"> 
                            <span id="exportbtn"></span>
                        </div><br><br> 
                          <!--div class="title-links " id="exportbtn"></div><br><br-->
                       <?php    
                       } ?>
                   <div class="overview-cnt "></div>
                     <div class="list-tab"><ul>
<!--                        <li><a class="postlink"  href="angelindex.php?value=<?php echo $strvalue[1]; ?>"  id="icon-grid-view"><i></i> List  View</a></li>-->
                        <li class="active"><a id="icon-detailed-view" class="postlink" href="reinvestordetails.php?value=<?php echo $strvalue[0]."/".$strvalue[1];?>" ><i></i> Detail View</a></li> 
                        </ul></div> 
                    <div class="lb" id="popup-box">
                        <div class="title">Send this to your Colleague</div>
                        <form>
                            <div class="entry">
                                    <label> To*</label>
                                    <input type="text" name="toaddress" id="toaddress"  />
                            </div>
                            <div class="entry">
                                    <h5>Subject*</h5>
                                    <p>Checkout this profile - <?php echo $myrow["Investor"]; ?> - in Venture Intelligence</p>
                                    <input type="hidden" name="subject" id="subject" value="Checkout this profile - <?php echo $myrow["Investor"]; ?> - in Venture Intelligence"  />
                                    <input type="hidden" name="basesubject" id="basesubject" value="Investor profile" />
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
                           
    <div class="detailed-title-links"> <h2>  <?php echo $myrow["Investor"]; ?></h2>
        <?php
        $usebackaction = $_SESSION['usebackaction'];    
        
        if( isset($_REQUEST['reipodealdetails']))
        {
            $page = 'reipodealdetails';
        }
        else if( isset($_REQUEST['remandadealdetails']))
        {
            $page = 'remandadealdetails';
        }
        
        else
        {
           $page = 'redealdetails';
       
        }
        ?>
        
      <a  class="postlink" id="previous" href="<?php echo $page?>.php?value=<?php echo $usebackaction; ?> ">< Back</a>
      
<!--      <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a>-->

    </div>             
 <div class="profilemain">
 <h2>RE Investor Profile</h2>
 <div class="profiletable" style="position:  relative;">
 <?php 

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
   
        <script type="text/javascript" src="//platform.linkedin.com/in.js"> 
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

              }

        </script>
        
       <div  id="sample" style="padding:10px 10px 0 0;">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0" style="display:none"></iframe>
    </div>

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
   <div class="fl" style="padding:10px 10px 0 0;display:none"><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div>    
           
<?php }
     else{
         
         $linkedinSearchDomain=  str_replace("http://www.", "", $website); 
       $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
        if(strrpos($linkedinSearchDomain, "/")!="")
        {
           $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
        }
    if($linkedinSearchDomain!=""){ ?>
     <!--<img src="<?php echo $refUrl; ?>images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;">-->
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


   
         <script type="text/javascript" src="//platform.linkedin.com/in.js">
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
               var url ="/company-search:(companies:(id,website-url))?keywords=<?php echo $myrow["Investor"] ?>";

                console.log(url);
            
                IN.API.Raw(url).result(function(response) {   
                   
                    //console.log(response);  
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
       <?php }
     }?>
<ul>
  <?php 
  if ($myrow["Investor"] != "") 
  { ?>                                        
        <li><h4>Investor  </h4><p> <?php echo $myrow["Investor"]; ?></p></li>
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
 
 if (($Fax != "") || ($Fax > 0)) {
   ?>
  <li><h4>Fax    </h4><p><?php echo $Fax; ?></p></li>
<?php
 }
        $rsMgmt = mysql_query($onMgmtSql);
        if (mysql_num_rows($rsMgmt) > 0) {
     ?>
    <li><h4>Management</h4>
             <?php
                While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
                    $designation = $mymgmtrow["Designation"];
                    if ($mymgmtrow["Designation"] == "")
                        $designation = "";
                    else
                        $designation = "" . $mymgmtrow["Designation"];
                    ?>
                       <p><?php echo $mymgmtrow["ExecutiveName"]; ?> - <?php echo $designation; ?></p>
                    <?php }
                    ?>

            <?php
        }
if (trim($Email) != "") {
    ?>
  <li><h4>Email    </h4><p><?php echo $Email; ?> </p></li> 
   <?php
    }

    if ($yearfounded != "") {
        ?>
   <li><h4> Year found</h4><p> <?php echo $yearfounded;?></p></li>
    <?php
    }
if (trim($website) != "") 
  { ?>
  <li><h4>Website    </h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>
   <?php
    }
    
if (trim($no_employees) != "") 
  { ?>
  <!--<li><h4>No of Employee    </h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>-->
   <?php
    }
    //{
    ?>
  
  <?php
    $companyurl=  urlencode($myrow["Investor"]);
    $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.in/ddw/";
    
    if ($company_newssearch != ""){
 ?>
  <li><h4>News </h4><p><a href=<?php echo $company_newssearch; ?> target="_blank">Click Here</a></p></li> 
 <?php } ?>
  
 <?php
    if (trim($linkedIn) != ""){
 ?>
  <li><h4>LinkedIn </h4><p><a href=<?php echo $linkedIn; ?> target="_blank">Click Here</a></p></li> 
 <?php } ?>
  
      <?php if ($linkedinSearchDomain != "") 
  {  ?>
  <li id="viewlinkedin_loginbtn" style="display: none"><h4>View LinkedIn Profile  </h4><p><script type="in/Login"></script></p></li>
  <?php } ?>
  
   </ul>
 
 </div>
 </div>     
 <div class="postContainer postContent masonry-container">
     <?php                             

              //echo "<bR>** ".$InvestmentSql;
                  if ($getcompanyinvrs = mysql_query($Investmentsql)) {
                      $inv_cnt = mysql_num_rows($getcompanyinvrs);
                  }
                  if ($inv_cnt > 0) {
                  ?>
        <div  class="work-masonry-thumb col-2">
        <div id="tabsholder2">
              <ul class="tabs">
                 <li id="tabz1">Investments</li>
              </ul>
               <div class="contents marginbot">
                 

                  <div id="contentz1" class="tabscontent"> 
                 <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                  <thead><tr><th>Company Name</th><th>Deal Period</th></tr></thead>
                  <tbody>
                   <?php
                      While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
                        {
                            $companyName=trim($myInvestrow["companyname"]);
                            $companyName=strtolower($companyName);
                            $compResult=substr_count($companyName,$searchString);
                            $compResult1=substr_count($companyName,$searchString1);

                            if($myInvestrow["SPV"]==1)
                            {
                                     $openBracket="(";
                                     $closeBracket=")";
                            }
                            else
                            {
                                $openBracket="";
                                $closeBracket="";
                            }

                            if(($compResult==0) && ($compResult1==0))
                            {
                          ?>
                          <tr><td style="alt">
                                  <?php echo $openBracket;?><a class="postlink" href='recompanydetails.php?value=<?php echo $myInvestrow["PECompanyId"]."/".$strvalue[1]; ?>' ><?php echo $myInvestrow["companyname"]; ?></a><?php echo $closeBracket;?></td>
                          <?php
                      } else {
                          ?>
                          <tr><td >
                          <?php echo ucfirst("$searchString"); ?></td>
                          <?php
                      }
                      ?>
                              <td colspan="2"> <a href="<?php echo $dealpage;?>?value=<?php echo $myInvestrow["PEId"]."/".$strvalue[1];?>">
							<?php echo $myInvestrow["dealperiod"];?> </a></td>



                      </tr>
                      <?php
                  }
                    ?>

                  </tbody>
              </table></div>
                   

              </div>
          </div>                                                          
       </div>
           <?php } ?>
      <?php

        if($rsipoinvestors= mysql_query($iposql))
        {
             $ipo_cnt = mysql_num_rows($rsipoinvestors);
        }
        if($ipo_cnt>0)
        {
      ?>
      <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
        <h2> Exits - IPO</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Company Name</th><th>Deal Period</th></tr></thead>
        <tbody>
        <?php
            While($ipmyrow=mysql_fetch_array($rsipoinvestors, MYSQL_BOTH))
           {
//                 $exitstatusdisplayforIPO="";
//                 $exitstatusvalueforIPO=$ipmyrow["ExitStatus"];
//                 if($exitstatusvalueforIPO==0)
//                 {$exitstatusdisplayforIPO="Partial Exit";}
//                 elseif($exitstatusvalueforIPO==1)
//                 {  $exitstatusdisplayforIPO="Complete Exit";}
           ?>

                           <tr>
                               <td><a class="postlink" href='recompanydetails.php?value=<?php echo $ipmyrow["PECompanyId"]."/".$strvalue[1]; ?>' ><?php echo $ipmyrow["companyname"]; ?></a></td>
                               <td><a class="postlink" href='reipodealdetails.php?value=<?php echo $ipmyrow["IPOId"]."/".$strvalue[1];?>'><?php echo $ipmyrow["dealperiod"];?></a></td> 
                           </tr>
               <?php
           }
         ?>
        </tbody>
        </table>
        </div>   
     <?php
        }
        if($rsmandainvestors =mysql_query($mandasql))
        {
            if($mandamyrow1=mysql_fetch_array($rsmandainvestors,MYSQL_BOTH))
            {
   ?>
     <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
        <h2> Exits - M&A </h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Company Name</th><th>Deal Period</th></tr></thead>
        <tbody>
        <?php
           if ($getcompanyrs = mysql_query($mandasql))
            {
                While($mandamyrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                {
//                  $exitstatusdisplay="";
//                  $exitstatusvalue=$mandamyrow["ExitStatus"];
//                  if($exitstatusvalue==0)
//                  {$exitstatusdisplay="Partial Exit";}
//                  elseif($exitstatusvalue==1)
//                  {  $exitstatusdisplay="Complete Exit";}
            ?>

                            <tr>
                                <td><a class="postlink" href='recompanydetails.php?value=<?php echo $mandamyrow["PECompanyId"]."/".$strvalue[1]; ?>' ><?php echo $mandamyrow["companyname"]; ?></a></td>
                                <td><a class="postlink" href='remandadealdetails.php?value=<?php echo $mandamyrow["MandAId"]."/".$strvalue[1];?>'><?php echo $mandamyrow["dealperiod"];?></a></td> 
                            </tr>
                <?php
            }
            }
            ?>
        </tbody>
        </table>
        </div>  
     <?php
            }
        }
        ?>
                                                                
<div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/tac-3/">
      <h2>More Info</h2>
                                                               
          <table class="tablelistview" cellpadding="0" cellspacing="0">
            <tr>                                                  
                <?php if (trim($firm_type) != "") { ?>
                <td><h4>Firm Type </h4><p><?php echo $firm_type; ?></p></td>
                <?php
                }
                if (trim($other_location) != "") {
                ?>
                 <td><h4>Other Location</h4>Other Location(s)<p><?php echo $other_location; ?>&nbsp;</p></td>
                <?php
                }
                if (trim($preferred_stage) != "") {
                ?>
                <td><h4>Stage of funding</h4><p><?php echo $preferred_stage; ?>&nbsp;</p></td>
           
                <?php
                }
                ?>
            </tr><tr>
                <?php
                if (trim($assets_mgmt) != "") {
                ?>
               <td><h4>Assets Under Management</h4> <p><?php echo $assets_mgmt; ?></p></td>
                <!--<tr><td width=20%><b>&nbsp;Already Invested (US$ Million)</b></td><td  width=30%>&nbsp;<?php echo $already_invested; ?>&nbsp;</td></tr> -->
                <?php
                }
                if (trim($limited_partners) != "") {
                ?>
               <td><h4>Limited partners</h4><p><?php echo $limited_partners; ?></p></td>
                <?php
                }
                if (trim($strIndustry) != "") {
                ?>
                <td><h4>Industry  (Existing Investments)</h4><p><?php echo $strIndustry; ?></p></td>
                <?php
                }
                ?>
            </tr><tr>
               <?php
               if (trim($no_funds) != "") {
                ?>
                <td><h4>Number of Funds</h4><p><?php echo $no_funds; ?></p></td>
                <?php
                }

                if (trim($min_investment) != "") {
                ?>
                <td><h4>Minimum Investment Size (US$ Million)</h4><p><?php echo $min_investment; ?></p></td>
                <?php
                }
                if (trim($AddInfo) != "") {
                ?>
                <td><h4>Additional Information</h4><p><?php echo $AddInfo; ?></p></td>
                <?php
                }                                                    
                 ?>                                                                                                   
             </tr><tr>
                <?php
                if(trim($description)!="") 
                {
                ?>
                <td colspan="3"><h4>Description</h4><p><?php echo $description; ?></p></td>
                <?php }
                ?>   
            </tr> </table>
 </div>
    </div>
      </div>
        <?php
        }
        }
    ?>
                               <?php
                    if(($exportToExcel==1))
                    {
                    ?>
                                    <span style="float:right" class="one">
                                             <input class ="export" type="submit" id="expshowdealsbtn"  value="Export" name="showdeals">
                                    </span>
                                <script type="text/javascript">
                                    $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                                </script>
                    <?php
                    }
                    ?>
                
                </div>
          </td>
       </tr>
      </table>
   </div>
    <div class=""></div>
    
</form>

<form name="reinvestorDetails" id="investorDetails" method="post" action="exportreinvestorprofile.php">
     <input type="hidden" name="txthideinvestorId" value="<?php echo $investorId;?>" >
    <input type="hidden" name="hidepeipomandapage" value="5" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>    
 <script type="text/javascript">
			
            /*$('#expshowdeals').click(function(){ 
                hrefval= 'exportreinvestorprofile.php';
                $("#investorDetails").attr("action", hrefval);
                $("#investorDetails").submit();
                return false;
            });*/
    
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
                    setCurControl("postlink");
                    $("#pesearch").submit();
                    return false;
                    
                });
                
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
                        hrefval= 'exportreinvestorprofile.php';
                        $("#investorDetails").attr("action", hrefval);
                        $("#investorDetails").submit();
                        jQuery('#preloading').fadeOut();
                    }else{
                        jQuery('#preloading').fadeOut();
                        //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                        alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.in");
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
mysql_close();
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
    
<?php if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){ ?> 

    
     <script type="text/javascript" >
    $(document).ready(function(){
       
   hopscotch.startTour(tour, 11); 
    
           });
           
        </script>
   <?php }    mysql_close();   ?>