<?php
    require_once("reconfig.php");
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    include ('checklogin.php');
    $value = isset($_GET['value']) ? $_GET['value'] : '';
    $strvalue = explode("/", $value);
    $investorId=$strvalue[0];
    $vcflagValue=$strvalue[1];
    $dealvalue=$strvalue[2];
//GET PREV NEXT ID
    $prevNextArr = array();
    $prevNextArr = $_SESSION['investeeId'];
    $currentKey = array_search($investorId,$prevNextArr);
    $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1;
    $nextKey = $currentKey+1;
    $pe_re= 2;
    $numofcount=$_SESSION['numberofcom'];
    $dealpage="redirdetails.php";

    $exportToExcel=0;
    $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,RElogin_members as dm where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
    //echo "<br>---" .$TrialSql;
    if($trialrs=mysql_query($TrialSql))
    {
        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
        {
            $exportToExcel=$trialrow["TrialLogin"];
        }
    }

    $resetfield=$_POST['resetfield'];

    if($resetfield=="keywordsearch")
    {
        $_POST['keywordsearch']="";
        $keyword="";
    }
    else
    {
        $keyword=trim($_POST['keywordsearch']);
    }

    if($resetfield=="industry")
    {
        $_POST['industry']="";
        $industry="";
    }
    else
    {
        $industry=trim($_POST['industry']);
    }

    if($resetfield=="stage")
    {
        $_POST['stage']="";
        $stageval="";
    }
    else
    {
        $stageval=$_POST['stage'];
    }
    if($_POST['stage'] && $stageval!="")
    {
        $boolStage=true;
    }
    else
    {
        $stage="--";
        $boolStage=false;
    }

    if($resetfield=="invType")
    {
        $_POST['invType']="";
        $investorType="";
    }
    else
    {
        $investorType=trim($_POST['invType']);
    }

    if($resetfield=="range")
    {
        $_POST['invrange']="";
        $range="--";
    }
    else
    {
        $range=$_POST['invrange'];
    }

    $whereind="";$whereinvType="";$wherestage="";$wheredates="";$whererange="";

    if($resetfield=="period" && !$_GET)
    {
        
        $_POST['month1']=$_POST['month2']=$_POST['year1']=$_POST['year2']="";
        $month1=01;
        $year1 = 2005;
        $month2=date('n');
        $year2 = date('Y');
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

    if($resetfield=="searchallfield")
    {
        $_POST['searchallfield']="";
        $searchallfield="";
    }
    else
    {
        $searchallfield=trim($_POST['searchallfield']);
    }

    if($resetfield=="dirsearch")
    {
        $_POST['dirsearch']="";
        $dirsearch="";
    }
    else
    {
        $dirsearch=trim($_POST['dirsearch']);
    }

    $searchString="Undisclosed";
    $searchString=strtolower($searchString);
    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);
    $searchString2="Others";
    $searchString2=strtolower($searchString2);

    if($range != "--")
    {
        $rangesql= "select startRange,EndRange,RangeText from investmentrange where InvestRangeId=". $range ." ";
        if ($rangers = mysql_query($rangesql))
        {
            While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
            {
                $startRangeValue=$myrow["startRange"];
                $endRangeValue=$myrow["EndRange"];
                $RangeText=$myrow["RangeText"];
            }
        }
    }

    if($investorType !="")
    {
        $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
        if ($invrs = mysql_query($invTypeSql))
        {
            While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
            {
                $invtypevalue=$myrow["InvestorTypeName"];
            }
        }
    }
    if($industry >0){
        $indvalue="and c.industry =".$industry;
        $indvalue_investment="and peinv.IndustryId =".$industry;
    }
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

    if($boolStage==true)
    {
        foreach($stageval as $stageid)
        {
            $stagesql= "select REType from realestatetypes where RETypeId=$stage";
            //  echo "<br>**".$stagesql;
            if ($stagers = mysql_query($stagesql))
            {
                While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                {
                    $stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
                }
            }
        }
        $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
    }
    else
    {
        $stagevaluetext="";
    }
