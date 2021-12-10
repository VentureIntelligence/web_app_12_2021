<?php

 require_once("dbconnectvi.php");
 $Db = new dbInvestments();
 
$sqlquery=  urldecode(stripslashes($_POST['sql']));

$orderby=$_POST['orderby'];
$ordertype=$_POST['ordertype'];

?>
  <?php $unicornmediapath=BASE_URL.'adminvi/importfiles/Unicorntable.xlsx';?>
 <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;width:100%;" id="myTable">
             <thead>
               <tr class="unicornhead">
                 <th class="unicorn-space headerval <?php echo ($orderby == "id") ? $ordertype : ""; ?>" id="id" >No</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "company") ? $ordertype : ""; ?>" id="company" style = "width: 13%;">Company</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "sector") ? $ordertype : ""; ?>" id="sector" >Sector</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "entryvaluation") ? $ordertype : ""; ?>" id="entryvaluation" style = "width: 20%;">Entry Valuation^^ ($B)</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "valuation") ? $ordertype : ""; ?>" id="valuation" style = "width: 18%;">Valuation ($B)</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "entry") ? $ordertype : ""; ?>" id="entry" style= "width: 10%;">Entry</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "location") ? $ordertype : ""; ?>" id="location" >Location</th>
                 <th class="unicorn-space  <?php echo ($orderby == "selectInvestor") ? $ordertype : ""; ?>" id="selectInvestor" style= "width: 25%;">Select Investors  <a  href=" <?php echo $unicornmediapath;?>" class="tooltip4" style="color:#fff;float:right;padding-left: 10px;"><i class="fa fa-download" aria-hidden="true"></i><span class=" " >
                   
                    <strong>Download</strong>
                    </span></a></th>
               </tr>
             </thead>
             <?php 
                    $sqlquery=$sqlquery.$orderby.$ordertype;
                 
                    $result=mysql_query($sqlquery);
                    
                    while($row=mysql_fetch_array($result))
                    {

                      // echo '<pre>'; print_r($row); echo '</pre>';

             ?>
             <tr class="unicorndata">
                <td><?php echo $row[0];?></td>
               <td class="unicorn-space"><?php echo $row[1];?></td>
               <td class="unicorn-space" style= "width: 20%;"><?php echo $row[2];?></td>
               <td class="valuation "><?php echo $row[3];?></td>
               <td class="valuation "><?php echo $row[4];?></td>
               <td><?php $newphrase = str_replace('/', '-', $row[5]);
               echo $newphrase; ?></td>
               <td class="unicorn-space"><?php echo $row[6];?></td>
               <td style= "line-height:1.2"> <?php echo $row[7];?></td>


             </tr>
           <?php } ?>
           <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <!-- <td style="text-align: right;padding-top: 20px;">* Former Unicorns</td> -->
           </tr>
           </table> 

    <?php

                        mysql_close();
    mysql_close($cnx);
                        ?>
                    