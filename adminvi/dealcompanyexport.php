<?php
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
    {
     //print_r($_POST);

       $company_id = $_POST['companyid'];
        //clean the output buffer
        ob_end_clean();
        $getCompNameSql ="Select * from dealcompanies where DCompId=$company_id ";
        $dealcompanyrs = mysql_query($getCompNameSql);
        $mycomrow=mysql_fetch_row($dealcompanyrs, MYSQL_BOTH);
           
        $filename='DealCompany - '.$mycomrow['DCompanyName'].'.csv'; //save our workbook as this file name
        // Redirect output to a clients web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header("Pragma: no-cache");
        header("Expires: 0");
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        $out = fopen("php://output", 'w');
        $expiry_date = date('d M Y', strtotime($mycomrow['ExpiryDate']));
        fputcsv( $out, array( 'Deal Company - '.$mycomrow['DCompanyName'], '', '' ), ',', '"' );
        fputcsv( $out, array( 'Company Name', $mycomrow['DCompanyName'] ), ',', '"' );
        fputcsv( $out, array( 'Expiry Date',$expiry_date ), ',', '"' );
        fputcsv( $out, array( '','','','',''), ',', '"' );
        fputcsv( $out, array( 'Access Section','','','',''), ',', '"' );
        fputcsv( $out, array( 'PE Login','VC Login','MA Login','RE Login','Export to Excel','Student','IP Add'), ',', '"' );
        
        if($mycomrow["PEInv"] == 1 || $mycomrow["VCInv"] == 1){
            
            $peloginFlag = 1;
        }
        $maloginFlag = $mycomrow["MAMA"];
        $reloginFlag = $mycomrow["REInv"];
        $trialLoginFlag = $mycomrow["TrialLogin"];
        $studentLoginFlag = $mycomrow["Student"];
        $IpAddFlag = $mycomrow["IPAdd"];
        $poContact = $mycomrow["poc"];
        
        if($mycomrow["PEInv"] == 1 || $mycomrow["PEIpo"] == 1 || $mycomrow["PEMa"] == 1 || $mycomrow["PEDir"] == 1 || $mycomrow["CTech"] == 1){
            
            $peonlyFlag = 1;
        }
        
        if($mycomrow["VCInv"] == 1 || $mycomrow["VCIpo"] == 1 || $mycomrow["VCMa"] == 1 || $mycomrow["VCDir"] == 1 || $mycomrow["Inc"] == 1 || $mycomrow["AngelInv"] == 1 || $mycomrow["SVInv"] == 1 || $mycomrow["IfTech"] == 1){
            
            $vconlyFlag = 1;
        }
        
        if($peloginFlag==1)
        {
            $ipflag="YES";
        }else{
            $ipflag="NO";
        }
        if($vconlyFlag == 1){
            
            $vconlyflag = "YES";
        }else{
            $vconlyflag = "NO";
        }
        if($maloginFlag==1)
        {
            $maflag="YES";
        }else{
            $maflag="NO";
        }
        if($reloginFlag==1)
        {
            $reflag="YES";
        }else{
            $reflag="NO";
        }
        if($trialLoginFlag==1)
        {
            $trialFlag ="YES";
        }else{
            $trialFlag ="NO";
        }
        if($studentLoginFlag==1)
        {
            $studentFlag = "YES";
        }else{
            $studentFlag = "NO";
        }
        if($IpAddFlag==1)
        {
            $ipflag = "YES";
        }else{
            $ipflag = "NO";
        }
        if ($poContact == ''){
            $poContact = 'info@ventureintelligence.com';
        }
        
        fputcsv( $out, array( $ipflag,$maflag,$reflag,$trialFlag,$studentFlag,$ipflag), ',', '"' );
        fputcsv( $out, array( '','','','',''), ',', '"' );
        fputcsv( $out, array( 'PE ONLY','VC ONLY'), ',', '"' );
        
        if($peonlyFlag == 1){
            
            $peonlyflag = "YES";
        }else{
            $peonlyflag = "NO";
        }
        if($vconlyFlag == 1){
            
            $vconlyflag = "YES";
        }else{
            $vconlyflag = "NO";
        }
        fputcsv( $out, array( $peonlyflag,$vconlyflag), ',', '"' );
        fputcsv( $out, array( '','','','','','','','','','','','','','','','',''), ',', '"' );
        /*fputcsv( $out, array( 'PE-Inv','VC-Inv','PE-IPO','VC-IPO','PE-M&A','VC-M&A','PE-Dir','VC-Dir','SP-Dir','PE-Back','VC-Back','MAMA','Inc','AngelInv','SV-Inv','If-Tech','CTech'), ',', '"' );*/
        fputcsv( $out, array( 'PE-Inv','VC-Inv','PE-IPO','VC-IPO','PE-M&A','VC-M&A','PE-Dir','VC-Dir','SP-Dir','LP-Dir','Inc','AngelInv','SV-Inv','If-Tech','CTech'), ',', '"' );
        
        if($mycomrow["PEInv"] == 1){ 
            
            $PEInvFlag = "YES";
        }else{
            $PEInvFlag = "NO";
        }
        
        if( $mycomrow["PEIpo"] == 1 ){
            $PEIPOFlag = "YES";
        }else{
            $PEIPOFlag = "NO";
        }
        
        if($mycomrow["PEMa"] == 1 ){
            $PEmaFlag = "YES";
        }else{
            $PEIPOFlag = "NO";
        }
        
        if($mycomrow["PEDir"] == 1 ){
             $PEdirFlag = "YES";
        }else{
            $PEIPOFlag = "NO";
        }
         
        if( $mycomrow["CTech"] == 1){
            $CTechFlag = "YES";
        }else{
             $CTechFlag = "NO";
        }
        
        if($mycomrow["VCInv"] == 1){  
            
            $VCInvFlag = "YES";
        }else{
            $VCInvFlag = "NO";
        }
        
        if($mycomrow["VCIpo"] == 1 ){
            $VCIpoFlag = "YES";
        }else{
            $VCIpoFlag = "NO";
        }
        
        if($mycomrow["VCMa"] == 1 ){
            $VCmaFlag = "YES";
        }else{
            $VCmaFlag = "NO";
        }
        
        if($mycomrow["VCDir"] == 1 ){
            $VCdirFlag = "YES";
        }else{
            $VCdirFlag = "NO";
        }
        
        if($mycomrow["Inc"] == 1 ){
            $IncFlag = "YES";
        }else{
            $IncFlag = "NO";
        }  
        
        if($mycomrow["AngelInv"] == 1 ){
            $AngelInvFlag = "YES";
        }else{
            $AngelInvFlag = "NO";
        }
        
        if($mycomrow["SVInv"] == 1 ){
            
            $SVInvFlag = "YES";
        }else{
             $SVInvFlag = "NO";
        }
        
        if($mycomrow["IfTech"] == 1){
             $IfTechFlag = "YES";
        }else{
            $IfTechFlag = "NO";
        }
        
        if($mycomrow["SPDir"] == 1){
             $SPDirFlag = "YES";
        }else{
            $SPDirFlag = "NO";
        }
        
         if($mycomrow["LPDir"] == 1){
             $LPDirFlag = "YES";
        }else{
            $LPDirFlag = "NO";
        }
        
        if($mycomrow["PE_backDir"] == 1){
             $PEbackDirFlag = "YES";
        }else{
            $PEbackDirFlag = "NO";
        }
        
        if($mycomrow["VC_backDir"] == 1){
             $VCbackDirFlag = "YES";
        }else{
            $VCbackDirFlag = "NO";
        }
        
        /*fputcsv( $out, array( $PEInvFlag,$VCInvFlag,$PEIPOFlag,$VCIpoFlag,$PEmaFlag,$VCmaFlag,$PEdirFlag,$VCdirFlag,$SPDirFlag,$PEbackDirFlag,$VCbackDirFlag,$maflag,$IncFlag,
            $AngelInvFlag,$SVInvFlag,$IfTechFlag,$CTechFlag), ',', '"' );*/
             fputcsv( $out, array( $PEInvFlag,$VCInvFlag,$PEIPOFlag,$VCIpoFlag,$PEmaFlag,$VCmaFlag,$PEdirFlag,$VCdirFlag,$SPDirFlag,$LPDirFlag,$IncFlag,
            $AngelInvFlag,$SVInvFlag,$IfTechFlag,$CTechFlag), ',', '"' );
        
        //Get IP Address
        fputcsv( $out, array( '','','','',''), ',', '"' );
        fputcsv( $out, array( 'IP RANGE','','','',''), ',', '"' );
        fputcsv( $out, array( 'IP Address','Start Range','End Range'), ',', '"' );
        
        $sqlSelIp = "SELECT ipAddress,StartRange,EndRange FROM ipAddressKey WHERE DCompId='$company_id'";
       
        if($rsgetip = mysql_query($sqlSelIp)){

            if(mysql_num_rows($rsgetip) > 0){
                
                While($myIp=mysql_fetch_array($rsgetip, MYSQL_BOTH)){
                
                
                    $usrIp = $myIp['ipAddress'];
                    $usrsRng = $myIp['StartRange'];
                    $usreRng = $myIp['EndRange'];
                    $ipCount++;
                    fputcsv( $out, array( $usrIp,$usrsRng,$usreRng), ',', '"' );

                }
                fputcsv( $out, array( '','',''), ',', '"' );
            }else{
                fputcsv( $out, array( '','',''), ',', '"' );
            }
            
        }
        
        fputcsv( $out, array( 'Company Contacts',$poContact,''), ',', '"' );
        fputcsv( $out, array( '','','','',''), ',', '"' );
        fputcsv( $out, array( 'List of Members','','','',''), ',', '"' );
        fputcsv( $out, array( 'S.No','Name','Email Id','Password','Device Allowed', 'Export Limit','Database'), ',', '"' );
        
        $emailCount=1;
        $getpeMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit from dealmembers where DCompId=$company_id and Deleted=0 order by EmailId";
        if ($rspeMembers=mysql_query($getpeMembersSql))
        {
            if(mysql_num_rows($rspeMembers) > 0){
                
                While($pemyrow=mysql_fetch_array($rspeMembers, MYSQL_BOTH))
                {
                    fputcsv( $out, array( $emailCount,$pemyrow['Name'],$pemyrow['EmailId'],$pemyrow['Passwrd'],$pemyrow['deviceCount'],$pemyrow['exportLimit'],'PE'), ',', '"' );
                    $emailCount=$emailCount+1;
                }
            }
            
        }
        
        $MAemailCount=1;
        $getMAMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit from malogin_members where DCompId=$company_id and Deleted=0 order by EmailId ";
        if ($rsMAMembers=mysql_query($getMAMembersSql))
        {
            if(mysql_num_rows($rsMAMembers) > 0){
                
                While($myMArow=mysql_fetch_array($rsMAMembers, MYSQL_BOTH))
                {
                    fputcsv( $out, array( $MAemailCount,$myMArow['Name'],$myMArow['EmailId'],$myMArow['Passwrd'],$myMArow['deviceCount'],$myMArow['exportLimit'],'MA'), ',', '"' );
                    $MAemailCount=$MAemailCount+1;
                }
            }
        }
        
        $REemailCount=1;
        $getREMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit from RElogin_members where DCompId=$company_id and Deleted=0 order by EmailId ";
        if ($rsREMembers=mysql_query($getREMembersSql))
        {
            if(mysql_num_rows($rsREMembers) > 0){
                
                While($myRErow=mysql_fetch_array($rsREMembers, MYSQL_BOTH))
                {
                    fputcsv( $out, array( $REemailCount,$myRErow['Name'],$myRErow['EmailId'],$myRErow['Passwrd'],$myRErow['deviceCount'],$myRErow['exportLimit'],'RE'), ',', '"' );
                    $REemailCount=$REemailCount+1;
                }
            
            }
        }
        
        fclose($out);
          
    }
?>     
        
			