//Query section
    $sql="select * from REinvestors where InvestorId=$investorId";

    $iposql="select peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,c.companyname,DATE_FORMAT( peinv.IPODate, '%b-%Y' ) as dealperiod,inv.*
    from REipo_investors as peinv_inv,REinvestors as inv,REipos as peinv,REcompanies as c 
    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId and peinv.Deleted=0 and peinv.IPOId=peinv_inv.IPOId and 
    c.PECompanyId=peinv.PECompanyId $indvalue";

    $mandasql="select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,c.companyname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,inv.*
    from REmanda_investors as peinv_inv,REinvestors as inv,REmanda as peinv,REcompanies as c
    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId 
    and peinv.Deleted=0 $indvalue order by DealDate desc";

    $onMgmtSql="select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
    from REinvestors as pec,executives as exe,REinvestors_management as mgmt
    where pec.InvestorId=$investorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";
    
    $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,SPV,inv.*
    from REinvestments_investors as peinv_inv,REinvestors as inv,REinvestments as peinv,REcompanies as c
    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId 
    and peinv.Deleted=0 $indvalue_investment and c.PECompanyId=peinv.PECompanyId order by peinv.dates desc";
    
    if($industry > 0){
        $ind_where = " and peinv.IndustryId ='$industry' ";
    }else{
        $ind_where = "";
    }
    $indSql= " SELECT DISTINCT i.industry as ind, peinv.IndustryId, peinv_inv.InvestorId
    FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
    WHERE peinv_inv.InvestorId =$investorId AND inv.InvestorId = peinv_inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
    AND peinv.PEId = peinv_inv.PEId AND i.industryid = peinv.IndustryId $ind_where  order by i.industry";

    $stageSql= "select distinct s.REType,pe.StageId,peinv_inv.InvestorId
    from REinvestments_investors as peinv_inv,REinvestors as inv,REinvestments as pe,realestatetypes as s
    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
    and pe.PEId=peinv_inv.PEId and s.ReTypeId=pe.StageId and REType!='' order by REType ";
//Query section ends
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
//Header section starts
    $topNav = 'Directory';
    include_once('redirectory_header.php');
//Header section ends
?>
 <input type="hidden" name="resetfield" value="" id="resetfield"/>
