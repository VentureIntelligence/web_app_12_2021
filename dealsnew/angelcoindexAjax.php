<?php
$vcflagValue = 2;
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$videalPageName = "AngelCoInv";
include ('checklogin.php');
$topNav = 'Deals';


$limit =($_POST['page']*50)-50;


$orderbyfield =$_POST['orderby'];

$ordertype =$_POST['ordertype'];

$sql = $_POST['sql'];



if($orderbyfield==''){
    $orderbyfield = ' a.company_name';
}

$query1 = $sql;
$totalAngelCo = mysql_query($query1);



$orderby = 'ORDER BY '. $orderbyfield .' ' . $ordertype ;
$query2 = $sql;


$angelquery  = $query2 . $orderby."  LIMIT $limit, 50";

$angelco = mysql_query($angelquery);


function moneyFormatIndia($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                            <thead><tr>
                                    <th class="header <?php echo ($orderbyfield == "company_name") ? $ordertype : ""; ?>"  id="company_name">Company Name</th>
                                    <th class="header <?php echo ($orderbyfield == "raising_amount") ? $ordertype : ""; ?>" id="raising_amount">Raising Amount(US $)</th>
                                    <th  class="header <?php echo ($orderbyfield == "location") ? $ordertype : ""; ?>" id="location">Location</th>
                                    <th class="header" style="width: 250px; background: none"   id="high_concept">Description</th>
                                    <th class="header" style="width: 150px; background: none" id="website">Website</th>

                                </tr></thead>
                            <tbody id="movies">
                                
                                <?php
                                while ($co = mysql_fetch_array($angelco)) {
                                    
                                    if($co['PECompanyId']!='' && $co['PECompanyId']>0){
                                        $data = "value=".$co['PECompanyId']."/$vcflagValue&raisingcomp"; 
                                    }
                                    elseif($co['angel_id']!='' && $co['angel_id']>0){
                                        $data = "value=".$co['angel_id']."/$vcflagValue&angelco_only&raisingcomp"; 
                                    }
                                  ?>
                                <tr  class="details_link" valueid="<?php echo $data?>" >
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data;?>" style="text-decoration: none"> <?php echo $co['company_name'] ?> </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data;?>" style="text-decoration: none"> <?php echo number_format($co['raising_amount']) ?> </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data;?>" style="text-decoration: none"> <?php echo $co['location'] ?>  </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data;?>" style="text-decoration: none"> <?php echo $co['high_concept'] ?>  </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data;?>" style="text-decoration: none"> <?php echo $co['company_url'] ?>  </a></td>
                                </tr>    
                                <?php 
                                }
                                
                                ?>

                            </tbody>
                        </table>

<?php
mysql_close();
    mysql_close($cnx);
    ?>
                  			


              