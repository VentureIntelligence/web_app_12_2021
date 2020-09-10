<?php include_once("../../globalconfig.php"); ?>
<?php
//error_reporting(E_ALL); 
//ini_set( 'display_errors','1');
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
 session_start();
 if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd")){
    $currentyear = date("Y");
    
    require("../dbconnectvi.php");
    $Db = new dbInvestments();          
    
    if ($_POST){
        $dbType             = 'PE';
        $investorId='';
        $fundnameId='';
        if($_POST['investoradd']!='') 
        {
            
            $sqlinv = "INSERT INTO `peinvestors` (`investor`) VALUES ('".$_POST['investoradd']."') ";
            $res = mysql_query($sqlinv) or die(mysql_error());
            $investorId = mysql_insert_id();
        }
       else{
           $investorId = $_POST['investor'];
       }
       
       if($_POST['fundNameadd']!='') 
        {
            
            $sqlfun = "INSERT INTO `fundNames` (`investorId`,`fundName`) VALUES (".$investorId.",'".$_POST['fundNameadd']."') ";
            echo $sqlfun;
            $funres = mysql_query($sqlfun) or die(mysql_error());
            $fundnameId = mysql_insert_id();
        }
       else{
           $fundnameId = $_POST['fundName'];
       }
        
        $fundMan            = $_POST['fundMan'];
        $fundTypStage       = $_POST['fundTypeStage'];
        $fundTypIndy        = $_POST['fundTypeIndustry'];
        $fundSize           = $_POST['size'];
        $fundStatus         = $_POST['fundStatus'];
        $fundCloseStatus    = $_POST['fundCloseStatus'];
        $fundDate           = $_POST['date'];
        $capitalSource      = $_POST['capitalSource'];
        $moreInfo           = $_POST['moreInfo'];
        $source             = $_POST['source'];

        //Insert into Table
        $sqlIns = "INSERT INTO `fundRaisingDetails` (`dbType`,`investorId`,`fundName`,`fundManager`,`fundTypeStage`,`fundTypeIndustry`,`size`,`fundStatus`,`fundClosedStatus`,`fundDate`,`capitalSource`,`moreInfo`,`source`) ";
        $sqlIns .= " VALUES ('".$dbType."','".$investorId."','".$fundnameId."','".$fundMan."','".$fundTypStage."','".$fundTypIndy."','".$fundSize."','".$fundStatus."','".$fundCloseStatus."','".$fundDate."','".$capitalSource."','".$moreInfo."','".$source."')";
        $res = mysql_query($sqlIns) or die(mysql_error());
        header("location:fundlist.php");
    }                            
?>
<html><head>
<title>Add Fund Raising Details</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="styles/token-input.css" type="text/css" />
<link rel="stylesheet" href="styles/token-input-facebook.css" type="text/css" />

<script type="text/javascript">
    jQuery(document).ready(function($) {
        
       
        $("#investor").tokenInput("ajaxphp.php?opt=investor",{
                hintText: "Start typing the investor name",
                noResultsText: "No Investors matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                onAdd: function (item) {
                    
                    $.post("ajaxphp.php?opt=fundname&inv="+item.id, function(data) {
                            data=$.parseJSON(data);
                            if(data.length > 0)
                            {
                                data=data[0];
                                $("#fundName").tokenInput("add", {id: data.id, name: data.name});
                            }else{
                                $("#fundName").tokenInput("clear");
                            }
                            
                                
                 });
                    
                   $('#investoradd').attr('disabled',"true");
                   
            },
             onDelete: function (item) {
                   $('#investoradd').removeAttr('disabled');
                    $("#fundName").tokenInput("clear");
            }
        }); 
         $("#fundName").tokenInput("ajaxphp.php?opt=allfundname",{
                hintText: "Start typing the fundname",
                noResultsText: "No name matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                 onAdd: function (item) {
             
                   $('#fundnameadd').attr('disabled',"true");
            },
             onDelete: function (item) {
                   $('#fundnameadd').removeAttr('disabled');
            }
            });
        //jQuery('input[type=radio]')
        $("input:radio[name='fundStatus']").click(function(){
            if(this.value==2){
                 jQuery('#closeStatus').show();
            }else{
                jQuery('#closeStatus').hide();
            }
        });
    });
   /* function fundname(fundid){
        alert("dddddddddd");
        $("#fundName").tokenInput("ajaxphp.php?opt=fundname&inv="+fundid,{
                hintText: "Start typing the fundname",
                noResultsText: "No name matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                 onAdd: function (item) {
             
                   $('#fundnameadd').attr('disabled',"true");
            },
             onDelete: function (item) {
                   $('#fundnameadd').removeAttr('disabled');
            }
            });
    }*/
