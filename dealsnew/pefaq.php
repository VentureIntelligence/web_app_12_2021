<?php 
/*$filename="https://companyfilings.s3.amazonaws.com/FAQAssets/Video/Private%20Company%20Financials%20Database.mp4";
$ext = pathinfo($filename, PATHINFO_EXTENSION);
echo $ext;
*/
require_once "../dbconnectvi.php";
$Db = new dbInvestments();
//session_save_path("/tmp");
session_start();
include_once 'tvindex_search.php';

$dbtype=$_POST['dbtypeValue'];
  require_once('aws.php');    // load logins
    require_once('aws.phar');

    use Aws\S3\S3Client;

    $client = S3Client::factory(array(
        'key'    => $GLOBALS['key'],
        'secret' => $GLOBALS['secret']
    ));
?>

<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<style>
	div#sec-header{
		display: none !important;
	}
	#header .left-box{
		border-bottom: 1px solid #000;
	}
	.result-cnt{
		padding: 10px 20px 0px 20px !important;
	}
	/*.result-cnt p{
		color: #000;
	    float: left;
	    font-weight: bold;
	    padding: 0 5px 0 15px;
	    text-transform: none !important;
	    font-size:17px;
	    margin:0px;
	}*/
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
.show{display:block ;}
.hide{display:none ;}	
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
.faq-list:first-child .faq-answer
{
    display: block;
}
.faq-answer {
    margin-top: 5px;
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
<script>
  /*$( function() {
    $( "#accordion" ).accordion({
      heightStyle: "content",
      collapsible: true,
    });
  } );*/
  </script>
  <script>
// 		$(document).on('click','.faq-title',function () {
// $('.faq-answer').hide();
// $(".faqvideo").css("display","none");
// $(".faq-video-title").css("display","none");
// $(this).next('.faq-answer').fadeIn();
// $(this).find('i.fa-chevron-up').toggle();
// });
$(document).on('click','.questionans',function () {
$(this).find('i.fa-chevron-down').removeClass('show');
$('.questionans').find('i.fa-chevron-up').addClass('hide').removeClass('show');
$('.questionans').find('i.fa-chevron-down').addClass('show').removeClass('hide');
$('.faq-list:first-child .fa-chevron-up').css('display','none');
$('.faq-answer').hide();

// $(".faqvideo").css("display","none");
// $(".faq-video").addClass("faq-default-video");
// 	$(".video-placeholder").css("display","block");

$(this).next('.faq-answer').fadeIn();
$(this).find('i.fa-chevron-up').addClass('show').removeClass('hide');
$(this).find('i.fa-chevron-down').addClass('hide').removeClass('show');
$('.faq-list:first-child .fa-chevron-down').css('display','block');
//$('.questionans').find('i.fa-chevron-down').addClass('hide').removeClass('show');

$(".faqvideo").not(this).each(function () {
                $(this).get(0).pause();
            });


});
$(document).on('click','.faq-list:first-child .questionans',function () {
    $('.faq-list:first-child .fa-chevron-up').css('display','block');
    $('.faq-list:first-child .fa-chevron-down').css('display','none');
});

$(document).ready(function(){
var divheight=$('.faq-video.faq-default-video').height();
var halfheight= divheight/2;
$(".faq-default-video p.video-placeholder").css("margin-top",halfheight);
});

// $(document).on('click','.questionans',function () {
// 	$(this).find('i.fa-chevron-down').toggle();
	
// 	//$('.faq-answer').toggle();
// 	$(".faqvideo").css("display","none");
// 	$(".faq-video-title").css("display","none");
// 	$(this).next('.faq-answer').toggle();
// 	$(this).find('i.fa-chevron-up').toggle();
// });

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
<div id="container" style="margin-top: 50px;">
	<div class="result-cnt">
		<p class="faq-title">FREQUENTLY ASKED QUESTIONS</p>
		<?php 
			 /*if(trim($dbtype)!="")
            {*/
              //  $nanoSql="select * from faq where DBtype='PE' and status='0' order by createdDate desc";
				$nanoSql="select * from faq where DBtype='PE' and status='0' ORDER BY faq_order_no ASC";
				
				
            /*}*/
           	if ($dbtypers = mysql_query($nanoSql)) {
			    $dbtype_cnt = mysql_num_rows($dbtypers);
			}
			$bucket = $GLOBALS['bucket'];
    $faq="FAQAssets/";
   // echo $faq;
    $iterator = $client->getIterator('ListObjects', array(
        'Bucket' => $bucket,
        'Prefix' => $faq 
    ));
    
    $c1=0;$c2=0;

        $items = $object1 = array();
        $foldername = '';
        $items1 = array();
        $filesarr = array();

    try {
            $valCount = iterator_count($iterator);
        } catch(Exception $e){}

        if($valCount > 0){

        foreach($iterator as $object){
        	
             $fileName =  $object['Key'];

            if($object['Size'] == 0){
                $foldername = explode("/", $object['Key']);
                
            } 
            $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');

            $pieces = explode("/", $fileName);
            $pieces = $pieces[ sizeof($pieces) - 1 ];

            $fileNameExt = $pieces;
            $ex_ext = explode(".", $fileName);
            $ext = $ex_ext[count($ex_ext)-1];
           
            if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){
                continue;
            }

            $c1 = $c1 + 1;

            $c2 = $c2 + 1;
            
            /*$items1[$foldername[sizeof($foldername) - 2]][$pieces] = $signedUrl;*/    
            $items1[$pieces] = $signedUrl;
            
            array_push($items, array('name'=>$str) );

        }   // foreach

        $result = $c2. " of ". $c1;
    }
			
		?>
		<div id="container" style="width:100%;margin-top: 10px;    display: inline-flex;
    ">
			<div class="faq-question-container" style="width:50%;word-break: break-all;overflow-y: auto;
    height: 76vh;border-right:1px solid #ccc">
				<div id="accordion">
					<?php 
                     if($dbtype_cnt>0){
						 while($myrow = mysql_fetch_array($dbtypers, MYSQL_BOTH)) {
						

    //echo "signedurl:".$signedUrl;
						?>
						<div class="faq-list">
				  <div class="questionans" ><h3  class="faq-title faq-h3"><?php echo $myrow['question'];?></h3>
				  <span class="arrow" >
				  <i class="fa fa-chevron-down show" aria-hidden="true"></i>
				  <i class="fa fa-chevron-up hide" aria-hidden="true" ></i>
				  </span>
				  </div>
				  <div  class="faq-answer">
				    <p class="faq-content"><?php echo $myrow['answer'];?>
				  
				        <?php 
				  	
                                            if(sizeof($items1) > 0){
                                                
                                                        foreach ($items1 as $key => $value) {
                                                        	//echo "assetname".$myrow['assetname'];
                                                        	if($key==$myrow['assertname']){
                                                        		if($myrow['assert_type']!="pdf"){
                                                        			$liststr = "<span class='faq-asset' data-link='$value'>Video</span>";
                                                        		}else{
                                                        			$liststr ="<span class='faq-asset-pdf' data-link='$value'>
					<a href='$value' target='_blank'>PDF</a></span>";
                                                        		}
                                                        	}
                                                        	else{
                                                        		$liststr ="";
                                                        	}
                                                        	echo $liststr;
                                                            
                                                      }
                                                
                                            } 

                                        ?>

				  
				   
				    	

				    </p>
					</div>
				  </div>
				<?php }
             }else{
 ?>
 <p>No Data Found</p>
                        <?php 
    }
    
?>
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
		
	</div>
</div>

