<?php /* Smarty version 2.5.0, created on 2020-05-27 17:18:49
         compiled from filters_ioc.tpl */ ?>

</form>
<?php if ($this->_tpl_vars['pageName1'] == 'home.php' || $this->_tpl_vars['pageName1'] == 'home1.php' || $this->_tpl_vars['pageName1'] == 'homedev.php' || $this->_tpl_vars['pageName1'] == 'chargesholderlist_suggest.php' || $this->_tpl_vars['pageName1'] == 'indexofcharges.php'): ?>
<div class="companies-fount-new">
<!--<h1><?php if ($GLOBALS['HTTP_SESSION_VARS']['totalResults']): ?><span><?php echo $GLOBALS['HTTP_SESSION_VARS']['totalResults']; ?>
</span><?php else: ?>0<?php endif; ?> Companies found</h1>-->
   
    <h1 style="margin-left:15px;"><span><?php if ($this->_tpl_vars['totalrecord_1']): ?><?php echo $this->_tpl_vars['totalrecord_1']; ?>
<?php else: ?><?php echo $this->_tpl_vars['totalrecord']; ?></span>
<?php endif; ?> Companies found <?php if ($this->_tpl_vars['ChargesholderName']):?>for <?php echo $this->_tpl_vars['ChargesholderName']; ?><?php endif;?>
<?php $filtered_chargesholdername = $_GET['name'];$filtered_chargesholdername = str_replace('_', ' ', $filtered_chargesholdername);
$chargeaddress=$_REQUEST['chargeaddress'];
$chargefromamount=$_REQUEST['chargefromamount'];
$chargetoamount=$_REQUEST['chargetoamount'];
if($_REQUEST['chargetodate']!='') {            
        $chargetodate=$_REQUEST['chargetodate'];    
     }
     else{
          
          $chargetodate = date('Y-m-d');
     }
 $chargefromdate=$_REQUEST['chargefromdate'];
?>
<div style="float:right;">
<?php if ( $this->_tpl_vars['pageName1'] != 'indexofcharges.php'): ?>
  
<div class="page-no" style="position:relative">
    <div class="btn-cnt" style="float:right; padding: 0px 10px !important;">
         <form name="Frm_Compare" id="exportform" action="ioc_companylist_export.php" method="post" enctype="multipart/form-data">
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel" value="<?php echo $this->_tpl_vars['searchexport']; ?>
"/>
            <input type="hidden" name="ioc" value="<?php echo $filtered_chargesholdername;?>">
            <input type="hidden" name="chargeaddress" value="<?php echo $chargeaddress;?>">
            <input type="hidden" name="chargefromamount" value="<?php echo $chargefromamount;?>">
            <input type="hidden" name="chargefromdate" value="<?php echo $chargefromdate;?>">
            <input type="hidden" name="chargetoamount" value="<?php echo $chargetoamount;?>">
            <input type="hidden" name="chargetodate" value="<?php echo $chargetodate;?>">
            <input type="hidden" id="ChargesholderName" name="ChargesholderName" value="<?php echo $this->_tpl_vars['ChargesholderName']; ?>
"/>
            <div class="btn-cnt p10" style="float:right;padding: 5px!important;"><input class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
        </div>
    </div>
    <?php endif; ?>
</div>
</h1>
</div>

<?php endif; ?>