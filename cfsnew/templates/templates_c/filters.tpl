<?php /* Smarty version 2.5.0, created on 2018-05-31 14:37:57
         compiled from filters.tpl */ ?>
<?php if ($this->_tpl_vars['pageName1'] == 'home.php' || $this->_tpl_vars['pageName1'] == 'home1.php' || $this->_tpl_vars['pageName1'] == 'homedev.php'): ?>
<div class="companies-fount-new">
<!--<h1><?php if ($GLOBALS['HTTP_SESSION_VARS']['totalResults']): ?><span><?php echo $GLOBALS['HTTP_SESSION_VARS']['totalResults']; ?>
</span><?php else: ?>0<?php endif; ?> Companies found</h1>-->
   
    <h1><?php if ($this->_tpl_vars['totalrecord_1']): ?><span><?php echo $this->_tpl_vars['totalrecord_1']; ?>
</span><?php else: ?><?php echo $this->_tpl_vars['totalrecord']; ?>
<?php endif; ?> Companies found</h1>

<?php if ($this->_tpl_vars['pageName1'] == 'details.php'): ?>
    <div class="compare-new" style="margin-right:25px;">
        <p class="findcom">
            <label>Dont find a Company ?</label>
            <!--<a href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to request for financials</a>-->
            <a href="javascript:void(0)" class="updateFinancialHome">Click here to request for financials</a>
        </p>
        <p class="findcom">
            <a href="javascript:void(0)"  class="oldFinacialData" >Click Here to search for additional
companies (with older financials)</a>
        </p>
    </div>
    <?php else: ?>
       <div class="compare-new" style="margin-top:-35px;margin-right:25px;">
        <p class="findcom"><label>Dont find a Company ?</label>
            <!--<a href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to request for financials</a>-->
            <a href="javascript:void(0)" class="updateFinancialHome">Click here to request for financials</a>
        </p>
        <p class="findcom">
            <a href="javascript:void(0)"  class="oldFinacialData" >Click Here to search for additional
companies (with older financials)</a>
        </p>
    </div> 
<?php endif; ?>
</div>
<div class="filter-selected">
<?php if (count ( $this->_tpl_vars['REQUEST'] ) > 0 && count ( $this->_tpl_vars['fliters'] )): ?>     
    <ul>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['fliters']) ? count($this->_tpl_vars['fliters']) : max(0, (int)$this->_tpl_vars['fliters']);
$this->_sections['List']['show'] = true;
$this->_sections['List']['max'] = $this->_sections['List']['loop'];
$this->_sections['List']['step'] = 1;
$this->_sections['List']['start'] = $this->_sections['List']['step'] > 0 ? 0 : $this->_sections['List']['loop']-1;
if ($this->_sections['List']['show']) {
    $this->_sections['List']['total'] = $this->_sections['List']['loop'];
    if ($this->_sections['List']['total'] == 0)
        $this->_sections['List']['show'] = false;
} else
    $this->_sections['List']['total'] = 0;
if ($this->_sections['List']['show']):

            for ($this->_sections['List']['index'] = $this->_sections['List']['start'], $this->_sections['List']['iteration'] = 1;
                 $this->_sections['List']['iteration'] <= $this->_sections['List']['total'];
                 $this->_sections['List']['index'] += $this->_sections['List']['step'], $this->_sections['List']['iteration']++):
$this->_sections['List']['rownum'] = $this->_sections['List']['iteration'];
$this->_sections['List']['index_prev'] = $this->_sections['List']['index'] - $this->_sections['List']['step'];
$this->_sections['List']['index_next'] = $this->_sections['List']['index'] + $this->_sections['List']['step'];
$this->_sections['List']['first']      = ($this->_sections['List']['iteration'] == 1);
$this->_sections['List']['last']       = ($this->_sections['List']['iteration'] == $this->_sections['List']['total']);
?>
      <li> <span><?php echo $this->_tpl_vars['fliters'][$this->_sections['List']['index']]['value']; ?>
</span> <a  onclick="resetinput('<?php echo $this->_tpl_vars['fliters'][$this->_sections['List']['index']]['field']; ?>
','<?php echo $this->_tpl_vars['fliters'][$this->_sections['List']['index']]['key']; ?>
');"><img src="images/close-selected.gif" width="14" height="14" alt="" /></a></li> 
    <?php endfor; endif; ?>
<!--<li> <span>Unlisted</span> <a href="javascript:;"><img src="images/close-selected.gif" width="14" height="14" alt="" /></a></li>-->

<li class="result-select-close"><a href="home.php">
                                             <img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
</ul>
 
<?php endif; ?>
<div style="float:right;">
  <?php if ($this->_tpl_vars['searchexport']): ?>
            <div class="btn-cnt" style="float:right; padding: 8px 0 !important;"><input name="exportcompare" class="home_export" id="exportcompare" type="button" value="EXPORT" /></div>
<?php elseif ($this->_tpl_vars['searchexport2']): ?>
          
            <div class="btn-cnt" style="float:right;  padding: 8px 0 !important;"><input name="exportcompare" class="home_export" id="exportcompare" type="button" value="EXPORT" /></div>

<?php elseif ($this->_tpl_vars['searchexport3']): ?> 
       
            <div class="btn-cnt" style="float:right;  padding: 8px 0 !important;"><input name="exportcompare" calss="home_export" id="exportcompare" type="button" value="EXPORT" /></div>

<?php endif; ?>
     <?php if ($this->_tpl_vars['pageName1'] == 'home.php' || $this->_tpl_vars['pageName1'] == 'home1.php' || $this->_tpl_vars['pageName1'] == 'homedev.php'): ?>
  <div class="page-no" style="position:relative"><span>Show </span>
    <select name="limit" onchange="this.form.submit();">
    <option value="all" <?php if ($this->_tpl_vars['limit'] == 'all'): ?>selected<?php endif; ?>>All</option>
    <option value="10" <?php if ($this->_tpl_vars['limit'] == 10): ?>selected<?php endif; ?>>10</option>
    <option value="25" <?php if ($this->_tpl_vars['limit'] == 25): ?>selected<?php endif; ?>>25</option>
    <option value="50" <?php if ($this->_tpl_vars['limit'] == 50): ?>selected<?php endif; ?>>50</option>
</select>
</div>
<?php endif; ?>
<div class="page-no" style="position:relative"><span>Sort By </span><div class="btn-cnt" style="float:right; padding: 8px 10px !important;"><input name="exportcompare" class="sorthead asc home_export" id="sortnew" type="button" value="Latest Added" /></div></div>
</div>

</div><br>
<?php endif; ?>