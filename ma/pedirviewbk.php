<?php
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
       //print_r($_POST);
        $dealvalue = isset($_POST['showdeals']) ? $_POST['showdeals'] :102;
       // echo $dealvalue;
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
			
        include('checklogin.php');
        $limit = ' LIMIT 0,100';
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
                    if($dealvalue ==102)
                    {
                        $search=" and  pec.companyname like '$search%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {
                        $search=" and  cia.Cianame like '$search%'";
                    }
                }
                if($dirsearch !='')
                {
                   if($dealvalue ==102)
                    {
                        $dirsearchall=" and  pec.companyname like '$dirsearch%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {
                        $dirsearchall=" and  cia.Cianame like '$dirsearch%'";
                    }
                }
                
               
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
                
               
                if($dealvalue==102)
                {                 
                   $showallsql="SELECT DISTINCT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business FROM
                                mama AS pe, industry AS i, pecompanies AS pec WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                                AND pe.Deleted =0 " .$search." ".$dirsearchall." and pec.industry != 15  order by pec.companyname";

                   //echo $showallsql;
                }
                else if($dealvalue==103 || $dealvalue==104)
                {
                    $showallsql="(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
					AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry." )
					UNION (
					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adcomp.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
					AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry." )	ORDER BY Cianame";
                    
                }
                
               $showallsql = $showallsql.$limit;
                
                
	$topNav = 'Directory';
        $defpage=$defvalue;
        $stagedef=1;
	include_once('madir_header.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
<?php
       /* $exportToExcel=0;
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
        }*/	
        $totalDisplay="Total";
        $industryAdded ="";
        $totalAmount=0.0;
        $totalInv=0;
        $compDisplayOboldTag="";
        $compDisplayEboldTag="";

       // exit;
        if ($rsinvestor = mysql_query($showallsql))
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
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           <span class="result-for">for MA Directory</span>
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                                    <!--div class="title-links " id="exportbtn"></div-->
                                    <?php
                                   }
                                   else 
                                   { ?>    <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           <span class="result-for">for MA Directory</span>
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                             <!--div class="title-links " id="exportbtn"></div-->
                             <?php if($dirsearch!="" || (count($_POST)>4) || $search!=""){
                                 ?>
                             
                             <ul class="result-select">
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
                             </ul>
                             
                             <?php } }?>
                             
                                            
                        </div>
    
     <?php
                        if($notable==false)
                        {
                            ?>
                        
                             <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"  href="pedirview.php?value=<?php echo $_GET['value'];?>"  id="icon-grid-view"><i></i> List  View</a></li>
                         <?php
                          /*  $count=0;
                             While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                            {
                                    if($count == 0)
                                    {
                                             $comid = $myrow["InvestorId"];
                                            $count++;
                                    }
                            }*/
                        ?>
                        <li><a id="icon-detailed-view" class="postlink" href="dirdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detail  View</a></li> 
                        </ul></div>
				<?php  $rowlimit=25;
                                $offset=0;
                                $i=1;
                                $j=1;
                                $newrowflag=1;
                                $newcolumnflag=1;
                                $columncount=1;
                                 $columnlimit=4;?>
    
    <div class="directory-cnt"> 
        <div class="search-area">
             <input type="hidden" name="showvalue" value="<?php echo $dealvalue?>"> 
            <input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="Directory Search"  value="">
            <input type="button" name="fliter_dir" value="" onclick="this.form.submit();" >
        </div>
  </form>
  
            <!--form name="pegetdata" id="pegetdata"  method="post" action="exportinvestorprofile1.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >    
            <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
            <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
            <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
            <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
            <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
            <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
            <input type="hidden" name="hidepeipomandapage" value="4" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" -->
       
<h3>Show by:</h3>
        <div class="show-by-list">
        <ul><li>
        <a href="pedirview.php?value=<?php echo $_GET['value']?>&sv=<?php echo $dealvalue;?>" class="postlink <?php if(!$_REQUEST['s']){?> active<?php } ?>" >All</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=a&sv=<?php echo $dealvalue;?>" class="postlink <?php if(a==$_REQUEST['s']){?> active<?php }?>">A</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=b&sv=<?php echo $dealvalue;?>" <?php if(b==$_REQUEST['s']){?>class="active" <?php }?>>B</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=c&sv=<?php echo $dealvalue;?>" class="postlink <?php if(c==$_REQUEST['s']){?> active<?php }?>">C</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=d&sv=<?php echo $dealvalue;?>" <?php if(d==$_REQUEST['s']){?>class="active" <?php }?>>D</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=e&sv=<?php echo $dealvalue;?>" class="postlink <?php if(e==$_REQUEST['s']){?> active<?php }?>">E</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=f&sv=<?php echo $dealvalue;?>" <?php if(f==$_REQUEST['s']){?>class="active" <?php }?>>F</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=g&sv=<?php echo $dealvalue;?>" class="postlink <?php if(g==$_REQUEST['s']){?> active<?php }?>">G</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=h&sv=<?php echo $dealvalue;?>" <?php if(h==$_REQUEST['s']){?>class="active" <?php }?>>H</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=i&sv=<?php echo $dealvalue;?>" class="postlink <?php if(i==$_REQUEST['s']){?> active<?php }?>">I</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=j&sv=<?php echo $dealvalue;?>" <?php if(j==$_REQUEST['s']){?>class="active" <?php }?>>J</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=k&sv=<?php echo $dealvalue;?>" class="postlink <?php if(k==$_REQUEST['s']){?> active<?php }?>">K</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=l&sv=<?php echo $dealvalue;?>" <?php if(l==$_REQUEST['s']){?>class="active" <?php }?>>L</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=m&sv=<?php echo $dealvalue;?>" class="postlink <?php if(m==$_REQUEST['s']){?> active<?php }?>">M</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=n&sv=<?php echo $dealvalue;?>" <?php if(n==$_REQUEST['s']){?>class="active" <?php }?>>N</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=o&sv=<?php echo $dealvalue;?>" class="postlink <?php if(o==$_REQUEST['s']){?> active<?php }?>">O</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=p&sv=<?php echo $dealvalue;?>" <?php if(p==$_REQUEST['s']){?>class="active" <?php }?>>P</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=q&sv=<?php echo $dealvalue;?>" class="postlink <?php if(q==$_REQUEST['s']){?> active<?php }?>">Q</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=r&sv=<?php echo $dealvalue;?>" <?php if(r==$_REQUEST['s']){?>class="active" <?php }?>>R</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=s&sv=<?php echo $dealvalue;?>" class="postlink <?php if(s==$_REQUEST['s']){?> active<?php }?>">S</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=t&sv=<?php echo $dealvalue;?>" <?php if(t==$_REQUEST['s']){?>class="active" <?php }?>>T</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=u&sv=<?php echo $dealvalue;?>" class="postlink <?php if(u==$_REQUEST['s']){?> active<?php }?>">U</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=v&sv=<?php echo $dealvalue;?>" <?php if(v==$_REQUEST['s']){?>class="active" <?php }?>>V</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=w&sv=<?php echo $dealvalue;?>" class="postlink <?php if(w==$_REQUEST['s']){?> active<?php }?>">W</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=x&sv=<?php echo $dealvalue;?>" <?php if(x==$_REQUEST['s']){?>class="active" <?php }?>>X</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=y&sv=<?php echo $dealvalue;?>" class="postlink <?php if(y==$_REQUEST['s']){?> active<?php }?>">Y</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=z&sv=<?php echo $dealvalue;?>" <?php if(z==$_REQUEST['s']){?>class="active" <?php }?>>Z</a></li>
</ul></div>  
    </div>
    <div class="list-view-table">
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTables">
                              <thead><tr>
                                      <?php
                                        if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of MA Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of MA Legal Advisors</th>
                                      <?php
                                          } else if ($dealvalue==104){
                                      ?>
                                               <th colspan="<?php echo $columnlimit; ?>">List of MA Transaction Advisors</th>
                                      <?php
                                          }
                                      
                                      ?>
                              </tr></thead>
                              
                              <tbody id="movies">
                                  <?php
                                    //Code to add PREV /NEXT
                                        $icount = 0;
                                        if ($_SESSION['investeeId']) 
                                        unset($_SESSION['investeeId']);
//                                        if ($_SESSION['resultCompanyId']) 
//                                        unset($_SESSION['resultCompanyId']); 
                                    
                                       // mysql_data_seek($rsinvestor ,0);
                                     $count=mysql_num_rows($rsinvestor);
                                     //echo "Deal value=".$dealvalue;
                                     
                                  if($dealvalue==102)
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
                                                    $_SESSION['resultCompanyId'][$icount++] = $myrow["MAMAId"];
                                                   
                                   ?><tr>
                                       <td ><?php echo $myrow["companyname"];?><!--a class="postlink" href="dircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $dealvalue;?> "> </a--></td></tr>
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

                                                      echo "</table></td></tr>";
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
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
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
        </div>
			<?php
					}
				 
			?>
             <div class="holder"></div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
		<?php
		if(($exportToExcel==1))
		{
		?>
				<span style="float:right" class="one">
				<input class="export" id="expshowdeals" type="submit"  value="Export" name="showprofile">
				</span>
				 <script type="text/javascript">
                        $('#exportbtn').html('<input class ="export" type="submit" id="expshowdeals"  value="Export" name="showprofile">');
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

</div>
<!--/form-->
       <script type="text/javascript">
                $("a.postlink").click(function(){
                 
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval); 
                    $("#pesearch").submit();
                    
                    return false;
                    
                });
                   $('#expshowdeals').click(function(){ 
                      	hrefval= 'exportinvestorprofile.php';
						$("#pegetdata").submit();
						return false;
					});
                function resetinput(fieldname)
                {
                 
                //alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val(fieldname));
                  $("#pesearch").submit();
                    return false;
                }
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
 ?>
<SCRIPT>
$(function() {
    $( "#autocomplete" ).autocomplete({
        
      source: function( request, response ) {
        $.ajax({
            type: "POST",
          url: "directoryajax.php",
          dataType: "json",
          data: {
            queryString: request.term,
            dealvalue: <?php echo $dealvalue; ?>
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
                if (item.dealvalue==102){
                    return {
                        label: item.companyname,
                        value: item.companyname,
                         id: item.companyname
                      }
                }else if (item.dealvalue==103 || item.dealvalue==104){
                    return {
                        label: item.advisors,
                        value: item.advisors,
                         id: item.advisors
                      }
                }
              
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#industry').val(ui.item.id);
       //$('#form').submit();
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
<?php mysql_close(); ?>