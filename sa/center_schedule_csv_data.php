<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
<?php
	$year=$_REQUEST['year'];
	$month=$_REQUEST['month'];
	$course=$_REQUEST['course'];
	$centre=$_SESSION['centre_id'];
	if(!empty($year) && !empty($month) AND !empty($course))
	{
		$cond="YEAR(sg.start_date) = '$year' AND MONTH(sg.start_date) = '$month' AND sg.course_id='$course' AND sg.centre_id='$centre'";
	}
	elseif(!empty($year) && !empty($month) AND empty($course))
	{
		$cond="YEAR(sg.start_date) = '$year' AND MONTH(sg.start_date) = '$month' AND sg.centre_id='$centre'";
	}
	else
	{$cond="";}
	$class_sql=$dbf->genericQuery("	SELECT sg.id,sg.group_id,sg.group_name,sg.units,sg.unit_per_day,sg.class_per_week,sg.class_day,sg.start_date,sg.end_date,sg.group_start_time,sg.group_end_time,t.name as teacher,c.code,c.name as course_name
									FROM student_group sg
									INNER JOIN teacher t ON sg.teacher_id=t.id
									INNER JOIN course c ON sg.course_id=c.id
									WHERE $cond
									ORDER BY sg.start_date
								");
	//CONVERT(SUBSTRING(group_name, 10), SIGNED INTEGER)
	?>
	<tr>
		<? foreach($class_sql as $c_sql):?>
			<td colspan="2" width="250" class="pedtext_normal">
				<table style="width:250px;" border="1">
					<tr><td align="center"><?=$dbf->getDataFromTable("common","name","id='$c_sql[group_id]'")?></td></tr>
					<tr><td align="center"><b><a href="group_manage_edit.php?id=<?=$c_sql['id']?>"><?=$c_sql['group_name']?></a></b></td></tr>
					<tr><td align="center"><?=$c_sql['code']?></td></tr>
					<tr><td align="center"><?=$c_sql['course_name']?></td></tr>
					<tr><td align="center"><?=$c_sql['teacher']?></td></tr>
					<tr><td align="center"><?=date("d/m/Y", strtotime($c_sql['start_date']))?></td></tr>
					<tr><td align="center"><?=date("d/m/Y", strtotime($c_sql['end_date']))?></td></tr>
					<tr><td align="center"><?=$c_sql['unit_per_day']?>units/day</td></tr>
					<tr>
						<td align="center">
						<?#=(empty($c_sql['class_day'])?"N/A":$c_sql['class_day'])?>
						<?php
							if(empty($c_sql['class_day']))
							{echo "N/A";}
							else
							{
								$days=explode(',',$c_sql['class_day']);
								foreach($days as $dy):
									echo ucfirst($dy)."&nbsp;"; 
								endforeach;
							}
						?>
						</td>
					</tr>
					<tr><td align="center"><?=$c_sql['group_start_time']?>-<?=$c_sql['group_end_time']?></td></tr>
					<tr>
						<td align="center">
						<?php
							if(empty($c_sql['class_per_week']) && empty($c_sql['class_day']))
							{$class_duration=$dbf->getDataFromTable("group_size","week_id","group_id='$c_sql[group_id]'");}
							else
							{
								$frequency=floor($c_sql['units']/$c_sql['unit_per_day']/$c_sql['class_per_week']);
								$class_duration=($frequency>1?$frequency."&nbsp;weeks":$frequency."&nbsp;week");
							}
						?>
						<?=$class_duration?>
						</td>
					</tr>
					<tr><td align="center"><?=$c_sql['units']?></td></tr>
					<?$groups[]=$c_sql[id];?>
				</table><br/>
			</td>
		<?endforeach;?>
	</tr>
	<tr>
	<?php 
		//$count_groups=count($groups);
		//echo var_dump($class_student);
		foreach($groups as $g):
			$class_student=$dbf->genericQuery("SELECT student_id,course_id FROM student_group_dtls WHERE parent_id='$g'");
	?>
			<td colspan="2" width="220" class="pedtext_normal" valign="top">
				<table style="width:250px;" border="1">
					<tr><td align="center"><b><?=$dbf->getDataFromTable("student_group","group_name","id='$g'")?></b>(<?="STU:".count($class_student)?>)</td></tr>
					<?php
						foreach($class_student as $cs):
							$corporate=$dbf->getDataFromTable("student","corporate","id='$cs[student_id]'");
							$font_weight=(empty($corporate)?"normal":"bold");
							$invoice=$dbf->getInvoiceCode($cs['student_id'],$cs['course_id']);
					?>
					<tr>
						<td align="center">
						<?php
							$balance = $dbf->BalanceAmount($cs['student_id'],$cs['course_id']);
							if($balance==0)
							{$ws_link="#52D017";}
							elseif($balance>0)
							{$ws_link="red";}
							else{$ws_link="black";}
						?>
						<a href="single-home.php?student_id=<?=$cs['student_id']?>" style="color:<?=$ws_link?>;font-weight:<?=$font_weight?>">
							<?=$dbf->acctPrintStudentName($cs['student_id']);?>
						</a>
						</td>
					</tr>
					<?php
						endforeach;
					?>
				</table>
			</td>
	<?	endforeach;?>
	</tr>
</table>