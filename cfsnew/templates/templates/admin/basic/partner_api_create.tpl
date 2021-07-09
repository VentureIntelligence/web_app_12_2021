{include file="admin/header.tpl"}
   <link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
   <script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
   <script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
   <script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
   <script type="text/javascript" src="{$smarty.const.BASE_URL}/cfsnew/admin/js/jquery.tablesorter.js"></script>
   {literal}
   <style type="text/css">
      /* CSS Document */
      .PLDPanel{
      display:none;
      cursor:pointer;
      }
      .BSPanel{
      display:none;
      }
      .CFPanel{
      display:none;
      }
      .PLDFlip{
      cursor:pointer;
      }
      .BSFlip{
      cursor:pointer;
      }
      .CFFlip{
      cursor:pointer;
      }
      .error{
      color:#990000;
      font-weight:bold;
      }
      /* CSS Clearfix */
      .clearfix:after {
      content: ".";
      display: block;
      height: 0;
      clear: both;
      visibility: hidden;
      }
      .clearfix{clear:both;}
      .clearfix {display: inline-table;}
      /* Hides from IE-mac \*/
      * html .clearfix {height: 1%;}
      .clearfix {display: block;}
      /* End hide from IE-mac */
      ul, ol, dl {
      list-style:none outside none;
      padding-left:20px;
      }
      p, pre, ul, ol, dl, dd, blockquote, address, fieldset, .gallery-row, .post-thumb, .post-thumb-single, .entry-meta {
      padding-bottom:0px;
      }
      /*END OF COMMON CODE*/
     
      .adtitle
      {
      font:bold 24px "Courier New", Courier, monospace;
      margin:55px 0;
      color:#000;
      }
    
      .col-3 {
      width: 40%;
      float: left;
      }
      .col-2 {
      width: 25%;
      float: left;
      }
      .body-overlay, .body-overlay2 {
      background: rgba(0,0,0,0.5);
      display: none;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      z-index:9;
      }
      .desc_content{
        text-align: center;
        width: 355px;
      }
      .p_title{
        font-weight: 100;
        color: #1b1919;
        margin-bottom: 10px;
      }
      hr {
        margin: 20px 355px 19px;
        border: 0;
        border-bottom: 2px solid #c1bcbc;
    }
    .internal_partners_btn{
        color: #fff;
        background: #58331a;
        padding: 15px 70px;
        margin: 10px;
        font-weight: 600;
    }
    .internal_partners_btn:hover{
        color: #fff;
        background: #58331a;
        padding: 15px 70px;
        margin: 10px;
        font-weight: 600;
        text-decoration: none;
    }
    .external_partners_btn:hover{
        color: #fff;
        background: #a96231;
        padding: 15px 70px;
        margin: 10px;
        font-weight: 600;
        text-decoration: none;
    }
    .external_partners_btn{
        color: #fff;
        background: #a96231;
        padding: 15px 70px;
        margin: 10px;
        font-weight: 600;
    }
    .sub_api_partners_btn{
        color: #fff;
        background: #6e5d51;
        padding: 15px 70px;
        margin: 10px;
        font-weight: 600;
    }
    .sub_api_partners_btn:hover{
        color: #fff;
        background: #6e5d51;
        padding: 15px 70px;
        margin: 10px;
        font-weight: 600;
        text-decoration: none;
    }
    .partners_type{
        margin-top:50px;
    }
    .fa{
        font-size: 14px;
        color: #d6913b;
        padding-left: 6px;
    }
   </style>
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
       {/literal} 

<div class="body-overlay">
   <div class="loader-text"></div>
</div>
<div class="contentbg">
<div class="breadcrumb">
   <div class="breadtext">&nbsp;</div>
</div>
<div class="container">
   <div class="content" style="height: 200px;">
      <div>
         <span style="float:left; font-size: 13px; text-decoration: underline;"><a href="{$smarty.const.ADMIN_BASE_URL}index.php">Back to Home</a></span>
      </div>
      <div class="adtitle" align="center">
         VENTURE
      </div>
      <div class="select_log" align="center">
        <div class="partners_type">
            <a href="create-partner.php?type=CFS" class="sub_api_partners_btn"> CFS API Partners <i class="fa fa-sign-in" aria-hidden="true"></i></a>
             <a href="create-partner.php?type=PE" class="sub_api_partners_btn"> PE API Partners <i class="fa fa-sign-in" aria-hidden="true"></i></a>
        </div>
         {* <div class="partners_type">
            <a href="create-partner.php?type=basic_api_partner" class="sub_api_partners_btn"> Basic API Partners <i class="fa fa-sign-in" aria-hidden="true"></i></a>
        </div> *}
      </div>
   </div>
</div>