</script>


<SCRIPT LANGUAGE="JavaScript">

    
function checklist()
{
	missinginfo = "";
      
        investor=jQuery("#investor").val();
        investoradd=jQuery("#addinvestor").val();
       
        fundName=jQuery("#fundName").val();
        fundadd=jQuery("#fundadd").val();
       
       if(investor!="" || investoradd!="")
        {
//            if(fundName!="" || fundadd!="")
//            {
//                
//            }else{
//                 missinginfo += "\n     -  Please select Fund Name";
//            }
        }else if(fundName!="" || fundadd!="")
        {
            if(investor!="" || investoradd!="")
            {
                
            }else{
                 missinginfo += "\n     -  Please select Investor";
            }
        }
      
       var elem=document.forms['addfund'].elements['fundStatus'];
        len=elem.length-1;
        chkvalue='';
        for(i=0; i<=len; i++)
        {
            if(elem[i].checked)chkvalue=elem[i].value;
        }
        
        if(chkvalue=='')
        {
            missinginfo += "\n     -  Please select Fund Status";
        }
        else if(chkvalue==2){
            
            var elem2=document.forms['addfund'].elements['fundCloseStatus'];
            len2=elem2.length-1;
            
            chkvalue2='';
            for(j=0; j<=len2; j++)
            {
                if(elem2[j].checked)chkvalue2=elem2[j].value;
            }
           
            if(chkvalue2=='')
            {
                missinginfo += "\n     -  Please select Close Status";
            }
        
        }   
        
        if(document.addfund.date.value =='')
            missinginfo += "\n     -  Please enter Date";
        
	if (missinginfo != "")
	{
		alert(missinginfo);
		return false;
	}
	else
        {
            return true;
        }
}
</SCRIPT>
<script type="text/javascript">

$(document).ready(function() {
            
             //$("#token-input-fundName,#fundnameadd").attr('disabled',"true");
            //$("#fundlist").html("Show Manager");
            $("#investoradd").click(function(){
              
                $("#addinvestor").show();
                $(this).html('Suggest Investor');
                $("#token-input-investor").hide();
                $(".token-input-list").css('border','none');
            });
            $("#fundnameadd").click(function(){
               
                $("#fundadd").show();
                $(this).html('Suggest FundName');
                $("#token-input-fundName").hide();
                $(".token-input-list").css('border','none');
            });
            
  
});
  
</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->

</head>

<body>
<form name="addfund" onSubmit="return checklist();" method=post action="addfund.php">
 <table border=1 align=center cellpadding="5px" cellspacing="0px" width="900px" style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111"  bgcolor="#F5F0E4">

        <tr bgcolor="#808000"><td colspan=3 align=center style="color: #FFFFFF" ><b> Add Fund Raising Details</b></td></tr>
        
        <tr>
            <td width="300px">Investor</td>
            <td colspan="2">
                <input type="text" name="investor" id="investor">
                <input type="text" name="investoradd" id="addinvestor" style="display:none">
<!--                <span id="addinvestor"> </span>-->
                 <button type="button" id="investoradd" value="">Add Investor</button>
                 
            </td>
            
        </tr>
        <tr>
            <td>Fund Name</td>
            <td colspan="2">
                <input type="text" name="fundName" id="fundName" size="50">
