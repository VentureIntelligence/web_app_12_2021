<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();

  	$fullString1 = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $fullString=explode("/", $fullString1);
	$IPO_MandA_flag=$fullString[0];
    $ipmandid=$fullString[1];
    $companyid=$fullString[2];
        if($ipmandid==0)
        {        $IPO_MandAId= rand();       }
        else
         {
               $IPO_MandAId=$ipmandid;    }
//on submission
        if($_POST)
        {
    	    $ipo_mandaflag=$_POST['txtpereflag'];
            $IPO_MandAId=$_POST['txtPEId'];
 	if($IPO_MandAId>0)
	{
         // echo "<bR>-----------------------" .$ipo_mandaflag;
         
		$exitInvestor=$_POST['txtinvestor'];
		$invReturnMultiple=$_POST['txtReturnMultiple'];
		$invReturnMultipleINR=$_POST['txtReturnMultipleINR'];
                $invHideAmount=$_POST['txthideamount'];
                $invexp_dp=$_POST['txtexcludedp'];
		$invMoreInfo=$_POST['txtInvmoreinfor'];
                $rowcount = $_POST["rowcount"];
                $row_db_count = $_POST["row_db_count"];
                $txtinvestorid = $_POST["txtinvestorid"];
                $investorOrder=$_POST['investorOrder'];
                $leadinvestor=$_POST['leadinvestor'];
                $newinvestor=$_POST['newinvestor'];
                $existinvestor=$_POST['existinvestor'];
                $fundname=$_POST['txtfundname'];
               // print_r($fundname);
                
                //remove investor
                /*$getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,peinv.InvMoreInfo from peinvestments_investors as peinv,
                peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$IPO_MandAId ORDER BY peinv.InvestorId =9 ASC";*/
                $getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,peinv.InvMoreInfo,peinv.investorOrder from peinvestments_investors as peinv,peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$IPO_MandAId ";
           //echo "<bR>--" .$getInvestorsSql;
              /*  $deleted_investor = array();
                if ($rsinvestors = mysql_query($getInvestorsSql))
                {
                      While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                      {
                        $InvestorName = $myInvrow['Investor'];
                        $Investor_Id = $myInvrow['InvestorId'];
                          if(!in_array($InvestorName, $exitInvestor)){ 
                            if (mysql_query("delete from peinvestments_investors where PEId=$IPO_MandAId and InvestorId=$Investor_Id")){
                                //echo "<br>PE Investor deleted" ;
                                $deleted_investor[] = $InvestorName;
                            }
                          }
                      }
                }
          
			for ($j=0;$j<$rowcount;$j++)
			{
				if(trim($exitInvestor[$j])!="")
				{ 
                                    if($j < $row_db_count && $row_db_count > 0 && (!in_array($exitInvestor[$j],$deleted_investor))){                                        
                                        $investorId=return_insert_get_Investor_edit_update($exitInvestor[$j],$txtinvestorid[$j]);  
                                        if($investorId !=''){
                                            $ciaIdToInsert=insert_Investment_Investors_edit($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invReturnMultipleINR[$j],$invHideAmount[$j],$invexp_dp[$j],$invMoreInfo[$j]);
                                        }else{
                                            $investorId=return_insert_get_Investor($exitInvestor[$j]);
                                            //echo "<bR>--" .$investorId. "*** " .$ipo_mandaflag ;
                                            if($investorId !=''){
                                                $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invReturnMultipleINR[$j],$invHideAmount[$j],$invexp_dp[$j],$invMoreInfo[$j]);
                                            }
                                        }
                                    }else{ 
                                        $investorId=return_insert_get_Investor($exitInvestor[$j]);
                                        //echo "<bR>--" .$investorId. "*** " .$ipo_mandaflag ;
                                        if($investorId !=''){
                                            $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invReturnMultipleINR[$j],$invHideAmount[$j],$invexp_dp[$j],$invMoreInfo[$j]);
                                        }
                                    }
				}
			}*/
// if (mysql_query("delete from peinvestments_investors where PEId=$IPO_MandAId ")){
//                                                 echo "<br>PE Investor deleted" ;
                                                
//                                                }
for ($j=0;$j<$rowcount;$j++)
                                            {  
                if(trim($exitInvestor[$j])!=""){
                
                                if($row_db_count > 0 ){                                        
                                        $investorId=return_insert_get_Investor_edit_update($exitInvestor[$j],$txtinvestorid[$j]);  
                                        if($investorId !=''){
                                            
                                                $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invReturnMultipleINR[$j],$invHideAmount[$j],$invexp_dp[$j],$invMoreInfo[$j],$investorOrder[$j],$leadinvestor[$j],$newinvestor[$j]);
                                             
                                        }else{
                                             
                                            $investorId=return_insert_get_Investor($exitInvestor[$j]);
                                             
                                          
                                            if($investorId !=''){
                                            
                                               
                                                $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invReturnMultipleINR[$j],$invHideAmount[$j],$invexp_dp[$j],$invMoreInfo[$j],$investorOrder[$j],$leadinvestor[$j],$newinvestor[$j]);
                                                
                                            }
                                        }
                                    }else{ 
                                        $investorId=return_insert_get_Investor($exitInvestor[$j]);
                                        //echo "<bR>--" .$investorId. "*** " .$ipo_mandaflag ;
                                        if($investorId !=''){
                                           $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invReturnMultipleINR[$j],$invHideAmount[$j],$invexp_dp[$j],$invMoreInfo[$j],$investorOrder[$j],$leadinvestor[$j],$newinvestor[$j]);
                                        }
                                        }
                                    }
                                  
                       }  
                          
                       

                $deleted_investor = array();
                if ($rsinvestors = mysql_query($getInvestorsSql))
                {
                      While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                      {
                        $InvestorName = $myInvrow['Investor'];
                        $Investor_Id = $myInvrow['InvestorId'];
                          if(!in_array($InvestorName, $exitInvestor)){ 
                           
                            if (mysql_query("delete from peinvestments_investors where PEId=$IPO_MandAId and InvestorId=$Investor_Id")){
                                echo "<br>PE Investor deleted" ;
                                //$deleted_investor[] = $InvestorName;
                            }
                          }
                      }
                }


                       /* echo  "<script type='text/javascript'>";
echo "window.close();";
echo "</script>";*/
	}
      }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title></title>

