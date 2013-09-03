<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if($_REQUEST['action']=='insert'){
	
	$comment = mysql_real_escape_string($_REQUEST["attc13"]);
	$title = mysql_real_escape_string($_REQUEST["t13"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='1'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc14"]);
	$title = mysql_real_escape_string($_REQUEST["t14"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='2'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc15"]);
	$title = mysql_real_escape_string($_REQUEST["t15"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='3'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc16"]);
	$title = mysql_real_escape_string($_REQUEST["t16"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='4'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc17"]);
	$title = mysql_real_escape_string($_REQUEST["t17"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='5'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc18"]);
	$title = mysql_real_escape_string($_REQUEST["t18"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='6'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc19"]);
	$title = mysql_real_escape_string($_REQUEST["t19"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='7'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc20"]);
	$title = mysql_real_escape_string($_REQUEST["t20"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='8'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc21"]);
	$title = mysql_real_escape_string($_REQUEST["t21"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='9'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc22"]);
	$title = mysql_real_escape_string($_REQUEST["t22"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='10'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc23"]);
	$title = mysql_real_escape_string($_REQUEST["t23"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='11'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc24"]);
	$title = mysql_real_escape_string($_REQUEST["t24"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='12'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc25"]);
	$title = mysql_real_escape_string($_REQUEST["t24"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='13'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc26"]);
	$title = mysql_real_escape_string($_REQUEST["t26"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='14'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc27"]);
	$title = mysql_real_escape_string($_REQUEST["t27"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='15'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc28"]);
	$title = mysql_real_escape_string($_REQUEST["t28"]);
	$string="content='$comment',title='$title'";
	$dbf->updateTable("email_templetes",$string,"id='16'");
	
	header("Location:email_parameter_templete.php");
}
?>
