<?php

 require_once("dbconnectvi.php");
 $Db = new dbInvestments();
 
$sqlquery=  urldecode(stripslashes($_POST['sql']));

$orderby=$_POST['orderby'];
$ordertype=$_POST['ordertype'];

?>
 <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;width:100%;" id="myTable">
             <thead>
               <tr class="unicornhead">
                 <th class="unicorn-space headerval <?php echo ($orderby == "id") ? $ordertype : ""; ?>" id="id" >No</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "company") ? $ordertype : ""; ?>" id="company" >Company</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "sector") ? $ordertype : ""; ?>" id="sector" >Sector</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "valuation") ? $ordertype : ""; ?>" id="valuation" >Valuation ($B)</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "entry") ? $ordertype : ""; ?>" id="entry" >Entry</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "location") ? $ordertype : ""; ?>" id="location" >Location</th>
                 <th class="unicorn-space  <?php echo ($orderby == "selectInvestor") ? $ordertype : ""; ?>" id="selectInvestor" >Select Investors  <a  href=" <?php echo $unicornmediapath;?>" class="tooltip4" style="color:#fff;float:right;padding-left: 10px;"><i class="fa fa-download" aria-hidden="true"></i><span class=" " >
                   
                    <strong>Download</strong>
                    </span></a></th>
               </tr>
             </thead>
             <?php 
                    $sqlquery=$sqlquery.$orderby.$ordertype;
                 
                    $result=mysql_query($sqlquery);
                    
                    while($row=mysql_fetch_array($result))
                    {

             ?>
             <tr class="unicorndata">
               <td><?php echo $row[0];?></td>
               <td class="unicorn-space"><?php echo $row[1];?></td>
               <td class="unicorn-space"><?php echo $row[2];?></td>
               <td class="valuation "><?php echo $row[3];?></td>
               <td><?php echo $row[4];?></td>
               <td class="unicorn-space"><?php echo $row[5];?></td>
               <td><?php echo $row[6];?></td>

             </tr>
           <?php } ?>
           <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td style="text-align: right;
    padding-top: 20px;">* Former Unicorns</td>
           </tr>
           </table> 

    <?php

                        mysql_close();
    mysql_close($cnx);
                        ?>
                    