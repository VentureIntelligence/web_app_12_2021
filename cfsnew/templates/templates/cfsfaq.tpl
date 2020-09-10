{include file="header.tpl"}


<div class="container-right">
<!-- {if $searchupperlimit gte $searchlowerlimit}   --> 

{literal}
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
{/literal}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<div id="container" style="margin-top: 10px;">
    <div class="result-cnt">
        <p class="faq-title">FREQUENTLY ASKED QUESTIONS</p>
          <div id="container" style="width:100%;margin-top: 10px;    display: inline-flex;">
            <div class="faq-question-container" style="width:50%;word-break: break-all;overflow-y: auto;
    height: 76vh;border-right:1px solid #ccc">
                <div id="accordion">

<!-- {$cfsitem|@print_r} -->
 
  {if $SearchResults|@count gt 0}
  {section name=List loop=$SearchResults}  
   
    <div class="faq-list">
    <div class="questionans" ><h3  class="faq-title faq-h3">{$SearchResults[List].question}</h3>
                  <span class="arrow" >
                  <i class="fa fa-chevron-down show" aria-hidden="true"></i>
                  <i class="fa fa-chevron-up hide" aria-hidden="true" style="display:none"></i>
                  </span>
                  </div>
                  <div  class="faq-answer">
                    <p class="faq-content">{$SearchResults[List].answer}

                        {foreach from=$cfsitem key=k item=v}

                              {if $k eq $SearchResults[List].assertname}

                                {if $SearchResults[List].assert_type eq 'video'}
                                     <span class='faq-asset' data-link='{$v}'>Video</span>
                                {else}
                                     <span class='faq-asset-pdf' data-link='{$v}'><a href='{$v}' target='_blank' style="text-decoration: underline;"> PDF</a></span>
                                {/if}
                               
                            
                              {/if}
                           
                        {/foreach}
                    </p>
                </div>
                </div>
     
  {/section}
  {else}
     <p class="faq-content">No data found</p>
  {/if}

  </div>
   </div>
    {* <div style="width:50%;padding: 25px;">
                <video width="100%" class="faqvideo" controls autoplay style="display:none;">
<source class="video-link"
src="#">
</video>
            </div> *}


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

   
  



  
  
<!-- {else}
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
{/if} -->

<!-- End of container-right -->

</div>
<!-- End of Container -->
{literal}

   <script>


$(document).on('click','.questionans',function () {
$(this).find('i.fa-chevron-down').removeClass('show');
$('.questionans').find('i.fa-chevron-up').addClass('hide').removeClass('show');
$('.questionans').find('i.fa-chevron-down').addClass('show').removeClass('hide');
$('.faq-list:first-child .fa-chevron-up').css('display','none ');
$('.faq-answer').hide();
$(this).next('.faq-answer').fadeIn();
$(this).find('i.fa-chevron-up').addClass('show').removeClass('hide');
$(this).find('i.fa-chevron-down').addClass('hide').removeClass('show');
$('.faq-list:first-child .fa-chevron-down').css('display','block ');
$(".faqvideo").not(this).each(function () {
                $(this).get(0).pause();
            });


});
$(document).on('click','.faq-list:first-child .questionans',function () {
    $('.faq-list:first-child .fa-chevron-up').css('display','block ');
    $('.faq-list:first-child .fa-chevron-down').css('display','none ');
});

var divheight=$('.faq-video.faq-default-video').height();
var halfheight= divheight/2;
$(".faq-default-video p.video-placeholder").css("margin-top",halfheight);



$(document).on('click','.faq-asset',function () {
var assetUrl = $(this).attr('data-link');
var question = $(this).parent().parent().prev().find('h3').text();
$('.faq-video-title').text(question);


});
$(document).on('click','.faq-asset',function(){
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
{/literal}


</body>
</html>
