<?php include_once("../globalconfig.php"); 
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('machecklogin.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Venture Intelligence</title>
<link href="<?php echo $refUrl; ?>css/ma_skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/detect800.css" />

<link href="hopscotch.min.css" rel="stylesheet"></link>
<link href="demo.css" rel="stylesheet"></link>

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo $refUrl; ?>js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script> 
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/expand.js"></script>
 <script src="<?php echo $refUrl; ?>js/showHide.js" type="text/javascript"></script>
 <script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.mCustomScrollbar.concat.min.js"></script>

<style type="text/css">
/* css for the header start*/

/*
== malihu jquery custom scrollbar plugin ==
Plugin URI: http://manos.malihu.gr/jquery-custom-content-scroller
*/



/*
CONTENTS: 
    1. BASIC STYLE - Plugin's basic/essential CSS properties (normally, should not be edited). 
    2. VERTICAL SCROLLBAR - Positioning and dimensions of vertical scrollbar. 
    3. HORIZONTAL SCROLLBAR - Positioning and dimensions of horizontal scrollbar.
    4. VERTICAL AND HORIZONTAL SCROLLBARS - Positioning and dimensions of 2-axis scrollbars. 
    5. TRANSITIONS - CSS3 transitions for hover events, auto-expanded and auto-hidden scrollbars. 
    6. SCROLLBAR COLORS, OPACITY AND BACKGROUNDS 
        6.1 THEMES - Scrollbar colors, opacity, dimensions, backgrounds etc. via ready-to-use themes.
*/



/* 
------------------------------------------------------------------------------------------------------------------------
1. BASIC STYLE  
------------------------------------------------------------------------------------------------------------------------
*/

.mCustomScrollbar{ -ms-touch-action: pinch-zoom; touch-action: pinch-zoom; /* direct pointer events to js */ }
    .mCustomScrollbar.mCS_no_scrollbar, .mCustomScrollbar.mCS_touch_action{ -ms-touch-action: auto; touch-action: auto; }
    
    .mCustomScrollBox{ /* contains plugin's markup */
        position: relative;
        overflow: hidden;
        height: 100%;
        max-width: 100%;
        outline: none;
        direction: ltr;
    }

    .mCSB_container{ /* contains the original content */
        overflow: hidden;
        width: auto;
        height: auto;
    }



/* 
------------------------------------------------------------------------------------------------------------------------
2. VERTICAL SCROLLBAR 
y-axis
------------------------------------------------------------------------------------------------------------------------
*/

    .mCSB_inside > .mCSB_container{ margin-right: 30px; }

    .mCSB_container.mCS_no_scrollbar_y.mCS_y_hidden{ margin-right: 0; } /* non-visible scrollbar */
    
    .mCS-dir-rtl > .mCSB_inside > .mCSB_container{ /* RTL direction/left-side scrollbar */
        margin-right: 0;
        margin-left: 30px;
    }
    
    .mCS-dir-rtl > .mCSB_inside > .mCSB_container.mCS_no_scrollbar_y.mCS_y_hidden{ margin-left: 0; } /* RTL direction/left-side scrollbar */

    .mCSB_scrollTools{ /* contains scrollbar markup (draggable element, dragger rail, buttons etc.) */
        position: absolute;
        width: 16px;
        height: auto;
        left: auto;
        top: 0;
        right: 0;
        bottom: 0;
    }

    .mCSB_outside + .mCSB_scrollTools{ right: -26px; } /* scrollbar position: outside */
    
    .mCS-dir-rtl > .mCSB_inside > .mCSB_scrollTools, 
    .mCS-dir-rtl > .mCSB_outside + .mCSB_scrollTools{ /* RTL direction/left-side scrollbar */
        right: auto;
        left: 0;
    }
    
    .mCS-dir-rtl > .mCSB_outside + .mCSB_scrollTools{ left: -26px; } /* RTL direction/left-side scrollbar (scrollbar position: outside) */

    .mCSB_scrollTools .mCSB_draggerContainer{ /* contains the draggable element and dragger rail markup */
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0; 
        height: auto;
    }

    .mCSB_scrollTools a + .mCSB_draggerContainer{ margin: 20px 0; }

    .mCSB_scrollTools .mCSB_draggerRail{
        width: 2px;
        height: 100%;
        margin: 0 auto;
        -webkit-border-radius: 16px; -moz-border-radius: 16px; border-radius: 16px;
    }

    .mCSB_scrollTools .mCSB_dragger{ /* the draggable element */
        cursor: pointer;
        width: 100%;
        height: 30px; /* minimum dragger height */
        z-index: 1;
    }

    .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ /* the dragger element */
        position: relative;
        width: 4px;
        height: 100%;
        margin: 0 auto;
        -webkit-border-radius: 16px; -moz-border-radius: 16px; border-radius: 16px;
        text-align: center;
    }
    
    .mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
    .mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{ width: 12px; /* auto-expanded scrollbar */ }
    
    .mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{ width: 8px; /* auto-expanded scrollbar */ }

    .mCSB_scrollTools .mCSB_buttonUp,
    .mCSB_scrollTools .mCSB_buttonDown{
        display: block;
        position: absolute;
        height: 20px;
        width: 100%;
        overflow: hidden;
        margin: 0 auto;
        cursor: pointer;
    }

    .mCSB_scrollTools .mCSB_buttonDown{ bottom: 0; }



/* 
------------------------------------------------------------------------------------------------------------------------
3. HORIZONTAL SCROLLBAR 
x-axis
------------------------------------------------------------------------------------------------------------------------
*/

    .mCSB_horizontal.mCSB_inside > .mCSB_container{
        margin-right: 0;
        margin-bottom: 30px;
    }
    
    .mCSB_horizontal.mCSB_outside > .mCSB_container{ min-height: 100%; }

    .mCSB_horizontal > .mCSB_container.mCS_no_scrollbar_x.mCS_x_hidden{ margin-bottom: 0; } /* non-visible scrollbar */

    .mCSB_scrollTools.mCSB_scrollTools_horizontal{
        width: auto;
        height: 16px;
        top: auto;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .mCustomScrollBox + .mCSB_scrollTools.mCSB_scrollTools_horizontal,
    .mCustomScrollBox + .mCSB_scrollTools + .mCSB_scrollTools.mCSB_scrollTools_horizontal{ bottom: -26px; } /* scrollbar position: outside */

    .mCSB_scrollTools.mCSB_scrollTools_horizontal a + .mCSB_draggerContainer{ margin: 0 20px; }

    .mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_draggerRail{
        width: 100%;
        height: 2px;
        margin: 7px 0;
    }

    .mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_dragger{
        width: 30px; /* minimum dragger width */
        height: 100%;
        left: 0;
    }

    .mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        width: 100%;
        height: 4px;
        margin: 6px auto;
    }
    
    .mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
    .mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{
        height: 12px; /* auto-expanded scrollbar */
        margin: 2px auto;
    }
    
    .mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
        height: 8px; /* auto-expanded scrollbar */
        margin: 4px 0;
    }

    .mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonLeft,
    .mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonRight{
        display: block;
        position: absolute;
        width: 20px;
        height: 100%;
        overflow: hidden;
        margin: 0 auto;
        cursor: pointer;
    }
    
    .mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonLeft{ left: 0; }

    .mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonRight{ right: 0; }



/* 
------------------------------------------------------------------------------------------------------------------------
4. VERTICAL AND HORIZONTAL SCROLLBARS 
yx-axis 
------------------------------------------------------------------------------------------------------------------------
*/

    .mCSB_container_wrapper{
        position: absolute;
        height: auto;
        width: auto;
        overflow: hidden;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin-right: 30px;
        margin-bottom: 30px;
    }
    
    .mCSB_container_wrapper > .mCSB_container{
        padding-right: 30px;
        padding-bottom: 30px;
        -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;
    }
    
    .mCSB_vertical_horizontal > .mCSB_scrollTools.mCSB_scrollTools_vertical{ bottom: 20px; }
    
    .mCSB_vertical_horizontal > .mCSB_scrollTools.mCSB_scrollTools_horizontal{ right: 20px; }
    
    /* non-visible horizontal scrollbar */
    .mCSB_container_wrapper.mCS_no_scrollbar_x.mCS_x_hidden + .mCSB_scrollTools.mCSB_scrollTools_vertical{ bottom: 0; }
    
    /* non-visible vertical scrollbar/RTL direction/left-side scrollbar */
    .mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden + .mCSB_scrollTools ~ .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
    .mCS-dir-rtl > .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_scrollTools.mCSB_scrollTools_horizontal{ right: 0; }
    
    /* RTL direction/left-side scrollbar */
    .mCS-dir-rtl > .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_scrollTools.mCSB_scrollTools_horizontal{ left: 20px; }
    
    /* non-visible scrollbar/RTL direction/left-side scrollbar */
    .mCS-dir-rtl > .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden + .mCSB_scrollTools ~ .mCSB_scrollTools.mCSB_scrollTools_horizontal{ left: 0; }
    
    .mCS-dir-rtl > .mCSB_inside > .mCSB_container_wrapper{ /* RTL direction/left-side scrollbar */
        margin-right: 0;
        margin-left: 30px;
    }
    
    .mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden > .mCSB_container{ padding-right: 0; }
    
    .mCSB_container_wrapper.mCS_no_scrollbar_x.mCS_x_hidden > .mCSB_container{ padding-bottom: 0; }
    
    .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden{
        margin-right: 0; /* non-visible scrollbar */
        margin-left: 0;
    }
    
    /* non-visible horizontal scrollbar */
    .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_container_wrapper.mCS_no_scrollbar_x.mCS_x_hidden{ margin-bottom: 0; }



