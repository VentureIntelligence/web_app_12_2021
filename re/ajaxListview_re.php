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
if($orderby=="amount")
    $orderby="hideamount,amount";
if($companysql!="" && $orderby!="" && $ordertype!="") {
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
                                <th style="width: 40%;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Company</th>
                                <th style="width: 10%;" class="header <?php echo ($orderby=="dealcity")?$ordertype:""; ?>" id="dealcity">City</th>
                                <th style="width: 20%;" class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Investor</th>
                                <th style="width: 10%;" class="header <?php echo ($orderby=="dates")?$ordertype:""; ?>" id="dates">Date</th>
                                 <th style="width: 10%;" class="header <?php echo ($orderby=="Exit_Status")?$ordertype:""; ?>" id="Exit_Status">Exit Status</th>
                                <th style="width: 10%;" class="header <?php echo ($orderby=="amount"  ||$orderby=="hideamount,amount")?$ordertype:""; ?>" id="amount">Amount (US$M)</th>
                                </tr></thead>
                              <tbody id="movies">
						<?php
						if ($company_cnt>0)
						  {
						  	$hidecount=0;
						  	$acrossDealsCnt=0;
                                                         mysql_data_seek($companyrs,0);
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
                                                                $amtTobeDeductedforAggHide=0;
                                                                $prd=$myrow["dealperiod"];
                                                                
                                                                 if($myrow["AggHide"]==1)
								{
                                                                        $openaggBracket="{";
									$closeaggBracket="}";
									$amtTobeDeductedforAggHide=$myrow["amount"];
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
                                                                       $openaggBracket="";
									$closeaggBracket="";
									$amtTobeDeductedforAggHide=0;
									$NoofDealsCntTobeDeducted=0;
								}
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

								if(trim($myrow[17])=="")
								{
									$compDisplayOboldTag="";
									$compDisplayEboldTag="";
								}
								else
								{
									$compDisplayOboldTag="<b><i>";
									$compDisplayEboldTag="</b></i>";
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="--";
									$hidecount=$hidecount+1;
								}
								else
								{
									$hideamount=$myrow["amount"];
								}
								if($myrow["REType"]!="")
								{
									$showindsec=$myrow["REType"];
								}
								else
								{
									$showindsec="&nbsp;";
								}

								$companyName=trim($myrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);

								if($myrow["amount"]==0)
								{
									$hideamount="";
									$amountobeAdded=0;
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="";
									$amountobeAdded=0;

								}
								elseif($myrow["hideamount"]==0)
								{
									$hideamount=$myrow["amount"];
                                                                        $acrossDealsCnt=$acrossDealsCnt+1;
									$amountobeAdded=$myrow["amount"];
								}
                                                                
                                                                
                                                                    if($myrow["Exit_Status"]==1){
                                                                        $exitstatus_name = 'Unexited';
                                                                    }
                                                                    else if($myrow["Exit_Status"]==2){
                                                                         $exitstatus_name = 'Partially Exited';
                                                                    }
                                                                    else if($myrow["Exit_Status"]==3){
                                                                         $exitstatus_name = 'Fully Exited';
                                                                    }
                                                                    else{
                                                                         $exitstatus_name = '--';
                                                                    }
                                                ?>
                                  
                                                <tr class="details_link" valueId="<?php echo $myrow["PEId"];?>">
                                
						<?php
								if(($compResult==0) && ($compResult1==0))
								{
						?>
                                                                            <td style="width: 1090px;"><?php echo $openBracket;?><?php echo $openaggBracket; ?><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"];?>"><?php echo trim($myrow["companyname"]);?>  </a> <?php echo $closeaggBracket; ?><?php echo $closeBracket ; ?></td>
						<?php
								}
								else
								{
						?>
								<td style="width: 1090px;"><?php echo ucfirst("$searchString");?></td>
						<?php
								}
						?>

										<td style="width: 245px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"];?>"><?php echo $myrow["dealcity"]; ?></a></td>
                                                                                <td style="width: 540px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"];?>"><?php echo $myrow["Investor"]; ?></a></td>
										<td style="width: 210px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"];?>"><?php echo $prd; ?></a></td>
										<td style="width: 182px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"];?>"><?php echo $exitstatus_name; ?></a></td>
										<td style="width: 182px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"];?>"><?php echo $hideamount; ?>&nbsp;</a></td>
										
						
                                                </tr>
							<?php

							}
						}
						?>
                        </tbody>
                  </table>
<?php mysql_close(); ?>