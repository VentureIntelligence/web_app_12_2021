<?php /* Smarty version 2.5.0, created on 2016-03-07 02:12:17
         compiled from other_report_details.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<style type="text/css">
    form.custom .custom.dropdown
    {
        width:80px !important;
        }
        
    </style>
'; ?>


	
    <div class="view-table1">
    <div class="close-frame"> x </div>
       <iframe src="https://www.ventureintelligence.com/cfsnew/nanofolder/<?php echo $this->_tpl_vars['reportList']['embedCode']; ?>
" frameborder="0" height="100%" width="100%" onload="this.width=screen.width;this.height=(screen.height-250);"> </iframe>
    </div>
       

</form>







</div>


</div>
  

</div>
<!-- End of Container -->


</body>
</html>

<?php echo '
<script>
    $(".close-frame").live("click",function(){
                    window.location.href = \'other_report.php\';
                    return  false;
                }); 
                
    </script>

'; ?>