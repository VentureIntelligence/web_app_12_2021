   
<style>
    /* body{ font-family:sans-serif;}*/
    .s-popup-overlay{z-index:9999;background: rgba(0, 0, 0, .9); width: 100%; height: 100%; position: fixed; left: 0; top: 0;}
    .s-popup-main{ background: #fff; width: 1000px;  padding:100px 50px; margin-left: calc(50% - 550px); margin-top: 200px;opacity:1px;}
    .s-access-database{ text-align: center; color: #4e4e4e;}
    .s-access-database .s-btn-primary{ text-align: center; padding: 20px 0; margin: 40px 0 20px;}
    .s-access-database .s-btn-sec{ text-align: center; padding: 20px 0;}
    .s-popup-overlay a{ margin: 0 20px; color: #6d6d6d; border: 1px solid #aeb6b3; width: 250px; text-align: center; padding: 10px 0; text-decoration: none; display: inline-block; 
       -moz-border-radius: 2px;  -webkit-border-radius: 2px;    border-radius: 2px;}
    .s-popup-overlay a:hover{ color: #444444; border-color: #444444;}

</style>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>


<div class="s-popup-overlay" id="dialog">
    <div class="s-popup-main s-access-database">
        <h2>Would you like to access this database on your mobile device?</h2>
        <p>Please take this 2 Minute Survey to help us understand your requirements.</p>
        <div class="s-btn-primary"><a href="https://www.surveymonkey.com/r/92SX7R3" id="take_now" target="_blank">Yes, I'll take the survey now</a></div>
        <div class="s-btn-sec" ><a href="#" id="remind_me">Remind me later</a>
            <a href="#" id="dont_ask">No, Dont ask me again</a></div>

    </div>

</div>
<?php
if($surveyDB=='CFS'){
 $postURL = '../survey/insert.php?cfs';   
}else{
    $postURL = '../survey/insert.php'; 
}
?>
<script type="text/javascript"  >

    $(function() {  // Shorthand for $(document).ready(function() {;
        $('#dont_ask').click(function() {
            $.post("<?php echo $postURL?>",
                    {
                        status: 3
                    },
                    function(data, status) {
                        $('#dialog').hide();
                       
                    });

        });


        $('#remind_me').click(function() {
            $.post("<?php echo $postURL?>",
                    {
                        status: 2
                    },
                    function(data, status) {
                        $('#dialog').hide();
                        
                    });

        });



        $('#take_now').click(function() {
            $.post("<?php echo $postURL?>",
                    {
                        status: 1
                    },
                    function(data, status) {
                      $('#dialog').hide();
                      
                    });


        });


    });

</script>  

