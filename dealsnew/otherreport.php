<?php

require_once("../dbconnectvi.php");
$Db = new dbInvestments();


include('checklogin.php');
include_once('tvheader_search_trend.php');
require_once('awsreport.php');    // load logins
require_once('aws.phar');
use Aws\S3\S3Client;
$client = S3Client::factory(array(
    'key'    => $GLOBALS['key'],
    'secret' => $GLOBALS['secret']
));

$bucket = $GLOBALS['bucket'];

$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => $bucket,
    'Prefix' => $GLOBALS['root'] . '/Annual Reports'
));
$iteratorquaterly = $client->getIterator('ListObjects', array(
    'Bucket' => $bucket,
    'Prefix' => $GLOBALS['root'] . '/Quarterly Reports'
));


$c1 = 0;
$c2 = 0;

$items = $object1 = array();
$foldername = '';
$aritems = array();
$qritems = array();
$filesarr = array();

try {
    $valCount = iterator_count($iterator);
} catch (Exception $e) {
}
try {
    $valCountqr = iterator_count($iteratorquaterly);
} catch (Exception $e) {
}
//Annual report
if ($valCount > 0) {

    foreach ($iterator as $object) {

        //echo $object['Key'] . "<br>";
        $fileName =  $object['Key'];

        if ($object['Size'] == 0) {
            $foldername = explode("/", $object['Key']);
            //echo sizeof($foldername) . "<br>";print_r($foldername);
        }

        // Get a pre-signed URL for an Amazon S3 object
        $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
        // > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]



        $pieces = explode("/", $fileName);
        $pieces = $pieces[sizeof($pieces) - 1];
        $fileNameExt = $pieces;
        $ex_ext = explode(".", $fileName);
        $ext = $ex_ext[count($ex_ext) - 1];
        //$ext = ".pdf";

        // ----------------------------------
        // test if the word ends with '.pdf'
        if (strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt)) {
            //echo "<BR>EXT";
            continue;
        }
        // ----------------------------------

        $c1 = $c1 + 1;

        if ($object['form_date'] != '') {
            $uploaddate = date('d-m-Y', strtotime($object['form_date']));
        } else {
            $uploaddate = '';
        }


        $c2 = $c2 + 1;

        $str = "<li> <a href='" . $signedUrl . "' target='_blank' >" .  $pieces . "</a></li><BR>";

        $str = "<tr><td><a href='" . $signedUrl . "' target='_blank'  >" .  $pieces . "</a></td></tr>";
        $list .= "<tr><td><a href='" . $signedUrl . "' target='_blank'  >" .  $pieces . "</a></td></tr>";
        //print_r($foldername);
        //if($foldername[2] != ''){
        $aritems[$foldername[sizeof($foldername) - 3]][$foldername[sizeof($foldername) - 2]][$pieces] = $signedUrl;
        //}

        array_push($items, array('name' => $str));
    }   // foreach

    $result = $c2 . " of " . $c1;
}

//Quaterly report
if ($valCountqr > 0) {
    foreach ($iteratorquaterly as $objectqr) {
        $fileNameqr =  $objectqr['Key'];
        if ($objectqr['Size'] == 0) {
            $foldernameqr = explode("/", $objectqr['Key']);
        }

        // Get a pre-signed URL for an Amazon S3 object
        $signedUrl = $client->getObjectUrl($bucket, $fileNameqr, '+60 minutes');
        // > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]



        $piecesqr = explode("/", $fileNameqr);
        $piecesqr = $piecesqr[sizeof($piecesqr) - 1];
        $fileNameExt = $piecesqr;
        $ex_ext = explode(".", $fileNameqr);
        $ext = $ex_ext[count($ex_ext) - 1];
        // ----------------------------------
        // test if the word ends with '.pdf'
        if (strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt)) {
            //echo "<BR>EXT";
            continue;
        }
        // ----------------------------------

        $c1 = $c1 + 1;

        if ($object['form_date'] != '') {
            $uploaddate = date('d-m-Y', strtotime($object['form_date']));
        } else {
            $uploaddate = '';
        }


        $c2 = $c2 + 1;

        $str = "<li> <a href='" . $signedUrl . "' target='_blank' >" .  $pieces . "</a></li><BR>";

        $str = "<tr><td><a href='" . $signedUrl . "' target='_blank'  >" .  $pieces . "</a></td></tr>";
        $list .= "<tr><td><a href='" . $signedUrl . "' target='_blank'  >" .  $pieces . "</a></td></tr>";


        $qritems[$foldernameqr[sizeof($foldernameqr) - 3]][$foldernameqr[sizeof($foldernameqr) - 2]][$piecesqr] = $signedUrl;


        array_push($items, array('name' => $str));
    }   // foreach

}