<!--                <span id="addfund"> </span>-->
                <input type="text" name="fundNameadd" id="fundadd" style="display:none">
                <button type="button" id="fundnameadd" value="">Add FundName</button>
            </td>
        </tr>
        <tr>
            <td>Fund Manager</td>
            <td colspan="2">
                <input type="text" name="fundMan" id="fundMan" size="50">
            </td>
        </tr>
        <tr>
            <td>Fund Type</td>
            <td colspan="2">
                <?php
                    $sql = "SELECT `id`,`fundTypeName` FROM fundType WHERE `focus`='Stage'";
                    $res = mysql_query($sql) or die(mysql_error());
                    $option = '';
                    
                    while($rows=mysql_fetch_array($res)){ 
                        $id = $rows['id'];
                        $fundTypeName = $rows['fundTypeName'];
                        $option .= '<option value="'.$id.'">'.$fundTypeName.'</option>';
                    }
                ?>
                
                <select name="fundTypeStage">
                    <option value="">---STAGE---</option>
                    <?php echo $option; ?>
                </select> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <?php
                    $sql = "SELECT `id`,`fundTypeName` FROM fundType WHERE `focus`='Industry'";
                    $res = mysql_query($sql) or die(mysql_error());
                    $option = '';
                    while($rows=mysql_fetch_array($res)){
                        $id = $rows['id'];
                        $fundTypeName = $rows['fundTypeName'];
                        $option .= '<option value="'.$id.'">'.$fundTypeName.'</option>';
                    }
                ?>
                <select name="fundTypeIndustry">
                    <option value="">---INDUSTRY---</option>
                    <?php echo $option; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Size (US$M)</td>
            <td colspan="2">
                <input type="text" name="size" id="size">
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <?php
                    $sql ="SELECT * FROM fundRaisingStatus";
                    $res = mysql_query($sql) or die(mysql_error());
                    while($rows = mysql_fetch_array($res)){
                        $id = $rows['id'];
                        $fundStatus = $rows['fundStatus'];
                        echo '<input type="radio" name="fundStatus" value="'.$id.'">&nbsp;'.$fundStatus.'&nbsp;&nbsp;' ;
                    }
                ?>
            </td>
            <td id="closeStatus" style="display:none;"> 
                &nbsp;&nbsp;Close Status :
                <?php
                $sql ="SELECT * FROM fundCloseStatus";
                    $res = mysql_query($sql) or die(mysql_error());
                    $count=0;
                    while($rows = mysql_fetch_array($res)){
                        echo ($count==0) ? '&nbsp;&nbsp;&nbsp;' : '';
                        $id = $rows['id'];
                        $closeStatus = $rows['closeStatus'];
                        echo '<input type="radio" name="fundCloseStatus" value="'.$id.'">&nbsp;'.$closeStatus.'&nbsp;&nbsp;' ;
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Capital Source</td>
            <td colspan="2">
                <?php
                    $sql ="SELECT * FROM fundCapitalSource";
                    $res = mysql_query($sql) or die(mysql_error());
                    while($rows = mysql_fetch_array($res)){
                        $id = $rows['id'];
                        $source = $rows['source'];
                        echo '<input type="radio" name="capitalSource" value="'.$id.'">&nbsp;'.$source.'&nbsp;&nbsp;' ;
                    }
                ?>
                
            </td>
        </tr>
        <tr>
            <td>Date</td>
            <td colspan="2">
                <input type="date" name="date" size="50" value="<?php echo date('Y-m-d');?>" >
            </td>
        </tr>
        <tr>
            <td>More Info</td>
            <td colspan="2">
                <textarea name="moreInfo"></textarea>
            </td>
        </tr>
        <tr>
            <td>Source</td>
            <td colspan="2">
                <textarea name="source"></textarea>
            </td>
        </tr>
        
        <tr><td colspan="3">&nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a></td><td align=right colspan="2"> <a href="fundlist.php">Funds List</a> </td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="Add Fund" name="actionlist" > </td></tr></table>




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

 } // if resgistered loop ends
 else
 	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
