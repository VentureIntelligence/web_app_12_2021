<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
session_start();
                
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
//	if (session_is_registered("SessLoggedAdminPwd"))
//	{
//	//&& session_is_registered("SessLoggedIpAdd"))
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Venture Intelligence</title>
        <link href="../css/style_root.css" rel="stylesheet" type="text/css">
        <link href="../css/vistyle.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <form name="admin"  method="post" action="" >
            <div id="containerproductproducts">
                <!-- Starting Left Panel -->
                <div id="leftpanel">
                      <?php include_once 'leftpanel.php'; ?>
                        <!--    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
                            <div id="vertbgproproducts">
                                        <div id="vertMenu">
                                                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
                                                </div>
                                              <div id="linksnone">
                                                                        <a href="dealsinput.php">Investment Deals</a><br />
                                                                        <a href="companyinput.php">Profiles</a><br />
                                                                  <a href="investorinput.php">Investor Profile</a><br />
                                                                </div>

                                                                <div id="vertMenu">
                                                                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
                                                                </div>
                                                                <div id="linksnone">
                                                                        <a href="pegetdatainput.php">Deals / Profile</a><br />
                                                                        <a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a><br />

                                                                </div>

                                                                <div id="vertMenu">
                                                                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
                                                                </div>
                                                                <div id="linksnone">
                                                                        <a href="admin.php">Subscriber List</a><br />
                                                                        <a href="addcompany.php">Add Subscriber / Members</a><br />
                                                                        <a href="delcompanylist.php">List of Deleted Companies</a><br />
                                                                        <a href="delmemberlist.php">List of Deleted Emails</a><br />
                                                                        <a href="deallog.php">Log</a><br />
                                        </div>
                                                        <div id="vertMenu">
                                                                <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
                                                        </div>
                                                        <div id="linksnone"><a href="../adminlogoff.php">Logout</a><br />
                                        </div>

                        </div>-->
                </div>
                <!-- Ending Left Panel -->
                <!-- Starting Work Area -->

                <div style="width:570px; float:right;background-color:#FFF; ">
                    <div style="width:565px; float:left; padding-left:2px;height:760;overflow-y: auto;">
                        <div style=" width:565px;">
                            <div id="maintextpro">
                                <div id="headingtextpro">

                                    <h3 style="margin-bottom:15px;">Updated Members List</h3>
                                    <div style="width: 542px; max-height: 600px;overflow-y: auto;">
                                        <table border="1" cellpadding="2" cellspacing="0" width="100%"  >
                                        <?php
                                        
                                            $companyId=$_POST['compId'];
                                            $companyName= $_POST['companyname'];
                                            $expDate=$_POST['date'];
                                            $trial=$_POST['txtTrialLogin'];
                                            $relogin=$_POST['txtRELogin'];
                                            $student=$_POST['txtStudent'];
                                            $ipAdd=$_POST['txtIPAdd'];
                                            $PEindustry = implode(', ', $_POST['industryPE']);
                                            $MAindustry = implode(', ', $_POST['industryMA']);
                
                                            if($_POST['txtTrialLogin'])
                                            {
                                                    $trial=1;
                                            }
                                            else
                                            {
                                                    $trial=0;
                                            }
                                            if($_POST['txtStudent'])
                                            {
                                                    $student=1;
                                            }
                                            else
                                            {
                                                    $student=0;
                                            }
                                            if($_POST['txtPELogin'])
                                            {
                                                $PElogin=1;
                                            }
                                            else
                                            {
                                                $PElogin=0;
                                            }
                                            if($_POST['txtMALogin'])
                                            {
                                                $MAlogin=1;
                                            }
                                            else
                                            {
                                                $MAlogin=0;
                                            }
                                            if($_POST['txtRELogin'])
                                            {
                                                    $RElogin=1;
                                            }
                                            else
                                            {
                                                    $RElogin=0;
                                            }
                                            if($_POST['txtIPAdd'])
                                            {
                                                    $ipFlag=1;
                                            }
                                            else
                                            {
                                                    $ipFlag=0;
                                            }
                                            
                                            $PEInv=0;
                                            $VCInv=0;
                                            $REInv=0;
                                            $PEIpo=0;
                                            $VCIpo=0;
                                            $PEMa=0;
                                            $VCMa=0;
                                            $PEDir=0;
                                            $CODir=0;
                                            $SPDir=0;
                                            $MaMa=0;
                                            $Inc=0;
                                            $angelInv=0;
                                            $sv=0;
                                            $itech=0;
                                            $ctech=0;
                                            $valInfo=0;

                                            
                                            $PEInvArray=$_POST['PEInv'];
                                            if($_POST['PEInv']){
                                                $PEInv=1;
                                            }else{
                                                $PEInv=0;
                                            }

                                            $VCInvArray=$_POST['VCInv'];
                                            if($_POST['VCInv']){
                                                $VCInv=1;
                                            }else{
                                                $VCInv=0;
                                            }

                                           /* $ReInvArray=$_POST['REInv'];
                                            if($_POST['REInv']){
                                                $REInv=1;
                                            }else{
                                                $REInv=0;
                                           }*/
                                            
                                            $PEIpoArray=$_POST['PEIpo'];
                                            if($_POST['PEIpo']){
                                                $PEIpo=1;
                                            }else{
                                                $PEIpo=0;
                                            }

                                            $VCIpoArray=$_POST['VCIpo'];
                                            if($_POST['VCIpo']){
                                                $VCIpo=1;
                                            }else{
                                                $VCIpo=0;
                                            }
                                            
                                            $PEMaArray=$_POST['PEMa'];
                                            if($_POST['PEMa']){
                                                $PEMa=1;
                                            }else{
                                                $PEMa=0;
                                            }
                                            
                                            $VCMaArray=$_POST['VCMa'];
                                            if($_POST['VCMa']){
                                                $VCMa=1;
                                            }else{
                                                $VCMa=0;
                                            }
                                            
                                            $PEDirArray=$_POST['PEDir'];
                                            if($_POST['PEDir']){
                                                $PEDir=1;
                                            }else{
                                                $PEDir=0;
                                            }
                                            
                                            $CODirArray=$_POST['CODir'];
                                            if($_POST['CODir']){
                                                $CODir=1;
                                            }else{
                                                $CODir=0;
                                            }
                                            
                                            $SPDirArray=$_POST['SPDir'];
                                            if($_POST['SPDir']){
                                                $SPDir=1;
                                            }else{
                                                $SPDir=0;
                                            }
                                            $LPDirArray=$_POST['LPDir'];
                                            if($_POST['LPDir']){
                                                $LPDir=1;
                                            }else{
                                                $LPDir=0;
                                            }
                                            
                                            $MAMAArray=$_POST['MA_MA'];
                                            if($_POST['MA_MA']){
                                                $MaMa=1;
                                            }else{
                                                $MaMa=0;
                                            }
                                            
                                            $IncArray=$_POST['INC'];
                                            if($_POST['INC']){
                                                $Inc=1;
                                            }else{
                                                $Inc=0;
                                            }
                                            
                                            $AngelInvArray=$_POST['AngelInv'];
                                            if($_POST['AngelInv']){
                                                $angelInv=1;
                                            }else{
                                                $angelInv=0;
                                            }

                                            $SVArray=$_POST['SVInv'];
                                            if($_POST['SVInv']){
                                                $sv=1;
                                            }else{
                                                $sv=0;
                                            }
                                            
                                            $IfArray=$_POST['IfTech'];
                                            if($_POST['IfTech']){
                                                $itech=1;
                                            }else{
                                                $itech=0;
                                            }
                                            
                                            $CtArray=$_POST['CTech'];
                                            if($_POST['CTech']){
                                                $ctech=1;
                                            }else{
                                                $ctech=0;
                                            }
                                            $valInfo=$_POST['valInfo'];
                                            if($_POST['valInfo']){
                                                $valInfo=1;
                                            }else{
                                                $valInfo=0;
                                            }
                                            
                                            $mobappArray=$_POST['mobappaccess'];
                                            if($_POST['mobappaccess']){
                                                $mobapp=1;
                                            }else{
                                                $mobapp=0;
                                            }

                                            $MailsArray=$_POST['email'];
                                            $MailsArrayLength= count($MailsArray);
                                            $nameArray=$_POST['Nams'];
                                            $NewMailArray=$_POST['Mails'];
                                            $NewPwd=$_POST['Pwd'];
                                          
                                            $MAMailsArray=$_POST['emailMA'];
                                            $MAMailsArrayLength= count($MAMailsArray);
                                            $MAnameArray=$_POST['NamsMA'];
                                            $MANewMailArray=$_POST['MailsMA'];
                                            $MANewPwd=$_POST['PwdMA'];

                                            //echo "<br>----" .$MAMailsArrayLength;
                                            $REMailsArray=$_POST['emailRE'];
                                            $REMailsArrayLength= count($REMailsArray);
                                            $REnameArray=$_POST['NamsRE'];
                                            $RENewMailArray=$_POST['MailsRE'];
                                            $RENewPwd=$_POST['PwdRE'];
                                            
                                            //Added by JFR-Kutung
                                            $peDevCntArray = $_POST['DevCnt'];
                                            $peExpLmtArray = $_POST['ExpLmt'];
                                            $maDevCntArray = $_POST['DevCntMA'];
                                            $maExpLmtArray = $_POST['ExpLmtMA'];
                                            $reDevCntArray = $_POST['DevCntRE'];
                                            $reExpLmtArray = $_POST['ExpLmtRE'];
                                            $contacts = trim($_POST['contacts']);

                                            $exp_limit=intval($_POST['exp_limit']);
			                                $limit_enable=intval($_POST['limit_enable']);
                                            //echo $contacts;
                                            if($_POST['peonly']==1 && $_POST['vconly']==2  ) { $permission=0; }
                                            else if(!isset($_POST['vconly']) && $_POST['peonly']==1  ) { $permission=1; }
                                            else if(!isset($_POST['peonly']) && $_POST['vconly']==2  ) { $permission=2; }
                        
                                            //	echo "<Br>Companyid - " .$companyId;
                                            //	echo "<Br>Company - " .$companyName;
                                           /* $UpdateCompSql= "Update dealcompanies set DCompanyName='$companyName',ExpiryDate='$expDate',TrialLogin=$trial, PEInv=$PEInv,VCInv=$VCInv,REInv=$REInv,PEIpo=$PEIpo,VCIpo=$VCIpo,
                                            PEMa=$PEMa,VCMa=$VCMa,PEDir=$PEDir,VCDir=$CODir,SPDir=$SPDir,MAMA=$MaMa,Inc=$Inc,AngelInv=$angelInv,SVInv=$sv,IfTech=$itech,CTech=$ctech,
                                            Student=$student,REInv=$RElogin,IPAdd=$ipFlag,poc='$contacts',permission='$permission',peindustries='$PEindustry',maindustries='$MAindustry' where DCompId=$companyId ";*/
                                            $UpdateCompSql= "Update dealcompanies set DCompanyName='$companyName',ExpiryDate='$expDate',TrialLogin=$trial, PEInv=$PEInv,VCInv=$VCInv,REInv=$REInv,PEIpo=$PEIpo,VCIpo=$VCIpo,
                                            PEMa=$PEMa,VCMa=$VCMa,PEDir=$PEDir,VCDir=$CODir,SPDir=$SPDir,MAMA=$MAlogin,Inc=$Inc,AngelInv=$angelInv,SVInv=$sv,IfTech=$itech,CTech=$ctech,valInfo=$valInfo,
                                            Student=$student,REInv=$RElogin,IPAdd=$ipFlag,poc='$contacts',permission='$permission',peindustries='$PEindustry',maindustries='$MAindustry',LPDir=$LPDir, mobile_access=$mobapp,custom_limit_enable=$limit_enable,custom_export_limit=$exp_limit where DCompId=$companyId ";
                                            //echo "<br>--" .$UpdateCompSql;
                                            
                                            if ($rsUpdateComp=mysql_query($UpdateCompSql))
                                            {
                                                
                                            ?>
                                                    <tr bgcolor="a6d39a" style="font-family: Verdana; font-size: 8pt">
                                                    <td> <?php echo $companyName; ?> -- Company Name,Expiry Date change recorded </td> </tr>
                                            <?php
                                            }

                                            // Added by JFR-KUTUNG - Store IP Range 
                                            $sqlDelCompIp = "DELETE FROM `ipAddressKey` WHERE `DCompId`='".$companyId."'";
                                            $resDelCompIp = mysql_query($sqlDelCompIp) or die(mysql_error());

                                            for ($i=0;$i<count($_POST['ipAddress']);$i++){
                                                $ipAddress = $_POST['ipAddress'][$i];
                                                $startRng = $_POST['startRange'][$i];
                                                $endRng = $_POST['endRange'][$i];

                                                //Insert IP
                                                if ($ipAddress!=''){
                                                    $sNo = $valGetMaxSno[0]+1;
                                                    $sqlInsIpRng = "INSERT INTO `ipAddressKey` (`slno`,`DCompId`,`ipAddress`,`StartRange`,`EndRange`) VALUES ('".$sNo."','".$companyId."','".$ipAddress."','".$startRng."','".$endRng."')";
                                                    mysql_query($sqlInsIpRng) or die(mysql_error());
                                                }
                                            }
                                        
                                        // PE login members Update or enable Existing User access PE Login
                                            if($PElogin==1 && $MailsArrayLength > 0){
                                                
                                                for ($i=0;$i<=$MailsArrayLength-1;$i++)
                                                {
                                                    //	echo "<br>Mail id to Update" .$MailsArray[$i];
                                                    //	echo "<Br> Name - " .$nameArray[$i];
                                                    //	echo "<Br>".$i."New Email - ".$NewMailArray[$i]."-------";
                                                    //	echo "New Pwd - ".$NewPwd[$i];
                                                    $mailidtoUpdate = trim($MailsArray[$i]);
                                                    $newEmail= trim($NewMailArray[$i]);

                                                    $newPwd=trim($NewPwd[$i]);
                                                    /*$UpdateMemberSql= "Update dealmembers set EmailId='$newEmail',Name='$nameArray[$i]',
                                                    Passwrd='$newPwd',deviceCount='$peDevCntArray[$i]',exportLimit='$peExpLmtArray[$i]' where Emailid='$mailidtoUpdate' ";*/
                                                    $UpdateMemberSql= "Update dealmembers set EmailId='$newEmail',Name='$nameArray[$i]',
                                                    deviceCount='$peDevCntArray[$i]',exportLimit='$peExpLmtArray[$i]' where Emailid='$mailidtoUpdate' ";
                                                    //echo "<br>--" .$UpdateMemberSql;
                                                    if ($companyrs=mysql_query($UpdateMemberSql))
                                                    {
                                                    ?>
                                                            <tr bgcolor="#FF6699" style="font-family: Verdana; font-size: 8pt">
                                                            <td> <?php echo $MailsArray[$i]; ?> -- Updated (PE Login)</td> </tr>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                            <tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
                                                            <td> <?php echo $MailsArray[$i]; ?> -- Update Failed (PE Login)</td> </tr>
                                                    <?php
                                                    }     
                                                }
                                                
                                            }
                                            /*elseif($PElogin==1 && $MailsArrayLength == 0){
                                              
                                                if($MAMailsArrayLength > 0){
                                                    
                                                    for ($i=0;$i<=$MAMailsArrayLength-1;$i++){
                                                        
                                                        $MailtoInsert = trim($MANewMailArray[$i]);
                                                        $NametoInsert= trim($MAnameArray[$i]);
                                                        $PwdtoInsert= trim($MANewPwd[$i]);
                                                        $deleted=0;
                                                        $insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                            echo '<tr bgcolor="#FF6699" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' - existing member inserted to access PE LOGIN</td> </tr>';

                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }
                                                }elseif($REMailsArrayLength > 0){
                                                   
                                                    for ($i=0;$i<=$REMailsArrayLength-1;$i++){
                                                        
                                                        $MailtoInsert = trim($RENewMailArray[$i]);
                                                        $NametoInsert= trim($REnameArray[$i]);
                                                        $PwdtoInsert= trim($RENewPwd[$i]);
                                                        $deleted=0;
                                                        $insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                            echo '<tr bgcolor="#FF6699" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' - existing member inserted to access PE LOGIN</td> </tr>';

                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }
                                                }else{
                                                    echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td> No member found.</td> </tr>';
                                                }
                                            }*/

                                             // Merger login members Update or enable Existing User access MA Login
                                            
                                            if($MAlogin==1 && $MAMailsArrayLength > 0){
                                                for ($j=0;$j<=$MAMailsArrayLength-1;$j++)
                                                {
                                                    //	echo "<br>Mail id to Update" .$MailsArray[$i];
                                                    //	echo "<Br> Name - " .$nameArray[$i];
                                                    //	echo "<Br>New Email - ".$NewMailArray[$i];
                                                    //	echo "<Br>New Pwd - ".$MANewPwd[$j];
                                                    $MAmailidtoUpdate = trim($MAMailsArray[$j]);
                                                    $MAnewEmail= trim($MANewMailArray[$j]);

                                                    $MAnewPwd=trim($MANewPwd[$j]);
                                                    /*$MAUpdateMemberSql= "Update malogin_members set EmailId='$MAnewEmail',Name='$MAnameArray[$j]',
                                                    Passwrd='$MAnewPwd',deviceCount='$maDevCntArray[$j]',exportLimit='$maExpLmtArray[$j]' where Emailid='$MAmailidtoUpdate' ";*/
                                                    $MAUpdateMemberSql= "Update malogin_members set EmailId='$MAnewEmail',Name='$MAnameArray[$j]',
                                                    deviceCount='$maDevCntArray[$j]',exportLimit='$maExpLmtArray[$j]' where Emailid='$MAmailidtoUpdate' ";
                                                    //echo "<br>--" .$MAUpdateMemberSql;
                                                    if ($MAcompanyrs=mysql_query($MAUpdateMemberSql))
                                                    {
                                                    ?>
                                                            <tr bgcolor="#FFFF00" style="font-family: Verdana; font-size: 8pt">
                                                            <td> <?php echo $MAMailsArray[$j]; ?> -- Updated (Merger Login)</td> </tr>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                            <tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
                                                            <td> <?php echo $MAMailsArray[$j]; ?> -- Update Failed (Merger Login) </td> </tr>
                                                    <?php
                                                    }
                                                }
                                            }
                                            
                                            /*elseif($MAlogin==1 && $MAMailsArrayLength == 0){
                                                if($MailsArrayLength > 0){
                                                    
                                                    for ($j=0;$j<=$MailsArrayLength-1;$j++){
                                                        
                                                        $MailtoInsert = trim($NewMailArray[$j]);
                                                        $NametoInsert= trim($nameArray[$j]);
                                                        $PwdtoInsert= trim($NewPwd[$j]);
                                                        $deleted=0;
                                                        $insMemberSql= "insert into malogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                            echo '<tr bgcolor="#FFFF00" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' - existing member inserted to access MA LOGIN</td> </tr>';

                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }
                                                }elseif($REMailsArrayLength > 0){
                                                    for ($j=0;$j<=$REMailsArrayLength-1;$j++){
                                                        
                                                        $MailtoInsert = trim($RENewMailArray[$j]);
                                                        $NametoInsert= trim($REnameArray[$j]);
                                                        $PwdtoInsert= trim($RENewPwd[$j]);
                                                        $deleted=0;
                                                        $insMemberSql= "insert into malogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                           echo '<tr bgcolor="#FFFF00" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' - existing member inserted to access MA LOGIN</td> </tr>';

                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }
                                                }else{
                                                    echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td> No member found.</td> </tr>';
                                                }
                                            }*/
                                                
                                            // RE login members Update or enable Existing User access RE Login
                                            
                                            if($RElogin==1 && $REMailsArrayLength > 0){
                                                
                                                for ($k=0;$k<=$REMailsArrayLength-1;$k++)
                                                {

                                                    $REmailidtoUpdate = trim($REMailsArray[$k]);
                                                    $REnewEmail= trim($RENewMailArray[$k]);

                                                    $REnewPwd=trim($RENewPwd[$k]);
                                                   /* $REUpdateMemberSql= "Update RElogin_members set EmailId='$REnewEmail',Name='$REnameArray[$k]',
                                                    Passwrd='$REnewPwd',deviceCount='$reDevCntArray[$k]',exportLimit='$reExpLmtArray[$k]' where Emailid='$REmailidtoUpdate' ";*/
                                                     $REUpdateMemberSql= "Update RElogin_members set EmailId='$REnewEmail',Name='$REnameArray[$k]',
                                                    deviceCount='$reDevCntArray[$k]',exportLimit='$reExpLmtArray[$k]' where Emailid='$REmailidtoUpdate' ";
                                                    //echo "<br>--" .$REUpdateMemberSql;
                                                    if ($REcompanyrs=mysql_query($REUpdateMemberSql))
                                                    {
                                                    ?>
                                                            <tr bgcolor="#008000" style="font-family: Verdana; font-size: 8pt">
                                                            <td> <?php echo $REMailsArray[$k]; ?> -- Updated (RE  Login)</td> </tr>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                            <tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
                                                            <td> <?php echo $REMailsArray[$k]; ?> -- Update Failed (RE  Login) </td> </tr>
                                                    <?php
                                                    }
                                                }
                                            }
                                            
                                            /*else if($RElogin==1 && $REMailsArrayLength == 0){
                                                
                                                if($MailsArrayLength > 0){
                                                    
                                                    for ($k=0;$k<=$MailsArrayLength-1;$k++){
                                                        
                                                        $MailtoInsert = trim($NewMailArray[$k]);
                                                        $NametoInsert= trim($nameArray[$k]);
                                                        $PwdtoInsert= trim($NewPwd[$k]);
                                                        $deleted=0;
                                                        $insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                            echo '<tr bgcolor="#008000" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' - existing member inserted to access RE LOGIN</td> </tr>';

                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }
                                                }elseif($MAMailsArrayLength > 0){
                                                   
                                                    for ($k=0;$k<=$MAMailsArrayLength-1;$k++){
                                                        
                                                        $MailtoInsert = trim($MANewMailArray[$k]);
                                                        $NametoInsert= trim($MAnameArray[$k]);
                                                        $PwdtoInsert= trim($MANewPwd[$k]);
                                                        $deleted=0;
                                                        $insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                            echo '<tr bgcolor="#008000" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' - existing member inserted to access RE LOGIN</td> </tr>';

                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }
                                                }else{
                                                    echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td> No member found.</td> </tr>';
                                                }
                                                
                                            }*/
                                            

                                    ?>
                                                         
                                        <?php 
                         
                                            $MailArray=$_POST['Emails'];
                                            $MailArrayLength= count($MailArray);
                                            //echo "<br>--" .$MailArrayLength;
                                            $namArray=$_POST['UNams'];
                                            $PwArray=$_POST['Passwd'];
                   
                                            if($MailArrayLength > 0 && $_POST['type_field']==1)
                                            {
                                                echo '<tr bgcolor="#f7a4be" style="font-family: Verdana; font-size: 10pt"> <td>New Added Member</td></tr>';
                                                for ($i=0;$i <= $MailArrayLength-1;$i++)
                                                {

                                                    $MailtoInsert = trim($MailArray[$i]);
                                                    $NametoInsert= trim($namArray[$i]);
                                                    $PwdtoInsert= md5(trim($PwArray[$i]));
                                                    $deleted=0;
                                                    if((trim($MailtoInsert) !="") && (trim($NametoInsert)!="") && (trim($PwdtoInsert)!=""))
                                                    {
                                                        if($MAlogin==1)
                                                        {
                                                            $insMemberSql= "insert into malogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                            ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                            //echo "<br>Ins MA Lgoin For new-" .$insMemberSql;

                                                            if ($rsMemberinsert = mysql_query($insMemberSql))
                                                            {
                                                                echo '<tr bgcolor="#FFFF00" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' New member inserted for MA LOGIN</td> </tr>';

                                                            }else{
                                                                echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                            }
                                                        }

                                                        if($RElogin==1)
                                                        {
                                                            $insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                            ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                            //echo "<br>Ins RE Login For new-" .$insMemberSql;

                                                            if ($rsMemberinsert = mysql_query($insMemberSql))
                                                            {
                                                                echo '<tr bgcolor="#008000" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' New member inserted for RE LOGIN</td> </tr>';
                                                            }else{
                                                                echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                            }
                                                        }

                                                        if($PElogin==1)
                                                        {
                                                            $insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                            ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                            //echo "<br>Ins PE Login For new-" .$insMemberSql;
                                                            if ($rsMemberinsert = mysql_query($insMemberSql))
                                                            {
                                                                echo '<tr bgcolor="#FF6699" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' New member inserted for PE LOGIN</td> </tr>';
                                                            }else{
                                                                echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                            }

                                                        }
    //
                                   
                                } //if loop for empty row ends
                            } //for i loop ends
                            
                            ?>
                             
                             <br><tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><a href="admin.php">Back to Home</a></td></tr>      
                          <?php
                        } // if array count loop ends
                        else{
                            
                           
                            include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
                            
                            if(isset($_FILES['dealsmemberfilepath'])){
                                
                                if($_FILES['dealsmemberfilepath']['tmp_name']){

                                    if(!$_FILES['dealsmemberfilepath']['error'])
                                    {

                                        $inputFile = $_FILES['dealsmemberfilepath']['tmp_name'];
                                        $inputFilename = $_FILES['dealsmemberfilepath']['name'];
                                        
                                        $extension = strtoupper(pathinfo($inputFilename, PATHINFO_EXTENSION));
                   
                                        if($extension == 'XLS' || $extension == 'XLXS'){

                                            try {
                                                $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                                                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                                $objPHPExcel = $objReader->load($inputFile);
                                            } catch(Exception $e) {
                                                die($e->getMessage());
                                            }

                                            $data = array($objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
                                            $rowcount=0;
                                            if(count($data) <= 0){ ?>
                                                <Br>
                                                <div style="font-family: Verdana; font-size: 8pt">Problem in uploaded Excel as data not in proper format or no row has been added. Please check and uplaod again <a href="uploaddeals.php">Back to Upload</a></td></div>
                                            <?php  
                                                exit();
                                            }
                                            
                                            foreach($data[0] as $da){

                                                if($da['A'] !=''){
                                                    $rowcount++;
                                                }
                                            }
                                            //Get worksheet dimensions
                                            $sheet = $objPHPExcel->getSheet(0); 
                                            $highestRow = $rowcount; 
                                            $highestColumn = 'C';

                                            $rowData = array();
                                            
                                             for ($row = 2; $row <= $highestRow; $row++){ 
                                            //  Read a row of data into an array
                                                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, "", TRUE, TRUE);
                                              
                                                $MailtoInsert = trim($rowData[0][0]);
                                                $NametoInsert= trim($rowData[0][1]);
                                                $PwdtoInsert= md5(trim($rowData[0][2]));
                                                $deleted=0;
                                                if((trim($MailtoInsert) !="") && (trim($NametoInsert)!="") && (trim($PwdtoInsert)!=""))
                                                {
                                                    if($MAlogin==1)
                                                    {
                                                        $insMemberSql= "insert into malogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        //echo "<br>Ins MA Lgoin For new-" .$insMemberSql;

                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                                echo '<tr bgcolor="#FFFF00" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' New member inserted for MA LOGIN</td> </tr>';
                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }

                                                    if($RElogin==1)
                                                    {
                                                        $insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        //echo "<br>Ins RE Login For new-" .$insMemberSql;

                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                                echo '<tr bgcolor="#008000" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' New member inserted for RE LOGIN</td> </tr>';
                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }
                                                    }

                                                    if($PElogin==1)
                                                    {
                                                        $insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                        ($companyId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                                echo '<tr bgcolor="#FF6699" style="font-family: Verdana; font-size: 8pt"> <td>'.$MailtoInsert.' New member inserted for PE LOGIN</td> </tr>';
                                                        }else{
                                                            echo '<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt"> <td>'. mysql_error().'</td> </tr>';
                                                        }

                                                    }
                                                }
                                            } ?>
                                            <br><tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><a href="admin.php">Back to Home</a></td></tr> 
                                            
                                       <?php
                                       exit();
                                       
                                                        }else{ ?>
                                            <div style="font-family: Verdana; font-size: 8pt">Problem in uploaded Excel as data not in proper format or no row has been added. Please check and uplaod again <a href="uploaddeals.php">Back to Upload</a></td></div>
                                       <?php }
                                    }
                                }
                            
                            }   
                            
                            
                            
                        }
                         
                         
                         
                         ?>
			</table>
			</div>


		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
   </form>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>

</body>
</html>
<?php
	//header( 'Location: https://www.ventureintelligence.com/logoff.php?value=P' ) ;

//} // if resgistered loop ends
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>