/* 
------------------------------------------------------------------------------------------------------------------------
5. TRANSITIONS  
------------------------------------------------------------------------------------------------------------------------
*/

    .mCSB_scrollTools, 
    .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCSB_scrollTools .mCSB_buttonUp,
    .mCSB_scrollTools .mCSB_buttonDown,
    .mCSB_scrollTools .mCSB_buttonLeft,
    .mCSB_scrollTools .mCSB_buttonRight{
        -webkit-transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
        -moz-transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
        -o-transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
        transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
    }
    
    .mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger_bar, /* auto-expanded scrollbar */
    .mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerRail, 
    .mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger_bar, 
    .mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerRail{
        -webkit-transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                    margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                    margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                    opacity .2s ease-in-out, background-color .2s ease-in-out; 
        -moz-transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                    margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                    margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                    opacity .2s ease-in-out, background-color .2s ease-in-out; 
        -o-transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                    margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                    margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                    opacity .2s ease-in-out, background-color .2s ease-in-out; 
        transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                    margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                    margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                    opacity .2s ease-in-out, background-color .2s ease-in-out; 
    }



/* 
------------------------------------------------------------------------------------------------------------------------
6. SCROLLBAR COLORS, OPACITY AND BACKGROUNDS  
------------------------------------------------------------------------------------------------------------------------
*/

    /* 
    ----------------------------------------
    6.1 THEMES 
    ----------------------------------------
    */
    
    /* default theme ("light") */

    .mCSB_scrollTools{ opacity: 0.75; filter: "alpha(opacity=75)"; -ms-filter: "alpha(opacity=75)"; }
    
    .mCS-autoHide > .mCustomScrollBox > .mCSB_scrollTools,
    .mCS-autoHide > .mCustomScrollBox ~ .mCSB_scrollTools{ opacity: 0; filter: "alpha(opacity=0)"; -ms-filter: "alpha(opacity=0)"; }
    
    .mCustomScrollbar > .mCustomScrollBox > .mCSB_scrollTools.mCSB_scrollTools_onDrag,
    .mCustomScrollbar > .mCustomScrollBox ~ .mCSB_scrollTools.mCSB_scrollTools_onDrag,
    .mCustomScrollBox:hover > .mCSB_scrollTools,
    .mCustomScrollBox:hover ~ .mCSB_scrollTools,
    .mCS-autoHide:hover > .mCustomScrollBox > .mCSB_scrollTools,
    .mCS-autoHide:hover > .mCustomScrollBox ~ .mCSB_scrollTools{ opacity: 1; filter: "alpha(opacity=100)"; -ms-filter: "alpha(opacity=100)"; }

    .mCSB_scrollTools .mCSB_draggerRail{
        background-color: #000; background-color: rgba(0,0,0,0.4);
        filter: "alpha(opacity=40)"; -ms-filter: "alpha(opacity=40)"; 
    }

    .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        background-color: #fff; background-color: rgba(255,255,255,0.75);
        filter: "alpha(opacity=75)"; -ms-filter: "alpha(opacity=75)"; 
    }

    .mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{
        background-color: #fff; background-color: rgba(255,255,255,0.85);
        filter: "alpha(opacity=85)"; -ms-filter: "alpha(opacity=85)"; 
    }
    .mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
        background-color: #fff; background-color: rgba(255,255,255,0.9);
        filter: "alpha(opacity=90)"; -ms-filter: "alpha(opacity=90)"; 
    }

    .mCSB_scrollTools .mCSB_buttonUp,
    .mCSB_scrollTools .mCSB_buttonDown,
    .mCSB_scrollTools .mCSB_buttonLeft,
    .mCSB_scrollTools .mCSB_buttonRight{
        background-image: url(mCSB_buttons.png); /* css sprites */
        background-repeat: no-repeat;
        opacity: 0.4; filter: "alpha(opacity=40)"; -ms-filter: "alpha(opacity=40)"; 
    }

    .mCSB_scrollTools .mCSB_buttonUp{
        background-position: 0 0;
        /* 
        sprites locations 
        light: 0 0, -16px 0, -32px 0, -48px 0, 0 -72px, -16px -72px, -32px -72px
        dark: -80px 0, -96px 0, -112px 0, -128px 0, -80px -72px, -96px -72px, -112px -72px
        */
    }

    .mCSB_scrollTools .mCSB_buttonDown{
        background-position: 0 -20px;
        /* 
        sprites locations
        light: 0 -20px, -16px -20px, -32px -20px, -48px -20px, 0 -92px, -16px -92px, -32px -92px
        dark: -80px -20px, -96px -20px, -112px -20px, -128px -20px, -80px -92px, -96px -92px, -112 -92px
        */
    }

    .mCSB_scrollTools .mCSB_buttonLeft{
        background-position: 0 -40px;
        /* 
        sprites locations 
        light: 0 -40px, -20px -40px, -40px -40px, -60px -40px, 0 -112px, -20px -112px, -40px -112px
        dark: -80px -40px, -100px -40px, -120px -40px, -140px -40px, -80px -112px, -100px -112px, -120px -112px
        */
    }

    .mCSB_scrollTools .mCSB_buttonRight{
        background-position: 0 -56px;
        /* 
        sprites locations 
        light: 0 -56px, -20px -56px, -40px -56px, -60px -56px, 0 -128px, -20px -128px, -40px -128px
        dark: -80px -56px, -100px -56px, -120px -56px, -140px -56px, -80px -128px, -100px -128px, -120px -128px
        */
    }

    .mCSB_scrollTools .mCSB_buttonUp:hover,
    .mCSB_scrollTools .mCSB_buttonDown:hover,
    .mCSB_scrollTools .mCSB_buttonLeft:hover,
    .mCSB_scrollTools .mCSB_buttonRight:hover{ opacity: 0.75; filter: "alpha(opacity=75)"; -ms-filter: "alpha(opacity=75)"; }

    .mCSB_scrollTools .mCSB_buttonUp:active,
    .mCSB_scrollTools .mCSB_buttonDown:active,
    .mCSB_scrollTools .mCSB_buttonLeft:active,
    .mCSB_scrollTools .mCSB_buttonRight:active{ opacity: 0.9; filter: "alpha(opacity=90)"; -ms-filter: "alpha(opacity=90)"; }
    

    /* theme: "dark" */

    .mCS-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.15); }

    .mCS-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

    .mCS-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: rgba(0,0,0,0.85); }

    .mCS-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: rgba(0,0,0,0.9); }

    .mCS-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -80px 0; }

    .mCS-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -80px -20px; }

    .mCS-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -80px -40px; }

    .mCS-dark.mCSB_scrollTools .mCSB_buttonRight{ background-position: -80px -56px; }
    
    /* ---------------------------------------- */
    


    /* theme: "light-2", "dark-2" */

    .mCS-light-2.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-dark-2.mCSB_scrollTools .mCSB_draggerRail{
        width: 4px;
        background-color: #fff; background-color: rgba(255,255,255,0.1);
        -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
    }

    .mCS-light-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        width: 4px;
        background-color: #fff; background-color: rgba(255,255,255,0.75);
        -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
    }

    .mCS-light-2.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-dark-2.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-light-2.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-2.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        width: 100%;
        height: 4px;
        margin: 6px auto;
    }

    .mCS-light-2.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.85); }

    .mCS-light-2.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-light-2.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.9); }

    .mCS-light-2.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px 0; }

    .mCS-light-2.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -20px; }

    .mCS-light-2.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -40px; }

    .mCS-light-2.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -56px; }
    
    
    /* theme: "dark-2" */

    .mCS-dark-2.mCSB_scrollTools .mCSB_draggerRail{
        background-color: #000; background-color: rgba(0,0,0,0.1);
        -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
    }

    .mCS-dark-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        background-color: #000; background-color: rgba(0,0,0,0.75);
        -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
    }

    .mCS-dark-2.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

    .mCS-dark-2.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-dark-2.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

    .mCS-dark-2.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px 0; }

    .mCS-dark-2.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -20px; }

    .mCS-dark-2.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -40px; }

    .mCS-dark-2.mCSB_scrollTools .mCSB_buttonRight{ background-position: -120px -56px; }
    
    /* ---------------------------------------- */
    


    /* theme: "light-thick", "dark-thick" */

    .mCS-light-thick.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-dark-thick.mCSB_scrollTools .mCSB_draggerRail{
        width: 4px;
        background-color: #fff; background-color: rgba(255,255,255,0.1);
        -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
    }

    .mCS-light-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        width: 6px;
        background-color: #fff; background-color: rgba(255,255,255,0.75);
        -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
    }

    .mCS-light-thick.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-dark-thick.mCSB_scrollTools_horizontal .mCSB_draggerRail{
        width: 100%;
        height: 4px;
        margin: 6px 0;
    }

    .mCS-light-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        width: 100%;
        height: 6px;
        margin: 5px auto;
    }

    .mCS-light-thick.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.85); }

    .mCS-light-thick.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-light-thick.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.9); }

    .mCS-light-thick.mCSB_scrollTools .mCSB_buttonUp{ background-position: -16px 0; }

    .mCS-light-thick.mCSB_scrollTools .mCSB_buttonDown{ background-position: -16px -20px; }

    .mCS-light-thick.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -20px -40px; }

    .mCS-light-thick.mCSB_scrollTools .mCSB_buttonRight{ background-position: -20px -56px; }


    /* theme: "dark-thick" */
    
    .mCS-dark-thick.mCSB_scrollTools .mCSB_draggerRail{
        background-color: #000; background-color: rgba(0,0,0,0.1);
        -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
    }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        background-color: #000; background-color: rgba(0,0,0,0.75);
        -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
    }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_buttonUp{ background-position: -96px 0; }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_buttonDown{ background-position: -96px -20px; }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -100px -40px; }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_buttonRight{ background-position: -100px -56px; }
    
    /* ---------------------------------------- */
    


    /* theme: "light-thin", "dark-thin" */
    
    .mCS-light-thin.mCSB_scrollTools .mCSB_draggerRail{ background-color: #fff; background-color: rgba(255,255,255,0.1); }

    .mCS-light-thin.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-thin.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ width: 2px; }

    .mCS-light-thin.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-dark-thin.mCSB_scrollTools_horizontal .mCSB_draggerRail{ width: 100%; }

    .mCS-light-thin.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-thin.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        width: 100%;
        height: 2px;
        margin: 7px auto;
    }


    /* theme "dark-thin" */
    
    .mCS-dark-thin.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.15); }

    .mCS-dark-thin.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }
    
    .mCS-dark-thin.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }
    
    .mCS-dark-thin.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-dark-thin.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }
    
    .mCS-dark-thin.mCSB_scrollTools .mCSB_buttonUp{ background-position: -80px 0; }

    .mCS-dark-thin.mCSB_scrollTools .mCSB_buttonDown{ background-position: -80px -20px; }

    .mCS-dark-thin.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -80px -40px; }

    .mCS-dark-thin.mCSB_scrollTools .mCSB_buttonRight{ background-position: -80px -56px; }
    
    /* ---------------------------------------- */
    
    
    
    /* theme "rounded", "rounded-dark", "rounded-dots", "rounded-dots-dark" */
    
    .mCS-rounded.mCSB_scrollTools .mCSB_draggerRail{ background-color: #fff; background-color: rgba(255,255,255,0.15); }
    
    .mCS-rounded.mCSB_scrollTools .mCSB_dragger, 
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger, 
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_dragger, 
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger{ height: 14px; }
    
    .mCS-rounded.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        width: 14px;
        margin: 0 1px;
    }
    
    .mCS-rounded.mCSB_scrollTools_horizontal .mCSB_dragger, 
    .mCS-rounded-dark.mCSB_scrollTools_horizontal .mCSB_dragger, 
    .mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_dragger, 
    .mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_dragger{ width: 14px; }
    
    .mCS-rounded.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        height: 14px;
        margin: 1px 0;
    }
    
    .mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
    .mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
    .mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{
        width: 16px; /* auto-expanded scrollbar */
        height: 16px;
        margin: -1px 0;
    }
    
    .mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
    .mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{ width: 4px; /* auto-expanded scrollbar */ }
    
    .mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
    .mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
    .mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{
        height: 16px; /* auto-expanded scrollbar */
        width: 16px;
        margin: 0 -1px;
    }
    
    .mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
    .mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
        height: 4px; /* auto-expanded scrollbar */
        margin: 6px 0;
    }
    
    .mCS-rounded.mCSB_scrollTools .mCSB_buttonUp{ background-position: 0 -72px; }
    
    .mCS-rounded.mCSB_scrollTools .mCSB_buttonDown{ background-position: 0 -92px; }
    
    .mCS-rounded.mCSB_scrollTools .mCSB_buttonLeft{ background-position: 0 -112px; }
    
    .mCS-rounded.mCSB_scrollTools .mCSB_buttonRight{ background-position: 0 -128px; }
    
    
    /* theme "rounded-dark", "rounded-dots-dark" */
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.15); }
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -80px -72px; }
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -80px -92px; }
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -80px -112px; }
    
    .mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonRight{ background-position: -80px -128px; }
    
    
    /* theme "rounded-dots", "rounded-dots-dark" */
    
    .mCS-rounded-dots.mCSB_scrollTools_vertical .mCSB_draggerRail, 
    .mCS-rounded-dots-dark.mCSB_scrollTools_vertical .mCSB_draggerRail{ width: 4px; }
    
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
        background-color: transparent;
        background-position: center;
    }
    
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_draggerRail{
        background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAANElEQVQYV2NkIAAYiVbw//9/Y6DiM1ANJoyMjGdBbLgJQAX/kU0DKgDLkaQAvxW4HEvQFwCRcxIJK1XznAAAAABJRU5ErkJggg==");
        background-repeat: repeat-y;
        opacity: 0.3;
        filter: "alpha(opacity=30)"; -ms-filter: "alpha(opacity=30)"; 
    }
    
    .mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
        height: 4px;
        margin: 6px 0;
        background-repeat: repeat-x;
    }
    
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonUp{ background-position: -16px -72px; }
    
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonDown{ background-position: -16px -92px; }
    
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -20px -112px; }
    
    .mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonRight{ background-position: -20px -128px; }
    
    
    /* theme "rounded-dots-dark" */
    
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_draggerRail{
        background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAALElEQVQYV2NkIAAYSVFgDFR8BqrBBEifBbGRTfiPZhpYjiQFBK3A6l6CvgAAE9kGCd1mvgEAAAAASUVORK5CYII=");
    }
    
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -96px -72px; }
    
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -96px -92px; }
    
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -100px -112px; }
    
    .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonRight{ background-position: -100px -128px; }
    
    /* ---------------------------------------- */
    
    
    
    /* theme "3d", "3d-dark", "3d-thick", "3d-thick-dark" */
    
    .mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        background-repeat: repeat-y;
        background-image: -moz-linear-gradient(left, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%);
        background-image: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(255,255,255,0.5)), color-stop(100%,rgba(255,255,255,0)));
        background-image: -webkit-linear-gradient(left, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
        background-image: -o-linear-gradient(left, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
        background-image: -ms-linear-gradient(left, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
        background-image: linear-gradient(to right, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    }
    
    .mCS-3d.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        background-repeat: repeat-x;
        background-image: -moz-linear-gradient(top, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.5)), color-stop(100%,rgba(255,255,255,0)));
        background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
        background-image: -o-linear-gradient(top, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
        background-image: -ms-linear-gradient(top, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
        background-image: linear-gradient(to bottom, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    }
    
    
    /* theme "3d", "3d-dark" */
    
    .mCS-3d.mCSB_scrollTools_vertical .mCSB_dragger, 
    .mCS-3d-dark.mCSB_scrollTools_vertical .mCSB_dragger{ height: 70px; }
    
    .mCS-3d.mCSB_scrollTools_horizontal .mCSB_dragger, 
    .mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_dragger{ width: 70px; }
    
    .mCS-3d.mCSB_scrollTools, 
    .mCS-3d-dark.mCSB_scrollTools{
        opacity: 1;
        filter: "alpha(opacity=30)"; -ms-filter: "alpha(opacity=30)"; 
    }
    
    .mCS-3d.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ -webkit-border-radius: 16px; -moz-border-radius: 16px; border-radius: 16px; }
    
    .mCS-3d.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_draggerRail{
        width: 8px;
        background-color: #000; background-color: rgba(0,0,0,0.2);
        box-shadow: inset 1px 0 1px rgba(0,0,0,0.5), inset -1px 0 1px rgba(255,255,255,0.2);
    }
    
    .mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,    
    .mCS-3d.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
    .mCS-3d.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-3d.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-3d-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #555; }

    .mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ width: 8px; }

    .mCS-3d.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
        width: 100%;
        height: 8px;
        margin: 4px 0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.5), inset 0 -1px 1px rgba(255,255,255,0.2);
    }

    .mCS-3d.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        width: 100%;
        height: 8px;
        margin: 4px auto;
    }
    
    .mCS-3d.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }
    
    .mCS-3d.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }
    
    .mCS-3d.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }
    
    .mCS-3d.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -128px; }
    
    
    /* theme "3d-dark" */
    
    .mCS-3d-dark.mCSB_scrollTools .mCSB_draggerRail{
        background-color: #000; background-color: rgba(0,0,0,0.1);
        box-shadow: inset 1px 0 1px rgba(0,0,0,0.1);
    }
    
    .mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{ box-shadow: inset 0 1px 1px rgba(0,0,0,0.1); }
    
    .mCS-3d-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }

    .mCS-3d-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

    .mCS-3d-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

    .mCS-3d-dark.mCSB_scrollTools .mCSB_buttonRight{    background-position: -120px -128px; }
    
    /* ---------------------------------------- */
    
    
    
    /* theme: "3d-thick", "3d-thick-dark" */
    
    .mCS-3d-thick.mCSB_scrollTools, 
    .mCS-3d-thick-dark.mCSB_scrollTools{
        opacity: 1;
        filter: "alpha(opacity=30)"; -ms-filter: "alpha(opacity=30)"; 
    }
    
    .mCS-3d-thick.mCSB_scrollTools, 
    .mCS-3d-thick-dark.mCSB_scrollTools, 
    .mCS-3d-thick.mCSB_scrollTools .mCSB_draggerContainer, 
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_draggerContainer{ -webkit-border-radius: 7px; -moz-border-radius: 7px; border-radius: 7px; }
    
    .mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }
    
    .mCSB_inside + .mCS-3d-thick.mCSB_scrollTools_vertical, 
    .mCSB_inside + .mCS-3d-thick-dark.mCSB_scrollTools_vertical{ right: 1px; }
    
    .mCS-3d-thick.mCSB_scrollTools_vertical, 
    .mCS-3d-thick-dark.mCSB_scrollTools_vertical{ box-shadow: inset 1px 0 1px rgba(0,0,0,0.1), inset 0 0 14px rgba(0,0,0,0.5); }
    
    .mCS-3d-thick.mCSB_scrollTools_horizontal, 
    .mCS-3d-thick-dark.mCSB_scrollTools_horizontal{
        bottom: 1px;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.1), inset 0 0 14px rgba(0,0,0,0.5);
    }
    
    .mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        box-shadow: inset 1px 0 0 rgba(255,255,255,0.4);
        width: 12px;
        margin: 2px;
        position: absolute;
        height: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    
    .mCS-3d-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{ box-shadow: inset 0 1px 0 rgba(255,255,255,0.4); }
    
    .mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,  
    .mCS-3d-thick.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
    .mCS-3d-thick.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-3d-thick.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #555; }
    
    .mCS-3d-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        height: 12px;
        width: auto;
    }
    
    .mCS-3d-thick.mCSB_scrollTools .mCSB_draggerContainer{
        background-color: #000; background-color: rgba(0,0,0,0.05);
        box-shadow: inset 1px 1px 16px rgba(0,0,0,0.1);
    }
    
    .mCS-3d-thick.mCSB_scrollTools .mCSB_draggerRail{ background-color: transparent; }
    
    .mCS-3d-thick.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }
    
    .mCS-3d-thick.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }

    .mCS-3d-thick.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }

    .mCS-3d-thick.mCSB_scrollTools .mCSB_buttonRight{   background-position: -40px -128px; }
    
    
    /* theme: "3d-thick-dark" */
    
    .mCS-3d-thick-dark.mCSB_scrollTools{ box-shadow: inset 0 0 14px rgba(0,0,0,0.2); }
    
    .mCS-3d-thick-dark.mCSB_scrollTools_horizontal{ box-shadow: inset 0 1px 1px rgba(0,0,0,0.1), inset 0 0 14px rgba(0,0,0,0.2); }
    
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ box-shadow: inset 1px 0 0 rgba(255,255,255,0.4), inset -1px 0 0 rgba(0,0,0,0.2); }
     
    .mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{ box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), inset 0 -1px 0 rgba(0,0,0,0.2); }
    
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,  
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #777; }
    
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_draggerContainer{
        background-color: #fff; background-color: rgba(0,0,0,0.05);
        box-shadow: inset 1px 1px 16px rgba(0,0,0,0.1);
    }
    
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: transparent; }
    
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }
    
    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

    .mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonRight{  background-position: -120px -128px; }
    
    /* ---------------------------------------- */
    
    
    
    /* theme: "minimal", "minimal-dark" */
    
    .mCSB_outside + .mCS-minimal.mCSB_scrollTools_vertical, 
    .mCSB_outside + .mCS-minimal-dark.mCSB_scrollTools_vertical{
        right: 0; 
        margin: 12px 0; 
    }
    
    .mCustomScrollBox.mCS-minimal + .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
    .mCustomScrollBox.mCS-minimal + .mCSB_scrollTools + .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
    .mCustomScrollBox.mCS-minimal-dark + .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
    .mCustomScrollBox.mCS-minimal-dark + .mCSB_scrollTools + .mCSB_scrollTools.mCSB_scrollTools_horizontal{
        bottom: 0; 
        margin: 0 12px; 
    }
    
    /* RTL direction/left-side scrollbar */
    .mCS-dir-rtl > .mCSB_outside + .mCS-minimal.mCSB_scrollTools_vertical, 
    .mCS-dir-rtl > .mCSB_outside + .mCS-minimal-dark.mCSB_scrollTools_vertical{
        left: 0; 
        right: auto;
    }
    
    .mCS-minimal.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-minimal-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: transparent; }
    
    .mCS-minimal.mCSB_scrollTools_vertical .mCSB_dragger, 
    .mCS-minimal-dark.mCSB_scrollTools_vertical .mCSB_dragger{ height: 50px; }
    
    .mCS-minimal.mCSB_scrollTools_horizontal .mCSB_dragger, 
    .mCS-minimal-dark.mCSB_scrollTools_horizontal .mCSB_dragger{ width: 50px; }
    
    .mCS-minimal.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        background-color: #fff; background-color: rgba(255,255,255,0.2);
        filter: "alpha(opacity=20)"; -ms-filter: "alpha(opacity=20)"; 
    }
    
    .mCS-minimal.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-minimal.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
        background-color: #fff; background-color: rgba(255,255,255,0.5);
        filter: "alpha(opacity=50)"; -ms-filter: "alpha(opacity=50)"; 
    }
    
    
    /* theme: "minimal-dark" */
    
    .mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
        background-color: #000; background-color: rgba(0,0,0,0.2);
        filter: "alpha(opacity=20)"; -ms-filter: "alpha(opacity=20)"; 
    }
    
    .mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
        background-color: #000; background-color: rgba(0,0,0,0.5);
        filter: "alpha(opacity=50)"; -ms-filter: "alpha(opacity=50)"; 
    }
    
    /* ---------------------------------------- */
    
    
    
    /* theme "light-3", "dark-3" */
    
    .mCS-light-3.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-dark-3.mCSB_scrollTools .mCSB_draggerRail{
        width: 6px;
        background-color: #000; background-color: rgba(0,0,0,0.2);
    }

    .mCS-light-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ width: 6px; }

    .mCS-light-3.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-dark-3.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-light-3.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-dark-3.mCSB_scrollTools_horizontal .mCSB_draggerRail{
        width: 100%;
        height: 6px;
        margin: 5px 0;
    }
    
    .mCS-light-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-light-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
    .mCS-dark-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-dark-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
        width: 12px;
    }
    
    .mCS-light-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-light-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
    .mCS-dark-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
    .mCS-dark-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
        height: 12px;
        margin: 2px 0;
    }
    
    .mCS-light-3.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }
    
    .mCS-light-3.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }
    
    .mCS-light-3.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }
    
    .mCS-light-3.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -128px; }
    
    
    /* theme "dark-3" */
    
    .mCS-dark-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

    .mCS-dark-3.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

    .mCS-dark-3.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-dark-3.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }
    
    .mCS-dark-3.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.1); }
    
    .mCS-dark-3.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }

    .mCS-dark-3.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

    .mCS-dark-3.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

    .mCS-dark-3.mCSB_scrollTools .mCSB_buttonRight{ background-position: -120px -128px; }
    
    /* ---------------------------------------- */
    
    
    
    /* theme "inset", "inset-dark", "inset-2", "inset-2-dark", "inset-3", "inset-3-dark" */
    
    .mCS-inset.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-dark.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-2.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-3.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_draggerRail{
        width: 12px;
        background-color: #000; background-color: rgba(0,0,0,0.2);
    }

    .mCS-inset.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ 
        width: 6px;
        margin: 3px 5px;
        position: absolute;
        height: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .mCS-inset.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-2.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-2-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-3.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-3-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
        height: 6px;
        margin: 5px 3px;
        position: absolute;
        width: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    
    .mCS-inset.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-inset-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-inset-2.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-inset-2-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-inset-3.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
    .mCS-inset-3-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
        width: 100%;
        height: 12px;
        margin: 2px 0;
    }
    
    .mCS-inset.mCSB_scrollTools .mCSB_buttonUp, 
    .mCS-inset-2.mCSB_scrollTools .mCSB_buttonUp, 
    .mCS-inset-3.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }
    
    .mCS-inset.mCSB_scrollTools .mCSB_buttonDown, 
    .mCS-inset-2.mCSB_scrollTools .mCSB_buttonDown, 
    .mCS-inset-3.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }
    
    .mCS-inset.mCSB_scrollTools .mCSB_buttonLeft, 
    .mCS-inset-2.mCSB_scrollTools .mCSB_buttonLeft, 
    .mCS-inset-3.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }
    
    .mCS-inset.mCSB_scrollTools .mCSB_buttonRight, 
    .mCS-inset-2.mCSB_scrollTools .mCSB_buttonRight, 
    .mCS-inset-3.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -128px; }
    
    
    /* theme "inset-dark", "inset-2-dark", "inset-3-dark" */
    
    .mCS-inset-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

    .mCS-inset-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

    .mCS-inset-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-inset-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }
    
    .mCS-inset-dark.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.1); }
    
    .mCS-inset-dark.mCSB_scrollTools .mCSB_buttonUp, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonUp, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }

    .mCS-inset-dark.mCSB_scrollTools .mCSB_buttonDown, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonDown, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

    .mCS-inset-dark.mCSB_scrollTools .mCSB_buttonLeft, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonLeft, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

    .mCS-inset-dark.mCSB_scrollTools .mCSB_buttonRight, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonRight, 
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonRight{   background-position: -120px -128px; }
    
    
    /* theme "inset-2", "inset-2-dark" */
    
    .mCS-inset-2.mCSB_scrollTools .mCSB_draggerRail, 
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail{
        background-color: transparent;
        border-width: 1px;
        border-style: solid;
        border-color: #fff;
        border-color: rgba(255,255,255,0.2);
        -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;
    }
    
    .mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail{ border-color: #000; border-color: rgba(0,0,0,0.2); }
    
    
    /* theme "inset-3", "inset-3-dark" */
    
    .mCS-inset-3.mCSB_scrollTools .mCSB_draggerRail{ background-color: #fff; background-color: rgba(255,255,255,0.6); }
    
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.6); }
    
    .mCS-inset-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }
    
    .mCS-inset-3.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }
    
    .mCS-inset-3.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-inset-3.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }
    
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.75); }
    
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.85); }
    
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
    .mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.9); }
    
    /* ---------------------------------------- */

