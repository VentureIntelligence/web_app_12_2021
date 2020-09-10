<?php
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
$company_cntall=$_POST['totalrecords'];
 $companysql=  urldecode(stripslashes($_POST['sql']));
$vcflagValue=$_POST['vcflagvalue'];
 $orderby=$_POST['orderby'];
$ordertype=$_POST['ordertype'];
$year=$_POST['dateYear'];
$usrRgsPEInv=$_POST['usrRgsPEInv'];
$usrRgsVCInv=$_POST['usrRgsVCInv'];

/*if($companysql!="" && $orderby!="" && $ordertype!="") {
        $orderstr="order by ".$orderby." ".$ordertype;
    $companysql = $companysql . " ". $orderstr ;  
}*/
if($companysql!="" && $orderby!="" && $ordertype!="") {
        $orderstr="order by ".$orderby." ".$ordertype;
    $companysql = $companysql . " ". $orderstr ;  
}
else
{
  $orderstr="order by deals desc";
    $companysql = $companysql . " ". $orderstr ;  
}

//echo $companysql;
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

 if ($reportrs = mysql_query($companysqlwithlimit))
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
<?php 
if(($vcflagValue==3)|| ($vcflagValue==4)|| ($vcflagValue==5)){
    $redirecturl="svindex.php";
}
else if($vcflagValue==2){
    $redirecturl="angelindex.php";
}else
{
    $redirecturl="index.php";
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                                                <thead><tr>


                                                        <th class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Investor </th>
                                                        <th class="header <?php echo ($orderby=="deals")?$ordertype:""; ?>" id="deals">No.of Deals</th>
                                                        <th class="header <?php echo ($orderby=="cos")?$ordertype:""; ?>" id="cos">No.of Cos</th>
                                                        <?php if($vcflagValue!=2){?><th class="header <?php echo ($orderby=="newPCos")?$ordertype:""; ?>" id="newPCos">New Portfolio Cos</th>  <?php }?> 

                                                    </tr></thead>

                                                <tbody id="movies">
                                                    <?php
                                                    if ($report_cnt > 0) {
                                                        $hidecount = 0;
                                                        //Code to add PREV /NEXT
                                                        mysql_data_seek($reportrs, 0);
                                                        While ($myrow = mysql_fetch_array($reportrs, MYSQL_BOTH)) {
                                                            ?>           
                                                            <?php if($usrRgsPEInv == 0 || $usrRgsVCInv == 0) { ?>
                                                                 <tr>

                                                                    <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["id"];?>/<?php echo $vcflagValue;?>/<?php echo $dealshow;?> " ><?php echo $myrow["investor"]; ?></a></td>
                                                                   <td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a></td>
                                                                    <td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a></td>
                                                                    <?php if($vcflagValue!=2){?><td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["newPCos"]; ?></a></td><?php }?> 
                                                                </tr>
                                                            <?php } else { ?>
                                                                 <tr>

                                                                    <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["id"];?>/<?php echo $vcflagValue;?>/<?php echo $dealshow;?> " ><?php echo $myrow["investor"]; ?></a></td>
                                                                  <!--  <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a></td>
                                                                    <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a></td>
                                                                    <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>&newCos=<?php echo $view_table; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["newPCos"]; ?></a></td> -->
                                                                    <td style="padding-left:5%">
                                                                        
                                                                        <a class="postlink" href="<?php echo $redirecturl;?>?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a>
                                                                        
                                                                    </td>
                                                                    <td style="padding-left:5%">
                                                                        
                                                                        <a class="postlink" href="<?php echo $redirecturl;?>?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a>
                                                                       
                                                                    </td>
                                                                  <?php if($vcflagValue!=2){?>  
                                                                    <td style="padding-left:5%">
                                                                        
                                                                        <a class="postlink" href="<?php echo $redirecturl;?>?value=<?php echo $vcflagValue; ?>&newCos=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["newPCos"]; ?></a>
                                                                       
                                                                    </td>
                                                                <?php }?>
                                                                </tr>
                                                            <?php } ?>  
                                                            <?php
                                                        }
                                                    }
                                                    else{ ?>
                                                        
                                                        <tr><td >No Result Found</td></tr>
                                                    <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <script type="text/javascript">
                                    var orderby = '<?php echo $orderby; ?>';
                                    var ordertype = '<?php echo $ordertype; ?>';
                                  
                                    $(".header").live("click", function() {
                                        var orderby = $(this).attr('id');

                                        if ($(this).hasClass("desc")){
                                            ordertype = "asc";
                                        }else{
                                            if(!$(this).hasClass("desc") && !$(this).hasClass("asc") && orderby== 'investor'){
                                                ordertype = "asc";
                                            }else{
                                                ordertype = "desc";
                                            }
                                        }
                                        loadhtml(1, orderby, ordertype);
                                        return  false;
                                    });

                                  </script>