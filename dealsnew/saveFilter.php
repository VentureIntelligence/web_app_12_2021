<?php include_once("../globalconfig.php"); ?>

<?php

session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();
$dlogUserEmail = $_SESSION['UserEmail'];
//echo $dlogUserEmail;exit();
    if($_POST['mode'] == 'saveFilter')
    {
        $sql="SELECT `filter_name` FROM `saved_filter` GROUP BY `filter_name`";
        //echo $sql;exit();
        $sqlSelResult = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($sqlSelResult)) {

            $InvestorId .= $row['filter_name'] ."," ;
        }
        
        echo rtrim($InvestorId,',');
    }
  else if($_POST['mode'] == 'A')
    {
    $investorval = json_decode(stripslashes($_POST['investorval']));

    $filtername = $_POST['filtername'];
    $EditFilter=$_POST['EditFilter'];
    //echo $EditFilter;exit();
    $filterDesc=$_POST['filterDesc'];
    $checkboxName=$_POST['checkboxName'];

    $dlogUserEmail = 'vijayakumar.k@praniontech.com';
    $investorvalArray = implode (",", $investorval);  

    $sqlSelCount = "SELECT *  FROM `saved_filter` WHERE `filter_name` = '" . $EditFilter . "' ";
    //echo $sqlSelCount;exit();
    $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
    $rowSelCount = mysql_num_rows($sqlSelResult);
        //echo $rowSelCount;exit();
    if($rowSelCount > 0)
    {
        $query = "UPDATE `saved_filter` SET `filter_name`='".$filtername."',`filter_desc`='".$filterDesc."',`investor_name`='" . $investorvalArray . "',`column_name`='" . $checkboxName . "',`modefied_by`='" . $dlogUserEmail . "',`modefied_on`=CURDATE() WHERE `filter_name` = '" . $EditFilter . "' ";
       // echo $filtername;
    }
    else
    {
        $query = "INSERT INTO `saved_filter`(`id`, `investor_name`, `column_name`, `filter_name`,`filter_desc`,`created_by`, `created_on`) VALUES (default,'".$investorvalArray."','".$checkboxName."','".$filtername."','".$filterDesc."','".$dlogUserEmail."',CURDATE())";
 
    }
    //echo "query = $query";exit(); // for debugging purposes, remove this once it is working
    mysql_query($query) or die(mysql_error());

   

    }
    else if($_POST['mode'] == 'D')
    {
        $filtername = $_POST['filterName'];

        $sql="Delete from saved_filter where  filter_name='$filtername'";

        mysql_query($sql) or die(mysql_error());

        
    }

    else if($_POST['mode'] == 'E')
    {
        $filtername = $_POST['filterName'];
        $sql="SELECT `investor_name` FROM `saved_filter` where filter_name='".$filtername."' ";
        $sqlSelResult = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($sqlSelResult)) {

            $investor_id= $row['investor_name']  ;
           
        }
        $inv_investor_id=explode(',',$investor_id);
    
        $returndata=array();
        $InvestorArray=array();
        if(isset($inv_investor_id))
        {
            $sqlquery='SELECT * FROM `peinvestors`,`saved_filter` WHERE `Investor` IN ("'. implode('","', $inv_investor_id) .'") and filter_name="'. $filtername.'"';
           // echo $sqlquery;exit();
                                $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());

                            while ($row = mysql_fetch_assoc($sqllResultquery)) {

                                array_push($InvestorArray,$row);
                            }
                            //$InvestorArray=$filtername;
                            echo json_encode($InvestorArray);exit();
                            //$returndata["data"] = $InvestorArray;
                           

        }


    }

    else if($_POST['mode'] == 'export')
    {
        $filtername = $_POST['filterName'];
        $sql="SELECT `investor_name` FROM `saved_filter` where filter_name='".$filtername."' ";
        $sqlSelResult = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($sqlSelResult)) {

            $investor_id= $row['investor_name']  ;
           
        }
        $inv_investor_id=explode(',',$investor_id);
    
        $InvestorArray=array();
        if(isset($inv_investor_id))
        {
            $sqlquery='SELECT * FROM `peinvestors`,`saved_filter` WHERE `Investor` IN ("'. implode('","', $inv_investor_id) .'") and filter_name="'. $filtername.'"';
           // echo $sqlquery;exit();
                                $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());

                            while ($row = mysql_fetch_assoc($sqllResultquery)) {

                                array_push($InvestorArray,$row);
                            }
                            echo json_encode($InvestorArray);exit();
                           

        }

        
    }

    else if($_POST['mode'] == 'getInvestorId')
    {
        $investor_id = $_POST['investorName'];
        //echo $investor_id;exit();
        $inv_investor_id=explode(',',$investor_id);
    
        $InvestorArray=array();
        if(isset($inv_investor_id))
        {
            $sqlquery='SELECT * FROM `peinvestors` WHERE `Investor` IN ("'. implode('","', $inv_investor_id) .'")';
            //echo $sqlquery;exit();
                                $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());

                            while ($row = mysql_fetch_assoc($sqllResultquery)) {

                                array_push($InvestorArray,$row);
                            }
                            echo json_encode($InvestorArray);exit();
                           }
                        }

 

?>