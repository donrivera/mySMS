<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
//date calculation start here
function week_number($date){
	return date("W", strtotime("$date + 1 day"));
}

function datefromweeknr($aYear, $aWeek, $aDay){
	$Days=array('xx','ma','di','wo','do','vr','za','zo');
	$DayOfWeek=array_search($aDay,$Days); //get day of week (1=Monday)
	$DayOfWeekRef = date("w", mktime (0,0,0,1,4,$aYear)); //get day of week of January 4 (always week 1)
	if ($DayOfWeekRef==0)
		$DayOfWeekRef=7;
		$ResultDate=mktime(0,0,0,1,4,$aYear)+((($aWeek-1)*7+($DayOfWeek-$DayOfWeekRef))*86400);

		return $ResultDate;
};

function week_start_date($wk_num, $yr, $first = 1, $format = 'F d, Y'){
    $wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
    $mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
    return date($format, $mon_ts);
}

//------------------------------------------
//accepting dynamic date value
//------------------------------------------

$teacher_id = $_REQUEST[teacher_id];
if($_REQUEST[date_value]==""){
	unset($dd);
	unset($chdate);
}else{
	$dd=strtotime($_REQUEST[date_value]);
	$chdate=date("Y-m-d",$dd);
}
if(isset($chdate)){
	$date=$chdate;
}else{
	$date=date("Y-m-d");
}

$yar=date('Y',strtotime($date));
$d=date('d',strtotime($date));
$wk_num= week_number($date); 

//echo $sStartDate = week_start_date($wk_num, $yr);
$rr=datefromweeknr($yar, $wk_num, $d);;
$sStartDate= date('Y-m-d',strtotime($_REQUEST[date_value]));

// $sStartDate = week_start_date($wk_num, $yr);
$startdate= date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
$enddate   = date('Y-m-d', strtotime('+6 days', strtotime($sStartDate))); 

//exit;
//$sund=date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
$sun=date('m/j', strtotime('+1 days', strtotime($sStartDate))); 
$mon= date('m/j', strtotime('+2 days', strtotime($sStartDate))); 
$tue= date('m/j', strtotime('+3 days', strtotime($sStartDate)));
$wed= date('m/j', strtotime('+4 days', strtotime($sStartDate))); 
$thu= date('m/j', strtotime('+5 days', strtotime($sStartDate))); 
$fri= date('m/j', strtotime('+6 days', strtotime($sStartDate)));
$sat= date('m/j', strtotime('0 days', strtotime($sStartDate))); 

$sun1=date('Y-m-d', strtotime('-0 days', strtotime($sStartDate))); 
$mon1= date('Y-m-d', strtotime('+1 days', strtotime($sStartDate))); 
$tue1= date('Y-m-d', strtotime('+2 days', strtotime($sStartDate)));
$wed1= date('Y-m-d', strtotime('+3 days', strtotime($sStartDate))); 
$thu1= date('Y-m-d', strtotime('+4 days', strtotime($sStartDate))); 
$fri1= date('Y-m-d', strtotime('+5 days', strtotime($sStartDate)));
$sat1= date('Y-m-d', strtotime('+6 days', strtotime($sStartDate)));

/*$sun1=date('Y-m-d', strtotime('-1 days', strtotime($sStartDate))); 
$mon1= date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
$tue1= date('Y-m-d', strtotime('+1 days', strtotime($sStartDate)));
$wed1= date('Y-m-d', strtotime('+2 days', strtotime($sStartDate))); 
$thu1= date('Y-m-d', strtotime('+3 days', strtotime($sStartDate))); 
$fri1= date('Y-m-d', strtotime('+4 days', strtotime($sStartDate)));
$sat1= date('Y-m-d', strtotime('+5 days', strtotime($sStartDate)));
*/
$sum_month= date('m', strtotime('+0 days', strtotime($sStartDate))); 
$mon_month= date('m', strtotime('+1 days', strtotime($sStartDate))); 
$tue_month= date('m', strtotime('+2 days', strtotime($sStartDate)));
$wed_month= date('m', strtotime('+3 days', strtotime($sStartDate))); 
$thu_month= date('m', strtotime('+4 days', strtotime($sStartDate))); 
$fri_month= date('m', strtotime('+5 days', strtotime($sStartDate)));
$sat_month= date('m', strtotime('+6 days', strtotime($sStartDate))); 

$sum_day= date('D', strtotime('+0 days', strtotime($sStartDate))); 
$mon_day= date('D', strtotime('+1 days', strtotime($sStartDate))); 
$tue_day= date('D', strtotime('+2 days', strtotime($sStartDate)));
$wed_day= date('D', strtotime('+3 days', strtotime($sStartDate))); 
$thu_day= date('D', strtotime('+4 days', strtotime($sStartDate))); 
$fri_day= date('D', strtotime('+5 days', strtotime($sStartDate)));
$sat_day= date('D', strtotime('+6 days', strtotime($sStartDate))); 

