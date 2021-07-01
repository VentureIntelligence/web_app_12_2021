<?php

    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();

    // echo '<pre>'; print_r($_POST); echo '</pre>';

    $search=trim($_REQUEST['search']);
    //echo $search;exit;
    $getCompanySql="SELECT * FROM `acquirers` where `Acquirer` like '".$search."%' group by `Acquirer`";
    $jsonarray=array();

    if ($rsccompany = mysql_query($getCompanySql))
    {
        While($myrow=mysql_fetch_array($rsccompany, MYSQL_BOTH))
        {
            // echo '<pre>'; print_r($myrow); echo '</pre>'; exit;

            $acquirerId = $myrow["AcquirerId"];

            $Acquirer=trim($myrow["Acquirer"]);
            $Acquirerlower=$Acquirer;

            $industry           =   $myrow["IndustryId"];
            $city               =   $myrow["CityId"];

            $jsonarray[]=array('id'=>$acquirerId,'label'=>$Acquirer,'value'=>$Acquirerlower,'industry'=>$industry,'city'=>$city);
        }
    }
    echo json_encode($jsonarray);
            
               
?>