.clearfix{
    clear:both;
}
 .row.masonry {
    clear: both;
}   
.note-nia{
    color: #6c6c6c !important;
    font-weight: 600;
    font-size: 10pt;padding-top: 10px;padding-bottom: 10px;

}
.row.section1 {
    width: 100%;
    /* background-color: #f4f4f4; */
    background-color: #fff;
    margin-left: -18px;
    margin-right: -18px;
    padding-left: 18px;
    padding-right: 18px;
    padding-top: 18px;
    padding-bottom: 10px;
}
.section1 .work-masonry-thumb1 {
    margin-right: 15px;
    height: 252px;
}
#deal_info, #valuation_info {
    margin-right: 0.8px;
}

.row.masonry .col-6{
    width: 100%;
    /* padding: 7px 0; */
    box-sizing: border-box;
    /* vertical-align: middle; */
    display: inline-block;
    float: none;column-fill: auto;
}
.accordions_dealcontent .com-address-cnt{
    padding: 20px 0px 0px !important
}
/*.view-detailed{
    padding: 10px 0;
}*/
.detailtitle{
    position: relative !important;left: 0px !important;
}
.detailtitle a{
    font-size: 21px !important;
    color: #333;
    font-weight: 600;
        text-decoration: none;
    text-transform: capitalize;
}
.inner-section .action-links{
        background-color: #fff;
}
.profile-view-left{
    position:relative;
}
.tablelistview .more-info p{
    font-size: 9pt;
    line-height: 18px !important;
    text-align: justify;
}
.companyinfo_table td a{
    color: #666 !important;text-decoration: none;
}
.companydealcontent{
    height: 205px;
    
}
.valuationcontent{
    height: 175px;
    padding-top: 15px !important;
    padding-bottom: 25px !important;
    
}
.advisor_Table{
    padding: 2px !important;
}
.companyinfo tbody {
    display: block !important;
}
#deal_info tr, #valuation_info tr, #financials_info tr, #investor_info tr, #company_info tr, #advisor_info tr {
    border-bottom: 1px solid #ccc;
    /* overflow: hidden; */
    clear: both;
    width: 100%;
    float: left;
}
.valuation_info tr{
    border-bottom: 1px solid #ccc;
}
#investor_info tr, #company_info tr {
    margin: 0px;
}
.tablelistview3 tr {
    margin: 0px 0;
    overflow: visible !important;
}
.companyinfo td:first-child {
    width: 32% !important;
}
.valuationinfo td:first-child {
    width: 50% !important;
}
.valuationcontent{
    padding-right:10px !important;
}
#deal_info td:nth-child(1), #deal_info td:nth-child(3), #valuation_info td:first-child, #financials_info td:first-child, #investor_info td:first-child, #company_info td:first-child, #company_info td:nth-child(3), #advisor_info td:first-child {
    padding-left: 15px;
}
#deal_info td, #valuation_info td, #financials_info td, #investor_info td, #company_info td, #advisor_info td {
    width: 25%;
    display: inline-block;
    float: left;
    height: auto;
}
.companyinfo td, .dealinfo td,.valuationinfo td {
    padding: 5px 2px !important;
}
.work-masonry-thumb1 td {
    vertical-align: top;
    position: relative;
}
.tablelistview3 td {
    color: #6c6c6c;
    padding: 10px 20px 10px;
}
.work-masonry-thumb1{
  border:none !important;
  background-color: #fff !important;
}
.dealinfo_table, .companyinfo_table {
    border: none !important;
    width: 100% !important;
}
.section1 .accordions_dealcontent{
    /*border: 1px solid #4e4e4e;*/
    border: 1px solid #afb0b3;
    border-top: none;
    box-shadow: 0px 3px #d9dada;
    padding-right: 10px;
}
.row.masonry .col-6 {
    width: 50%;
    padding: 0px 8px;
    box-sizing: border-box;
    display: block;
    float: left;
}
.row.masonry .col-6:first-child{
    padding-left: 0px;
}
.row.masonry .col-6:nth-child(2){
    padding-right: 0px;
}
 @-moz-document url-prefix() {
    .row.masonry .col-6 {
        width: 50%;
        padding: 0px 8px;
        box-sizing: border-box;
        display: block;
        float: left;
    }
} 

    /*.redirection-icon{
        margin-left: 15px;
    }*/
    .m-15{
        margin-top: 15px;
    }


