<?php
ob_start();
session_start();
$_SESSION[number]=$_REQUEST[number];
$_SESSION['sms_student_id']= $_REQUEST[id];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>


<body>
<script type="text/javascript">
self.parent.location.href='sms.php';

self.parent.tb_remove();

</script>
</body>
</html>
