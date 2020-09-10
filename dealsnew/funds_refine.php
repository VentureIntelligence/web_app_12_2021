<script>
    $(document).ready(function(){
        
         if($('.status2').is(":checked")) { 
                $('#sec-closed').show();
            }
            else
            {
                $('#sec-closed').hide();
            }
        $('#status2').on('ifChecked', function(event){
            
            if($(this).is(":checked"))
            {
                $('#sec-closed').show();
            }
            else
            {
                $('#sec-closed').hide();
            }

        });
        $('#status2').on('ifUnchecked', function(event){
            if($(this).is(":checked"))
            {
                
                $('#sec-closed').show();
            }
            else
            {
                $('#sec-closed').hide();
            }

        });

    });
</script> 
<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
<div class="acc_container" >
    <div class="block">
        <ul>
            
            <li class="odd"><h4>Type</h4>
                <div class="selectgroup">
                    <select name="type[]" multiple="multiple" size="5" id='type'>
                        <?php

                            if ($typers = mysql_query($sqltype)){
                                    $type_cnt = mysql_num_rows($typers);
                            }
                            if($type_cnt > 0){
                                $i=1;
                                    While($myrow=mysql_fetch_array($typers, MYSQL_BOTH)){
                                            $id = $myrow[0];
                                            $name = $myrow[2];
                                            $isselect='';
                                            if($_REQUEST['type']!='')
                                            {
                                                for($i=0;$i<count($_REQUEST['type']);$i++){
                                                $isselect = ($_REQUEST['type'][$i]==$id) ? "SELECTED" : $isselect;
                                                }
                                                echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                                            }
                                            else
                                            {
                                                 //$isselected = ($getstage==$name) ? 'SELECTED' : '';
                                                echo "<OPTION id=".$id. " value=".$id." >".$name."</OPTION> \n";
                                            }
                                    }
                                     mysql_free_result($stagers);
                            }

                         ?>
                    </select> 
                </div>
                <div class="selectgroup">
                    <select name="type2[]" multiple="multiple" size="5" id='type2'>
                    <?php

                           if ($type2rs = mysql_query($sqltype2)){
                                    $type2_cnt = mysql_num_rows($type2rs);
                            }
                            if($type2rs > 0){
                                $i=1;
                                    While($myrow=mysql_fetch_array($type2rs, MYSQL_BOTH)){
                                        $id = $myrow[0];
                                        $name = $myrow[2];
                                        $isselect='';
                                        if($_REQUEST['type2']!='')
                                        {
                                            for($i=0;$i<count($_REQUEST['type2']);$i++){
                                                $isselect = ($_REQUEST['type2'][$i]==$id) ? "SELECTED" : $isselect;
                                            }
                                            echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                                        }
                                        else
                                        {
                                             //$isselected = ($getstage==$name) ? 'SELECTED' : '';
                                            echo "<OPTION id=".$id. " value=".$id." >".$name."</OPTION> \n";
                                        }
                                    }
                                     mysql_free_result($type2rs);
                            }

                     ?>
                    </select> 
                </div>
                <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
            </li>
            <li class="odd range-to"><h4>Size (US $ M)</h4>

                <SELECT name="sizestart"><OPTION id=4 value="" selected>ALL  </option>
                        <?php
                            $counter=0;

                            for ( $counter = 0; $counter <= 1000; $counter += 5){

                                if($_POST['sizestart']!='')
                                {
                                    $isselcted = (($_REQUEST['sizestart']==$counter."")) ? 'SELECTED' : "";             
                                    echo "<OPTION id=".$counter. " value=".$counter." ".$isselcted.">".$counter."</OPTION> \n";
                                }
                                else
                                {
                                    $exprg = explode("-", $getrg);
                                    $strg = $exprg[0];
                                    $isselcted = (($strg==$counter."")) ? 'SELECTED' : "";             
                                    echo "<OPTION id=".$counter. " value=".$counter." ".$isselcted.">".$counter."</OPTION> \n";
                                }
                            }

                        ?> 
                </select>
                <span class="range-text"> to</span>
                <SELECT name="sizeend" onchange="this.form.submit();"><OPTION id=5 value="" selected>ALL  </option>
                        <?php
                            $counter=0;

                            for ( $counterto = 5; $counterto <= 2000; $counterto += 5){

                                if($_POST['sizeend']!='')
                                {
                                    $isselcted = (($_REQUEST['sizeend']==$counterto."")) ? 'SELECTED' : "";             
                                    echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted." >".$counterto."</OPTION> \n";
                                }
                                else
                                {
                                    $exprg = explode("-", $getrg);
                                    $erg = $exprg[1];
                                    $isselcted = (($strg==$counterto."")) ? 'SELECTED' : "";             
                                   // echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted.">".$counterto."</OPTION> \n";
                                    echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted." >".$counterto."</OPTION> \n";
                                }
                            }
                        ?> 
                </select>
            </li>

           <!-- <li class="odd"><h4>Status</h4>
                <?php/*
                if ($statusrs = mysql_query($sqlfundstatus)){
                        $status_cnt = mysql_num_rows($statusrs);
                }
                if($status_cnt > 0){
                    $i=1;
                        While($myrow=mysql_fetch_array($statusrs, MYSQL_BOTH)){
                            $id = $myrow[0];
                            $name = $myrow[1];
                            $isselect='';
                            if($_REQUEST['status']!='')
                            {
                                
                                for($i=0;$i<count($_REQUEST['status']);$i++){
                                    $isselect = ($_REQUEST['status'][$i]==$id) ? "checked" : $isselect;
                                }
                                echo '<label> <input type="checkbox" name="status[]" class="status'.$id.'"  id="status'.$id.'" value="'.$id.'" '.$isselect.'/> '.$name.'</label>';
                               
                            }
                            else
                            {
                                echo '<label> <input type="checkbox" name="status[]" class="status'.$id.'"  id="status'.$id.'" value="'.$id.'" '.$isselect.'/> '.$name.'</label>';
                            }
                        }
                } */?>
                
                <div id="sec-closed" style="margin-left:33%;">
                    <?php
                       /* if ($closedstatusrs = mysql_query($sqlfundClosed)){
                                $closedst_cnt = mysql_num_rows($closedstatusrs);
                        }
                        if($closedst_cnt > 0){
                            $i=1;
                                While($myrow=mysql_fetch_array($closedstatusrs, MYSQL_BOTH)){
                                    $id = $myrow[0];
                                    $name = $myrow[1];
                                    $isselect='';
                                    if($_REQUEST['cstatus']!='')
                                    {
                                        for($i=0;$i<count($_REQUEST['cstatus']);$i++){
                                            
                                            $isselect = ($_REQUEST['cstatus'][$i]==$id) ? "checked" : $isselect;
                                        }
                                        echo '<label> <input type="checkbox" name="cstatus[]" class="cstatus'.$id.'"  id="cstatus'.$id.'" value="'.$id.'" '.$isselect.'/> '.$name.'</label><br>';

                                    }
                                    else
                                    {
                                        echo '<label> <input type="checkbox" name="cstatus[]" class="cstatus'.$id.'"  id="cstatus'.$id.'" value="'.$id.'"  checked/> '.$name.'</label><br>';
                                    }
                                }
                        } */ ?>
                </div>
            </li>-->
            <li class="odd"><h4>Capital Source</h4>
                <div class="selectgroup">

                <select name="capital[]" multiple="multiple" size="5" id='capital'>
                <?php

                        if ($capitalrs = mysql_query($sqlcapitalsrc)){
                                $capital_cnt = mysql_num_rows($capitalrs);
                        }
                        if($capital_cnt > 0){
                            $i=1;
                                While($myrow=mysql_fetch_array($capitalrs, MYSQL_BOTH)){
                                    $id = $myrow[0];
                                    $name = $myrow[1];
                                    $isselect='';
                                    if($_REQUEST['capital']!='')
                                    {
                                        for($i=0;$i<count($_REQUEST['capital']);$i++){
                                                $isselect = ($_REQUEST['capital'][$i]==$id) ? "SELECTED" : $isselect;
                                        }
                                        echo '<OPTION  id=c'.$id. '  value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                                    }
                                    else
                                    {
                                        echo "<OPTION id=c".$id. " value=".$id.">".$name."</OPTION> \n";
                                    }
                                }
                                 mysql_free_result($stagers);
                        }

                 ?>
                </select> 
                </div>
                <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
            </li>
        </ul>
    </div>
</div>
<script>
  
    </script>