#sec-header table{
    height: 45px !important;
}
.sec-header-fix{
    height: 48px !important;
}
#container{
    margin-top:90px !important;
}
#sec-header h3{
    padding: 6px 20px 6px 0 !important;
}
.dealsubmit,#dealsubmit{
padding: 3px 0px 0px 0 !important;
}
.period-date select{
    margin-top: 5px !important;
}
.vertical-form{
    float:right;
}
..result-title ul{
    width: 95%;
}
.result-title li{
    /* padding: 0px 0 0px 10px; */
    padding: 2px 20px 0px 10px;
    margin: 0px 2px;
    margin-top: 3px;
    float: left;
    color: #333231;
    line-height: 23px;
    position: relative;
    font-size: 12px;
    background: transparent !important;
    border: 1px solid #ccc;
}
.result-title li a{
    margin-left: 0px;
    padding: 6px;
    border-left: 1px solid #fff;
    cursor: pointer;
    margin-right: 2px;
    float: right;
    margin-top: 1px;
    background: transparent !important;
}
.result-rt-cnt{
  margin-right:22px;
}
.result-select{
  margin-left:0px;
  padding: 0px 2px;
  padding-bottom: 3px;
  margin-top: 1px;
}
@media only screen and (min-width: 768px){
.maindex .investment-form {
    width: 46% !important;
}
}
input.export{
  background: none !important;
  border: none !important;
  background-color: #a27539 !important;
  margin-left: 10px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    text-transform: uppercase;
    padding: 5px 10px;
    color: #fff;
   padding-left: 10px !important;
   font-weight:600;

}
.result-select {
    border: none !important;
}
#icon_grid-view i {
    background-position: -23px -147px !important;
    margin-right: 5px;
}
.active #icon_detailed-view i, #icon_detailed-view:hover i {
    background-position: -73px -105px !important;
}
#icon_grid-view i:hover {
    background-position: -23px -105px !important;
    margin-right: 5px;
}
.list-tab li a i {
    background: url(../dealsnew/images/sprites-icons.png) no-repeat !important;
    width: 22px !important;
    height: 22px !important;
}
.detail-view-header, .detail-view-header .inner-section, .list-tab ul, .list-tab li.active a {
    background: #fff !important;
}
.list-tab li a {
    padding: 1px 2px !important;
}
.mt-list-tab h2 {
    padding: 10px 0px 5px 0px;
    font-size: 22px;
    /* margin-bottom: -1px; */
}
.text-center {
    text-align: center;
}
.detailtitle {
    position: relative !important;
    left: 0px !important;
}
.detailtitle a {
    font-size: 21px !important;
    color: #333;
    font-weight: 600;
    text-decoration: none;
    text-transform: capitalize;
}
.list-tab .inner-list {
    margin-top: -24px;
}
.list-tab .inner-list {
    display: inline-block;
    float: left;
    position: relative;
    z-index: 1;
}
.redirection-icon {
    padding-left: 15px;
    background: #fff !important;
    padding-top: 2px;
    padding-bottom: 0px;
    margin-top: -25px !important;
}
.inner-section-width1 {
    margin-right: 0px !important;
   
}
.inner-section-width1 {
    width: auto;
    float: right;
}
.inner-section {
    display: inline-block;
    box-sizing: border-box;
    text-align: center;
}
.inner-section .action-links {
    margin: 0px;
}
.inner-section .action-links {
    margin-top: 1px !important;
}
.inner-section .action-links {
    background-color: #fff;
}
.inner-section .action-links {
    float: right;
}
#previous, #next {
    display: inline-block;
}
#next .next-icon {
    background: url(../dealsnew/images/sprites-icons.png) no-repeat;
    width: 24px !important;
    height: 22px !important;
    display: inline-block;
}
.next-icon {
    background-position: -73px -230px !important;
}
#previous .previous-icon {
    background: url(../dealsnew/images/sprites-icons.png) no-repeat;
    width: 24px !important;
    height: 22px !important;
    display: inline-block;
}
.previous-icon {
    background-position: -23px -230px !important;
}

