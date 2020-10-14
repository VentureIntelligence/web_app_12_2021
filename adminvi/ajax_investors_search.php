<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $search=$searchval=trim($_REQUEST['search']);
    $req = $_REQUEST['opt'];
    $dbtype = $_REQUEST['dbtype'];
    $exist = $_REQUEST['type'];
    $investorId = $_REQUEST['investor'];
    $investorval = $_REQUEST['investorval'];
    if ($dbtype=='PE') {
        if ($req=="investor"){
                $search="'$search%'";
                if($investorval!=""){
                    $getinvestors="SELECT inv.InvestorId as id, inv.Investor as name , fn.fundId as fundId, fn.fundname as fundName FROM `peinvestors` as inv INNER JOIN fundNames as fn on inv.InvestorId = fn.InvestorId where inv.Investor ='$investorval' and fn.fundname like $search";
                    
                }else{
                    $getinvestors="SELECT inv.InvestorId as id, inv.Investor as name , fn.fundId as fundId, fn.fundname as fundName FROM `peinvestors` as inv INNER JOIN fundNames as fn on inv.InvestorId = fn.InvestorId where inv.Investor like $search group by inv.Investor";
                }
                
                $jsonarray=array();
                if ($rssearch = mysql_query($getinvestors))
                {
                   
                    While($myrow=mysql_fetch_array($rssearch, MYSQL_BOTH))
                    {
                        $investorId=$myrow["id"];
                        $investorName=trim($myrow["name"]);
                        $fundName=trim($myrow["fundName"]);
                        $fundId=trim($myrow["fundId"]);
                        $jsonarray[]=array('id'=>$investorId,'label'=>$investorName,'value'=>$investorName,'fundId'=>$fundId,'fundName'=>$fundName);
                    }
                
                }
                echo json_encode($jsonarray);        
                mysql_close();   
        }        
    }
?>
