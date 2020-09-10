<?php /* Smarty version 2.5.0, created on 2018-08-30 05:17:19
         compiled from admin/pmanagement.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include('admin/header.tpl', array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo $this->_tpl_vars['ADMIN_CSS_PATH']; ?>
home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
<?php echo '
    
<script  type="text/javascript" language="javascript1.2">

jQuery.noConflict();

function suggest(inputString){
		
                var searchby = jQuery(\'#searchby\').val();
                     
                     if(searchby==0) { var searchbystring = \'FCompanyName\';}
                     else if(searchby==1) { var searchbystring = \'CIN\';}
        
		if(inputString.length == 0) {
			jQuery(\'#suggestions\').fadeOut();
                        jQuery(\'#cid\').val(\'\');
		} else if(inputString.length > 2) {
		jQuery(\'#searchname\').addClass(\'load\');
			jQuery.post("autosuggest_cname_cin.php", {queryString: ""+inputString+"", searchby:""+searchbystring+""}, function(data){
				if(data.length >0) {
					jQuery(\'#suggestions\').fadeIn();
					jQuery(\'#suggestionsList\').html(data);
					jQuery(\'#searchname\').removeClass(\'load\');
				}
			});
		}
}
function fill(thisValue) {
      if(thisValue){
        jQuery(\'#searchname\').val(thisValue);    
        }
        
        setTimeout(jQuery(\'#suggestions\').fadeOut(), 300);
       
        //jQuery(\'#suggestions\').hide;
}
function clearsearch(){
    jQuery(\'#searchname\').val(\'\');  
    setTimeout(jQuery(\'#suggestions\').fadeOut(), 300);
}
</script>
<script  type="text/javascript" language="javascript1.2">
function deleteReg(op,extra)
{	if (confirm("Are you sure you want to delete? ")) {
		
	document.addformspringform.op.value=op;
	document.addformspringform.extra.value=extra;
	document.addformspringform.submit();

    } else {
       document.addformspringform.op.value=op;
    }
}

function ChangeStatus(op,status,msg)
{	if (confirm("Are you sure you want to "+msg)) {
		
	document.addformspringform.op.value=op;
	document.addformspringform.status.value=status;
	document.addformspringform.edstatus.value=msg;
	document.addformspringform.submit();

    } else {
       document.addformspringform.op.value=op;
    }
}

</script>
<style>
    
.suggestionsBox {
max-height: 500px;
overflow-y: scroll;
z-index: 10;
min-width: 305px;
margin-left: 0px !important;
}
.suggestionList ul
{
    padding: 0 !important; 
    }
.suggestionList ul li{
color: #fff;    
}
</style>
'; ?>

<body>
<form  method="post" name="addformspringform" id="addformspringform">
  <input type="hidden" name="op" />
  <input type="hidden" name="extra" />
  <input type="hidden" name="status" />
  <input type="hidden" name="edstatus" />
</form>
<div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Company Profile </h1><a href="addcprofile.php" style="float: right;margin-top: -34px;">Add Company Profile</a>
        </div>
          <div id="suggest" style="width:500px;float:left; position: relative;">
            <form action="pmanagement.php" method="get" id="search">
                <input type="text" placeholder="Search By " name="searchname" id="searchname" value="<?php if ($this->_tpl_vars['searchname']): ?><?php echo $this->_tpl_vars['searchname']; ?>
<?php endif; ?>" onkeyup="suggest(this.value);" onblur="fill();" class=""  autocomplete=off style="height: 24px; padding-right: 90px;"   required>
                <select style="width: 85px; top:3px;left:217px; position:absolute" id="searchby" name="searchby" onchange="clearsearch();">
                    <option value="0" <?php if ($this->_tpl_vars['searchby'] == '0'): ?> selected <?php endif; ?>>Company</option>
                    <option value="1" <?php if ($this->_tpl_vars['searchby'] == '1'): ?> selected <?php endif; ?>>CIN</option>
                </select>
                <input type="submit" value="Search">
                <?php if ($this->_tpl_vars['searchname']): ?> <input type="button" value="Show all" onclick="window.location.href='pmanagement.php';"> <?php endif; ?>
                <div class="suggestionsBox" id="suggestions" style="display: none;">
				  <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
				</div>
                
             </form>                   
	    </div>
          
                <div id="alphaPagination" style="float:right;margin-top: 1%;">
                        <?php if (isset($this->_sections['i'])) unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($this->_tpl_vars['alphaletter']) ? count($this->_tpl_vars['alphaletter']) : max(0, (int)$this->_tpl_vars['alphaletter']);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                                <?php if ($this->_tpl_vars['setalphaletter'] == $this->_tpl_vars['alphaletter'][$this->_sections['i']['index']]): ?>
                                    <a href="pmanagement.php?pag=<?php echo $this->_tpl_vars['alphaletter'][$this->_sections['i']['index']]; ?>
"> <span style="text-decoration: underline;font-weight: bold;"><?php echo $this->_tpl_vars['alphaletter'][$this->_sections['i']['index']]; ?>
</span></a>	
                                <?php else: ?>
                                <a href="pmanagement.php?pag=<?php echo $this->_tpl_vars['alphaletter'][$this->_sections['i']['index']]; ?>
"> <?php echo $this->_tpl_vars['alphaletter'][$this->_sections['i']['index']]; ?>
</a>	
                                <?php endif; ?>
                        <?php endfor; endif; ?>
                </div><br><br>
         
          <div class="row" style="clear:both; margin-top: 1%">
          <div style="margin-left: 2%;">
           
			<table class="condensed-table">
        <thead>
          <tr>
            <th width="10%">ID</th>
            <th width="33%">Company Name</th>
            <th width="33%">CIN</th>
            <th width="31%">Added Date </th>
            <th colspan="2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($this->_sections['i'])) unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($this->_tpl_vars['CProfileList']) ? count($this->_tpl_vars['CProfileList']) : max(0, (int)$this->_tpl_vars['CProfileList']);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
		  <tr>
            <th><?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['Company_Id']; ?>
</th>
            <td><?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['FCompanyName']; ?>
</td>
            <td><?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['CIN']; ?>
</td>
            <td><?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['Added_Date']; ?>
</td>
            <td width="3%" align="center"><a href="editcprofile.php?cpid=<?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['Company_Id']; ?>
"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>
            <?php if ($this->_tpl_vars['Usr_Type'] != 2): ?><td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','<?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['Company_Id']; ?>
');" alt="delete" title="delete"/></td>
        		<td width="3%">
        		<?php if ($this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['Profile_Flag'] == '1'): ?>
        			<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus('changestatus','<?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['Company_Id']; ?>
','Disable');"  style="cursor:pointer;"/>
        		<?php else: ?>
        			<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus('changestatus','<?php echo $this->_tpl_vars['CProfileList'][$this->_sections['i']['index']]['Company_Id']; ?>
','Enable');"  style="cursor:pointer;"/>
        		<?php endif; ?>	
        		</td><?php endif; ?>
          </tr>
		  <?php endfor; else: ?>
			<tr>
				<td colspan="">&nbsp;</td>
				<td colspan="3" align="center">No Data Found !</td>
				<td colspan="">&nbsp;</td>
			</tr>		  		  
		  <?php endif; ?>
  <tr>
  <td  colspan="8" style="color:#000000; padding-left:390px;padding-top:15px;" align="right">
		<?php if ($this->_tpl_vars['pages_New']['first'] == '0' && $this->_tpl_vars['pages_New']['next'] == '0'): ?>
<tr><td colspan="8">&nbsp;</td></tr>
		<?php else: ?>

		<?php if ($this->_tpl_vars['pages_New']['first']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['first']; ?>
" style="color:#000000;" >first</a><?php else: ?>first&nbsp;<?php endif; ?> |

		<?php if ($this->_tpl_vars['pages_New']['first']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['previous']; ?>
" style="color:#000000;">&lt; previous</a><?php else: ?> &lt;   
		previous<?php endif; ?> |

		<?php if ($this->_tpl_vars['pages_New']['next']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['next']; ?>
" style="color:#000000;">next &gt;</a><?php else: ?> next &gt;&nbsp;	<?php endif; ?> |

		<?php if ($this->_tpl_vars['pages_New']['last']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['last']; ?>
" style="color:#000000;">last</a><?php else: ?>&nbsp;last<?php endif; ?>

		<?php endif; ?>
</td></tr>	  
        </tbody>
      </table>
     <?php if ($this->_tpl_vars['Usr_Type'] != 2): ?>
        <a href='companyexport.php' style="float: right;"><input type="button" value="Export"></a>
        <a href='companynaicsexport.php' style="float: right; margin-right: 10px;"><input type="button" value="Export with NAICS"></a>
     <?php endif; ?>
          </div>          
        </div>
      </div>

      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
</body>