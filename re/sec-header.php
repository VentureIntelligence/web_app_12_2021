<?php
$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0';
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>
<!-- <?php //if($value="1"){}else{?> -->
<table cellpadding="0" cellspacing="0">
<tr>
<?php if($topNav =='Funds' || $topNav =='Fund-details' ){ }else{?>
<td class="vertical-form">
    
<!-- <?php if($_GET['value']==0 || $curPageName == "redealdetails.php" || $curPageName == "reindex.php"){ ?>
<h3 id="investmenttype">PE Investments - Real Estate</h3>
<?php }elseif($_GET['value']==1 || $curPageName == "reipodealdetails.php" || $curPageName == "reipoindex.php"){ ?>
    <h3 id="investmenttype">PE backed IPO </h3>
<?php }elseif($_GET['value']==2  || $curPageName == "remandadealdetails.php" || $curPageName == "remandaindex.php"){ ?>
<h3 id="investmenttype">PE Exits via M&A </h3>
<?php }elseif($_GET['value']==3  || $curPageName == "remadealdetails.php" || $curPageName == "remaindex.php"){ ?>
<h3 id="investmenttype">Other M&A </h3>
<?php } ?> -->
<?php if( $curPageName == "redealdetails.php" || $curPageName == "reindex.php"){ ?>
<h3 id="investmenttype">PE Investments - Real Estate</h3>
<?php }elseif( $curPageName == "reipodealdetails.php" || $curPageName == "reipoindex.php"){ ?>
    <h3 id="investmenttype">PE backed IPO </h3>
<?php }elseif( $curPageName == "remandadealdetails.php" || $curPageName == "remandaindex.php"){ ?>
<h3 id="investmenttype">PE Exits via M&A </h3>
<?php }elseif( $curPageName == "remadealdetails.php" || $curPageName == "remaindex.php"){ ?>
<h3 id="investmenttype">Other M&A </h3>
<?php } ?>

</td>
<?php } ?>
<td class="investment-form">
    <?php if($topNav=='Funds' || $topNav=='Fund-details' ){ ?>
    <div style="display:inline-flex;">
     <h3>INVESTOR</h3>

        <div class="investmentlabel">
        <input type="text" id="investorauto" name="investorauto" value="<?php if(isset($_REQUEST['investorauto'])) echo  $_REQUEST['investorauto'];  ?>" placeholder="" style="width:220px;height:25px;z-index:1111;">
        <input type="hidden" id="investorsearch" name="investorsearch" value="<?php if(isset($_REQUEST['investorsearch'])) echo  $_REQUEST['investorsearch'];  ?>" placeholder="" style="width:220px;z-index:1111;"> 
        </div>
<?php }else if($value==1){ } ?>
  
</td>




<td class="vertical-form">
    <div style="float:right">
   


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
    echo "yeaer:".$year1;
   
    if($curPageName == "reipodealdetails.php" || $curPageName == "reipoindex.php"){
        $yearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from REipos order by IPODate desc";
    }else if($curPageName == "remandadealdetails.php" || $curPageName == "remandaindex.php"){
		$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from REmanda where Deleted=0 order by DealDate desc";
    }else if($curPageName == "remadealdetails.php" || $curPageName == "remaindex.php"){
		$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from REmama where Deleted=0 order by DealDate desc";
    }else{
        $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from REinvestments order by dates desc";
    }
    
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
                        
                    if($curPageName == "reipodealdetails.php" || $curPageName == "reipoindex.php" || $curPageName == "remandadealdetails.php" || $curPageName == "remandaindex.php" || $curPageName == "remadealdetails.php" || $curPageName == "remaindex.php"){
                        While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
                        {
                            $id = $myrow["Year"];
                            $name = $myrow["Year"];
                            $isselected = ($year1==$id) ? 'SELECTED' : '';
                            echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        }
                    }else{
                        $currentyear = date("Y");
                        $i=$currentyear;
                        While($i>= 1998 )
                        {
                        $id = $i;
                        $name = $i;
                        $isselected = ($year1==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i--;
                        }
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
    if($value ==1){
    	$endyearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from REipos order by IPODate desc";
                    if($_POST['year2']=='')
                {
                    $year2=$lastEndYear;
                }
            if($endyearSql=mysql_query($endyearsql))
            {
            While($myrow=mysql_fetch_array($endyearSql, MYSQL_BOTH))
            {
                $endid = $myrow["Year"];
                $endname = $myrow["Year"];
                $isselcted = ($year2== $endid) ? 'SELECTED' : '';
                echo "<OPTION id=". $endid. " value='". $endid."' ".$isselcted.">".$endname."</OPTION>\n";
            }		
       }
    }else if($value == 2 || $value == 3){
        $yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from REmanda where Deleted=0 order by DealDate desc";
                if(isset($_POST['year2']) && $_POST['year2']!='')
                {
                    $year2 = $_POST['year2'];
                }else{
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
                }
                
    }else{
		        $currentyear = date("Y");
                $i=$currentyear;
                While($i>= 1998 )
                {
                $id = $i;
                $name = $i;
                $isselected = ($year2==$id) ? 'SELECTED' : '';
                echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                $i--;
                }
            }
	?> 
</SELECT>
</div>

  <div class="search-btn"   id="datesubmit"> <input name="searchpe" type="submit" value="Search" class="datesubmit"/></div>
  </div>

</td>
</tr>
</table>
