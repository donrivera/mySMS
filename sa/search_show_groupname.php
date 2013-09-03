<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';
$pageTitle='Welcome to Berlitz-KSA';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');
?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="450" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
$name="$_REQUEST[search_group1]";
if($name == "") { exit; }

foreach($dbf->fetchOrder("student","(family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%') And centre_id='$_SESSION[centre_id]' And email <> ''") as $val){
	
	$is_complete = $dbf->countRows("student_group m,student_group_dtls d", "m.centre_id='$_SESSION[centre_id]' And m.id=d.parent_id And d.student_id='$val[id]' And m.status='Completed'");
	if($is_complete > 0){
?>
  <tr>
    <td width="126" align="left" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="search_group_f.php?student=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
    <td width="111" align="left" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="search_group_f.php?student=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["student_mobile"];?></a></td>
    <td width="105" align="left" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="search_group_f.php?student=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["email"];?></a></td>
  </tr>
  <?php
	}
	}
  ?>  
</table>
<?php } else{?>
<table width="450" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
$name="$_REQUEST[search_group1]";
if($name == "") { exit; }

foreach($dbf->fetchOrder("student","(family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%') And centre_id='$_SESSION[centre_id]' And email <> ''") as $val){
	
	$is_complete = $dbf->countRows("student_group m,student_group_dtls d", "m.centre_id='$_SESSION[centre_id]' And m.id=d.parent_id And d.student_id='$val[id]' And m.status='Completed'");
	if($is_complete > 0){
?>
  <tr>
    <td width="105" align="right" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="search_group_f.php?student=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["email"];?></a></td>
    <td width="111" align="right" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="search_group_f.php?student=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["student_mobile"];?></a></td>
    <td width="126" align="right" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="search_group_f.php?student=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?><?php echo $val["first_name"];?></a></td>
  </tr>
  <?php
	}
	}
  ?>  
</table>
<?php }?>