<?php
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 $searchString="Undisclosed";
 $searchString=strtolower($searchString);
 $searchString1="Unknown";
 $searchString1=strtolower($searchString1);

//Company Sector
$searchString="Undisclosed";
$searchString=strtolower($searchString);

$searchString1="Unknown";
$searchString1=strtolower($searchString1);

$searchString2="Others";
$searchString2=strtolower($searchString2);
$company_cntall=$_POST['totalrecords'];
$companysql=  urldecode($_POST['sql']);
$orderby=$_POST['orderby'];
$ordertype=$_POST['ordertype'];
if($orderby=="DealAmount")
    $orderby="hideamount,DealAmount";
if($companysql!="" && $orderby!="" && $ordertype!="") {
    if($orderby=="sector_business")
        $orderstr="order by ".$orderby." ".$ordertype.","." i.industry ".$ordertype ;
    else
        $orderstr="order by ".$orderby." ".$ordertype;
    $companysql = $companysql . " ". $orderstr ;  
}
if($company_cntall > 0)
{
 $rec_limit = 50;
 $rec_count = $company_cntall;

if( isset($_POST['page']) )
{
   
  $currentpage=$_POST['page']-1;
  $page = $_POST['page']-1;
  $offset = $rec_limit * $page ;
}
else
{
   $currentpage=1;
   $page = 1;
   $offset = 0;
}
 $left_rec = $rec_count - ($page * $rec_limit);
 $companysqlwithlimit=$companysql." limit $offset, $rec_limit";
 if ($companyrs = mysql_query($companysqlwithlimit))
 {
     $company_cnt = mysql_num_rows($companyrs);
 }
             //$searchTitle=" List of Deals";
}
else
{
     $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
     $notable=true;
     writeSql_for_no_records($companysql,$emailid);
}
 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                                <th style="width:755px;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Company</th>
                                <th style="width: 590px;" class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                                <th style="width: 530px;" class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Investor</th>
                                <th style="width: 260px;" style="width: 150px;" class="header <?php echo ($orderby=="DealDate")?$ordertype:""; ?>" id="DealDate">Date</th>
                                <th style="width: 110px;" class="header <?php echo ($orderby=="DealAmount" || $orderby=="hideamount,DealAmount" )?$ordertype:""; ?>" id="DealAmount">Amount</th>
                                <th style="width: 140px;" class="header  <?php echo ($orderby=="ExitStatus")?$ordertype:""; ?>" id="ExitStatus">Exit Status</th>
                                
                                </tr></thead>
                              <tbody id="movies">
						<?php
						if ($company_cnt>0)
						  {
						  	$hidecount=0;
                                                        $icount=0;
                                                          mysql_data_seek($companyrs, 0);
                                                        While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                                             {
                                                                     $prd=$myrow["dealperiod"];
                                                                    if($myrow["SPV"]==1)
                                                                    {
                                                                     $openBracket="(";
                                                                     $closeBracket=")";
                                                                    }
                                                                     else
                                                                     {
                                                                             $openBracket="";
                                                                             $closeBracket="";
                                                                     }

                                                                     if($myrow["DealAmount"]==0)
                                                                     {
                                                                             $hideamount="";
                                                                             $amountobeAdded=0;
                                                                     }
                                                                     elseif($myrow["hideamount"]==1)
                                                                     {
                                                                             $hideamount="";
                                                                             $amountobeAdded=0;

                                                                     }
                                                                     else
                                                                     {
                                                                             $hideamount=$myrow["DealAmount"];
                                                                             $acrossDealsCnt=$acrossDealsCnt+1;
                                                                             $amountobeAdded=$myrow["DealAmount"];
                                                                     }


                                                                     if(trim($myrow["REType"])=="")
                                                                             $showindsec=$myrow["industry"];
                                                                     else
                                                                             $showindsec=$myrow["REType"];
                                                                     
                                                                     
                                                                       if($myrow["ExitStatus"]=="0")
                                                                        {$Exit_Status="Partial Exit"; }
                                                                        elseif($myrow["ExitStatus"]=="1")
                                                                        {$Exit_Status="Complete Exit";}
                                                ?>
                                  
                                                <tr class="details_link" valueId="<?php echo $myrow["MandAId"];?>">
                                
						
                                                                            <td style="width: 755px;"><?php echo $openBracket;?><a class="postlink" href="remandadealdetails.php?value=<?php echo $myrow["MandAId"];?>"><?php echo trim($myrow["companyname"]);?>  </a> <?php echo $closeBracket ; ?></td>

										<td style="width: 595px;"><a class="postlink" href="remandadealdetails.php?value=<?php echo $myrow["MandAId"];?>"> <?php echo trim($showindsec); ?></a></td>
                                                                                <td style="width: 590px;"><a class="postlink" href="remandadealdetails.php?value=<?php echo $myrow["MandAId"];?>"><?php echo $myrow["Investor"]; ?></a></td>
										<td style="width: 260px;"><a class="postlink" href="remandadealdetails.php?value=<?php echo $myrow["MandAId"];?>"><?php echo $prd; ?></a></td>
										<td style="width: 110px;"><a class="postlink" href="remandadealdetails.php?value=<?php echo $myrow["MandAId"];?>"><?php echo $hideamount; ?>&nbsp;</a></td>
										<td style="width: 140px;"><a class="postlink" href="remandadealdetails.php?value=<?php echo $myrow["MandAId"];?>"><?php echo $Exit_Status; ?></a></td>
									</tr>
							<?php
							}
						}
						?>
                        </tbody>
                  </table>
<?php mysql_close(); ?>