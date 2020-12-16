<?php include_once("../globalconfig.php"); ?>
<?php

                $companyId=632270771;
                $compId=0;
                require_once("../dbconnectvi.php");
                $Db = new dbInvestments();
                $videalPageName="Inc";     
                 include ('checklogin.php');
                $searchString="Undisclosed";
                $searchString=strtolower($searchString);
               $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 6; 
                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);
                $totalDisplay="";
               // print_r($_POST);
                $resetfield=$_POST['resetfield'];
                
                if($resetfield=="keywordsearch")
                { 
                 $_POST['keywordsearch']="";
                 $keyword="";
                 $keywordhidden="";
                }
                else 
                {
                 $keyword=($_POST['keywordsearch']);
                 $keywordhidden=trim($_POST['keywordsearch']);
                }
                $keywordhidden =ereg_replace(" ","_",$keywordhidden);
                
              
                if($resetfield=="companysearch")
                { 
                 $_POST['companysearch']="";
                 $companysearch="";
                }
                else 
                {
                 $companysearch=$_POST['companysearch'];
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
                 $industry="";
                }
                else 
                {
                 $industry=trim($_POST['industry']);
                }
                
                if($resetfield=="statusid")
                { 
                 $_POST['statusid']="";
                 $status="--";
                }
                else 
                {
                 $status=trim($_POST['statusid']);
                }
                
                  if($resetfield=="txtfirmtype")
                { 
                 $_POST['txtfirmtype']="";
                 $incfirmtype="";
                }
                else 
                {
                 $incfirmtype=trim($_POST['txtfirmtype']);
                }
               
                 if($resetfield=="chkDefunct")
                { 
                  $_POST['chkDefunct']="";
                  $defunctflag=1;
                  $addDefunctqry="";
                }
                else 
                {
                  $defunctflag=0;
                  $addDefunctqry=" and Defunct=0 ";
                 
                }
                
                if($resetfield=="followonFund")
                { 
                 $_POST['followonFund']="";
                 $followon="";
                }
                else 
                {
                 $followon=trim($_POST['followonFund']);
                }
                
                 if($resetfield=="txtregion")
                { 
                 $_POST['txtregion']="";
                 $regionId="";
                }
                else 
                {
                 $regionId=trim($_POST['txtregion']);
                }
                
            if($followon=="--")
                $followonFund="--";
            if($followon==1)
                $followonFund=1;
            elseif($followon==2)
                $followonFund=0;
                $whereind="";
                $wherestatus="";
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
   		if($status >0)
		{
		$statussql= "select StatusId,Status from incstatus where StatusId=$status";
    		if ($stagers = mysql_query($statussql))
			{
				While($mysrow=mysql_fetch_array($stagers, MYSQL_BOTH))
				{
					$statusvalue=$mysrow["Status"];
				}
			}
		}
		if($incfirmtype >0)
		{
			$incfirmsql= "select IncFirmTypeId,IncTypeName from incfirmtypes where IncFirmTypeId=$incfirmtype";
    		if ($incrs = mysql_query($incfirmsql))
                {
                        While($myincrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                        {
                                $inctype=$myincrow["IncTypeName"];
                        }
                }
		}
		if($defunctflag==1)
                {   $defunctText= "Excluded Defunct Cos"; }
                else
                {     $defunctText= "Included Defunct Cos"; }
		if($regionId >0)
			{
			$regionSql= "select Region from region where RegionId=$regionId";
					if ($regionrs = mysql_query($regionSql))
					{
						While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$regionvalue=$myregionrow["Region"];
						}
					}
		}
                if($followonFund =="--")
                {
                    $followonFundText="";
                }
                elseif($followonFund=="1")
                {
                    $followonFundText="Follow on Funding";
                }
                elseif($followonFund=="2")
                {
                    $followonFundText="No Funding";
                }

                $addVCFlagqry = " and pec.industry !=15 ";

                $searchTitle = "Incubated Companies";
                $orderby=""; $ordertype="";
                if(!$_POST)
                {
                    $iftest=1;
                    $yourquery=0;
                    $companysql = "SELECT pe.IncDealId,pe.IncubateeId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,Individual,inc.Incubator,pec.PECompanyid as companyid
                                        FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,incubators as inc 
                                        WHERE pec.industry = i.industryid   and inc.IncubatorId=pe.IncubatorId 
                                        AND pec.PEcompanyID = pe.IncubateeId  and pe.Deleted=0" .$addVCFlagqry.$addDefunctqry;
                    $orderby="companyname";
                    $ordertype="asc";
                    // echo "<br>all records" .$companysql;
                }
                elseif($searchallfield!="")
                {
                        $iftest=4;
                        $yourquery=1;
                        $companysql="SELECT pe.IncDealId, pe.IncubateeId,pec.companyname, pec.industry, i.industry, pec.sector_business  as sector_business,
                                        Individual,inc.Incubator,pec.AdCity,pec.PECompanyid as companyid
                                        FROM incubatordeals AS pe, industry AS i,pecompanies AS pec,incubators as inc
                                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and  inc.IncubatorId=pe.IncubatorId
                                        AND pe.Deleted =0 " .$addVCFlagqry .$addDefunctqry.  " AND ( pec.AdCity LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' or sector_business LIKE '$searchallfield%'
                                        or MoreInfor LIKE '%$searchallfield%' ) ";
                        $orderby="companyname";
                        $ordertype="asc";
                        //echo "<bR>---" .$companysql;
                }
                elseif ($companysearch!="")
                {
                        $iftest=2;
                        $yourquery=1;
                        $companysql="SELECT pe.IncDealId,pe.IncubateeId, pec.companyname, pec.industry, i.industry, pec.sector_business  as sector_business,
                                        Individual,inc.Incubator,pec.PECompanyid as companyid
                                        FROM incubatordeals AS pe, industry AS i,  pecompanies AS pec,incubators as inc
                                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and inc.IncubatorId=pe.IncubatorId
                                        AND pe.Deleted =0 " .$addVCFlagqry.$addDefunctqry. " AND ( pec.companyname LIKE '%$companysearch%'
                                        OR sector_business LIKE '%$companysearch%') ";
                        $orderby="companyname";
                        $ordertype="asc";
                        //	echo "<br>Query for company search";
                        //echo "<br> Company search--" .$companysql;
                }
                elseif($keyword!="")
                {
                    $iftest=3;
                    $yourquery=1;
                    $companysql="select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business  as sector_business,Individual,
                                        pe.IncubatorId,inc.Incubator,pec.PECompanyid as companyid 
                                        from incubatordeals as pe,pecompanies as pec,industry as i ,incubators as inc 
                                        where pec.industry = i.industryid and  inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 
                                        and pec.PECompanyId=pe.IncubateeId " .$addVCFlagqry.$addDefunctqry. " AND inc.Incubator like '%$keyword%' ";
                    $orderby="companyname";
                    $ordertype="asc";
                    	//echo "<br> Investor search- ".$companysql;
                }
                elseif (($industry!="") || ($status !="")|| ($followonFund !="")|| ($regionId!="") || ($incfirmtype>0) )
                {
                    // echo "<br>--" .$regionId;
                    $iftest=5;
                    $yourquery=1;
                    $companysql = "select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business  as sector_business,Individual,inc.Incubator,pec.PECompanyid as companyid
                                    from incubatordeals as pe, industry as i,pecompanies as pec,incubators as inc,region as r where";
                    //	echo "<br> individual where clauses have to be merged ";
                    if ($industry > 0)
                    {
                            $whereind = " pec.industry=" .$industry ;
                            $qryIndTitle="Industry - ";
                    }
                    if ($status> 0)
                    {
                            $wherestatus = " pe.StatusId =" .$status ;
                            $qryDealTypeTitle="Stage  - ";
                    }
                    if($incfirmtype>0)
                    {
                      $wherefirmtype=" inc.IncFirmTypeId=".$incfirmtype;
                      $qryFirmType="Firm Type - ";
                    }
                    if (($followonFund =="0") || ($followonFund=="1"))
                    {
                        $wherefollowonFund = " pe.FollowonFund = ".$followonFund;
                        $qryDealTypeTitle="Follow on Funding Status  - ";
                    }
                    if ($regionId> 0)
                    {
                            $whereregion = " pec.RegionId =" .$regionId ;
                            $qryregionTitle="Region  - ";
                    }
                    if ($whereind != "")
                    {
                            $companysql=$companysql . $whereind ." and ";
                    }
                    if (($wherestatus != ""))
                    {
                        $companysql=$companysql . $wherestatus . " and " ;
                    }
                    if($wherefirmtype!="")
                    {
                        $companysql=$companysql . $wherefirmtype . " and " ;
                    }
                    if (($whereregion != ""))
                    {
                        $companysql=$companysql . $whereregion . " and " ;
                    }
                    if($wherefollowonFund!="")
                         $companysql=$companysql .$wherefollowonFund. " and ";

                    $companysql = $companysql . "  i.industryid=pec.industry and
                                    pec.PEcompanyID = pe.IncubateeId and inc.IncubatorId=pe.IncubatorId and  r.RegionId=pec.RegionId
                                    and pe.Deleted=0 " .$addVCFlagqry .$addDefunctqry ;
                    $orderby="companyname";
                    $ordertype="asc";
                    //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                }
                else
                {
                        echo "<br> Invalid input selection ";
                        $fetchRecords=false;
                }
        $ajaxcompanysql=  urlencode($companysql);
        if($companysql!="")
           $companysql = $companysql . " order by ".$orderby." ".$ordertype ; 
    ?>

    <?php 
    $topNav = 'Report';
    include_once('report_search.php');
    ?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
    <?php
            $exportToExcel=0;
            $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                        $studentOption=$trialrow["Student"];
                }
        }
        if($yourquery==1)
                $queryDisplayTitle="Query:";
        elseif($yourquery==0)
                $queryDisplayTitle="";
        if(trim($buttonClicked==""))
        {
            $totalDisplay="Total";
            $industryAdded ="";
            $totalAmount=0.0;
            $totalInv=0;
            $compDisplayOboldTag="";
            $compDisplayEboldTag="";
            //echo $status;
            //  /   echo "<br> query final-----" .$companysql."//".$iftest."/".$TrialSql."/".$studentOption."/".$companysearch;
            /* Select queries return a resultset */
            if ($companyrsall = mysql_query($companysql))
            {
                $company_cntall = mysql_num_rows($companyrsall);
            } 
            if($company_cntall > 0)
            {
                $rec_limit = 50;
                $rec_count = $company_cntall;
                if( isset($_GET{'page'} ) )
                {
                   $currentpage=$page;
                   $page = $_GET{'page'} + 1;
                   $offset = $rec_limit * $page ;
                }
                else
                {
                    $currentpage=1;
                   $page = 1;
                   $offset = 0;
                }
                $companysqlwithlimit=$companysql." limit $offset, $rec_limit";
                if ($companyrs = mysql_query($companysqlwithlimit))
                {
                    $company_cnt = mysql_num_rows($companyrs);
                }
            }
            else
            {
                 $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                 $notable=true;
            }
           ?>     
    <td class="profile-view-left" style="width:100%;">
     
    <div class="result-cnt" style="margin-bottom: 30px;">
    	<?php if ($accesserror==1){?>
                    <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php" target="_blank">Click here</a></b></div>
        <?php
                exit; 
                } 
        ?>
        <div class="result-title">

                <?php if(!$_POST)
                    {   
                    ?>
            <h2>
           <?php  
                if($studentOption==1)
                {
                ?>
                 <span class="result-no"><?php echo @mysql_num_rows($companyrsall); ?> Results Found</span>  
                 
                 <?php
                }
                else
                {
                   if($exportToExcel==1)
                     {
                     ?> 
                       <span class="result-no"><?php echo @mysql_num_rows($companyrsall); ?> Results Found</span> 
                     <?php
                     }
                     else
                     {
                     ?>
                             <span class="result-no">XXX Results Found</span> 
                     <?php
                     }
                }
                ?>  
            <span class="result-for">  for Incubation Investments</span>
            </h2>
            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo @mysql_num_rows($companyrs); ?>">
            <div class="title-links " id="exportbtn"></div>                   
            <?php 
            }
            else 
            {
               ?>
            <h2>
             <?php  
                if($studentOption==1)
                {
                ?>
                 <span class="result-no"><?php echo @mysql_num_rows($companyrsall); ?> Results Found</span>  
                 <?php
                }
                else
                {
                   if($exportToExcel==1)
                     {
                     ?> 
                       <span class="result-no"><?php echo @mysql_num_rows($companyrsall); ?> Results Found</span> 
                     <?php
                     }
                     else
                     {
                     ?>
                             <span class="result-no">XXX Results Found</span> 
                     <?php
                     }
                }
                ?>  
            <span class="result-for">  for Incubation Investments</span>
            </h2>
            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo @mysql_num_rows($companyrs); ?>">
            <div class="title-links " id="exportbtn"></div>
            <?php if(($industry >0 && $industry!=null)||($status>0)||($defunctflag==0)||($incfirmtype >0)||
                    ($followonFund!="--" && $followonFund!="")||($regionId>0)||($keyword!=" " && $keyword!="")||($companysearch!=" " && $companysearch!="")||($searchallfield!="")){ $cls="mt-list-tab"; ?>
            <ul class="result-select">
                <?php
                // echo "<bR>--**" .$followonVCFund."adsasd".$followonVCFundText;
                 //echo $queryDisplayTitle;
               if($industry >0 && $industry!=null){ ?>
                <li><?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php }
                if($status>0){ ?>
                <li>
                    <?php echo $statusvalue; ?><a  onclick="resetinput('statusid');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } if($defunctflag==0){ ?>
                <li>
                    <?php echo "Exclude Defunct Cos"; ?><a  onclick="resetinput('chkDefunct');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li> 
                
                <?php } if($incfirmtype >0){ ?>
                <li>
                    <?php echo $inctype; ?><a  onclick="resetinput('txtfirmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } 
                if($followonFund!="--" && $followonFund!=""){ ?>
                <li>
                    <?php echo $followonFundText;?><a  onclick="resetinput('followonFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php }  if($regionId>0){ ?>
                <li>
                    <?php echo $regionvalue;?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php }  if($keyword!=" " && $keyword!=""){ ?>
                <li>
                    <?php echo $keyword?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } if($companysearch!=" " && $companysearch!=""){ ?>
                <li>
                    <?php echo $companysearch?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } if($searchallfield!=""){ ?>
                <li>
                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
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
                 $cl_count = count($_POST);
                if($cl_count >= 4)
                {
                ?>
                <li class="result-select-close"><a href="incindex.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                <?php
                }
                ?>
             </ul> 
                    <?php }else { $cls="mt-list-tab-directory";} } 
                     
                    ?>
            
  </div>	
   <?php
        if($notable==false)
        { 
        ?>	
        
         <div class="list-tab <?php echo ($cls!="")?$cls:"mt-list-tab-directory"; ?>"><ul>
        <li class="active"><a class="postlink"   href="incindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
            <?php
            $count=0;
             While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
            {
                    if($count == 0)
                    {
                             $comid = $myrow["IncDealId"];
                            $count++;
                    }
            }
            ?>
        <li><a id="icon-detailed-view" class="postlink" href="incdealdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>" ><i></i> Detail View</a></li> 
        </ul></div>
         <?php
                if ($company_cntall>0)
                {
                      $hidecount=0;
                      //Code to add 
                      // /NEXT
                      $icount = 0;
                      if ($_SESSION['resultId']) 
                              unset($_SESSION['resultId']); 
                      if ($_SESSION['resultCompanyId']) 
                              unset($_SESSION['resultCompanyId']); 
                      mysql_data_seek($companyrsall,0);
                      While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                      {
                          $incubatorname=$myrow["Incubator"];
                          $companyName=trim($myrow["companyname"]);
                          $companyName=strtolower($companyName);
                          $compResult=substr_count($companyName,$searchString);
                          $compResult1=substr_count($companyName,$searchString1);
                          if(($compResult==0) && ($compResult1==0))
                          {
                              //Session Variable for storing Id. To be used in Previous / Next Buttons
                              $_SESSION['resultId'][$icount] = $myrow["IncDealId"]; 
                              $_SESSION['resultCompanyId'][$icount] = $myrow["companyid"];
                              $icount++;
                          }
                          $totalInv=$totalInv+1;
                      }
              }
        ?>
        <div class="view-table view-table-list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
                <th class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname" >Incubatee</th>
                <th class="header <?php echo ($orderby=="Incubator")?$ordertype:""; ?>" id="Incubator" >Incubator</th>
                <th class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>

               </tr></thead>
              
              <tbody id="movies">
                     <?php
                        if ($company_cnt>0)
                          {
                                $hidecount=0;
                                //Code to add PREV /NEXT
                                mysql_data_seek($companyrs,0);
                                While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                {
                                    
                                    if($myrow["Individual"]==1)
                                    {
                                            $openBracket="(";
                                            $closeBracket=")";
                                    }
                                    else
                                    {
                                            $openBracket="";
                                            $closeBracket="";
                                    }
                                    if(trim($myrow["sector_business"])=="")
                                            $showindsec=$myrow["industry"];
                                    else
                                            $showindsec=$myrow["sector_business"];
                                    $incubatorname=$myrow["Incubator"];
                                    $companyName=trim($myrow["companyname"]);
                                    $companyName=strtolower($companyName);
                                    $compResult=substr_count($companyName,$searchString);
                                    $compResult1=substr_count($companyName,$searchString1);

                           ?>           <tr>
                                <?php
                                                if(($compResult==0) && ($compResult1==0))
                                                {

                                ?>
                                                <td ><?php echo $openBracket ; ?><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?></td>
                                <?php
                                                }
                                                else
                                                {
                                ?>
                                                <td><?php echo ucfirst("$searchString");?></td>
                                <?php
                                                }
                                ?>
                                                <td><?php echo trim($incubatorname); ?></td>
                                                <td><?php echo trim($showindsec); ?></td>
                                                        </tr>
                                                <!--</tbody>-->
                                        <?php
                                        }
                                }
                                ?>
        </tbody>
    </table>

    </div>			
        <?php
                        }
              
        ?>
    <div class="holder">
                 <?php
                    $totalpages=  ceil($company_cntall/$rec_limit);
                    $firstpage=1;
                    $lastpage=$totalpages;
                    $prevpage=(( $currentpage-1)>0)?($currentpage-1):1;
                    $nextpage=(($currentpage+1)<$totalpages)?($currentpage+1):$totalpages;
                 ?>
                 
                  <?php
                    $pages=array();
                    $pages[]=1;
                    $pages[]=$currentpage-2;
                    $pages[]=$currentpage-1;
                    $pages[]=$currentpage;
                    $pages[]=$currentpage+1;
                    $pages[]=$currentpage+2;
                    $pages[]=$totalpages;
                    $pages =  array_unique($pages);
                    sort($pages);
                 if($currentpage<2){
                 ?>
                 <a class="jp-previous jp-disabled" >← Previous</a>
                 <?php } else { ?>
                 <a class="jp-previous" >← Previous</a>
                 <?php } for($i=0;$i<count($pages);$i++){ 
                     if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                ?>
                 <a class='<?php echo ($pages[$i]==$currentpage)? "jp-current":"jp-page" ?>'  ><?php echo $pages[$i]; ?></a>
                 <?php } 
                     }
                     if($currentpage<$totalpages){
                     ?>
                 <a class="jp-next">Next →</a>
                     <?php } else { ?>
                  <a class="jp-next jp-disabled">Next →</a>
                     <?php  } ?>
    </div>
    <?php
                if($studentOption==1)
		{
		?>
                     <script type="text/javascript" >
                           $("#show-total-deal").html<?php echo $totalInv; ?> (' Results found  ');
                    </script>
		
		<?php
		}
		else
		{

                    if($exportToExcel==1)
                    {
                    ?>
                        <script type="text/javascript" >
                         $("#show-total-deal").html<?php echo $totalInv; ?> (' Results found  ');
                        </script>
                    <?php
                    }
                    else
                    {
                    ?>
                       <script type="text/javascript" >
                           $("#show-total-deal").html('XXX Results found ');
                       </script>
                       <br><div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    }
                    
                            if(($totalInv>0) &&  ($exportToExcel==1))
                            {
                    ?>
                        <span style="float:right" class="one">
                        <input class="export" type="button" id="expshowdeals1"  value="Export" name="showdeals">
                        </span>
                        <script type="text/javascript">
                            $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                        </script>

                    <?php
                            }
                            elseif(($totalInv>0) && ($exportToExcel==0))
                            {
                    ?>
                            <div>
                             <span>
                                <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE investments.  </p>
                                <span style="float:right" class="one">
                                     <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                <a class ="export" target="_blank" href="../xls/Sample_Sheet_Investments.xls"> Export Sample</a>
                                </span>
                                <script type="text/javascript">
                                            $('#exportbtn').html('<a class="export"  href="../xls/Sample_Sheet_Investments.xls">Export Sample</a>');
                                </script>
                             </span>
                            </div>

                    <?php
                            }
		}
                ?>
		</div>
		<?php
					}
					elseif($buttonClicked=='Aggregate')
					{

						$aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
								and  pe.Deleted=0 " .$addVCFlagqry.
									 " order by pe.amount desc,dates desc";
						//	echo "<br>Agg SQL--" .$aggsql;
							 if ($rsAgg = mysql_query($aggsql))
							 {
								$agg_cnt = mysql_num_rows($rsAgg);
							 }
							   if($agg_cnt > 0)
							   {
									 While($myrow=mysql_fetch_array($rsAgg, MYSQL_BOTH))
									   {
											$totDeals = $myrow["totaldeals"];
											$totDealsAmount = $myrow["totalamount"];
										}
							   }
							   else
							   {
									$searchTitle= $searchTitle ." -- No Investments found for this search";
							   }
							   if($industry >0)
							   {
							   	  $indSql= "select industry from industry where industryid=$industry";
							   	  if($rsInd=mysql_query($indSql))
							   	  {
								   	  while($myindRow=mysql_fetch_array($rsInd,MYSQL_BOTH))
								   	  {
								   	  	$indqryValue=$myindRow["industry"];
								   	  }
								   }
								}
								 if($stage!="")
							   {
								  $stageSql= "select Stage from stage where StageId=$stage";
								  if($rsStage=mysql_query($stageSql))
								  {
									  while($mystageRow=mysql_fetch_array($rsStage,MYSQL_BOTH))
									  {
										$stageqryValue=$mystageRow["Stage"];
									  }
								   }
								}
								if($dealtype!= "--")
								{
									$dealSql= "select Stage from dealtypes where StageId=$stage";
								  	if($rsDealType=mysql_query($dealSql))
								  	{
									  while($mydealRow=mysql_fetch_array($rsDealType,MYSQL_BOTH))
									  {
										$stageqryValue=$mydealRow["Stage"];
									  }
								   	}
								 }
								if($range!= "--")
								{
									$rangeqryValue= $rangeText;
								}
								if($wheredates !== "")
								{
									$dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
								}
								$searchsubTitle="";
								if(($industry==0) && ($stage=="--") && ($range=="--") && ($wheredates==""))
								{
									$searchsubTitle= "All";
								}

					?>
						<div id="headingtextpro">
						<div id="headingtextproboldfontcolor"> <?php echo $searchAggTitle; ?> <br />  <br /> </div>
						<div id="headingtextprobold"> Search By :  <?php echo $searchsubTitle; ?> <br /> <br /></div>
					<?php
						$spacing="<Br />";
						if ($industry > 0)
						{

					?>
							<?php echo $qryIndTitle; ?><?php echo $indqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($stage !="")
						{
					?>
							<?php echo $qryDealTypeTitle; ?><?php echo $stageqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($range!="--")
						{
					?>
							<?php echo $qryRangeTitle; ?><?php echo $rangeqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($wheredates!="--")
						{
					?>
							<?php echo $qryDateTitle; ?><?php echo $dateqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
					?>
						<div id="headingtextprobold"> <br />No of Deals : <?php echo $totDeals; ?>  <br /> <br/></div>
						<div id="headingtextprobold"> Value (US $M) : <?php echo $totDealsAmount; ?>   <br /></div>
						</div>
					<?php
					}
                                          
			?>
    </div>

    </td>

    </tr>
    </table>

    </div>
    <div class=""></div>

     
            <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="js/listviewfunctions.js"></script>
            <script type="text/javascript">
                 orderby='<?php echo $orderby; ?>';
                 ordertype='<?php echo $ordertype; ?>';
                $(".jp-next").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#next").val();
                    loadhtml(pageno,orderby,ordertype);}
                    return  false;
                });
                $(".jp-page").live("click",function(){
                    pageno=$(this).text();
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-previous").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#prev").val();
                     loadhtml(pageno,orderby,ordertype);
                    }
                    return  false;
                });
                $(".header").live("click",function(){
                    orderby=$(this).attr('id');
                    
                    if($(this).hasClass("asc"))
                        ordertype="desc";
                    else
                        ordertype="asc";
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });   
		$(document).ready(function(){ 
           
     
          });              
               function loadhtml(pageno,orderby,ordertype)
               {
                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'ajaxListview_inc.php',
                data: {

                        sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                        totalrecords : '<?php echo addslashes($company_cntall); ?>',
                        page: pageno,
                        vcflagvalue:'<?php echo $vcflagValue; ?>',
                        orderby:orderby,
                        ordertype:ordertype
                },
                success : function(data){
                        $(".view-table-list").html(data);
                        $(".jp-current").text(pageno);
                       var prev=parseInt(pageno)-1
                        if(prev>0)
                        $("#prev").val(pageno-1);
                        else
                        {
                        $("#prev").val(1);
//                        $(".jp-previous").addClass('.jp-disabled').removeClass('.jp-previous');
                        }
                        $("#current").val(pageno);
                        var next=parseInt(pageno)+1;
                        if(next < <?php echo $totalpages ?> )
                         $("#next").val(next);
                        else
                        {
                        $("#next").val(<?php echo $totalpages ?>);
//                        $(".jp-next").addClass('.jp-disabled').removeClass('.jp-next');
                        }
                        drawNav(<?php echo $totalpages ?>,parseInt(pageno))
                        jQuery('#preloading').fadeOut(500); 
                       
                        return  false;
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                        jQuery('#preloading').fadeOut(500);
                        alert('There was an error');
                }
            });
               }
			
                $("a.postlink").live('click',function(){
                  
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
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
            </script>
            <script type="text/javascript">
        
           $('#expshowdeals').click(function(){ 
            hrefval= 'exportinvdeals.php';
            
            $("#pelisting").submit();
            return false;
            });
            $('#expshowdeals1').click(function(){ 
            hrefval= 'exportinvdeals.php';
            
            $("#pelisting").submit();
            return false;
            });
            
                $("a.postlink").live('click',function(){
                   $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
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
            </script>
                </div>
    </form>
    <form name="pelisting"  method="post" action="exportincdeals.php" id="pelisting">
    <input type="hidden" name="txtsearchon" value="1" >
    <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
    <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
    <input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
    <input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
    <input type="hidden" name="txthidestage" value=<?php echo $statusvalue; ?> >
    <input type="hidden" name="txthidestageid" value=<?php echo $status; ?> >
    <input type="hidden" name="txthidefirmtypeid" value=<?php echo $incfirmtype; ?> >
    <input type="hidden" name="txthidedefunct" value=<?php echo $defunctflag; ?> >
    <input type="hidden" name="txthidedefunctvalue" value=<?php echo $defunctText; ?> >
    <input type="hidden" name="txthidefollowonfund" value=<?php echo $followonFund; ?> >
    <input type="hidden" name="txthidefollowonfundvalue" value=<?php echo $followonFundText; ?> >
    <input type="hidden" name="txthideregion" value=<?php echo $regionId; ?> >
    <input type="hidden" name="txthideregiontext" value=<?php echo $regionvalue; ?> >
    <input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
    <input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
    <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
    </form>
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
    mysql_close();
    ?>
<script type="text/javascript" >
        <?php  if($_POST || $vcflagValue==6)
        { ?>
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
        <?php } ?>
                                        
    </script> 