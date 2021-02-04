<?php include_once("../globalconfig.php");
require_once("../dbconnectvi.php");//including database connectivity file
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
         header('Location:../pelogin.php');
}
else
{
?>
<style>.companyProfile{ margin-top:0px !important; } .com-cnt-sec{margin-top:0px;} .view-detailed1{padding-top:0px;}</style>
<?php
        if($pe_re=="0-0")
        {
                $pe_re=7;
        }
        else if($pe_re=="1-0")
        {
                $pe_re=8;
        }
        else if($pe_re=="0-1")
        {
                $pe_re=9;
        }
        if($pe_re==2)
        {
            $invpage="angleinvdetails.php";
        }
        else
        {
            /*$invpage="investordetails.php";*/
            $invpage="dirdetails.php";
        }        
        if($myrow["InvesteeId"] != ''){
            $SelCompRefvalue = $myrow["InvesteeId"];
        }else
        if($myrow['IncubateeId'] != ''){
            $SelCompRefvalue = $myrow['IncubateeId'];
        }else{
            $SelCompRefvalue = $myrow['PECompanyId'];
        }
        $sql="SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,linkedIn, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, pec.Email, pec.AdditionalInfor, linkedin_companyname,pec.tags,pec.CINNo
                    FROM pecompanies pec
                    LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                    LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                    LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                    WHERE pec.PECompanyId ='$SelCompRefvalue'";	
        
       $company_link_Sql =mysql_query("select * from pecompanies_links where PECompanyId='$SelCompRefvalue'"); 
       
        $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator,DATE_FORMAT( date_month_year, '%M-%Y' ) as dt FROM
                                `incubatordeals` as pe, incubators as inc WHERE IncubateeId =$SelCompRefvalue
                                and pe.IncubatorId= inc.IncubatorId ";

        $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
                        exe.ExecutiveName,exe.Designation,exe.Company from
                        pecompanies as pec,executives as exe,pecompanies_management as mgmt
        where pec.PECompanyId='$SelCompRefvalue' and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";

        $onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
        exe.ExecutiveName,exe.Designation,exe.Company from
        pecompanies as pec,executives as exe,pecompanies_board as bd
        where pec.PECompanyId='$SelCompRefvalue' and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";

        $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
                peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
                peinvestors as inv where pe.PECompanyId='$SelCompRefvalue' and
                peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
                and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";

        $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,
                            DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType
                            FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                             WHERE  i.industryid=pec.industry
                            AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId='$SelCompRefvalue'
                            and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and pe.DealTypeId=dt.DealTypeId
                            order by DealDate desc ";
                            //echo "<br>-- ".$maexitsql;

        $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
                        IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                        FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                         WHERE  i.industryid=pec.industry
                AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId='$SelCompRefvalue'
                and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId
                 order by IPODate desc";
                  // echo "<br>-- ".$ipoexitsql;



        $angelinvsql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,
                        DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor
                        FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
                        angel_investors as peinv,peinvestors as inv
                         WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                         pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId='$SelCompRefvalue'
                         and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by DealDate desc";
                    // echo "<Br>---" .$angelinvsql;
?>
    
<style>
    .relatedCompany .com-add-li, .tags .com-add-li{  min-height: 1px; }
    .tags .com-add-li{  width:140px; }
    .tags .bor-top-cnt{
        border-top:none;
    }
    .relatedCompany .com-address-cnt, .tags .com-address-cnt{ 
        border-bottom:none;  
        padding:0 30px;
    }
    .com-investment-profile{
        width: 33%;
    }
    .bor-top-cnt{
        border-top: 1px solid #e4e4e4;
        clear: both;
        padding-top: 10px;
    }
    .mar-top {
        margin: 0px 15px 10px;
    }
    .inv-lf-li{
        min-height: 100px;
    }
    
</style>
<span id="companyProfileBox">
<div id="container" class="companyProfile">
<form name="companyDisplay" method="post" action="exportcompanyprofile.php">
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>



<td class="profile-view-left" style="width:100%;">
<div class="result-cnt dealspage" style="position: relative;">
    <?php 
   // echo $sql;
    if ($companyrs = mysql_query($sql))
		{
    //   echo $sql;
        ?>
         
                        <?php if($companyrs)
		 {
                            
                            $myrow=mysql_fetch_array($companyrs,MYSQL_BOTH);
                            
                        
                        if(isset($_REQUEST['angelco_only'])){
                               $angelco_compID=$SelCompRef;
                           }    
                        else if(mysql_num_rows($companyrs)>0){ 
//              / echo "adsasd";
			$angelco_compID=$myrow["angelco_compID"];
                        $compname=$myrow["companyname"];
			$industry=$myrow["industry"];
			$sector=$myrow["sector_business"];
			$website=$myrow["website"];
			$Address1=$myrow["Address1"];
			$Address2=$myrow["Address2"];
			$AdCity=$myrow["AdCity"];
			$Zip=$myrow["Zip"];
                        $finlink=$myrow["FinLink"];
                        $uploadname=$myrow["uploadfilename"];
			$currentdir=getcwd();
			$target = $currentdir . "../uploadmamafiles/" . $uploadname;
                        $file = "../../uploadmamafiles/" . $uploadname;
                        
			$OtherLoc=$myrow["OtherLocation"];
			$Country=$myrow["country"];
			$Tel=$myrow["Telephone"];
			$Fax=$myrow["Fax"];
			$Email=$myrow["Email"];
			$AddInfo=$myrow["AdditionalInfor"];
			$stockcode=$myrow["stockcode"];
			$yearfounded=$myrow["yearfounded"];
			$website=$myrow["website"];
                        $linkedIn=$myrow["linkedIn"];
                        $linkedin_compname=$myrow["linkedin_companyname"];
                       // echo "<bR>^^^^^^^^*********^^^^^^^^^^^^^^^^" .$linkedin_compname;

			$companyName=trim($myrow["companyname"]);
			$companyName=strtolower($companyName);
			$compResult=substr_count($companyName,$searchString);
			$compResult1=substr_count($companyName,$searchString1);
                        $compResult2=substr_count($companyName,$searchString2);
			$webdisplay="";
      if($myrow["CINNo"] != ''){
        $cinno = $myrow["CINNo"];
      }else{
        $cinno = 0;
      }
			$google_sitesearch="https://www.google.co.in/search?q=".$companyName."+site%3Alinkedin.com";
                        $companyurl=  urlencode($companyName);
                        $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";
			$google_sitesearch_mgmt="";
                        //$linkedin_url="http://www.linkedin.com/company/".$companyName; }

			//if($linkedin_compname!="")
			//{ 	$linkedin_url="http://www.linkedin.com/company/".$linkedin_compname; }


			//echo "<br>----" .$linkedin_url;
                           }
                          
                        
                        if(($compResult==0) && ($compResult1==0))
	    		{
	    			$webdisplay=$website;
    
    ?>
    
   <div class="view-detailed view-detailed1"> 
    <?php
    if(mysql_num_rows($companyrs)>0){  
        
    $value =$_GET['value'];
    $strvalue = explode("/", $value);
    
    }
    ?>
       
       
    <!-- new -->
  <?php
  
  if($angelco_compID !=''){
      
     // echo $angelco_compID; exit;
      
    /*$profileurl ="https://api.angel.co/1/startups/$angelco_compID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
      
    //role=founder&
    $roleurl ="https://api.angel.co/1/startups/$angelco_compID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
   
   

                $profilejson = file_get_contents($profileurl);
    $profile = json_decode($profilejson);*/
      $profileurl =GLOBAL_BASE_URL."/cron_job/angelfrominfo.php?name=profile&angelco_compID=$angelco_compID";
    $profilejson = file_get_contents($profileurl);
    $profile = json_decode($profilejson);
      $profileurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=role&angelco_compID=$angelco_compID";
    $rolejson = file_get_contents($roleurl);
    $roles = json_decode($rolejson);
    $roles = $roles->startup_roles;
    
    
//   echo "<pre>";
//   print_r($roles);
//   echo "</pre>";
  //  exit;
    
     
  }
  ?>
    
<div class="com-wrapper">
	<section class="com-cnt-sec">
    	<header>
            <h3 style="float:left">Company Profile</h3> 
                <?php
                    if(($exportToExcel==1) && (!isset($_REQUEST['angelco_only'])))
                    {
                    ?>
                                    <span style="float:right;margin-top: 5px;margin-right: 5px;" class="one">
                                             <input class ="export" type="button" id="expshowdealsbtn1"  value="Export Co. Profile" name="showdeals">
                                    </span>
                    <?php
                    }
                    ?>
         </header>
            
         <?php  if($angelco_compID !='' && $profile->id > 0){ ?>
         <div class="com-col">
             <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
         <div class="com-sec-lg bor-top-cnt">
         	<div class="co-home-ground border-btm pad-top-no">
            	<img src="<?php echo $profile->logo_url ?>" alt="<?php echo $profile->name ?>">
                <address class="fl">
                	<strong> <?php echo $profile->name ?> </strong>
                    <span> <?php echo $profile->high_concept ?> </span>
                    <p>
<!--                        Mumbai · Specialty Foods · Food Processing · South East Asia-->
                        <?php
                        $places ='';
                        foreach ( $profile->locations as $locations){
                            $places .=$locations->display_name." - ";
                        }
                        
                        foreach ( $profile->markets as $markets){
                            $places .=$markets->display_name." - ";
                        }
                        
                        echo rtrim($places,'- ');
                        
                        ?>
                    
                    </p>
                </address>
            </div>
             
           <?php if($profile->product_desc) { ?>
            <div class="com-pro-cnt border-btm">
            	<h3 class="com-sub-title">Product</h3>
                <p> <?php echo $profile->product_desc ?> </p>
            </div>
           <?php } ?>  
             
             
            <?php 
            $rolescount=0;
            foreach ($roles as $ro) {  if($ro->role == 'founder') { $rolescount++; } }
            
            if($rolescount > 0) { ?> 
            <div class="com-founder-cnt border-btm no-bor">
            	<h3 class="com-sub-title">FOUNDER</h3>
                
                <?php foreach ($roles as $ro) {  
                    if($ro->role == 'founder') { 
//                            echo "<pre>";
//                            print_r($ro);
//                            echo "</pre>";
                ?>
                <div class="fonder-detail-com">
                	<img src="<?php echo $ro->tagged->image ?>" alt="<?php echo $ro->tagged->name ?>">
                    <div class="fon-det-sec fl">
                    	<h4 class="founder-name-com"><?php echo $ro->tagged->name ?></h4>
                        <span><?php echo $ro->title ?></span>
                        <p><?php echo $ro->tagged->bio ?></p>
                    </div>
                </div>
                <?php } } ?> 
                
            </div>
             <?php } ?> 
             
            </div>
            
         </div>
        <?php } ?>
            
            
            <?php if(mysql_num_rows($companyrs)>0){ ?>
            
         <div class="com-col">
             <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
         	<div class="com-address-cnt bor-top-cnt">

                    <div>
                        <span style="float:right;text-decoration: underline;font-size: 18px;color:#624C34;font-weight: bolder;cursor:pointer;" id="allfinancial">Financials</span>
                    </div>

                    <?php 
                    if ($myrow["Investor"] != "") 
                    { ?>                                        

                          <div class="com-add-li">
                                          <h6>Investor</h6>
                                      <span><?php echo $myrow["Investor"]; ?></span>
                          </div>
                    <?php
                    }
                    if($industry!="")
                  {
                  ?>

                          <div class="com-add-li">
                              <h6>INDUSTRY</h6>
                          <span> <?php echo $industry;?></span>
                          </div>

                  <?php }
                  if($sector!="")
                  {
                  ?>
                          <div class="com-add-li">
                             <h6>SECTOR</h6>
                          <span><?php echo $sector;?></span>
                          </div>

                  <?php }
                  if($stockcode!="")
                  {
                  ?>
                          <div class="com-add-li">
                             <h6>STOCK CODE</h6>
                          <span><?php echo $stockcode;?></span>
                          </div>
                  <?php }
                   if ($Address1 != "" || $Address2 != "") 
                   { ?>
                                        <div class="com-add-li">
                                          <h6>ADDRESS</h6>
                                      <span> <?php echo $Address1; ?><?php if ($Address2 != "") echo "<br/>" . $Address2; ?></span>
                                  </div>


                     <?php
                  }
                  if ($AdCity != "") 
                  { ?>
                                      <div class="com-add-li">
                                          <h6>CITY</h6>
                                      <span><?php echo $AdCity; ?></span>
                                  </div>


                      <?php
                      }
                      if(($Country!="")&&($Country!="--" ))
                      {
                    ?>
                                  <div class="com-add-li">
                                          <h6>COUNTRY</h6>
                                      <span> <?php echo $Country; ?></span>
                                  </div>

                     <?php
                     }
                    if (($Zip != "") || ($Zip > 0)) 
                        { ?>
                                  <div class="com-add-li">
                                          <h6>ZIP</h6>
                                      <span><?php echo $Zip; ?></span>
                                  </div>

                     <?php
                  }
                   if (($Tel != "") || ($Tel > 0)) {
                     ?>
                                  <div class="com-add-li">
                                          <h6> TELEPHONE</h6>
                                      <span><?php echo $Tel ?></span>
                                  </div>
                  <?php
                   }
                   if(($Fax!="")|| ($Fax>0)) 
                  {
                  ?>
                                  <div class="com-add-li">
                                          <h6>FAX</h6>
                                      <span><?php echo $Fax; ?></span>
                                  </div>
                  <?php }
                  if (trim($Email) != "") {
                      ?>
                                  <div class="com-add-li">
                                          <h6>EMAIL</h6>
                                      <span><?php echo $Email; ?></span>
                                  </div>
                     <?php
                      }

                      if ($yearfounded != "" && $yearfounded >0) {
                          ?>
                                  <div class="com-add-li">
                                          <h6>YEAR FOUNDED </h6>
                                      <span><?php echo $yearfounded; ?></span>
                                  </div>

                      <?php
                      }
                  if(trim($OtherLoc)!="") 
                  {
                  ?>
                                  <div class="com-add-li">
                                          <h6>OTHER LOC</h6>
                                      <span><?php echo $OtherLoc; ?></span>
                                  </div>

                  <?php }
                  if (trim($website) != "") 
                    { ?>
                                  <div class="com-add-li">
                                          <h6>WEBSITE</h6>
                                      <span><a href="<?php echo $website; ?>" target="_blank"> Click Here  </a> </span>
                                  </div>

                     <?php
                      }

                      if ($company_newssearch != "") 
                    { 
                    ?>
                                  <div class="com-add-li">
                                          <h6>NEWS</h6>
                                      <span> <a href="<?php echo $company_newssearch; ?>"  target="_blank"> Click Here </a> </span>
                                  </div>

                     <?php
                      }?> 

                        <div class="com-add-li">
                            <h6>M&A Deals</h6>

                            <span> <a  href='<?php echo BASE_URL; ?>malogin.php?search=<?php echo $compname;?>'  target="_blank"> Click Here </a> </span>
                        </div>
                    <?php 
                    
                    /* if($linkedIn!=''){          
                        $url = $linkedIn;
                        $keys = parse_url($url); // parse the url
                        $path = explode("/", $keys['path']); // splitting the path
                        $companyid = (int)end($path); // get the value of the last element  
                     }*/
                    
//                    if ($companyid != "") 
//                    {  
                     if($linkedIn!=''){  
                        ?>
                                  <div class="com-add-li"  id="viewlinkedin_loginbtn" >
                                          <h6>VIEW LINKEDIN PROFILE</h6>
                                           <span> <a href="<?php echo $linkedIn; ?>"  target="_blank"> Click Here </a> </span>
                                      <!-- <span><script type="in/Login"></script></span> -->
                                  </div>

                  <!--  <li id="viewlinkedin_loginbtn" style="display: none"><h4>  </h4><p><script type="in/Login"></script></p></li>-->
                    <?php 
                  }
//                     }
  
                    
                    if (trim($AddInfo) != "") 
                    { ?>
                                      <div class="com-add-li" >
                                          <h6>ADDITIONAL INFORMATION </h6>
                                      <span><?php echo $AddInfo; ?></span>
                                  </div>


                     <?php
                      } ?>
                    <div style="clear:both;"></div>
                    
        <?php
                    if($rsMgmt= mysql_query($onMgmtSql))
        {
             $mgmt_cnt = mysql_num_rows($rsMgmt);
        }
        if($mgmt_cnt>0)
        {   
        ?>

        <div  class="work-masonry-thumb  com-inv-sec   col-2" style="float:left" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Top Management</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th></tr></thead>
        <tbody>
             <?php
                if($rsMgmt= mysql_query($onMgmtSql))
                //{
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
        } ?>
                    
    <?php if($rsBoard= mysql_query($onBoardSql))
    {
         $board_cnt = mysql_num_rows($rsBoard);
    }
    if($board_cnt>0)
    {
    ?>
      <div  class="work-masonry-thumb  com-inv-sec   col-2" style="float:left" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Investor Board Member</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th> <th>LinkedIn</th></tr></thead>
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
        } ?>
                       
            </div>
            
         </div>
         
                 
                  <!-- LINKED IN START -->
                  
                    <!--  <?php 
                   
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

                     $linkedinSearchDomain=  str_replace("http://www.", "", $webdisplay); 
                       $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
                        if(strrpos($linkedinSearchDomain, "/")!="")
                        {
                           $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
                        }
                    if($linkedinSearchDomain!=""){ ?> -->
                 <!--  <img src="images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;"> -->
                 <!--  <div class="com-col linkedindiv"  style="display: none">
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
                   ?> -->
                  
                  <!-- LINKED IN END -->
                  
                 
            
            
            <?php } ?>
            
    </section>
    
    <section class="com-cnt-sec">
        
        
        <?php
         $rolescount2=0;
         foreach ($roles as $ro) {  if($ro->role == 'past_investor' || $ro->role == 'current_investor') { $rolescount2++; } }
        
        
        if(mysql_num_rows($companyrs)>0 || $rolescount2>0  ){ ?>
        
    	<header>
        	<h3>INVESTMENTS</h3>
        </header>
        
        <?php } ?>
        
        
        <div class="com-col" id="ventureInvestment">
           
            <div style="margin:0 15px">
            <div class="company-cnt-sec">
                 <span class="">INVESTMENTS from Our Database</span>
                 <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
            <div class="vicomp-cnt">
            </div>
                
            </div>
            </div>
            
            
        <div class="postContainer postContent masonry-container " >  
    
  
    
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
      
    
    
    <div  class="work-masonry-thumb  com-inv-sec   col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>PE/VC Investors</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
    <thead><tr><th>Investor Name</th> <th>Deal Period</th></tr></thead>
    <tbody>
         <?php

            $addTrancheWord ="";
            $addDebtWord="";
            $addTrancheWordtxt = "";
            While($myInvestorrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                    {
                            $Investorname=trim($myInvestorrow["Investor"]);
                            $Investorname=strtolower($Investorname);
                            $invResult=substr_count($Investorname,$searchString);
                            $invResult1=substr_count($Investorname,$searchString1);
                            $invResult2=substr_count($Investorname,$searchString2);
                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                            {
                               $addTrancheWord="";
                               $addDebtWord="";
                                if(($pe_re==0) || ($pe_re==1) || ($pe_re==8) )
                                {
                                    if($myInvestorrow["AggHide"]==1){
                                        $addTrancheWord = "; NIA";
                                        $addTrancheWordtxt = $addTrancheWord;
                                    }
                                    else{
                                        $addTrancheWord="";
                                    }
                                }
                                else
                                    $addTrancheWord="";
                                    if($myInvestorrow["SPV"]==1)
                                        $addDebtWord="; Debt";
                                    else
                                        $addDebtWord="";

            ?>
        <?php $deal=0; ?>
        <tr><td style="alt">
          <a href='<?php echo $invpage;?>?value=<?php echo $myInvestorrow["InvestorId"].'/'.$VCFlagValue.'/'.$deal;?>' title="Investor Details" target="_blank"><?php echo $myInvestorrow["Investor"]; ?></a>
        </td>
            <td><a href="dealdetails.php?value=<?php echo $myInvestorrow["DealId"].'/'.$VCFlagValue;?>" title="Deal Details"><?php echo $myInvestorrow["dt"];?></a><?php echo $addTrancheWord;?><?php echo $addDebtWord;?></td>                                                          
 <?php 
      }
       } 
?>  
    </tbody>
    </table> 
    <?php if($addTrancheWordtxt == "; NIA"){ ?>
        <p class="note-nia">*NIA - Not Included for Aggregate</p>
    <?php }?>
    </div>
 <?php
    }
    if($incrs= mysql_query($incubatorSql))
        {
             $incubator_cnt = mysql_num_rows($incrs);
        }
        if($incubator_cnt>0)
        {
            
    ?>   
    
   <div  class="work-masonry-thumb  com-inv-sec   col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
    <!-- <h2>Incubators</h2> -->
    <h2>Incubation</h2>
    <table width="100%" cellpadding="0" cellspacing="0" class="tableview">
      <thead><tr><th>Incubator Name</th><th>Deal Period</th></tr></thead>
      <tbody>
        <?php  
            While($incrow=mysql_fetch_array($incrs, MYSQL_BOTH))
            {
                $incubator=$incrow["Incubator"];
                $incubatorId=$incrow["IncubatorId"];
                $incubatordate=$incrow["dt"];?>
        <tr><td><a href='incubatordetails.php?value=<?php echo $incubatorId.'/'.$VCFlagValue;?>' title="Incubator Details"> <?php echo $incubator;?> </a> </td>
            <td><a href='incubatordetails.php?value=<?php echo $incubatorId.'/'.$VCFlagValue;?>' > <?php echo $incubatordate;?></a></td>
        </tr>
         <?php  }?>
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
            <div  class="work-masonry-thumb  com-inv-sec   col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
            <h2>PE/VC Exits</h2>
            <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
            <thead><tr><th>Deal Type</th><th>Investor(s)</th> <th>Deal Period</th> <th>Status</th></tr></thead>
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
                       <tr><td style="alt">IPO</td><td><?php echo $ipoexitrow["Investor"];?></td>

                        <td> <a href='ipodealdetails.php?value=<?php echo $ipoexitrow["IPOId"].'/'.$VCFlagValue;?>'><?php echo $ipoexitrow["dt"];?></a></td>

                        <td><?php echo $exitstatusdisplayforIPO;?></td>
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

                        <tr><tr><td style="alt"><!--M&A--> <?php echo $mymandaexitrow["DealType"] ?></td><td><?php echo $mymandaexitrow["Investor"];?></td>

                        <td> <a href='mandadealdetails.php?value=<?php echo $mymandaexitrow["MandAId"].'/'.$VCFlagValue;?>'><?php echo $mymandaexitrow["dt"];?></a></td>

                        <td><?php echo $exitstatusdisplay;?></td>
                        </tr>
                        <?php
                        } 
                       ?>  
            </tbody>
            </table> 
            </div>
         <?php
            }
            
    /*    if($myrow["uploadfilename"]!="" || mysql_num_rows($company_link_Sql)>0 )
        {   
        ?>

        <div  class="work-masonry-thumb  com-inv-sec   col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>FINANCIALS INFO</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <tbody>
<!--             <?php

              //  if($finlink!="")
              //  {
                ?>
                    <tr><td ><h4>Link for Financials
                            </h4><p style="word-break: break-all;"><a target="_blank" href=<?php //echo $finlink; ?> ><?php //echo $finlink; ?></a></p></td></tr>

                <?php
              //  } 
                ?>-->
                
                
<?php                 
if($myrow["uploadfilename"]!="")
{
        ?>
                <?php
                if($exportToExcel==1)
                 {
                 ?>
                <tr>
                    <td class="txtBold"><a href="<?php echo $file;?>" target="_blank" > Download Excel File </a></td>
                </tr>
                <tr>
                    <td class="txtBold"><a href="<?php echo GLOBAL_BASE_URL; ?>cfsnew/comparers.php" target="_blank">View in CFS Database</a></td>
                </tr>
                 <?php
                 }
                else
                 {
                 ?>
                <tr>
                             <td>&nbsp;Paid Subscribers can view a link to the co. financials here </td> </tr>
                 <?php
                  }
                 ?>
               
        <?php
} 
        ?>
        
        
        
        <!-- pecompany links -->
         <?php if(mysql_num_rows($company_link_Sql)>0){ ?>
        <tr> <td><h4> Links & Comments </h4></td><td>
  
         <?php while($com_links_com = mysql_fetch_array($company_link_Sql)) { ?>
         <p style="font-weight: normal;margin:2px  0 8px;line-height: 20px;"><a href='<?php echo $com_links_com['Link']?> ' target="_blank" style="font-weight: bold;"> <?php echo $com_links_com['Link']?>  </a> <br> <?php echo $com_links_com['Comment']?>  </p> 
        <?php } ?>
         </td></tr>
        <?php } ?>
        <!-- end pecompany links -->
        
     </tbody>
        </table> 
        </div>   
        <?php
        }*/
      ?>
    
            
            
            
             <?php
        if($rsangel= mysql_query($angelinvsql))
            {
                 $angel_cnt = mysql_num_rows($rsangel);
            }
            if($angel_cnt>0)
            {                   
        ?>
        
         <div   class="work-masonry-thumb  com-inv-sec   col-2 masonry-brick" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
            <h2>Angel Investments</h2>
            <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
            <thead><tr><th>Investor Name</th> <th>Deal Period</th></tr></thead>
            <tbody>
             <?php

                While($angelrow=mysql_fetch_array($rsangel, MYSQL_BOTH))
                {
                  $Investorname=trim($angelrow["Investor"]);
                $Investorname=strtolower($Investorname);
                $hide_agg = $angelrow['AggHide'];
                $invRes=substr_count($Investorname,$searchString);
                        $invRes1=substr_count($Investorname,$searchString1);
                        $invRes2=substr_count($Investorname,$searchString2);


                        if(($invRes==0) && ($invRes1==0) && ($invRes2==0))
                        {
                            if($hide_agg==0) {

?>
                        <tr><td style="alt"><a href='angleinvdetails.php?value=<?php echo $angelrow["InvestorId"].'/'.$VCFlagValue;?>' ><?php echo $angelrow["Investor"]; ?></a></td>

                        <td> <a href="angeldealdetails.php?value=<?php echo $angelrow["AngelDealId"].'/'.$VCFlagValue;?>">
                                                <?php echo $angelrow["dt"];?></a></td></tr>

<?php
                            } else { ?>
                                <tr><td style="alt"><?php echo $angelrow["Investor"]; ?></td>

                        <td> <a href="angeldealdetails.php?value=<?php echo $angelrow["AngelDealId"].'/'.$VCFlagValue;?>">
                                                <?php echo $angelrow["dt"];?></a></td></tr>
                        <?php } }
                        elseif(($invRes==1) || ($invRes1==1) || ($invRes2==1))
                        {
                          $AddUnknowUndisclosedAtLast=$angelrow["Investor"];
                          $dealid=$angelrow["AngelDealId"];
                                $dtdisplay=$angelrow["dt"];
                        }
                        elseif($invRes2==1)
                        {
                          $AddOtherAtLast=$angelrow["Investor"];
                          $dealid=$angelrow["AngelDealId"];
                          $dtdisplay1=$angelrow["dt"];
                          }

                }

            // if($AddUnknowUndisclosedAtLast!="")
            //{
              ?>
            </tbody>
            </table> 
           
            </div>
           

            
    <?php
            } ?>
           
         
         
         </div>
        
       
        </div>
        
        <!-- Angel Only Start -->
       
        <?php         
            if($rolescount2 > 0) { ?> 
            
        <div class="com-col" style="padding: 20px">
             
            <div class="investment-cnt-com">
                <div class="company-cnt-sec">
                <span class="">INVESTORS from previous rounds</span>
                <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
                </div>
                 <?php foreach ($roles as $ro) {  
                    if($ro->role == 'past_investor' || $ro->role == 'current_investor') { ?>
                <div class="com-investment-profile">
                    
                    <?php if($ro->tagged->image) { ?>
                    <img src="<?php echo $ro->tagged->image ?>" alt="<?php echo $ro->tagged->name ?>">
                    <?php }elseif($ro->tagged->thumb_url) { ?>
                    <img src="<?php echo $ro->tagged->thumb_url ?>" alt="<?php echo $ro->tagged->name ?>">
                    <?php } ?>
                    
                    
                    <div class="inver-pro-sec">
                        <?php
                         $InvQuery = mysql_query("SELECT InvestorId FROM peinvestors where angelco_invID='".$ro->tagged->id."' LIMIT 1"); 
                        $Invcount = mysql_num_rows($InvQuery);
                        if($Invcount>0) {
                            $Invalue = mysql_fetch_array($InvQuery);
                        ?>
                        <h5><a href="angleinvdetails.php?value=<?php echo $Invalue['InvestorId'];?>/2"><?php echo $ro->tagged->name ?></a></h5>
                        <?php } else { ?>
                        <h5><a href="angleinvdetails.php?value=<?php echo $ro->tagged->id?>/2&angelco_only"><?php echo $ro->tagged->name ?></a></h5>
                        <?php } ?>
                       
                        <?php if($ro->role == 'past_investor'){?>
                        <span style="font-size: 14px;font-weight: bold;"> Past Investor </span>
                        <?php } else if($ro->role == 'current_investor'){?>
                        <span style="font-size: 14px;font-weight: bold;"> Current Investor </span>
                        <?php } ?>
                        
                        
                        <p>
                            <?php  if($ro->tagged->bio) { echo $ro->tagged->bio; } elseif($ro->tagged->high_concept){ echo $ro->tagged->high_concept; } ?>
                        </p>
                    </div>
                </div>
                 <?php } } ?>

            </div>
           
         </div>
            
        <?php } ?>
                
       
            
        <!-- Angel Only Start -->
        
    </section>
    
    <?php 
                    if ($myrow["tags"] != "") 
                    { 
                            ?>      
	<section class="com-cnt-sec relatedCompany">
    	<header>
    		<h3>Related Companies</h3>
         </header>
            
         <div class="com-col">
             <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
            <div class="com-address-cnt bor-top-cnt">
             <?php 
                $company_id = array();$s=0; 
                $ex_tags = explode(',',$myrow["tags"]);
                 if(count($ex_tags) > 0){
                    for($k=0;$k<count($ex_tags);$k++){
                        if($ex_tags[$k] !=''){
                            $ex_tags_inner = explode(':',$ex_tags[$k]);
                            $inner_tag = trim($ex_tags_inner[0]);
                            $inner_tag_val = trim($ex_tags_inner[1]);
                            if($inner_tag =='c') {
                                $CompanyQuery = mysql_query("SELECT PECompanyId,companyname FROM pecompanies where (tags like '%c:$inner_tag_val%' or tags like '%c: $inner_tag_val%' or tags like '%c : $inner_tag_val%'     or tags like '%c : $inner_tag_val%') and PECompanyId != '$SelCompRef'");
                                if(mysql_num_rows($CompanyQuery) >0){ ?>
                <div <?php if($s != 0) { ?>style="border-top: 1px solid #d4d4d4;"<?php } ?>>
                <?php
                                    while($myrow1=mysql_fetch_array($CompanyQuery, MYSQL_BOTH))
                                    { 
                                        if(!in_array($myrow1["PECompanyId"], $company_id)){                                    
                                            $company_id[] = $myrow1["PECompanyId"]; ?>
                                            <div class="com-add-li">
                                                <span>
                                                  <!-- <a href="companydetails.php?value=<?php echo $myrow1["PECompanyId"].'/'.$VCFlagValue.'/';?>"><?php echo $myrow1['companyname']; ?></a> -->
                                                  <a href="companydetails.php?value=<?php echo $myrow1["PECompanyId"].'/'.$VCFlagValue.'/';?>" target="_blank"><?php echo $myrow1['companyname']; ?></a>
                                                </span>
</div>
                                    <?php  }                                  
                                    } ?>
                    <div style="clear:both"></div>
                </div>
                <?php  $s++; 
                                }
                            }
                        }
                    }
                } ?>                     
            </div>  
         </div>
    
    </section>    
	<section class="com-cnt-sec tags">
    	<header>
    		<h3>TAGS</h3>
         </header>
    
         <div class="com-col">
            <div class="com-address-cnt bor-top-cnt">
             <?php $ex_tags = explode(',',$myrow["tags"]);
             if(count($ex_tags) > 0){
                for($k=0;$k<count($ex_tags);$k++){
                    if($ex_tags[$k] !=''){
                        $ex_tags_inner = explode(':',$ex_tags[$k]);
                        $inner_tag = trim($ex_tags_inner[1]);
                        if($inner_tag !='' && trim($ex_tags_inner[0]) != 'c') {  ?>
                            <div class="com-add-li">
                                <span><a href="javascript:void(0)" class="tags_link"><?php echo $inner_tag; ?></a></span>
                            </div>             
                    <?php }
                    }
                }
            } ?>                     
            </div>  
         </div>
<!--Header-->
<?php if($vcflagValue=="0" || $vcflagValue=="1")
{
    $actionlink1="index.php?value=".$vcflagValue;
}
else if($vcflagValue=="4" || $vcflagValue=="5" || $vcflagValue=="3")
{
        $actionlink1="svindex.php?value=".$vcflagValue;
}
else if($vcflagValue=="6"){
        $actionlink1="incindex.php";
}else if($vcflagValue=="2"){
     $actionlink1="angelindex.php";
}
?>
    </section>
                    <?php
                    }?>
</div>
    
    
<!-- -->    
    
    
    
    

                                                        
      <?php
                        }
                    }
                }
                    ?>                       
  </div>

</td></tr></table>
</form></div></span>
</div>
            <form action="<?php echo $actionlink1; ?>" name="tagForm" id="tagForm"  method="post">
                <input type="hidden" value="" name="searchTagsField" id="searchTagsField" />
              </form>

<form name="companyDisplay"  id="companyDisplay" method="post" action="exportcompanyprofile.php">
 <input type="hidden" name="txthideCompanyId" value="<?php echo $myrow['PECompanyId'];?>" >
			<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>  

<script type="text/javascript">
     
     
     $(document).ready(function() {
        var ventureInvestment =  $( "#ventureInvestment" ).has( "td" ).length ;
        if(ventureInvestment==0){ $( ".vicomp-cnt, #ventureInvestment" ).hide() ;   }
             
        
     });
     
     </script>
 <script type="text/javascript">
			
            $('.tags_link').click(function(){ 
                    $("#searchTagsField").val('tag:'+$(this).html());
                    $('#tagForm').submit();
                });	
           /* $('#expshowdeals,.exlexport').click(function(){ 
                    hrefval= 'exportcompanyprofile.php';
            $("#companyDisplay").attr("action", hrefval);
            $("#companyDisplay").submit();
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
     
           /* $('#expshowdeals').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });

                $('#expshowdealsbtn').click(function(){ 
                    jQuery('#preloading').fadeIn();  
                    initExport();
                    return false;
                });*/
            $('#expshowdeals').click(function(){ 
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
                
                });
               
            $('#expshowdealsbtn').click(function(){ 
                /*jQuery('#preloading').fadeIn();   
                initExport();
                return false;*/
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });
               
                $('#expshowdealsbtn1').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport1();
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
               
                function initExport1(){
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
                                    //hrefval= 'exportinvdeals.php';
                                    //$("#pelisting").attr("action", hrefval);
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
                data: { to : $("#toaddress").val(),subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
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
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>

<script>
</body>
</html>
<script>
                                    
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
<style>
    .com-investment-profile{
        width: 33%
    }
    .bor-top-cnt{
        border-top: 1px solid #e4e4e4;
        clear: both;
        padding-top: 10px;
    }
    .mar-top {
        margin: 0px 15px 10px;
    }
    .inv-lf-li{
        min-height: 100px;
    }
    .note-nia{
        position: absolute;margin-top: 5px;font-size: 13px;margin-bottom: 0px;
    }
</style>
<?php } ?>