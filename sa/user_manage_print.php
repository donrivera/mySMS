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

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
?>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
<body>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
    <thead>
      <tr class="logintext">
        <th width="4%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
        <th width="24%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
        <th width="22%" height="25" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
        <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
        <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
        <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_PASSWORD");?></th>
        </tr>
      </thead>
    <?php	
	$condition = '';
	//Concate the Condition
	//1.
	if($_REQUEST[fname]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
		$condition = "user_name LIKE '$_REQUEST[fname]%'";
	}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
		$condition = "mobile LIKE '$_REQUEST[mobile]%'";
	}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
		$condition = "email LIKE '$_REQUEST[email]%'";
	}
	//End 1.
	
	//2.
	else if($_REQUEST[fname]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
		$condition = "user_name LIKE '$_REQUEST[fname]%' AND mobile LIKE '$_REQUEST[mobile]%'";
	}else if($_REQUEST[fname]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
		$condition = "user_name LIKE '$_REQUEST[fname]%' AND email LIKE '$_REQUEST[email]%'";
	}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
		$condition = "mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
	}
	//End 2.
	
	//3.
	else if($_REQUEST[fname]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
		$condition = "user_name LIKE '$_REQUEST[fname]%' AND mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
	}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
		$condition = "mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
	}
	//End 3.
	
	//4.
	else if($_REQUEST[fname]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
		$condition = "id<>'1'";
	}
	//End 4.
					
    $i = 1;
    $color = "#ECECFF";
    
    foreach($dbf->fetchOrder('user',$condition." And user_type='Student' And center_id='$_SESSION[centre_id]'","id DESC") as $val) {
    
    $pass = base64_decode(base64_decode($val["password"]));
    ?>
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td height="25" align="center" valign="middle" class="mytext"><?php echo $i;?></td>
      <td height="25" align="left" valign="middle" class="mytext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
      <td align="left" valign="middle" class="mytext" style="padding-left:5px;"><?php echo $val[email];?></td>
      <td align="left" valign="middle" class="mytext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
      <td align="left" valign="middle" class="mytext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
      <td align="left" valign="middle" class="mytext" style="padding-left:5px;"><?php echo $pass;?></td>
      <?php
		  $i = $i + 1;
		  if($color=="#ECECFF"){
			  $color = "#FBFAFA";
		  }else{
			  $color="#ECECFF";
		  }
      }
      ?>
      </tr>
    </table>
</body>
</html>
<script type="text/javascript">
window.print();
</script>