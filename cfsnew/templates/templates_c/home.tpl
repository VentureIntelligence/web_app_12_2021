<?php /* Smarty version 2.5.0, created on 2019-11-08 16:08:38
         compiled from home.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'lower', 'home.tpl', 48, false),
array('modifier', 'capitalize', 'home.tpl', 48, false),
array('modifier', 'explode', 'home.tpl', 62, false),
array('modifier', 'replace', 'home.tpl', 83, false),
array('function', 'math', 'home.tpl', 57, false),
array('function', 'assign', 'home.tpl', 62, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
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
    </style>
'; ?>

<div class="list-tab"  style="margin-top: 26px;">
<ul>
<li><a  href="home.php" class="active postlink"><i></i> LIST VIEW</a></li>
<li><a class="postlink" href="<?php if (count ( $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']] ) > 0): ?>details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][0]['Company_Id']; ?>
<?php else: ?>#<?php endif; ?>"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul><div class="page-no" style="position: initial;"><span>(in Rs. Cr) &nbsp;&nbsp;</span></div>
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
    
      <tr><td class="name-list" style="text-transform: uppercase"> <span class="has-tip" data-tooltip="" title="<?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> Listed<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> Privately held(Ltd)<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> Partnership <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> Proprietorship<?php endif; ?>"><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> L<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> PVT<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> PART <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> PROP<?php endif; ?></span>
              <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']): ?>
            <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&c=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']; ?>
" title="Click here to view Annual Report" 
         
        ><?php echo $this->_run_mod_handler('capitalize', true, $this->_run_mod_handler('lower', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['SCompanyName'])); ?>
</a>	

        <?php else: ?>
        <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
" title="Click here to view Annual Report" 
       
        ><?php echo $this->_run_mod_handler('capitalize', true, $this->_run_mod_handler('lower', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['SCompanyName'])); ?>
</a>

        <?php endif; ?>
              </td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY'] > 0): ?>
    <td>
        <?php echo $this->_plugins['function']['assign'][0](array('var' => 'FY','value' => $this->_run_mod_handler('explode', true, ' ', $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY'])), $this) ; ?>

        <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']): ?>
            <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&c=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']; ?>
" title="Click here to view Annual Report" 
         
        >FY<?php echo $this->_tpl_vars['FY'][0]; ?>
 </a>	(upto <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Years<?php endif; ?> <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Years<?php endif; ?> )	

        <?php else: ?>
        
        <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
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
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
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
</body>
</html>
<?php echo '
    <script type="text/javascript">
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
                    form.custom .custom.dropdown ul li { width: 100%;}
        #export-popup .agree-export {
            margin-right: 10px;
        }

        #export-popup .close-lookup {
            background-color: #000;
        }
    </style>
'; ?>
