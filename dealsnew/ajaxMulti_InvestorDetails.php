<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $VCFlagValue=$_REQUEST['vcflag'];
        $search=$_REQUEST['search'];
        
        if(($VCFlagValue=="0" || $VCFlagValue=="1") && trim(search)!="" )
        {
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);
        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        $addVCFlagqry="";    
        $getInvestorSql=getPESql($VCFlagValue,$search);
        $jsonarray=array();
        if ($rsinvestors = mysql_query($getInvestorSql)){
               $investor_cnt = mysql_num_rows($rsinvestors);
        }
        if($investor_cnt >0){
            
            $multiselect = '<label> <input style="width:auto !important;" type="checkbox" id="inv_selectall"> SELECT ALL</label><br>';
            
             While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                    $Investorname=trim($myrow["Investor"]);
                                    $Investorname=strtolower($Investorname);

                                    $invResult=substr_count($Investorname,$searchString);
                                    $invResult1=substr_count($Investorname,$searchString1);
                                    $invResult2=substr_count($Investorname,$searchString2);

                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
                                            $investor = $myrow["Investor"];
                                            $investorId = $myrow["InvestorId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearch'])==trim($investor)) ? 'SELECTED' : '';
                                            
                                          //  $jsonarray[]=array('id'=>$investorId,'label'=>$investor,'value'=>$investor);
                                            $multiselect.="<label style='clear: both;'><input type='checkbox' name='investor_multi[]' value='".$investorId."' class='investor_slt' data-title='$investor'>".$investor."</label></br>";
                                    }
            }
         
                    mysql_free_result($rsinvestors);
                   
            }
            echo $multiselect."</br></br>";
        }
        else if($VCFlagValue==3 || $VCFlagValue==4 || $VCFlagValue==5 || $VCFlagValue==7 || $VCFlagValue==8 || $VCFlagValue==9 || $VCFlagValue==10 || $VCFlagValue==11){
            
            $showallcompInvFlag=$_REQUEST['showallcompInvFlag'];
            $searchString="Undisclosed";
            $searchString=strtolower($searchString);

            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);
            $getInvestorSql=getSVSql($showallcompInvFlag,$VCFlagValue,$search);
            $jsonarray=array();
            if ($rsinvestors = mysql_query($getInvestorSql)){
               $investor_cnt = mysql_num_rows($rsinvestors);
            }
			
            if($investor_cnt >0){
                 $multiselect = '<label> <input style="width:auto !important;" type="checkbox" id="inv_selectall"> SELECT ALL</label><br>';
             	 While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investorname=trim($myrow["Investor"]);
					$Investorname=strtolower($Investorname);

					$invResult=substr_count($Investorname,$searchString);
					$invResult1=substr_count($Investorname,$searchString1);
					$invResult2=substr_count($Investorname,$searchString2);
					
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
						$investor = $myrow["Investor"];
						$investorId = $myrow["InvestorId"];
                                               // $jsonarray[]=array('id'=>$investorId,'label'=>$investor,'value'=>$investor);
                                               $multiselect.="<label style='clear: both;'><input type='checkbox' name='investor_multi[]' value='".$investorId."' class='investor_slt' data-title='$investor'>".$investor."</label></br>";

					}
            	}
         		
        	}
           // echo json_encode($jsonarray);
            echo $multiselect."</br></br>"; 
            
            
        }       
        
        
        
        function getPESql($VCFlagValue,$search)
        {
        
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
        $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
        FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
        WHERE pe.PECompanyId = pec.PEcompanyId
        AND s.StageId = pe.StageId
        AND pec.industry !=15
        AND peinv.PEId = pe.PEId
        AND inv.InvestorId = peinv.InvestorId
        AND pe.Deleted=0 " .$addVCFlagqry. " AND inv.Investor LIKE '".$search."%' order by inv.Investor ";
        return $getInvestorSql;
        }       
        
        
        
        function getSVSql($showallcompInvFlag,$VCFlagValue,$search)
        {
            
                $addVCFlagqry=$getInvestorSql="";
                if($showallcompInvFlag==3) 
		{
		    
                    if($vcflagValue==7)
                    {
                            $addVCFlagqry="";
                            $pagetitle="PE Backed IPOs - Investors";
                    }
                    
                     $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%' order by inv.Investor ";
		}
                if($showallcompInvFlag==4) 
		{
		    
                    if($vcflagValue==8)
                    {
                            $addVCFlagqry = " and VCFlag=1 ";
                            $pagetitle="VC Backed IPOs - Investors";
                    }
                    
                    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%' order by inv.Investor ";
		}
                if($showallcompInvFlag==5) 
		{
		    
                    if($VCFlagValue==10)
                    {
                        $addVCFlagqry="";
                        $pagetitle="PE Exits M&A - Investors";
                    }
                    
                    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%'  order by inv.Investor";
		}
                if($showallcompInvFlag==6)  
		{
                
                    if($VCFlagValue==11)
                    {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $pagetitle="VC Exits M&A - Investors";
                    }
                    
              	   $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%'  order by inv.Investor";
		}
                if($showallcompInvFlag==8)  //Social Venture Investments investors
		{
		    if($VCFlagValue==3)
		    {
			$addVCFlagqry = "";
			$dbtype="SV";
			$pagetitle="Social Venture Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 AND inv.Investor LIKE '".$search."%' " .$addVCFlagqry. " order by inv.Investor ";
		}
		if($showallcompInvFlag==9)  //CleanTech Investments investors
		{
		    if($VCFlagValue==4)
		    {
			$addVCFlagqry = "";
			$dbtype="CT";
			$pagetitle="CleanTech Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 AND inv.Investor LIKE '".$search."%' " .$addVCFlagqry. " order by inv.Investor ";
		}
                if($showallcompInvFlag==10)  //Social Venture Investments investors
		{
		    if($VCFlagValue==5)
		    {
			$addVCFlagqry = "";
			$dbtype="IF";
			$pagetitle="Infrastructure Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 AND inv.Investor LIKE '".$search."%' " .$addVCFlagqry. " order by inv.Investor ";
		}
                
                if($showallcompInvFlag==11) 
		{
		   
                    if($VCFlagValue==9)
                    {
                        $addVCFlagqry = "";
                        $pagetitle="PMS - Investors";
                    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%'  order by inv.Investor";
		}
                return $getInvestorSql;
        }
                        

    ?>
