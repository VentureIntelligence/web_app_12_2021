<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
  session_save_path("/tmp");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{
	//	echo "<br>1--";
	$companyIdtoEdit = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	$trialFlag="";
	$getCompNameSql ="Select DCompanyName,ExpiryDate,TrialLogin,Student,REInv,IPAdd,poc from dealcompanies where DCompId=$companyIdtoEdit ";
	if($rsgetname =mysql_query($getCompNameSql))
	{
	//	echo "<br>2--";

		While($myrow=mysql_fetch_array($rsgetname, MYSQL_BOTH))
		{
	//		echo "<br>3--";
			$CompanyName=$myrow["DCompanyName"];
			$ExpDate=$myrow["ExpiryDate"];
			$trialLoginFlag=$myrow["TrialLogin"];
			$studentLoginFlag=$myrow["Student"];
			$reloginFlag=$myrow["REInv"];
			$IpAddFlag=$myrow["IPAdd"];
                        $poContact = $myrow["poc"];
                        if ($poContact == '')
                            $poContact = 'info@ventureintelligence.com';
			//echo "<br>--" .$studentLoginFlag;
			if($trialLoginFlag==1)
			{
	//		//	echo "<br>4--";
				$trialFlag="checked";
			}
			if($studentLoginFlag==1)
			{
				$studentFlag="checked";
				//echo "<Br>***".$studentFlag;
			}
			if($reloginFlag==1)
			{
				$reflag="checked";
				//echo "<Br>***".$studentFlag;
			}
			if($IpAddFlag==1)
			{
				$ipflag="checked";
				//echo "<Br>***".$studentFlag;
			}
		}
	}
        
        //Get IP Address - ADDED BY JFR-KUTUNG
        $sqlSelIp = "SELECT ipAddress,StartRange,EndRange FROM ipAddressKey WHERE DCompId='$companyIdtoEdit'";
        $ipContent = '';
        $ipCount = 0;
        if($rsgetip = mysql_query($sqlSelIp)){
            While($myIp=mysql_fetch_array($rsgetip, MYSQL_BOTH)){
                $usrIp = $myIp['ipAddress'];
                $usrsRng = $myIp['StartRange'];
                $usreRng = $myIp['EndRange'];
                $ipCount++;
                
                if ($ipCount==1){
                    $ipContent.='
                        <p id="ipPr'.$ipCount.'">
                            <b>IP Range</b>
                            <br>
                            <input type="text" name="ipAddress[]" placeholder="IP Address" value="'.$usrIp.'">
                            &nbsp;
                            <input type="text" name="startRange[]" placeholder="Start Range" size="7" value="'.$usrsRng.'">
                            &nbsp;
                            <input type="text" name="endRange[]" placeholder="End Range" size="7" value="'.$usreRng.'">
                            &nbsp;
                            <input type="button" name="addMore" id="addMore" value="Add More IP Range">
                        </p>';
                }else{
                    $ipContent.='
                        <p id="ipPr'.$ipCount.'">
                            <input type="text" name="ipAddress[]" placeholder="IP Address" value="'.$usrIp.'">
                            &nbsp;
                            <input type="text" name="startRange[]" placeholder="Start Range" size="7" value="'.$usrsRng.'">
                            &nbsp;
                            <input type="text" name="endRange[]" placeholder="End Range" size="7" value="'.$usreRng.'">
                        </p>';
                    
                    
                }
                
            }
        }
        
        if ($ipContent==''){
                $ipContent.='
                    <p>
                            <b>IP Range</b>
                            <br>
                            <input type="text" name="ipAddress[]" placeholder="IP Address" value="">
                            &nbsp;
                            <input type="text" name="startRange[]" placeholder="Start Range" size="7" value="">
                            &nbsp;
                            <input type="text" name="endRange[]" placeholder="End Range" size="7" value="">
                            &nbsp;
                            <input type="button" name="addMore" id="addMore" value="Add">
                        </p>';
            }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="calendar-win2k-cold-1.css" title="win2k-cold-1" />

	<style type="text/css">@import url(calendar-win2k-1.css);</style>

  <!-- main calendar program -->
  <script type="text/javascript" src="calendar.js"></script>

  <!-- language for the calendar -->
  <script type="text/javascript" src="lang/calendar-en.js"></script>

  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script type="text/javascript" src="calendar-setup.js"></script>
  <script type="text/javascript" src="../dealsnew/js/jquery-1.8.2.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
function deleteMembers(companyId){   
    
    var chk;
    var chk1;
    var chk2;
    var DelEmailId = new Array();
    var MADelEmailId = new Array();
    var REDelEmailId = new Array();
    
    chk = $('[name="DelEmailId[]"]:checked').length;
    chk1 = $('[name="MADelEmailId[]"]:checked').length;
    chk2 = $('[name="REDelEmailId[]"]:checked').length;
    
    $('input[name="DelEmailId[]"]:checked').each(function() {
        
        DelEmailId.push(this.value);
    });
    $('input[name="MADelEmailId[]"]:checked').each(function() {
        
        MADelEmailId.push(this.value);
    });
    $('input[name="REDelEmailId[]"]:checked').each(function() {
        
        REDelEmailId.push(this.value);
    });
    
    if ((chk > 0) || (chk1 > 0) || (chk2 > 0))
    {
                
        var formData= new Array();
        formData.push({ name: 'DelEmailId', value: DelEmailId },{ name: 'MADelEmailId', value: MADelEmailId },{ name: 'REDelEmailId', value: REDelEmailId });
        $.ajax({

            url: 'deletemembers.php',
            type: "POST",
            data: formData,
            dataType:"json",
            success: function(data) {
                
               // window.location = 'https://www.ventureintelligence.com/adminvi/companyedit.php?value=1015268522';
                 window.location = '<?php echo GLOBAL_BASE_URL; ?>adminvi/companyedit.php?value='+companyId;
                //console.log(data.length);   
                if(data.length > 0){

                    alert("Users Deleted Successfully");
                }else{
                    alert("User Deleted Successfully");
                }
                
//                 $.each(data ,function(field,error){
//                    console.log(error);
//                });
            }
        });
            
    }
    else{
        
        alert("Pls select one or more to delete");
        return false;
    }
    
    
    
    
}
function ExporttoExel()
{
	if(document.companyedit.txtStudent.checked==true)
	{
		document.companyedit.txtStudent.checked=false;
	}
}

function Student()
{
	/*if(document.companyedit.txtTrialLogin.checked==true)
	{
		document.companyedit.txtTrialLogin.checked=false;
	}*/
        
        //ADDED BY JFR-KUTUNG (For student IP Restriction is to be applied)
        if (document.companyedit.txtStudent.checked==true){
            document.companyedit.txtIPAdd.checked=true;
        }
            
}
 //ADDED BY JFR-KUTUNG (For student IP Restriction is to be applied)
function IPAdd(){
    if (document.companyedit.txtIPAdd.checked==false){
            document.companyedit.txtStudent.checked=false;
        }
}

$(document).ready(function(){
    $('#addMore').click(function(){
        var ipNum = $("#ipCount").val();
        ipNum = (ipNum * 1) + 1;
        var htmlpr = '<p id="ipPr'+ipNum+'"><input type="text" name="ipAddress[]" placeholder="IP Address" value="">&nbsp;<input type="text" name="startRange[]" placeholder="Start Range" size="7" value="">&nbsp;<input type="text" name="endRange[]" placeholder="End Range" size="7" value="">&nbsp;<img src="../dealsnew/images/cross.gif" onclick="removeip('+ ipNum +')"></p>';
        $("#ipCount").val(ipNum); 
        $("#IpRnglst").append(htmlpr);
    });
});

function removeip(idval){
    var temp = '#ipPr'+idval;
    $(temp).html('');
    $(temp).remove();
    $("#ipCount").val(idval-1);
}



function updateMembers()
{
	//alert("99999999999999999");
	document.companyedit.action="updatemembers.php";
	document.companyedit.submit();
}

function AddMembers()
{
	//alert("99999999999999999");
	document.companyedit.action="addcompany.php";
	document.companyedit.submit();
}

function resetExpLimit(){
    var resValue = document.getElementById('resetExp').value;
    if (resValue!=''){
        if (confirm('Are you sure to reset the export limit of all users')){
            $("[name='ExpLmt[]']").val(resValue);
            $("[name='ExpLmtMA[]']").val(resValue);
            $("[name='ExpLmtRE[]']").val(resValue);
            alert('Export Limit is set to '+resValue+'. Click Update Memebers to save. ');
        }
    }else{
        alert('Please enter the export limit');
    }
}



$(document).ready(function() {    
   
      $('#vconly').click(function(event) {  //on click 
               
                 if(this.checked) { // check select status
                     $('.vconly').each(function() { //loop through each checkbox
                         this.checked = true;  //select all checkboxes with class "checkbox1"               
                     });
                 }else{
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
                        $('#vconly').prop( "checked", false );
                    }
                    
                    if( vccount>0 ||  (vctotal == vccount) ){
                        $('#vconly').prop( "checked", true );
                    }
                 
             }); 
         
         
         
         
         
         
         
         
             
             
       $('#peonly').click(function(event) {  //on click 
               
                 if(this.checked) { // check select status
                     $('.peonly').each(function() { //loop through each checkbox
                         this.checked = true;  //select all checkboxes with class "checkbox1"               
                     });
                 }else{
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
                    }
                    
                    if( pecount>0 ||  (petotal == pecount) ){
                        $('#peonly').prop( "checked", true );
                    }
             }); 
             
    });

</SCRIPT>

<link href="../css/style_root.css" rel="stylesheet" type="text/css">
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="companyedit"  method="post" action="" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
<?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproproducts">

   		<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
				</div>
				<div id="linksnone">
					<a href="dealsinput.php">Investment Deals</a> | <a href="companyinput.php">Profiles</a><br />

				  <a href="investorinput.php">Investor Profile</a><br />
				</div>

				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
				</div>
				<div id="linksnone">
					<a href="pegetdatainput.php">Deals / Profile</a><br />
								<a href="peadd.php">Add PE Inv </a> |  <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA </a> |

			<A href="peadd_RE.php"> RE Inv</a> | <A href="reipoadd.php"> RE-IPO</a> <br />
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
				<div id="linksnone">
					<a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div>
   </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
<!--   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>  -->

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:534px; margin-top:0px;overflow: scroll;">

	    <div id="maintextpro">
	    <div id="headingtextpro">
		<input type=hidden name="compId" value="<?php echo $companyIdtoEdit; ?>" >

		Company&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="../images/arrow.gif" />
						<input type=text name="companyname" value="<?php echo $CompanyName; ?>" >
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


		<input type=checkbox name="txtTrialLogin"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $trialFlag; ?> onclick="ExporttoExel()" >
		Export to Excel
		<input type=checkbox name="txtIPAdd"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $ipflag; ?>  onclick="IPAdd();">
		IP Add
		<br />
		Expiry Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="../images/arrow.gif" />
					<input type="text" name="date" value="<?php echo $ExpDate; ?>" size="20"> (yyyy-mm-dd)
					&nbsp;&nbsp;&nbsp;&nbsp;
                <br/>
                <input type=checkbox name="txtStudent"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $studentFlag; ?> onclick="Student()" >
                Student &nbsp;&nbsp;&nbsp;&nbsp;
                <input type=checkbox name="txtRELogin"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $reflag; ?>  >
                RELogin
                <br/><br/>
                <!-- ADDED BY JFR - KUTUNG -->
                <div id="IpRnglst">
                    <?php echo $ipContent; ?>
                    
                    <input type="hidden" name="ipCount" id="ipCount" value="<?php echo $ipCount; ?>">
                </div>
                
                Company Contact(s) <i>(Add multiple email ID separated by comma's)</i> <br/> <textarea name="contacts" rows="1" cols="30"><?php echo $poContact; ?></textarea> 
                <br/><br/>
                
                Reset Export Limit to <input type="text" name="resetExp" id="resetExp"> <input type="button" name="limReset" value="Reset" onclick="resetExpLimit();">

                    <!--id="f_date_c" readonly="0" size="20" />
                            <img src="img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector"
 onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /> --><br /><br />
	            <div style="width: 542px; height: 260px; overflow: scroll;">
                        <input type="checkbox" value="1" name="peonly" id="peonly" > <label for="peonly"><strong>PE-Only</strong></label> 
                        <input type="checkbox" value="2" name="vconly" id="vconly"> <label for="vconly"><strong>VC-Only</strong></label> 
                        <br>
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
						<th>PE-back</th>
						<th>VC-back</th>
						<th>MA-MA</th>
						<th>Inc</th>
						<th>AngelInv</th>
						<th>SVInv</th>
						<th>IfTech</th>
						<th>CTech</th>
								<!--<th> </th> -->
					</tr>
		<?php

				$dealcompanySql="select * from dealcompanies where Deleted=0 and DCompId=$companyIdtoEdit";
						if ($companyrs = mysql_query($dealcompanySql))
						 {	$company_cnt = mysql_num_rows($companyrs);	 }
						 if ($company_cnt>0)
							{
								While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
								{
									$PEInv="";
									$VCInv="";
									//$REInv="";
									$PEIpo="";
									$VCIpo="";
									$PEMa="";
									$VCMa="";
									$PEDir="";
									$VCDir="";
									$SPDir="";
									$PE_back="";
									$VC_back="";
									$Ma_Ma="";
									$inc="";
									$angelInv="";
                                                                        $sv="";
									$itech="";
									$ctech="";

                                                                        $permission = $myrow["permission"];
                                                                        
									if($myrow["PEInv"]==1)
										$PEInv="checked";
									if($myrow["VCInv"]==1)
										$VCInv="checked";
									//if($myrow["REInv"]==1)
									//	$REInv="checked";
									if($myrow["PEIpo"]==1)
										$PEIpo="checked";
									if($myrow["VCIpo"]==1)
										$VCIpo="checked";
									if($myrow["PEMa"]==1)
										$PEMa="checked";
									if($myrow["VCMa"]==1)
										$VCMa="checked";
									if($myrow["PEDir"]==1)
										$PEDir="checked";
									if($myrow["VCDir"]==1)
										$VCDir="checked";
									if($myrow["SPDir"]==1)
										$SPDir="checked";
									if($myrow["PE_backDir"]==1)
										$PE_back="checked";
									if($myrow["VC_backDir"]==1)
										$VC_back="checked";
									if($myrow["MAMA"]==1)
										$Ma_Ma="checked";
									if($myrow["Inc"]==1)
										$inc="checked";
									if($myrow["AngelInv"]==1)
									    $angelInv="checked";
                                                                        if($myrow["SVInv"]==1)
									    $sv="checked";
					                                if($myrow["IfTech"]==1)
									    $itech="checked";
 						                    if($myrow["CTech"]==1)
									    $ctech="checked";
                                                            ?>
						 <tr>
						<td align=center><input name="PEInv" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEInv; ?>></td>
                                                <td align=center><input name="VCInv" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>"<?php echo $VCInv; ?> ></td>
						<!--<td align=center><input name="RE" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $REInv; ?> ></td>-->
						<td align=center><input name="PEIpo" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEIpo; ?> ></td>
						<td align=center><input name="VCIpo" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCIpo; ?> ></td>
						<td align=center><input name="PEMa" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEMa; ?> ></td>
						<td align=center><input name="VCMa" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCMa; ?> ></td>
						<td align=center><input name="PEDir" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEDir; ?> ></td>
						<td align=center><input name="CODir" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCDir; ?> ></td>
						<td align=center><input name="SPDir" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $SPDir; ?> ></td>

						<td align=center><input name="PE_back" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $PE_back; ?> ></td>
						<td align=center><input name="VC_back" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $VC_back; ?> ></td>
						<td align=center><input name="MA_MA" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $Ma_Ma; ?> ></td>
						<td align=center><input name="INC" class="vconly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $inc; ?> ></td>
						<td align=center><input name="AngelInv" class="vconly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $angelInv; ?> ></td>
                                                <td align=center><input name="SVInv" class="vconly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $sv; ?> ></td>
                                                <td align=center><input name="IfTech" class="peonly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $itech; ?> ></td>
                                                <td align=center><input name="CTech" class="peonly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $ctech; ?> ></td>
						</tr> </table>
					<?php
						} //end of while loop
					} //end of if loop
					?>


		List of Members : <br />

			<table border="1" align=left cellpadding="2" cellspacing="0" width="70%"  >
			<tr style="font-family: Verdana; font-size: 8pt">
			<th colspan=2> Del</th>
			<th>Sl.No</th>
			<th >Name</th>
			<th> Email Id</th>
			<th>Password</th>
                        <th>Devices Allowed</th>
                        <th>Export Limit</th>
			</tr>
		<?php
				$emailCount=1;
				$getMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit from dealmembers where DCompId=$companyIdtoEdit and Deleted=0 order by EmailId";
				//echo "<Br>--" .$getMembersSql;
				if ($rsMembers=mysql_query($getMembersSql))
				{
					While($myrow=mysql_fetch_array($rsMembers, MYSQL_BOTH))
					{
		?>
						<tr style="font-family: Verdana; font-size: 8pt">
					 	<td align=center colspan=2 BGCOLOR="#FF6699"><input name="DelEmailId[]" type="checkbox" value=" <?php echo $myrow["EmailId"]; ?>" >
						<input type=hidden name="email[]" value="<?php echo $myrow['EmailId']; ?>"> </td>
						<td  align=center><?php echo $emailCount; ?></td>
						<td  ><input type=text name="Nams[]"  value="<?php echo trim($myrow['Name']); ?>"> </td>
						<td  > <input type=text name="Mails[]" value="<?php echo trim($myrow['EmailId']); ?> "></td>
						<td  ><input type=password name="Pwd[]" value="<?php echo trim($myrow['Passwrd']); ?>" > </td>
                                                <td  ><input type=text name="DevCnt[]" value="<?php echo trim($myrow['deviceCount']); ?>" > </td>
                                                <td  ><input type=text name="ExpLmt[]" value="<?php echo trim($myrow['exportLimit']); ?>" > </td>
						</tr>
			<?php
					$emailCount=$emailCount+1;
					}
				}
				//Get members from malogin table
				$MAemailCount=1;
				$getMAMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit from malogin_members where DCompId=$companyIdtoEdit and Deleted=0 order by EmailId ";
				//echo "<Br>--" .$getMAMembersSql;
				if ($rsMAMembers=mysql_query($getMAMembersSql))
				{
					While($myMArow=mysql_fetch_array($rsMAMembers, MYSQL_BOTH))
					{
		?>
						<tr style="font-family: Verdana; font-size: 8pt">
						<td align=center colspan=2 BGCOLOR="#FFFF00"><input name="MADelEmailId[]" type="checkbox" value=" <?php echo $myMArow["EmailId"]; ?>" >
						<input type=hidden name="emailMA[]" value="<?php echo $myMArow['EmailId']; ?>"> </td>
						<td  align=center><?php echo $MAemailCount; ?></td>

						<td  ><input type=text name="NamsMA[]"  value="<?php echo trim($myMArow['Name']); ?>"> </td>
						<td  > <input type=text name="MailsMA[]" value="<?php echo trim($myMArow['EmailId']); ?> "></td>
						<td  ><input type=password name="PwdMA[]" value="<?php echo trim($myMArow['Passwrd']); ?>" > </td>
                                                <td  ><input type=text name="DevCntMA[]" value="<?php echo trim($myMArow['deviceCount']); ?>" > </td>
                                                <td  ><input type=text name="ExpLmtMA[]" value="<?php echo trim($myMArow['exportLimit']); ?>" > </td>
						</tr>
		<?php
					$MAemailCount=$MAemailCount+1;

					}
				}


				//Get members from RELogin table
				$REemailCount=1;
				$getREMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit from RElogin_members where DCompId=$companyIdtoEdit and Deleted=0 order by EmailId ";
				//echo "<Br>--" .$getREMembersSql;
				if ($rsREMembers=mysql_query($getREMembersSql))
				{
					While($myRErow=mysql_fetch_array($rsREMembers, MYSQL_BOTH))
					{
		?>
						<tr style="font-family: Verdana; font-size: 8pt">
						<td align=center colspan=2 BGCOLOR="GREEN"><input name="REDelEmailId[]" type="checkbox" value=" <?php echo $myRErow["EmailId"]; ?>" >
						<input type=hidden name="emailRE[]" value="<?php echo $myRErow['EmailId']; ?>"> </td>
						<td  align=center><?php echo $REemailCount; ?></td>

						<td  ><input type=text name="NamsRE[]"  value="<?php echo trim($myRErow['Name']); ?>"> </td>
						<td  > <input type=text name="MailsRE[]" value="<?php echo trim($myRErow['EmailId']); ?> "></td>
						<td  ><input type=password name="PwdRE[]" value="<?php echo trim($myRErow['Passwrd']); ?>" > </td>
                                                <td  ><input type=text name="DevCntRE[]" value="<?php echo trim($myRErow['deviceCount']); ?>" > </td>
                                                <td  ><input type=text name="ExpLmtRE[]" value="<?php echo trim($myRErow['exportLimit']); ?>" > </td>
						</tr>
		<?php
					$REemailCount=$REemailCount+1;

					}
				}

		?>

				</table>
				</div>
			<span style="float:left" class="one">
			<input type="button"  value="Delete Members" name="deleteMember" onClick="deleteMembers(<?php echo $_GET["value"]; ?>);">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  value="Add Members" name="addMember" onClick="AddMembers();">

			</span>

			<span style="float:right" class="one">
			<input type="button"  value="Update Member List" name="updateMember" onClick="updateMembers();" >
			</span> <br /><br />
			<div id="headingtextprosmallfontbgPinkcolorAdmin">PE Logins </div>
						<div id="headingtextprosmallfontbgYellowcolorAdmin">Merger Logins</div>
						<div id="headingtextprosmallfontbgGreencolorAdmin">RE Logins</div>


		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
<script>
$(document).ready(function() {   
       <?php if ($permission==1) { ?>
                        $('#peonly').prop( "checked", true );
        <?php } else if($permission==2) { ?> 
                        $('#vconly').prop( "checked", true );
        <?php  } else { ?>
            
            
                    
                     var pecheckcount=0;
                     $('.peonly').each(function() { //loop through each checkbox
                        if(this.checked==true) { pecheckcount++; }        
                     });                     
                    if(pecheckcount>0){
                        $('#peonly').prop( "checked", true );
                    }
                    
                  
                    
                     var vccheckcount=0;
                     $('.vconly').each(function() { //loop through each checkbox
                        if(this.checked==true) { vccheckcount++; }        
                     });                     
                    if(vccheckcount>0){
                        $('#vconly').prop( "checked", true );
                    }
                    
                        
                        
        <?php  } ?>
});
</script>

   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
   </form>

   <script type="text/javascript">
         Calendar.setup({
             inputField     :    "f_date_c",     // id of the input field
             ifFormat       :    "%B %e, %Y",      // format of the input field
             button         :    "f_trigger_c",  // trigger for the calendar (button ID)
             align          :    "Tl",           // alignment (defaults to "Bl")
             singleClick    :    true
         });
</script>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>

</body>
</html>
<?php

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>