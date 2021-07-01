<?php
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
      // print_r($_POST);
        $dealvalue = isset($_POST['showdeals']) ? $_POST['showdeals'] :102;
       //echo "DealValue=".$dealvalue;
        if($resetfield=="autocomplete")
        { 
         $_POST['autocomplete']="";
         $dirsearch="";
         $search="";
        }
        else 
        {
         $dirsearch=trim($_POST['autocomplete']);
        }
    
        if($_REQUEST['sv'] =='')
        {
            if($_POST['autocomplete'] != '')
            {
               $_POST['showdeals'] ='';
            }
            if($_POST['showdeals'] != '')
            {
                $dealvalue = $_POST['showdeals'];
            }
            else {
                     $dealvalue = isset($_REQUEST['showvalue']) ? $_REQUEST['showvalue']:102; 
            }
        }
        else         
        {
        $dealvalue= isset($_REQUEST['sv']) ? $_REQUEST['sv'] : 102;
        }
			
        include('machecklogin.php');
        $limit = ' LIMIT 0,100';
        $_REQUEST['s'] = (isset($_REQUEST['s'])) ? $_REQUEST['s'] : '';
        $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
        $totalCount=0;

        $resetfield=$_POST['resetfield'];
        
                if($resetfield=="searchallfield")
               { 
                $_POST['searchallfield']="";
                $searchallfield="";
               }
               else 
               {
                $searchallfield=trim($_POST['searchallfield']);
               }
               
		if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";

                if($search !='')
                {   
                    if($dealvalue ==101)
                    {
                        $search=" and  RTRIM(pec.companyname) like '$search%'";
                    }
                    else if($dealvalue ==102)
                    {
                         $search=" and  RTRIM(ac.Acquirer) like '$search%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {
                        $search=" and  RTRIM(cia.Cianame) like '$search%'";
                    }
                }
    
                if($dirsearch !='' && !(isset($_GET['s'])))
                {
                   if($dealvalue ==101)
                    {
                        $dirsearchall=" and  RTRIM(pec.companyname) like '".$dirsearch."%'";
                    }
                     if($dealvalue ==102)
                    {
                        $dirsearchall=" and  RTRIM(ac.Acquirer) like '".$dirsearch."%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {
                        $dirsearchall=" and  RTRIM(cia.Cianame) like  '".$dirsearch."%'";
                    }
                     $search='';
                }
                
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
                
    if($_SESSION['MA_industries']!=''){
               
        $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['MA_industries'].') ';
    }
               
                if($dealvalue==101)
                {                 
                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business FROM
                    mama AS pe, industry AS i, pecompanies AS pec WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                     AND pe.Deleted =0 " .$search." ".$dirsearchall." $comp_industry_id_where order by pec.companyname";
                   //echo $showallsql;
                }
                else if($dealvalue==102)
                {
                    if($_SESSION['MA_industries']!=''){

                        $comp_industry_id_where = ' AND ac.IndustryId IN ('.$_SESSION['MA_industries'].') ';
                    }
                    $showallsql="SELECT distinct peinv.AcquirerId, ac.Acquirer
                    FROM acquirers AS ac, mama AS peinv
                    WHERE ac.AcquirerId = peinv.AcquirerId and
                    peinv.Deleted=0 " .$search." ".$dirsearchall.$comp_industry_id_where." order by Acquirer";
                    //echo $showallsql;
                }
                else if($dealvalue==103 || $dealvalue==104)
                {
                    if($_SESSION['MA_industries']!=''){

                        $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['MA_industries'].') ';
                    }
        
                    $showallsql="(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                    WHERE Deleted =0 AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                    AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.$comp_industry_id_where." )
                    UNION (
                    SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
                    WHERE Deleted =0 AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                    AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.$comp_industry_id_where." )	ORDER BY Cianame";
                    
                }
    
                mysql_query('SET CHARACTER SET utf8');
                 if ($_SESSION['totalall']) 
                {
                    unset($_SESSION['totalall']);
                }
               
               $ajaxcompanysql=  urlencode($showallsql);
               $totall=0;
               if ($rsinvestor = mysql_query($showallsql))
               {
                    $totalrecords = mysql_num_rows($rsinvestor);
                    $_SESSION['totalall']=mysql_num_rows($rsinvestor);
               }
    
               if($totalrecords > 0)
                {
                    $rec_limit = 100;
                    $rec_count = $totalrecords;
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
                    $companysqlwithlimit=$showallsql." limit $offset, $rec_limit";
               }
                
     echo "<div style='display:none'>$showallsql</div>";
                
	$topNav = 'Directory';
        $defpage=$defvalue;
        $stagedef=1;
	include_once('madir_header.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
<?php
        $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc ,malogin_members as dm
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
        
        $totalDisplay="Total";
        $industryAdded ="";
        $totalAmount=0.0;
        $totalInv=0;
        $compDisplayOboldTag="";
        $compDisplayEboldTag="";

        if ($rsinvestor = mysql_query($companysqlwithlimit))
        {
             $investor_cnt = mysql_num_rows($rsinvestor);
        }

        if($investor_cnt > 0)
        {
                    $notable=false;
        }
        else
        {
             $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
             $notable=true;
             writeSql_for_no_records($companysql,$emailid);
        }

       ?>
    
    <td class="profile-view-left" style="width:100%;">
<div class="result-cnt">
    <div class="result-title result-title-nofix"> 
    
                                            
                        	<?php if(!$_POST){
                                    ?>
                                    <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo $totalrecords; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Target Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Acquirer Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for  Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                         <!--  <span class="result-for">for MA Directory</span> -->
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalrecords; ?>">
                                           </h2>
    
                                    <div class="title-links " id="exportbtn"></div>
                                    <?php
                                   }
                                   else 
                                   { ?>    <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo $totalrecords; ?> Results found</span>
                                           <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Target Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Acquirer Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for  Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for  Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                          <!-- <span class="result-for">for MA Directory</span> -->
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalrecords; ?>">
                                           </h2>
    
                             <div class="title-links " id="exportbtn"></div>
                             <?php /* if($dirsearch!="" || (count($_POST)>4) || $search!=""){ ?>
                             
                             <!-- <ul class="result-select">
                                <?php 
                                 if($dirsearch!="") { ?>
                                <li> 
                                    <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($search!="") { ?>
                                <li> 
                                    <?php echo $_REQUEST['s'];?><a  onclick="resetinput('autocomplete');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                               // print_r($_POST);
                                $cl_count = count($_POST);
                                if($cl_count > 3)
                                {
                                ?>
                                <li class="result-select-close"><a href="pedirview.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                ?>
                             </ul>-->
                             
                             <?php } */?>
                                    
                             <?php } ?>
                             
                                            
                        </div>
    
    <div class="directory-cnt" id="directorySearch"> 
        <div class="search-area"  style="position:relative">
            <a id="detailpost" class="postlink"></a> 
            <input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="Directory Search" > <img  id="autosuggest_loading"  src="img/autosuggest_loading.gif" style="position: absolute;left: 21%;top: 10%; display:none;">
            <a type="text" id="compid" ></a>
            <input type="button" id="searchsub" name="fliter_dir" value="" onclick="this.form.submit();">
        </div>
<h3>Show by:</h3>
        <div class="show-by-list">
        <ul>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=&sv=<?php echo $dealvalue;?>" class="postlink <?php if($_REQUEST['s']==''){?> active<?php } ?>" >All</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=a&sv=<?php echo $dealvalue;?>" class="postlink <?php if(a==$_REQUEST['s']){?> active<?php }?>">A</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=b&sv=<?php echo $dealvalue;?>" class="postlink <?php if(b==$_REQUEST['s']){?> active<?php }?>">B</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=c&sv=<?php echo $dealvalue;?>" class="postlink <?php if(c==$_REQUEST['s']){?> active<?php }?>">C</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=d&sv=<?php echo $dealvalue;?>" class="postlink <?php if(d==$_REQUEST['s']){?> active<?php }?>">D</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=e&sv=<?php echo $dealvalue;?>" class="postlink <?php if(e==$_REQUEST['s']){?> active<?php }?>">E</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=f&sv=<?php echo $dealvalue;?>" class="postlink <?php if(f==$_REQUEST['s']){?> active<?php }?>">F</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=g&sv=<?php echo $dealvalue;?>" class="postlink <?php if(g==$_REQUEST['s']){?> active<?php }?>">G</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=h&sv=<?php echo $dealvalue;?>" class="postlink <?php if(h==$_REQUEST['s']){?> active<?php }?>">H</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=i&sv=<?php echo $dealvalue;?>" class="postlink <?php if(i==$_REQUEST['s']){?> active<?php }?>">I</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=j&sv=<?php echo $dealvalue;?>" class="postlink <?php if(j==$_REQUEST['s']){?> active<?php }?>">J</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=k&sv=<?php echo $dealvalue;?>" class="postlink <?php if(k==$_REQUEST['s']){?> active<?php }?>">K</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=l&sv=<?php echo $dealvalue;?>" class="postlink <?php if(l==$_REQUEST['s']){?> active<?php }?>">L</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=m&sv=<?php echo $dealvalue;?>" class="postlink <?php if(m==$_REQUEST['s']){?> active<?php }?>">M</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=n&sv=<?php echo $dealvalue;?>" class="postlink <?php if(n==$_REQUEST['s']){?> active<?php }?>">N</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=o&sv=<?php echo $dealvalue;?>" class="postlink <?php if(o==$_REQUEST['s']){?> active<?php }?>">O</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=p&sv=<?php echo $dealvalue;?>" class="postlink <?php if(p==$_REQUEST['s']){?> active<?php }?>">P</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=q&sv=<?php echo $dealvalue;?>" class="postlink <?php if(q==$_REQUEST['s']){?> active<?php }?>">Q</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=r&sv=<?php echo $dealvalue;?>" class="postlink <?php if(r==$_REQUEST['s']){?> active<?php }?>">R</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=s&sv=<?php echo $dealvalue;?>" class="postlink <?php if(s==$_REQUEST['s']){?> active<?php }?>">S</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=t&sv=<?php echo $dealvalue;?>" class="postlink <?php if(t==$_REQUEST['s']){?> active<?php }?>">T</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=u&sv=<?php echo $dealvalue;?>" class="postlink <?php if(u==$_REQUEST['s']){?> active<?php }?>">U</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=v&sv=<?php echo $dealvalue;?>" class="postlink <?php if(v==$_REQUEST['s']){?> active<?php }?>">V</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=w&sv=<?php echo $dealvalue;?>" class="postlink <?php if(w==$_REQUEST['s']){?> active<?php }?>">W</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=x&sv=<?php echo $dealvalue;?>" class="postlink <?php if(x==$_REQUEST['s']){?> active<?php }?>">X</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=y&sv=<?php echo $dealvalue;?>" class="postlink <?php if(y==$_REQUEST['s']){?> active<?php }?>">Y</a></li>
            <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=z&sv=<?php echo $dealvalue;?>" class="postlink <?php if(z==$_REQUEST['s']){?> active<?php }?>">Z</a></li>
                            </ul>
    </div>
                    </div>
      
     <?php
                        if($notable==false)
                        {
                             $rowlimit=25;
                                $offset=0;
                                $i=1;
                                $j=1;
                                $newrowflag=1;
                                $newcolumnflag=1;
                                $columncount=1;
                                 $columnlimit=4;?>
    <div class="list-view-table view-table-list">
                            
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTables" class="directroyList">
                              <thead><tr>
                                      <?php
                                        if($dealvalue==101)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Target Companies</th>
                                      <?php
                                          }
                                          if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Acquirer Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of  Legal Advisors</th>
                                      <?php
                                          } else if ($dealvalue==104){
                                      ?>
                                               <th colspan="<?php echo $columnlimit; ?>">List of  Transaction Advisors</th>
                                      <?php
                                          }
                                      
                                      ?>
                              </tr></thead>
                              
                              <tbody id="movies">
                                  <?php
                                    //Code to add PREV /NEXT
                                        $icount = 0;
                                         if ($_SESSION['resultCompanyId'])
                                        {
                                              unset($_SESSION['resultCompanyId']);
                                        }
                                    
                                        if ($_SESSION['acquirerId']) 
                                        {
                                            unset($_SESSION['acquirerId']);
                                        }
                                       
                                        if ($_SESSION['advisorId'])
                                        {
                                              unset($_SESSION['advisorId']);
                                        }
                                     $count=mysql_num_rows($rsinvestor);
                                     //echo "Deal value=".$dealvalue;
                                     
                                  if($dealvalue==101)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $companyname=trim($myrow["companyname"]);
                                                $companyname=strtolower($companyname);

                                                $invResult=substr_count($companyname,$searchString);
                                                $invResult1=substr_count($companyname,$searchString1);
                                                $invResult2=substr_count($companyname,$searchString2);
                                            
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                $_SESSION['resultCompanyId'][$icount++] = $myrow["PECompanyId"]; ?>
                                                   
                                                <tr>
                                       <td ><a class="postlink" href="dircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $dealvalue;?> "> <?php echo $myrow["companyname"];?></a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
						
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      //echo "</table></td></tr>";
                                                   }
                                                
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {
                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                   //   echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                                    
                                     if($dealvalue==102)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Acquirer"]);
                                                $adviosrname=strtolower($adviosrname);
                                                $querystrvalue= $myrow["AcquirerId"];
                                                
                                               $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                                
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                $_SESSION['acquirerId'][$icount++] = $myrow["AcquirerId"]; ?>
                                                   
                                                <tr>
                                       <td ><a class="postlink" href="diracquirer.php?value=<?php echo $myrow["AcquirerId"];?>/<?php echo $dealvalue;?> "><?php echo $myrow["Acquirer"];?> </a></td></tr>
                                                    <?php $totalCount=$totalCount+1;
                                                }
						
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                    //  echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                    //  echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                                     else if($dealvalue==103 || $dealvalue==104)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Investor"]);
                                                $adviosrname=strtolower($adviosrname);

                                                $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                            
                                                if($newrowflag==1)
                                                echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                                
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                        $querystrvalue= $myrow["CIAId"];
                                                        $_SESSION['advisorId'][$icount++] = $myrow["CIAId"];
                                         ?>
                                                        <tr><td>
                                                        <a style="text-decoration: none" href='diradvisor.php?value=<?php echo $querystrvalue;?>/<?php echo $dealvalue;?>' >
                                                        <?php echo $myrow["Cianame"]; ?></a></td></tr>
                                                <?php
                                                        $totalCount=$totalCount+1;
                                                }
                                                 $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td></tr>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                    //  echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                        }
                                     }
                                  ?>
                                                           
                              </tbody> 
                              
                             </table>
                       
                             
                </div>	

                <!-- <div class="pageinationManual"> -->
                <div class="holder" style="float:none; text-align: center;">
             <div class="paginate-wrapper" style="display: inline-block;">
                 <?php
                    $totalpages=  ceil($totalrecords/$rec_limit);
                    $firstpage=1;
                    $lastpage=$totalpages;
                    $prevpage=(( $currentpage-1)>0)?($currentpage-1):1;
                    $nextpage=(($currentpage+1)<$totalpages)?($currentpage+1):$totalpages;
                 
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
                if($currentpage<2){ ?>
                            
                 <a class="jp-previous jp-disabled" >&#8592; Previous</a>
                 <?php } else { ?>
                                
                 <a class="jp-previous" >&#8592; Previous</a>
                 <?php } for($i=0;$i<count($pages);$i++){ 
                                
                if($pages[$i] > 0 && $pages[$i] <= $totalpages){ ?>

                 <a class='<?php echo ($pages[$i]==$currentpage)? "jp-current":"jp-page" ?>'  ><?php echo $pages[$i]; ?></a>
                 <?php } 
                                    }if($currentpage<$totalpages){ ?>
                                            
                 <a class="jp-next">Next &#8594;</a>
                <?php } else { ?>
                                        
                  <a class="jp-next jp-disabled">Next &#8594;</a>
                     <?php  } ?>
    </div></div>
                <!-- </div> -->

                    <center>
    <div class="pagination-section"><input type="text" name = "paginaitoninput" id = "paginationinput" class = "paginationtextbox" placeholder = "P.no" onkeyup = "paginationfun(this.value)">
   <button class = "jp-page1 button pagevalue" name="pagination"  id="pagination"  type="submit" onclick = "validpagination()">Go</button></div>
   </center>


         
                        <?php if(($exportToExcel==1)){ ?>
                    
				<span style="float:right" class="one">
				<input class="export" id="expshowdealsbtn" type="button"  value="Export" name="showprofile">
				</span>
				 <script type="text/javascript">
                        $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showprofile">');
                 </script>
                        <?php } 
		}
                                        else
                                        {
                                            echo "NO DATA FOUND";
                    } ?>
				 
    </div>
