<?php /* Smarty version 2.5.0, created on 2020-09-10 12:18:50
         compiled from admin/editGroup-api-pe.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'admin/editGroup-api-pe.tpl', 345, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("admin/header.tpl", array());
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
		                 
		if(inputString.length == 0) {
			jQuery(\'#suggestions\').fadeOut();
                        jQuery(\'#cid\').val(\'\');
		} else if(inputString.length > 2) {
		jQuery(\'#searchname\').addClass(\'load\');
			jQuery.post("ajaxcheckdealcomname.php", {groupnamesuggest: ""+inputString+""}, function(data){
				if(data.length >0) {
                                        
					jQuery(\'#suggestions\').fadeIn();
					jQuery(\'#suggestionsList\').html(data);
					jQuery(\'#searchname\').removeClass(\'load\');
				}
			});
		}
}
function fillgroupname(thisValue) {
        if(thisValue){
        jQuery(\'#searchname\').val(thisValue);        
    }
    setTimeout(jQuery(\'#suggestions\').fadeOut(), 300);
        //jQuery(\'#suggestions\').hide;
}
</script>
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}
/*.slider-bg {
	height:472px;
	position:absolute;
	width:980px;
	left: 155px;
	top: -39px;
	z-index:1000;
}*/
ul#primary-nav {
	float:left;
	height:75px;
	left:225px;
	position:absolute;
	top:57px;
	width: 746px;
}

ul#primary-nav {
margin:0; padding:0;
}

ul#primary-nav li {display:block; float:left; margin-right:22px;} 

ul#primary-nav li.home:hover{background: url(images/homehover.png) left top; width:77px; height:50px;}
ul#primary-nav li.aboutus:hover{background: url(images/abouthover.png) left top; width:114px; height:50px;}
ul#primary-nav li.services:hover{background: url(images/serviceshover.png) left top; width:114px; height:50px;}
ul#primary-nav li.contactus:hover{background: url(images/contactushover.png) left top; width:134px; height:50px;}

ul#primary-nav li.home a
{
background:url(images/home.png) no-repeat;
line-height:64px;
padding:19px 38px;
}

