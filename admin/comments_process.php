<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{
	//Check duplicate for Attandance
	$num=$dbf->countRows('comment',"type='Attendance' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[attc1]);
	if($num==0)
	{		
		$string="id='1',type='Attendance',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Attendance'");
	}

	$num=$dbf->countRows('comment',"type='Attendance' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[attc2]);
	if($num==0)
	{		
		$string="id='2',type='Attendance',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Attendance'");
	}
	
	$num=$dbf->countRows('comment',"type='Attendance' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[attc3]);
	if($num==0)
	{		
		$string="id='3',type='Attendance',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Attendance'");
	}
	
	$num=$dbf->countRows('comment',"type='Attendance' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[attc4]);
	if($num==0)
	{		
		$string="id='4',type='Attendance',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Attendance'");
	}
	
	$num=$dbf->countRows('comment',"type='Attendance' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[attc5]);
	if($num==0)
	{		
		$string="id='5',type='Attendance',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Attendance'");
	}
	//==== Attendance ===
	
	//Check duplicate for participation
	$num=$dbf->countRows('comment',"type='Participation' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[part1]);
	if($num==0)
	{		
		$string="id='1',type='Participation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Participation'");
	}
	
	$num=$dbf->countRows('comment',"type='Participation' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[part2]);
	if($num==0)
	{		
		$string="id='2',type='Participation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Participation'");
	}
	
	$num=$dbf->countRows('comment',"type='Participation' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[part3]);
	if($num==0)
	{		
		$string="id='3',type='Participation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Participation'");
	}
	
	$num=$dbf->countRows('comment',"type='Participation' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[part4]);
	if($num==0)
	{		
		$string="id='4',type='Participation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Participation'");
	}
	
	$num=$dbf->countRows('comment',"type='Participation' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[part5]);
	if($num==0)
	{		
		$string="id='5',type='Participation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Participation'");
	}
	//=== participation
	
	//Check duplicate for Homework
	$num=$dbf->countRows('comment',"type='Homework' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[home1]);
	if($num==0)
	{		
		$string="id='1',type='Homework',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Homework'");
	}
	
	$num=$dbf->countRows('comment',"type='Homework' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[home2]);
	if($num==0)
	{		
		$string="id='2',type='Homework',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Homework'");
	}
	
	$num=$dbf->countRows('comment',"type='Homework' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[home3]);
	if($num==0)
	{		
		$string="id='3',type='Homework',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Homework'");
	}
	
	$num=$dbf->countRows('comment',"type='Homework' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[home4]);
	if($num==0)
	{		
		$string="id='4',type='Homework',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Homework'");
	}
	
	$num=$dbf->countRows('comment',"type='Homework' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[home5]);
	if($num==0)
	{		
		$string="id='5',type='Homework',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Homework'");
	}
	//=== Homework
	
	//Check duplicate for Fluency
	$num=$dbf->countRows('comment',"type='Fluency' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[flu1]);
	if($num==0)
	{		
		$string="id='1',type='Fluency',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Fluency'");
	}
	
	$num=$dbf->countRows('comment',"type='Fluency' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[flu2]);
	if($num==0)
	{		
		$string="id='2',type='Fluency',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Fluency'");
	}
	
	$num=$dbf->countRows('comment',"type='Fluency' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[flu3]);
	if($num==0)
	{		
		$string="id='3',type='Fluency',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Fluency'");
	}
	
	$num=$dbf->countRows('comment',"type='Fluency' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[flu4]);
	if($num==0)
	{		
		$string="id='4',type='Fluency',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Fluency'");
	}
	
	$num=$dbf->countRows('comment',"type='Fluency' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[flu5]);
	if($num==0)
	{		
		$string="id='5',type='Fluency',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Fluency'");
	}
	//=== Fluency	
	
	//Check duplicate for Pronunciation
	$num=$dbf->countRows('comment',"type='Pronunciation' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[pro1]);
	if($num==0)
	{		
		$string="id='1',type='Pronunciation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Pronunciation'");
	}
	
	$num=$dbf->countRows('comment',"type='Pronunciation' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[pro2]);
	if($num==0)
	{		
		$string="id='2',type='Pronunciation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Pronunciation'");
	}
	
	$num=$dbf->countRows('comment',"type='Pronunciation' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[pro3]);
	if($num==0)
	{		
		$string="id='3',type='Pronunciation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Pronunciation'");
	}
	
	$num=$dbf->countRows('comment',"type='Pronunciation' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[pro4]);
	if($num==0)
	{		
		$string="id='4',type='Pronunciation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Pronunciation'");
	}
	
	$num=$dbf->countRows('comment',"type='Pronunciation' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[pro5]);
	if($num==0)
	{		
		$string="id='5',type='Pronunciation',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Pronunciation'");
	}
	//=== Pronunciation
	
	//Check duplicate for Grammer
	$num=$dbf->countRows('comment',"type='Grammer' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[gra1]);
	if($num==0)
	{		
		$string="id='1',type='Grammer',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Grammer'");
	}
	
	$num=$dbf->countRows('comment',"type='Grammer' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[gra2]);
	if($num==0)
	{		
		$string="id='2',type='Grammer',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Grammer'");
	}
	
	$num=$dbf->countRows('comment',"type='Grammer' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[gra3]);
	if($num==0)
	{		
		$string="id='3',type='Grammer',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Grammer'");
	}
	
	$num=$dbf->countRows('comment',"type='Grammer' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[gra4]);
	if($num==0)
	{		
		$string="id='4',type='Grammer',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Grammer'");
	}
	
	$num=$dbf->countRows('comment',"type='Grammer' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[gra5]);
	if($num==0)
	{		
		$string="id='5',type='Grammer',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Grammer'");
	}
	//=== Grammer
	
	//Check duplicate for Vocabulary
	$num=$dbf->countRows('comment',"type='Vocabulary' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[voc1]);
	if($num==0)
	{		
		$string="id='1',type='Vocabulary',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Vocabulary'");
	}
	
	$num=$dbf->countRows('comment',"type='Vocabulary' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[voc2]);
	if($num==0)
	{		
		$string="id='2',type='Vocabulary',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Vocabulary'");
	}
	
	$num=$dbf->countRows('comment',"type='Vocabulary' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[voc3]);
	if($num==0)
	{		
		$string="id='3',type='Vocabulary',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Vocabulary'");
	}
	
	$num=$dbf->countRows('comment',"type='Vocabulary' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[voc4]);
	if($num==0)
	{		
		$string="id='4',type='Vocabulary',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Vocabulary'");
	}
	
	$num=$dbf->countRows('comment',"type='Vocabulary' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[voc5]);
	if($num==0)
	{		
		$string="id='5',type='Vocabulary',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Vocabulary'");
	}
	//=== Vocabulary
	
	//Check duplicate for Comprehension
	$num=$dbf->countRows('comment',"type='Comprehension' AND id='1'");
	$comment = mysql_real_escape_string($_REQUEST[comp1]);
	if($num==0)
	{		
		$string="id='1',type='Comprehension',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='1' And type='Comprehension'");
	}
	
	$num=$dbf->countRows('comment',"type='Comprehension' AND id='2'");
	$comment = mysql_real_escape_string($_REQUEST[comp2]);
	if($num==0)
	{		
		$string="id='2',type='Comprehension',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='2' And type='Comprehension'");
	}
	
	$num=$dbf->countRows('comment',"type='Comprehension' AND id='3'");
	$comment = mysql_real_escape_string($_REQUEST[comp3]);
	if($num==0)
	{		
		$string="id='3',type='Comprehension',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='3' And type='Comprehension'");
	}
	
	$num=$dbf->countRows('comment',"type='Comprehension' AND id='4'");
	$comment = mysql_real_escape_string($_REQUEST[comp4]);
	if($num==0)
	{		
		$string="id='4',type='Comprehension',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='4' And type='Comprehension'");
	}
	
	$num=$dbf->countRows('comment',"type='Comprehension' AND id='5'");
	$comment = mysql_real_escape_string($_REQUEST[comp5]);
	if($num==0)
	{		
		$string="id='5',type='Comprehension',comment='$comment'";
		$dbf->insertSet("comment",$string);
	}	
	else
	{
		$string="comment='$comment'";
		$dbf->updateTable("comment",$string,"id='5' And type='Comprehension'");
	}
	//=== Comprehension
		
	header("Location:comments_manage.php");
}
?>