?>
<style type="text/css">
    .innerqr li,.inner li {line-height: 25px;}.pagetitle{padding:5px}esop{float:right}.detailtitle a{font-size:21px!important;color:#333;font-weight:600;text-decoration:none;text-transform:capitalize}.text-center{text-align:center}.detailtitle{position:relative!important;left:0!important}.result-title{margin-left:-18px}.result-select{border:none!important;padding:12px 6px 0 20px!important}.result-title li{background:0 0!important;border:1px solid #ccc}.result-title li a{border-left:1px solid transparent!important}.pagetitle{font-size:21px!important;color:#333;font-weight:600;text-decoration:none;text-transform:capitalize;text-align:center}.view-table table{border:1px solid #b3b3b3}.filing-cnt td a{color:#c0a172;text-decoration:underline;font-weight:400;font-size:14px}ul .inner,ul .subfolder,ul .innerqr,ul .subfolderqr{overflow:hidden;display:none;border-top:none;text-indent:40px}ul .inner,ul .innerqr{text-indent:60px;margin-bottom:5px}ul .inner li,ul .innerqr li{padding:10px 12px;margin:0!important;border-bottom:1px solid #ccc}ul .subfolder li,ul .subfolderqr li{padding:0 12px;margin:0!important;border-bottom:1px solid transparent}ul .inner li:last-child,ul .innerqr li:last-child{border-bottom:none}ul .inner li a,ul .innerqr li a{color:#000;font-size:14px}.filing-cnt{margin-top:20px;border:1px solid #b3b3b3;padding:0}.filing-cnt h3{color:#c0a172;font-weight:700;font-size:18px;padding:10px}ul li a.toggle,ul li a.toggleqr{display:block;color:#000;padding:10px 32px!important;border-radius:0;transition:background .3s ease;font-size:16px;text-decoration:none;border-top:1px solid #ccc;min-height:16px;font-weight:700}.innertoggle,.innertoggleqr{display:block;color:#000;padding:5px 32px!important;border-radius:0;transition:background .3s ease;font-size:16px;text-decoration:none;min-height:16px;font-weight:700;border-top:1px solid transparent!important}.subfolder,.subfolderqr{text-indent:40px}.accordionlist a span,.accordionlistqr a span{align-self:center;display:inline-block;position:absolute;left:10px;font-family:"Font Awesome 5 Free";-webkit-font-smoothing:antialiased;display:inline-block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1;font-weight:700;color:#a37535}.accordionlist a span:after,.accordionlistqr a span:after{content:"\f07b";display:block}.accordionlist a.active span:after,.accordionlistqr a.active span:after{content:"\f07c";display:block}.view-detailed{margin-top:50px;position:relative}.detailed-title-links a#previous{margin-top:-26px}#previous{text-decoration:none;font-size:14px;text-transform:uppercase;float:left;padding:5px 10px;color:#fff;background-color:#a2753a;display:inline-block}.backbtn{padding-left:18px}.shp_table{border-collapse:collapse!important}.table_heading_tr,.table_stake_held,th.table_shareholder{border-top:1px solid #000!important;border-bottom:1px solid #000!important}.shp_table td,.shp_table th{border-right:1px solid #000!important;border-left:1px solid #000!important}.shp_table td{border-bottom:none!important}.dynamic_table_val{padding-left:30px!important}.table_shareholder{background-color:#e0d8c3!important;width:70%!important}.table_stake_held{background-color:#e0d8c3!important}.table_h3{text-align:center!important;background-color:#413529!important;color:#fff!important;margin-bottom:4px!important}.mt-list-tab{height:34px}.mt-list-tab h2{padding:10px 0 0 0;font-size:22px;margin-bottom:-1px}.inner-section .action-links{margin:0}.action-links img{margin-top:4px;margin-right:5px}.list-tab .inner-list{margin-top:-24px}div.token-input-dropdown-facebook{z-index:999}.popup_content ul.token-input-list-facebook{height:39px!important;width:537px!important}#popup-box{top:10%}.entry p{margin:0}.popup_main{position:fixed;left:0;top:0;bottom:0;right:0;background:rgba(2,2,2,.5);z-index:999}.popup_box{width:70%;height:0;position:relative;left:0;right:0;bottom:0;top:35px;margin:auto}.pop_menu ul li{margin-right:0;background:#413529;margin-bottom:10px;width:10%;cursor:pointer;text-align:center;color:#fff;display:table-cell;vertical-align:middle;height:60px;font-size:14px}.pop_menu ul li:first-child{margin-right:0;background:#fff;margin-bottom:10px;width:10%;cursor:pointer;text-align:center;color:#413529;display:table-cell;vertical-align:middle;height:60px;font-size:14px;border:1px solid #413529}.table-view{max-height:600px!important;overflow-y:scroll;width:100%}.popup_content{background:#ececec;border:3px solid #211b15;margin:auto}.popup_form{width:700px;border:1px solid #d5d5d5;background:#fff;height:40px}.popup_dropdown{width:155px;margin:0;border:none;height:40px;-webkit-appearance:none;-moz-appearance:none;appearance:none;background:url(images/polygon1.png) no-repeat 95% center;padding-left:17px;cursor:pointer;font-size:14px}.popup_text{width:538px;border:none;border-left:1px solid #d5d5d5;padding-left:17px;box-sizing:border-box;height:40px;font-size:16px;float:right}.auto_keywords{position:absolute;top:106px;width:537px;background:#fff;border:1px solid #d5d5d5;border-top:none;display:none}.auto_keywords ul{line-height:25px;font-size:16px}.auto_keywords ul li{padding-left:20px;cursor:pointer}.auto_keywords ul li a{text-decoration:none;color:#414141}.auto_keywords ul li:hover{background:#f2f2f2}.popup_btn{text-align:center;padding:33px 0 50px}.popup_cancel{background:#d5d5d5;cursor:pointer;padding:10px 27px;text-align:center;color:#767676;text-decoration:none;margin-right:16px;font-size:16px;display:none}.popup_btn input[type=button]{background:#a27639;cursor:pointer;padding:10px 27px;text-align:center;color:#fff;text-decoration:none;font-size:16px;float:right}.popup_close{color:#fff;right:0;font-size:20px;position:absolute;top:1px;width:15px;background:#413529;text-align:center}.popup_close a{color:#fff;text-decoration:none;cursor:pointer}.popup_searching{width:538px;float:right;position:relative}div.token-input-dropdown{z-index:999!important}.detail-table-div{display:block;float:left;overflow:hidden;border:1px solid #b3b3b3}.detail-table-div table{border-top:0!important;border-bottom:0!important;width:auto!important;margin:0!important}.detail-table-div th{background:#e5e5e5;text-align:right!important}.detail-table-div td{background:#fff;min-width:130px;text-align:right!important}.detail-table-div th:first-child{max-width:240px;text-align:left!important;min-width:240px;background:#c9c2af;padding:8px}.detail-table-div.cfs-head th:first-child{max-width:330px;text-align:left!important;min-width:330px;background:#c9c2af;padding:8px}.detail-table-div td:first-child{max-width:260px;text-align:left!important;min-width:260px;background:#e0d8c3}.detail-table-div td{padding:8px}.tab-res{display:block;overflow-x:visible!important;border:1px solid #b3b3b3;margin-left:280px!important}.tab-res.cfs-value{display:block;overflow-x:visible!important;border:1px solid #b3b3b3;margin-left:350px!important}.tab-res table{border-top:0!important;border-right:1px solid #b3b3b3;width:auto!important;margin:0!important}.tab-res th{background:#e5e5e5;text-align:right!important}.tab-res td{background:#fff;min-width:150px;text-align:right!important;padding:8px;border-right:1px solid #b3b3b3}.tab-res table thead th{border-bottom:1px solid #b3b3b3;border-right:1px solid #b3b3b3;text-align:left;padding:8px;font-weight:700}.tab-res th{background:#e5e5e5;text-align:right!important}detail-table-div table thead th:last-child{border-right:0!important}.tab-res table thead th{border-bottom:1px solid #b3b3b3}#allfinancial{display:inline-block;font-size:17px;color:#804040;font-weight:bolder;cursor:pointer;float:right}.companyinfo .toolbox6 p,.companyinfo .tooltip5 p,.dealinfo .toolbox6 p,.dealinfo .tooltip5 p{white-space:nowrap;width:100%;overflow:hidden;text-overflow:ellipsis}p.linktooltip a{display:none}p.linktooltip a:first-child{display:block}@media (min-width:1366px) and (max-width:2559px){#allfinancial{margin-right:5px}}@media (max-width:1500px){.popup_content{background:#ececec;height:calc(100% - -511px)!important}.table-view{height:400px;overflow-y:auto}.popup_main{top:45px}}@media (max-width:1025px){.popup_content{height:500px}.table-view{height:400px}.popup_main{top:80px}}@media (min-width:780px){.list_companyname{margin-left:160px!important}}@media (min-width:1280px){.list_companyname{margin-left:250px!important}#company_info table,#deal_info table{float:none!important;padding:0!important}}@media (max-width:1280px){#company_info table,#deal_info table{float:none!important;padding:0!important}td.investname{width:38%}}@media (min-width:1439px){.list_companyname{margin-left:340px!important}}@media (min-width:1639px){.list_companyname{margin-left:520px!important}}@media (min-width:1921px){.popup_content{background:#ececec;height:600px;overflow-y:auto}}.popup-button{text-decoration:none;font-size:14px;cursor:pointer;text-transform:uppercase;padding:5px 0 6px 5px;color:#fff;background-color:#a2753a;width:85px;float:right;text-align:center}.popup-export{width:100%;float:right;padding:0 5px 5px 0}.more_info .mCSB_container{margin-right:10px!important;margin-left:10px!important}.more_info .moreinfo_1{padding-right:0!important}.col-p-12_1{width:38.5%}.more_info .mCSB_draggerRail,.more_info .mCSB_dragger_bar{margin-right:0!important}@media (max-width:1280px){.col-p-8{width:27.5%}.col-md-6{width:100%}.batchwidth{width:20%}}@media (max-width:1245px){#container{margin-top:90px!important}.sec-header-fix{top:48px!important}.more_info{width:30%!important}.dealinfo{width:30%!important}.companyinfo{width:40%!important}}@media only screen and (max-width:1500px) and (min-width:1281px){.col-p-12{width:38.5%}.col-p-8{width:27.5%}.col-md-6{width:80%}.batchwidth{width:20%}}@media (max-width:1280px){.companyinfo{width:40%}.dealinfo{width:32%}.more_info{width:28%}}@media only screen and (max-width:1079px) and (min-width:920px){.sec-header-fix{top:48px!important}#container{margin-top:103px!important}}@media only screen and (max-width:1024px){.col-md-6{width:100%}.batchwidth{width:12%}td.investname{width:35%}.companyinfo h4,.companyinfo p,.dealinfo h4,.dealinfo p,.note-nia,.tableInvest td,.tableInvest td a,.tableInvest th{font-size:9pt!important}#company_info{margin-right:15px!important}#deal_info{margin-right:0!important;width:35%!important}#container{margin-top:144px!important}.moreinfo_1{height:220px}.period-date+.search-btn{margin-top:0}.sec-header-fix{top:51px!important;border-bottom:1px solid #fff;height:auto}.clear-sm{clear:both}#company_info{width:62%!important}.section1 .work-masonry-thumb1.more_info{height:auto}.more_info{width:100%!important}.row.section1{display:block!important}.col-md-6{width:100%;float:none;padding-right:0}.col-p-12 table,.col-p-8 table{padding:0}.moreinfo{padding:6px 0!important}.row.masonry .col-6{width:100%;padding:0}.more_info .mCSB_container{margin-left:0!important}}@media only screen and (max-width:768px){#container{margin-top:168px!important}.batchwidth{width:15%}.sec-header-fix{top:75px!important}.col-12 .tableInvest .table-width1{width:140px}.col-12 .tableInvest .table-width2{width:60px}.col-12 .tableInvest .table-width3{width:120px}.row.masonry .col-6{width:100%;padding:0}td.investname{width:30%}.col-12 .tableInvest .table-width1{padding-right:10px!important}#company_info,#deal_info{width:100%!important;margin-bottom:15px}}
</style>
<div id="container">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>

            <td class="left-td-bg" style="min-width: 36px;">
                <div class="acc_main" style="width: 35px;">
                    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide">Slide Panel</a></div>

                </div>
            </td>



            <td class="profile-view-left" style="width:100%;">
                <div class="result-cnt">

                    <?php if ($accesserror == 1) { ?>
                        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
                    <?php
                        exit;
                    }

                    ?>

                    <div class="result-title backbtn">

                        <a class="postlink" id="previous" href="dashboard.php?type=1">&lt; Back</a>

                    </div>



                    <div class="view-detailed">
                        <div class="detailed-title-links" style="padding-bottom:0px !important;">
                            <div class="pagetitle">Trend Reports</div>
                            <?php
                            $url_cont = explode('/', $_GET['location_cont']);
                            $location_cont = $url_cont[1];
                            ?>

                        </div>
                        <input type="hidden" id="currentdealdate" value="<?php echo $dealdate ?>">
                        <div class="view-table view-table-list filing-cnt" style="padding-top: 3px !important;width: 48.5%;float:left;">
                            <h3 class="table_h3" style="margin: 2px 5px;text-align: left !important;">Annual Reports</h3>
                            <ul class="accordionlist">
                                <?php
                                if (sizeof($aritems) > 0) {
                                    foreach ($aritems as $folder => $innerArray) {
                                        $liststr .= "<li><a class='toggle' data-dealdate='$folder' href='javascript:void(0);'> <span></span> $folder</a><ul class='subfolder' style='position:relative'>";
                                        foreach ($innerArray as $key => $value) {

                                            $liststr .= "<li><a class='innertoggle' data-dealdate='$key' href='javascript:void(0);'> <span style='position:absolute'></span> $key</a><ul class='inner'>";
                                            if (is_array($value)) {
                                                foreach ($value as $key => $value) {
                                                    $liststr .= "<li><a href='$value' target='_blank'  >$key</a></li>";
                                                }
                                                $liststr .= "</ul></li>";
                                            }
                                        }
                                        $liststr .= "</ul></li>";
                                    }
                                    echo $liststr;
                                } else {
                                    echo '<li style="font-size: 16px;padding: 10px;border-top: 1px solid #ccc;color: #c0a172;"><b> The Report section is currently not accessible. Please try after some time</b></li>';
                                }
                                // else {
                                //     echo "<li style='font-size: 16px;padding: 10px;border-top: 1px solid #ccc;color: #c0a172;'>No Records Found</li>";
                                // }

                                ?>
                            </ul>
                        </div>
                        <!-- SHP -->


                        <div class="view-table view-table-list filing-cnt" style="padding-top: 3px !important;width: 48.5%;float:left;margin-left:25px;position: relative;">
                            <h3 class="table_h3" style="margin: 2px 5px;text-align: left !important;">Quarterly Reports</h3>
                            <ul class="accordionlistqr">
                                <?php
                                if (sizeof($qritems) > 0) {
                                    foreach ($qritems as $folderqr => $innerArrayqr) {
                                        $liststrqr .= "<li><a class='toggleqr' data-dealdate='$folderqr' href='javascript:void(0);'> <span></span> $folderqr</a><ul class='subfolderqr' style='position:relative'>";
                                        foreach ($innerArrayqr as $key => $value) {

                                            $liststrqr .= "<li><a class='innertoggleqr' data-dealdate='$key' href='javascript:void(0);'> <span style='position:absolute'></span> $key</a><ul class='innerqr'>";
                                            if (is_array($value)) {
                                                foreach ($value as $key => $value) {
                                                    $liststrqr .= "<li><a href='$value' target='_blank'  >$key</a></li>";
                                                }
                                                $liststrqr .= "</ul></li>";
                                            }
                                        }
                                        $liststrqr .= "</ul></li>";
                                    }
                                    echo $liststrqr;
                                } else {
                                    echo '<li style="font-size: 16px;padding: 10px;border-top: 1px solid #ccc;color: #c0a172;"><b> The Report section is currently not accessible. Please try after some time</b></li>';
                                }
                                // else {
                                //     echo "<li style='font-size: 16px;padding: 10px;border-top: 1px solid #ccc;color: #c0a172;'>No Records Found</li>";
                                // }

                                ?>
                            </ul>



                        </div>


                    </div>
            </td>
        </tr>
    </table>
</div>

</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('.toggle').click(function(e) {
            e.preventDefault();

            var $this = $(this);
            $('.toggle').removeClass('active');
            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');
               
                $this.next().slideUp(350);
            } else {
                $this.parent().parent().find('li .subfolder').removeClass('show');
                $('.toggle').next().removeClass('show');
                $('.toggle').next().find('ul.inner').removeClass('show');
                $('.toggle').next().find('ul.inner').css('display','none');
                $('.innertoggle').removeClass('active');
                $this.parent().parent().find('li .subfolder').slideUp(350);
                $this.next().toggleClass('show');
                $(this).toggleClass('active');
                $this.next().slideToggle(350);
            }
        });
        $('.innertoggle').click(function(e) {
            e.preventDefault();

            var $this = $(this);
            $('.innertoggle').removeClass('active');
            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');
                $this.next().slideUp(350);
            } else {
                $this.parent().parent().find('li .inner').removeClass('show');

                $this.parent().parent().find('li .inner').slideUp(350);
                $this.next().toggleClass('show');
                $(this).toggleClass('active');
                $this.next().slideToggle(350);
            }
        });
        $('.toggleqr').click(function(e) {
            e.preventDefault();

            var $this = $(this);
            $('.toggleqr').removeClass('active');
            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');

                $this.next().slideUp(350);
            } else {
                $this.parent().parent().find('li .subfolderqr').removeClass('show');
                $('.toggleqr').next().removeClass('show');
                $('.toggleqr').next().find('ul.innerqr').removeClass('show');
                $('.toggleqr').next().find('ul.innerqr').css('display','none');
                $('.innertoggleqr').removeClass('active');
                $this.parent().parent().find('li .subfolderqr').slideUp(350);
                $this.next().toggleClass('show');
                $(this).toggleClass('active');
                $this.next().slideToggle(350);
            }
        });
        $('.innertoggleqr').click(function(e) {
            e.preventDefault();

            var $this = $(this);
            $('.innertoggleqr').removeClass('active');
            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');
                $this.next().slideUp(350);
            } else {
                $this.parent().parent().find('li .innerqr').removeClass('show');

                $this.parent().parent().find('li .innerqr').slideUp(350);
                $this.next().toggleClass('show');
                $(this).toggleClass('active');
                $this.next().slideToggle(350);
            }
        });
      
    });
</script>

</body>

</html>

<?php
function curPageURL()
{
    $URL = 'http';
    $portArray = array('80', '443');
    if ($_SERVER["HTTPS"] == "on") {
        $URL .= "s";
    }
    $URL .= "://";
    if (!in_array($_SERVER["SERVER_PORT"], $portArray)) {
        $URL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $URL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    $pageURL = $URL . "&scr=EMAIL";
    return $pageURL;
}

?>

<script>
    $(".btn-slide").click(function() {
        $(this).toggleClass("active");
        if ($('.left-td-bg').css("min-width") == '264px') {
            $('.left-td-bg').css("min-width", '36px');
            $('.acc_main').css("width", '35px');

        } else {
            $('.left-td-bg').css("min-width", '264px');
            $('.acc_main').css("width", '264px');

        }
        return false; //Prevent the browser jump to the link anchor
    });
</script>