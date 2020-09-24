<?php /* Smarty version 2.5.0, created on 2020-09-24 09:48:37
         compiled from leftpanel_ioc.tpl */ ?>
<?php echo '
    <script>
    $(document).ready(function(){
    var searchhead = $(".search-main").height();
var tophead = $(".header-right").height();
var overall = $(window).height();
var headsection = searchhead + tophead;
var bodyheight = overall - headsection;
var containerheight = $(".container-right").height();
//$(".container-right").css("height",bodyheight);
if(containerheight > overall){
    $("#panel").css("height",containerheight);
}else{
$("#panel").css("height",bodyheight);
}
});
    </script>
    <style>
    .container-left li{
        border-bottom : 1px solid transparent !important;
    }
    </style>
'; ?>

<input type="hidden" name="HmeSearch" id="HmeSearch" value="HmeSearch" />
<input type="hidden" name="permission" id="permission" value="<?php echo $this->_tpl_vars['authAdmin']['Permissions']; ?>
" />
<input type="hidden" name="CountingStatus" id="CountingStatus" value="<?php echo $this->_tpl_vars['authAdmin']['CountingStatus']; ?>
" />
<input type="hidden" name="Country" id="Country" value="" />

<div class="left-td-bg"> <a class="btn-slide active" href="#">Slide Panel</a>
<div id="panel"  class="container-left" >


<div style="width:264px; display:block; overflow:hidden;">



 
  
    <!-- -->
<div>
<h2 class="active"><span> [-] </span>Charges based</h2>

<?php if ($this->_tpl_vars['chargewhere'] != ''): ?>
<div class="acc_container acc_container_active" > 
<?php else: ?>
<div class="acc_container acc_container_active" > 
<?php endif; ?> 

<ul>

<li >

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" id="fintable">
    <tr><td colspan="2">Charge Date</td></tr>   
    <tr> <td style="padding-right:4px !important;"><input type="text" name="chargefromdate" id="chargefromdate" autocomplete="off" value="<?php if ($this->_tpl_vars['chargefromdate']): ?><?php echo $this->_tpl_vars['chargefromdate']; ?>
<?php endif; ?>" style="width:100% !important"></td>  <td><input type="text" name="chargetodate" id="chargetodate"  autocomplete="off" value="<?php if ($this->_tpl_vars['chargetodate']): ?><?php echo $this->_tpl_vars['chargetodate']; ?>
<?php endif; ?>" style="width:100% !important"></td>  </tr>
<tr><td colspan="2">Charge Amount (in Rs. Cr)</td></tr>  
<tr> <td style="padding-right:4px !important;"><input type="text" name="chargefromamount" id="chargefromamount" autocomplete="off"  onkeypress="return isNumber(event)" value="<?php if ($this->_tpl_vars['chargefromamount']): ?><?php echo $this->_tpl_vars['chargefromamount']; ?>
<?php endif; ?>" style="width:100% !important"></td>  <td><input type="text" name="chargetoamount" id="chargetoamount" autocomplete="off" onkeypress="return isNumber(event)" value="<?php if ($this->_tpl_vars['chargetoamount']): ?><?php echo $this->_tpl_vars['chargetoamount']; ?>
<?php endif; ?>" style="width:100% !important"></td>  </tr>



<tr><td colspan="2">Address (city)</td></tr>  
<tr><td Colspan="2"><input type="text" name="chargeaddress" id="chargeaddress" autocomplete="off"  value="<?php if ($this->_tpl_vars['chargeaddress']): ?><?php echo $this->_tpl_vars['chargeaddress']; ?>
<?php endif; ?>" style="width:100% !important" > <img  id="autosuggest_loading3"  src="images/autosuggest_loading.gif" style="display:none;"></td>  </tr>
<input type="hidden" name="name" id="ChargesholderName" value="<?php if ($this->_tpl_vars['ChargesholderName']): ?><?php echo $this->_tpl_vars['ChargesholderName']; ?>
<?php endif; ?>" style="width:100% !important">
</table>

    <div class="btn-cnt">
    <input name="refine" type="submit" value="Refine" class="refine"/> 
</div>

</li>

</ul>
    
</div>
</div>
  <!-- -->
  
</div>
  
  







</div>

</div>
</div>
 <input type="hidden" name="resetfield" value="" id="resetfield"/>	
   <input type="hidden" name="resetfieldindex" value="" id="resetfieldindex"/>

  