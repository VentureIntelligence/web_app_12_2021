<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        
        
        $VCFlagValue = $_GET['vcf'];
        
        if($VCFlagValue==0)
        {
                $addVCFlagqry="";
                $pagetitle="PE Investors";
        }
        elseif($VCFlagValue==1)
        {
                //$addVCFlagqry="";
                $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                $pagetitle="VC Investors";
        }
        
        
        elseif($VCFlagValue==3)
        {
               $addVCFlagqry="";
                $dbtype="SV";
        }
        
         elseif($VCFlagValue==4)
        {
                $addVCFlagqry = "";
               $dbtype="CT";
        }
        
        elseif($VCFlagValue==5)
        {
              $addVCFlagqry = "";
	      $dbtype="IF";
        }
        
        
       
        
        
      
    if($VCFlagValue ==0 || $VCFlagValue ==1 ){
      
       $term = $_GET['pe_q'];
       
       $getInvestorSql="SELECT DISTINCT inv.InvestorId as id, inv.Investor as name
        FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
        WHERE pe.PECompanyId = pec.PEcompanyId
        AND s.StageId = pe.StageId
        AND pec.industry !=15
        AND peinv.PEId = pe.PEId
        AND inv.InvestorId = peinv.InvestorId
        AND pe.Deleted=0 " .$addVCFlagqry. " AND inv.Investor LIKE '".$term."%' order by inv.Investor "; 
       
       
       
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

    
    elseif($VCFlagValue ==3 ||  $VCFlagValue == 4 || $VCFlagValue == 5 ){
                  
         
       
       $term = $_GET['social_q'];
       
    
       
       
       $getInvestorSql="SELECT DISTINCT inv.InvestorId as id, inv.Investor as name
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 AND inv.Investor LIKE '".$term."%' " .$addVCFlagqry. " order by inv.Investor"; 
       
       
       
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
    
    
    elseif($VCFlagValue == 6) 
    {
        
          $term = $_GET['angel_q'];
        $getInvestorSql="SELECT DISTINCT inv.InvestorId as id, inv.Investor as name
                    FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                    WHERE pe.InvesteeId = pec.PEcompanyId
                    AND pec.industry !=15
                    AND peinv.AngelDealId = pe.AngelDealId
                    AND inv.InvestorId = peinv.InvestorId
                    AND pe.Deleted=0 and inv.investor like '".$term."%' order by inv.Investor ";
    
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
                        
mysql_close();
    mysql_close($cnx);
    ?>
