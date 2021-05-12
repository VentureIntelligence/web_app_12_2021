<?php
    if( $_SESSION[ 'is_admin' ] == 0 ) {
        $fullPrevilege = false;
        $modulesArray = explode( ',', $_SESSION[ 'modules_permission' ] );
    } else {
        $fullPrevilege = true;
        $modulesArray = array();
    }
?>
<style>
#vertbgproproducts{
   
    height: 925px;
} 

</style>
<div id="leftpanel">

    <div><a href="admin.php"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>

    <div id="vertbgproproducts">
        <?php
        if( $fullPrevilege || in_array( 'import', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
        </div>
        <div id="linksnone">
            <a href="dealsinput.php">Investment Deals</a> | <a href="companyinput.php">Profiles</a> |
            <a href="importtime_cfs.php"> CFs </a>
        </div>
        <?php }
        if( $fullPrevilege || in_array( 'export', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Export</span></div>
        </div>
        <div id="linksnone">
            <a href="exportPECompaniesProfile.php">PECompanies </a> | <a href="exportREcompaniesprofile.php">RECompanies </a>
        </div>
        <?php }
        if( $fullPrevilege || in_array( 'currency_conversion', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" /><a href="usdtoinrconversion.php">&nbsp;$ to ₹ Conversion Rate</a></div>
        </div>
        <?php }
        if( $fullPrevilege || in_array( 'edit', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
        </div>
        <div id="linksnone">
            <a href="pegetdatainput.php">Deals / Profile</a><br />
            <a href="peadd.php">Add PE Inv </a> |  <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA </a> |
            <a href="peadd_RE.php"> RE Inv</a> | <a href="reipoadd.php"> RE-IPO</a> | <a href="remandaadd.php"> RE-M&A</a><br /> | <a href="remamaadd.php">RE-MA </a> |
            <a href="incadd.php">Inc Add </a> | <a href="angeladd.php">Angel Inv</a> |
            <a href="ui_insert_comp_cfs.php"> CFs </a> |
            <a href="tag_list.php"> Tags </a>
        </div>
        <?php }
        if( $fullPrevilege || in_array( 'subscribers', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
        </div>
        <div id="linksnone">
            <a href="admin.php">Subscriber List</a><br />
            <a href="addcompany.php">Add Subscriber / Members</a><br />
            <a href="delcompanylist.php">List of Deleted Companies</a><br />
            <a href="delmemberlist.php">List of Deleted Emails</a><br />
            <a href="deallog.php">Log</a><br />
        </div>
        <?php }
        if( $fullPrevilege || in_array( 'fund_raising', $modulesArray ) ) { ?>       
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Fund Raising</span></div>
        </div>
        <div id="linksnone">
            <a href="fundlist.php">View Funds</a><br />
            <a href="addfund.php">Add Fund</a><br />
        </div>
        <?php }
        if( $fullPrevilege || in_array( 'admin_report', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Admin Report</span></div>
        </div>
        <div id="linksnone">
            <a href="viewlist.php">View Report</a><br />
            <a href="addlist.php">Add Report</a><br />
        </div>
        <?php }
       if( $fullPrevilege || in_array( 'upload_deals', $modulesArray ) || in_array( 'upload_league', $modulesArray ) || in_array( 'upload_weeklyNL', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Upload</span></div>
        </div>
        <div id="linksnone">
            <?php if( $fullPrevilege || in_array( 'upload_deals', $modulesArray ) ) { ?>
            <a href="uploaddeals.php">Deals</a><br />
            <?php }if( $fullPrevilege || in_array( 'upload_league', $modulesArray ) ) { ?>
            <a href="uploadleague.php">League Table</a><br />
            <?php }if( $fullPrevilege || in_array( 'upload_weeklyNL', $modulesArray ) ) { ?>
            <a href="uploadweeklyNL.php">Weekly NL</a><br />
            <?php }if( $fullPrevilege || in_array( 'upload_unicornTrack', $modulesArray ) ) { ?>
            <a href="uploadunicorn.php">Unicorn</a><br />
            <?php }?>
        </div>
        <?php }
/*        if( $fullPrevilege || in_array( 'upload_league', $modulesArray ) ) { ?>
            <div id="vertMenu">
                <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;League Table</span></div>
            </div>
            <div id="linksnone">
                <a href="uploadleague.php">Upload</a><br />
            </div>
        <?php }*/
        if( $fullPrevilege || in_array( 'reports', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Reports</span></div>
        </div>
        <div id="linksnone">
            <a href="userlog.php">User Reports</a><br />
        </div>
        <?php }
        if( $fullPrevilege || in_array( 'faq', $modulesArray ) ) { ?>
            <div id="vertMenu">
                <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;FAQ</span></div>
            </div>
            <div id="linksnone">
                <a href="addfaq.php">Add</a> | <a href="viewfaqlist.php">Edit</a>
            </div>
        <?php }
         if( $fullPrevilege || in_array( 'LPDir', $modulesArray ) ) { ?>
            <div id="vertMenu">
                <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;LP Directory</span></div>
            </div>
            <div id="linksnone">
                <a href="lpadd.php">Add</a> | <a href="lpgetdata.php">Edit</a>
            </div>
        <?php } 
        if( $fullPrevilege || in_array( 'user_management', $modulesArray ) ) { ?>
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;User management</span></div>
        </div>
        <div id="linksnone">
            <a href="users.php">User(s) List</a><br />
        </div>
        <?php } ?>
        <!-- <div id="vertMenu"> -->
            <!-- <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;VI Filter</span></div>
        </div>
        <div id="linksnone"><a href="../adminvi/adminFilter.php">AddFilter</a><br /></div>
        <div id="linksnone"><a href="../adminvi/EditAdminFilter.php">EditFilter</a><br /></div>
         -->
        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;M&A</span></div>
        </div>
        <div id="linksnone"><a href="../adminvi/uploadCinno.php">Upload CIN Number</a><br /></div>


        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;VI Filter</span></div>
        </div>
        <div id="linksnone"><a href="../adminvi/adminFilter.php">Add Filter</a><br /></div>
        <div id="linksnone"><a href="../adminvi/EditAdminFilter.php">Edit Filter</a><br /></div>
         
        <!-- <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;vifilter log</span></div>
        </div> -->
        <div id="linksnone"><a href="../adminvi/advFilterlogtable.php">Log Table</a><br /></div>


        <div id="vertMenu">
            <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
        </div>
        <div id="linksnone"><a href="../adminlogoff.php">Logout</a><br /></div>
       
    </div> <!-- end of vertbgproducts div-->
</div>
