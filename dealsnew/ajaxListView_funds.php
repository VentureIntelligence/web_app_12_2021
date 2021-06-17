<?php
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();

$company_cntall=$_POST['totalrecords'];
$companysql=  urldecode($_POST['sql']);
$orderby=$_POST['orderby'];

if($orderby=="Investor")
{
    $orderby="Investor";
}
else if($orderby=="fundName")
{
    $orderby="fundName";
}
else if($orderby=="fundDate")
{
    $orderby="fundDate";
}
else if($orderby=="industry")
{
    $orderby="industry";
}
else if($orderby=="size")
{
    $orderby="size";
}
else if($orderby=="fundStatus")
{
    $orderby="fundStatus";
}
else if($orderby=="source")
{
    $orderby="source";
}
else if( $orderby == "amount_raised" ) {
    $orderby = "amount_raised";
}

$ordertype=$_POST['ordertype'];

if($companysql!="" && $orderby!="" && $ordertype!="") {
    if($orderby=="Investor")
    {
        $orderstr="order by pi.".$orderby." ".$ordertype ;
    }
    elseif($orderby=="fundName" || $orderby=="fundDate" || $orderby=="size"){
        $orderstr="order by fd.".$orderby." ".$ordertype ;
    }
    elseif($orderby=="fundStatus") {
        $orderstr="order by frs.".$orderby." ".$ordertype ;
    }
    elseif($orderby=="source") {
        $orderstr="order by fcs.".$orderby." ".$ordertype ;
    }
    elseif( $orderby=="industry" ) {
        $orderstr="order by fts.fundTypeName ".$ordertype.", fti.fundTypeName ".$ordertype;
    }
    else{
        $orderstr="order by fd.".$orderby." ".$ordertype ;
    }
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
    $companysqlwithlimit = $companysql." limit $offset, $rec_limit";
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
         <tr>
            
            <th style="width: 242px;" class="header <?php echo ($orderby=="Investor")?$ordertype:""; ?>" id="Investor">Investor Name</th>
            <!--th style="width: 300px;" style="border-top: 1px solid #999;">Manager</th-->
            <th style="width: 248px;" class="header <?php echo ($orderby=="fundName")?$ordertype:""; ?>" id="fundName">Fund Name</th>
            <th style="width: 253px;" class="header <?php echo ($orderby=="industry")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="industry">Type</th>
            <th style="width: 230px;" class="header <?php echo ($orderby=="size")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="size">Size</th>
            <th style="width: 230px;" class="header <?php echo ($orderby=="amount_raised")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="amount_raised">Amount raised ($USM)</th>
            <th style="width: 236px;" class="header <?php echo ($orderby=="fundStatus")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="fundStatus">Status</th>
            <th style="width: 238px;" class="header <?php echo ($orderby=="source")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="source">Capital Source</th>
            <th style="width: 241px;" class="header <?php echo ($orderby=="fundDate")?$ordertype:""; ?>" id="fundDate">Date</th>
        </tr>
    </thead>
    <tbody id="movies">
<?php
if ($company_cnt > 0)
  {
        $hidecount=0; 
        mysql_data_seek($companyrs,0);
        $ah=1;
        //Code to add PREV /NEXT
        While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
        {
            $VCFlagValue='funds';
            $dealuv=0;
            $in_ve_id = $myrow["InvestorId"]; 
        ?>
                <tr class="details_link" valueId="<?php echo $myrow["InvestorId"];?>/<?php echo $VCFlagValue;?>/<?php echo $dealuv;?>">
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>"><?php echo $myrow["Investor"];?></a> </td>
                        <!--td style="width: 300px;"><a class="postlink" href="" ><?php echo $myrow["fundManager"];?></a></td-->
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["fundName"];?></a></td>
                        <td style="width: 300px;"><a class="postlink" href="investordetails.php?value=<?php echo $myrow["InvestorId"]."/".$VCFlagValue."/".$dealuv;?>" > <?php if($myrow["stage"]!=""){ ?><span class="fund-badge"><?php echo $myrow["stage"]?></span> <?php } ?> <?php echo $myrow["industry"];?></a></td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["size"];?></a></td>
                        <td style="width: 300px; text-align: right;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo ($myrow["amount_raised"]!=0) ? $myrow["amount_raised"] : "-";?></a></td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["closeStatus"];?></a></td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["source"];?></a></td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["fundDate"];?></a></td>

                </tr>
                <?php
                $ah++;
        }
    }

?>
        </tbody>
</table>



<?php
mysql_close();
    mysql_close($cnx);
    ?>

