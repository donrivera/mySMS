<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

$num_group=$dbf->countRows('corporate_students',"account='$_REQUEST[account]'");
if($num_group > 0)
{	echo "Record Exists...";
?>
	<script language="javascript" type="text/javascript">
	$(document).ready(function() 
	{
		//$('#submit').attr('disabled', 'disabled');
		document.getElementById("submit").disabled = true; 
	}	
	</script>
<?php	
}
?>