<!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="styles/token-input.css" type="text/css" />
<link rel="stylesheet" href="styles/token-input-facebook.css" type="text/css" />
<style>
    .ui-widget.ui-widget-content{
        height: 100px;
        overflow: hidden scroll;
        width: 263px;
    }
</style>
<SCRIPT LANGUAGE="JavaScript">
function returnIPOId()
{
	//alert(document.investorsexit.txtPEId.value);
        /*$("input[type=checkbox]:not(:checked)").each(function() {
       
                $(this).val(0);
                $(this).attr("checked", true);
        });*/
        $(".txthideamount:not(:checked)").each(function() {
            
            $(this).val(0);
            $(this).prop("checked", true);
	});
        
        $(".txtexcludedp:not(:checked)").each(function() {
            
            $(this).val(0);
            $(this).prop("checked", true);
	});
  $(".leadinvestor:not(:checked)").each(function() {
            
            $(this).val(0);
            $(this).prop("checked", true);
  });
  $(".newinvestor:not(:checked)").each(function() {
            
            $(this).val(0);
            $(this).prop("checked", true);
  });
      
    opener.document.adddeal.hideIPOId.value= document.investorsexit.txtPEId.value;
	document.investorsexit.action="addPEInvestors.php?value=<?php echo $fullString1; ?>";
	document.investorsexit.submit();
}
function addMoreRow(){
    var rowcount = $('#rowcount').val() + 1;
    var str = '<tr><td valign=top> <input type="text" name="txtinvestor[]" class="txtinvestor"  size="30" > </td>';
        str += '<td valign=top> <input type="text" name="txtReturnMultiple[]"  size="5" value=0.00 class="txtReturnMultiple"></td>';
        str += '<td valign=top> <input type="text" name="txtReturnMultipleINR[]"  size="5" value=0.00 class="txtReturnMultipleINR"> </td>';
        str += '<td style="valign:center;text-align: center;"> <input type="checkbox"  class="txthideamount" name="txthideamount[]"  value="1" size="5"> </td>';
        str += '<td style="valign:center;text-align: center;"> <input type="checkbox" class="txtexcludedp" name="txtexcludedp[]"  value="1" size="5"> </td>';
        str += '<td style="valign:center;text-align: center;"> <input type="checkbox" class="leadinvestor" name="leadinvestor[]"  value="1" size="5"> </td>';
        str += '<td style="valign:center;text-align: center;"> <input type="checkbox" class="newinvestor" name="newinvestor[]"  value="1" size="5"> </td>';
        str +=' <td style="valign:center;text-align: center;"> <input type="checkbox" name="existinvestor[]" value="1"  size="30" class="existinvestor"> </td>';
        str +=' <td valign=top style="display:none;"> <input type="text" name="investorOrder[]"   size="30" class="investorOrder"> </td>';
        str += '<td><textarea name="txtInvmoreinfor[]" rows="3" cols="40" class="txtInvmoreinfor"></textarea></td>';
        str += '</tr>';
    $('#rowcount').val(rowcount);
    $('#mutiple_investor').append(str);
}
var fundval ='';
function addMorefundRow(fundval,event){
    // var rowcount = $('#rowcount').val() + 1;
    var str1 = `<div class="fundname fundsection" > <input type="text" name="txtfundname[]" class="txtfundname" size="30" ><span class="addsign`+fundval+`" onClick="addMorefundRow('`+fundval+`');" style="cursor:pointer;margin-left: 7px;">+</span></div>`;
    var str11 = '<div class="fundnamemill  fundnameinput"><input type="text" name="txtfundvalue[]"  size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;" class="txtfundvalue"> </div>';
    var str21 = '<div class="fundnameinr  fundnameinput"><input type="text" name="txtfundvalueINR[]"  size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;" class="txtfundvalueINR"> </div>';
        
    // $('#rowcount').val(rowcount);
    // $('.fundname'+fundval).append(str1);
    // $('.fundnamemill'+fundval).append(str11);
    // $('.fundnameinr'+fundval).append(str21);
    $(str1).insertAfter('.fundname'+fundval);
    $(str11).insertAfter('.fundnamemill'+fundval);
    $(str21).insertAfter('.fundnameinr'+fundval);
}
</script>
<style>
/* ul.token-input-list{
    width: 250px;
} */
  /* .fundsection{
      display:inline-flex;
  } */
  .fundsection input, .fundnameinput input{
  margin: 5px 0px 5px 10px;
    width:85%;
  }
  /* ul.token-input-list{z-index:0 !important;} */
  .fundsection ul.token-input-list {
    margin-top: 5px;
    margin-bottom: 4px;
}
/* .addsign{
    margin-top:8px;
    margin-left:5px;
} */
</style>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="investorsexit" method="post" >
<td><input type="text" name="txtPEId" size="50" READONLY value="<?php echo $IPO_MandAId; ?>"> </td>
<td><input type="text" name="txtpereflag" size="50" READONLY value="<?php echo $IPO_MandA_flag; ?>"> </td>
<?php
    $cnt=6;
