<?php include_once("../globalconfig.php"); ?>
<style>
#adminfilter {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#adminfilter td, #adminfilter th {
  border: 1px solid #ddd;
  padding: 8px;
}

#adminfilter tr:nth-child(even){background-color: #f2f2f2;}

#adminfilter tr:hover {background-color: #ddd;}

#adminfilter th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #aaaaaa;
  color: white;
}

input[type=button] {
        width: 20%;
    border-radius: 5px;
    height: 30px;
    background-color: 413529;
    color: white;
    border: 2px solid;
    font-size: 14px;
}

input[type="radio"],input[type="checkbox"]
{
    font-size: 14px;
}
        
</style>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
    checkaccess( 'subscribers' );
//session_save_path("/tmp");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    //	echo "<br>1--";
    $companyIdtoEdit = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
    $trialFlag="";$peindustries = array(); $maindustries = array();
    
    $getCompNameSql ="Select DCompanyName,ExpiryDate,TrialLogin,Student,REInv,IPAdd,poc,MAMA,peindustries,maindustries,mobile_access from dealcompanies where DCompId=$companyIdtoEdit ";
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
            $maloginFlag=$myrow["MAMA"];
            $mobappFlag=$myrow["mobile_access"];
            $peindustries = explode(', ', $myrow["peindustries"]);
            $maindustries = explode(', ', $myrow["maindustries"]);

           
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
            if($maloginFlag==1)
            {
                    $maflag="checked";
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
            if($mobappFlag==1)
            {
                    $mobflag="checked";
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
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/jquery.validate.min.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> 
        <script type="text/javascript" src="js/jquery.multiselect.js"></script> 
</head>

<body>
    <form name="adminFilter" id="adminFilter" method="post" action="" >
        <div id="containerproductproducts">
        <!-- Starting Left Panel -->
        <?php include_once 'leftpanel.php'; ?>
        <!-- Ending Left Panel -->
        <div style="width:570px; float:right; background-color:#FFF; ">
                <div style="width:565px; float:left; padding-left:2px;">
                    <div style="width:565px;">
                        <div id="editFilter"></div>
                    </div>
                </div>
         </div>
        <!-- Starting Work Area -->
            
  <!-- Ending Work Area -->

</div>
<script>
    $(document).ready(function(){
        getFilterName()
        
    })
    function getFilterName()
    {
        $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data:{mode:"saveFilter"},
         success: function(data){
            var dataValue=data.replace(/[\u0000-\u0019]+/g,"")
         var dataset=JSON.parse(JSON.stringify(dataValue))
         var dataVal=JSON.parse(dataset);
         
         var div='';
         div+='<table id="adminfilter"><tr><th>Filter Name</th><th>Action</th></tr>'

         for(i=0;i<dataVal.length;i++)
         {
            div +='<tr><td>'+dataVal[i].filter_name+'</td><td><input type="button" name="editFilter" id="editFilter" value="Edit" onclick="EditFilter(\''+dataVal[i].filter_name+'\')"><input type="button" name="deleteFilter" id="deleteFilter" value="Delete" onclick="delFilter(\''+dataVal[i].filter_name+'\')"></td></tr>'
         }
         div+='</table>'
         $('#editFilter').html(div)
         },
        });
    }
    function delFilter(filterNameId)
         {
         
             $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {filterName: filterNameId, mode: 'D'},
         success: function(data){
         
         alert('deleted successfully');
         getFilterName();
         },
         });
         
         }
         function EditFilter(filterNameId){

            $.ajax({
            url: 'saveFilter.php',
            type: "POST",
            data: {filterName: filterNameId, mode: 'E'},
            success: function(data){
            var dataval=data.replace(/[\u0000-\u0019]+/g,"")
            var dataset=JSON.parse(JSON.stringify(dataval))
            var dataValue=JSON.parse(dataset);
            window.location.href = "../adminvi/adminFilter.php?filterName="+dataValue[0].filter_name+ "&query="+dataValue[0].query+ "&filter_active="+dataValue[0].filter_active+ "&vi_filter="+dataValue[0].vi_filter+ "&filter_type="+dataValue[0].filter_type+"";
            $('#filter_name').val(dataValue[0].filter_name)
            $('#filterQuery').val(dataValue[0].query)
            $("input[name=filter_type]:checked").val()
            $('#filter_active:checked').val();
            $('#admin_filter:checked').val();

            },
            });

         }
</script>

</body>
</html>
<?php

} // if resgistered loop ends
else
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>