$year=date('Y',strtotime($date));
//date calculation end here
?>
<style type="text/css">
.style14 {color: #0000FF; font-weight: bold; font-size: larger; }
.style15 {font-size: larger}
.style25 {color: #0000FF; font-weight: bold; }
.style28 {font-size: 14px; font-weight: normal; color: #000000; }
.style35 {font-size: 12px; font-weight: bold; color: #000000; }
.pedtext{font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:7px;font-weight:bold;}
.teachertext{font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#999900;padding-left:2px;font-weight:bold;}
.teachertext a{font-size:12px;color:#999900;text-decoration:none;}
.teachertext1{font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#FF0000;padding-left:2px;font-weight:bold;}
.scroll-div{
overflow-x:hidden;
overflow-y:scroll;
font-size:11px;
font-weight:bold;
color:#245F9A;
float:left;
width:99%;
height:300px;
margin:5px 0px;
}
</style>
<?php
$centre_id = $_SESSION['centre_id'];
$center = $dbf->strRecordID("centre", "*", "id='$centre_id'");
$start_time = $center["class_start_time"];
$end_time = $center["class_end_time"];

$tot = $dbf->TimeDiff($start_time,$end_time);
$time = explode(":",$tot);

$minutes = intval($time[0])*60 + intval($time[1]);
$minutes = $minutes / 15;
?>
<table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">
  <tr>
    <td width="85" height="30" align="center" valign="middle" bordercolor="#FF9933" bgcolor="#FFF8E6" class="pedtext"><?php echo constant("CD_GROUP_TEACHER_TIME");?></td>
    <td bordercolor="#FF9933" bgcolor="#EBEBEB"><table width="690" border="0" cellspacing="0" cellpadding="0">
                                  <tr class="pedtext">
                                    <td width="86" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $sum_day.'<br>'.$sat?></td>
                                    <td width="96" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $mon_day.'<br>'.$sun?></td>
                                    <td width="96" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $tue_day.'<br>'.$mon?></td>
                                    <td width="89" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $wed_day.'<br>'.$tue?></td>
                                    <td width="95" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $thu_day.'<br>'.$wed?></td>
                                    <td width="90" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $fri_day.'<br>'.$thu?></td>
                                    <td align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $sat_day.'<br>'.$fri?></td>
                                    <td align="center" valign="middle">&nbsp;</td>
                                  </tr>
                                </table></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" valign="middle">
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="middle">
          
          
          <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">

          <tr>
            <td height="25" colspan="2" align="center" valign="middle">
              
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" valign="middle">
                  
                  <div class="scroll-div">
          
                  <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">
                  <?php
                  $line = 1;
                  for($k = 1; $k <= $minutes; $k++){
                  if($k == 1){
                      $centre_time = date('h:i A', strtotime($start_time));
                  }
				  							  
                  $starttime = date('H:i:s',strtotime(date("H:i:s", strtotime($centre_time)) . " +1 minutes"));									  
                  ?>
                    <tr>
                      <td width="70" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo $centre_time;?></td>
                      <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0" >
                          <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                            <td width="3" align="left" valign="middle"></td>
                            <?php
							$num = $dbf->timeSlotAvailable($teacher_id, $sun1, $centre_time);                                     
							//$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$sun1' BETWEEN start_date And end_date)");
							if($num == false){
								$class = 'teachertext';
								$text = 'Available';
								$img = "../images/tick.png";
							}else{
								$class = 'teachertext1';
								$text = 'Not Available';
								$img = "../images/block.png";
							}
							
							$each_day = date('l', strtotime($sStartDate));
							$each_date = date('Y-m-d', strtotime($sStartDate));
							$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
							$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
							
							if($weekend == 0){
							?>
                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $sun1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                            <?php } else { ?>
                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1"  id="td<?php echo $line;?>">Non-Teaching Day</td>
                            <?php } $line++;?>
                            <td width="3" align="right" valign="middle"></td>
                            </tr>
                          </table></td>
                      <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                            <td width="3" align="left" valign="middle"></td>
                            <?php
							$num = $dbf->timeSlotAvailable($teacher_id, $mon1, $centre_time); 
							//$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$mon1' BETWEEN start_date And end_date)");
							if($num == false){
								$class = 'teachertext';
								$text = 'Available';
								$img = "../images/tick.png";
							}else{
								$class = 'teachertext1';
								$text = 'Not Available';
								$img = "../images/block.png";
							}                    
							
							$each_day = date('l', strtotime($each_day));
							$each_date = date('Y-m-d', strtotime($each_day));
							$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
							$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
							
							if($weekend == 0){
							?>
                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $mon1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                            <?php } else { ?>
                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                            <?php } $line++; ?>
                            <td width="3" align="right" valign="middle"></td>
                            </tr>
                          </table></td>
                      <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                            <td width="3" align="left" valign="middle"></td>
                            <?php
							$num = $dbf->timeSlotAvailable($teacher_id, $tue1, $centre_time); 
							//$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$tue1' BETWEEN start_date And end_date)");
							if($num == false){
								$class = 'teachertext';
								$text = 'Available';
								$img = "../images/tick.png";
							}else{
								$class = 'teachertext1';
								$text = 'Not Available';
								$img = "../images/block.png";
							}
							
							$each_day = date('l', strtotime($each_day));
							$each_date = date('Y-m-d', strtotime($each_day));
							$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
							$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
							
							if($weekend == 0)
							{
							?>
                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $tue1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                            <?php } else { ?>
                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                            <?php } $line++; ?>
                            <td width="3" align="right" valign="middle"></td>
                            </tr>
                          </table></td>
                      <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                            <td width="3" align="left" valign="middle"></td>
                            <?php
							$num = $dbf->timeSlotAvailable($teacher_id, $wed1, $centre_time); 
							//$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$wed1' BETWEEN start_date And end_date)");
							if($num==0){
								$class = 'teachertext';
								$text = 'Available';
								$img = "../images/tick.png";
							}else{
								$class = 'teachertext1';
								$text = 'Not Available';
								$img = "../images/block.png";
							}
							
							$each_day = date('l', strtotime($each_day));
							$each_date = date('Y-m-d', strtotime($each_day));
							$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
							$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
							
							if($weekend == 0)
							{
							?>
                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $wed1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                            <?php } else { ?>
                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                            <?php } $line++; ?>
                            <td width="3" align="right" valign="middle"></td>
                            </tr>
                          </table></td>
                      <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                            <td width="3" align="left" valign="middle"></td>
                            <?php
							$num = $dbf->timeSlotAvailable($teacher_id, $thu1, $centre_time); 
							//$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$thu1' BETWEEN start_date And end_date)");
							if($num==0){
								$class = 'teachertext';
								$text = 'Available';
								$img = "../images/tick.png";
							}else{
								$class = 'teachertext1';
								$text = 'Not Available';
								$img = "../images/block.png";
							}
							
							$each_day = date('l', strtotime($each_day));
							$each_date = date('Y-m-d', strtotime($each_day));
							$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
							$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
							
							if($weekend == 0){
							?>
                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $thu1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                            <?php } else { ?>
                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                            <?php } $line++; ?>
                            <td width="3" align="right" valign="middle"></td>
                            </tr>
                          </table></td>
                      <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                            <td width="3" align="left" valign="middle"></td>
                            <?php
							$num = $dbf->timeSlotAvailable($teacher_id, $fri1, $centre_time); 
							//$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$fri1' BETWEEN start_date And end_date)");
							if($num==0){
								$class = 'teachertext';
								$text = 'Available';
								$img = "../images/tick.png";
							}else{
								$class = 'teachertext1';
								$text = 'Not Available';
								$img = "../images/block.png";
							}
							
							$each_day = date('l', strtotime($each_day));
							$each_date = date('Y-m-d', strtotime($each_day));
							$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
							$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
							
							if($weekend == 0){
							?>
                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $fri1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);"><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                            <?php } else { ?>
                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                            <?php } $line++; ?>
                            <td width="3" align="right" valign="middle"></td>
                            </tr>
                          </table></td>
                      <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                            <td width="3" align="left" valign="middle"></td>
                            <?php
							$num = $dbf->timeSlotAvailable($teacher_id, $sat1, $centre_time); 
							//$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$sat1' BETWEEN start_date And end_date)");
							if($num==0){
								$class = 'teachertext';
								$text = 'Available';
								$img = "../images/tick.png";
							}else{
								$class = 'teachertext1';
								$text = 'Not Available';
								$img = "../images/block.png";
							}
							
							$each_day = date('l', strtotime($each_day));
							$each_date = date('Y-m-d', strtotime($each_day));
							$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
							$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
							
							if($weekend == 0){
							?>
                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $sat1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);"><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                            <?php } else { ?>
                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                            <?php } $line++; ?>
                            <td width="3" align="right" valign="middle"></td>
                            </tr>
                          </table></td>
                    </tr>
                    <?php						
                    $centre_time = date('h:i A',strtotime(date("H:i:s", strtotime($centre_time)) . " +15 minutes"));
                    $each_day = $sStartDate;
                  }
                    ?>                                        
                    </table>                            
          </div>                                      
          </td>
          </tr>
        </table>
      
      </td>
  </tr>
</table>                                     
</td>
</tr>
</table>

</td>
</tr>
                </table>