?>

<td>
<table width=60% align=left id="mutiple_investor" border=1 cellpadding=1 cellspacing=0>

  <tr> <th>Investor </th><th> Amount $M </th><th> Amount INR </th><th> Hide Amount </th><th> Exclude for Dry powder</th><th> Lead Investor</th><th> New Investor</th><th> Existing Investor</th><th style="display:none;"> Investor Order</th><th> Return Multiple </th> <th>More Info </th></tr>
<?php
   
    $getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,peinv.InvMoreInfo,peinv.hide_amount,peinv.exclude_dp,peinv.investorOrder,peinv.leadinvestor,peinv.newinvestor,peinv.existinvestor from peinvestments_investors as peinv,peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$IPO_MandAId ORDER BY peinv.investorOrder ASC";
   //echo "<bR>--" .$getInvestorsSql;
    $flag='';
   if ($rsinvestors = mysql_query($getInvestorsSql))
   {
        $i=0;
        if($count_rows= mysql_num_rows($rsinvestors)){
            if($count_rows>0){
                $flag='edit';
            }else{
                $flag='add';
            }               
         }else{
            $flag='add';
         }
         While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
         {
           
         ?>
           <input name="txtinvestorid[]" type="hidden" value="<?php echo $myInvrow["InvestorId"]; ?>"  >
           <tr>
               <td valign=top> <input type="text" name="txtinvestor[]" class="txtinvestor" value="<?php echo $myInvrow["Investor"]; ?>" data-investor="<?php echo $myInvrow["Investor"]; ?>"  data-invid="<?php echo $myInvrow["InvestorId"]; ?>" size="30" >
               <div class="fundname<?php echo $i; ?>  fundsection" > 
               <?php 
                $getfundSql ='SELECT peinv.PEId,peinv.InvestorId,fn.fundName,peinv.fundId,peinv.Amount_M,peinv.Amount_INR FROM fundNames AS fn,peinvestment_funddetail as peinv,peinvestors as inv where fn.fundId= peinv.fundId and  inv.InvestorId=peinv.InvestorId and peinv.PEId='.$IPO_MandAId.' and peinv.InvestorId='.$myInvrow['InvestorId'];  
                $rsfund = mysql_query($getfundSql);
               if( mysql_num_rows($rsfund)>0)
               {
               while($myfundrow1=mysql_fetch_array($rsfund, MYSQL_BOTH))
               {
               ?>
                 <input type="text" name="txtfundname[]" id="txtfundname" value="<?php echo $myfundrow1["fundName"]; ?>"  size="30"  class="txtfundname"  data-fundid="<?php echo $myfundrow1["fundId"]; ?>"><span class="addsign<?php echo $i; ?>" onClick="addMorefundRow(<?php echo $i; ?>);" style="cursor:pointer;margin-left: 7px;">+</span>
                <?php }
               }else{?>
                 <input type="text" name="txtfundname[]" id="txtfundname" value=""  size="30"  class="txtfundname" ><span class="addsign" onClick="addMorefundRow(<?php echo $i; ?>);" style="cursor:pointer;margin-left: 7px;" class="txtfundnameevent">+</span>
               <?php }?>
               </div>
               </td>
               <td valign=top> <input type="text" name="txtReturnMultiple[]"  value="<?php echo $myInvrow["Amount_M"]; ?>" size="5" value=0.00 class="txtReturnMultiple"> 
               <div class="fundnamemill<?php echo $i; ?>">
               <?php 
               if( mysql_num_rows($rsfund) > 0)
               {
               if($rsfund = mysql_query($getfundSql)){
               while($myfundrow2=mysql_fetch_array($rsfund, MYSQL_BOTH))
               {
               ?>   
                  <input type="text" name="txtfundvalue[]"  value="<?php echo $myfundrow2["Amount_M"]; ?>" size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;" class="txtfundvalue">
                <?php 
                }}
                }else{?>
                   <input type="text" name="txtfundvalue[]" value="0.00"  size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;" class="txtfundvalue">
               <?php }?>  
               </div>   
               </td>
               <td valign=top> <input type="text" name="txtReturnMultipleINR[]"   size="5" value="<?php echo $myInvrow["Amount_INR"]; ?>" class="txtReturnMultipleINR"> 
               <div class="fundnameinr<?php echo $i; ?>">
               <?php 
               if( mysql_num_rows($rsfund) > 0)
               {
                if($rsfund = mysql_query($getfundSql)){
               while($myfundrow3=mysql_fetch_array($rsfund, MYSQL_BOTH))
               {
               ?> 
                   <input type="text" name="txtfundvalueINR[]"  value="<?php echo $myfundrow3["Amount_INR"]; ?>" size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;" class="txtfundvalueINR">
               <?php }}
                }else{?>
                   <input type="text" name="txtfundvalueINR[]"  value="0.00" size="5"  style="margin: 5px 0px 5px 10px;width: 85%;" class="txtfundvalueINR">
               <?php }?> 
               </div>
               </td>
               <td style="valign:center;text-align: center;"> <input type="checkbox" class="txthideamount" name="txthideamount[]"  value="1" <?php if($myInvrow["hide_amount"]==1){ echo 'checked'; } ?> size="5"> </td>
               <td style="valign:center;text-align: center;"> <input type="checkbox" class="txtexcludedp" name="txtexcludedp[]"  value="1" <?php if($myInvrow["exclude_dp"]==1){ echo 'checked'; } ?> size="5"> </td>
               <td style="valign:center;text-align: center;"> <input type="checkbox" class="leadinvestor" name="leadinvestor[]"  value="1" <?php if($myInvrow["leadinvestor"]==1){ echo 'checked'; } ?> size="5"> </td>
               <td style="valign:center;text-align: center;"> <input type="checkbox" class="newinvestor" name="newinvestor[]"  value="1" <?php if($myInvrow["newinvestor"]==1){ echo 'checked'; } ?> size="5"> </td>
                <td style="valign:center;text-align: center;"> <input type="checkbox" class="existinvestor" name="existinvestor[]"  value="1" <?php if($myInvrow["existinvestor"]==1){ echo 'checked'; } ?> size="5" > </td>
               <td valign=top   style="display:none;"> <input type="text" name="investorOrder[]" value="<?php echo $i; ?>"  size="30" class="investorOrder">  </td>
               <td><textarea name="txtInvmoreinfor[]" rows="3" cols="40" class="txtInvmoreinfor"><?php echo $myInvrow["InvMoreInfo"]; ?></textarea></td>
               
           </tr>
          

 <?php
  $i++;
         }
 }
  ?>
                <input type="hidden" name="row_db_count" value="<?php echo mysql_num_rows($rsinvestors); ?>">
                <input type="hidden" name="rowcount" id="rowcount" value="<?php echo $cnt+mysql_num_rows($rsinvestors); ?>">
                
