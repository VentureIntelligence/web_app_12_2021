<?php /* Smarty version 2.5.0, created on 2020-08-18 16:59:56
         compiled from admin/header.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $this->_tpl_vars['pageTitle']; ?>
</title>
 <script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
 
<?php if (! $this->_tpl_vars['url_valid']): ?>
 <script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
prototype.js"></script>
 <?php endif; ?>
 <link type="text/css" rel="stylesheet" href="<?php echo $this->_tpl_vars['ADMIN_CSS_PATH']; ?>
bootstrap.min.css" />
 <link type="text/css" rel="stylesheet" href="<?php echo $this->_tpl_vars['ADMIN_CSS_PATH']; ?>
header.css" />
 <link href="<?php echo $this->_tpl_vars['ADMIN_CSS_PATH']; ?>
home.css" rel="stylesheet" type="text/css" media="screen"/>
<?php echo '
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

      /* Styles you shouldn\'t keep as they are for displaying this base example only */
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
'; ?>

<div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="<?php echo @constant('ADMIN_BASE_URL'); ?>
index.php">CFS Admin Panel</a>
        <?php if ($this->_tpl_vars['curPage'] != 'register.php'): ?>
      <ul class="nav" <?php if ($this->_tpl_vars['Usr_Type'] == 4): ?>style="float: right;"<?php endif; ?>>
        <?php if ($this->_tpl_vars['Usr_Type'] == 4): ?>
    
      <li <?php if ($this->_tpl_vars['curPage'] == 'logout.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
logout.php">logout</a></li>
   
<?php else: ?>
        <?php if ($this->_tpl_vars['Usr_Flag'] == 1 || $this->_tpl_vars['Usr_Flag'] == 2 || $this->_tpl_vars['Usr_Type'] == 6): ?><li <?php if ($this->_tpl_vars['curPage'] == 'cfs_dashboard.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
cfs_dashboard.php">Dashboard</a></li><?php endif; ?>
         <?php if ($this->_tpl_vars['Usr_Flag'] == 1 || $this->_tpl_vars['Usr_Flag'] == 2 || $this->_tpl_vars['Usr_Type'] == 6): ?><li <?php if ($this->_tpl_vars['curPage'] == 'pmanagement.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
pmanagement.php">Company Profile</a></li><?php endif; ?>
       <?php if ($this->_tpl_vars['Usr_Flag'] == 1 || $this->_tpl_vars['Usr_Flag'] == 2 || $this->_tpl_vars['Usr_Type'] == 6): ?><li <?php if ($this->_tpl_vars['curPage'] == 'fmanagement.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
fmanagement.php">Company Financials</a></li><?php endif; ?>
       <?php if ($this->_tpl_vars['Usr_Flag'] == 1): ?><li <?php if ($this->_tpl_vars['curPage'] == 'addIndustry.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
addIndustry.php">Add Industry</a></li><?php endif; ?>
       <?php if ($this->_tpl_vars['Usr_Flag'] == 1): ?><li <?php if ($this->_tpl_vars['curPage'] == 'addSector.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
addSector.php">Add Sector</a></li><?php endif; ?>
       <?php if ($this->_tpl_vars['Usr_Flag'] == 1): ?><li <?php if ($this->_tpl_vars['curPage'] == 'adminusers.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
adminusers.php">Admin Users</a></li><?php endif; ?>
       <?php if ($this->_tpl_vars['Usr_Flag'] == 1): ?><li <?php if ($this->_tpl_vars['curPage'] == 'naicsCodeCheck.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
naicsCodeCheck.php">NAICS Code Check</a></li><?php endif; ?>
         <?php if ($this->_tpl_vars['Usr_Flag'] == 1): ?><li <?php if ($this->_tpl_vars['curPage'] == 'index.php'): ?><?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
index.php">Back To Home</a></li><?php endif; ?>
      <li <?php if ($this->_tpl_vars['curPage'] == 'logout.php'): ?>class="active"<?php endif; ?>><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
logout.php">logout</a></li>
    <?php endif; ?> 
  <?php endif; ?>  
          </ul>
        </div>
      </div>
    </div>
</head>