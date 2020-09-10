<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();

$report_cntall = $_POST['totalrecords'];
$reportsql = urldecode($_POST['sql']);

if ($report_cntall > 0) {
    $rec_limit = 50;
    $rec_count = $report_cntall;

    if (isset($_POST['page'])) {

        $currentpage = $_POST['page'] - 1;
        $page = $_POST['page'] - 1;
        $offset = $rec_limit * $page;
    } else {
        $currentpage = 1;
        $page = 1;
        $offset = 0;
    }
    $left_rec = $rec_count - ($page * $rec_limit);
    $reportsqlwithlimit = $reportsql . " limit $offset, $rec_limit";
// echo $reportsqlwithlimit;
    if ($reportrs = mysql_query($reportsqlwithlimit)) {
        $report_cnt = mysql_num_rows($reportrs);
    }
    //$searchTitle=" List of Deals";
} else {
    $searchTitle = $searchTitle . " -- No Deal(s) found for this search ";
    $notable = true;
    writeSql_for_no_records($companysql, $emailid);
}
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
    <thead><tr>

            <th>Investor </th>
            <th>No.of Deals</th>   
            <th>No.of Cos</th>
        </tr></thead>
    <tbody id="movies">
<?php
if ($report_cnt > 0) {
    $hidecount = 0;
    //Code to add PREV /NEXT
    mysql_data_seek($reportrs, 0);
    While ($myrow = mysql_fetch_array($reportrs, MYSQL_BOTH)) {
        ?>           <tr>

                    <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["id"];?>/<?php echo $_POST['vcflagvalue'];?>/<?php echo $_POST['dealshow'];?> " ><?php echo $myrow["investor"]; ?></a></td>
                    <td><?php echo $myrow["deals"]; ?></td>
                    <td><?php echo $myrow["cos"]; ?></td>
                </tr>
                <?php
            }
        }
        else{ ?>
                                                        
            <tr><td >No Result Found</td></tr>
        <?php }
        ?>
    </tbody>
</table>
<?php
mysql_close();
    mysql_close($cnx);
    ?>

