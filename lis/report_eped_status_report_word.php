<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_eped_status_report.doc");
?>	
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
      <th width="5%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
      <th width="80%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("LIS_COUNT");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";					
        $num=$dbf->countRows('student_fees', $group);
        $days = $dbf->dateDiff($_REQUEST[start_date],$_REQUEST[end_date]);
        
        $status = $_REQUEST[status];
        
        //loop start
        for($k = 0; $k <= $days; $k++){
            if($k == 0){
                $st = $_REQUEST[start_date];
            }else{
                $st = date('Y-m-d',strtotime(date("Y-m-d", strtotime($st)) . "1 day"));
            }
            $no_stu = $dbf->countRows("ped_attendance","(shift1='$status' OR shift2='$status' || shift3='$status' OR shift4='$status' OR shift5='$status' || shift6='$status' OR shift7='$status' OR shift8='$status' || shift9='$status') And attend_date='$st'");
        ?>
        
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="center" valign="middle" class="mycon"><?php echo $k + 1;?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $st;?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $no_stu;?></td>
      </tr>  
	<?php
            $i = $i + 1;
            if($color=="#ECECFF"){
                $color = "#FBFAFA";
            }else{
                $color="#ECECFF";
            }
        }
        ?>            
</table>