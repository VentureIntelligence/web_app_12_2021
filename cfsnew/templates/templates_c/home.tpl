<?php /* Smarty version 2.5.0, created on 2021-03-30 18:22:39
         compiled from home.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'assign', 'home.tpl', 197, false),
array('function', 'math', 'home.tpl', 213, false),
array('modifier', 'replace', 'home.tpl', 197, false),
array('modifier', 'lower', 'home.tpl', 204, false),
array('modifier', 'capitalize', 'home.tpl', 204, false),
array('modifier', 'explode', 'home.tpl', 218, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("leftpanel.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container-right">
<?php if ($this->_tpl_vars['searchupperlimit'] >= $this->_tpl_vars['searchlowerlimit']): ?>   
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("filters.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '

    <style>
.entry-pad{
padding:0px 10px; }
        .mobileRedirectPopup {
            position: fixed !important;
            background: #fff;
            height: 185px;
            width:700px;
            border-radius: 10px;
            left:50%;
            top:25%;
            margin-top:-92.5px;
            margin-left:-350px;
            -webkit-box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            z-index:1000;
            display:none;
        }
        .backdrop{
            height:100vh;
            width:100vw;
            background:rgba(50, 50, 50, 0.75);
            z-index:500;
            position:absolute;
            top:0px;
            left:0px;
            overflow:hidden;
        }
        .app-text-col h5{
            font-size:1em !important;
            color:#302922 !important;
            margin-left: 20px;
        }
        h5 {
            margin: 10px 0px;
        }

        .text-left {
            text-align: left;
        }

        .btn {
            padding: 10px;
            width: 100%;
            border-radius: 25px;
            border: 0px solid #000;
            -webkit-box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            text-decoration: none;
        }
         .redirect-button-col .btn {
            margin-top: 2px;
        }
        .redirect-button-col .btn-primary {
            background: #302922 !important;
        }
        .redirect-button-col .btn-primary a{
            color: white !important;
        }
        .redirect-button-col .btn-default {
            background: unset !important;
            color: #302922;
        }

        .d-none {
            display: none;
        }

        .d-block {
            display: block;
        }

        .row {
            width: 100%;
            display: flex;
            /* margin-left: -15px;
            margin-left: -15px; */
            margin: 10px 0;
        }

        .image-col {
            width: 18%;
            padding-right: 0px;
            padding-left: 15px;
        }

        .app-text-col {
            width: 50%;
            padding-right: 15px;
            padding-left: 0px;
        }

        .redirect-button-col {
            width: 35%;
            padding-right: 15px;
            padding-left: 15px;
            text-align: center;
        }

        .w-100 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }
        .popup-title{
            padding-left:20px;
            padding-right:20px;
            margin-bottom:15px;
        }
        .popup-title h5 {
            border-bottom: 1.25px solid #302922;
            padding-bottom: 10px;
            padding-top: 5px;
            font-size:1rem;
        }

        .image-col img {
            max-width: 50px !important;
            border-radius: 50px;
            height: 40px;
            margin-top:1px;
        }

        .btn a {
            text-decoration: none;
            color: #000;
        }

        .btn.btn-primary a {
            color: #fff !important;
        }

        .btn:focus {
            outline: none;
        }
        .list-tab{
            height:39px;
            overflow: initial;
        }
        .limit{
            width: 62px !important;
        }
    </style>
'; ?>

<div class="backdrop"></div>
 
<div class="list-tab"  style="margin-top: 26px;">

<ul>
<li><a  href="home.php" class="active postlink"><i></i> LIST VIEW</a></li>

