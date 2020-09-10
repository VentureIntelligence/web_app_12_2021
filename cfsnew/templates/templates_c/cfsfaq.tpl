<?php /* Smarty version 2.5.0, created on 2020-03-13 09:32:12
         compiled from cfsfaq.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'print_r', 'cfsfaq.tpl', 127, false),
array('modifier', 'count', 'cfsfaq.tpl', 129, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<div class="container-right">
<!-- <?php if ($this->_tpl_vars['searchupperlimit'] >= $this->_tpl_vars['searchlowerlimit']): ?>   --> 

<?php echo '
<style>
.search-main{
  display:none;
}
  .entry-pad{
  padding:0px 10px; }
  #sec-header,.sec-header-fix{
        display: none !important;
  }
  #header .left-box,.logo{
    border-bottom: 1px solid #000;
  }
  .result-cnt{
        padding: 10px 20px 0px 20px !important;
  }
  .faq-title{
font-weight: 700;
font-size: 15px;
cursor: pointer;
margin-top:20px;
    margin-bottom: 5px;
    width: 95%;
    word-break: break-word;
    line-height: 20px;
}



.faq-content {

color: black;
margin:0px;
font-size:15px;
color:#414141;
word-break: break-word;
line-height: 1.4;
}

.faq-asset {
cursor: pointer;
color: blue;
text-decoration: underline;
}

.faq-asset-pdf {
cursor: pointer;
color: blue;
}

.faq-answer {
display: none;
}
.result-cnt{
    position: relative;
}
.faq-list{
    border-bottom: 1px solid #ccc;
    padding: 0 0 10px 0px;
    width: 95%;
}
.faq-list div.questionans{
    display:inline-flex;position:relative;width:100%;
}
.faq-list span.arrow{
    position: absolute;
    right: 0;
    top: 25px;
    font-size: 16px;
}
.show{display:block !important;}
.hide{display:none !important;}    
.faqvideo{
    border: 1px solid #ccc;
    padding: 6px;
    background: #f3f3f3;
}
.faq-default-video{
    border: 1px solid #ccc;
    background: #f3f3f3;
    text-align: center;
}
.video-placeholder{
font-size: 18px;
}
.faq-h3{
    font-weight:normal !important;
    font-size: 15px !important;

}
  .slide-bg{
    background: none !important;
  }
 .faq-list:first-child .faq-answer
{
    display: block;
}
.faq-answer {
    margin-top: 3px;
    margin-bottom: 3px;
}
.faq-list:first-child .fa-chevron-down
{
    display: none ;
}
.faq-list:first-child .fa-chevron-up
{
    display: block ;
}
    </style>
'; ?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<div id="container" style="margin-top: 10px;">
    <div class="result-cnt">
        <p class="faq-title">FREQUENTLY ASKED QUESTIONS</p>
          <div id="container" style="width:100%;margin-top: 10px;    display: inline-flex;">
            <div class="faq-question-container" style="width:50%;word-break: break-all;overflow-y: auto;
    height: 76vh;border-right:1px solid #ccc">
                <div id="accordion">

<!-- <?php echo $this->_run_mod_handler('print_r', false, $this->_tpl_vars['cfsitem']); ?>
 -->
 
  <?php if ($this->_run_mod_handler('count', false, $this->_tpl_vars['SearchResults']) > 0): ?>
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
   
    <div class="faq-list">
    <div class="questionans" ><h3  class="faq-title faq-h3"><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['question']; ?>
</h3>
                  <span class="arrow" >
                  <i class="fa fa-chevron-down show" aria-hidden="true"></i>
                  <i class="fa fa-chevron-up hide" aria-hidden="true" style="display:none"></i>
                  </span>
                  </div>
                  <div  class="faq-answer">
                    <p class="faq-content"><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['answer']; ?>


                        <?php if (count((array)$this->_tpl_vars['cfsitem'])):
    foreach ((array)$this->_tpl_vars['cfsitem'] as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>

                              <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['assertname']): ?>

                                <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['assert_type'] == 'video'): ?>
                                     <span class='faq-asset' data-link='<?php echo $this->_tpl_vars['v']; ?>
'>Video</span>
                                <?php else: ?>
                                     <span class='faq-asset-pdf' data-link='<?php echo $this->_tpl_vars['v']; ?>
'><a href='<?php echo $this->_tpl_vars['v']; ?>
' target='_blank' style="text-decoration: underline;"> PDF</a></span>
                                <?php endif; ?>
                               
                            
                              <?php endif; ?>
                           
                        <?php endforeach; endif; ?>
                    </p>
                </div>
                </div>
     
  <?php endfor; endif; ?>
  <?php else: ?>
     <p class="faq-content">No data found</p>
  <?php endif; ?>

  </div>
   </div>
    


             <div class="faq-video faq-default-video" style="width:50%;margin:50px 25px;height:45vh">
            <p class="faq-video-title faq-h3" style="
    font-size: 17px;position: absolute;
    top: 75px;">Watch FAQ video</p>
    <p class="video-placeholder" style="
    
">Video Player
</p>
                <video width="100%" class="faqvideo" controls autoplay style="display:none;">
<source class="video-link"
src="#">
</video>
            </div>
    </div>

   
  



  
  
<!-- <?php else: ?>
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
<?php endif; ?> -->

<!-- End of container-right -->

</div>
<!-- End of Container -->
<?php echo '

   <script>


$(document).on(\'click\',\'.questionans\',function () {
$(this).find(\'i.fa-chevron-down\').removeClass(\'show\');
$(\'.questionans\').find(\'i.fa-chevron-up\').addClass(\'hide\').removeClass(\'show\');
$(\'.questionans\').find(\'i.fa-chevron-down\').addClass(\'show\').removeClass(\'hide\');
$(\'.faq-list:first-child .fa-chevron-up\').css(\'display\',\'none \');
$(\'.faq-answer\').hide();
$(this).next(\'.faq-answer\').fadeIn();
$(this).find(\'i.fa-chevron-up\').addClass(\'show\').removeClass(\'hide\');
$(this).find(\'i.fa-chevron-down\').addClass(\'hide\').removeClass(\'show\');
$(\'.faq-list:first-child .fa-chevron-down\').css(\'display\',\'block \');
$(".faqvideo").not(this).each(function () {
                $(this).get(0).pause();
            });


});
$(document).on(\'click\',\'.faq-list:first-child .questionans\',function () {
    $(\'.faq-list:first-child .fa-chevron-up\').css(\'display\',\'block \');
    $(\'.faq-list:first-child .fa-chevron-down\').css(\'display\',\'none \');
});

var divheight=$(\'.faq-video.faq-default-video\').height();
var halfheight= divheight/2;
$(".faq-default-video p.video-placeholder").css("margin-top",halfheight);



$(document).on(\'click\',\'.faq-asset\',function () {
var assetUrl = $(this).attr(\'data-link\');
var question = $(this).parent().parent().prev().find(\'h3\').text();
$(\'.faq-video-title\').text(question);


});
$(document).on(\'click\',\'.faq-asset\',function(){
	$(".video-link").attr("src","");
	$(".faq-video").removeClass("faq-default-video");
	$(".video-placeholder").css("display","none");
	$(".faqvideo").css("display","block");

	$(".faq-video-title").css("display","block");
	
	var value=$(this).attr("data-link");
	$(".video-link").attr("src",value);
	$(".faqvideo").load();
    $(".faqvideo").play();
});
</script>
'; ?>



</body>
</html>