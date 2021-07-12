<?php

    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();

    // echo '<pre>'; print_r($_POST); echo '</pre>';

    $search=trim($_REQUEST['search']);
    //echo $search;exit;
    $getCompanySql="SELECT * FROM `pecompanies` where `companyname` like '".$search."%' group by `companyname`";
    $jsonarray=array();

    if ($rsccompany = mysql_query($getCompanySql))
    {
        While($myrow=mysql_fetch_array($rsccompany, MYSQL_BOTH))
        {
            // echo '<pre>'; print_r($myrow); echo '</pre>'; exit;

            $companyId=$myrow["PECompanyId"];

            $companyName=trim($myrow["companyname"]);
            $companyNamelower=$companyName;

            $industry           =   $myrow["industry"];
            $city               =   $myrow["city"];
            $state              =   $myrow["state"];
            $stateid            =   $myrow["stateid"];
            $RegionId           =   $myrow["RegionId"];
            $sector_business    =   $myrow["sector_business"];
            $website    =   $myrow["website"];

            $jsonarray[]=array('id'=>$companyId,'label'=>$companyName,'value'=>$companyNamelower,'industry'=>$industry,'city'=>$city, 'state'=>$state, 'stateid'=>$stateid, 'RegionId' =>$RegionId, 'sector_business' =>$sector_business, 'website' => $website);
        }
    }
    
    echo json_encode($jsonarray);
            
               
?>