ul#primary-nav li.aboutus a
{
background:url(images/aboutus.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.services a
{
background:url(images/services.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.contactus a
{
background:url(images/contactus.png) no-repeat;
line-height:64px;
padding:19px 67px;
}

ul#primary-nav li a{
height:19px;
width:auto;
}
.contentbg
{
height:auto;
position:relative;
}
.content
{
width:930px;
height:auto;
margin:0 auto;
padding-top:42px;

}
.wrapper {
padding:0px 0px 20px;
width:300px;
float:left;
}
.breadtext
{
font:13px Verdana, Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
text-indent:15px;
}
.breadcrumb
{
width:100%;
/*background-color:#000000;*/
/*padding:15px 0;*/
}
.title {
color:#FFFFFF;
font:lighter 25px impact;
text-transform:uppercase;
text-align:left;
}
.imagebg
{
background-color:#FFFFFF;
width:278px;
height:auto;
margin:25px auto;
border:1px solid #cecece;
padding:6px;
}
.conttext
{
font:12px/1.8 Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
width:290px;

}
h1{
display:inline;
}
.ListText{
	font:18px Arial, Helvetica, sans-serif;
	bor

}
#slidecontent {

    position: relative;
}
ol#controls {
    height: 28px;
    left: 360px;
    margin: 1em 0;
    padding: 0;
    position: absolute;
    top: 121px;
    z-index: 1000;
}
.adminbox {
    border: 1px solid #589711;
	background-color:#FFFFFF;
    border-radius: 10px 10px 10px 10px;
	-webkit-border-radius: 10px 10px 10px 10px;
    box-shadow: 2px 2px 2px #B0AEA6;
    padding: 10px;
	
    margin: 20px auto;
    height: auto;
    padding: 20px;
    width: 500px;
}
.adtitle
{
font:bold 24px "Courier New", Courier, monospace;
margin:15px 0;
color:#000;

}
select, input
{
padding:5px;
width:250px;
}
label{
font-family:Arial, Helvetica, sans-serif;
font-size:18px;
float:left;
width:150px;
color:#333333;
text-align:left;
}
input[type=radio]{
width:20px;
}
.dob{
	width:60px;
	padding:0px;
}
.condensed-table td{
    line-height: 35px !important;
}

.suggestionsBox {
max-height: 500px;
overflow-y: scroll;
z-index: 10;
min-width: 256px;
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

	<script type="text/javascript" language="javascript1.3">
		var $j = jQuery.noConflict();
		$j(document).ready(function(){	
			$j("#slider").easySlider({
				//auto: false, 
				//continuous: true,
				numeric: true
			});
		});	



/*function Validation(id){
  var flag		=		0;
  if(id == 1 && id != undefined){
	var email = document.getElementById(\'emailaddress\').value;
	var City = document.getElementById(\'City\').value;
	 if(email==""){
		$(\'CatErrorMsg\').innerHTML = "Please Enter Email";
		$(\'emailaddress\').focus();
		flag=1;
	 }else if (!isValidEmail(email)){
		$(\'CatErrorMsg\').innerHTML = "Please Enter Valid Email Address";
		$(\'emailaddress\').focus();
		flag=1;
	}
  }	
	if(flag == 0 && email != "" && email != undefined){
		document.authcheck.submit();
	}
}
*/
function IndexKeyPress(id,e){
		// look for window.event in case event isn\'t passed in
		if (window.event) { e = window.event; }
		if (e.keyCode == 13){
		return true;
			//	validation(id);
		}
}


function ChangeStatus(statuschange,op1,msg1)
{	
    if (confirm("Are you sure you want to "+msg1)) {
		
	document.addformspringform1.Groupid.value=op1;
	document.addformspringform1.status.value=msg1;
        document.addformspringform1.GroupStatusChange.value=statuschange;
	document.addformspringform1.submit();
    } 
}    

function ChangeStatus1(statuschange,op1,msg1)
{	
    if (confirm("This account has been expired. Please update the Expiry Date.")) {
		
	document.addformspringform1.Groupid.value=op1;
	document.addformspringform1.status.value=msg1;
        document.addformspringform1.GroupStatusChange.value=statuschange;
        window.location.replace("'; ?>
<?php echo $this->_tpl_vars['editgroupurl']; ?>
<?php echo '"+op1+\'&expupdate=1\');
	//document.addformspringform1.submit();
    } 
}    
    
 function sortload(name,order){
        document.sortlist.sortby.value=name;
	document.sortlist.order.value=order;
	document.sortlist.submit();
}    
	</script>

	'; ?>

</head>


 <form  method="post" name="sortlist" id="sortlist" action="editGroup-api-pe.php">    
  <input type="hidden" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
  <input type="hidden" name="order" value="<?php echo $this->_tpl_vars['order']; ?>
" />
  <input type="hidden" name="page" value="<?php echo $this->_tpl_vars['Page']; ?>
" />
</form>

<form  method="post" name="addformspringform1" id="addformspringform1">
  <input type="hidden" name="Groupid" />
  <input type="hidden" name="status" />
  <input type="hidden" name="GroupStatusChange" />
</form>

<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
<!--<form name="Frm_EditUser" id="Frm_EditUser" action="" method="post" onSubmit="return Validation('Frm_EditUser')" enctype="multipart/form-data">
<input type="hidden" name="EditUser" id="EditUser" value="EditUser" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
				<li><div class="adminbox">
		<div class="adtitle" align="center">Edit Group</div>
		<div align="center">
			<label id="req_answer[GroupName]">Group Name:</label>
			<select type="text" id="answer[GroupName]"  name="answer[GroupName]" class="" forError="GroupName" value="" />
					<?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['grouplist']), $this) ; ?>
	
				</select>			
		</div><br />

		<div align="center">
			<label id="req_answer[Limit]">Visit Limit:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="answer[Limit]" size="26" name="answer[Limit]" class="req_value" forError="Limit" value="<?php echo $this->_tpl_vars['grouplist1']['Limit']; ?>
"/>		
		</div><br />
<br />
		<div align="center">
			<label id="req_answer[Limit]">Excel Limit:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="answer[ExLimit]" size="26" name="answer[ExLimit]" class="req_value" forError="Limit"/>		
		</div><br />
<br />
		<div align="center">
			<label id="req_answer[Limit]">Submit Limit:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="answer[subLimit]" size="26" name="answer[subLimit]" class="req_value" forError="Limit"/>		
		</div><br />
<br />

	<div align="center">
		<input type="image" name="edit_business"  src="images/submit.png" style="width:87px; height:25px;"/>
	</div><br />

	
	</div><br />

	
	
	
	
	</li>
				
							
			</ul>
		</div>
	</div>

</div>
</form>-->
        <div class="page-header">
          <h1 style="margin-left:100px;">PE Company List </h1>
          
          <a href="addGroup.php" style="float:right; margin-right:10%; font-weight: bold;font-size: 15px;">Add Group</a>
          
        </div>
        <div class="row"  style="margin-left:100px;">
            <div id="suggest">
            <form action="editGroup-api-pe.php" method="get" id="groupsearch">
                <input type="text" placeholder="Group Name" name="name" id="searchname" value="<?php if ($this->_tpl_vars['searchname']): ?><?php echo $this->_tpl_vars['searchname']; ?>
<?php endif; ?>" onkeyup="suggest(this.value);" onblur="fill();" class=""  autocomplete=off   required>
                <input type="submit" value="Search">
                <?php if ($this->_tpl_vars['searchname']): ?> <input type="button" value="Show all" onclick="window.location.href='editGroup-api-pe.php';"> <?php endif; ?>
                <div class="suggestionsBox" id="suggestions" style="display: none;">
				  <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
				</div>
             </form>                   
	    </div>
        </div>
            
            
            
          <div style="width:90%; margin-left: 5%">
           
              <table class="condensed-table">
        <thead>
          <tr>
            
            <th> <a onclick="sortload<?php echo $this->_tpl_vars['groupnameclicksort']; ?>
;"> <span style="float:left;color:#000">Group Name</span> <img src="images/sort.gif"></th>
            
            
            <th>Api Access </th>
            
            <th>Actions</th>
            
          </tr>
        </thead>
        <tbody>
          <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['GroupList1']) ? count($this->_tpl_vars['GroupList1']) : max(0, (int)$this->_tpl_vars['GroupList1']);
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
            <tr>
                
                <td><?php echo $this->_tpl_vars['GroupList1'][$this->_sections['List']['index']]['DCompanyName']; ?>
</td> 
                
                <td><?php if ($this->_tpl_vars['GroupList1'][$this->_sections['List']['index']]['api_access'] == 1): ?>Yes<?php else: ?>No<?php endif; ?></td>
                
                <td width="3%" align="center"><a href="editadmingroup-api-pe.php?auid=<?php echo $this->_tpl_vars['GroupList1'][$this->_sections['List']['index']]['DCompId']; ?>
"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>
                
            </tr>
            <?php endfor; else: ?>
            <tr>
                <td colspan="">&nbsp;</td>
                <td colspan="3" align="center">No Data Found !</td>
                <td colspan="">&nbsp;</td>
            </tr>		  		  
            <?php endif; ?>
  <tr>
  <td  colspan="11" style="color:#000000;padding-top:15px;" align="right">
        <center>
		<?php if ($this->_tpl_vars['pages_New']['first'] == '0' && $this->_tpl_vars['pages_New']['next'] == '0'): ?>
<tr><td colspan="11">&nbsp;</td></tr>
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
       </center>        
</td></tr>	  
        </tbody>
      </table>
          </div>          
        </div>

</div>