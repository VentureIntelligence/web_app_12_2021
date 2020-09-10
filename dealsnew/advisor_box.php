<?php
          if($comp_cnt>0 || $compinv_cnt>0) {
    ?>
<style>
    .advisor_innerTable tr td{
        width: 100% !important;
    }
    .advisor_innerTable{
        border-collapse: collapse;
        border-left: 1px solid #ccc !important;
        border-right: none !important;
        border-top: none !important;
        border-bottom: none !important;
    }
    #advisor_info .tablelistview4 td:last-child{
        padding: 0px;
    }
    .advisor_innerTable tr:last-child{
        border-bottom: none;
    }
    .advisor_innerTable td{
        padding: 5px 5px 5px 5px !important;
    }
    .advisor_innerTable td p{
        padding: 4px 0px 2px 0px !important;
    }
    </style>
                        <div  class="work-masonry-thumb1 col-p-8" id="advisor_info" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                <h2 class="box_heading content-box ">Advisor Info</h2>
                <table cellspacing="0" cellpadding="0" class="tablelistview4">
                    <tbody>
        <?php 
            if($comp_cnt>0)
            { ?>
            <tr>
                <td>
                    <h4>To Company</h4></td>
                <td>
                    <table class="advisor_innerTable">
                    <?php While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                            { ?>
                        <tr><td class="">
                            
                            <p>
                                <a class="postlink" href='advisor.php?value=<?php echo $myadcomprow["CIAId"];?>/1/<?php echo $flagvalue?>' >
                                <?php echo $myadcomprow["cianame"]; ?></a> (<?php echo $myadcomprow["AdvisorType"];?>)
                            </p>
                            </td></tr>
                        <?php } ?>
                        </table>
                        </td>
            </tr>
         <?php } ?>
        <?php  if($compinv_cnt>0){ ?>
            <tr>
                <td><h4>To Investor</h4></td>
                <td>
                    <table class="advisor_innerTable">
        <?php
                if ($getinvestorrs = mysql_query($advinvestorssql))
                { ?>
                <?php While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                    {
        ?>
                
                <tr>
                <td class="">
                    <p>
                <A class="postlink" href='advisor.php?value=<?php echo  $myadinvrow["CIAId"];?>/1/<?php echo $flagvalue?>' >
        <?php 
                //advisor.php?value=<?php echo $myadinvrow["CIAId"];   /1/<?php echo $flagvalue 
        echo $myadinvrow["cianame"]; ?> </a> (<?php echo $myadinvrow["AdvisorType"];?>)</p></td>
            </tr>
                <?php } ?>
                        </table>
                        </td>
            </tr> <?php }
        }
        ?>
                    </tbody>
                </table>
            </div>   <?php }else{ ?>
                        <div  class="work-masonry-thumb1 <?php if($financial_label == "financial_label"){ echo "col-p-8_1"; } else { echo "col-p-8_2"; } ?> " id="advisor_info" href="http://erikjohanssonphoto.com/work/aishti-ss13/" style="visibility: hidden;"></div>
        <?php    }
    ?>