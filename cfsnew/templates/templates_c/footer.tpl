<?php /* Smarty version 2.5.0, created on 2019-10-15 13:38:41
         compiled from footer.tpl */ ?>
<!--   <script src="js/foundation.min.js"></script> 
 <script src="js/foundation.tooltips.js"></script>   -->
  


<?php echo '
    <script>
  // document.write(\'<script src=\' +
  // (\'__proto__\' in {} ? \'js/vendor/zepto\' : \'js/vendor/jquery\') +
  // \'.js><\\/script>\')
  </script>
<script type="text/javascript">
 $(document).foundation();

	$(".btn-slide").click("slow", function(){  
		$(this).toggleClass("active"); 
		 $(".slide-bg" ).toggleClass( "container-bg");
		 return false; 
	});
  
  $(".firstdiv").show();
$(".container-left h2").click("slow", function () {
   $(this).next(".acc_container").toggleClass("acc_container_active", 200); 
   var text = $(this).find(\'span\').text();
    $(this).find(\'span\').text(text == " [-] " ? " [+] " : " [-] ");
	 
		 return false; 
});

$(document).ready( function(){

    $(".cb-enable").click(function(){
        var parent = $(this).parents(\'.switch-and-or\');
        $(\'.cb-disable\',parent).removeClass(\'selected\');
        $(this).addClass(\'selected\');
        $(\'.checkbox\',parent).attr(\'checked\', true);
    });
    $(".cb-disable").click(function(){
        var parent = $(this).parents(\'.switch-and-or\');
        $(\'.cb-enable\',parent).removeClass(\'selected\');
        $(this).addClass(\'selected\');
        $(\'.checkbox\',parent).attr(\'checked\', false);
    });
});

</script>



'; ?>


<?php echo '
<script type="text/javascript">
 $("a.postlink").live(\'click\',function(){
        /*$(\'<input>\').attr({
        type: \'hidden\',
        id: \'foo\',
        name: \'searchallfield\',
        value:\'<?php echo $searchallfield; ?>\'
        }).appendTo(\'#pesearch\');*/
        hrefval= $(this).attr("href");
        $("#Frm_HmeSearch").attr("action", hrefval);
        $("#Frm_HmeSearch").submit();
        return false;

    });
    function resetinput(fieldname,index)
    {
  
      $("#resetfield").val(fieldname);
      $("#resetfieldindex").val(index);
      $(fieldname).val(index);
      //alert( $("#resetfield").val());
      $("#Frm_HmeSearch").submit();
        return false;
    }
        function updateFinancial(from, to, subject, message,link){
             $.ajax({
                 url: \'ajaxsendmails.php\',
                  type: "POST",
                 data: { to : to, subject : subject, message : message , url_link : link, from : from },
                 success: function(data){
                     alert("Your request has been sent successfully");
                 },
                 error:function(){
                     alert("There was some problem sending request...");
                 }

             });
         }

         $( document ).ready( function() {
      meta();
    });
    function meta() {
      if( $(window).width() < 768 ) {
        $("meta[name=\'viewport\']").attr("content", "width=device-width, initial-scale=0");
      }
      else {
         $("meta[name=\'viewport\']").attr("content", "width=device-width, initial-scale=1.0"); 
      }
    }
</script>
'; ?>