</ul><div class="page-no" style="position: initial;width">
<select name="currency" class="limit currency"  onchange="this.form.submit();">
    <option value="INR" <?php if ($this->_tpl_vars['currency'] == 'INR'): ?>selected<?php endif; ?>>INR</option>
    <option value="USD" <?php if ($this->_tpl_vars['currency'] == 'USD'): ?>selected<?php endif; ?>>USD</option>
  </select>
  <?php if ($this->_tpl_vars['currency'] == 'INR'): ?><span>(in Rs. Cr) &nbsp;&nbsp;</span><?php endif; ?>
  <?php if ($this->_tpl_vars['currency'] == 'USD'): ?><span>(in $ M) &nbsp;&nbsp;</span><?php endif; ?>
  </div>
</div>

<div class="companies-list">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
        <th  class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortcompany'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortcompany">Company Name</th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortrevenue'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortrevenue">Revenue</th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortebita'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortebita">EBITDA</th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortpat'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortpat">PAT</th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortdetailed'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortdetailed">Detailed</th>

<?php if ($this->_tpl_vars['chargewhere'] != ''): ?>

 <th style='background:none'> Date of Charge</th> 
 <th style='background:none'> Charge Amount</th> 
 <th style='background:none'> Charge Holder</th> 
<?php endif; ?>


