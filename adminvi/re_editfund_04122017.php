<?php include_once("../globalconfig.php"); ?>
<?php
//error_reporting(E_ALL); 
//ini_set( 'display_errors','1');
require("../dbconnectvi.php");
    $Db = new dbInvestments();          
    
 session_save_path("/tmp");
 session_start();
 if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd")){
    $currentyear = date("Y");
    
    
    if ($_POST){
        $dbType             = 'RE';
        $investorId='';
        $fundnameId='';
        if($_POST['investoradd']!='') 
        {
            
            $sqlinv = "INSERT INTO `REinvestors` (`investor`) VALUES ('".$_POST['investoradd']."') ";
            $res = mysql_query($sqlinv) or die(mysql_error());
            $investorId = mysql_insert_id();
        }
       else{
           $investorId = $_POST['investor'];
       }
       
       if($_POST['fundNameadd']!='') 
        {
            
            $sqlfun = "INSERT INTO `fundNames` (`investorId`,`fundName`, `dbtype`) VALUES (".$investorId.",'".$_POST['fundNameadd']."', '$dbType') ";
            $funres = mysql_query($sqlfun) or die(mysql_error());
            $fundnameId = mysql_insert_id();
        }
       else{
           $fundnameId = $_POST['fundName'];
       }
        $fundId             = $_POST['id'];
        $fundMan            = $_POST['fundMan'];
       // $fundTypStage       = $_POST['fundTypeStage'];
        //$fundTypIndy        = $_POST['fundTypeIndustry'];
        $REsector        = $_POST['REsector'];
        $fundSize           = $_POST['size'];
        $fundStatus         = $_POST['fundStatus'];
        $fundCloseStatus    = $_POST['fundCloseStatus'];
        //$fundDate           = $_POST['date'];
        $fundDate           = "$_POST[year]-$_POST[month]-01";
        $capitalSource      = $_POST['capitalSource'];
        $moreInfo           = mysql_real_escape_string($_POST['moreInfo']);
        $source             = mysql_real_escape_string($_POST['source']);

        $sqlUpdate ="UPDATE `fundRaisingDetails` SET `dbType` = '$dbType',`investorId` = '".$investorId."',`fundName` = '".$fundnameId."',`fundManager` = '".$fundMan."',`REsector` = '".$REsector."',`size` = '".$fundSize."',`fundStatus` = '".$fundStatus."',`fundClosedStatus` = '".$fundCloseStatus."',`fundDate` = '".$fundDate."',`capitalSource` = '".$capitalSource."',`moreInfo` = '".$moreInfo."',`source` = '".$source."' WHERE `id` = '".$fundId."'";
       
        $res = mysql_query($sqlUpdate) or die(mysql_error());
        header("location:fundlist.php");
    }    
    
    //Fetch values from DB
    $selectedId = $_GET['id'];
    $sqlGet = "SELECT * FROM `fundRaisingDetails` WHERE `id`='".$selectedId."'";
    $resGet = mysql_query($sqlGet) or die(mysql_error());
    while($row=mysql_fetch_array($resGet)){
        $dtfundId             = $row['id'];
        $dtinvestorId         = $row['investorId'];
        $dtfundName           = $row['fundName'];
        $dtfundMan            = $row['fundManager'];
        //$dtfundTypeStage      = $row['fundTypeStage'];
        //$dtfundTypeIndustry   = $row['fundTypeIndustry'];
        $REsector   = $row['REsector'];
        $dtfundSize           = $row['size'];
        $dtfundStatus         = $row['fundStatus'];
        $dtfundClosedStatus   = $row['fundClosedStatus'];
        $dtfundDate           = $row['fundDate'];
        $dtcapitalSource      = $row['capitalSource'];
        $dtmoreInfo           = $row['moreInfo'];
        $dtsource             = $row['source'];
        
        //Get Investor Name
        $sqlInv = "SELECT `Investor` FROM `REinvestors` WHERE `InvestorId` = '".$dtinvestorId."'";
        $resInv = mysql_query($sqlInv) or die(mysql_error());
        $rowsInv = mysql_fetch_row($resInv);
        $dtinvestorName       = $rowsInv[0];
        
        $sqlfund = "SELECT `fundName` FROM `fundNames` WHERE `fundId` = '".$dtfundName."'";
        $resfund = mysql_query($sqlfund) or die(mysql_error());
        $rowsfund = mysql_fetch_row($resfund);
        $fundname       = $rowsfund[0];
    }
    
    