.row.masonry {
    clear: both;
}
.row.masonry .col-6:first-child {
    padding-left: 0px;
}
.row.masonry .col-6 {
    width: 50%;
    padding: 0px 8px;
    box-sizing: border-box;
    display: block;
    float: left;
}
.row.masonry .col-12 {
    width: 100%;
    /* padding-right: 8px; */
    box-sizing: border-box;
    display: block;
    float: left;
}
.col-6{
        width: 50%;
        float: left;
    }
.accordian-group {
    background: #fff !important;
    border: none !important;
    margin-bottom: 15px !important;
}
.accordian-group table {
        background: #fff;
        padding: 0px !important;
        width: 100%;
        box-sizing: border-box;
        border-top: none;
    }
    .accordian-group tr {
        border-bottom: 1px solid #ccc;
        clear: both;
        margin: 0px;
        width: 100%;
    }
    .accordian-group tr:last-child{
        border-bottom: none;
    }

    .accordian-group td{
    height: auto;
}
    .accordian-group tbody td {
        border-bottom: 1px solid #e6e5e5;
    }
    .valuationinfo .accordian-group tbody td {
        border-bottom: 1px solid #ccc !important;
        height:22px;
    }
    .accordian-group tbody td:last-child{
        border-bottom: none;
    }
    .accordian-group .innertable td{
        border-bottom: none !important;
        padding: 6px 0px;
        width: 50%;
    }
    .accordian-group tbody tr:last-child td{
        border-bottom: none !important;
    }

