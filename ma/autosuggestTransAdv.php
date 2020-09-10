<?php

    require_once("../dbconnectvi.php");//including database connectivity file
    $Db = new dbInvestments();

    $searchTerm = $_REQUEST['queryString'];
    $jsonarray=array();

    $advisorsql="(
                    SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID and AdvisorType='T'
                    AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                    " AND cia.Cianame like '%".$searchTerm."%')
                    UNION (
                    SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID  and AdvisorType='T'
                    AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                    " AND cia.Cianame like '%".$searchTerm."%')	ORDER BY Cianame";
	
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
                                        $jsonarray[]=array('ladvisor'=>addslashes($ladvisor),'ladvisorid'=>$ladvisorid);
                                        //echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
                                        //$isselcted = (trim($_POST['advisorsearch_trans'])==trim($ladvisor)) ? 'SELECTED' : '';
                                        //echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
                                }
        }
                mysql_free_result($rsadvisor);
        }
    
    echo json_encode($jsonarray);
    mysql_close();