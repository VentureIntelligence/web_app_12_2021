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
/*if($orderby=="Amount")
    $orderby="hideamount,amount";*/
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
        <thead>
                <tr>
                        <th style="width: 700px;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Target</th>
                        <th style="width: 500px;" class="header <?php echo ($orderby=="Acquirer")?$ordertype:""; ?>" id="Acquirer">Acquirer</th>
                        <th style="width: 300px;" class="header <?php echo ($orderby=="DealDate")?$ordertype:""; ?>" id="DealDate">Date</th>
                        <th style="width: 228px;" class="header <?php echo ($orderby=="Amount")?$ordertype:""; ?>" id="Amount">Amount (US$M)</th>
                </tr>
        </thead>
        <tbody id="movies">
                <?php
                if ($company_cnt>0)
                {


                        $acrossDealsCnt=0;
                                mysql_data_seek($companyrs, 0);
                        While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                        {
                                $searchString4="PE Firm(s)";
                                $searchString4=strtolower($searchString4);
                                $searchString4ForDisplay="PE Firm(s)";
                                $searchString="Undisclosed";
                                $searchString=strtolower($searchString);
                                $companyName=trim($myrow["companyname"]);
                                $companyName=strtolower($companyName);
                                $compResult=substr_count($companyName,$searchString);
                                $compResult4=substr_count($companyName,$searchString4);

                                $acquirerName=$myrow["Acquirer"];
                                $acquirerName=strtolower($acquirerName);

                                $compResultAcquirer=substr_count($acquirerName,$searchString4);
                                $compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);

                                if($compResult==0)
                                        $displaycomp=$myrow["companyname"];
                                elseif($compResult4==1)
                                        $displaycomp=ucfirst("$searchString4");
                                elseif($compResult==1)
                                        $displaycomp=ucfirst("$searchString");

                                if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0))
                                        $displayAcquirer=$myrow["Acquirer"];
                                elseif($compResultAcquirer==1)
                                        $displayAcquirer=ucfirst("$searchString4ForDisplay");
                                elseif($compResultAcquirerUndisclosed==1)
                                        $displayAcquirer=ucfirst("$searchString");;

                                if($myrow["Asset"]==1)
                                {
                                        $openBracket="(";
                                        $closeBracket=")";
                                }
                                else
                                {
                                        $openBracket="";
                                        $closeBracket="";
                                }
                                if($myrow["DealDate"]!="")
                                {
                                        $displaydate=$myrow["dealperiod"];
                                }
                                else
                                {
                                        $displaydate=="--";
                                }
                                if($myrow["Amount"]==0)
                                {
                                        $hideamount="";
                                }
                                else
                                {
                                        $hideamount=$myrow["Amount"];
                                        $acrossDealsCnt=$acrossDealsCnt+1;
                                }
                                if(trim($myrow["sector_business"])=="")
                                        $showindsec=$myrow["industry"];
                                else
                                        $showindsec=$myrow["sector_business"];

                ?>

                <tr class="details_link" valueId="<?php echo $myrow["MAMAId"];;?>">

                <?php
                                //Session Variable for storing Id. To be used in Previous / Next Buttons
                ?>
                                <td style="width: 700px;"><?php echo $openBracket;?><a class="postlink" href="remadealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaycomp; ?> </a> <?php echo $closeBracket ; ?></td>
                                <td style="width: 500px;"><a class="postlink" href="remadealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displayAcquirer; ?></a></td>
                                <td style="width: 300px;"><a class="postlink" href="remadealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaydate; ?></a></td>
                                <td style="width: 228px;"><a class="postlink" href="remadealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $hideamount; ?>&nbsp;</a></td>
                </tr>
                        <?php
                        }
                }
                ?>
        </tbody>
        </table>
<?php mysql_close(); ?>