.work-masonry-thumb1 {
    font-size: 14px;
}
.accordions {
    position: relative;
}
.accordions_dealtitle{
  width: 100%;
    display: grid;
    grid-template-columns: 50px 1fr;
    background-color: #e0d8c3;
    cursor: pointer;
    border: 1px solid #a28669;
    margin-top: 2px;
    box-sizing: border-box;
}
.accordions_dealcontent{
    color: #000;
    box-shadow: 0px 3px #e3e4e4;
    border: 1px solid #afb0b3;
    border-top: 1px solid transparent;
    width: 100%;
    padding: 0px 20px;
    padding-top: 8px;
    padding-bottom: 7px;
    box-sizing: border-box;
    border-top: none;
}
.accordions_dealtitle span {
    align-self: center;
    display: block;
    padding-left: 15px;
}
.accordions_dealtitle.active span:after{
  background: url(../dealsnew/images/sprites-icons.png) no-repeat -72px -59px;
    width: 24px;
    height: 24px;
    display: block;
    margin-right: 5px;
    border-radius: 50px;
}
.accordions_dealtitle span:after{
  content: " ";
    background: url(../dealsnew/images/sprites-icons.png) no-repeat -22px -59px;
    width: 24px;
    height: 24px;
    display: block;
    margin-right: 5px;
    border-radius: 50px;
}
.box_heading.content-box {
  background: #e0d8c3 !important;
  border-radius: 5px 5px 0 0;
  text-transform: capitalize !important;
    color: #000000;
    overflow: hidden;
}
.accordions_dealtitle h2{
    padding: 10px 0px !important;
    margin: 0;
    color: #333333 !important;
    /* font-weight: bold; */
    text-transform: uppercase;
    font-size: 19px !important;
    background: #fff;
}
.section1 .accordions_dealcontent {
    /* border: 1px solid #4e4e4e; */
    border: 1px solid #afb0b3;
    border-top: none;
    box-shadow: 0px 3px #d9dada;
    padding-right: 10px;
}
.accordions_dealcontent {
    color: #000;
    /* transition: 0.8s linear; */
    box-shadow: 0px 3px #e3e4e4;
    border: 1px solid #afb0b3;
    border-top: 1px solid transparent;
    width: 100%;
    /* padding: 10px 20px; */
    padding: 0px 20px;
    padding-top: 8px;
    padding-bottom: 7px;
    box-sizing: border-box;
    border-top: none;
}

