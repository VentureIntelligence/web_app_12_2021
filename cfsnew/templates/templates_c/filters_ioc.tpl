<?php /* Smarty version 2.5.0, created on 2020-09-22 18:36:27
         compiled from filters_ioc.tpl */ ?>

</form>
<?php if ($this->_tpl_vars['pageName1'] == 'home.php' || $this->_tpl_vars['pageName1'] == 'home1.php' || $this->_tpl_vars['pageName1'] == 'homedev.php' || $this->_tpl_vars['pageName1'] == 'chargesholderlist_suggest.php' || $this->_tpl_vars['pageName1'] == 'indexofcharges.php'): ?>
<div class="companies-fount-new">
<!--<h1><?php if ($GLOBALS['HTTP_SESSION_VARS']['totalResults']): ?><span><?php echo $GLOBALS['HTTP_SESSION_VARS']['totalResults']; ?>
</span><?php else: ?>0<?php endif; ?> Companies found</h1>-->
   
    <h1 style="margin-left:15px;"><span><?php if ($this->_tpl_vars['totalrecord_1']): ?><?php echo $this->_tpl_vars['totalrecord_1']; ?>
<?php else: ?><?php echo $this->_tpl_vars['totalrecord']; ?>
<?php endif; ?> </span>Companies found
    <div style="float:right;">
  <?php if ($this->_tpl_vars['pageName1'] != 'indexofcharges.php'): ?>
<div class="page-no" style="position:relative">
    <div class="btn-cnt" style="float:right; padding: 0px 10px !important;">
         <form name="Frm_Compare" id="exportform" action="ioc_companylist_export.php" method="post" enctype="multipart/form-data">
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel" value="<?php echo $this->_tpl_vars['searchexport']; ?>
"/>
            <input type="hidden" name="ioc" value="<?php echo $this->_tpl_vars['ChargesholderName']; ?>
">
            <input type="hidden" name="chargeaddress" value="<?php echo $this->_tpl_vars['ioc_faddress']; ?>
">
            <input type="hidden" name="chargefromdate" value="<?php echo $this->_tpl_vars['ioc_fchargefromdate']; ?>
">
            <input type="hidden" name="chargetoamount" value="<?php echo $this->_tpl_vars['ioc_fchargetoamount']; ?>
">
            <input type="hidden" name="chargefromamount" value="<?php echo $this->_tpl_vars['ioc_fchargefromamount']; ?>
">
            <input type="hidden" name="chargetodate" value="<?php echo $this->_tpl_vars['ioc_fchargetodate']; ?>
">
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