</td>
</tr>
</table>
</div>
</form>
<?php if($dealvalue==101){ ?>

               <form name="pegetdata" id="pegetdata"  method="post" action="exportcompaniesprofile.php">
               <input type="hidden" name="hidevcflagValue" value="9" >
               <input type="hidden" name="hideShowAll" value="ShowAll" >
               <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
<?php } if($dealvalue==102){ ?>
       
                <form name="pegetdata" id="pegetdata"  method="post" action="exportacquirerProfile.php" >
		<input type="hidden" name="hideShowAll" value="ShowAll" >
                <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
                <input type="hidden" name="txthideemail1" value="<?php echo $emailid1;?>" >
                
<?php }else if($dealvalue==103 || $dealvalue==104){

                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
            ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportadvisorsprofile.php" >
                <input type="hidden" name="hidepeipomandapage" value="4" >
		<input type="hidden" name="hideShowAll" value="ShowAll" >
                <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
                <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
            <?php
            }
            ?>
<div class=""></div>
</form>


        <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
        <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
        <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
        <script src="<?php echo $refUrl; ?>js/listviewfunctions.js"></script>
        <script type="text/javascript">
            orderby='<?php echo $orderby; ?>';
            ordertype='<?php echo $ordertype; ?>';
           $(".jp-next").live("click",function(){
               if(!$(this).hasClass('jp-disabled')){
               pageno=$("#next").val();
               $("#paginationinput").val('');
               loadhtml(pageno,orderby,ordertype);}
               return  false;
           });
           $(".jp-page").live("click",function(){
               pageno=$(this).text();
               $("#paginationinput").val('');
                loadhtml(pageno,orderby,ordertype);
               return  false;
           });
           $(".jp-page1").live("click",function(){
               pageno=$(this).val();
                loadhtml(pageno,orderby,ordertype);
               return  false;
           });
           $(".jp-previous").live("click",function(){
               if(!$(this).hasClass('jp-disabled')){
               pageno=$("#prev").val();
               $("#paginationinput").val('');
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

          function  loadhtml(pageno,orderby,ordertype)
          {
           jQuery('#preloading').fadeIn(1000);   
           $.ajax({
           type : 'POST',
           url  : 'madirviewajax.php',
           data: {

                   sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                   totalrecords : '<?php echo addslashes($totalrecords); ?>',
                   page: pageno,
                   vcflagvalue:'<?php echo $vcflagValue; ?>',
                   orderby:orderby,
                   ordertype:ordertype,
                   dealvalue:<?php echo $dealvalue; ?>
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
      
       </script>
       <script type="text/javascript">
                $("a.postlink").click(function(){
                 
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval); 
                    $("#pesearch").submit();
                    
                    return false;
                    
                });
                /*$('.export').click(function(){ 
                     hrefval= 'exportinvestorprofile.php';
                     $("#pegetdata").submit();
                     return false;
                 });*/
    
                 $('#expshowdeals,.export').click(function(){ 
                     
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });

          /*      $('#expshowdealsbtn').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });*/
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
                
                function initExport(){ 
                    
                        url = ($("#pegetdata").attr('action')=='exportacquirerProfile.php') ? 'exportacquirerProfilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportcompaniesprofile.php') ? 'exportcompaniesprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportadvisorsprofile.php') ? 'exportadvisorsprofilecnt.php' : '';
                        $.ajax({
                            url: url ,
                            data: $("#pegetdata").serialize(),
                            type: 'POST',
                            success: function(data){
                                var currentRec = data;
                                //alert(currentRec);
                                 if (currentRec > 0){
                                    $.ajax({
                                        url: 'ajxCheckDownload.php',
                                        dataType: 'json',
                                        success: function(data){
                                            var downloaded = data['recDownloaded'];
                                            var exportLimit = data.exportLimit;
                                            var remLimit = exportLimit-downloaded;
                                
                                            if (currentRec <= remLimit){
                                                //hrefval= 'exportinvestorprofile.php';
                                                //$("#pegetdata").attr("action", hrefval);
                                                $("#pegetdata").submit();
                                            }else{
                                                jQuery('#preloading').fadeOut();
                                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                                            }
                                            jQuery('#preloading').fadeOut();
                                        },
                                        error:function(){
                                            jQuery('#preloading').fadeOut();
                                            alert("There was some problem exporting...");
                                        }

                                    });
                                }else{
                                    jQuery('#preloading').fadeOut();
                                    alert("There was some problem exporting...");
                                }
                            },
                            error: function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem exporting...");
                            }
                        });
                    }
                 
    
                function resetinput(fieldname)
                {
                 
                //alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val(fieldname));
                  $("#pesearch").submit();
                    return false;
                }
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
 ?>
<SCRIPT>
$(function() {
    $( "#autocomplete" ).autocomplete({
        
      source: function( request, response ) {
          
      $("#autosuggest_loading").show();    
      
        $.ajax({
            type: "POST",
          url: "directoryajax.php",
          dataType: "json",
          data: {
            queryString: request.term,
            dealvalue: <?php echo $dealvalue; ?>
          },
          success: function( data ) {
      
            $("#autosuggest_loading").hide();
            response( $.map( data, function( item ) {
                if (item.dealvalue==102 || item.dealvalue==101){
                    return {
                        label: item.companyname,
                        value: item.companyname,
                         id: item.companyId,
                         dval:item.dealvalue
                      };
                }else if (item.dealvalue==103 || item.dealvalue==104){
                    return {
                        label: item.advisors,
                        value: item.advisors,
                         id: item.companyId,
                         dval:item.dealvalue
                      };
                }
              
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
        $('#industry').val(ui.item.value);
        $("#compid").val(ui.item.id);
        idval=$("#compid").val();
        
        if(<?php echo $dealvalue;?>==101)
            {
                $("#detailpost").attr("href","<?php echo BASE_URL; ?>ma/dircomdetails.php?value="+idval+"/<?php echo $dealvalue;?>").trigger("click");
            }
            else if(<?php echo $dealvalue;?>==102)
            {
                $("#detailpost").attr("href","<?php echo BASE_URL; ?>ma/diracquirer.php?value="+idval+"/<?php echo $dealvalue;?>").trigger("click");
            }
            else if(<?php echo $dealvalue;?>==103)
            {
                $("#detailpost").attr("href","<?php echo BASE_URL; ?>ma/diradvisor.php?value="+idval+"/<?php echo $dealvalue;?>").trigger("click");
            }
            else if(<?php echo $dealvalue;?>==104)
            {
                $("#detailpost").attr("href","<?php echo BASE_URL; ?>ma/diradvisor.php?value="+idval+"/<?php echo $dealvalue;?>").trigger("click");
            }
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
  }); 
  
</SCRIPT>

<script src="hopscotch.js"></script>
    <script src="demo.js"></script>
    
        <script type="text/javascript" >
            $(document).ready(function(){
                
    <?php 
    // Guided tour attributes 
    $tourIndustryId="24";
    // End of Tour Attributes
    if(isset($_POST["searchpe"]) ){?>
            //init();
            hopscotch.startTour(tour, 3);
    <?php } 
          else if(isset($_POST["controlName"])) {
            
                switch ($_POST["controlName"]) {
                    case 'dealperiod': ?>
                           hopscotch.startTour(tour, 5);
                   <?php break;
                   case 'industry':
                       if($_POST["industry"]==$tourIndustryId){
                       ?>
                           hopscotch.startTour(tour, 7);
                       <?php }else { ?>
                           hopscotch.startTour(tour, 6);
                       <?php } break;
                   case 'postlink':
                       ?>
                           hopscotch.startTour(tour, 14);
                       <?php break;
                    default:  ?>
                         init();
                   <?php break;
                }
            
        }  
        else if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=="1" ) {
            if(isset($_POST["showdeals"]) && $_POST["showdeals"]=="104" ) {
            ?>
                hopscotch.startTour(tour, 17);
            <?php }else{ ?>  
                hopscotch.startTour(tour, 16);
            <?php } } ?>
            });
            $( window ).scroll(function() {
            hopscotch.refreshBubblePosition();
           });
           
        </script>
        <?php mysql_close(); ?>



    <script>

        function paginationfun(val)
        {
            $(".pagevalue").val(val);
        }
        function validpagination()
            {
                var pageval = $("#paginationinput").val();
                if(pageval == "")
                {
                    alert('Please enter the page Number...');
                    location.reload();
                }else{
                    
                }
            }

        var wage = document.getElementById("paginationinput");
        wage.addEventListener("keydown", function (e) {debugger;
            if (e.code === "Enter") {  //checks whether the pressed key is "Enter"
                //paginationForm();
                event.preventDefault();
                document.getElementById("pagination").click();

            }
        });
    </script>

    <style>  
        .paginationtextbox{
            width:3%;
            padding: 3px;
        }

        input[type='text']::placeholder
    {   
        text-align: center;      /* for Chrome, Firefox, Opera */
    }
        .button{
            background-color: #a2753a; /* Green */
            border: none;
            color: white;
            padding: 4px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
        .pageinationManual{
            display: flex;
            position: absolute;
            left: 35%;
        }
    </style>