<style>
.closetagspacedir{
    margin-top: 15px !important;
}
.overview-cnt{
    margin-bottom:0px;
}
.result-cnt {
    padding: 10px 20px 20px 20px;
}
.result-title{
    padding: 10px 0 20px;
}
</style>
<div id="container" >
    <table cellpadding="0" cellspacing="0" width="100%" >
        <tr>
            <td class="left-td-bg">
                <div class="acc_main">
                    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
                    <div id="panel" style="display:block; overflow:visible; clear:both;">
                        <?php include_once('redirrefine.php'); ?>
                    </div>
                </div>
            </td>
            <td class="profile-view-left" style="width:100%;">
                <div class="result-cnt">
                    <div class="result-title result-title-nofix">
                    <?php if(!$_POST){ ?>
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
                            <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                            <?php  if(($exportToExcel==1)){ ?>
                                    <span id="exportbtn"></span>
                            <?php } ?>
                        </div>
                     </div>
                    <?php }else{ ?>
                        <h2>
                            <span class="result-no" id="show-total-deal"> <?php echo $numofcount; ?> Results found</span>
                            <span class="result-for">for PE-RE Directory</span>
                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $numofcount; ?>">
                        </h2>
                        <div class="title-links">
                            <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                            <?php if(($exportToExcel==1)) { ?>
                                <span id="exportbtn"></span>
                            <?php } ?>
                        </div>
                        <ul class="result-select closetagspace closetagspacedir">
                        <?php
                        if($industry >0 && $industry!=null){ ?>
                            <li title="Industry">
                                <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                        <?php }
                        if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                            <li>
                                <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                        <?php }
                        if($investorType !="--" && $investorType!=null){ ?>
                            <li>
                                <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                        <?php }
                        if (($range!= "--") && ($range != "")){ ?>
                            <li>
                                <?php echo "(USM)".$startRangeValue ."-" .$endRangeValue ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                        <?php }
                        if($datevalueDisplay1!=""){ ?>
                            <li>
                                <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                        <?php }
                        if($keyword!="") { ?>
                            <li>
                                <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                        <?php }
                        $_POST['resetfield']="";
                        foreach($_POST as $value => $link)
                        {
                            if($link == "" || $link == "--" || $link == " ")
                            {
                                unset($_POST[$value]);
                            }
                        }
                        //print_r($_POST);
                        $cl_count = count($_POST);
                        if($cl_count > 5)
                        {
                        ?>
                        <li class="result-select-close"><a href="redirview.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php }?>
                </div>
                <?php if ($rsinvestors = mysql_query($sql)) { 
                    
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
                            $investorurl=  urlencode($myrow["Investor"]);
                            $investor_newssearch="https://www.google.co.in/search?q=".$investorurl."+site:ventureintelligence.com/ddw/";
                ?>
                <div class="overview-cnt"></div>
                <div class="list-tab "><ul>
                    <li ><a class="postlink"  href="redirview.php?value=<?php echo $vcflagValue; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
                    <li class="active"><a id="icon-detailed-view" class="postlink" href="" ><i></i> Detail  View</a></li>
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
        <p>Checkout this deal- <?php echo $myrow["Investor"]; ?> - in Venture Intelligence</p>
        <input type="hidden" name="subject" id="subject" value="Checkout this deal- <?php echo $myrow["Investor"]; ?> - in Venture Intelligence"  />
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

                                  <div class="detailed-title-links"> <h2>  <?php echo $myrow["Investor"]; ?></h2>
                        <?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="redirdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>">< Previous</a><?php } ?>
                <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="redirdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>"> Next > </a>  <?php } ?>
                            </div>
         <div class="profilemain">
         <h2>PE-RE Investor Profile</h2>
         <div class="profiletable" style="position:  relative;">
            <!--   <?php $linkedinSearchDomain=  str_replace("http://www.", "", $website);
               $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain);
                if(strrpos($linkedinSearchDomain, "/")!="")
                {
                   $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
                }
            if($linkedinSearchDomain!=""){ ?> -->
             <!--<img src="<?php echo $refUrl; ?>images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;">-->
         <!--  <div class="linkedin-bg">

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
               <?php } ?> -->
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
                if (mysql_num_rows($rsMgmt) > 0) { ?>
                <li><h4>Management    </h4><p>
                    <?php
                        While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
                            $designation = $mymgmtrow["Designation"];
                            if ($mymgmtrow["Designation"] == "")
                                $designation = "";
                            else
                                $designation = "" . $mymgmtrow["Designation"];
                            ?>
                                <?php echo $mymgmtrow["ExecutiveName"]; ?> ( <?php echo $designation; ?> ) <br/>
                        <?php } ?>
                    </p></li>
                <?php  } if (trim($Email) != "") {
            ?>
          <li><h4>Email    </h4><p><?php echo $Email; ?> </p></li>
           <?php
            }

            if ($yearfounded != "") {
                ?>
           <li><h4> Year Founded</h4><p><?php echo  $yearfounded; ?> </p></li>
            <?php
            }
        if (trim($website) != "")
          { ?>
          <li><h4>Website    </h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>
           <?php
            }
            if ($investor_newssearch != "")
          { ?>
          <li><h4>News </h4><p><a href=<?php echo  $investor_newssearch; ?> target="_blank">Click Here</a></p></li>
           <?php
            }

        if (trim($no_employees) != "")
          { ?>
          <!--<li><h4>No of Employee    </h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>-->
           <?php
            }
            //{
            ?>
          
             <?php if ($myrow["linkedIn"] != "") 
            {  ?>
            <li ><h4>LinkedIn</h4><p><a href=<?php echo $myrow["linkedIn"]; ?> target="_blank">Click Here</a></p></li>
            <?php } ?>

  
           </ul>
                
            
         </div>
         </div>
         <div class="postContainer postContent masonry-container">
             <?php

                      //echo "<bR>** ".$Investmentsql;
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
                                          <?php echo $openBracket;?><a class="postlink" href='redircomdetails.php?value=<?php echo $myInvestrow["PECompanyId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>' ><?php echo $myInvestrow["companyname"]; ?></a><?php echo $closeBracket;?></td>
                                  <?php
                              } else {
                                  ?>
                                  <tr><td >
                                  <?php echo ucfirst("$searchString"); ?></td>
                                  <?php
                              }
                              ?>
                                      <td colspan="2"> <a class="postlink" href="redirdeal.php?value=<?php echo $myInvestrow["PEId"];?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>">
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
                   ?>

                                   <tr>
                                       <td><a class="postlink" href='redircomdetails.php?value=<?php echo $ipmyrow["PECompanyId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>' ><?php echo $ipmyrow["companyname"]; ?></a></td>
                                       <td><a class="postlink" href='rediripodeal.php?value=<?php echo $ipmyrow["IPOId"];?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>'><?php echo $ipmyrow["dealperiod"];?></a></td>
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
                                        <td><a class="postlink" href='redircomdetails.php?value=<?php echo $mandamyrow["PECompanyId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>' ><?php echo $mandamyrow["companyname"]; ?></a></td>
                                        <td><a class="postlink" href='redirmandadeal.php?value=<?php echo $mandamyrow["MandAId"];?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>'><?php echo $mandamyrow["dealperiod"];?></a></td>
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
                        <td><h4>Sector</h4><p><?php echo $preferred_stage; ?>&nbsp;</p></td>

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
        <!--      <?php
                $rsMgmt = mysql_query($onMgmtSql);
                if (mysql_num_rows($rsMgmt) > 0) {
             ?>
            <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/the-rules-of-dada/">
                <h2>Management</h2>

                <table cellpadding="0" cellspacing="0" class="tablelistview">
                     <?php
                        While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
                            $designation = $mymgmtrow["Designation"];
                            if ($mymgmtrow["Designation"] == "")
                                $designation = "";
                            else
                                $designation = "" . $mymgmtrow["Designation"];
                            ?>
                                <tr>
                                    <td><p><?php echo $mymgmtrow["ExecutiveName"]; ?></p> </td><td><p><?php echo $designation; ?></p></td>
                                </tr>
                            <?php }
                            ?>
                </table>
            </div>

                    <?php
                }
                ?></div>            -->
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
                                 <input class ="export" type="button" id="expshowdealsbtn"  value="Export" name="showdeals">
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
<!--    <input type="hidden" name="value" value="<?php echo $vcflagValue; ?>">-->
    </form>
