<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<!--	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
-->
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>
    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

</head>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger(){
    if(countdown_number > 0){
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0){
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION['lang']=='EN'){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
	
	<td align="center" valign="top">
		<table width="98%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="10%">
					<BR/>
					<table style="width:100px;" border="1">
					<tr><td><b>Group Size</b></td></tr>
					<tr><td><b>Group Name</b></td></tr>
					<tr><td><b>Program</b></td></tr>
					<tr><td><b>Level</b></td></tr>
					<tr><td><b>Teacher</b></td></tr>
					<tr><td><b>Start Date</b></td></tr>
					<tr><td><b>End Date</b></td></tr>
					<tr><td><b>Units/Day</b></td></tr>
					<tr><td><b>Working Days</b></td></tr>
					<tr><td><b>Time</b></td></tr>
					<tr><td><b>Duration</b></td></tr>
					<tr><td><b>Units</b></td></tr>
					</table>
				</td>
				<td width="97%" height="10%" align="left" valign="top">
					<form name="frm" id="frm" method="post">
						<table border="0">
							<tr>
								<td>&nbsp;</td>
								<td>
									Year:
									<select name="year">
										<?php $year_select=(empty($_REQUEST['year'])?date('Y'):$_REQUEST['year']);?>
										<?php foreach(range(2000,(int)date("Y")) as $year):?>
											<option value="<?php echo $year; ?>" <?php if ($year_select == $year) { echo 'selected="selected"'; } ?>>
												<?=$year;?>
											</option>
										<?php	endforeach;?>
									</select>
									Month:
									<select name="month">
										<?php $month_select=(empty($_REQUEST['month'])?date('n'):$_REQUEST['month']);?>
										<?php foreach(range('1', '12') as $m) : ?>
											<option value="<?php echo $m; ?>" <?php if ($month_select == $m) { echo 'selected="selected"'; } ?>>
												<?=date("F", mktime(0, 0, 0, $m, 10));?>
											</option>
										<?php endforeach; ?>
									</select>
									Course:
									<select name="course">
										<option value=''>Course</option>
										<?php $course_option=$dbf->genericQuery("SELECT id,name FROM course ORDER BY id");?>
										<?php foreach($course_option as $c) : ?>
											<option value="<?php echo $c['id']; ?>" <?php if ($_REQUEST['course'] == $c['id']) { echo 'selected="selected"'; } ?>>
												<?=$c['name']?>
											</option>
										<?php endforeach; ?>
									</select>
									<input type="submit" value="Search" class="btn1" border="0" align="left" />
									&nbsp;
									<a href="center_schedule_csv.php?year=<?=$_REQUEST["year"];?>&month=<?=$_REQUEST["month"];?>&course=<?=$_REQUEST["course"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a>
									<!--
									<a href="print_schedule_word.php?year=<?=$_REQUEST["year"];?>&month=<?=$_REQUEST["month"];?>&course=<?=$_REQUEST["course"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a>
									&nbsp;
									<a href="center_schedule_csv.php?year=<?=$_REQUEST["year"];?>&month=<?=$_REQUEST["month"];?>&course=<?=$_REQUEST["course"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a>
									&nbsp;
									<a href="print_schedule_pdf.php?year=<?=$_REQUEST["year"];?>&month=<?=$_REQUEST["month"];?>&course=<?=$_REQUEST["course"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a>
									&nbsp;
									<a href="print_schedule_print.php?year=<?=$_REQUEST["fname"];?>&month=<?=$_REQUEST["month"];?>&course=<?=$_REQUEST["course"];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a>
									-->
								</td>
							</tr>
						</table>
						<style>
						#rowScroll { height: <?=$table_height?>; } /* Student Names */
						#contentScroll { height: 210; width: 1250px; }/*Group Class*/
						<!--#activeScroll { height: 210; width: 1250px; }/*Group Class*/-->
						#colScroll { height: 210; width: 1250px; } /* date */
						</style>
						<div id="colScroll" style="overflow-x:hidden;">
						<table border="0" >
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
						</table>
						</div>
					</form>
				</td>
			</tr>
			
			<tr>
				<td width="10%" valign="top">
					<table border="1">
					<tr><td><b>Active</b></td></tr>
					<tr><td>*Legend:</td></tr>
					<tr><td><font color="red">Remaining Money</font></td></tr>
					<tr><td><font color="#52D017">Full Payment</font></td></tr>
					<tr><td><font color="black">No Payment</font></td></tr>
					</table>
				</td>
				<td width="97%" align="left" valign="top">
				<div id="contentScroll" style="overflow:auto">
				<table border="0">
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
													$stu_course_fee=$dbf->getDataFromTable("course_fee","fees","course_id='$cs[course_id]'");
													if($balance==0)
													{$ws_link="#52D017";}
													elseif($balance>0)
													{$ws_link=($balance==$stu_course_fee?"black":"red");}
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
				</div>
				</td>
			</tr>
			<tr>
				<td width="10%" valign="top">
					&nbsp;
				</td>
				<td width="97%" height="10%" align="left" valign="top">
					<table border="0">
						<tr>
							<td colspan="2" width="180" class="pedtext_normal" valign="top">
								<center><b>On Hold</b></center> 
								<?php
										if(empty($course))
										{$onhold_cond="";}//$waiting_cond="sm.status_id='3' AND s.centre_id='$centre'";
										else{$onhold_cond="sm.status_id='6' AND sf.course_id='$course' AND sf.type='on hold'  AND s.centre_id='$centre'";}
										$onhold_student=$dbf->genericQuery("	SELECT DISTINCT(s.id),sf.course_id 
																				FROM student s
																				INNER JOIN student_moving sm ON sm.student_id=s.id
																				INNER JOIN student_fees sf ON sf.student_id=s.id
																				WHERE $onhold_cond
																				ORDER BY sf.created_date DESC
																				LIMIT 0,50");
										foreach($onhold_student as $ohs):
											$corporate=$dbf->getDataFromTable("student","corporate","id='$ohs[id]'");
											$font_weight=(empty($corporate)?"normal":"bold");
											$balance = $dbf->BalanceAmount($ohs['id'],$ohs['course_id']);
											$stu_course_fee=$dbf->getDataFromTable("course_fee","fees","course_id='$ohs[course_id]'");
											if($balance==0)
											{$ws_link="#52D017";}
											elseif($balance>0)
											{$ws_link=($balance==$stu_course_fee?"black":"red");}
											else{$ws_link="black";}
									?>
										<table style="width:250px;" border="1">
										<tr>
											<td align="center">
												<a href="single-home.php?student_id=<?=$ohs['id']?>" style="color:<?=$ws_link?>;font-weight:<?=$font_weight?>">
													<?=$dbf->acctPrintStudentName($ohs['id']);?>
												</a>
											</td>
										</tr>
										</table>
									<?php
										endforeach;
									?>
							</td>
							<td colspan="2" width="180" class="pedtext_normal" valign="top">
								<center><b>Waiting</b></center> 
								<?php
										if(empty($course))
										{$waiting_cond="";}//$waiting_cond="sm.status_id='3' AND s.centre_id='$centre'";
										else{$waiting_cond="sm.status_id='3' AND sf.course_id='$course' AND sf.type='advance' AND s.centre_id='$centre'";}
										$waiting_student=$dbf->genericQuery("	SELECT DISTINCT(s.id),sf.course_id 
																				FROM student s
																				INNER JOIN student_moving sm ON sm.student_id=s.id
																				INNER JOIN student_fees sf ON sf.student_id=s.id
																				WHERE $waiting_cond
																				ORDER BY sf.created_date DESC
																				LIMIT 0,50");
										foreach($waiting_student as $ws):
											$corporate=$dbf->getDataFromTable("student","corporate","id='$ws[id]'");
											$font_weight=(empty($corporate)?"normal":"bold");
											$balance = $dbf->printBalanceAmount($ws['id'],$course);//BalanceAmount($ws['id'],$ws['course_id']);
											if($balance==0)
													{$ws_link="#52D017";}
													elseif($balance>=0)
													{$ws_link="red";}
													else{$ws_link="black";}
									?>
										<table style="width:250px;" border="1">
											<tr>
												<td align="center">
													<a href="single-home.php?student_id=<?=$ws['id']?>" style="color:<?=$ws_link?>;font-weight:<?=$font_weight?>">
														<?=$dbf->acctPrintStudentName($ws['id']);?>
													</a>
												</td>
											</tr>
										</table>
									<?php
										endforeach;
									?>
							</td>
							<td colspan="2" width="180" class="pedtext_normal" valign="top">
								<center><b>Potential</b></center>
								<?php
										if(empty($course))
										{$potential_cond="";}//$waiting_cond="sm.status_id='3' AND s.centre_id='$centre'";
										else{$potential_cond="sm.status_id='2' AND sc.course_id='$course' AND s.centre_id='$centre'";}
										$potential_student=$dbf->genericQuery("	SELECT s.id 
																				FROM student s
																				INNER JOIN student_moving sm ON sm.student_id=s.id
																				INNER JOIN student_course sc ON sc.student_id=s.id
																				WHERE $potential_cond
																				ORDER BY s.id DESC
																				LIMIT 0,50");
										foreach($potential_student as $ps):
										$corporate=$dbf->getDataFromTable("student","corporate","id='$ps[id]'");
											$font_weight=(empty($corporate)?"normal":"bold");
										$ws_link="black";
									?>
										<table style="width:250px;" border="1">
										<tr>
											<td align="center">
												<a href="single-home.php?student_id=<?=$ps['id']?>" style="color:<?=$ws_link?>;;font-weight:<?=$font_weight?>">
													<?=$dbf->acctPrintStudentName($ps['id']);?>
												</a>
											</td>
										</tr>
										</table>
									<?php
										endforeach;
									?>
							</td>
						</tr>
					</table>
				</td>
				
			</tr>
			<!--
			<tr>
				<td width="10%" valign="top">
					<table border="1">
						<tr><td><b>Waiting</b></td></tr>
					</table>
				</td>
				<td width="97%" align="left" valign="top">
				<table border="0">
						<tr>
							<?php 
								
								
								//$count_groups=count($groups);
								//echo var_dump($class_student);
								//foreach($groups as $g):
							?>
								<td colspan="2" width="180" class="pedtext_normal">
									
									<?php
										if(empty($course))
										{$waiting_cond="";}//$waiting_cond="sm.status_id='3' AND s.centre_id='$centre'";
										else{$waiting_cond="sm.status_id='3' AND sc.course_id='$course' AND s.centre_id='$centre'";}
										$waiting_student=$dbf->genericQuery("	SELECT s.id,sc.course_id 
																				FROM student s
																				INNER JOIN student_moving sm ON sm.student_id=s.id
																				INNER JOIN student_course sc ON sc.student_id=s.id
																				WHERE $waiting_cond
																				LIMIT 0,10");
										foreach($waiting_student as $ws):
										
											$balance = $dbf->printBalanceAmount($ws['id'],$course);//BalanceAmount($ws['id'],$ws['course_id']);
											if($balance==0)
													{$ws_link="#52D017";}
													elseif($balance>=0)
													{$ws_link="red";}
													else{$ws_link="black";}
									?>
										<table style="width:250px;" border="1">
											<tr>
												<td align="center">
													<a href="single-home.php?student_id=<?=$ws['id']?>" style="color:<?=$ws_link?>">
														<?=$dbf->acctPrintStudentName($ws['id']);?>
													</a>
												</td>
											</tr>
										</table>
									<?php
										endforeach;
									?>
									
								</td>
							<?	//endforeach;?>
						</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td width="10%" valign="top">
					<table border="1">
						<tr><td><b>Potential</b></td></tr>
					</table>
				</td>
				</td>
				<td width="97%" align="left" valign="top">
				<table border="0">
						<tr>
							<?php 
								
								
								//$count_groups=count($groups);
								//echo var_dump($class_student);
								//foreach($groups as $g):
							?>
								<td colspan="2" width="180" class="pedtext_normal">
									
									<?php
										if(empty($course))
										{$potential_cond="";}//$waiting_cond="sm.status_id='3' AND s.centre_id='$centre'";
										else{$potential_cond="sm.status_id='2' AND sc.course_id='$course' AND s.centre_id='$centre'";}
										$potential_student=$dbf->genericQuery("	SELECT s.id 
																				FROM student s
																				INNER JOIN student_moving sm ON sm.student_id=s.id
																				INNER JOIN student_course sc ON sc.student_id=s.id
																				WHERE $potential_cond
																				ORDER BY s.created_datetime");
										foreach($potential_student as $ps):
										$ws_link="black";
									?>
										<table style="width:250px;" border="1">
										<tr>
											<td align="center">
												<a href="single-home.php?student_id=<?=$ps['id']?>" style="color:<?=$ws_link?>">
													<?=$dbf->acctPrintStudentName($ps['id']);?>
												</a>
											</td>
										</tr>
										</table>
									<?php
										endforeach;
									?>
									
								</td>
							<?	//endforeach;?>
						</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td width="10%" valign="top">
					<table border="1">
						<tr><td><b>On Hold</b></td></tr>
					</table>
				</td>
				</td>
				<td width="97%" align="left" valign="top">
				<table border="0">
						<tr>
							<?php 
								
								
								//$count_groups=count($groups);
								//echo var_dump($class_student);
								//foreach($groups as $g):
							?>
								<td colspan="2" width="180" class="pedtext_normal">
									
									<?php
										if(empty($course))
										{$onhold_cond="";}//$waiting_cond="sm.status_id='3' AND s.centre_id='$centre'";
										else{$onhold_cond="sm.status_id='6' AND sc.course_id='$course' AND s.centre_id='$centre'";}
										$onhold_student=$dbf->genericQuery("	SELECT s.id,sc.course_id 
																				FROM student s
																				INNER JOIN student_moving sm ON sm.student_id=s.id
																				INNER JOIN student_course sc ON sc.student_id=s.id
																				WHERE $onhold_cond
																				LIMIT 0,10");
										foreach($onhold_student as $ohs):
											$balance = $dbf->BalanceAmount($ohs['id'],$ohs['course_id']);
											if($balance==0)
											{$ws_link="#52D017";}
											elseif($balance>0)
											{$ws_link="red";}
											else{$ws_link="black";}
									?>
										<table style="width:250px;" border="1">
										<tr>
											<td align="center">
												<a href="single-home.php?student_id=<?=$ohs['id']?>" style="color:<?=$ws_link?>">
													<?=$dbf->acctPrintStudentName($ohs['id']);?>
												</a>
											</td>
										</tr>
										</table>
									<?php
										endforeach;
									?>
									
								</td>
							<?	//endforeach;?>
						</tr>
				</table>
				</td>
			</tr>
			-->
		</table>
		<script type="text/javascript">
			var content = $("#contentScroll");
			//var active = $("#activeScroll");
			var headers = $("#colScroll");
			var rows = $("#rowScroll");
			content.scroll(function () {headers.scrollLeft(content.scrollLeft());rows.scrollTop(content.scrollTop());});
			//active.scroll(function () {headers.scrollLeft(active.scrollLeft());rows.scrollTop(active.scrollTop());});
		</script>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
