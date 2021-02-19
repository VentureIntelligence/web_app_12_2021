<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        
        if(!isset($_SESSION['UserNames']))
        {
                header('Location:../pelogin.php');
        }
        else
        {   
     
    $VCFlagValue = $_GET['ipovcf'];
    
    if($VCFlagValue==0)
    {
            $addVCFlagqry="";
    }
    elseif($VCFlagValue==1)
    {
            //$addVCFlagqry="";
            $addVCFlagqry = " and VCFlag=1 ";
    }
    if($maVCFlagValue==0 || $maVCFlagValue==1 ) {
                  
       $searchTerm = $_GET['ipo_q'];
       
        
        $getInvestorSql="SELECT DISTINCT inv.InvestorId as id , inv.Investor as name
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 and inv.Investor like '".$searchTerm."%' " .$addVCFlagqry. " order by inv.Investor ";
       
       $getInvestorSql_Exe=mysql_query($getInvestorSql);
      // print_r($getInvestorSql_Exe);
       $response =array(); 
      $i = 0;
       While($myrow = mysql_fetch_array($getInvestorSql_Exe,MYSQL_BOTH)){
               
         $response[$i]['id']= $myrow['id'];
         $response[$i]['name']= $myrow['name'];
        $i++;
        
       }
       
       echo json_encode($response);
    } 
}  
                        
mysql_close();
    mysql_close($cnx);
    ?>
