{include file='admin/header.tpl'}
<script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
 <script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}prototype.js"></script>
{literal}
<style type="text/css">
div{margin:0; padding:0;}
.boxcont{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#999;
}
.boxcont a{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#999;
}

.bcontainer
{
width:820px;
margin:0 auto;
background-color:#eee;
border-left:#000000 solid 1px;
border-right:#000000 solid 1px;

border-bottom:#000000 solid 1px;
padding:15px;

}

.label a{
float: left;
width: 250px;
font-weight: bold;
margin-right:15px;
font-size:18px;
}

.label h2
{
font:bold 18px Arial, Helvetica, sans-serif;
margin-top:5px;
}
input, textarea{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#777;
}

textarea{
width: 250px;
height: 150px;
padding:5px 10px;
}

table th {
    background: #bfbfbf;
    /* color: #fff !important; */
}
table th, table td {
    border: 1px solid #000;
}
a.disable:hover {
    cursor: not-allowed;
    text-decoration: none;
    color: #0069d6;
}
</style>
{/literal}
</head>
<body>
<div class="bcontainer">
    <div class="label" style="margin-bottom:10px;">
    <h2>CFS Admin</h2>
    </div>
    <div style="clear:both"></div>
    <div style="width: 50%;float: left;">

  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="addCity.php">Add City</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="addState.php">Add State</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="addArchive.php">Add Archive</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="shareholder.php">Add Shareholder Information</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="competitors.php">Add Competitors</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="othercomparables.php">Add Other Comparables</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="rating.php">Add Rating</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="news.php">Add News</a></h2>{/if}  
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="addRound.php">Add ShareRound</a></h2>{/if}
  
  
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="editGroup.php"> Group Management </a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="users.php"> User Management </a></h2>{/if}

  {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 2 or $Usr_Type eq 6}<h2 style="font-size:13px;"><a href="deletePlstandard.php">Delete P & L Standard</a></h2>{/if}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="deleteSector.php">Delete Sector</a></h2>{/if}
  
  {if $Usr_Type eq 1 or $Usr_Type eq 3}<h2 style="font-size:13px;"><a href="otherReport.php">Report Management</a></h2>{/if}
  {if $GLOBAL_BASE_URL eq 'https://dev.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://www.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://localhost/vi_webapp/'}
  {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 }  <h2 style="font-size:18px;">XBRL Automation</h2>{/if}
  
      <div>
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/xbrlparse.php">DB Update</a></h3>{/if}
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/forex_update.php">Forex Update</a></h3>{/if}
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/earning_update.php">Earnings Update</a></h3>{/if}
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/xbrl_log.php">Log History</a></h3>{/if}    
      </div>
      {/if}
    </div>
    <div style="width: 50%;float: left;">
      {if $GLOBAL_BASE_URL eq 'https://www.ventureintelligence.com/' or $GLOBAL_BASE_URL eq 'http://localhost/vi_webapp/'}
     {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 }  <h2 style="font-size:18px;">XBRL Automation</h2>{/if}
  
      <div>
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/xbrlparse.php">DB Update</a></h3>{/if}
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/forex_update.php">Forex Update</a></h3>{/if}
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/earning_update.php">Earnings Update</a></h3>{/if}
       {if $Usr_Type eq 1 or $Usr_Type eq 3 or $Usr_Type eq 4 or $Usr_Type eq 6 } <h3 style="font-size:13px;"><a href="xbrl/xbrl_log.php">Log History</a></h3>{/if}    
      </div>
      {/if}
     
     
      {if $Usr_Type eq 1 or $Usr_Type eq 3}<!-- <h2 style="font-size:13px;"><a href="xbrlparse.php">XBRL Automation</a></h2> -->{/if}
      
      {if $GLOBAL_BASE_URL eq 'https://www.ventureintelligence.com/' or $GLOBAL_BASE_URL eq 'https://localhost/vi_webapp/'}
      {if $Usr_Type eq 1 or $Usr_Type eq 3}<div style="margin-top:20px;"> 
      <table>
        <thead>
          <tr>
            <th colspan="2"style="text-align: center;"> {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Mobile API</h2>{/if}</th>
          </tr>
          <tr>
            <th>CFS</th>
            <th>PE</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/mobile_api_tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 hidden style="font-size:13px;"><a href="mobile/mobile_api_tracker_vi.php"></a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/mobile_api_details.php">Details</a></h3>{/if}
        </div>
            </td>
            <td>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/PE/mobile_api_tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 hidden style="font-size:13px;"><a href="mobile/PE/mobile_api_tracker_vi.php"></a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/PE/mobile_api_details.php">Details</a></h3>{/if}
        </div>
            </td>
          </tr>
        </tbody>
      </table>
     </div>
{/if}
{/if}

{if $GLOBAL_BASE_URL eq 'https://dev.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://www.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://localhost/vi_webapp/'}
{if $Usr_Type eq 1 or $Usr_Type eq 3}
     <div style="margin-top:20px;"> 
      <table>
        <thead>
          <tr>
            <th colspan="2"style="text-align: center;"> {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Partner API</h2>{/if}</th>
          </tr>
          <tr>
            <th style="width: 47%;">CFS</th>
            <th style="width: 53%;">PE</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partner-api-create.php">Create Partner</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partners-list.php">Manage Partners</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partner-api-tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partner-api-details.php">Details</a></h3>{/if}
        </div>
            </td>
            <td>
             <div>
         {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partner-api-create.php">Create Partner</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partners-list.php">Manage Partners</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partner-api-tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/sub-partner-api-tracker.php">Tracking Dashboard - SUB API</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partner-api-details.php">Details</a></h3>{/if} 

           {* {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="#" class="disable">Create Partner</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="#" class="disable">Manage Partners</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="#" class="disable">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="#" class="disable">Details</a></h3>{/if} *}
        </div>
            </td>
          </tr>
        </tbody>
      </table>
     </div>{/if}
     {/if}



{if $GLOBAL_BASE_URL eq 'https://dev.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://www.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://localhost/vi_webapp/'}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}
     <div style="margin-top:20px;"> 
      <table>
        <thead>
          <tr>
            <th colspan="2"style="text-align: center;"> {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">News API</h2>{/if}</th>
          </tr>
          {* <tr>
            <th style="width: 53%;">PE</th>
          </tr> *}
        </thead>
        <tbody>
          <tr>
          
            <td>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="news/partner-api-create.php">Create Partner</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="news/partners-list.php">Manage Partners</a></h3>{/if}
        
        </div>
            </td>
          </tr>
        </tbody>
      </table>
     </div>
  {/if}
{/if}



{if $GLOBAL_BASE_URL eq 'https://dev.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://www.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://localhost/vi_webapp/'}
  {if $Usr_Type eq 1 or $Usr_Type eq 3}
     <div style="margin-top:20px;"> 
      <table>
        <thead>
          <tr>
            <th colspan="2"style="text-align: center;"> {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Basic API</h2>{/if}</th>
          </tr>
          {* <tr>
            <th style="width: 53%;">PE</th>
          </tr> *}
        </thead>
        <tbody>
          <tr>
          
            <td>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="basic/partner-api-create.php">Create Partner</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="basic/partners-list.php">Manage Partners</a></h3>{/if}
        
        </div>
            </td>
          </tr>
        </tbody>
      </table>
     </div>
  {/if}
{/if}




     {if $GLOBAL_BASE_URL eq 'https://dev.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://www.vionweb.com/' or $GLOBAL_BASE_URL eq 'https://localhost/vi_webapp/'}
  <div style="margin-top:20px;"> 
      <table>
        <thead>
          <tr>
            <th colspan="2"style="text-align: center;">
             {if $Usr_Type eq 1 or $Usr_Type eq 3}
             <h2 style="font-size:18px;">Full API</h2>{/if}</th>
          </tr>
          <tr>
            <th colspan='2'>Web Access</th> 
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
             <div>
          {if $Usr_Type eq  1 or $Usr_Type eq 3} <h3 style="font-size:13px;">
          <a href="editGroup_API.php">CFS Companies </a></h3>{/if}
           </div>
            </td>
            <td>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;">
          <a href="editGroup-api-pe.php"> PE  Companies</a></h3>{/if}
        </div>
            </td>
          </tr>
          <tr>
            <th colspan='2'>Web Access Only</th> 
          </tr>
          <tr>
            <th>CFS</th>
            <th>PE</th>
          </tr>
          <tr>
            <td>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;">
          <a href="external_add_adminuser.php">Create User </a></h3>{/if}
           </div>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;">
          <a href="external_adminusers.php">Manage Users </a></h3>{/if}
           </div>
            </td>
            <td>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;">
          <a href="external_add_adminusers_pe.php"> Create User</a></h3>{/if}
        </div>
             <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;">
          <a href="external_adminusers_pe.php"> Manage Users</a></h3>{/if}
        </div>
            </td>
          </tr>
          <tr>
            <th colspan='2'>JSON Access</th> 
          </tr>
          <tr>
            <td colspan='2'>
              <div>
                {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;"><a href="fullapi/user-fullapi-create.php">Create User</a></h3>{/if}
                {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;"><a href="fullapi/users-fullapilist.php">Manage Users</a></h3>{/if}
                {if $Usr_Type eq 1 or $Usr_Type eq 3} <h3 style="font-size:13px;"><a href="fullapi/fullapi-tracker.php">Tracking Dashboard</a></h3>{/if}
              </div>
            </td>
            </tr>
        </tbody>
      </table>
     </div>

     {/if}



     
      {* <div style="margin-top:20px;"> 
         {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Mobile API - CFS</h2>{/if}
        <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/mobile_api_tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 hidden style="font-size:13px;"><a href="mobile/mobile_api_tracker_vi.php"></a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/mobile_api_details.php">Details</a></h3>{/if}
        </div>
      </div>

      <div style="margin-top:20px;"> 
         {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Mobile API - PE</h2>{/if}
        <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/PE/mobile_api_tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 hidden style="font-size:13px;"><a href="mobile/PE/mobile_api_tracker_vi.php"></a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="mobile/PE/mobile_api_details.php">Details</a></h3>{/if}
        </div>
      </div> *}


      {* <div style="margin-top:20px;"> 
         {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Partner API - CFS</h2>{/if}
        <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partner-api-create.php">Create Partner</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partners-list.php">Manage Partners</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partner-api-tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="partner/partner-api-details.php">Details</a></h3>{/if}
        </div>
      </div>
      <div style="margin-top:20px;"> 
         {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Partner API - PE</h2>{/if}
        <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partner-api-create.php">Create Partner</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partners-list.php">Manage Partners</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partner-api-tracker.php">Tracking Dashboard</a></h3>{/if}
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="PE/partner-api-details.php">Details</a></h3>{/if}
        </div>
      </div> *}
      <!-- <div style="margin-top:20px;"> 
         {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h2 style="font-size:18px;">Currency Configuration</h2>{/if}
        <div>
          {if $Usr_Type eq 1 or $Usr_Type eq 3 } <h3 style="font-size:13px;"><a href="update_currency.php">Update Currency</a></h3>{/if}
         </div>
     </div> --> 
    </div>
	<div style="clear:both;">&nbsp;</div>
    <div style="clear:both"></div>
</div>
</body>
</html>