?>
<html><head>
<title>Add Fund Raising Details</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="styles/token-input.css" type="text/css" />
<link rel="stylesheet" href="styles/token-input-facebook.css" type="text/css" />


<script type="text/javascript">
    
    /**
     * $(document).ready(function() {
            $("#demo-input-pre-populated-with-tokenlimit").tokenInput("http://shell.loopj.com/tokeninput/tvshows.php", {
                prePopulate: [
                    {id: 123, name: "Slurms MacKenzie"},
                    {id: 555, name: "Bob Hoskins"},
                    {id: 9000, name: "Kriss Akabusi"}
                ],
                tokenLimit: 3
            });
        });
     * 
     * **/
    
    jQuery(document).ready(function($) {
        $("#investor").tokenInput("ajaxphp.php?dbtype=RE&opt=investor",{
                hintText: "Start typing the investor name",
                noResultsText: "No Investors matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                onAdd: function (item) {
                    
                    $.post("ajaxphp.php?dbtype=RE&opt=fundname&inv="+item.id, function(data) {
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
            },
                <?php if ($dtinvestorName!=""){?>
                
                prePopulate: [
                    {id:<?php echo $dtinvestorId;?>, name: "<?php echo $dtinvestorName; ?>"} ],
                     
                <?php } ?>
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
            },
                <?php if ($fundname !=""){?>
                prePopulate: [
                    {id:<?php echo $dtfundName;?>, name: "<?php echo $fundname; ?>"} ],
                <?php } ?>
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
</script>


<SCRIPT LANGUAGE="JavaScript">


    function monthyearcheck()
{
         var checkmonth = document.addfund.month.value;
         var checkyear = document.addfund.year.value;
         var checkinvestor = document.addfund.investor.value;
       
       var sltdb ='RE';
     
       
        var xmlhttp;
      //  var str ='test';
       
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
             //document.getElementById("property_type_box").innerHTML=xmlhttp.responseText;
             document.getElementById("datecheck").value=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","ajaxphp.php?opt=checkdate&dbtype="+sltdb+"&checkmonth="+checkmonth+"&checkyear="+checkyear+"&checkinvestor="+checkinvestor,true);
        xmlhttp.send();
        
        
}


    
function checklist()
{
	missinginfo = "";
        
        investor=jQuery("#investor").val();
        investoradd=jQuery("#addinvestor").val();
       
        fundName=jQuery("#fundName").val();
        fundadd=jQuery("#fundadd").val();
       
//       if(investor!="" || investoradd!="")
//        {
////            if(fundName!="" || fundadd!="")
////            {
////                
////            }else{
////                 missinginfo += "\n     -  Please select Fund Name";
////            }
//        }else if(fundName!="" || fundadd!="")
//        {
//            if(investor!="" || investoradd!="")
//            {
//                
//            }else{
//                 missinginfo += "\n     -  Please select Investor";
//            }
//        }

        if(investor =="")
              {
                  if(investoradd =="")
                   {
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
        
//        if(document.addfund.date.value =='')
//            missinginfo += "\n     -  Please enter Date";
        
         if(document.addfund.datecheck.value > '1'){
            missinginfo += "\n     -  Month & Year already exists !!!";
        }
        
        if(document.addfund.month.value =='0'){
            missinginfo += "\n     -   Please select Month";
        }
        
        if(document.addfund.year.value =='0'){
            missinginfo += "\n     -   Please select Year";
        }
        
        
        
	if (missinginfo != "")
	{
		alert(missinginfo);
		return false;
	}
	else
		return true;
}
</SCRIPT>
<script type="text/javascript">

$(document).ready(function() {
            
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
<form name="addfund" onSubmit="return checklist();" method=post action="re_editfund.php">
     <input type="hidden" value="1" id="datecheck" name="datecheck">
 <table border=1 align=center cellpadding="5px" cellspacing="0px" width="900px" style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111"  bgcolor="#F5F0E4">

        <tr bgcolor="#808000"><td colspan=3 align=center style="color: #FFFFFF" ><b> Edit Fund Raising Details</b></td></tr>
        
        <tr>
            <td width="300px">Investor</td>
            <td colspan="2">
                <input type="text" name="investor" id="investor">
                <input type="text" name="investoradd" id="addinvestor" style="display:none">
                 <button type="button" id="investoradd" value="" >Add Investor</button>
            </td>
        </tr>
        <tr>
            <td>Fund Name</td>
            <td colspan="2">
                <input type="text" name="fundName" id="fundName" size="50" value="<?php echo $dtfundName; ?>">
                <input type="text" name="fundNameadd" id="fundadd" style="display:none">
                <button type="button" id="fundnameadd" value="" >Add FundName</button>
            </td>
        </tr>
        <tr>
            <td>Fund Manager</td>
            <td colspan="2">
                <input type="text" name="fundMan" id="fundMan" size="50" value="<?php echo $dtfundMan; ?>">
            </td>
        </tr>
        <tr>
            <td>Fund Type</td>
            <td colspan="2">
                
                
                <select name="REsector">
                    <?php
                            $sql="select * from realestatetypes order by REType";
                            $stagesql_search = mysql_query($sql) or die(mysql_error());
                                    While($myrow=mysql_fetch_array($stagesql_search)){

                                            $id = $myrow['RETypeId'];
                                            $name = $myrow['REType'];
                                            $name=($name!="")?$name:"Other";
                                            if($REsector==$id) {
                                            echo "<OPTION id=".$id. " value=".$id." selected>".$name."</OPTION>";
                                            }
                                            else{
                                                 echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION>";
                                            }
                                    }
                                    
                           
                     ?>
                </select> 
                
                
             
            </td>
        </tr>
        <tr>
            <td>Size (US$M)</td>
            <td colspan="2">
                <input type="text" name="size" id="size" value="<?php echo $dtfundSize; ?>">
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
                        if ($dtfundStatus == $id)
                            echo '<input type="radio" name="fundStatus" value="'.$id.'" CHECKED>&nbsp;'.$fundStatus.'&nbsp;&nbsp;' ;
                        else
                            echo '<input type="radio" name="fundStatus" value="'.$id.'">&nbsp;'.$fundStatus.'&nbsp;&nbsp;' ;
                    }
                ?>
            </td>
            <td id="closeStatus" style="<?php echo ($dtfundStatus == 2) ? '' : 'display:none;'; ?>"> 
                &nbsp;&nbsp;Close Status :
                <?php
                $sql ="SELECT * FROM fundCloseStatus";
                    $res = mysql_query($sql) or die(mysql_error());
                    $count=0;
                    while($rows = mysql_fetch_array($res)){
                        echo ($count==0) ? '&nbsp;&nbsp;&nbsp;' : '';
                        $id = $rows['id'];
                        $closeStatus = $rows['closeStatus'];
                        if ($dtfundClosedStatus == $id)
                            echo '<input type="radio" name="fundCloseStatus" value="'.$id.'" CHECKED>&nbsp;'.$closeStatus.'&nbsp;&nbsp;' ;
                        else
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
                        if ($dtcapitalSource == $id)
                            echo '<input type="radio" name="capitalSource" value="'.$id.'" CHECKED>&nbsp;'.$source.'&nbsp;&nbsp;' ;
                        else
                            echo '<input type="radio" name="capitalSource" value="'.$id.'">&nbsp;'.$source.'&nbsp;&nbsp;' ;
                    }
                ?>
                
            </td>
        </tr>
        <tr>
            <td>Date</td>
            <td colspan="2">
<!--                <input type="date" name="date" size="50" value="<?php echo $dtfundDate;?>" >-->
                <?php 
                $month = date("m",strtotime($dtfundDate)); 
                $year = date("Y",strtotime($dtfundDate)); 
                ?>
                 <select name="month" id="month"  onchange="monthyearcheck();" >
                     <option value="0" >Month</option>
                     <option value="01"  <?php if($month=='01'){ echo "selected"; } ?> >Jan</option>
                    <option value="02"  <?php if($month=='02'){ echo "selected"; } ?>>Feb</option>
                    <option value="03"  <?php if($month=='03'){ echo "selected"; } ?> >Mar</option>
                    <option value="04"  <?php if($month=='04'){ echo "selected"; } ?> >Apr</option>
                    <option value="05"  <?php if($month=='05'){ echo "selected"; } ?> >May</option>
                    <option value="06"  <?php if($month=='06'){ echo "selected"; } ?> >Jun</option>
                    <option value="07"  <?php if($month=='07'){ echo "selected"; } ?> >Jul</option>
                    <option value="08"  <?php if($month=='08'){ echo "selected"; } ?> >Aug</option>
                    <option value="09"  <?php if($month=='09'){ echo "selected"; } ?> >Sep</option>
                    <option value="10"  <?php if($month=='10'){ echo "selected"; } ?> >Oct</option>
                    <option value="11"  <?php if($month=='11'){ echo "selected"; } ?> >Nov</option>
                   <option value="12"  <?php if($month=='12'){ echo "selected"; } ?> >Dec</option>
                </select>
                
                
                <select name="year" id="year"  onchange="monthyearcheck();">
                <option  value="0">Year</option>
                <?php
                 $i=1998;
                        While($i<= $currentyear )
                        {
                        $id = $i;
                        $name = $i;
                       $isselected = ($year==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i++;
                        }
              ?>
<!--                 <option id="1998" value="1998" >1998</option>
                <option id="1999" value="1999" <?php if($year==1999){ echo "selected"; } ?> >1999</option>
                <option id="2000" value="2000" <?php if($year==2000){ echo "selected"; } ?> >2000</option>
                <option id="2001" value="2001" <?php if($year==2001){ echo "selected"; } ?> >2001</option>
                <option id="2002" value="2002" <?php if($year==2002){ echo "selected"; } ?> >2002</option>
                <option id="2003" value="2003" <?php if($year==2003){ echo "selected"; } ?> >2003</option>
                <option id="2004" value="2004" <?php if($year==2004){ echo "selected"; } ?> >2004</option>
                <option id="2005" value="2005" <?php if($year==2005){ echo "selected"; } ?> >2005</option>
                <option id="2006" value="2006" <?php if($year==2006){ echo "selected"; } ?> >2006</option>
                <option id="2007" value="2007" <?php if($year==2007){ echo "selected"; } ?> >2007</option>
                <option id="2008" value="2008" <?php if($year==2008){ echo "selected"; } ?> >2008</option>
                <option id="2009" value="2009" <?php if($year==2009){ echo "selected"; } ?> >2009</option>
                <option id="2010" value="2010" <?php if($year==2010){ echo "selected"; } ?> >2010</option>
                <option id="2011" value="2011" <?php if($year==2011){ echo "selected"; } ?> >2011</option>
                <option id="2012" value="2012" <?php if($year==2012){ echo "selected"; } ?> >2012</option>
                <option id="2013" value="2013" <?php if($year==2013){ echo "selected"; } ?> >2013</option>
                <option id="2014" value="2014" <?php if($year==2014){ echo "selected"; } ?> >2014</option>-->
                

                </select>
                
            </td>
        </tr>
        <tr>
            <td>More Info</td>
            <td colspan="2">
                <textarea name="moreInfo"><?php echo $dtmoreInfo; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Source</td>
            <td colspan="2">
                <textarea name="source"><?php echo $dtsource; ?></textarea>
            </td>
        </tr>
        
        <tr><td colspan="3">&nbsp;<input type="hidden" name="id" value="<?php echo $selectedId;?>"></td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a></td><td align=right colspan="2"> <a href="fundlist.php">Funds List</a> </td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="Update Fund" name="actionlist" > </td></tr></table>




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