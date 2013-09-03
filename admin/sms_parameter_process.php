<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	
	$comment = mysql_real_escape_string($_REQUEST["attc13"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='13'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc14"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='14'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc15"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='15'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc16"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='16'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc17"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='17'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc18"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='18'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc19"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='19'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc20"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='20'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc21"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='21'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc22"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='22'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc23"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='23'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc24"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='24'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc25"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='25'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc26"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='26'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc27"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='27'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc28"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='28'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc29"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='29'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc30"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='30'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc31"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='31'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc32"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='32'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc33"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='33'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc34"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='34'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc36"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='35'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc36"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='36'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc37"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='37'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc40"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='40'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc41"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='41'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc42"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='42'");
	
	$comment = mysql_real_escape_string($_REQUEST["attc43"]);
	$string="comments='$comment'";
	$dbf->updateTable("sms_templete",$string,"id='43'");	
	//==== sms_parameter ===
		
	header("Location:sms_parameter_templete.php");
}
?>