<?php
		for ($k=1;$k<=$cnt;$k++)
		{
            $rowvalue=mysql_num_rows($rsinvestors)+$k;
?>
        <tr><td valign=top> <input type="text" name="txtinvestor[]" class="txtinvestor" size="30" >
            <!-- <div class="fundname echo $k.$k.$k; ?>  fundsection" > <input type="text" name="txtfundname[]"  class="txtfundname"  size="30" ><span class="addsign" onClick="addMorefundRow( echo $k.$k.$k;?>);" style="cursor:pointer">+</span></div> -->
         </td>
                <td valign=top> <input type="text" name="txtReturnMultiple[]"  size="5" value=0.00 class="txtReturnMultiple">  </td>
                <td valign=top> <input type="text" name="txtReturnMultipleINR[]"  size="5" value=0.00 class="txtReturnMultipleINR"> </td>
                <td style="valign:center;text-align: center;"> <input type="checkbox"  class="txthideamount" name="txthideamount[]"  value="1" size="5"> </td>
                <td style="valign:center;text-align: center;"> <input type="checkbox" class="txtexcludedp" name="txtexcludedp[]"  value="1" size="5"> </td>
                <td style="valign:center;text-align: center;"> <input type="checkbox" class="leadinvestor" name="leadinvestor[]"  value="1" size="5"> </td>
                <td style="valign:center;text-align: center;"> <input type="checkbox" class="newinvestor" name="newinvestor[]"  value="1" size="5"> </td>
                <td style="valign:center;text-align: center;"> <input type="checkbox" class="existinvestor" name="existinvestor[]"  value="1" size="5" > </td>
                <td valign=top style="display:none;"> <input type="text" name="investorOrder[]" value="<?php echo $rowvalue; ?>"  size="30" class="investorOrder" >  </td>
                <td><textarea name="txtInvmoreinfor[]" rows="3" cols="40" class="txtInvmoreinfor"></textarea></td>
                </tr>
<?php
		}
