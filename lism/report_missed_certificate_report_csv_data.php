<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

?>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
<thead>
        <tr class="logintext">
			<th width="21%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
			<th width="17%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></th>
			<th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME");?></th>
			<th width="15%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></th>
			<th width="11%" align="center" valign="middle" class="pedtext"><?php echo constant("CD_REPORT_CD_GRAPHS_NOOFSTUDENT");?></th>
		</tr>
  </thead>
<?php
    $i = 1;
    $color="#ECECFF";
    $teacher_id=$_REQUEST['teacher_id'];
	$centre_id=$_REQUEST['centre_id'];
	$query=$dbf->genericQuery("SELECT sg.id , CEIL( sg.units / MAX( p.units ) *100 ) AS percentage
								FROM student_group sg
								INNER JOIN ped_units p ON p.group_id = sg.id
								WHERE sg.teacher_id =  '$teacher_id'
								AND centre_id =  '$centre_id'
								AND p.dated !=  ''");
	//echo var_dump($query);
	foreach($query as $q)
	{
		$percent=$q['percentage'];
		$group_id=$q['id'];
		$progress=$dbf->getDataFromTable("teacher_progress","id","group_id='$group_id'"); 
		if($percent>=50 && empty($progress))
		{
			$data=$dbf->genericQuery("SELECT sg.group_name, c.name AS course_name, t.name AS teacher_name, COUNT( sgrp.id ) AS total,ctr.name as centre_name
										FROM student_group sg
										INNER JOIN course c ON c.id = sg.course_id
										INNER JOIN centre ctr ON ctr.id=sg.centre_id
										INNER JOIN teacher t ON t.id = sg.teacher_id
										INNER JOIN student_group_dtls sgrp ON sgrp.parent_id = sg.id
										WHERE sg.id ='$group_id'");
			$num=count($data);
		}
		else
		{
			$check_progress=$dbf->getDataFromTable("teacher_progress","id","group_id='$group_id' AND progress_report_date=''"); 
			if(!empty($check_proress))
			{
				$data=$dbf->genericQuery("SELECT sg.group_name, c.name AS course_name, t.name AS teacher_name, COUNT( sgrp.id ) AS total,ctr.name as centre_name
											FROM student_group sg
											INNER JOIN course c ON c.id = sg.course_id
											INNER JOIN centre ctr ON ctr.id=sg.centre_id
											INNER JOIN teacher t ON t.id = sg.teacher_id
											INNER JOIN student_group_dtls sgrp ON sgrp.parent_id = sg.id
											WHERE sg.id ='$group_id'");
				$num=count($data);
			}
			else{$num=0;}
		}
		foreach($data as $row)
		{
?>                    
			<tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
				<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[teacher_name];?></td>
				<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[centre_name];?></td>
				<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($group_id);?></td>
				<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[course_name];?></td>
				<td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[total];?></td>
	<?php
          $i = $i + 1;
          if($color=="#ECECFF"){$color = "#FBFAFA";}else{$color="#ECECFF";}					  
		}
	}
		?>
        </tr>                   
  </table>