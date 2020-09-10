<?php include_once("../globalconfig.php"); ?>
<?php        
        require("../dbconnectvi.php");
        $Db = new dbInvestments();
    if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
    {
        
        $month1=$_POST['month1'];
        $year1 = $_POST['year1'];
        $month2=$_POST['month2'];
        $year2 = $_POST['year2'];
        $addVCFlagqry = " and pec.industry !=15 ";
        $searchTitle = "List of PE Investments ";
		
        if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
        {
//         $companysql = "SELECT pe.PEId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
//                        amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,pe.comment,pe.uploadfilename,FinLink,AggHide
//                        FROM peinvestments AS pe, industry AS i, pecompanies AS pec ,stage as s
//                        WHERE pec.industry = i.industryid
//                        AND pec.PEcompanyID = pe.PECompanyID and s.StageId=pe.StageId
//                        and pe.Deleted=0" .$addVCFlagqry.
//                        "order by companyname";
         
         $companysql = "SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, pec.sector_business,
      	 pe.amount, pe.round,pe.StageId, s.stage, pe.stakepercentage, DATE_FORMAT( dates, '%M' )  as dates,
      	 pec.website, pec.city, pec.RegionId,r.Region, PEId,DATE_FORMAT( dates, '%Y' ) as dtyear, comment,MoreInfor,
      	 Validation,InvestorType,hideamount,hidestake,SPV,Link,pec.countryid,pec.uploadfilename,source,Valuation,FinLink,AggHide,
      	 Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,pe.Revenue,pe.EBITDA,pe.PAT,
         (SELECT GROUP_CONCAT( DISTINCT CONCAT(inv.Investor,'(', peinv_inv.Amount_M, ') ')  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
         (SELECT GROUP_CONCAT( cia.cianame) from peinvestments_advisorcompanies as advcomp,advisor_cias as cia where advcomp.PEId=pe.PEId and advcomp.CIAId=cia.CIAId) AS advisor_companies,
         (SELECT GROUP_CONCAT( ria.cianame) from from REinvestments_advisorinvestors as advinv,REadvisor_cias as ria where advinv.PEId=pe.PEId and advinv.CIAId=ria.CIAId) AS advisor_investor
  			FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,region as r
  			WHERE i.industryid = pec.industry   and r.RegionId=pec.RegionId
			AND pec.PEcompanyID = pe.PECompanyID and s.StageId=pe.StageId and pe.Deleted=0" .$addVCFlagqry. "order by companyname";
		//	echo "<br>--" .$getDatasql;
//	 $getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
//	 peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef";

        }
        elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
        {

                $dt1 = $year1."-".$month1."-01";
                //echo "<BR>DATE1---" .$dt1;
                $dt2 = $year2."-".$month2."-01";
//                $companysql = "select pe.PEId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
//                amount,DATE_FORMAT(dates,'%b-%Y') as dealperiod,pe.comment,pe.uploadfilename,FinLink ,AggHide
//                from peinvestments as pe, industry as i,pecompanies as pec,stage as s where pec.industry=i.industryid
//                and dates between '".$dt1."' and '".$dt2 ."'
//                and	pec.PEcompanyID = pe.PECompanyID  and s.StageId=pe.StageId
//                and pe.Deleted=0 " .$addVCFlagqry. "order by companyname  ";
                
                
                $companysql = "SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, i.industry, pec.sector_business,
                pe.amount, pe.round,pe.StageId, s.stage, pe.stakepercentage, DATE_FORMAT( dates, '%M' )  as dates,
                pec.website, pec.city, pec.RegionId,r.Region, PEId,DATE_FORMAT( dates, '%Y' ) as dtyear, comment,MoreInfor,
                Validation,it.InvestorTypeName,hideamount,hidestake,SPV,Link,c.country,pec.uploadfilename,source,Valuation,FinLink,AggHide,
                Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,es.status,Exit_Status,pe.Revenue,pe.EBITDA,pe.PAT,
                (SELECT GROUP_CONCAT(DISTINCT CONCAT(inv.Investor,'(', peinv_inv.Amount_M, ') ')  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
                (SELECT GROUP_CONCAT( cia.cianame) from peinvestments_advisorcompanies as advcomp,advisor_cias as cia where advcomp.PEId=pe.PEId and advcomp.CIAId=cia.CIAId) AS advisor_companies,
                (SELECT GROUP_CONCAT( ria.cianame) from peinvestments_advisorinvestors as advinv, advisor_cias as ria where advinv.PEId=pe.PEId and advinv.CIAId=ria.CIAId) AS advisor_investors	
                FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,region as r,exit_status as es,country as c,investortype as it
                WHERE i.industryid = pec.industry   and r.RegionId=pec.RegionId and es.id = pe.Exit_Status and c.countryid = pec.countryid and it.InvestorType=pe.InvestorType and pe.dates between '".$dt1."' and '".$dt2 ."'
                AND pec.PEcompanyID = pe.PECompanyID and s.StageId=pe.StageId and pe.Deleted=0" .$addVCFlagqry. "order by companyname";
//				echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
        }
        else
        {
            echo "<br> INVALID DATES GIVEN ";
            $fetchRecords=false;
        }

			

 $sql=$companysql;
//echo "<br>---" .$sql;die;
 //execute query
 $result = @mysql_query($sql)
     or die("Error in connection:<br>");

 //if this parameter is included ($w=1), file returned will be in word format ('.doc')
 //if parameter is not included, file returned will be in excel format ('.xls')
 	if (isset($w) && ($w==1))
 	{
 		$file_type = "msword";
 		$file_ending = "doc";
 	}
 	else
 	{
 		$file_type = "vnd.ms-excel";
 		$file_ending = "xls";
	}
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=pe_investment.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");

 /*    Start of Formatting for Word or Excel    */

 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	if ($Use_Title == 1)
 	{
 		echo("$title\n");
 	}
    //define separator (defines columns in excel & tabs in word)
    $sep = "\t"; //tabbed character


    echo "Company"."\t";
    echo "Period"."\t";
    echo "Listing Status"."\t";
    echo "Exit Status"."\t";
    echo "Industry"."\t";
    echo "Sector"."\t";
    echo "Amount(US\$M)"."\t";
    echo "Round"."\t";
    echo "Stage"."\t";
    echo "Investors"."\t";
    echo "Investor Type"."\t";
    echo "Stake percentage"."\t";
    echo "Website"."\t";
    echo "City"."\t";
    echo "Region"."\t";
    echo "Country"."\t";
    echo "Advisor Company"."\t";
    echo "Advisor Investor"."\t";
    echo "Comment"."\t";
    echo "More Information"."\t";
    echo "Validation"."\t";
    echo "Link"."\t";
    echo "Company valuation (INR cr)"."\t";
    echo "Revenue Multiple"."\t";
    echo "EBITDA Multiple"."\t";
    echo "PAT Multiple"."\t";
    echo "Price to book"."\t";
    echo "valuation (more info)"."\t";
    echo "Revenue (INR cr)"."\t";
    echo "EBITDA (INR cr)"."\t";
    echo "PAT (INR cr)"."\t";
    echo "Book value per share"."\t";
    echo "Price per share"."\t";
    echo "Link for financial"."\t";
    echo "Financial"."\t";
    echo "Source"."\t";
    echo "Hide for Aggregate"."\t";
    echo "Db type"."\t";
    echo "Debt"."\t";
    
    print("\n");

    print("\n");
    //end of printing column names

    //start while loop to get data
    /*
    note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
    */

   While($row=mysql_fetch_array($result, MYSQL_BOTH))
   {
      
        $schema_insert = "";
            
        $schema_insert .= $row['companyname'].$sep;  //company name 
        $schema_insert .= $row['dates']."-".$row['dtyear'].$sep; //period
        if ($row['listing_status']=="L")
        {   
          $schema_insert .= 'Listed'.$sep;//Listing status
        }
        elseif($row['listing_status']=="U")
        {
           $schema_insert .= 'UnListed'.$sep;   //UnListing status
        }
        $schema_insert .= $row['status'].$sep; //exit status
        $schema_insert .= $row['industry'].$sep;   //Industry
        $schema_insert .= $row['sector_business'].$sep; //Sector
        $schema_insert .= $row['amount'].$sep;   //amount
        $schema_insert .= $row['round'].$sep; //round
        $schema_insert .= $row['stage'].$sep;   //stage
        $schema_insert .= $row['Investor'].$sep; //Investors
        $schema_insert .= $row['InvestorTypeName'].$sep;   //Investor type
        $schema_insert .= $row['stakepercentage'].$sep; //stake percentsge
        $schema_insert .= $row['website'].$sep;   //website
        $schema_insert .= $row['city'].$sep; //city
        $schema_insert .= $row['Region'].$sep;   //region
        $schema_insert .= $row['country'].$sep; //country
        $schema_insert .= $row['advisor_companies'].$sep; // echo "Advisor Company"."\t";
        $schema_insert .= $row['advisor_investors'].$sep; // echo "Advisor Investor"."\t";
        $schema_insert .= $row['comment'].$sep; // echo "Comment"."\t";
        $schema_insert .= $row['MoreInfor'].$sep; // echo "More Information"."\t";
        $schema_insert .= $row['Validation'].$sep; // echo "Validation"."\t";
        $schema_insert .= $row['Link'].$sep; // echo "Link"."\t";
        $schema_insert .= $row['Company_Valuation'].$sep; // echo "Company valuation (INR cr)"."\t";
        $schema_insert .= $row['Revenue_Multiple'].$sep; // echo "Revenue Multiple"."\t";
        $schema_insert .= $row['EBITDA_Multiple'].$sep; // echo "EBITDA Multiple"."\t";
        $schema_insert .= $row['PAT_Multiple'].$sep; // echo "PAT Multiple"."\t";
        $schema_insert .= $row['price_to_book'].$sep; // echo "Price to book"."\t";
        $schema_insert .= $row['Valuation'].$sep; // echo "valuation (more info)"."\t";
        $schema_insert .= $row['Revenue'].$sep; // echo "Revenue (INR cr)"."\t";
        $schema_insert .= $row['EBITDA'].$sep; // echo "EBITDA (INR cr)"."\t";
        $schema_insert .= $row['PAT'].$sep; // echo "PAT (INR cr)"."\t";
        $schema_insert .= $row['book_value_per_share'].$sep; // echo "Book value per share"."\t";
        $schema_insert .= $row['price_per_share'].$sep; // echo "Price per share"."\t";
        $schema_insert .= $row['FinLink'].$sep; // echo "Link for financial"."\t";
        if($row['uploadfilename']!=''){
            $schema_insert .= 'www.ventureintelligence.com/uploadmamafiles/'.$row['uploadfilename'].$sep; // echo "Financial file"."\t";
        }else{
            $schema_insert .=''.$sep;
        }
        $schema_insert .= $row['source'].$sep; // echo "Source"."\t";
        
        if($row['AggHide']==0){
            $schema_insert .= 'NO'.$sep; // echo "Hide for Aggregate"."\t";\
        }else{
            $schema_insert .= 'Yes'.$sep; // echo "Hide for Aggregate"."\t";\
        }
        $schema_insert .= 'Social Venture'.$sep; // echo "Db type"."\t";
        if($row['AggHide']==0){
            $schema_insert .= 'NO'.$sep; // echo "Debt"."\t";\
        }else{
            $schema_insert .= 'Yes'.$sep; // echo "Debt"."\t";\
        }
        $schema_insert .= ""."\n";
        //following fix suggested by Josue (thanks, Josue!)
        //this corrects output in excel when table fields contain \n or \r
        //these two characters are now replaced with a space
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
        

   }
    }
		