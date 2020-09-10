<?php
        require_once("reconfig.php");
	require_once("../dbconnectvi.php");
        $companyId=632270771;
        $compId=0;
	$Db = new dbInvestments();
        $videalPageName="REInv";
	include ('checklogin.php');
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	$mailurl= curPageURL();
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
       $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	$strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $vcflagValue=$strvalue[1];
        $dealvalue=$strvalue[2];
         $numofcount=$_SESSION['numberofcom'];
        $SelCompRef2=1;
  	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
  	pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,
  	pec.website, pe.city, r.Region,pe.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor,InvestmentDeals,Link,pe.EstimatedIRR,pe.MoreInfoReturns
   	FROM REipos AS pe, reindustry AS i, REcompanies AS pec,region as r
  	WHERE pec.industry = i.industryid and pe.IPOId=$SelCompRef  and
  	pec.PEcompanyId = pe.PECompanyId and pe.RegionID=r.RegionId
  	and pe.Deleted=0 order by IPOSize desc,i.industry";
	//echo "<br>".$sql;

	$investorSql="SELECT peinv.IPOId, peinv.InvestorId, inv.Investor
	FROM REipo_investors AS peinv, REinvestors AS inv
	WHERE peinv.IPOId =$SelCompRef
	AND inv.InvestorId = peinv.InvestorId";

