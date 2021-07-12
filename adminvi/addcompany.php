<style>
    .ui-multiselect-menu.ui-widget.ui-widget-content.ui-corner-all {
        position: absolute;
        overflow: auto;
        display: none;
    }
    
    .selectgroup .ui-icon,
    .ui-helper-reset .ui-icon{
        display: inline-block;
    }
    
    .ui-multiselect-close {
        position: absolute;
        top: 5px;
        right: 3px;
        z-index: 1;
    }
    
    .ui-widget-header .ui-helper-reset {
        padding: 6px;
    }
    
    .ui-helper-reset li {
        display: inline-block;
        padding: 0 6px 0 0;
    }
    
    .ui-multiselect-checkboxes li {
        display: block;
    }
    
    .ui-helper-reset li a {
        font-size: 10px;
    }
    
    .ui-state-default .ui-icon {
        float: right;
        margin: 2px;
    }
    
    .ui-multiselect-checkboxes .ui-corner-all {
        padding: 4px;
        line-height: 28px;
    }
        
    
</style>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
    checkaccess( 'subscribers' );
 //session_save_path("/tmp");
    session_start();
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';
    if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
    {
	//$companyIdforMem = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	$companyIdforMem = $_POST['compId'];
	$companyIdAgainforMem=$_POST['CompIdwhilesubmit'];

	$comp =$_POST['txtaddcompany'];
	$trial=$_POST['txtTrialLogin'];
	if($_POST['txtTrialLogin'])
        {
            $trial=1;
        }
        else
        {
                $trial=0;
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
      //  echo $MAlogin."====".$RElogin;exit();
	if($_POST['txtStudent'])
        {
                $student=1;
        }
        else
        {
            $student=0;
        }
	for ($i=0;$i<=9;$i++)
	{
		$MailArray[i]="";
	}
	$MailArray=$_POST['Mails'];
	$MailArrayLength= count($MailArray);
	//echo "<br>--" .$MailArrayLength;
	$namArray=$_POST['Nams'];
	$PwArray=$_POST['Pwd'];
	if(($companyIdforMem >0) )
	{
            $compName="";
            $expDate="";
            $insMemberSql="";
            $MailtoInsert="";
            $NametoInsert="";
            $PwdtoInsert="";

            echo "<br>Adding for  companyid~~~" .$companyIdforMem;
            $getcompNameSql = "select DCompanyName,ExpiryDate,REInv from dealcompanies where DCompId=$companyIdforMem";
            if ($rsGetComp=mysql_query($getcompNameSql))
            {
                While($myrow=mysql_fetch_array($rsGetComp, MYSQL_BOTH))
                {
                    $compName=$myrow["DCompanyName"];
                    $expDate=$myrow["ExpiryDate"];
                    $relogindbvalue=$myrow["REInv"];
                    if($relogindbvalue==1)
                    {
                        $RElogin=1;
                        $Reloginflagvalue="checked";
                    }
                    else
                    {
                        $RElogin=0;
                        $Reloginflagvalue="";
                    }

                }
            }
	}
	if($companyIdAgainforMem >0)
	{
            echo "<br>Array length---" .$MailArrayLength;
            if($MailArrayLength>0)
            {
                //echo "<br>--";
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
                            ($companyIdAgainforMem,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                            //echo "<br>Ins MA Lgoin For new-" .$insMemberSql;
                            if ($rsMemberinsert = mysql_query($insMemberSql))
                            {
                                echo "---".$MailtoInsert." deal member inserted for MA LOGIN--<br>";
                            }
                        }
                        if($RElogin==1)
                        {
                            $insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                            ($companyIdAgainforMem,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                            echo "<br>Ins RE Lgoin For new-" .$insMemberSql;
                            if ($rsMemberinsert = mysql_query($insMemberSql))
                            {
                                echo "---".$MailtoInsert." deal member inserted for RE LOGIN--<br>";
                            }
                        }
                        if($PElogin==1)
                        {
                            $insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
                            ($companyIdAgainforMem,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                            echo "<br>Ins Memb For existing-" .$insMemberSql;
                            if ($rsMemberinsert = mysql_query($insMemberSql))
                            {
                                echo "---".$MailtoInsert." deal member inserted for PE LOGIN--<br>";
                            }
                        }
//                        if ($rsMemberinsert = mysql_query($insMemberSql))
//                        {
//                        }
                    } //if loop for empty row ends
                } //for i loop ends
            } // if array count loop ends
	}
	elseif((trim($comp)!="") && ($companyIdAgainforMem <=0))
	{
		$compName="";
		$expDate="";

                $PEindustry = implode(', ', $_POST['industryPE']);
                $MAindustry = implode(', ', $_POST['industryMA']);

		$dts =$_POST['date'];
		$ExpiryDate= strtotime($dts);
		$ExpiryDate = date("Y-m-d", $ExpiryDate);
		$DCompId=0;
		$DCompId=rand();
                
                $PEInvArray=$_POST['PEInv'];
                if($_POST['PEInv']){
                    $PEInv = 1;
                }else{
                    $PEInv = 0;
                }

                $VCInvArray=$_POST['VCInv'];
                if($_POST['VCInv']){
                    $VCInv=1;
                }else{
                    $VCInv = 0;
                }
                
                $PEIpoArray=$_POST['PEIpo'];
                if($_POST['PEIpo']){
                    $PEIpo=1;
                }else{
                    $PEIpo = 0;
                }
                
                $VCIpoArray=$_POST['VCIpo'];
                if($_POST['VCIpo']){
                    $VCIpo=1;
                }else{
                    $VCIpo = 0;
                }
                
                $PEMaArray=$_POST['PEMa'];
                if($_POST['PEMa']){
                    $PEMa=1;
                }else{
                    $PEMa = 0;
                }
                
                $VCMaArray=$_POST['VCMa'];
                if($_POST['VCMa']){
                    $VCMa=1;
                }else{
                    $VCMa = 0;
                }
                
                $PEDirArray=$_POST['PEDir'];
                if($_POST['PEDir']){
                    $PEDir=1;
                }else{
                    $PEDir = 0;
                }
                
                $CODirArray=$_POST['CODir'];
                if($_POST['CODir']){
                    $CODir=1;
                }else{
                    $CODir = 0;
                }
                
                $SPDirArray=$_POST['SPDir'];
                if($_POST['SPDir']){
                    $SPDir=1;
                }else{
                    $SPDir = 0;
                }
                 $LPDirArray=$_POST['LPDir'];
                if($_POST['LPDir']){
                    $LPDir=1;
                }else{
                    $LPDir = 0;
                }
                
                $MAMAArray=$_POST['MA_MA'];
                if($_POST['MA_MA']){
                    $MaMa=1;
                }else{
                    $MaMa = 0;
                }
                
                $PE_backArray=$_POST['PE_back'];
                if($_POST['PE_back']){
                    $PE_back = 1;
                    }else{
                    $PE_back = 0;
                }
                
                $VC_backArray=$_POST['VC_back'];
                if($_POST['VC_back']){
                    $VC_back=1;
                }else{
                    $VC_back = 0;
                }
                
                $IncArray=$_POST['INC'];
                if($_POST['INC']){
                    $Inc=1;
                }else{
                    $Inc = 0;
                }
                
                $AngelInvArray=$_POST['AngelInv'];
                if($_POST['AngelInv']){
                    $angelInv=1;
                }else{
                    $angelInv = 0;
                }
                
                $SVArray=$_POST['SVInv'];
                if($_POST['SVInv']){
                    $sv=1;
                }else{
                    $sv = 0;
                }
                
                $IfArray=$_POST['IfTech'];
                if($_POST['IfTech']){
                    $itech=1;
                }else{
                    $itech = 0;
                }
                
                $CtArray=$_POST['CTech'];
                if($_POST['CTech']){
                    $ctech=1;
                }else{
                    $ctech = 0;
                }
                $valInfo=$_POST['valInfo'];
                if($_POST['valInfo']){
                    $valInfo=1;
                }else{
                    $valInfo = 0;
                }
               // echo $valInfo;exit();
                $mobappArray=$_POST['mobappaccess'];
                if($_POST['mobappaccess']){
                    $mobapp=1;
                }else{
                    $mobapp = 0;
                }
                
                $custom_limit_enable=$_POST['limit_enable'];
                if($_POST['limit_enable']){
                    $custom_limit_enable=1;
                }else{
                    $custom_limit_enable = 0;
                }
                
                $custom_export_limit=$_POST['exp_limit'];
                    
                $getcompNameSql = "select DCompId,DCompanyName from dealcompanies where DCompanyName LIKE '%".trim($comp)."%'";
                //echo $getcompNameSql;exit();
                $rscom = mysql_query($getcompNameSql);
                $companynum_rows = mysql_num_rows($rscom);
                
                if($companynum_rows > 0){  
                    
                    $companynum_res = mysql_fetch_row($rscom);
                    $link = "companyedit.php?value=".$companynum_res[0];
                ?>
                    
                   <div style="font-family: Verdana; font-size: 8pt;margin-top: 15px;"><?php echo $comp; ?>  already Exists . <a href="<?php echo $link;?>">Click here to edit this company</a></td>
                   or <tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><a href="admin.php">Back to Home</a></td></tr>   </div> 
               <?php  
               
               exit();
                }else{
                
                    $insSql= "insert into dealcompanies(DCompId,DCompanyName,Deleted,ExpiryDate,TrialLogin,Student,REInv,PEInv,VCInv,PEIpo,VCIpo,PEMa,VCMa,PEDir,VCDir,SPDir,MAMA,
                    Inc,AngelInv,SVInv,IfTech,CTech,valInfo,PE_backDir,VC_backDir,peindustries,maindustries,LPDir,mobile_access,custom_limit_enable,custom_export_limit) values ($DCompId,'$comp',0,'$ExpiryDate',$trial,$student,$RElogin,$PEInv,$VCInv,$PEIpo,$VCIpo,$PEMa,$VCMa,
                    $PEDir,$CODir,$SPDir,$MAlogin,$Inc,$angelInv,$sv,$itech,$ctech,$valInfo,$PE_back,$VC_back,'$PEindustry','$MAindustry',$LPDir,$mobapp,$custom_limit_enable,'$custom_export_limit')";
               
                    //echo "<Br> Insert company-" .$insSql;exit();
                    if ($rsinsert = mysql_query($insSql))
                    {
                        if($MailArrayLength > 0 && $_POST['type_field']==1)
                        {
                            for ($i=0;$i < $MailArrayLength;$i++)
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
                                        ($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                        echo "<br>Ins MA Lgoin For new-" .$insMemberSql;

                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                        {
                                                echo "---".$MailtoInsert." deal member inserted for MA LOGIN--<br>";
                                        }else{
                                            echo '<div bgcolor="red" style="font-family: Verdana; font-size: 8pt"> '. mysql_error().' </div>';
                                        }
                                    }
                                    
                                    if($RElogin==1)
                                    {
                                        $insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                        ($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                        //echo "<br>Ins RE Login For new-" .$insMemberSql;

                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                        {
                                                echo "---".$MailtoInsert." deal member inserted for RE LOGIN--<br>";
                                        }else{
                                            echo '<div bgcolor="red" style="font-family: Verdana; font-size: 8pt"> '. mysql_error().' </div>';
                                        }
                                    }
                                    
                                    if($PElogin==1)
                                    {
                                        $insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
                                        ($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                        //echo "<br>Ins RE Login For new-" .$insMemberSql;
                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                        {
                                                echo "---".$MailtoInsert." deal member inserted for PE LOGIN--<br>";
                                        }else{
                                            echo '<div bgcolor="red" style="font-family: Verdana; font-size: 8pt"> '. mysql_error().' </div>';
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
                                              
                                                $MailtoInsert = trim($rowData[0][1]);
                                                $NametoInsert= trim($rowData[0][0]);
                                                $PwdtoInsert= md5(trim($rowData[0][2]));
                                                
                                                $deleted=0;
                                                if((trim($MailtoInsert) !="") && (trim($NametoInsert)!="") && (trim($PwdtoInsert)!=""))
                                                {
                                                    if($MAlogin==1)
                                                    {
                                                        $insMemberSql= "insert into malogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                        ($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        echo "<br>Ins MA Lgoin For new-" .$insMemberSql;

                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                                echo "---".$MailtoInsert." deal member inserted for MA LOGIN--<br>";
                                                        }else{
                                                            echo '<div bgcolor="red" style="font-family: Verdana; font-size: 8pt"> '. mysql_error().' </div>';
                                                        }
                                                    }

                                                    if($RElogin==1)
                                                    {
                                                        $insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                        ($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        echo "<br>Ins RE Login For new-" .$insMemberSql;

                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                                echo "---".$MailtoInsert." deal member inserted for RE LOGIN--<br>";
                                                        }else{
                                                            echo '<div bgcolor="red" style="font-family: Verdana; font-size: 8pt"> '. mysql_error().' </div>';
                                                        }
                                                    }

                                                    if($PElogin==1)
                                                    {
                                                        $insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
                                                        ($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
                                                        if ($rsMemberinsert = mysql_query($insMemberSql))
                                                        {
                                                                echo "---".$MailtoInsert." deal member inserted for PE LOGIN--<br>";
                                                        }else{
                                                            echo '<div bgcolor="red" style="font-family: Verdana; font-size: 8pt"> '. mysql_error().' </div>';
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
                    } 
            } // record set loop ends
	} //elseif loop ends
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Venture Intelligence</title>
        <!-- calendar stylesheet -->
        
        <script src="../js/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/jquery-ui.css">
        <script src="../js/jquery-ui.js"></script>
        <script src="../js/jquery.validate.min.js"></script>
        <link href="../css/vistyle.css" rel="stylesheet" type="text/css">
        <link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
        <script type="text/javascript" src="js/jquery.multiselect.js"></script> 
        
        <style>
            .error{
                color:red;
                padding: 0px 0px 0px 10px;
            }
        </style>
        <SCRIPT LANGUAGE="JavaScript">
    
            function ExporttoExel()
            {
                //alert(document.companydelete.txtTrialLogin.checked);
                //alert(document.companydelete.txtStudent.checked);
                if(document.companydelete.txtStudent.checked==true)
                {
                    document.companydelete.txtStudent.checked=false;
                }
            }

            function Student()
            {
                if(document.companydelete.txtTrialLogin.checked==true)
                {
                    document.companydelete.txtTrialLogin.checked=false;
                }
            }
        
            $(document).ready(function() {    
                
                $('#type_field').change(function(event) {
                    
                    if($(this).val() == 1){
                        
                        $('.ip-file').val(''); 
                        $('.acc-sections').hide();
                        $('.form-fields').show();
                        
                    }else{
                        
                        $('input[type="text"][class="reset valid"]').val(''); 
                        $('.form-fields').hide();
                        $('.acc-sections').show();
                    }
                    //acc-section
                });
   
                $('#vconly').click(function(event) {  //on click 

                    if(this.checked) { // check select status
                        
                        $('#loginerror').text('');
                        $('#allpe').prop( "checked", true );
                        $('.vconly').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                    }else{

                        if ($('#peonly').prop('checked')==true){ 
                            $('#allpe').prop( "checked", true );
                        }else{
                             $('#allpe').prop( "checked", false );
                        }

                        $('.vconly').each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                        });         
                    }
                });
        
                $('.vconly').click(function(event) {  //on click 

                    var vctotal =  $('.vconly').length;
                    var vccount=0;
                    $('.vconly').each(function() { //loop through each checkbox
                       if(this.checked==true) { vccount++; }        
                    });

                    if(vccount==0){

                        if ($('#peonly').prop('checked')==true){ 
                            
                            $('#allpe').prop( "checked", true );
                        }else{
                             $('#allpe').prop( "checked", false );
                        }
                        $('#vconly').prop( "checked", false );
                    }

                    if( vccount>0 ||  (vctotal == vccount) ){
                        $('#loginerror').text('');
                        $('#vconly').prop( "checked", true );
                        $('#allpe').prop( "checked", true );
                    }

                }); 
             
                $('#peonly').click(function(event) {  //on click 

                    if(this.checked) { // check select status

                        $('#loginerror').text('');
                        $('#allpe').prop( "checked", true );
                        $('.peonly').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                    }else{

                        if ($('#vconly').prop('checked')==true){ 
                            $('#allpe').prop( "checked", true );
                        }else{
                             $('#allpe').prop( "checked", false );
                        }

                        $('.peonly').each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                        });         
                    }
                });
        
                $('.peonly').click(function(event) {  //on click 

                    var petotal =  $('.peonly').length;
                    var pecount=0;
                    $('.peonly').each(function() { //loop through each checkbox
                       if(this.checked==true) { pecount++; }        
                    });

                    if(pecount==0){

                        $('#peonly').prop( "checked", false );
                        $('#allpe').prop( "checked", false );

                        if ($('#vconly').prop('checked')==true){ 
                            $('#allpe').prop( "checked", true );
                        }else{
                             $('#allpe').prop( "checked", false );
                        }
                    }

                    if( pecount>0 ||  (petotal == pecount) ){
                        $('#loginerror').text('');
                       $('#peonly').prop( "checked", true );
                       $('#allpe').prop( "checked", true );
                    }
                }); 
        
                $('#allpe').click(function(event) {  //on click 

                    if(this.checked) { // check select status
                        $('#loginerror').text('');
                        $('#peonly').prop( "checked", true );
                        $('#vconly').prop( "checked", true );
                        $('.peonly').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                        $('.vconly').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                    }else{
                        $('#peonly').prop( "checked", false );
                        $('#vconly').prop( "checked", false );
                        $('.peonly').each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                        });    
                        $('.vconly').each(function() { //loop through each checkbox
                            this.checked = false;  //select all checkboxes with class "checkbox1"               
                        });
                    }
                });
        
        
                $('.maonly').click(function(event) {  //on click 

                   if($(this).prop('checked')==false){

                       $('#allma').prop( "checked", false );
                   }else{
                       $('#loginerror').text('');
                       $('#allma').prop( "checked", true );
                   }

                }); 

                $('#allma').click(function(event) {

                   if($(this).prop('checked') == false){

                       $('.maonly').prop( "checked", false );
                   }else{
                       $('#loginerror').text('');
                       $('.maonly').prop( "checked", true );
                   }
                });
                
                $('#allre').click(function(event) {

                   if($(this).prop('checked') == true){

                       $('#loginerror').text('');
                   }
                });
             
            });

            $(document).ready(function () {
              // Initialize form validation on the registration form.
              // It has the name attribute "registration"
              
                $("form[name='addcompany']").validate({
                  // Specify validation rules
                  
                    rules: {
                      // The key name on the left side is the name attribute
                      // of an input field. Validation rules are defined
                      // on the right side
                        txtaddcompany: "required",
                        date: "required"

                    },
                    messages: {
                      txtaddcompany: "Please enter company name.",
                      date: "Please select date."
                      
                    },
                    debug: true,
                    // Make sure the form is submitted to the destination defined
                    // in the "action" attribute of the form when valid
                    submitHandler: function(form) {
                        
                        
                        $('#loginerror,#industryerr-pe,#industryerr-ma').text('');
                        if($('#sltindustrype').val()== null){
                         
                            $('#industryerr-pe').text('Please select industry for PE.');
                            $('html, body').animate({
                                scrollTop: $('#industryerr-pe').offset().top
                                }, 1000);
                            return false;
                        }
                       
                        if($('#sltindustryma').val()== null){

                            $('#industryerr-ma').text('Please select industry for MA.');
                            $('html, body').animate({
                                scrollTop: $('#industryerr-ma').offset().top
                                }, 1000);
                            return false;
                        }
                        
                        if($("input.logincheckbox:checked").length <= 0){
                             $('#loginerror').text('Please give access for at least one login either for PE or MA or RE Login.');
                             $('html, body').animate({
                                scrollTop: $('#loginerror').offset().top
                                }, 1000);
                            return false;
                        }
                        
                        if($('#type_field option:selected').val()==1){
                            
                            var mail = []; var name=[]; var pass=[];
                        
                            $("input[name='Mails[]']").each(function() {

                                var value = $(this).val();
                                if (value!='') {
                                    $('#nameGroup').text('');
                                    mail.push(value);
                                }else{
                                    mail.push('');
                                }
                            });
                            $("input[name='Nams[]']").each(function() {

                                var value = $(this).val();
                                if (value!='') {
                                    $('#nameGroup').text('');
                                    name.push(value);
                                }else{
                                    $('#nameGroup').text('');
                                    name.push('');
                                }
                            });

                            $("input[name='Pwd[]']").each(function() {

                                var value = $(this).val();
                                if (value!='') {
                                    pass.push(value);
                                }else{
                                    pass.push('');
                                }
                            });

                            /*console.log(mail);
                            console.log(name);
                            console.log(pass);*/
                            
                            if(mail.some(function(i) { return i != ''; })==0 && name.some(function(i) { return i != ''; })==0 && pass.some(function(i) { return i != ''; })==0){
                                $('#nameGroup').text('Please add atleast one member from given fields or by upload xls/xlsx file.');
                                $('html, body').animate({
                                scrollTop: $('#nameGroup').offset().top
                                }, 1000);
                                return false;
                            }else{

                                for(var i=0;i < mail.length; i++){

                                    if(mail[i] !=''){

                                        if(name[i] =='' || pass[i] ==''){
                                            $('#nameGroup').text('All the three respective fields are compulsory.');
                                            $('html, body').animate({
                                            scrollTop: $('#nameGroup').offset().top
                                            }, 1000);
                                            return false;
                                        }
                                    }else{

                                        if(name[i] !='' || pass[i] !=''){
                                            $('#nameGroup').text('All the three respective fields are compulsory.');
                                            $('html, body').animate({
                                            scrollTop: $('#nameGroup').offset().top
                                            }, 1000);
                                            return false;
                                        }
                                    }
                                }

                            }
                        
                        }else{
                            
                            var fileName = $(".ip-file").val();
                            
                            if(fileName) { // returns true if the string is not empty
                                
                                var extension = fileName.substr( (fileName.lastIndexOf('.') +1) );
                                
                                if(extension.trim() != 'xls' && extension.trim() != 'xlsx' && extension.trim() != 'XLSX' && extension.trim() != 'XLS'){
                                   
                                    $('#nameGroup').text('Please select the xls / xlsx file to upload');
                                    $('html, body').animate({
                                    scrollTop: $('#nameGroup').offset().top
                                    }, 1000);
                                    return false;
                                }else{
                                    
                                    $('#nameGroup').text('');
                                    return true;
                                }
                                
                            } else { // no file was selected
                                $('#nameGroup').text('Please select the xls / xlsx file to upload');
                                $('html, body').animate({
                                scrollTop: $('#nameGroup').offset().top
                                }, 1000);
                                return false;
                            }
                        }
                        
                      
                      form.submit();
                    }
                });
                
                
            });
    </SCRIPT>
</head>
<body>
        <form name="addcompany"  enctype="multipart/form-data" method="post" action="addcompany.php" >
            <div id="containerproductproducts">
            <!-- Starting Left Panel -->
            <?php include_once 'leftpanel.php'; ?>
            <!-- Ending Left Panel -->
            <!-- Starting Work Area -->

                <div style="background-color:#FFF;width:570px; float:right; ">
                    <div style="width:565px; float:left; padding-left:2px;">
                        <div style=" width:565px;">
                            <div id="maintextpro">
                                <div id="headingtextpro">
                                    <h3 style="margin-bottom:20px;">Add New Company</h3>
                                    <label style="margin-right:40px;">Company</label>
                                    <img src="../images/arrow.gif" />
                                    <input type=text name="txtaddcompany" id="txtaddcompany" size="30" value="<?php echo $compName; ?>"> <br /><br />
                                    <label style="margin-right:30px;">Expiry Date</label>
                                    <img src="../images/arrow.gif" />
                                    <input type="text" name="date" value="<?php echo $expDate !='' ? $expDate:$expDate; ?>" size="15" placeholder="yyyy-mm-dd" id="fromdate"><Br /><Br />
                                    <input type="hidden" name="CompIdforMembers" value="<?php echo $companyIdforMem; ?>" >
                                    <input type="hidden" name="CompIdwhilesubmit" value="<?php echo $companyIdforMem; ?>" >
                                    
                                     <div class="selectgroup">
                                        <label style="margin-right:30px;">Select Inudstry for PE</label>
                                        <img src="../images/arrow.gif" />
                                        <select name="industryPE[]" multiple="multiple"  id="sltindustrype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                        <?php
                                       
                                            $industrysql_search="select industryid,industry from industry where industryid !=15 order by industry";
                                            
                                            if ($industryrs = mysql_query($industrysql_search))
                                            {
                                             $ind_cnt = mysql_num_rows($industryrs);
                                            }

                                            if($ind_cnt>0)
                                            {
                                                     While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                                    {
                                                        $id = $myrow[0];
                                                        $name = $myrow[1];
                                                        if(count($industry)>0)
                                                        {
                                                            $indSel = (in_array($id,$industry))?'selected':''; 
                                                            echo "<OPTION id='peindustry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                                        }
                                                        else
                                                        {
                                                            $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                                            echo "<OPTION id='peindustry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                                        }

                                                    }
                                                    mysql_free_result($industryrs);
                                            }
                                        ?>
                                        </select>
                                        <p id="industryerr-pe" style="color: red;margin-left:160px;"></p>
                                     </div><br>
                                     
                                     <div class="selectgroup">
                                        <label style="margin-right:30px;">Select Inudstry for MA</label>
                                        <img src="../images/arrow.gif" />
                                        <select name="industryMA[]" multiple="multiple"  id="sltindustryma" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                        <?php
                                       
                                            $industrysql_search="select industryid,industry from industry where industryid !=15 order by industry";
                                            
                                            if ($industryrs = mysql_query($industrysql_search))
                                            {
                                             $ind_cnt = mysql_num_rows($industryrs);
                                            }

                                            if($ind_cnt>0)
                                            {
                                                     While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                                    {
                                                        $id = $myrow[0];
                                                        $name = $myrow[1];
                                                        if(count($industry)>0)
                                                        {
                                                            $indSel = (in_array($id,$industry))?'selected':''; 
                                                            echo "<OPTION id='maindustry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                                        }
                                                        else
                                                        {
                                                            $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                                            echo "<OPTION id='maindustry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                                        }

                                                    }
                                                    mysql_free_result($industryrs);
                                            }
                                        ?>
                                        </select>
                                        <p id="industryerr-ma" style="color: red;margin-left:160px;"></p>
                                     </div>
                                     
                                    <p id="loginerror" style="color: red;"></p>
                                    <input type=checkbox name="txtPELogin" id="allpe" class="logincheckbox" value="1"> PE Login
                                    <input type="checkbox" value="1" name="vconly" id="vconly"> VC-Login
                                    <input type=checkbox name="txtMALogin" id="allma" class="logincheckbox" value="1"> Merger & Acquistion Login 
                                    <input type=checkbox name="txtRELogin" id="allre" <?php echo $Reloginflagvalue; ?> class="logincheckbox" value="1"> RE Login
                                    <input type=checkbox name="txtTrialLogin"  onclick="ExporttoExel()"> Export 
                                    <input type=checkbox name="txtStudent"  onclick="Student()">Student

                                    <br /><br />
                                    
                                   
                                    <div style="width: 542px; padding: 0px 0px 5px 0px;overflow-y: hidden;">
                                        <!-- <input type="checkbox" value="1" name="peonly" id="peonly" > <label for="peonly"><strong>PE-Only</strong></label> 
                                        <input type="checkbox" value="2" name="vconly" id="vconly"> <label for="vconly"><strong>VC-Only</strong></label>  -->
                                        <table border="1" cellpadding="2" cellspacing="0" width="80%" style="margin-top: 2%;"  >
                                       
                                            <tr style="font-family: Verdana; font-size: 8pt">
						<th>PE-Inv</th>
						<th>VC-Inv</th>
					<!--	<th>RE</th> -->
						<th>PE-IPO</th>
						<th>VC-IPO</th>
						<th>PE-M&A</th>
						<th>VC-M&A</th>
						<th>PE-Dir </th>
						<th>VC-Dir</th>
						<th>SP-Dir</th>
                        <th>LP-Dir</th>
						<!-- <th>PE-back</th>
						<th>VC-back</th>
						<th>MA-MA</th> -->
						<th>Inc</th>
						<th>Angel-<Br />Inv</th>
						<th>SV-<Br /> Inv</th>
						<th>If-<br />Tech</th>
						<th>CTech</th>
                        <th>W/0 val.</th>

                                            </tr>

                                            <tr>
                                                <td align=center><input name="PEInv" class="peonly" type="checkbox" value="1" <?php echo $PEInv; ?>></td>
                                                <td align=center><input name="VCInv" class="vconly" type="checkbox" value="1"<?php echo $VCInv; ?> ></td>
                                                <!--<td align=center><input name="RE" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $REInv; ?> ></td>-->
                                                <td align=center><input name="PEIpo" class="peonly" type="checkbox" value="1" <?php echo $PEIpo; ?> ></td>
                                                <td align=center><input name="VCIpo" class="vconly" type="checkbox" value="1" <?php echo $VCIpo; ?> ></td>
                                                <td align=center><input name="PEMa" class="peonly" type="checkbox" value="1" <?php echo $PEMa; ?> ></td>
                                                <td align=center><input name="VCMa" class="vconly" type="checkbox" value="1" <?php echo $VCMa; ?> ></td>
                                                <td align=center><input name="PEDir" class="peonly" type="checkbox" value="1" <?php echo $PEDir; ?> ></td>
                                                <td align=center><input name="CODir" class="vconly" type="checkbox" value="1" <?php echo $VCDir; ?> ></td>
                                                <td align=center><input name="SPDir" type="checkbox" value="1" <?php echo $SPDir; ?> ></td>
                                                <td align=center><input name="LPDir" type="checkbox" value="1" <?php echo $LPDir; ?> ></td>

                                                <!-- <td align=center><input name="PE_back" type="checkbox" value="1" <?php echo $PE_back; ?> ></td>
                                                <td align=center><input name="VC_back" type="checkbox" value="1" <?php echo $VC_back; ?> ></td>
                                                <td align=center><input name="MA_MA" class="maonly" type="checkbox" value="1" <?php echo $Ma_Ma; ?> ></td> -->
                                                <td align=center><input name="INC" class="vconly" type="checkbox" value="1" <?php echo $inc; ?> ></td>
                                                <td align=center><input name="AngelInv" class="vconly" type="checkbox" value="1" <?php echo $angelInv; ?> ></td>
                                                <td align=center><input name="SVInv" class="vconly" type="checkbox" value="1" <?php echo $sv; ?> ></td>
                                                <td align=center><input name="IfTech" class="peonly" type="checkbox" value="1" <?php echo $itech; ?> ></td>
                                                <td align=center><input name="CTech" class="peonly" type="checkbox" value="1" <?php echo $ctech; ?> ></td>
                                                <td align=center><input name="valInfo" class="peonly" type="checkbox" value="1" <?php echo $valInfo; ?> ></td>

                                            </tr> 
                                        </table>
                                        
                                        <p id="nameGroup" style="color: red;"></p>

                                         <input type=checkbox name="mobappaccess" id="applogin" class="applogincheckbox" value="1" <?php echo $mobapp; ?>> Mobile App access
                                            
                                         <div class="row" style="width: 300px;">
                                            <h2>Custom Export Option</h2>
                                            <input type="checkbox" id="limit_enable" name="limit_enable" value="1" <?php echo $custom_limit_enable; ?>><b>Enable</b><br><br>
                                            <b>Export Limit</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="exp_limit" id="exp_limit" value="<?php echo $custom_export_limit; ?>"><br><br>
                                        </div>
                                       
                                         <div style="margin-bottom: 15px;">
                                            <span style="font-size: 14px;font-weight:bold;">Add Members : </span> <Br />
                                        </div>
                                        
                                        <div class="ftype-wrapper comp_div" style="margin-bottom: 10px;">
                                           <div class="f-type type-title" style="width:150px;">
                                               <div class="filter-value">
                                                   <span class="filter-label" style ="float: left;padding: 5px 10px 0px 10px;"><b>By</b></span>
                                                   <select name="type_field" id="type_field" style="background-color: #ffffff;border: 1px solid #DED9CE;float:left;">
                                                       <option value="1">Form fields</option>
                                                       <option value="2">import</option>
                                                   </select>
                                               </div>
                                           </div>
                                        </div>
                                       
                                        <div class="acc-sections" style="display:none;margin-top:30px;">
                                            <div class="accordian active">
                                                <h3 class="acc-title"><span>Upload Members</span></h3>
                                                <div class="acc-content">
                                                    <p>Upload and .xls file through the window:</p>
                                                    <div class="upload-sec">
                                                        <input type="file" name="dealsmemberfilepath" class="ip-file">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        
                                        <table border="1" align=left cellpadding="2" cellspacing="0" width="70%" class="form-fields" >
                                            <tr><p id="field-error"></p></tr>
                                            <tr><span class="form-fields" style="font-size: 12px; color: #383838; margin-bottom: 5px;">(Note: All fields are manadatory. Please provide Email, Name, Pasword resp. )</span></tr>
                                            <tr style="font-family: Verdana; font-size: 8pt">
                                                <th> Email</th>
                                                <th >Name</th>
                                                <th>Password</th>
                                            </tr>
                                                 <?php
                                                 for ($counter = 0; $counter <= 9; $counter += 1)
                                                 {
                                                 ?>
                                                     <tr>
                                                        <td><input type="text" name="Mails[]"  value="" class="reset"> </td>
                                                        <td><input type="text" name="Nams[]" value="" class="reset"></td>
                                                        <td><input type="text" name="Pwd[]" value="" class="reset"></td>
                                                     </tr>
                                                 <?php
                                                 }
                                                 ?>
                                            <tr></tr>
                                        </table><br>
                                        <span style="float:right" class="one"><br /><input type="submit"  value="Add" name="compadd" ></span>
                                </div>

                            </div><!-- end of headingtextpro-->
                        </div> <!-- end of maintext pro-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Ending Work Area -->

        <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
       </form>

        
            
        <script type="text/javascript">
        
            $(function(){
                
            $("#sltindustrype").multiselect();
            $("#sltindustryma").multiselect();
                $( "#fromdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
            })
        </script>
        </script>
        <script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
        <script type="text/javascript">
         _uacct = "UA-1492351-1";
         urchinTracker();
        </script>
    </body>
</html>

<?php

} // if resgistered loop ends
else {
	header( 'Location:' . BASE_URL . 'admin.php' );
}
?>