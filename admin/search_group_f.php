<?php
ob_start();
session_start();

$_SESSION[group_search_id]=$_REQUEST[val_group_id];
?>
<script type="text/javascript">
self.parent.location.href='certificate.php?student=<?php echo $_REQUEST[student];?>';
self.parent.tb_remove();
</script>