?>
</table>
    <table width=60% align=left cellpadding=1 cellspacing=0 style="margin-top: 10px;">
<tr><td align=right><input type="button" value="Add More" name="addmore" onClick="addMoreRow();" > </td>
    <td align=left><input type="button" value="Insert Investor(s)" name="insertExitInvestors"  class="insertInvestors" > </td>
    <td align=center>&nbsp;</td>
</tr>
</table>
</form>
</body></html>



<?php


function insert_Investment_Investors($exit_flag,$dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,$moreinfo,$investorOrder,$leadinvestor,$newinvestor)
{
	$dbexecmgmt = new dbInvestments();
	if($exit_flag=="PE")
	{
        //  echo "<br>-***--- ".$insDealInvSql;
          /*$getDealInvSql="Select PEId,InvestorId from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";*/
           $getDealInvSql="Select PEId,InvestorId,investorOrder from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";
          if($rsgetdealinvestor = mysql_query($getDealInvSql))
	  {
		$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
		if($deal_invcnt==0)
		{
                    /*$insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo')";*/
                    $insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo,investorOrder,leadinvestor,newinvestor) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo','$investorOrder','$leadinvestor','$newinvestor')";
                    if ($rsinsmgmt = mysql_query($insDealInvSql))
                    {
                        echo "<br>PE Investor Inserted" ;
                        return true;
                    }
                }
                /*else{
                    $update_query = "update peinvestments_investors set Amount_M='$returnValue', Amount_INR='$returnValueINR', InvMoreInfo = '$moreinfo' where PEId=$dealId and InvestorId=$investorId";
                    if (mysql_query($update_query)){
                        echo "<br>PE Investor updated" ;
                        return true;
                    }
                }*/
          }
          mysql_free_result($rsinsmgmt);
         }
}


