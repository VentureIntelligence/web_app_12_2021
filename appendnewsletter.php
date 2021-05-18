<?php

require("dbconnectvi.php");
$Db = new dbInvestments();

    $sel = "SELECT * FROM newsletter LEFT JOIN sources ON newsletter.id = sources.news_id WHERE newsletter.is_newsletter_sent = 1 ";

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
            <br>
            <a href="<?php echo $result['url']; ?>">
            <font color="#C48600"><?php echo $result['name']; ?></font></a><font color="#C48600"><br>
            </font><br>
            <font>
            <?php 
            $string = strip_tags($result['summary']);
            
            $randomnumber = rand();
            $number =  str_pad($result['id'], 5, ''.$randomnumber.'', STR_PAD_LEFT);

            if (strlen($string) > 150) {

                // truncate string
                $stringCut = substr($string, 0, 150);
                $endPoint = strrpos($stringCut, ' ');

                //if the string doesn't contain any space then it will cut without word basis.
                $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                $string .= '... <a href="../vi_webapp/newsletterblog.php/'.$result['slug'].'_'.$number.'">Read More</a>';

                
            }
            echo $string;

            ?> </font> 
            </p>
            
            <?php

        }
   
    }


?>