<?php include_once("../globalconfig.php"); ?>
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
     .f-type.export-sec i{
        margin-top: 3px;
        margin-right: 10px;
    }
    .f-type.export-sec i b{
        margin:0px 6px;
    }
    .f-type.export-sec span:before{
        /*margin-top:3px;*/
        background:none !important;
    }

    input[type=button] {
        /* width: 20%; */
    border-radius: 5px;
    height: 30px;
    background-color: 413529;
    color: white;
    border: 2px solid;
    font-size: 14px;
    padding:0px 75px;
    margin-top:15px;
}


input[type=text], textarea {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
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
        <?php

        
			$keyword="";
			$keyword=$_GET['id'];
			
				$nanoSql="SELECT * FROM `saved_filter` where id='".$keyword."' ";
				if ($reportrs = mysql_query($nanoSql))
				 {
					$report_cnt = mysql_num_rows($reportrs);
				 }
		?>
        <?php include_once 'leftpanel.php'; ?>
        <!-- Ending Left Panel -->
        <div style="width:570px; float:right; background-color:#FFF; ">
                <div style="width:565px; float:left; padding-left:2px;">
                    <div style="padding:0px 15px">
                        <div id="maintextpro">
                            <div id="headingtextpro">
                                <h3 style="margin-bottom:15px;float:left;">Create New Filter</h3>
                                <a href="EditAdminFilter.php" style="padding: 15px;;float: right;text-decoration:underline">Back to filters list</a>
                            </div>
                        </div>
                        <div id="formtextpro">
                        <?php
                        if ($report_cnt>0)
                        {
                            While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                            {	
                        ?>
                                                   <input type="hidden" id="mode" value="E">

                        <input type="text" id="filter_name" placeholder="Enter Name For Your Customer Filter" value="<?php echo $myrow["filter_name"] ?>">
                        <span id="filternameErr"></span>
                        <textarea name="filterdesc" rows="4" cols="50" id="filterdesc" placeholder="description" value=""><?php echo $myrow["filter_desc"] ?></textarea>
                      <?php if( $_SESSION['name'] == "Vijaya Kumar") {?>
                        <textarea name="filterQuery" rows="4" cols="50" id="filterQuery" placeholder="query" value=""><?php echo $myrow["query"] ?></textarea>
                        <?php }
                         else { ?>
                            <input  type="hidden" name="filterQuery" rows="4" cols="50" id="filterQuery" placeholder="query" value="<?php echo $myrow["query"] ?>">
                            <?php }?>
                        <input type="checkbox" id="filter_active"  value="active" <?php echo ($myrow["filter_active"] == 'active') ? 'checked' : ''; ?>><b>Active?</b>
                       
                        <input type="hidden" id="admin_filter"  value="1" <?php echo ($myrow["vi_filter"] == '1') ? 'checked' : ''; ?>><br><br>
                        <p>Filter Type:</p>
                        <input type="radio" id="investments" name="filter_type" value="Investments" <?php echo ($myrow["filter_type"] == 'Investments') ? 'checked' : ''; ?>>
                        <label for="male">Investments</label><br>
                        <input type="radio" id="exit" name="filter_type" value="Exit" <?php echo ($myrow["filter_type"] == 'Exit') ? 'checked' : ''; ?>>
                        <label for="male">Exit</label><br>
                        <span id="filterTypeErr"></span><br>
                        <?php if( $_SESSION['name'] == "Vijaya Kumar") {?>
                            <input type="hidden" name="companyName" id="companyName" value="Pranion">
                            <?php } else {?> <input type="hidden" name="companyName" id="companyName" value="Venture">
                            <?php }?>
                        <input type="button" name="saveFilter" id="saveFilter" value="Save" onclick="saveAdminFilter()"><br><br>
                                <?php } }
                                else {?>
                                                           <input type="hidden" id="mode" value="A">

                                     <input type="text" id="filter_name" placeholder="Enter Name For Your Customer Filter" >
                                     <span id="filternameErr"></span>
                                     <textarea name="filterdesc" rows="4" cols="50" id="filterdesc" placeholder="description" value=""><?php echo $myrow["filter_desc"] ?></textarea>
                                     <?php if( $_SESSION['name'] == "Vijaya Kumar") {?>
                                        <textarea name="filterQuery" rows="4" cols="50" id="filterQuery" placeholder="query" value=""></textarea>
                                        <input type="hidden" name="companyName" id="companyName" value="Pranion">
                        <?php }
                         else { ?>
                            <input  type="hidden" name="filterQuery" rows="4" cols="50" id="filterQuery" placeholder="query" value="">
                            <input type="hidden" name="companyName" id="companyName" value="Venture">
                            <?php }?>
                        <input type="checkbox" id="filter_active"  value="active" ><b>Active?</b>
                        <input   type="hidden" id="admin_filter"  value="1" ><br>
                        <p>Filter Type:</p>
                        <input type="radio" id="investments" name="filter_type" value="Investments" >
                        <label for="male">Investments</label><br>
                        <input type="radio" id="exit" name="filter_type" value="Exit" >
                        <label for="male">Exit</label><br>
                        <span id="filterTypeErr"></span><br>

                        <input type="button" name="saveFilter" id="saveFilter" value="Save" onclick="saveAdminFilter()"><br><br>
                               <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Starting Work Area -->
            
  <!-- Ending Work Area -->

</div>
<script>

    function saveAdminFilter()
    {
        var filtername=$('#filter_name').val().trim().toLowerCase();
        var filterdesc=$('#filterdesc').val().trim().toLowerCase();

        var filterQuery=$('#filterQuery').val().trim();
        
        var filterType=$("input[name=filter_type]:checked").val()
        var filter_active=$('#filter_active:checked').val();
        var vi_filter=$('#admin_filter').val();
        var companyName=$('#companyName').val();
        var mode=$('#mode').val();
        //alert(companyName);
        $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {getTypeMode:mode,editfiltername:'<?php echo $_GET['filterName']?>',filtername:filtername,filterType:filterType, mode: 'getData'},
         success: function(data){
         
         if(data.trim() == 'failure')
         {         
         alert("Filter name already exists...kindly enter new filter name")
         return false;
         }
         else{
        if(filtername == '')
        {
            $("#filternameErr").text('Please Enter the filter name');
            $("#filternameErr").css("color", "red");
        }
        else if(filterType == undefined)
        {
            $("#filternameErr").hide();
            $("#filterTypeErr").text('Please Enter the filter type');
            $("#filterTypeErr").css("color", "red");
        }
        else{
        $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {companyName:companyName,filterDesc:filterdesc,EditFilter:"<?php echo $_GET['id']?>",vi_filter:vi_filter,filtername: filtername,filterQuery:filterQuery,filterType:filterType,filter_active:filter_active,mode: 'A'},
         success: function(data){
           //  alert(data);
           if(data.trim() == "success")
           {
            alert('saved successfully')
            window.location.href="../adminvi/EditAdminFilter.php"
            $('#filter_name').val('')
            $('#filterQuery').val('')
           }
          

         },
         });
        }
         }
         },});

    }

</script>

</body>
</html>
<?php

} // if resgistered loop ends
else
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>



