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
$report_cntall=$_POST['totalrecords'];
$reportsql=  urldecode($_POST['sql']);
$orderby=$_POST['orderby'];
$ordertype=$_POST['ordertype'];

if($reportsql!="" && $orderby!="" && $ordertype!="") {
    if($orderby=="title")
    {
        $orderstr="order by titleofReport ".$ordertype."" ;
    }
    else if($orderby=="type")
    {
         $orderstr="order by typeofReport ".$ordertype."" ;
    }
    else if($orderby=="period")
    {
        $orderstr="order by periodofReport ".$ordertype."" ;
    }
    else
    {
        $orderstr="order by ".$orderby." ".$ordertype;
    }
   $reportsql = $reportsql . " ". $orderstr ;  
}
if($report_cntall > 0)
{
 $rec_limit = 20;
 $rec_count = $report_cntall;

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
 $reportsqlwithlimit=$reportsql." limit $offset, $rec_limit";
// echo $reportsqlwithlimit;
 if ($reportrs = mysql_query($reportsqlwithlimit))
 {
     $report_cnt = mysql_num_rows($reportrs);
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
<!--                                <th class="header <?php echo ($orderby=="title")?$ordertype:""; ?>" id="title" >Title </th>
                                <th class="header <?php echo ($orderby=="type")?$ordertype:""; ?>" id="type" >Type</th>
                                <th class="header <?php echo ($orderby=="period")?$ordertype:""; ?>" id="period">Period</th>
                                 <th class="header <?php echo ($orderby=="date")?$ordertype:""; ?>" id="date">Date</th>-->
                                      
                                <th>Title </th>
                                <th>Type</th>
                                <th>Period</th>
                                <th>Date</th>      
                                                </tr></thead>
                               <tbody id="movies">
                     <?php
                     
                        if ($report_cnt>0)
                          {
                                $hidecount=0;
                                //Code to add PREV /NEXT
                                mysql_data_seek($reportrs,0);
                                While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                                {
                           ?>           <tr>
                               
                                            <td ><a class="postlink" href="report_details.php?id=<?php echo $myrow["id"]; ?>" target="_blank"><?php echo trim($myrow["titleofReport"]);?> </a></td>
                                            <td><?php echo $myrow["typeofReport"];?></td>
                                            <td><?php echo str_replace('_', ' ', $myrow["periodofReport"]); ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($myrow["date"])); ?> </td>
                                                        </tr>
                                        <?php
                                        }
                        }
                        ?>
        </tbody>
                  </table>
<?php
mysql_close();
    mysql_close($cnx);
    ?>