<form name="reinvestorDetails" id="investorDetails" method="post" action="exportreinvestorprofile.php">
    <input type="hidden" name="txthideinvestorId" value="<?php echo $investorId;?>" >
           <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
    <input type="hidden" name="hidepeipomandapage" value="5" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>
 <script type="text/javascript">
        /*$(".export").click(function(){
        $("#investorDetails").submit();
    });*/
    $("a.postlink").click(function(){

                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();

                    return false;
                });
    function resetinput(fieldname)
       {

      // alert($('[name="'+fieldname+'"]').val());
         $("#resetfield").val(fieldname);
       //  alert( $("#resetfield").val());
         $("#pesearch").submit();
           return false;
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
<script>
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
                        $("#investorDetails").submit();
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
                    return false;
                }

            });
    }
</script>


 <script src="hopscotch.js"></script>
 <script src="demo.js"></script>
    
     <script type="text/javascript" >
    $(document).ready(function(){       
    
     <?php
    if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){ ?> 
     hopscotch.startTour(tour, 20);     
     <?php }  ?>
           
           
           
            //// multi select checkbox hide
    $('.ui-multiselect').attr('id','uimultiselect');  
    
    $("#uimultiselect, #uimultiselect span").click(function() {
        if(demotour==1)
                {  showErrorDialog("To follow the guide"); $('.ui-multiselect-menu').hide(); }     
    });
    
             
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

        </script>
        <?php  mysql_close();   ?>