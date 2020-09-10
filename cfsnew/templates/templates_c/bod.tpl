<?php /* Smarty version 2.5.0, created on 2013-11-21 04:46:10
         compiled from bod.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript" language="javascript1.2">


	function suggest(inputString){
			$(\'#submitbtn\').hide();
			$(\'#viewfinance\').hide();
			if(inputString.length == 0) {
				$(\'#suggestions\').fadeOut();
			} else {
			$(\'#country\').addClass(\'load\');
				$.post("autosuggest.php", {queryString: ""+inputString+""}, function(data){
					if(data.length >0) {
						$(\'#suggestions\').fadeIn();
						$(\'#suggestionsList\').html(data);
						$(\'#country\').removeClass(\'load\');
					}
				});
			}
	}
	function suggestsectors(str)
	{
		var xmlhttp;
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
			document.getElementById("sectordisplay").innerHTML=xmlhttp.responseText;
                        $(document).foundation();
			//alert(xmlhttp.responseText);
			}
		  }
		xmlhttp.open("GET","autosector.php?queryString1="+str,true);
		xmlhttp.send();
	}

	
	/*function fill(thisValue) {
		$(\'#country\').val(thisValue);
		setTimeout("$(\'#suggestions\').fadeOut();", 300);
	}*/
        function fill(thisValue) {
		$(\'#country\').val(thisValue);
		setTimeout(function(){
                   $(\'#suggestions\').fadeOut(); 
                   $(\'#suggestionsList\').html("");	
                }, 400);
               
	}
	function fillHidden(thisid) {
		$(\'#cid\').val(thisid);
		$(\'#submitbtn\').show();
		$(\'.suggestionsBox\').hide();
                $(\'#country\').addClass(\'load\');
                $(\'#viewfinance\').html(\'<a href="viewannual.php?vcid=\'+thisid+\'" target="_blank"><img src="images/cfs/vfinancial.jpg" style="width:87px; height:25px;" /></a>\');
		$(\'#viewfinance\').show();
		setTimeout(function(){
                   $(\'#suggestions\').fadeOut();
                    $(\'#suggestionsList\').html("");	
                }, 400);
               
}
</script>
'; ?>


<?php echo '
<script type="text/javascript" language="javascript1.2">

function passwordcheck(){
    var Password = $(\'#Password\').val();
    var Password1 = $(\'#Password1\').val();
    if(Password!=Password1){
           alert("Password not match");
    }
}

function validate(){
    var Password = $(\'#Password\').val();
    var Password1 = $(\'#Password1\').val();
    if(Password==\'\' || Password1==\'\'){
           alert("Please enter password");
           return false;
    }
    return true;
}
</script>
'; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("leftpanel.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</form>
<form name="Frm_HmeSearch" id="Frm_HmeSearch" action="changepassword.php" method="post" onsubmit='return validate();'>
<div class="container-right">
    <div class="companies-details">
<div class="detailed-title-links"> <h2><?php echo $this->_tpl_vars['nod']; ?>
</h2>   <a class="back" href="details.php?vcid=<?php echo $this->_tpl_vars['VCID']; ?>
">BACK</a> </div>


<div class="filing-cnt">

 

 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr> 
    <th>Company Name </th>
    <th> Date of Appointment</th>
    <th>Date of Cessation  </th> 
</tr></thead>
<tbody> 
 <?php if (isset($this->_sections['dirname'])) unset($this->_sections['dirname']);
$this->_sections['dirname']['name'] = 'dirname';
$this->_sections['dirname']['loop'] = is_array($this->_tpl_vars['dir']) ? count($this->_tpl_vars['dir']) : max(0, (int)$this->_tpl_vars['dir']);
$this->_sections['dirname']['show'] = true;
$this->_sections['dirname']['max'] = $this->_sections['dirname']['loop'];
$this->_sections['dirname']['step'] = 1;
$this->_sections['dirname']['start'] = $this->_sections['dirname']['step'] > 0 ? 0 : $this->_sections['dirname']['loop']-1;
if ($this->_sections['dirname']['show']) {
    $this->_sections['dirname']['total'] = $this->_sections['dirname']['loop'];
    if ($this->_sections['dirname']['total'] == 0)
        $this->_sections['dirname']['show'] = false;
} else
    $this->_sections['dirname']['total'] = 0;
if ($this->_sections['dirname']['show']):

            for ($this->_sections['dirname']['index'] = $this->_sections['dirname']['start'], $this->_sections['dirname']['iteration'] = 1;
                 $this->_sections['dirname']['iteration'] <= $this->_sections['dirname']['total'];
                 $this->_sections['dirname']['index'] += $this->_sections['dirname']['step'], $this->_sections['dirname']['iteration']++):
$this->_sections['dirname']['rownum'] = $this->_sections['dirname']['iteration'];
$this->_sections['dirname']['index_prev'] = $this->_sections['dirname']['index'] - $this->_sections['dirname']['step'];
$this->_sections['dirname']['index_next'] = $this->_sections['dirname']['index'] + $this->_sections['dirname']['step'];
$this->_sections['dirname']['first']      = ($this->_sections['dirname']['iteration'] == 1);
$this->_sections['dirname']['last']       = ($this->_sections['dirname']['iteration'] == $this->_sections['dirname']['total']);
?>
      <tr><td style="alt"><!--a href='details.php?vcid=<?php echo $this->_tpl_vars['dir'][$this->_sections['dirname']['index']]['Company_Id']; ?>
' --><?php echo $this->_tpl_vars['dir'][$this->_sections['dirname']['index']][6]; ?>
</td> <td><?php echo $this->_tpl_vars['dir'][$this->_sections['dirname']['index']][9]; ?>
</td><td><?php echo $this->_tpl_vars['dir'][$this->_sections['dirname']['index']][10]; ?>
</td></tr>
 <?php endfor; else: ?>
  <tr><td colspan="5">No Companies Found</td></tr>
<?php endif; ?>
</tbody>
  </table>
  
 
 </div>
 
  
  
  
</div>
</div>
<!-- End of Container -->
</form>


</body>
</html>