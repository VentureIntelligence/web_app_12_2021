<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('machecklogin.php');
$select_type = $_REQUEST['select_type'];
$searchTerm=$_REQUEST['search'];
$jsonarray=array();
if ($searchTerm!=''){
    if($select_type == 'acquirers'){
        $acquirersql="SELECT distinct peinv.AcquirerId, ac.Acquirer FROM acquirers AS ac, mama AS peinv WHERE ac.AcquirerId = peinv.AcquirerId and peinv.Deleted=0 and ac.Acquirer like '".$searchTerm."%' order by Acquirer";

        /* populating the investortype from the investortype table */
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        
        if ($rsacquire = mysql_query($acquirersql))
        {
             $acquire_cnt = mysql_num_rows($rsacquire);
	}

        if($acquire_cnt >0){
            While($myrow=mysql_fetch_array($rsacquire, MYSQL_BOTH))
            {
                    $adviosrname=trim($myrow["Acquirer"]);
                    $adviosrname=strtolower($adviosrname);

                    $invResult=substr_count($adviosrname,$searchString,0);
                    $invResult1=substr_count($adviosrname,$searchString1,0);
                    //echo "ddddddddddddd".$invResult2=strcasecmp($adviosrname,$searchString2);
                    $invResult2=($adviosrname == $searchString2) ? 1 : 0;

                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                    {
                        $ladvisor = $myrow["Acquirer"];
                        $ladvisorid = $myrow["AcquirerId"];
                        $jsonarray[]=array('name'=>addslashes($ladvisor),'id'=>$ladvisorid);
                        
                        //echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
                        //$isselcted = (trim($_POST['keywordsearch'])==trim($ladvisor)) ? 'SELECTED' : '';
                        //echo "<OPTION value='".$ladvisor."'>".$ladvisor."</OPTION> \n";
                    }
            }
                    mysql_free_result($rsadvisor);
        }
    }else if($select_type == 'company'){ 
        $companysql_search="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business FROM mama AS pe, industry AS i, pecompanies AS pec";
        $companysql_search.=" WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.industry != 15 and pec.companyname like '".$searchTerm."%' order by pec.companyname";

        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);

        if ($rsinvestors = mysql_query($companysql_search) or die(mysql_error()))
        {    
                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                {
                        $companyname=trim($myrow["companyname"]);
                        $companyname=strtolower($companyname);

                        $invResult=substr_count($companyname,$searchString);
                        $invResult1=substr_count($companyname,$searchString1);
                        $invResult2=substr_count($companyname,$searchString2);

                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                        {
                                $compName = $myrow["companyname"];
                                $compid = $myrow["PECompanyId"];
                               // $isselected = (trim($_POST['companysearch'])==trim($compName)) ? 'SELECTED' : '';
                               // echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
                               //$totalCount=$totalCount+1;

                               $jsonarray[]=array('name'=>addslashes($compName),'id'=>addslashes($compid)); 
                        }

                }
        }
    }else if($select_type == 'sector'){
        $sectorsql_search="SELECT distinct sector_business FROM mama AS pe, industry AS i, pecompanies AS pec";
        $sectorsql_search .= " WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.industry != 15 and sector_business like '".$searchTerm."%'  order by pec.companyname"; 

        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        mysql_query('SET CHARACTER SET utf8');
        if ($rssector = mysql_query($sectorsql_search) or die(mysql_error()))
        {   
                While($myrow=mysql_fetch_array($rssector, MYSQL_BOTH))
                {
                        $sectorname=trim($myrow["sector_business"]);
                        $sectorname=strtolower($sectorname);

                        $invResult=substr_count($sectorname,$searchString);
                        $invResult1=substr_count($sectorname,$searchString1);
                        $invResult2=substr_count($sectorname,$searchString2);


                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ($sectorname!="") && ($sectorname!= null) && ($sectorname!= 'null'))
                        {
                                //$sectorName = $myrow["sector_business"];

                                                $sector = trim($myrow["sector_business"]);
                                                $pos = strpos($sector, '(');

                                                if ($pos == false) {
                                                    $sectorName = $sector;                                        
                                                } else {
                                                    $sectorName = substr_replace($sector, '', $pos);

                                                }

                                                $sectorName = trim($sectorName);

                                                    if (in_array($sectorName, $temp_array)) {
                                                        continue;
                                                    }
                                                    $temp_array[] = $sectorName;

                                $jsonarray[]=array('name'=> $sectorName,'id'=> $sectorName); 
                                //$isselected = (trim($_POST['sectorsearch']) == trim($sectorName)) ? 'SELECTED' : ' ';
                                //echo '<OPTION value='.$sectorName.' '.$isselected.'>'.$sectorName.'</OPTION> \n';
                                //$totalCount=$totalCount+1;
                        }
                }
        }
    }else if($select_type == 'legal_advisor'){
        $advisorsql="(
                    SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID and AdvisorType='L'
                    AND adac.MAMAId = peinv.MAMAId  AND cia.Cianame like '".$searchTerm."%' )
                    UNION (
                    SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID  and AdvisorType='L'
                    AND adcomp.MAMAId = peinv.MAMAId  AND cia.Cianame like '".$searchTerm."%'    )	ORDER BY Cianame";
	
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}
        
        /* populating the investortype from the investortype table */
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);

        if($advisor_cnt >0){
             While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                    $adviosrname=trim($myrow["Cianame"]);
                                    $adviosrname=strtolower($adviosrname);

                                    $invResult=substr_count($adviosrname,$searchString);
                                    $invResult1=substr_count($adviosrname,$searchString1);
                                    $invResult2=substr_count($adviosrname,$searchString2);

                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
                                            $ladvisor = $myrow["Cianame"];
                                            $ladvisorid = $myrow["CIAId"];
                                            $jsonarray[]=array('name'=>addslashes($ladvisor),'id'=>$ladvisorid);
                                            //echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
                                            //$isselcted = (trim($_POST['advisorsearch_legal'])==trim($ladvisor)) ? 'SELECTED' : '';
                                            //echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
                                    }
            }
                    mysql_free_result($rsadvisor);
        }

    }else if($select_type == 'transaction_advisor'){
        $advisorsql="(
                    SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID and AdvisorType='T'
                    AND adac.MAMAId = peinv.MAMAId  AND cia.Cianame like '".$searchTerm."%')
                    UNION (
                    SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID  and AdvisorType='T'
                    AND adcomp.MAMAId = peinv.MAMAId  AND cia.Cianame like '".$searchTerm."%')	ORDER BY Cianame";
	
        if ($rsadvisor = mysql_query($advisorsql)){
                $advisor_cnt = mysql_num_rows($rsadvisor);
        }

            /* populating the investortype from the investortype table */
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);

        if($advisor_cnt >0){
             While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                    $adviosrname=trim($myrow["Cianame"]);
                                    $adviosrname=strtolower($adviosrname);

                                    $invResult=substr_count($adviosrname,$searchString);
                                    $invResult1=substr_count($adviosrname,$searchString1);
                                    $invResult2=substr_count($adviosrname,$searchString2);

                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
                                            $ladvisor = $myrow["Cianame"];
                                            $ladvisorid = $myrow["CIAId"];
                                            $jsonarray[]=array('name'=>addslashes($ladvisor),'id'=>$ladvisorid);
                                            //echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
                                            //$isselcted = (trim($_POST['advisorsearch_trans'])==trim($ladvisor)) ? 'SELECTED' : '';
                                            //echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
                                    }
            }
                    mysql_free_result($rsadvisor);
        }
    }   
}
echo json_encode($jsonarray);
mysql_close();
?>