/* inserts and return the investor id */
function return_insert_get_Investor($investor)
	{
        
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
					//insert acquirer
					$insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
					if($rsInsAcquirer = mysql_query($insAcquirerSql))
					{
                                            $InvestorId = mysql_insert_id();
						return $InvestorId;
					}
			}
			elseif($investor_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$InvestorId = $myrow[0];
				//	echo "<br>Insert return investor id--" .$InvestorId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}
    function return_insert_get_Investor_edit($investor,$investor_id)
    {
        $dblink= new dbInvestments();
        $investor=trim($investor);
        $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor' and InvestorId != '$investor_id'";
        //echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;
            if ($investor_cnt==0)
            {
                $insAcquirerSql="UPDATE peinvestors set Investor='$investor' where InvestorId ='$investor_id'";
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                    return $investor_id;
                }
            }else{
                $rsgetInvestorId1 = mysql_fetch_array($rsgetInvestorId);
                return $rsgetInvestorId1['InvestorId'];
            }
        }
        $dblink.close();
    }
    function return_insert_get_Investor_edit_update($investor,$investor_id)
    {
        $dblink= new dbInvestments();
        $investor=trim($investor);
        $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor' and InvestorId = '$investor_id'";
        //echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;
            if ($investor_cnt==1)
            {
                return $investor_id;
            }else{
                return '';
            }
        }else{
            return '';
        }
        $dblink.close();
    }
?>

