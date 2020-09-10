{include file="header.tpl"}

{literal}
<style type="text/css">
    form.custom .custom.dropdown
    {
        width:80px !important;
        }
        
    </style>
{/literal}

	
    <div class="view-table1">
    <div class="close-frame"> x </div>
       <iframe src="https://www.ventureintelligence.com/cfsnew/nanofolder/{$reportList.embedCode}" frameborder="0" height="100%" width="100%" onload="this.width=screen.width;this.height=(screen.height-250);"> </iframe>
    </div>
       

</form>







</div>


</div>
  

</div>
<!-- End of Container -->


</body>
</html>

{literal}
<script>
    $(".close-frame").live("click",function(){
                    window.location.href = 'other_report.php';
                    return  false;
                }); 
                
    </script>

{/literal}