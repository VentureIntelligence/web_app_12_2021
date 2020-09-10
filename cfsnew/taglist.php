    <ul class="def-list">
        <p class="sub-tag">Industry Tags</p>
        <li class="listitem_ascolun">
             <ul>
            <?php 
                    $tagsql = "SELECT substring_index(tag_name, ':', -1) as tag FROM `tags` WHERE tag_type='Industry Tags'  ORDER BY tag";

                    if ($rstag = mysql_query($tagsql))
                    {
                        While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                            $tag_name=trim($myrow['tag']); ?>
                            
                                <li><?php echo $tag_name?></li>
                            
              <?php }
                       
                    }
            ?>
            </ul>
        </li>
    </ul>
    <ul class="def-list">
        <p class="sub-tag">Sector Tags</p>
        <li class="listitem_ascolun">
            <ul>
            <?php 
                        $tagsql = "SELECT substring_index(tag_name, ':', -1) as tag FROM `tags` WHERE tag_type='Sector Tags' ORDER BY tag";

                        if ($rstag = mysql_query($tagsql))
                        {
                            While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                                $tag_name=trim($myrow['tag']); ?>
                                 <li><?php echo $tag_name?></li>
                <?php }
                        
                        }
                ?>
            </ul>
        </li>
    </ul>
    <ul class="def-list">
        <p class="sub-tag">Competitor Tags</p>
        <li class="listitem_ascolun">
            <ul>
            <?php 
                        $tagsql = "SELECT substring_index(tag_name, ':', -1) as tag FROM `tags` WHERE tag_type='Competitor Tags'  ORDER BY tag";

                        if ($rstag = mysql_query($tagsql))
                        {
                            While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                                $tag_name=trim($myrow['tag']); ?>
                                 <li><?php echo $tag_name?></li>
                <?php }
                        
                        }
                ?>
            </ul>
        </li>
    </ul>