<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('checklogin.php');
         $videalPageName="AngelInv";  
        
        $mailurl= curPageURL();
        $notable=false;
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
        }
        else
        {
            $vcflagValue=2;
            $VCFlagValue=2;
        }
        $dealvalue=$strvalue[2];
        $resetfield=$_POST['resetfield'];
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
                $month1= date('n', strtotime(date('Y-m')." -2   month")); 
                $year1 = date('Y');
                $month2= date('n');
                $year2 = date('Y'); 
                if($type==1)
                {
                    $fixstart=1998;
                    $startyear =  $fixstart."-01-01";
                    $fixend=date("Y");
                    $endyear = $endyear = date("Y-m-d");
                }
                else 
                {
                    $fixstart=2009;
                    $startyear =  $fixstart."-01-01";
                    $fixend=date("Y");
                    $endyear = date("Y-m-d");
                }
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
         //   echo "2";
            if($resetfield=="period")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }
            elseif ($resetfield=="searchallfield")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="")
            {
             $month1=01; 
             $year1 = 1998;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month"));
             $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
             $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
         if($resetfield=="keywordsearch")
            { 
             $_POST['keywordsearch']="";
             $keyword="";
             $keywordhidden="";
            }
            else 
            {
             $keyword=trim($_POST['keywordsearch']);
             $keywordhidden=trim($_POST['keywordsearch']);
            }
            $keywordhidden =ereg_replace(" ","-",$keywordhidden);

             if($resetfield=="companysearch")
            { 
             $_POST['companysearch']=" ";
             $companysearch=" ";
            }
            else 
            {
             $companysearch=trim($_POST['companysearch']);
            }
             $companysearchhidden=ereg_replace(" ","_",$companysearch);

            if($resetfield=="searchallfield")
            { 
             $_POST['searchallfield']="";
             $searchallfield="";
            }
            else 
            {
             $searchallfield=trim($_POST['searchallfield']);
            }

            $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);

            if($resetfield=="industry")
            { 
             $_POST['industry']="";
             $industry=0;
            }
            else 
            {
             $industry=trim($_POST['industry']);
            }

             if($resetfield=="followonVCFund")
            { 
             $_POST['followonVCFund']="";
             $followonVC="--";
            }
            else 
            {
             $followonVC=trim($_POST['followonVCFund']);
            }

            if($followonVC=="--")
                $followonVCFund="--";
            if($followonVC==1)
                $followonVCFund=1;
            elseif($followonVC==2)
            {
                $followonVCFund=3;
            }

             if($resetfield=="exitedstatus")
            { 
             $_POST['exitedstatus']="";
             $exitvalue="--";
            }
            else 
            {
             $exitvalue=trim($_POST['exitedstatus']);
            }
            
            if($exitvalue=="--")
                $exited="--";
            elseif($exitvalue==1)
                $exited=1;
            elseif($exitvalue==2)
                $exited=3;
          if($followonVC=="--")
                $followonVCFund="--";
            if($followonVC==1)
                $followonVCFund=1;
            elseif($followonVC==2)
            {
                $followonVCFund=3;
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
//       if(($resetfield=="period" &&  $_POST) ||  $searchallfield!="")
//        { 
//        $month1="--";
//        $year1 = "--";
//        $month2="--";
//        $year2 = "--";
//        $_POST['month1']=$_POST['month2']=$_POST['year1']=$_POST['year2']="";
//        }
//        else 
//        {
//        $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
//        $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
//        $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
//        $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
//        }

        $notable=false;
        //$vcflagValue=$_POST['txtvcFlagValue'];
        //echo "<br>FLAG VALIE--" .$vcflagValue;
        $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
        $splityear1=(substr($year1,2));
        $splityear2=(substr($year2,2));

        if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
        {	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
                $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                $wheredates1= "";
        }
         if($followonVCFund =="--")
            {
                $followonVCFundText=="";
            }
            elseif($followonVCFund=="1")
            {
                $followonVCFundText="Follow on Funding";
            }
            elseif($followonVCFund=="3")
            {
                $followonVCFundText="No Funding";
            }
        if($exited =="--")
        {
            $exitedText="";
        }
        elseif($exited=="1")
        {
            $exitedText="Exited";
        }
        elseif($exited=="3")
        {
            $exitedText="Not Exited";

        }
        
        $topNav = 'Directory';
	include_once('dirnew_header.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<?php if($dealvalue==101 && $vcflagValue !=2)
{
    ?>
<td class="left-td-bg"> 
    <div class="acc_main">
        <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
  <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once('pedirrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
  </div>
    </div>
</td>
 <?php
}

        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
		$strvalue = explode("/", $value);
		$SelCompRef=$strvalue[0];
		$searchstring=$strvalue[1];
		
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

         //print_r($_POST);
	//$SelCompRef=$value;
  	$sql="SELECT pe.InvesteeId, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business,
	     DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website, pec.city,pec.RegionId,pe.AngelDealId,
	     Comment,MoreInfor,r.Region,MultipleRound,FollowonVCFund,Exited,   pe.Link
	     FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec, region as r
	     WHERE pec.industry = i.industryid
	     AND pec.PEcompanyID = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15
	     and pe.AngelDealId=$SelCompRef and r.RegionId=pec.RegionId ";
	     
	//echo "<br>********".$sql;

	$investorSql="select peinv.AngelDealId,peinv.InvestorId,inv.Investor from angel_investors as peinv,
		peinvestors as inv where peinv.AngelDealId=$SelCompRef and inv.InvestorId=peinv.InvestorId ";
	//echo "<Br>Investor".$investorSql;



  	if ($companyrs = mysql_query($sql))
		{
	?>
		

		<?php
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
			if($myrow["MultipleRound"]==1)
			{
				$multipleround="Yes";
			}
			else
			{
				$multipleround="No";
			}      
			if($myrow["FollowonVCFund"]==1)
			{    $followonFunding="Yes";}
			else
			{    $followonFunding="No";}
			if($myrow["Exited"]==1)
			{    $exitedstatus="Yes"; }
			else
			{    $exitedstatus="No";}
	      	
		
		//echo "<bR>---".$valuationdata;

                 $industryId=$myrow["industryId"];
	      	$moreinfor=$myrow["MoreInfor"];
	      	$string = $moreinfor;
			/*** an array of words to highlight ***/
			$words = array($searchstring);
			//$words="warrants convertible";
			/*** highlight the words ***/
			$moreinfor =  highlightWords($string, $words);

			$col6=$myrow["Link"];
			$linkstring=str_replace('"','',$col6);
			$linkstring=explode(";",$linkstring);       
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
        
            $pe_industries = explode(',', $_SESSION['PE_industries']);
            if(!in_array($industryId,$pe_industries)){

                echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
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
                              <span class="result-for"> for Angel Investments</span> 
                              </h2>
            
            <?php
             if(($exportToExcel==1))
            {
            ?>
                            <div class="title-links">
                                            <input class="export exlexport" type="submit"  value="Export" name="showdeal">
                            </div>

            <?php
            } ?>
                              <a href="#popup1" class="help-icon"><img  width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle"></a>
                               
                                <?php if($datevalueDisplay1!="")
                                { ?>
                                    <ul class="result-select">
                                        <li > 
                                            <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                    </ul>
                                <?php }
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
                              <span class="result-for"> for Angel Investments</span> 
                              <span class="result-amount" id="show-total-amount">  </span> </h2>
                              
                   <?php 
               ?>
              <?php
            if(($exportToExcel==1))
            {
            ?>
                            <div class="title-links">
                                            <input class="export exlexport" type="submit"  value="Export" name="showdeal">
                            </div>

            <?php
            }
	?>
            <ul  class="result-select">
                   <?php
                if($industry >0 && $industry!=null){ ?>
                <li>
                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } 
                if($followonVC!="--" && $followonVC!=""){ ?>
                    <li title="followonVc">
                        <?php echo $followonVCFundText ?> <a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                <?php } if($exited !="--" && $exited !=""){ ?>
                    <li  title="Exited">
                        <?php echo $exitedText?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                <?php } 
                if($datevalueDisplay1!=""){ ?>
                <li > 
                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('month1,year1,month2,year2');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } if($keyword!="" && $keyword!=" ") { ?>
                <li> 
                    <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php }
               if($companysearch!="" && $companysearch!=" "){ ?>
                <li> 
                    <?php echo $companysearch?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } 
                  if($searchallfield!="" && $searchallfield!=" "){ ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                  <?php }  ?>
             </ul>
             <?php } ?>
                                
                              
        </div>
    
    <div class="list-tab mt-list-tab"><ul>
            <li><a class="postlink"  href="angelindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="angeldirdetails.php?value=<?php echo $vcflagValue;?>" ><i></i> Detail  View</a></li> 
            </ul></div> 	
    <div class="view-detailed"> 
         <div class="detailed-title-links"> <h2> <A href='dircomdetails.php?value=<?php echo $myrow["InvesteeId"].'/'.$VCFlagValue.'/'.$dealvalue;?>' >
				<?php echo rtrim($myrow["companyname"]);?></a></h2>
		</div> 

<!--div class="alert-note">Note: Target/Company in () indicates tranche rather than a new round. Target/Company in indicates a debt investment. Not included in aggregate data.</div></div-->
  <?php if($exitedstatus!="" || $followonFunding!="" || $multipleround!="" || $myrow["dt"]!="") { ?>
    <div class="profilemain">
    <h2>Deal Info  </h2>
    <div class="profiletable">
          <ul>
 <?php if(mysql_num_rows(mysql_query($investorSql))>0){ ?>
            <li><h4>Investors</h4>
                <p>
                   
                   <?php
					if ($getcompanyrs = mysql_query($investorSql))
					{
						$AddOtherAtLast="";
						$AddUnknowUndisclosedAtLast="";
					While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
	      			{
	      				//$AddOtherAtLast="";
	      				$Investorname=trim($myInvrow["Investor"]);
	      				$Investorname=strtolower($Investorname);

	      				$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{
	      		?>
					<?php if ($myInvrow["InvestorId"]==9) { ?>
                                        <?php echo $myInvrow["Investor"]; ?>
                                        <?php } else { ?>
                                        <a class="postlink" href='newdirinv.php?value=<?php echo $myInvrow["InvestorId"].'/'.$VCFlagValue.'/'.$dealvalue;?>' ><?php echo $myInvrow["Investor"]; ?></a>
                                        <?php } ?>
                                        
                                        <br />
				<?php
						}
						elseif(($invResult==1) || ($invResult1==1))
							$AddUnknowUndisclosedAtLast=$myInvrow["Investor"];
						elseif($invResult2==1)
						{
							$AddOtherAtLast=$myInvrow["Investor"];
						}

					}
					}
				?>
					<?php echo $AddUnknowUndisclosedAtLast; ?>

					<?php echo $AddOtherAtLast; ?>
                </p></li>
          <?php } ?>
      
         <?php if($exitedstatus!="") {  ?> <li><h4>Exited ?</h4><p><?php echo $exitedstatus;?></p></li> <?php } ?>
         <?php if($followonFunding!="") {  ?> <li><h4>Follow on VC Funding ?</h4><p><?php echo $followonFunding;?></p></li> <?php } ?>
         <?php if($multipleround!="") {  ?> <li><h4>Multiple Angel Rounds</h4><p><?php echo $multipleround;?></p></li> <?php } ?>
         <?php if($myrow["dt"]!="") {  ?> <li><h4>Date</h4><p><?php echo  $myrow["dt"];?></p></li> <?php } ?>
       </ul>

    </div>
  </div> <?php } ?>
<div class="postContainer postContent masonry-container">
  <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                    <?php
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";
				
				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
				<td width=40% ><h4>Company Name</h4><p>&nbsp;<A class="postlink" href='dircomdetails.php?value=<?php echo $myrow["InvesteeId"].'/'.$VCFlagValue.'/'.$dealvalue;?>' >
				<?php echo rtrim($myrow["companyname"]);?></a>
				</p></td>
		<?php
				}
				else
				{
					$webdisplay="";
		?>
				<td width=40% ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>
                       <?php if($myrow["industry"]!="") { ?><td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td> <?php } ?> </tr>
                        <tr>  <?php if($myrow["sector_business"]!="") { ?> <td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td>  <?php } ?>
                              <?php if($myrow["city"]!="") { ?> <td><h4>City</h4> <p><?php echo  $myrow["city"];?></p></td> <?php } ?> </tr>
                        <tr>  <?php if($myrow["Region"]!="") { ?> <td><h4>Region</h4> <p><?php echo $myrow["Region"];?></p></td> <?php } ?> </tr>
                        <tr>  <?php if($webdisplay!="") { ?><td colspan="2"><h4>Website</h4> <p style="word-break: break-all;"><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></td> <?php } ?> </tr> 
                     
                    </table>
                    </div>  
                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-Angel Inv&body=<?php echo $mailurl;?> ">
                                      Click Here</a>  to request more details (financials, valuations, etc.) to the extent available for this deal
                              </p></td></tr></table>                                          
                    </div>
                </div>	
    </div>     
                
</div>
<!--/table>
	
				<?php
					if(($exportToExcel==1))
					{
					?>
							<span style="float:center" class="one">
								<input type="submit"  value="Click Here To Export" name="showdeal">
							</span>

					<?php
					}
					?>
				
</td></tr></tbody!-->

</td>
</tr>
</table>
 
</div>
</form>
<form name=companyDisplay id="companyDisplay" method="post" action="exportangeldealinfo.php">
    <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>
<div class=""></div>

</div>

 <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
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
            $('.exlexport').click(function(){ 
             
            $("#companyDisplay").submit();
            return false;
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
<?php
mysql_close();
    mysql_close($cnx);
    ?>