<?php
require("dbconnectvi.php");
$Db = new dbInvestments();
?>
<!DOCTYPE HTML>
<html>
  <head>
	  
	<script src="../vi_webapp/js/jquery.min.js"></script>
	<script src="../vi_webapp/js/jquery-ui.js"></script>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0, user-scalable=yes">
    <title>Venture Intelligence</title>
  </head>
  <body style="margin:0px; padding:0px;  font-family:Arial, Helvetica, sans-serif;">
    <div style="margin:0 auto; padding:0; max-width:698px;">
    <div style="width: 100%; float: left;">
        <div style="width:99.5%; margin:0px; padding:0px; float:left; border:1px solid #EAEAEA; ">
          <a name="top" id="top"></a>
          <div style="width:100%; float:left; background-color:#1B1B1B;">
            <div style="margin:0; padding:0; float:left; width:100%;">
              <img src="https://www.ventureintelligence.com/images/nl/vi-hdr-n.gif" alt="Venture Intelligence" border="0" usemap="#Map" style="display:block; max-width: 100%;" title="Venture Intelligence">
              <map name="Map">
                <area shape="rect" coords="15,18,668,90" href="https://www.ventureintelligence.com/" target="_blank">
              </map>
            </div>
          </div>
          <div style="width:90%; float:left; padding:1% 5%; font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#ffffff; text-align:center; background-color:#836422;">
			April 21, 2021</div>
          <div style="width:100%; float:left; background-color:#ffffff;">
            <div style="width:100%;">
              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="22" align="center" valign="top" style="color:#1b1b1b; font-size:15px; padding:1% 0 1%; font-weight:bold; text-align:center; font-family:Arial, Helvetica, sans-serif;">
					Platinum Sponsor<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<a href="http://technology-holdings.com/"> <img src="https://www.ventureintelligence.com/images/th.png" alt="" border="0" style="max-width: 100%; display:b" <br></a><font color="#F8F8F8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Presents</font></td>
                </tr>
                </table>
              </div>
            <div style="width:94%; float: left; padding: 0; margin: 0 3%; background-color: #ffffff; border-top:1px solid #CDCDCD;">

			<div style="width:100%; float:left; color:#1b1b1b;  padding:2% 0 4.1% 0; font-size:13px; line-height:18px; font-family:Arial, Helvetica, sans-serif; ">

            
                <?php
                
                    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                    $uri_segments = explode('/', $uri_path);
                    $newsblockslug = $uri_segments[3];
                    $newsblockid = substr($newsblockslug, -1);


                    $sel = "SELECT * FROM newsletter LEFT JOIN sources ON newsletter.id = sources.news_id WHERE newsletter.id = '".$newsblockid."'";

                    $res = mysql_query( $sel ) or die( mysql_error() );
                    $numrows = mysql_num_rows( $res );

                    if( $numrows > 0 ) {

                        while( $result = mysql_fetch_array( $res ) ) {

                            ?>
                            <div style="width:100%; float:left; color:#C39B44; font-size:24px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding:4% 4% 4% 0;">
                            <?php 
                                $category=$result[ 'category' ];
                                if($category == "PEFI")
                                {
                                    $categoryval="Private Equity Fund Investments";
                                }
                                else if($category == "LE")
                                {
                                    $categoryval="Liquidity Events";
                                }
                                else if($category == "SVCI")
                                {
                                    $categoryval="Social VC Investments";
                                }
                                else if($category == "I/A")
                                {
                                    $categoryval="Incubation/Acceleration";
                                }
                                else if($category == "AI")
                                {
                                    $categoryval="Angel Investments";
                                }
                                else if($category == "OPE/SI")
                                {
                                    $categoryval="Other Private Equity/Strategic Investments";
                                }
                                else if($category == "SI")
                                {
                                    $categoryval="Secondary Issues";
                                }
                                else if($category == "OD")
                                {
                                    $categoryval="Other Deals";
                                }
                                else if($category == "OD-LF")
                                {
                                    $categoryval="Other Deals - Listed Firms";
                                }
                                else if($category == "DF")
                                {
                                    $categoryval="Debt Financing";
                                }
                                else if($category == "RET")
                                {
                                    $categoryval="Real Estate Transactions";
                                }
                                else if($category == "FN")
                                {
                                    $categoryval="Fund News" ;
                                }
                
                                echo $categoryval;
                            
                            ?></div>
                
                            <p align="justify">
                            <font size="4" face="Calibri"><b><?php echo $result['heading']; ?></b></font><font face="Calibri" style="font-size: 11pt"><br>
                            <br />
                            <a href="<?php echo $result['url']; ?>">
                            <font color="#C48600"><?php echo $result['name']; ?></font></a><font color="#C48600"><br>
                            </font><br>
                            <font>
                            <?php 
                
                            echo $result['summary'];
                           
                
                            ?> </font> 
                            </p>
                            
                            <?php
                        }
                    }
                    

                ?>




					


                <br />
				<p>About this Newsletter </p>
				<p style="margin:0px; padding:0px; float:right;"><a href="#top">
				<img src="https://www.ventureintelligence.com/images/nl/top-arw.png" alt="Top" border="0" style="max-width:100%;" title="Top"></a></p>
				</span>
				<p align="justify">
				<span style="font-size:15px; font-family:Arial, Helvetica, sans-serif; width:100%; color:#1b1b1b; float:left;  padding:0 0 10px 0; ">
				<strong>Deal Digest Daily</strong></span> <br>
				<span style=" color:#1b1b1b;  padding:0 0 15px 0; width:100%; float:left; font-size:13px; line-height:18px;; font-family:Arial, Helvetica, sans-serif; ">Delivered by email on all working weekdays, the Deal Digest 
					Daily newsletter summarizes Private Equity / Venture Capital 
					Investment &amp; Exits, IPO, M&amp;A activity in India. Our coverage 
					includes not just completed deals, but &quot;Deals in the Making&quot; 
					as well: i.e., companies planning to raise PE/VC funding or 
					on the IPO path, looking for acquisition etc. The Deal 
					Digest also includes news on new funds being raised, 
					executive movements and much more – making it must update for executives in the Indian deal ecosystem. 
					</span>
				<span style="color:#1b1b1b;  padding:0px; float:left; font-size:13px; line-height:22px; font-family:Arial, Helvetica, sans-serif; width:100%; ">It 
					is a companion to the weekly Deal Digest that is published 
					each Friday.<br>
				<a href="https://www.ventureintelligence.com/newsletters.htm" target="_blank" style="color:#c48600; text-decoration:none;">Click Here</a> to request 
					a trial.</span></div>
				<div style="width:100%; float:left; padding:3% 0 3% 0; border-bottom:1px solid #CDCDCD;">
					<p align="justify">
					<span style=" color:#333; font-family:Arial, Helvetica, sans-serif; font-size:18px; padding:0 0 15px 0; float:left;">Recommend the Digest</span>
					<span style=" width:100%; color:#1b1b1b; float:left; font-size:13px; line-height:22px; font-family:Arial, Helvetica, sans-serif; padding:0 0 10px 0; ">Please note that the Deal Digest is a PAID FOR newsletter.</span>
					<br>
					<span style="color:#1b1b1b; padding:0 0 15px 0; width:100%; float:left; font-size:13px; line-height:22px; font-family:Arial, Helvetica, sans-serif;">We encourage forwarding of this newsletter to your industry colleagues on a once-per-user basis, provided you also copy 
					<a style="color:#c48600; text-decoration:none;" href="mailto:subscription@ventureintelligence.com">subscription@ventureintelligence.com</a></span>
					<span style="color:#1b1b1b; padding:0 0 0px 0; width:100%; float:left; font-size:13px; line-height:22px; font-family:Arial, Helvetica, sans-serif;">In return, we will be glad to provide your referrals with free trial issues. Any other unauthorized redistribution is a violation of copyright law.</span>
				</div>
				<div style="width:100%; float:left; padding:3% 0 3% 0; border-bottom:1px solid #CDCDCD;">
					<span style="color:#333; font-family:Arial, Helvetica, sans-serif; font-size:18px; padding:0 0 15px 0; float:left;">Other Venture Intelligence Products</span>
					<span style="color:#1b1b1b; padding:0; width:100%; font-size:13px; line-height:20px; font-family:Arial, Helvetica, sans-serif; float:left;">
					<span style="color:#1b1b1b; font-size:13px; line-height:20px; font-family:Arial, Helvetica, sans-serif; float:left">Databases PE Deal Database, Pvt Cos Financials Database, M&A Deal Database, PE RE Deal Database PE Reports, VC Reports, Directories, LP Directory.
					<a href="https://www.ventureintelligence.com/products.htm" target="_blank">
					<font color="#c48600">Click Here</font></a> for details</span></span>
				</div>
    
              </div>
            </div>
            <div style="width:100%; float:left; background-color:#474747;">
              <div style="width:94%; float:left; padding:0 3%;">
                <div style="float:left; width:67%; color:#BEBEBE; font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;  padding:4% 0;">Copyright © TSJ Media Private Limited. All rights reserved.</div>
                <div style="float:right; width:33%; padding:2% 0;">
                  <a style="float:right; margin: 3% 0; " href="https://plus.google.com/104062335450225242195/posts" target="_blank"><img src="https://www.ventureintelligence.com/images/nl/ven-fo-gplus.jpg"  alt="Google plus" border="0" style="display: inline-block; max-width:100%;" title="Google plus"></a>
                  <a style=" float:right; margin: 3% 0; " href="https://in.linkedin.com/in/ventureintelligence" target="_blank"><img src="https://www.ventureintelligence.com/images/nl/ven-fo-in.jpg" alt="LinkedIn" border="0" style="display: inline-block; max-width:100%;"  title="LinkedIn"></a>
                  <a style="float:right; margin: 3% 0; " href="https://twitter.com/ventureindia" target="_blank"><img src="https://www.ventureintelligence.com/images/nl/ven-fo-twitt.jpg" alt="Twitter" border="0" style="display: inline-block; max-width:100%;"  title="Twitter"></a>
                  <a style="float:right; margin: 3% 0;" href="https://www.facebook.com/ventureintelligence" target="_blank"><img src="https://www.ventureintelligence.com/images/nl/ven-fo-face.jpg"  alt="Facebook" border="0" style="display: inline-block; max-width:100%;" title="Facebook"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </body>
</html>