@media (min-width: 1280px){
#deal_info table, #company_info table, #valuation_info table {
    float: none !important;
    padding: 0px !important;
}
}
.tablelistview h4, .tablelistview2 h4, .tablelistview3 h4, .tablelistview4 h4 {
    text-transform: capitalize !important;
    /* padding: 1px 0; */
}
.companyinfo h4, .dealinfo h4,.valuationinfo h4 {
    font-size: 10pt !important;
    font-weight: 600 !important;
    color: #000 !important;
}
.companyinfo td:nth-child(2) {
    border-right: 1px solid transparent !important;
    width: 65% !important;
    position: relative;
}
.companyinfo td, .dealinfo td, .valuationinfo td {
    padding: 5px 2px !important;
}
.tablelistview p, .tablelistview2 p, .tablelistview3 p, .tablelistview4 p {
    padding: 4px 0px 2px 0px;
}
.accordions_dealcontent p {
    color: #666666;
    margin: 0px !important;
    font-size:13px;
}
.mCS-dark-3.mCSB_scrollTools .mCSB_draggerRail,.mCS-dark-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
    width: 3px !important;
}
.companyinfo .mCSB_scrollTools, .valuationinfo .mCSB_scrollTools{
    right: -6px !important;
}
.companyinfo .mCSB_inside>.mCSB_container,.dealinfo .mCSB_inside>.mCSB_container {
    margin-right: 10px !important;
}
.valuationinfo .mCSB_inside>.mCSB_container{
    margin-right: 20px !important;
}
.dealinfo td:first-child {
    width: 48% !important;
}
.dealinfo td:nth-child(2) {
    border-right: 1px solid transparent !important;
    width: 50% !important;
}
.dealinfotable th{
  border-bottom:none !important;
}
.valuationinfo td {
    padding: 6px 2px !important;
}
.advisor_Table tbody td {
    border-color: #ccc !important;
}
td {
    vertical-align: top;
} 
.advisor_innerTable td {
    padding: 5px 5px 5px 5px !important;
}
.advisor_Table .advisor_innerTable {
    border-left: none !important;
}
.dealinfotable tr:hover td{background:#fff;}
.tableview td, .work-masonry-thumb1 .tableview th{
    padding:8px 10px !important;
    text-transform: capitalize;
}
table.tablelistview3.companyinfo_table.valuation_info tr td:last-child {
    text-align: center;
}
.section1 .accordions_dealcontent{
    padding-left: 50px;
    padding-top: 10px;
}
.accordions_dealcontent{
    padding-left: 50px;
}
.advisor_Table p{font-weight:bold;}
.row.section1{
    padding-top:0px !important;
    padding-bottom:0px !important;
}
.accordions_dealcontent p{font-weight:600 !important;}
.historytrans th{
    text-align:left;
    padding: 12px 12px 10px 12px;
    border-bottom: 1px solid #ccc;
}
.historytrans td{
    padding: 0px 0px 10px 12px;
    border-bottom:1px solid transparent !important;
}
.historytrans tr:first-child td{
    padding: 12px 0px 10px 12px;
}
@media screen and (max-width: 1441px) and (min-width: 1279px) {
    .valuationinfo td:first-child {
    width: 60% !important;
}
}
@media only screen and (max-width: 1475px) and (min-width: 768px){
.key-search input[type="text"] {
    width: 125px !important;
}
}
/* .advisor_Table td{
height: 33px;
} */
/* css for the header end*/


    .ui-widget-overlay{z-index: 2000 !important;}
    .ui-dialog{position: fixed !important;z-index: 2001 !important;}
    .accordions_dealtitle h2 {
    font-size: 18px !important;
}
.result-select li{clear:both;}
</style>
 <script type="text/javascript">

$(document).ready(function(){

  $(".accordions_dealtitle").on("click", function() {
    
    $(this).toggleClass("active").next().slideToggle();
});
// (function($){
//     $(window).on("load",function(){

//         $(".moreinfo_1").mCustomScrollbar('update');
         
//     });
// })(jQuery); 
   $('.show_hide').showHide({			 
		speed: 800,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1 // if you dont want the button text to change, set this to 0
		
					 
	}); 
	$(".btn-slide").click(function(){
            
            $("#panel").animate({width: 'toggle'},{duration:200,step:function(){
                     if(demotour==1){
                     hopscotch.refreshBubblePosition();
                      }
            }}); 
            $(this).toggleClass("active"); 
                
            if($(this).hasClass("active")){
              if(demotour==1){
                hopscotch.startTour(tour, 6);   
              }
              //Added for the T-931 
              if ($('.left-td-bg').css("min-width") == '264px') {
                        $('.left-td-bg').css("min-width", '36px');
                        $('.acc_main').css("width", '35px');
                        
                        if($('.result-select li').height() <= '40'){
                            $('.result-select').css('max-width', '75%');
                            
                        }else{
                            $('.result-select').css('max-width', '94%');
                        
                        }
                        
                        $('.list-tab').css('margin-top',$('.result-title').height()+40);
                        
                }
                else {
                        $('.left-td-bg').css("min-width", '264px');
                        $('.acc_main').css("width", '264px');
                        
                        if($('.result-select li').height() <= '40'){
                            $('.result-select').css('max-width', '75%');
                            
                        }else{
                            if($('.result-select li').width() >= '450'){
                                $('.result-select').css('max-width', '75%');
                            
                            }else{
                            $('.result-select').css('max-width', '94%');
                            }
                        
                        }
                        
                    
                        $('.list-tab').css('margin-top',$('.result-title').height()+45);
                }
            }else{
                if ($('.left-td-bg').css("min-width") == '264px') {
                    $('.left-td-bg').css("min-width", '36px');
                    $('.acc_main').css("width", '35px');
                    
                
                        $('.result-select').css('max-width', '94%');
                                
                    $('.list-tab').css('margin-top',$('.result-title').height()+40);
                    
                }
                else {
                    $('.left-td-bg').css("min-width", '264px');
                    $('.acc_main').css("width", '264px');
                    
                    if($('.result-select li').height() <= '40'){
                        $('.result-select').css('max-width', '75%');
                        
                    }else{
                        if($('.result-select li').width() >= '450'){
                                $('.result-select').css('max-width', '75%');
                                
                        }else{
                        $('.result-select').css('max-width', '94%');
                        }
                    
                    }
                    
                
                    $('.list-tab').css('margin-top',$('.result-title').height()+45);
                }
            }
             //Added for the T-931    
                
            
           
            return false; //Prevent the browser jump to the link anchor
            });
	
	 
});
//Added for the T-931    
$(document).ready(function(){
$countryheight=$('.countryht').height();
if($countryheight>'100')
{
    $('.countryht').addClass('countryscroll');
}else{
    $('.countryht').removeClass('countryscroll');
}
});
//Added for the T-931    
</script>
 <script type="text/javascript" >
$(document).ready(function()
{
$(".account").click(function()
{

$('.submenu').toggle();
});

//Mouseup textarea false
$(".submenu").mouseup(function()
{
return false
});
$(".account").mouseup(function()
{
return false
});
//Textarea without editing.
$(document).mouseup(function()
{
$(".submenu").hide();
});

}); 

</script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/tytabs.jquery.min.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	 
	$("#tabsholder2").tytabs({
                prefixtabs:"tabz",
                prefixcontent:"contentz",
                classcontent:"tabscontent",
                tabinit:"1",
                catchget:"tab2",
                fadespeed:"normal"
                });
});
-->
</script>   
<script src="<?php echo $refUrl; ?>js/jPages.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.icheck.min.js?v=0.9.1"></script>
<script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>

<!-- Masonry -->
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>


<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.responsivetable.js"></script>
<script>
$(document).ready(function() {
$('.testTable1').responsiveTable( {scrollRight: false, scrollHintEnabled: false} );
});
</script>
    
<script type="text/javascript">
	
    jQuery(window).load(function() {
                    jQuery('.flexslider').flexslider({ directionNav: false });
                    jQuery(function(){
                            jQuery('.masonry-container').masonry({
                                    itemSelector: '.work-masonry-thumb',
                                    columnWidth: 159 
                            });
                    });

    });
    
  $(document).ready(function(){ 
//	$("#myTable").tablesorter({widthFixed: true}); 
//	$("div.holder").jPages({
//	  containerID : "movies",
//	  previous : "�? Previous",
//	  next : "Next →",
//	  perPage : 50,
//	  delay : 20
//	});
});
 $(document).ready(function(){
         // var  totlen=$('.cbox').length;
          var  checklen=$('.cbox:checked').length
        //   alert(checklen);
//            if (checklen <= 2) {
//            $("#checksearch").show();
//        } else {
//            $("#checksearch").hide();
//        }
        totlen=$('[name="dealtype[]"]').length;
        checklen=$('[name="dealtype[]"]:checked').length;
           if(totlen==0)
               $('#checksearch').hide();
           else
               $('#checksearch').show();
           
        $('input').on('ifChecked', function(event){
            totlen=$('[name="dealtype[]"]').length;
            checklen=$('[name="dealtype[]"]:checked').length;
           if(checklen==0){
              $('#checksearch').hide();
              if(demotour==1){
                 hopscotch.showStep(1);
               }
           }
           else{
               $('#checksearch').show();
              if(demotour==1){
                 hopscotch.showStep(2);
               }
               
           }
          });
          $('input').on('ifUnchecked', function(event){
                totlen=$('[name="dealtype[]"]').length;
                checklen=$('[name="dealtype[]"]:checked').length;
                if(checklen==0)
                {
                    $('#checksearch').hide();
                    alert("You must select atleast one Deal Type to search");
                    if(demotour==1){
                    hopscotch.showStep(1);
                    }
                    event.stopPropagation();
                    return false;
                }else{
                    $('#checksearch').show();
                     if(demotour==1){
                        hopscotch.showStep(2);
                     }
                }
          }); 
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
      });
    });
</script>   
 <script>
       
    
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) { 
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
			//( ".selector" ).on( "autocompletechange", function( event, ui ) {} );
          },
         /*  autocompletechange: "_removeIfInvalid",*/
		   
   			/*autocompletechange: function( event, ui ) { 
				$("form").submit();
			}*/
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
	
        $("#resetall").click(function (){
           
            $('#companysearch').attr("value","");
            $('#assectorsearch').attr("value","");
            $('#askeywordsearch').attr("value","");
           $('#asadvisorsearch_legal').attr("value","");
           $('#asadvisorsearch_trans').attr("value","");
           
        });
    
 
        
  });
 
 

/*$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);*/ 
      jQuery(window).load(function() {
                    jQuery('.flexslider').flexslider({ directionNav: false });
                    jQuery(function(){
                            jQuery('.masonry-container').masonry({
                                    itemSelector: '.work-masonry-thumb',
                                    columnWidth: 159 
                            });
                    });

    });
 
</script>
  <script>
  
  $(document).ready(function() {

	if ((screen.width>=1280) && (screen.height>=720))
	{
		//alert('Screen size: 1280x720 or larger');
		//$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect1024.css"});
	}
	else
	{
		//alert('Screen size: less than 1280x720, 1024x768, 800x600 maybe?');
		$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect800.css"});
	}
});
 
$(document).ready(function(){
 
  	$(".popup").LePopup({

		skin : "big-shadow"
           });



$('.typeoff-nav2').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
           var hrefval = 'index.php?type=1';
                    $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=1&value=0");
    }
    else if (value == 2) {
         var hrefval = 'index.php?type=2';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=2&value=0");
    }
    else if (value == 4) {
         var hrefval = 'index.php?type=4';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=4&value=0");
    }
    else if (value == 5) {
                     var hrefval = 'index.php?type=5';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=5&value=0");
    }
    else if (value == 6) {
                     var hrefval = 'index.php?type=6';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=6&value=0");
    }
});
});

