<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$pageTitle}</title>
 <script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
 {* T935 CFS Dashboard *}
{if !$url_valid}
 <script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}prototype.js"></script>
 {/if}
 <link type="text/css" rel="stylesheet" href="{$ADMIN_CSS_PATH}bootstrap.min.css" />
 <link type="text/css" rel="stylesheet" href="{$ADMIN_CSS_PATH}header.css" />
 <link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
{literal}
<style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
      }
      .container > footer p {
        text-align: center; /* center align it with the container */
      }
      .container {
        width: 915px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
      }

      /* The white background content wrapper */
      .container > .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      /* Page header tweaks */
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      /* Styles you shouldn't keep as they are for displaying this base example only */
      .content .span10,
      .content .span4 {
        min-height: 500px;
      }
      /* Give a quick and non-cross-browser friendly divider */
      .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }

      .topbar .btn {
        border: 0;
      }

</style>
{/literal}
<div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="{$smarty.const.ADMIN_BASE_URL}index.php">CFS Admin Panel</a>
        {if $curPage neq 'register.php'}
      <ul class="nav" {if $Usr_Type eq 4}style="float: right;"{/if}>
        {if $Usr_Type eq 4}
    
      <li {if $curPage eq 'logout.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}logout.php">logout</a></li>
   
{else}
        {if $Usr_Flag eq 1 or $Usr_Flag eq 2 or $Usr_Type eq 6}<li {if $curPage eq 'cfs_dashboard.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}cfs_dashboard.php">Dashboard</a></li>{/if}
         {if $Usr_Flag eq 1 or $Usr_Flag eq 2 or $Usr_Type eq 6}<li {if $curPage eq 'pmanagement.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}pmanagement.php">Company Profile</a></li>{/if}
       {if $Usr_Flag eq 1 or $Usr_Flag eq 2 or $Usr_Type eq 6}<li {if $curPage eq 'fmanagement.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}fmanagement.php">Company Financials</a></li>{/if}
       {if $Usr_Flag eq 1}<li {if $curPage eq 'addIndustry.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}addIndustry.php">Add Industry</a></li>{/if}
       {if $Usr_Flag eq 1}<li {if $curPage eq 'addSector.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}addSector.php">Add Sector</a></li>{/if}
       {if $Usr_Flag eq 1}<li {if $curPage eq 'adminusers.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}adminusers.php">Admin Users</a></li>{/if}
       {if $Usr_Flag eq 1}<li {if $curPage eq 'naicsCodeCheck.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}naicsCodeCheck.php">NAICS Code Check</a></li>{/if}
         {if $Usr_Flag eq 1}<li {if $curPage eq 'index.php'}{/if}><a href="{$smarty.const.ADMIN_BASE_URL}index.php">Back To Home</a></li>{/if}
      <li {if $curPage eq 'logout.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}logout.php">logout</a></li>
    {/if} 
  {/if}  
          </ul>
        </div>
      </div>
    </div>
</head>