<script>

    var status = `<?php echo $flag;?>`;
    // alert(status);
    var companyid  = `<?php echo $companyid;?>`;
    var investorIdval = `<?php echo $IPO_MandAId;?>`;
    var ipo_mandaflag = `<?php echo $IPO_MandA_flag;?>`;
    
   
        var dataflag =0;
        var dataid ='';
        var $fund = $(".txtfundname").autocomplete({
            source: []
        });
        let fundArray = [];
        let dummy = [];
        let funds = [];
        $( ".txtinvestor" ).autocomplete({
            source: function( request, response ) {
                //$('#citysearch').val('');
                $.ajax({
                type: "POST",
                url: "ajax_investors_search.php?dbtype=PE&opt=investor",
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        // var fund = {id:item.fundId,value:item.fundName,label:item.fundName};
                        // fundArray.push(fund);
                        return {
                            label: item.label,
                            value: item.value,
                            id: item.id
                        }
                    }));
                    //console.log(data,"data");
                 }
                });
            },
            minLength: 1,
            select: function( event, ui ) {
            $(this).val(ui.item.value);
            //    $(this).parents("form").submit();
            // console.log(ui.item);
            $(this).attr("data-invid",ui.item.id);
            $(this).attr("data-investor",ui.item.value);
            // dummy.push({investor:ui.item.value,fund:funds});
            // fundArray.push({investor:ui.item.value,fund:""});
            },
            open: function() {
        //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $(this).val()=="";
                //$( "#companyrauto" ).val('');  
                //$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        }); 
        $( document ).on( "keyup",".txtinvestor", function( event, ui ) {
            var client = event.clientX;
            var inv=$(this).next().length;
            if(inv == 0){   
            var randomvalue=Math.round(Math.random()*2000000);
            appendata=`<div class="fundname`+randomvalue+` fundsection" > <input type="text" name="txtfundname[]"  class="txtfundname"  size="30" ><span class="addsign`+randomvalue+`" onClick="addMorefundRow(`+randomvalue+`);" style="cursor:pointer;margin-left: 7px;">+</span></div>`;
             str11 = '<div class="fundnamemill'+randomvalue+' fundnameinput"> <input type="text" name="txtfundvalue[]" class="txtfundvalue" size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;"> </div>';
             str21 = '<div class="fundnameinr'+randomvalue+' fundnameinput"><input type="text" name="txtfundvalueINR[]" class="txtfundvalueINR" size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;"> </div>';
             if($(this).next() !== appendata){
                $(this).parent().append(appendata);
                $(this).parent().next().append(str11);
                $(this).parent().next().next().append(str21);
            }
            }
    
        });
        $( document ).on( "autocompleteselect",".txtinvestor", function( event, ui ) {
            var client = event.clientX;
            var inv=$(this).next().length;
            if(inv == 0){
            var randomvalue=Math.round(Math.random()*2000000);
            appendata=`<div class="fundname`+randomvalue+` fundsection" > <input type="text" name="txtfundname[]"  class="txtfundname"  size="30" ><span class="addsign`+randomvalue+`" onClick="addMorefundRow(`+randomvalue+`);" style="cursor:pointer;margin-left: 7px;">+</span></div>`;
             str11 = '<div class="fundnamemill'+randomvalue+' fundnameinput"> <input type="text" name="txtfundvalue[]" class="txtfundvalue" size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;"> </div>';
             str21 = '<div class="fundnameinr'+randomvalue+' fundnameinput"><input type="text" name="txtfundvalueINR[]" class="txtfundvalueINR" size="5" value=0.00 style="margin: 5px 0px 5px 10px;width: 85%;"> </div>';
             if($(this).next() !== appendata){
                $(this).parent().append(appendata);
                $(this).parent().next().append(str11);
                $(this).parent().next().next().append(str21);
            }
            }
    
        });
        $(document).delegate('.txtfundname',"focus",function(event){
           //console.log(event.currentTarget,'client');
            var textinvestor = $(this).parent().parent().find('.txtinvestor')[0].value;
            // console.log(textinvestor,'textinvestor');
            $(this).autocomplete({
                // source: fundArray,
                source: function( request, response ) {
                    $.ajax({
                        type: "POST",
                        url: "ajax_investors_search.php?dbtype=PE&opt=investor&investorval="+textinvestor,
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function( data ) {
                            console.log(data,"second");
                            response( $.map( data, function( item ) {
                            return {
                                label: item.fundName,
                                value: item.fundName,
                                id: item.fundId
                            }
                        }));
                        }
                    });
                },
                minLength: 1,
                select: function( event, ui ) {
                    $(this).val(ui.item.value);
                    $(this).attr("data-fundid",ui.item.id)
                    //    $(this).parents("form").submit();
                    var investor =$(this).parent().parent().find(".txtinvestor")[0].value;
                  
                    fundArray.push({investor:investor,fund:ui.item.value});
                   
                    
                },
                open: function() {
            //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    $(this).val()=="";
                        //$( "#companyrauto" ).val('');  
            //        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            })
        });
        $(document).ready(function(){
            var textinvestor = $(".txtinvestor");
            textinvestor.each((index,investor)=>{
                if(investor.value!=(""|undefined)){
                    var child = investor.nextSibling.nextSibling.children;
                    for(var i=0;i<child.length;i++){
                        if(i%2==0){
                            var fundname = child[i].value;
                            if(fundname!=undefined){
                                fundArray.push({investor:investor.value,fund:fundname});
                                console.log(fundArray,"fundArray");
                            }
                        }
                    }
                }
            })
        })

        $(document).delegate(".insertInvestors","click",function(e){
           
            var invsestors = [];

$('#mutiple_investor tr').each(function(a,b){
    var cele = $(this);
    var investor_id = cele.find('.txtinvestor').attr('data-invid');
    var investor_value = cele.find('.txtinvestor').val();
    var amountm = cele.find(".txtReturnMultiple").val();
    var amountinr = cele.find('.txtReturnMultipleINR').val();
    var hideamount = cele.find('.txthideamount').is(":checked") ? 1 : 0 ;
    var excludry = cele.find('.txtexcludedp').is(":checked") ? 1 : 0 ;
    var leadinvestor = cele.find('.leadinvestor').is(":checked") ? 1 : 0 ;
    var newinvestor = cele.find('.newinvestor').is(":checked") ? 1 : 0 ;
    var existinvestor = cele.find('.existinvestor').is(":checked") ? 1 : 0 ;
    var returnmultiple = cele.find('.txtInvmoreinfor').val();
    var investorOrder = cele.find('.investorOrder').val();

    var cur_fund = [];

    $(cele.find('.fundsection input')).each(function(i,e){
        var fund = {};
        var fundele = $(this);
        var fundname = $(this).val();
        var fundid = $(this).attr('data-fundid');
        var fundamount = $(this).parent().parent().parent().find("div[class^='fundnamemi'] input").eq(i).val();
        var fundamountinr = $(this).parent().parent().parent().find("div[class^='fundnameinr'] input").eq(i).val();
        if(typeof fundname != 'undefined')
        {
            fund['fundname'] = fundname;
            fund['fundid'] = fundid;
            fund['fundamount'] = fundamount;
            fund['fundamountinr'] = fundamountinr;
            cur_fund.push(fund);
        }
        
    })

    console.log(cele,amountm,amountm);
    if( typeof investor_value != 'undefined'){
        var invset = {};
            invset['investor_id'] =investor_id;
            invset['investor_value'] = investor_value;
            invset['amountm'] = amountm;
            invset['amountinr'] = amountinr;
            invset['hideamount'] = hideamount;
            invset['excludry'] = excludry;
            invset['leadinvestor'] = leadinvestor;
            invset['newinvestor'] = newinvestor;
            invset['existinvestor'] = existinvestor;
            invset['investorOrder'] = investorOrder;
            invset['returnmultiple'] = returnmultiple;
            invset['fund'] = cur_fund;

         invsestors.push(invset);
    }
})
             postData = JSON.stringify(invsestors);
             console.log(postData,"postData");
             console.log(invsestors,"postData");
            $.ajax({
                type: "POST",
                url: "ajax_fund_details.php?dbtype=PE&opt=investor",
                dataType: "json",
                data: {
                    data: postData,
                    peid:investorIdval,
                    ipo_mandaflag : ipo_mandaflag,
                    companyid:companyid
                    
                },
                success: function( data ) {
                    alert(data.responseText);
                 },
                 error: function( data ) {
                    alert(data.responseText);
                 }
            });
        })
    
    
</script>