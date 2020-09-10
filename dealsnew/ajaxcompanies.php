<?php
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $vcflagValue=$_POST['value'];
        $search =$_POST['search'];
        $dealvalue=102;
        if($vcflagValue==0)
        {
                $addVCFlagqry="";
                $pagetitle="PE Investors";
        }
        elseif($vcflagValue==1)
        {
                //$addVCFlagqry="";
                $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                $pagetitle="VC Investors";
        }

            /* populating the investortype from the investortype table */
		$searchStrings="Undisclosed";
                $searchStrings=strtolower($searchStrings);

                $searchStrings1="Unknown";
                $searchStrings1=strtolower($searchStrings1);

                $searchStrings2="Others";
                $searchStrings2=strtolower($searchStrings2);

              if($dealvalue==102)
                {
                    
                             $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId and pec.companyname LIKE "."'".$search."%' " .$addVCFlagqry. "
                                        ORDER BY pec.companyname LIMIT 0,10";
                }
                  
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
			 $jsonarray=array();
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                               $commacount=0;
                               
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $companies = $myrow["companyname"] ;
                                            $jsonarray[]=array('companyname'=>$companies);
                                            
                                        }
                                }
                                
                    }
                    echo json_encode($jsonarray);
                
mysql_close();
    mysql_close($cnx);
    ?>

