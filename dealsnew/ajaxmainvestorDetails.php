<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        
        if(!isset($_SESSION['UserNames']))
        {
                header('Location:../pelogin.php');
        }
        else
        {    
     
    $maVCFlagValue = $_GET['mavcf'];
    
    if($maVCFlagValue==0)
    {
            $addVCFlagqry="";
            $pagetitle="PE Exits M&A - Investors";
    }
    elseif($maVCFlagValue==1)
    {
            //$addVCFlagqry="";
            $addVCFlagqry = " and VCFlag=1 ";
            $pagetitle="VC Exits M&A - Investors";
    }
    if($maVCFlagValue==0 || $maVCFlagValue==1 ) {
                  
       $searchTerm = $_GET['ma_q'];
       
       $getInvestorSql="SELECT DISTINCT inv.InvestorId as id, inv.Investor as name
                        FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId
                        AND pec.industry !=15
                        AND peinv.MandAId = pe.MandAId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and inv.Investor like '".$searchTerm."%' " .$addVCFlagqry. " order by inv.Investor";
       
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
