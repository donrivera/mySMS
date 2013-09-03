<?php
include_once 'includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST["action"] == "clear"){

	$result = mysql_query("show tables"); // run the query and assign the result to $result
	while($table = mysql_fetch_array($result)) { // go through each row that was returned in $result
		if($table[0] != 'comment' && $table[0] != 'common' && $table[0] != 'conditions' && $table[0] != 'countries' && $table[0] != 'currency_setup' && $table[0] != 'email_templete' && $table[0] != 'email_templetes' && $table[0] != 'grade' && $table[0] != 'grade_sheet' && $table[0] != 'group_size' && $table[0] != 'quick_menu' && $table[0] != 'sms_gateway' && $table[0] != 'sms_templete' && $table[0] != 'student_status' && $table[0] != 'working_day'){
			
			if($table[0] == "user"){
				$dbf->deleteFromTable("user", "id <> '1'");
			}else{
				mysql_query("TRUNCATE TABLE ".$table[0]);
			}
		}
	}
	header("Location:db_clean.php?b0l1e2t=b0l1e2t");
	exit;
}
?>
<title>Clean DB</title>
<br />
<br />
<br />
<script language="javascript" type="text/javascript">
function chk(){
	var x;
	x = confirm("Do you sure ?");
	if(x){
		return true;
	}else{
		return false;
	}
}
</script>
<form id="frm" name="frm" action="db_clean.php?action=clear" method="post" onsubmit="return chk();">
<table width="400" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#999999">
  <tr>
    <td width="224" height="40" align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#F00; font-size:11px;">Please click &quot;Clear&quot; button to clean the Database !!!</td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#063; font-size:11px;"><?php if($_REQUEST["b0l1e2t"]=="b0l1e2t"){?>You have successully clear the Database.<?php }?></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><input type="image" src="images/db_clean.png" width="83" height="79" title="Clear here to Clean" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</form>