$(document).ready(function() {
  $(".datesubmit").click(function() {
      
    var year1=$('#year1').val();
    var year2=$('#year2').val();
     
    var month1=$('#month1').val();
    var month2=$('#month2').val();
        
	if(year1 > year2)
	{
		alert("Error: 'To' Year cannot be before 'From' Year");
		return false;
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                alert("Error: 'To' Month cannot be before 'From' Month");
		return false;
            } 
            else
            {
                $("#pesearch").submit();
            }
        }
	else
	{
		$("#pesearch").submit();
	}
  
});
});

function checkForDate()
{
       
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
	if(year1 > year2)
	{
		alert("Error: 'To' date cannot be before 'From' date");
		return false;
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                alert("Error: 'To' Month cannot be before 'From' Month");
		return false;
            } 
            else
            {
                alert("adsasd");
                $("#controlName").val("dealperiod");
                $("#pesearch").submit();
            }
        }
	else
	{
                alert("asdasdasdasdsds");
                $("#controlName").val("dealperiod");
		$("#pesearch").submit();
	}
	
}

function checkForAggregates()
{
	document.manda.hiddenbutton.value='Aggregate';
	document.manda.submit();
}
 function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode

             if (((charCode > 47) && (charCode < 58 ) ) || (charCode == 8) || (charCode==46))
              {     return true;}
             else {  return false; }
          }
function isless()
//' do not submit if to < than from
           {

             var num1 = document.manda.txtmultipleReturnFrom.value;
             var num2 = document.manda.txtmultipleReturnTo.value;

             var x  = parseInt( num1  ,  10  )
             var y  = parseInt( num2  ,  10  )
             if(x > y)
                { 
                  alert("Please enter valid range");
                  return false;
                }

           }        

</script>
<script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});

</script>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
</head>

<?php if($_SESSION['MA_TrialLogin']==1){ ?>
<body > 
<?php }else { ?>
<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> 
<?php } ?>
    <div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(3000);
jQuery('#maskscreen').fadeOut(3000);
});
</script>
    <?php include_once('definitions.php');?>
    <?php include_once('marefinedef.php');?>
<!--Header-->
<?php
    $actionlink="index.php";
?>

<!--<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    -->
<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
<ul>
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?> id="dashboardmenu"><a href="madashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?> id="dealsmenu"><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?> id="directorymenu"><a href="pedirview.php"><i class="i-directory"></i>Directory</a></li>
</ul>
<ul class="fr">
   
     <!-- <li class="classic-btn classic-link"><a href="<?php echo GLOBAL_BASE_URL; ?>deals/madealsearch.php" >Classic View</a></li> -->
          <li class="classic-btn"><input  type="button" id="restartTourBtn" value="Start Tour" /></li>
          <li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input  autofocus="autofocus" type="text" name="searchallfield" id="searchallfield" placeholder=" Keyword Search"
                                                                                      <?php if($searchallfield!="") echo "value='".$searchallfield."'" ;?>
                                                                                       style="padding:5px;"  /> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>
<?php if($_SESSION['student']!="1") { ?>
    <li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $username; ?></span>
<?php } else {?>
        <li class="user-avt"><span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $username; ?></span>
<?php } ?>
<?php if($_SESSION['student']!="1") { ?>
<div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
		<ul class="dropdown-menu">
                        <li class="o_link"><a href="../pelogin.php" target="_blank">PE/VC Deals Database</a></li>
                        <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                        <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                        
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=M">Logout</a></li>
		</ul>
	</div>
<?php } ?></li>
</ul>
</td>
</tr>
</table>

</div>
<!--</form>

<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">-->
    <input type="hidden" id="controlName"  name="controlName"  value=""  />
    <input type="hidden" id="demoTour"  name="demoTour"  value="0"  />
<?php
$passwrd = $_GET['value'];
if($passwrd != 'P')
{
?>
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>

<td class="investment-form">
<div style="display:inline-flex">
<h3>Mergers & Acquistions</h3>
<label>DEAL TYPE 
    <a href="#popup3" class="help-icon1 tooltip" id="definition_step"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
    <span>
    <img class="callout1" src="<?php echo $refUrl; ?>images/callout.gif">
    Definitions
    </span>
           </a></label>
<?php 
    $invtypesql_search = "select MADealTypeId,MADealType from madealtypes order by MADealTypeId ";
    if ($invtypers = mysql_query($invtypesql_search))
    {
        $invtype_cnt = mysql_num_rows($invtypers);
    }
  ?>
<!--label><input type="checkbox" name="dealtype[]" value="--" checked /> All</label-->
    <?php
       /* populating the madealtypes from the madealtypes table */
       
        if($invtype_cnt >0)
        {
            While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
           {    $ischecked="";
                $id = $myrow["MADealTypeId"];
                $name = $myrow["MADealType"];
//                print_r($_POST['dealtype']);
                if($_POST['dealtype']!='' && count($_POST['dealtype'])<3)
                {
                    for($i=0;$i<count($_POST['dealtype']);$i++){
                           $t=$_POST['dealtype'][$i];
                            if($t == $id) 
                            {
                              $ischecked = 'checked="checked"';
                            }
                    }
                    echo '<label class="icheckbox"><input class="cbox dealtype" name="dealtype[]" type="checkbox"  data-related-item="'.$id.'" id="cbox'.$id.'"  value="'.$id.'" '.$ischecked.'>'.$name.'</label>';
                }
                else
                echo '<label class="icheckbox"><input class="cbox dealtype" type="checkbox" name="dealtype[]"  data-related-item="'.$id.'" id="cbox'.$id.'"  value="'.$id.'" checked>'.$name.'</label>';
            }
              mysql_free_result($invtypers);
        }
        
        
?>
 <div class="dealsubmit"> <input  id="checksearch" name="searchpe" type="submit" value="Search" style="padding:1px 7px;" /></div>
 </div>
</td>
    
<td class="vertical-form">
<!-- <h3>PERIOD</h3> -->

<div class="period-date">
<label>From</label>
<SELECT NAME="month1" id="month1">
     <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month1 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month1 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month1 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month1 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month1 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month1 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month1 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month1 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month1 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month1 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month1 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month1 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year1" id="year1"  id="year1">
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from mama order by DealDate desc";
		if($yearSql=mysql_query($yearsql))
		{
                        if($type == 1)  
                        {
                            if($_POST['year1']=='')
                            {
                                $year1;
                            }
                        }
                        else
                        {
                            if($_POST['year1']=='')
                            {
                                $year1;
                            }
                        }
			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}*/
                        $currentyear = date("Y");
                        $i=$currentyear;
                        While($i>= 2004 )
                        {
                        $id = $i;
                        $name = $i;
                        $isselected = ($year1==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i--;
                        }
		}
                
                
	?> 
</SELECT>
</div>
<div class="period-date">
<label>To</label>

<SELECT NAME="month2" id='month2'>
      <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month2 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month2 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month2 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month2 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month2 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month2 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month2 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month2 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month2 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month2 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month2 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month2 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year2" id="year2" onchange="checkForDate();" id='year2'>
    <OPTION id=2 value=""> Year </option>
    <?php 
		/*$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from mama order by DealDate asc";
                 if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}		
		}*/
                $currentyear = date("Y");
                $i=$currentyear;
                While($i>= 2004 )
                {
                $id = $i;
                $name = $i;
                $isselected = ($year2==$id) ? 'SELECTED' : '';
                echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                $i--;
                }
	?> 
</SELECT>
</div>
 <div class="dealsubmit"> <input  name="searchpe" type="submit" value="Search" class="datesubmit" style="padding:1px 7px;"/></div>
</td>
   
</tr>
</table>
</div>
<?php
}
?>
<script>
     function setCurControl(control)
    {       
        if(control=="industry" && demotour=='1')
        {
            if($("#industry").val()=="<?php  echo $tourIndustryId;?>")
            {
                 $("#controlName").val(control);
                 $("#pesearch").submit();
                 return true;
            }else
                {
                    showErrorDialog('Click on the industry tab and select "<?php echo $tourIndustryName;?>" to proceed further');
                    return false;
                }
        } else{
           $("#controlName").val(control);
           $("#pesearch").submit();
        }
    }
    //var $cBoxes = $('#1,#2,#3');
   /* $('#checksearch').attr("disabled",true);
$(".cbox").click(function(){
    alert("ddddddddddddd");
    $('#checksearch').attr('disabled', $('.cbox:checked').length >2);//submit will be disabled as per the boolean value of condition
});
    
    function evaluate(){
        
    var item = $(this);
    var relatedItem = $("#" + item.attr("data-related-item")).parent();
 if(item.is(":checked")){
        relatedItem.fadeIn();
    }else{
        relatedItem.fadeOut();   
    }

   $('.cbox').click(function() {
        if ( $('.cbox:checked').length <= 2) {
            $("#checksearch").show();
        } else {
            $("#checksearch").hide();
        }
    }); 
}

$('input[type="checkbox"]').click(evaluate).each(evaluate);*/
</script>