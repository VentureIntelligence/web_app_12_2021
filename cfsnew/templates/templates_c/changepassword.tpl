<?php /* Smarty version 2.5.0, created on 2019-04-04 08:39:33
         compiled from changepassword.tpl */ ?>
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
  <div class="change-password">  <h1><span>Change Password</span></h1>
    <input type="hidden" name="EditUser" id="EditUser" value="EditUser" />
    <input type="hidden" name="uid" id="uid" value="<?php echo $this->_tpl_vars['userid']; ?>
" />
     <input type="hidden" name="username" id="username" value="<?php echo $this->_tpl_vars['username']; ?>
" />
 
    
    <ul>
    <?php if ($this->_tpl_vars['succmsg']): ?><li><font color="green"><?php echo $this->_tpl_vars['succmsg']; ?>
</font></li><?php endif; ?>
        <li><label>New Password</label> <input type="password" id="Password" size="15" name="Password" class="" forError="Password" value=""/></li>
        <li><label>Retype Password</label> <input type="password" id="Password1" size="26" name="Password1" class="" forError="Password1" value="" onblur="javascript:passwordcheck();"/></li>
        
        <li><input type="submit" name="btnSubmit" value ="Update" class="fp"/> </li>

    </ul>
    
</div>

</div>

<!-- End of Container -->
</form>


</body>
</html>