<?php
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 include ('checklogin.php');
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
$ordertype=$_POST['ordertype'];

if($companysql!="" && $orderby!="" && $ordertype!="") {
    if($orderby=="Investor")
    {
        $orderstr="order by re.".$orderby." ".$ordertype ;
    }
    elseif($orderby=="fundName" || $orderby=="fundDate"){
        $orderstr="order by fd.".$orderby." ".$ordertype ;
    }
    else{
        $orderstr="order by fd.".$orderby." ".$ordertype ;
    }
    $companysql = $companysql . " ". $orderstr ;  
}

if($company_cntall > 0)
{
    $rec_limit = 20;
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
            <th style="width: 253px;" style="border-top: 1px solid #999;">Type</th>
            <th style="width: 230px;" style="border-top: 1px solid #999;"> Size (US$M)</th>
            <th style="width: 236px;" style="border-top: 1px solid #999;">Status</th>
            <th style="width: 238px;" style="border-top: 1px solid #999;">Capital Source</th>
            <th style="width: 241px;" class="header <?php echo ($orderby=="fundDate")?$ordertype:""; ?>" id="fundDate">Date</th>
        </tr>
    </thead>
    <tbody id="movies">
<?php
if ($company_cnt > 0)
  {
    $ah=1;
        $hidecount=0; 
        mysql_data_seek($companyrs,0);

        //Code to add PREV /NEXT
        While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
        {
            $VCFlagValue='funds';
            $dealuv=0;
            
            
        ?>
                <tr class="details_link" valueId="<?php echo $myrow["InvestorId"];?>/<?php echo $VCFlagValue;?>/<?php echo $dealuv;?>">
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php if($myrow["Investor"]){ echo $myrow["Investor"]; } else { echo $myrow["fundManager"];  }?></a> </td>
                        <!--td style="width: 300px;"><a class="postlink" href="" ><?php echo $myrow["fundManager"];?></a></td-->
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["fundName"];?></a></td>
                        
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>"  >  <?php $name = $myrow["sector"];  $name=($name!="")?$name:"Other";  echo $name ; ?>  </a></td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["size"];?></a></td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo ($myrow["fundStatus"]=="Closed") ? $myrow["closeStatus"] : $myrow["fundStatus"];?> </a>    </td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>"  ><?php echo $myrow["source"];?></a></td>
                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["fundDate"];?></a></td>

                </tr>
                <?php
                $ah++;
        }
    }

?>
        </tbody>
</table>
<?php mysql_close(); ?>