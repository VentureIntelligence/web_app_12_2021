<?php include_once("../globalconfig.php"); ?>
<?php
        require_once("reconfig.php");
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('checklogin.php');
        //  print_r($_POST);
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
        
        $value = isset($_GET['value']) ? $_GET['value'] : 0;
        //echo "<br>*".$value;
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $vcflagValue=$strvalue[1];
        $dealvalue=$strvalue[2];
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
            $flagvalue=$strvalue[1];
        }
        else
        {
            $vcflagValue=0;
            $VCFlagValue=0;
            $flagvalue="0-1";
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
        
        if($resetfield=="period" && !$_GET)
    {
        $month1="--";
        $year1 = "--";
        $month2="--";
        $year2 = "--";
        $_POST['month1']=$_POST['month2']=$_POST['year1']=$_POST['year2']="";
    }
    else
    {
        $month1=($_POST['month1']) ?  $_POST['month1'] : 01;
        $year1 = ($_POST['year1']) ?  $_POST['year1'] : 2005;
        $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
        $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
    }
    $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
    $splityear1=(substr($year1,2));
    $splityear2=(substr($year2,2));

    if(($month1!="") && ($month2!=="") && ($year1!="") &&($year2!=""))
    {
        $datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
        $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
        $wheredates1= "";
    }
        
        $prevNextArr = array();
	$prevNextArr = $_SESSION['resultCompanyId'];
	
	$currentKey = array_search($SelCompRef,$prevNextArr);
	$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
	$nextKey = $currentKey+1;
        $numofcount=$_SESSION['numberofcom'];
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
        
        $sql="SELECT pe.FinLink, pe.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website, 
                        stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, 
                        c.country, pec.Telephone, pec.Fax, pec.Email, pec.AdditionalInfor 
                FROM REcompanies pec
                LEFT JOIN REinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                LEFT JOIN reindustry i ON ( pec.industry = i.industryid ) 
                LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                WHERE pec.PECompanyId =$SelCompRef";
        
         $sectorSql= "SELECT DISTINCT sector, PECompanyId
			FROM REinvestments
			WHERE PECompanyId=$SelCompRef and sector!='' ";
	//echo "<Br>**********" .$sectorSql;

            if($rsSector= mysql_query($sectorSql))
            {
                    While($myStageRow=mysql_fetch_array($rsSector, MYSQL_BOTH))
                    {
                            $strSector=$strSector.", ".trim($myStageRow["sector"]);
                    }
                    $strSector =substr_replace(trim($strSector), '', 0,1);
            }
        
            
                $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt from
                REinvestments as pe, REinvestments_investors as peinv,REcompanies as pec,
                REinvestors as inv where pe.PECompanyId=$SelCompRef and
                peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
                and pec.PEcompanyId=pe.PECompanyId";

                $dealpage="redirdeal.php";
                //echo "<br>^^".$investorSql;
		
		

		$onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
		exe.ExecutiveName,exe.Designation,exe.Company from
		REcompanies as pec,executives as exe,REcompanies_board as bd
		where pec.PECompanyId=$SelCompRef and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";
		//echo "<Br>Board-" .$onBoardSql;

		$onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
				exe.ExecutiveName,exe.Designation,exe.Company from
				REcompanies as pec,executives as exe,REcompanies_management as mgmt
		where pec.PECompanyId=$SelCompRef and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
		//echo "<Br>Board-" .$onMgmtSql;


		$maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
			DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId,rei.MandAId, inv.InvestorId, inv.Investor
			FROM REmanda AS pe, reindustry AS i, REcompanies AS pec,REmanda_investors AS rei, REinvestors AS inv WHERE rei.InvestorId=inv.InvestorId AND pe.MandAId=rei.MandAId AND i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry =15 and pe.PECompanyId=$SelCompRef order by dt desc";

		$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId, rei.IPOId, inv.InvestorId, inv.Investor
				FROM REipos AS pe, reindustry AS i, REcompanies AS pec, REipo_investors AS rei, REinvestors AS inv WHERE  rei.InvestorId=inv.InvestorId AND  pe.IPOId=rei.IPOId, i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry =15 and pe.PECompanyId=$SelCompRef order by dt desc";
  
        ?>
<?php
	$topNav = 'Directory';
	include_once('redirectory_header.php');
?>
 <form name="recompanyDisplay" method="post" action="exportrecompanyprofile.php">
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg"> 
    <div class="acc_main">
     <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
<div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('redirrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
</div>
</td>

<td class="profile-view-left" style="width:100%;">
<div class="result-cnt">
    <div class="result-title result-title-nofix">
                <h2>
                    <span class="result-no" id="show-total-deal"> <?php echo $numofcount; ?> Results found</span>
                    <?php 
                        if($vcflagValue==0){?>
                                       <span class="result-for">for PE-RE Directory</span>
                        <?php } 
                        elseif($vcflagValue==1){?>
                                       <span class="result-for">for PE-IPO Directory</span>
                        <?php } 
                        elseif($vcflagValue==2){?>
                                       <span class="result-for">for PE-EXITS-M&A Directory</span>
                        <?php } 
                        elseif($vcflagValue==3){?>
                                       <span class="result-for">for OTHER-M&A Directory</span>
                        <?php } ?>
                    <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $numofcount; ?>">
                </h2>
                <div class="title-links">

                    <input class="senddeal" type="button" id="senddeal" value="Send this company detail to your colleague" name="senddeal">
                    <?php 

                    if(($exportToExcel==1))
                         {
                         ?>
                            <span id="exportbtn"></span>
                         <?php
                         }
                     ?>
                 </div>
    </div><br>
    <!--div class="result-title"><div class="title-links " id="exportbtn"></div>  </div-->
    
    <?php 
    if ($companyrs = mysql_query($sql))
		{
        ?>
         
                <?php
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
			$compname=$myrow["companyname"];
			$industry=$myrow["industry"];
			$sector=$strSector;
			//$myrow["sector_business"];
			$website=$myrow["website"];
			$Address1=$myrow["Address1"];
			$Address2=$myrow["Address2"];
			$AdCity=$myrow["AdCity"];
			$Zip=$myrow["Zip"];
                        $finlink=$myrow["FinLink"];
                        $uploadname=$myrow["uploadfilename"];
			$currentdir=getcwd();
			$target = $currentdir . "../uploadrefiles/" . $uploadname;
                        $file = "../uploadrefiles/" . $uploadname;
                        
			$OtherLoc=$myrow["OtherLocation"];
			$Country=$myrow["Country"];
			$Tel=$myrow["Telephone"];
			$Fax=$myrow["Fax"];
			$Email=$myrow["Email"];
			$AddInfo=$myrow["AdditionalInfor"];
			$stockcode=$myrow["stockcode"];
			$yearfounded=$myrow["yearfounded"];
			$website=$myrow["website"];

			$companyName=trim($myrow["companyname"]);
			$companyName=strtolower($companyName);
			$compResult=substr_count($companyName,$searchString);
			$compResult1=substr_count($companyName,$searchString1);
			$webdisplay="";       
    
    ?>
    <div class="overview-cnt"></div>
    <div class="list-tab"><ul>
             <li><a class="postlink" href="redirview.php?value=<?php echo $vcflagValue; ?>" id="icon-grid-view"><i></i> List  View</a></li>
         
        <li class="active"><a id="icon-detailed-view" class="postlink" href="recompanydetails.php?value=<?php echo $_GET['value'];?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>" ><i></i> Detail  View</a></li> 
        </ul></div> 
    <div class="lb" id="popup-box">
        <div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject</h5>
                    <p>Checkout this profile- <?php echo $compname; ?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this profile- <?php echo $compname; ?> - in Venture Intelligence"  />
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
<div class="view-detailed"> 
    <?php
    $value =$_GET['value'];
    $strvalue = explode("/", $value);

    ?>
    <div class="detailed-title-links">
        <h2>
        <?php if(($compResult==0) && ($compResult1==0)){
                        $webdisplay=$website;
                        echo $companynamevalue = $compname;
                }
                else {
                  $webdisplay="";
                  echo $companynamevalue = ucfirst("$searchString") ;
                } ?>
        </h2>
		<?php 
                if(count($prevNextArr)>0){
                
                    if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="redircomdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>">< Previous</a><?php } ?> 
                    <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="redircomdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?> "> Next > </a>  <?php } 
                }
                else{
                     $url=$_SERVER['HTTP_REFERER'];
                ?>
		<a class="postlink" href="<?php echo $url; ?>" onclick="window.history.back(1);">< Back</a>
              <?php  }
?>
    </div> 
 
 <div class="profilemain">
 <h2>Company Profile</h2>
 <div class="profiletable" style="position:  relative;">
      <?php $linkedinSearchDomain=  str_replace("http://www.", "", $webdisplay); 
       $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
        if(strrpos($linkedinSearchDomain, "/")!="")
        {
           $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
        }
    if($linkedinSearchDomain!=""){ ?>
     <!--<img src="<?php echo $refUrl ?>images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;">-->
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
               var url ="/company-search:(companies:(id,website-url))?keywords=<?php echo $companynamevalue ?>";

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
   <div class="fl" style="padding:10px 10px 0 0;"><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div>  <?php } ?>
 <ul>
  <?php 
  if ($myrow["Investor"] != "") 
  { ?>                                        
        <li><h4>Investor</h4><p> <?php echo $myrow["Investor"]; ?></p></li>
  <?php
  }
  if($industry!="")
{
?>
<li><h4>Industry</h4><p> <?php echo $industry;?></p></li>
<?php }
if($sector!="")
{
?>
<li><h4>Sector</h4><p><?php echo $sector;?></p></li>  
<?php }
if($stockcode!="")
{
?>
<li><h4>Stock Code</h4><p><?php echo $stockcode;?></p></li>
<?php }
 if ($Address1 != "" || $Address2 != "") 
 { ?>
   <li><h4>Address  </h4><p> <?php echo $Address1; ?><?php if ($Address2 != "") echo "<br/>" . $Address2; ?></p></li>  
   <?php
}
if ($AdCity != "") 
{ ?>
  <li><h4>City</h4><p><?php echo $AdCity; ?></p></li>
    <?php
    }
    if(($Country!="")&&($Country!="--" ))
    {
  ?>
  <li><h4>Country</h4><p> <?php echo $Country; ?></p></li>
   <?php
   }
  if (($Zip != "") || ($Zip > 0)) 
      { ?>
  <li><h4>Zip</h4><p> <?php echo $Zip; ?></p></li>
   <?php
}
 if (($Tel != "") || ($Tel > 0)) {
   ?>
  <li><h4>Telephone</h4><p><?php echo $Tel; ?></p></li>
<?php
 }
 if(($Fax!="")|| ($Fax>0)) 
{
?>
<li><h4>Fax  </h4><p><?php echo $Fax;?></p></li>
<?php }
if (trim($Email) != "") {
    ?>
  <li><h4>Email</h4><p><?php echo $Email; ?> </p></li> 
   <?php
    }

    if ($yearfounded != "") {
        ?>
   <li><h4> Year founded</h4><p><?php echo $yearfounded; ?> </p></li>
    <?php
    }
if(trim($OtherLoc)!="") 
{
?>
 <li><h4> Other Loc</h4><p><?php echo $OtherLoc;?></p></li>
<?php }
if (trim($website) != "") 
  { ?>
  <li><h4>Website</h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>
   <?php
    }
if(trim($AddInfo)!="") 
{
?>
 <li><h4> More Information</h4><p><?php echo $AddInfo;?></p></li>
<?php }
    
    
    ?> 
    
     <?php if ($linkedinSearchDomain != "") 
  {  ?>
  <li id="viewlinkedin_loginbtn" style="display: none"><h4>LinkedIn</h4><p><script type="in/Login"></script></p></li>
  <?php } ?>
  
   </ul>
 </div>
 </div> 
<div class="postContainer postContent masonry-container">  
<?php
$investor_cnt=0;
if($investorSql!="")
{
if($getcompanyrs= mysql_query($investorSql))
{
    $investor_cnt = mysql_num_rows($getcompanyrs);
}
}
if($investor_cnt>0)
{

?>                                                  
    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>Investors</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
    <thead><tr><th>Investor Name</th> <th>Deal Period</th></tr></thead>
    <tbody>
    <?php
        $AddOtherAtLast="";
        While($myInvestorrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
        {
            $Investorname=trim($myInvestorrow["Investor"]);
            $Investorname=strtolower($Investorname);
            $invResult=substr_count($Investorname,$searchString);
            $invResult1=substr_count($Investorname,$searchString1);
            $invResult2=substr_count($Investorname,$searchString2);
            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
            {
            ?>
            <tr><td style="alt"><a href='redirinvdetails.php?value=<?php echo $myInvestorrow["InvestorId"];?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>' title="Investor Details"><?php echo $myInvestorrow["Investor"]; ?></a></td>
                <td><a href='<?php echo $dealpage;?>?value=<?php echo $myInvestorrow["DealId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>' title="Deal Details"><?php echo $myInvestorrow["dt"];?> </a></td></tr>                                                          
            <?php 
            }
            else {
                    $AddOtherAtLast=$myInvestorrow["Investor"];
            }
        } 
           ?>  
    <tr><td style="alt" colspan="2"><?php echo $AddOtherAtLast; ?></td></tr>                    
    </tbody>
    </table> 
    </div>
 <?php
    }
    if($rsBoard= mysql_query($onBoardSql))
    {
         $board_cnt = mysql_num_rows($rsBoard);
    }
    if($board_cnt>0)
    {
    ?>
      <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Investor Board Member</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th> <th>Member Link</th></tr></thead>
        <tbody>
            <?php

                While($myboardrow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
                {
                    $desig="";
                    $desig=$myboardrow["Designation"];
                    if(strlen(trim($desig))==0)
                            $desig="";
                    else
                            $desig=", ".$myboardrow["Designation"];
                    $comp=$myboardrow["Company"];
                    if(strlen(trim($comp))==0)
                            $comp="";
                    else
                            $comp=", ".$myboardrow["Company"];

        ?>
        <tr><td style="alt"><?php echo $myboardrow["ExecutiveName"];?></td>
        <td>
           
            <?php 
            echo $myboardrow["Designation"];
             if($myboardrow["Designation"]!="" && $myboardrow["Company"]!=""){ echo ","; } ?>
            <?php echo $myboardrow["Company"]; ?></td>
        <td>
        <?php
                $google_sitesearch_board="https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$desig.$comp. "+site%3Alinkedin.com";
                                                                ?>
                <a target="_blank" href="<?php echo $google_sitesearch_board; ?>" >
                <?php echo $myboardrow["ExecutiveName"];?></a>
        </td></tr>
        <?php
                }
                //}
                ?>  
     </tbody>
        </table> 
        </div>     
        <?php
        }
        if($rsMgmt= mysql_query($onMgmtSql))
        {
             $mgmt_cnt = mysql_num_rows($rsMgmt);
        }
        if($mgmt_cnt>0)
        {   
        ?>

        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Top Management</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th></tr></thead>
        <tbody>
             <?php
                    While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                    {
                            $desig="";
                            $desig=$mymgmtrow["Designation"];
                            if(trim($desig)=="")
                                    $desig="";
                            else
                                    $desig=", ".$mymgmtrow["Designation"];
                ?>
                <tr><td style="alt"><?php echo $mymgmtrow["ExecutiveName"]; ?></td>
                    <td><?php echo $mymgmtrow["Designation"]; ?></td>
                <!--  <td>
                <?php 
                        $google_sitesearch_mgmt="https://www.google.co.in/search?q=".$companyName." ".$mymgmtrow["ExecutiveName"]."+site%3Alinkedin.com";
                        ?>
                        <a target="_blank" href="<?php echo $google_sitesearch_mgmt; ?>" ><img src="images/icon-in.png" width="25" height="24" alt="" /></a></td>-->
                </tr>
                <?php
                        }


                ?>
     </tbody>
        </table> 
        </div>   
        <?php
        }
         if($rsipoexit= mysql_query($ipoexitsql))
        {
             $ipoexit_cnt = mysql_num_rows($rsipoexit);
        }
        if($rsmandaexit= mysql_query($maexitsql))
        {
             $mandaexit_cnt = mysql_num_rows($rsmandaexit);
        }
        if(($ipoexit_cnt>0)||($mandaexit_cnt>0 ))
        {

        ?>                                                 
            <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
            <h2>Exits</h2>
            <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
            <thead><tr><th>Exit Type</th><th>Investor(s)</th><th>Deal Period</th></tr></thead>
            <tbody>
                 <?php
                        //if($rsipoexit= mysql_query($ipoexitsql))
                        //{
                        While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
                        {
                          $exitstatusvalueforIPO=$ipoexitrow["ExitStatus"];
                          if($exitstatusvalueforIPO==0)
                           {$exitstatusdisplayforIPO="Partial Exit";}
                          elseif($exitstatusvalueforIPO==1)
                          {  $exitstatusdisplayforIPO="Complete Exit";}
                        ?>
                       <tr><td style="alt">IPO</td>
                           <td style="alt"><?php echo $ipoexitrow["Investor"];?></td>
                        <td> <a href='rediripodeal.php?value=<?php echo $ipoexitrow["IPOId"];?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>' title="Deal Details"><?php echo $ipoexitrow["dt"];?></a></td>

                        
                        </tr>


                        <?php
                                }

                                if($rsmandaexit= mysql_query($maexitsql))
                        //{
                        While($mymandaexitrow=mysql_fetch_array($rsmandaexit, MYSQL_BOTH))
                        {
                          $exitstatusvalue=$mymandaexitrow["ExitStatus"];
                          if($exitstatusvalue==0)
                           {$exitstatusdisplay="Partial Exit";}
                          elseif($exitstatusvalue==1)
                          {  $exitstatusdisplay="Complete Exit";}
                        ?>

                        <tr><tr><td style="alt">M&A</td>
                            <td style="alt"><?php echo $mymandaexitrow["Investor"];?></td>
                        <td> <a href='redirmandadeal.php?value=<?php echo $mymandaexitrow["MandAId"];?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>' title="Deal Details"><?php echo $mymandaexitrow["dt"];?></a></td>

<!--                        <td><?php // echo $exitstatusdisplay;?></td>-->
                        </tr>
                        <?php
                        } 
                       ?>  
            </tbody>
            </table> 
            </div>
         <?php
            }
        /*if($myrow["uploadfilename"]!="")
        {   
        ?>

        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>FINANCIALS INFO</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <tbody>
             <?php

if($finlink!="")
{
?>
    <tr><td ><h4>Link for Financials
            </h4><p style="word-break: break-all;"><a target="_blank" href=<?php echo $finlink; ?> ><?php echo $finlink; ?></a></p></td></tr>

<?php
}
//echo "<BR>-----" .$exportToExcel;

//echo "<BR>^^^^".$showFinancial;
if($myrow["uploadfilename"]!="")
{
        ?>
                <tr><td  ><h4>Financials </h4>
                <?php
                 if($exportToExcel==1)
                 {
                 ?>
                            <td><a href=<?php echo $file;?> target="_blank" > Click here </a>
                            <Br />
                            <a href="<?php echo GLOBAL_BASE_URL; ?>cfs/index.php"target="_blank">Click Here to compare with other companies in CFS database</a>
                             </td>

                             </tr>
                 <?php
                 }
                 else
                 {
                 ?>
                             <td>&nbsp;Paid Subscribers can view a link to the co. financials here </td> </tr>
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
        <?php
        }*/
      ?>
 </div>                                                          
      <?php
                        
                    }
                }
                    ?>                       
  </div>
    
    <?php
			if(($exportToExcel==1))
			{
			?>
					<span style="float:right" class="one">
						 <input class ="export" type="button"  value="Export" name="showdeals">
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
<input type="hidden" name="value" value="<?php echo $vcflagValue; ?>">
</form>
<form name="recompanyDisplay"  id="recompanyDisplay" method="post" action="exportrecompanyprofile.php">
    <input type="hidden" name="txthideCompanyId" value="<?php echo $SelCompRef;?>" >
    <input type="hidden" name="txthidepeipomandaflag" value="<?php echo $pe_re;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    </form>
<script type="text/javascript">
	$(".export").click(function(){
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
    
    $("a.postlink").click(function(){

        hrefval= $(this).attr("href");
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();

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
        $("#recompanyDisplay").submit();
        $('#preloading').fadeOut(500);
        return false; 
     });
    
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
</script> 
<?php  mysql_close();  ?>