</tr></thead>
<tbody>  
  
  <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['SearchResults']) ? count($this->_tpl_vars['SearchResults']) : max(0, (int)$this->_tpl_vars['SearchResults']);
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
    <?php echo $this->_plugins['function']['assign'][0](array('var' => 'foo','value' => $this->_run_mod_handler('replace', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY'], ' ', '_')), $this) ; ?>

   
    
      <tr><td class="name-list" style="text-transform: uppercase"> <span class="has-tip" data-tooltip="" title="<?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> Listed<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> Privately held(Ltd)<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> Partnership <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> Proprietorship<?php endif; ?>"><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> L<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> PVT<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> PART <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> PROP<?php endif; ?></span>
              <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']): ?>
            <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&c=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']; ?>
&currencyval=<?php echo $this->_tpl_vars['currency']; ?>
" title="Click here to view Annual Report" 
         
        ><?php echo $this->_run_mod_handler('capitalize', true, $this->_run_mod_handler('lower', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['SCompanyName'])); ?>
</a>	

        <?php else: ?>
        <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&currencyval=<?php echo $this->_tpl_vars['currency']; ?>
" title="Click here to view Annual Report" 
       
        ><?php echo $this->_run_mod_handler('capitalize', true, $this->_run_mod_handler('lower', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['SCompanyName'])); ?>
</a>

        <?php endif; ?>
              </td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome']; ?>
<?php elseif ($this->_tpl_vars['currency'] == 'INR'): ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php elseif ($this->_tpl_vars['currency'] == 'USD'): ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x / z)/y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome'],'y' => 1000000,'z' => $this->_tpl_vars['yearcurrency'][$this->_tpl_vars['foo']],'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA']; ?>
<?php elseif ($this->_tpl_vars['currency'] == 'INR'): ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php elseif ($this->_tpl_vars['currency'] == 'USD'): ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x / z)/y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA'],'y' => 1000000,'z' => $this->_tpl_vars['yearcurrency'][$this->_tpl_vars['foo']],'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT']; ?>
<?php elseif ($this->_tpl_vars['currency'] == 'INR'): ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php elseif ($this->_tpl_vars['currency'] == 'USD'): ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x / z)/y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'],'y' => 1000000,'z' => $this->_tpl_vars['yearcurrency'][$this->_tpl_vars['foo']],'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY'] > 0): ?>
    <td>
        <?php echo $this->_plugins['function']['assign'][0](array('var' => 'FY','value' => $this->_run_mod_handler('explode', true, ' ', $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY'])), $this) ; ?>

        <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']): ?>
            <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&c=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']; ?>
&currencyval=<?php echo $this->_tpl_vars['currency']; ?>
" title="Click here to view Annual Report" 
         
        >FY<?php echo $this->_tpl_vars['FY'][0]; ?>
 </a>	(upto <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Years<?php endif; ?> <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Years<?php endif; ?> )	

        <?php else: ?>
        
        <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&currencyval=<?php echo $this->_tpl_vars['currency']; ?>
" title="Click here to view Annual Report" 
       
        >FY<?php echo $this->_tpl_vars['FY'][0]; ?>
 </a>	(upto <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Years<?php endif; ?> <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Years<?php endif; ?> )	
        <?php endif; ?>
       
    </td> 
     <?php else: ?>
         <td><a> </a></td>
     <?php endif; ?>
     
    <?php if ($this->_tpl_vars['chargewhere'] != ''): ?>
  
    <td> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['dateofcharge']; ?>
 </td> 
    <td> <?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_run_mod_handler('replace', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['chargeamt'], ',', ''),'y' => 10000000,'format' => "%.2f"), $this) ; ?>
 </td> 
    <td> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['chargeholder']; ?>
 </td> 
   <?php endif; ?>
     
     
    
  </tr>
  <?php endfor; endif; ?>
   
  </tbody>
  </table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("pagination.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<input type="hidden" name="sortby" id="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
"/>
<input type="hidden" name="sortorder" id="sortorder" value="<?php echo $this->_tpl_vars['sortorder']; ?>
"/>
<input type="hidden" name="pageno" id="pageno" value="<?php echo $this->_tpl_vars['curPage']; ?>
"/>
<input type="hidden" name="searchv" id="searchv" value="<?php echo $this->_tpl_vars['searchv']; ?>
"/>
<input type="hidden" name="countflag" value="<?php echo $this->_tpl_vars['countflag']; ?>
" class="countflag"/>
               <input type="hidden" id="filterData_top" name="filterData_top" value="<?php if ($GLOBALS['HTTP_SESSION_VARS']['totalResults']): ?><?php echo $GLOBALS['HTTP_SESSION_VARS']['totalResults_top']; ?>
<?php endif; ?>"/>
</form>

<?php if ($this->_tpl_vars['searchexport']): ?>
    <?php if ($this->_tpl_vars['chargewhere'] != ''): ?>
    <form name="Frm_Compare" id="exportform" action="homeexportwithcharges.php" method="post" enctype="multipart/form-data">
    <?php else: ?>
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
    <?php endif; ?>    
            <input type="hidden" name="exportenable" id="exportenable" value="0"/> 
            <input type="hidden" name="currency" id="currency" value="<?php echo $this->_tpl_vars['currency']; ?>
"/>     
             <input type="hidden" name="filters" id="filters" value=" <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?><?php echo $this->_tpl_vars['fliters'][$this->_sections['List']['index']]['value']; ?>
, <?php endfor; endif; ?>"/>
            <input type="hidden" id="exportexcel" name="exportexcel" value="<?php echo $this->_tpl_vars['searchexport']; ?>
"/>
            <div class="btn-cnt p10" style="float:right;"><input class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
</div>

<?php elseif ($this->_tpl_vars['searchexport2']): ?>
 <?php if ($this->_tpl_vars['chargewhere'] != ''): ?>
    <form name="Frm_Compare" id="exportform" action="homeexportwithcharges.php" method="post" enctype="multipart/form-data">
    <?php else: ?>
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
    <?php endif; ?> 
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>   
            <input type="hidden" name="currency" id="currency" value="<?php echo $this->_tpl_vars['currency']; ?>
"/>  
            <input type="hidden" id="exportexcel" name="exportexcel1" value="<?php echo $this->_tpl_vars['searchexport2']; ?>
"/>
            <div class="btn-cnt p10" style="float:right;"><input class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>


<?php elseif ($this->_tpl_vars['searchexport3']): ?>
    <?php if ($this->_tpl_vars['chargewhere'] != ''): ?>
    <form name="Frm_Compare" id="exportform" action="homeexportwithcharges.php" method="post" enctype="multipart/form-data">
    <?php else: ?>
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
    <?php endif; ?> 
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" name="currency" id="currency" value="<?php echo $this->_tpl_vars['currency']; ?>
"/> 
            <input type="hidden" id="exportexcel" name="exportexcel2" value="<?php echo $this->_tpl_vars['searchexport3']; ?>
"/>
            <div class="btn-cnt p10" style="float:right;"><input  class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
</div>

<?php endif; ?>
</div>
  
<?php else: ?>
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
<?php endif; ?>

<!-- End of container-right -->

</div>
<!-- End of Container -->

<div class="lb" id="popup-box">
	<div class="title">Dont find a Company ?</div>
        <form name="addDBFinacials" id="addDBFinacials">
            <div class="entry entry-pad" style="padding-top:10px"> 
        	<label> From</label>
                <input type="text" name="fromaddress" id="fromaddress" value="<?php echo $this->_tpl_vars['userEmail']; ?>
"  />
        </div>
        <div class="entry entry-pad">
        	<label> To</label>
                <input type="text" name="toaddress" id="toaddress" value="cfs@ventureintelligence.com" readonly="" />
        </div>
        <div class="entry entry-pad">
        	<label> CC</label>
                <input type="text" name="cc" id="cc" value="" />
        </div>
                <input type="hidden" name="subject" id="subject" value="Please add financials of the company to the Database" readonly="" />
        <div class="entry entry-pad"> 
        	<h5>Message</h5>
                <textarea name="textMessage" id="textMessage">Please add to the database financials for the company. </textarea>
        </div>
        <div class="entry">
            <input type="button" value="Send" id="mailbtn1" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

    </form>
</div>
<div id="maskscreen"></div>
<div class="lb" id="export-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" class="agree-export">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div class="mobileRedirectPopup">
        <div class="popup-title ">
            <h5 class="text-center">See Venture Intelligence in ...</h5>
        </div>
        <div class="row">
            <div class="image-col text-center"><img
                    src="images/cfs_app_icon@2x.png"></div>
            <div class="app-text-col">
                <h5 class="text-left vi_app">
                    VI <span class="login-type"></span> App
                </h5>
            </div>
            <div class="redirect-button-col">
                <button class="btn btn-primary"><a href="#" class="redirectApp">Open</a></button>
            </div>
        </div>
        <div class="row">
            <div class="image-col text-center">
            <?php if ($this->_tpl_vars['user_browser'] == 'Safari'): ?>
                <img
                    src="https://www.pngfind.com/pngs/m/314-3147164_download-png-ico-icns-flat-safari-icon-png.png"
            alt=""><?php endif; ?><?php if ($this->_tpl_vars['user_browser'] == 'Chrome'): ?>
            <img
                    src="https://www.pngfind.com/pngs/m/98-981105_chrome-icon-free-download-at-icons8-icono-google.png"
                    alt="">
                   <?php endif; ?>
                   </div>
            <div class="app-text-col">
                <h5 class="text-left">
                    <?php echo $this->_tpl_vars['user_browser']; ?>

                </h5>
            </div>
            <div class="redirect-button-col">
                <button class="btn btn-default continue">Continue</button>
            </div>
        </div>
    </div>
</body>
</html>
<?php echo '

    <script type="text/javascript">
        $(document).ready(function () {
            var userAgent = navigator.userAgent.toLowerCase();
            var login = "cfs";
            var Android = navigator.userAgent.match(/Android/i);
            var IOS = navigator.userAgent.match(/iPhone|iPad|iPod|macintosh/i);
            var redirectButton = $(".redirectApp");
            var loginTextSpan = $(".login-type");
            if (Android) {
                $(".mobileRedirectPopup").show();
                if (login == "cfs") {
                    loginTextSpan.text("CFS");
                    redirectButton.attr("href", "intent://scan/#Intent;scheme=Venture+intelligence;package=com.venture.intelligence;S.browser_fallback_url=https://play.google.com/store/apps/details?id=com.venture.intelligence;end")

                } else if (login == "pe") {
                    loginTextSpan.text("PE");
                    redirectButton.attr("href", " intent://scan/#Intent;scheme=Venture+intelligence;package=com.intelligence.venture;S.browser_fallback_url=https://play.google.com/store/apps/details?id=com.intelligence.venture;end")
                }
                // alert("Android")
            } else if (IOS) {
                // alert("IOS")
                $(".mobileRedirectPopup").hide();
                $(".backdrop").hide();
            }else{
                //alert("desktop");
                $(".mobileRedirectPopup").hide();
                $(".backdrop").hide();
            }
        })
        
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(\';\');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == \' \') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        $(".redirect-button-col .btn").on("click", function () {
            setCookie("mobilepopupcfs", "show", 1);
        });
        $(".continue").on("click", function () {
            $(".mobileRedirectPopup").hide();
            $(".backdrop").hide();
            setCookie("mobilepopupcfs", "show", 1);
        })

        $(document).ready(function(){
          
           var Android = navigator.userAgent.match(/Android/i);
            IOS = navigator.userAgent.match(/iPhone|iPad|iPod|macintosh/i);
            if(Android ){
                 
                    var popup = getCookie("mobilepopupcfs");
                    if (popup == "show") {
                        $(".mobileRedirectPopup").hide();
                        $(".backdrop").hide();  
                    }else{
                        
                            $(".mobileRedirectPopup").show();
                            $(".backdrop").show();
                        
                    }
                        
            }else{
                        $(".mobileRedirectPopup").hide();
                        $(".backdrop").hide();
                    }
       })

        $(document).ready(function() {
              $(".sorthead").live(\'click\',function(){
                 // $(this).html($(this).text()+\'<img src="images/ajax-loader.gif" style="float:right;height:20px;"/>\');
                 $(this).addClass(\'loadingth\');
                sortby=$(this).attr(\'id\');
                if($(this).hasClass("asc")){
                    sortorder="desc";
                }
                else if($(this).hasClass("desc")){
                    sortorder="asc";
                }
                else{
                    sortorder="desc";
                }
                 $("#sortby").val(sortby);
                 $("#sortorder").val(sortorder);
                   $.ajax({
            type: "POST",
          url: "ajaxhome.php",
          data: $("#Frm_HmeSearch").serializeArray(),
          success: function( data ) {
              $(\'.companies-list\').html(data);
             // alert(data);
          }
        });
                 //$("#Frm_HmeSearch").submit();
              });
        });
        
        
        $(\'input[name=exportcompare]#exportcompare\').click(function(){
              jQuery(\'#maskscreen\').fadeIn(1000);
              $( \'#export-popup\' ).show();
              return false; 
            });
        $( \'.agree-export\' ).on( \'click\', function() {    
            initExport();
            jQuery(\'#maskscreen\').fadeOut(1000);
            $( \'#export-popup\' ).hide();
            return false;
        });
        $( \'#export-popup\' ).on( \'click\', \'.close-lookup\', function() {
            $( \'#export-popup\' ).hide();
            jQuery(\'#maskscreen\').fadeOut(1000);
        });
            
            function initExport(){
                    $.ajax({
                        url: \'ajxCheckDownload.php\',
                        dataType: \'json\',
                        success: function(data){
                            var downloaded = data[\'recDownloaded\'];
                            var exportLimit = data.exportLimit;
                            var currentRec =  '; ?>
<?php echo $this->_tpl_vars['totalrecord']; ?>
<?php echo ';

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                                    if (currentRec < remLimit){
                                $("#exportform").submit();
                            }else{
                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                            }
                        },
                        error:function(){
                            alert("There was some problem exporting...");
                        }

                    });
                }
        
 $(\'.updateFinancialHome\').click(function(){ 
                    jQuery(\'#maskscreen\').fadeIn(1000);
                    jQuery(\'#popup-box\').fadeIn();   
                    return false;
                });
            $(\'#cancelbtn\').click(function(){ 
        
               jQuery(\'#popup-box\').fadeOut();   
                jQuery(\'#maskscreen\').fadeOut(1000);
               return false;
           });
            
        
 $(\'.oldFinacialData\').click(function(){ 
     $(\'#oldFinacialDataFlag\').val(\'display\');
                    $(\'#Frm_HmeSearch\').submit();
                });
            
    function updateFinancials(from, to, subject, link){ 
        var textMessage = $(\'#textMessage\').val();
          if(textMessage !=\'\')
          {
              $.ajax({
                 url: \'ajaxsendmails.php\',
                  type: "POST",
                 data: { to : to, subject : subject, message : textMessage , url_link : link, from : from },
                 success: function(data){
                        if(data=="1"){
                            alert("Your request has been sent successfully");
                           jQuery(\'#popup-box\').fadeOut();   
                           jQuery(\'#maskscreen\').fadeOut(1000);
                    }else{
                        alert("Try Again");
                    }
                 },
                 error:function(){
                     alert("There was some problem sending request...");
                 }

             });
           }
       }
       $(document).ready(function(){
         $(\'.refine\').on(\'click\',function(){    
            $(\'.countflag\').val(\'1\');   
        });
 $(\'#mailbtn1\').click(function(e){
        e.preventDefault(); 
        var to = $(\'#toaddress\').val().trim();
        var subject = $(\'#subject\').val().trim();
        var textMessage = $(\'#textMessage\').val().trim();
        var from = $(\'#fromaddress\').val().trim();
        var cc = $(\'#cc\').val().trim();
        if(from ==\'\'){
            alert("Please enter the from address");
            $(\'#fromaddress\').focus();
            return false;
        }
        else if(!(/^([\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4})?$/).test(from)){
            alert(\'Invalid from address\');
            $(\'#fromaddress\').focus();
            return false;
        }
        else if((cc !=\'\') && (!(/^([\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4})?$/).test(from))){
            alert(\'Invalid CC\');
            $(\'#fromaddress\').focus();
            return false;
        }
        else if(textMessage ==\'\')
        {
          alert("Please enter the message");
            $(\'#textMessage\').focus();
            return false;
        }else{
            $.ajax({
               url: \'ajaxsendmails.php\',
                type: "POST",
               data: { to : to, subject : subject, message : textMessage , cc: cc, from : from },
               success: function(data){
                      if(data=="1"){       
                          alert("Your request has been sent successfully"); 
                         // $(\'#addDBFinacials\')[0].reset();
                         $(\'#fromaddress\').val(\'\');
                         $(\'#textMessage\').val(\'\');
                         $(\'#cc\').val(\'\');
                         jQuery(\'#popup-box\').fadeOut();   
                         jQuery(\'#maskscreen\').fadeOut(1000); 
                        return true;
                  }else{
                      alert("Try Again");
                        return false;
                  }
               },
               error:function(){
                   alert("There was some problem sending request...");
                    return false;
               }
           });
           }
       }); 
       });
    </script>
    <style>
        #maskscreen {
            position: fixed;
            left: 0;
            top: 0;
            right:0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            z-index: 8000;
            overflow: hidden;
            display: none;
        }
        .lookup-body { margin-bottom:20px; padding:10px; text-align: center; }
        .lookup-body a,
        .lookup-body a:hover,
        .lookup-body a:focus,
        .lookup-body a:visited { color: #fff; background: #7f6000; text-decoration: none; padding: 5px; }
        .lookup-body span { font-size: 12px; }
        .name-list{
            text-transform: uppercase !important;
            }
            .filter-selected{
                overflow: visible !important;
                }
                .list-tab{
                    clear:both !important;
                    }
                    .custom.dropdown ul li { width: 100%;}
        #export-popup .agree-export {
            margin-right: 10px;
        }

        #export-popup .close-lookup {
            background-color: #000;
        }
    </style>
'; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("popup.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>