//	echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from REinvestments_advisorcompanies as advcomp,
	REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

        
        $resetfield=$_POST['resetfield'];
        $yearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from REipos order by IPODate asc";
        if($yearSql=mysql_query($yearsql))
        {
                if($type == 1)  
                {
                    if($_POST['year1']=='')
                    {
                        $year1;
                    }
                }
                else
                {
                    if($_POST['year1']=='')
                    {
                        $year1;
                    }
                }
                While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
                {
                        $lastStartYear = $myrow["Year"]."";
                       
                }		
        }
        
                $yearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from REipos order by IPODate asc";
                if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$lastEndYear = $myrow["Year"];
				
			}		
		}
 
        
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
        $getyear = $_REQUEST['y'];
        $getsy = $_REQUEST['sy'];
        $getey = $_REQUEST['ey'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
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
                $year1 = $lastStartYear-2;
                $month2= date('n');
                $year2 = $lastEndYear; 
            if($type==1)
            {
                $fixstart=2006;
                $startyear =  $fixstart."-01-01";
                $fixend=$lastEndYear;
                $endyear = $lastEndYear."-".date("m-d");
            }
            else 
            {
                $fixstart=2009;
                $startyear =  $fixstart."-01-01";
                $fixend=$lastEndYear;
                $endyear = $lastEndYear."-".date("m-d");
             }
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            if($resetfield=="period")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = $lastStartYear-2;;
             $month2= date('n');
             $year2 = $lastEndYear;
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = $lastStartYear-2;
             $month2= date('n');
             $year2 = $lastEndYear;
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
            {
            
             $month1=01; 
             $year1 = 2006;
             $month2= date('n');
             $year2 = $lastEndYear;
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month"));
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : ($lastStartYear-2);
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : $lastEndYear;
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
        
        
        if($getyear !='')
        {
            $getdt1 = $getyear.'-01-01';
            $getdt2 = $getyear.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getsy !='' && $getey !='')
        {
            $getdt1 = $getsy.'-01-01';
            $getdt2 = $getey.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getindus !='')
        { 
            $isql="select industryid,industry from industry where industry='".$getindus."'" ;
            $irs=mysql_query($isql);
            $irow=mysql_fetch_array($irs);
            $geti = $irow['industryid'];
            $getind=" and pec.industry=".$geti;
        }
         if($getstage !='')
        { 
            $ssql="select StageId,Stage from stage where Stage='".$getstage."'" ;
            $srs=mysql_query($ssql);
            $srow=mysql_fetch_array($srs);
            $gets = $srow['StageId'];
            $getst=" and pe.StageId=" .$gets;
        }
        if($getinv !='')
        {
            $invsql = "select InvestorType,InvestorTypeName from investortype where Hide=0 and InvestorTypeName='".$getinv."'" ;
            $invrs = mysql_query($invsql);
            $invrow=mysql_fetch_array($invrs);
            $getinv = $invrow['InvestorType'];
            $getinvest = " and pe.InvestorType = '".$getinv ."'";
        }
        if($getreg!='')
        {
            if($getreg =='empty')
            {
                $getreg='';
            }
            else
            {
                $getreg;
            }
            $regsql = "select RegionId,Region from region where Region='".$getreg."'" ;
            $regrs = mysql_query($regsql);
            $regrow=mysql_fetch_array($regrs);
            $getreg = $regrow['RegionId'];
            $getregion = " and pec.RegionId  =".$getreg." and pec.RegionId IS NOT NULL";
        }
        if($getrg!='')
        {
            if($getrg == '200+')
            {
                $getrange = " and pe.amount > 200";
            }
            else
            {
                $range = explode("-", $getrg);
                $getrange = " and pe.amount > ".$range[0]." and pe.amount <= ".$range[1]."";
            }

        }
  
        if($compId==$companyId)
        { 
           $hideIndustry = " and display_in_page=1 "; 

        }
        else
        {
           $hideIndustry="";     
        }

        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);
      
        $buttonClicked=$_POST['hiddenbutton'];
        $fetchRecords=true;
        $totalDisplay="";

        if($resetfield=="investorsearch")
        { 
            $_POST['investorsearch']="";
            $keyword="";
            $keywordhidden="";
        }
        else 
        {
            $keyword=trim($_POST['investorsearch']);
            $keywordhidden=trim($_POST['investorsearch']);
        }
        $keywordhidden =ereg_replace(" ","_",$keywordhidden);

        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $companysearch="";
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
        
        $advisorsearch="";
       
        if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry="";
        }
        else 
        {
            $industry=trim($_POST['industry']);
        }


        //echo "<br>Stge**" .$range;
     
            $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
            $splityear1=(substr($year1,2));
            $splityear2=(substr($year2,2));

           if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
            {
                $sdatevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
                $edatevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                $wheredates1= "";
            }
            $cmonth1= date('n', strtotime(date('Y-m')." -2	 month"));
            $cyear1 = date('Y');
            $cmonth2= date('n');
            $cyear2 = date('Y');
            $csplityear1=(substr($cyear1,2));
            $csplityear2=(substr($cyear2,2));
            $sdatevalueCheck1 = returnMonthname($cmonth1) ." ".$csplityear1;
            $edatevalueCheck2 = returnMonthname($cmonth2) ."  ".$csplityear2;
            
            if($sdatevalueDisplay1 == $sdatevalueCheck1)
            {
                $datevalueCheck1=$sdatevalueCheck1;
                $datevalueCheck2=$edatevalueCheck2;
                $datevalueDisplay1="";
                $datevalueDisplay2="";
            }
            else
            {
                $datevalueCheck1="";
                $datevalueCheck2="";
                $datevalueDisplay1= $sdatevalueDisplay1;
                $datevalueDisplay2= $edatevalueDisplay2;
            }
            
            
            
            if($industry >0)
		{
			$industrysql= "select industry from reindustry where industryid=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}

        $topNav = 'Directory';
        $defpage=$defvalue;
        $stagedef=1;
	include_once('redirectory_header.php');
?>
  
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

 <td class="left-td-bg"> 
 <div class="acc_main">
 <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
<div id="panel" style="display:block; overflow:visible; clear:both;">
<?php
 include_once('redirrefine.php');
 ?>
</div>
 </div>
</td>
	<!-- you can put content here -->
 <?php
      	//GET PREV NEXT ID
        $prevNextArr = array();
        $prevNextArr = $_SESSION['resultId'];

        $currentKey = array_search($SelCompRef,$prevNextArr);
        $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
        $nextKey = $currentKey+1;
		
        $flagvalue=$value;
        $searchstring="";

        if ($companyrs = mysql_query($sql))
                { 
        
        ?>
           
            <? $hideamount="";
			$hidemoreinfor="";
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{

			if($myrow["hideamount"]==1)
			{
				$hideamount="--";
			}
			else
			{
				$hideamount=$myrow["IPOSize"];
			}

			if($myrow["hidemoreinfor"]==1)
			{
				$hidemoreinfor="--";
			}
			else
			{
				$hidemoreinfor=$myrow["MoreInfor"];
	      	}
	      	$col6=$myrow["Link"];
			$linkstring=str_replace('"','',$col6);
			$linkstring=explode(";",$linkstring);

			$estimatedirrvalue=$myrow['EstimatedIRR'];
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
                                            
                        <?php if(!$_POST){?>
                                <h2>
                                    <?php
                                    if($studentOption==1 || $exportToExcel==1){
                                    ?>
                                       <span class="result-no"><?php echo $numofcount; ?> Results Found</span> 
                                    <?php }
                                    else {
                                    ?>
                                       <span class="result-no"> XXX Results Found</span> 
                                   <?php } 
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
                                </h2>
                              
                                <div class="title-links">
                                
                                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                        <?php 

                                        if(($exportToExcel==1))
                                             {
                                             ?>
                                                 <input class="export" type="submit" id="expshowdeals"  value="Export" name="showREIPOdeal">
                                             <?php
                                             }
                                         ?>
                                </div>
                               <ul class="result-select">
                                   <?php
                                if($stagevaluetext!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $stagevaluetext;?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          
                                <?php }
                                 if (($getrangevalue!= "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$getrangevalue; ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if (($getinvestorvalue!= "")){ ?>
                                <li> 
                                    <?php echo $getinvestorvalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if (($getregionevalue != "")){ ?>
                                <li> 
                                    <?php echo $getregionevalue ; ?><a  onclick="resetinput('txtregion');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                        if($getindusvalue!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $getindusvalue;?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                <?php }
                                  if($datevalueDisplay1!=""){  
                                         ?>
                                        <li> 
                                          <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                <?php }
                                else if($datevalueCheck1 !="")
                                {
                                ?>
                                    <li style="padding:1px 10px 1px 10px;"> 
                                      <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                    </li>
                                <?php 
                                }
                                ?>
                               </ul>
                              <?php            
                              }
                                   else 
                                   {  ?> 
                                        <h2>
                                            <?php
                                            if($studentOption==1 || $exportToExcel==1){
                                            ?>
                                               <span class="result-no"><?php echo $numofcount; ?> Results Found</span> 
                                            <?php }
                                            else {
                                            ?>
                                               <span class="result-no"> XXX Results Found</span> 
                                            <?php } 
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
                                        </h2>
                             <div class="title-links">
                                
                                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                        <?php 

                                        if(($exportToExcel==1))
                                             {
                                             ?>
                                                 <input class="export" type="submit" id="expshowdeals"  value="Export" name="showREIPOdeal">
                                             <?php
                                             }
                                         ?>
                            </div>
                            <ul class="result-select">
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($datevalueDisplay1!=""){  ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                else if($datevalueCheck1 !="")
                                {
                                 ?>
                                 <li style="padding:1px 10px 1px 10px;"> 
                                    <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                </li>
                                <?php
                                }
                                if($keyword!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $keyword;?><a  onclick="resetinput('investorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $companysearch?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                ?>
                             </ul>
                                        <?php } ?>
                    
                        </div>	
                       <div class="overview-cnt">
                    </div> 
    <div class="list-tab mt-list-tab">
            <ul>
            <li><a class="postlink"  href="redirview.php?value=<?php echo $vcflagValue;?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="rediripodeal.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
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
        	<p>Checkout this deal - <?php echo $myrow["companyname"]; ?> - in Venture Intelligence</p>
                 <input type="hidden" name="subject" id="subject" value="Checkout this deal - <?php echo $myrow["companyname"]; ?> - in Venture Intelligence"  />
        </div>
        <div class="entry">
        	<h5>Message</h5>
                <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>" />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
        </div>
        <div class="entry">
            <input type="button" value="Submit" id="mailbtn" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

    </form>
</div>
    <div class="view-detailed"> 
         <!--div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]; ?></h2-->
             <div class="detailed-title-links"><h2> <A class="postlink" href='recompanydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
		 <?php $url=$_SERVER['HTTP_REFERER']; ?>
                 <a class="postlink" href="<?php echo $url; ?>">< Back</a>
              <?php  //} ?> 
                    </div> 
                        
 <div class="profilemain">
                <h2>Deals Info  </h2>
                <div class="profiletable">
                    <ul>
                          <?php if($hideamount!="") {?><li><h4>IPO Size (US $M)</h4><p><?php echo $hideamount;?></p></li> <?php } ?>
                          <?php if($myrow["IPOAmount"]!="") {?><li><h4>IPO Price (Rs.)</h4><p><?php echo $myrow["IPOAmount"];?></p></li><?php } ?>
                          <?php if($myrow["IPOValuation"]!="") {?><li><h4>IPO Valuatation (US $M)</h4><p><?php echo $myrow["IPOValuation"];?></p></li><?php } ?>
                          <?php if($myrow["IPODate"]!="") {?><li><h4>Deal Period</h4><p><?php echo  $myrow["IPODate"];?></p></li><?php } ?>
                         
                    </ul>
                </div>
                </div>
    
    
    
  <div class="postContainer postContent masonry-container">
                     <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Investment Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody>
                       
                            	<?php
					if ($getcompanyrs = mysql_query($investorSql))
					{ ?> <tr>
                            <td><h4>Investors</h4><p>
                    	<?php
						$AddOtherAtLast="";
						$AddUnknowUndisclosedAtLast="";
					While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
					{
						$Investorname=trim($myInvrow["Investor"]);
						$Investorname=strtolower($Investorname);

						$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{
                            ?>                 
					<a class="postlink" href='redirinvdetails.php?value=<?php echo $myInvrow["InvestorId"] ?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' ><?php echo $myInvrow["Investor"]; ?></a><br />
				<?php
						}
						elseif(($invResult==1) || ($invResult1==1))
							$AddUnknowUndisclosedAtLast=$myInvrow["Investor"];
						elseif($invResult2==1)
						{
							$AddOtherAtLast=$myInvrow["Investor"];
						}

					}
					
				?>      <?php echo $AddUnknowUndisclosedAtLast; ?>
                                        <BR/>
					<?php echo $AddOtherAtLast; ?>
                            </td> </tr> <?php }
				?> 
                        <?php
                        if(($estimatedirrvalue !="")  && ($estimatedirrvalue >0))
                        {
                            ?>
                                   <?php if($myrow["EstimatedIRR"]!="") { ?> <tr><td><h4>Estimated Returns </h4><p><?php echo $myrow["EstimatedIRR"];?></p></tr> <?php } ?>
                                   <?php if($myrow["MoreInfoReturns"]!="") { ?> <tr><td ><h4>More Info (Returns) </h4><p><?php print nl2br($myrow["MoreInfoReturns"]);?></p></td></tr> <?php } ?>
                        <?php
                        }
                        ?>
                    <?php if(trim($myrow["InvestmentDeals"])!="") {?>
                     <tr>
                         <td><h4>Investment Details</h4>
                             <p><?php print nl2br($myrow["InvestmentDeals"]) ;?> </p> </td></tr>  
                     <?php } ?>
                    </tbody>
                    </table>
                    </div>
          	   
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
				<td width="120">
                                    <h4>Company</h4> 
                                    <p><A class="postlink" href='redircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' >
                                    <?php echo rtrim($myrow["companyname"]);?></a>
                                    </p>
                                </td>
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
                        <tr>
                             <?php if($myrow["industry"]!="") { ?>
                             <td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td> <?php } ?>
                             <?php if($myrow["sector_business"]!="") { ?><td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td> <?php } ?>
                        </tr>
                        <tr> 
                            <?php if($myrow["city"]!="") { ?><td><h4>City</h4> <p><?php echo  $myrow["city"];?></p></td><?php } ?>
                            <?php if($myrow["Region"]!="") { ?><td><h4>Region</h4> <p><?php echo $myrow['Region'];?></p>	</td><?php } ?>
                        </tr>
                        <tr>
                             <?php if($webdisplay!="") { ?><td colspan="2"><h4>Website</h4> <p><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></td><?php } ?></tr> 
                        <tr>
                             <?php if(trim($linkstring[0])!="") { ?>
                            <td colspan="2"><h4>Links</h4> <p style="word-break: break-all;">
                                <?php
				 foreach ($linkstring as $linkstr)
				{
					if(trim($linkstr)!=="")
					{
				?>
						<a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a>
				<?php
                                        }
                                }
				?>   
                        </p>	</td>
                             <?php } ?>
                        </tr>
                        
                     
                    </table>
            </div>   
          <?php if(trim($myrow["MoreInfor"])!="") { ?>	
           <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($myrow["MoreInfor"]);?></p></td></tr></table>
           </div>
          <?php } ?>
                </div>
                
                
</div>



    </div>
  
</td>

 

</tr>
</table>
 
</div>
 <input type="hidden" name="value" value="<?php echo $vcflagValue; ?>">
 </form>
 <form name="reipodealinfo" id="reipodealinfo" method="post" action="exportreipo.php">
    <input type="hidden" name="txthideIPOId" value="<?php echo $SelCompRef;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>
<div class=""></div>

</div>
 

 <script type="text/javascript">
    /*$(".export").click(function(){
        $("#reipodealinfo").submit();
    });*/
    
    
    $('#expshowdeals').click(function(){ 
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
                       // hrefval= 'exportrecompanyprofile.php';
                       // $("#companyDisplay").attr("action", hrefval);
                        $("#reipodealinfo").submit();
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
                                alert("There was some problem exporting...");
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
//   function resetinput(fieldname)
//   {
//  // alert($('[name="'+fieldname+'"]').val());
//     $("#resetfield").val(fieldname);
//     hrefval= 'redirview.php';
//     $("#pesearch").attr("action", hrefval);
//     $("#pesearch").submit();
//       return false;
//   }
   function resetinput(fieldname)
    {

    // alert($('[name="'+fieldname+'"]').val());
      $("#resetfield").val(fieldname);
    //  alert( $("#resetfield").val());
      $("#pesearch").submit();
        return false;
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