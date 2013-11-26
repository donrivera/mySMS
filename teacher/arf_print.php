<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
$res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.loginheading{
font-family:Arial, Helvetica, sans-serif;
font-size:18px;
color:#000000;
font-weight:normal;
padding-left:15px;
}
</style>
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
<body>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="border-color:#CCCCCC;">
	<tr>
		<td align="center" valign="middle" class="loginheading">&nbsp;</td>
	</tr>
	<tr>
		<td width="63" align="center" valign="middle" class="loginheading"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONREQUESTFRM");?> </td>
	</tr>
	<tr>
        <td height="40" align="left" valign="middle" class="nametext"><img src="../images/logo.png" alt="logo" width="105" height="30" /></td>
    </tr>
</table>
<br>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="1" >
	<tr>
		<td height="15" colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td width="63">&nbsp;</td>
		<td width="115" height="30" bgcolor="#CCCCCC" class="leftmenu" style="border-left:solid 1px; border-color:#636;border-top:solid 1px; border-color:#636;border-bottom:solid 1px; border-color:#636;border-right:solid 1px; border-color:#636;"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?> :</td>
		<td width="202" class="mytext">
			<?
				$sg=$dbf->strRecordID("student_group","group_name","id='$res_arf[group_id]'");
				echo $sg[group_name];
			?>
		</td>
		<td width="16">&nbsp;</td>
		<td width="74">&nbsp;</td>
		<td width="196" class="mytext">&nbsp;</td>
	</tr>
	<tr>
		<td width="63">&nbsp;</td>
		<td width="115" height="30" bgcolor="#CCCCCC" class="leftmenu" style="border-left:solid 1px; border-color:#636;border-top:solid 1px; border-color:#636;border-bottom:solid 1px; border-color:#636;border-right:solid 1px; border-color:#636;"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?> :</td>
		<td width="202" class="mytext"><?php echo $res_std[first_name]."&nbsp;".$res_std[father_name]."&nbsp;".$res_std[family_name]."&nbsp;(".$res_std[first_name1]."&nbsp;".$res_std[father_name1]."&nbsp;".$res_std[grandfather_name1]."&nbsp;".$res_std[family_name1].")";?></td>
		<td width="16">&nbsp;</td>
		<td width="74">&nbsp;</td>
		<td width="196" class="mytext">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> :</td>
		<td align="left" valign="middle"  class="mytext"><?php echo $res_arf[dated];?></td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_NR");?> :</td>
		<td align="left" valign="middle" class="mytext"><?php echo $res_arf[nr];?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?> :</td>
		<td align="left" valign="middle"  class="mytext"><?php echo $res_arf[action_owner];?></td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="mytext">&nbsp;</td>
	</tr>
	<tr>
        <td>&nbsp;</td>
        <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORTBY");?> : <span class="nametext1">*</span></td>
        <td align="left" valign="middle" class="leftmenu"></td>
        <td align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORTEDTO");?>:</td>
        <td align="left" valign="middle"></td>
    </tr>
	<tr>		
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CUSTOMER");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="function" value="customer" <?php echo ($res_arf["arf_function"] == 'customer' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td width="74" align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?> : </td>
		<td height="25" align="left" valign="middle">
			<span class="leftmenu">
				<input type="radio" name="function1" value="reception" <?php echo ($res_arf["arf_function1"] == 'reception' ? 'checked' : '')?>>
			</span>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_TEACHER");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="function" value="teacher" <?php echo ($res_arf["arf_function"] == 'teacher' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_LCD");?> : </td>
		<td height="25" align="left" valign="middle">
			<span class="leftmenu">
				<input type="radio" name="function1" value="lcd" <?php echo ($res_arf["arf_function1"] == 'lcd' ? 'checked' : '')?>>
			</span> 
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="function" value="reception" <?php echo ($res_arf["arf_function"] == 'reception' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_LIS");?> : </td>
		<td height="25" align="left" valign="middle">
			<span class="leftmenu">
				<input type="radio" name="function1" value="lis" <?php echo ($res_arf["arf_function1"] == 'lis' ? 'checked' : '')?>>
			</span>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CS");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="function" value="customer service" <?php echo ($res_arf["arf_function"] == 'customer service' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CS");?> : </td>
		<td height="25" align="left" valign="middle">
			<span class="leftmenu">
				<input type="radio" name="function1" value="customer service" <?php echo ($res_arf["arf_function1"] == 'customer service' ? 'checked' : '')?>>
			</span>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="function" value="other" <?php echo ($res_arf["arf_function"] == 'other' ? 'checked' : '')?>>
			<input name="other1" type="text" id="other1" value="<?php echo $res_arf[other1];?>" class="new_textbox100"/>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> :</td>
		<td height="25" align="left" valign="middle">&nbsp;&nbsp;
			<input type="radio" name="function1" value="other" <?php echo ($res_arf["arf_function1"] == 'other' ? 'checked' : '')?>>
			<input name="other2" type="text" id="other2" value="<?php echo $res_arf[other1];?>" class="new_textbox100"/>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_SUBJECT");?> :</td>
		<td align="left" valign="middle" class="leftmenu"></td>
	</tr>
	<tr>
		<td align="center" class="leftmenu"></td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_INSTRUCTION");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="subject" value="instruction" <?php echo ($res_arf["subject"] == 'instruction' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_MATERIAL");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="subject" value="material" <?php echo ($res_arf["subject"] == 'material' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_PROGRAMME");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="subject" value="program" <?php echo ($res_arf["subject"] == 'program' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_PREMISSES");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="subject" value="premises" <?php echo ($res_arf["subject"] == 'premises' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_ADMINST");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="subject" value="administration" <?php echo ($res_arf["subject"] == 'administration' ? 'checked' : '')?>>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> : </td>
		<td height="25" align="left" valign="middle" class="leftmenu">
			<input type="radio" name="subject" value="other" <?php echo ($res_arf["subject"] == 'other' ? 'checked' : '')?>>
			<input name="other3" type="text" class="new_textbox100" id="other3" value="<?php echo $res_arf[other3];?>"size="45" minlength="4"/>
		</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
	</tr>
    </table>
	<table>
	<tr>
		<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORT");?>:</td>
		<td><textarea name="action_report" cols="50" rows="10"><?php echo $res_arf[action_report];?></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
			<input name="action_report_date"  type="text" class="new_textbox100" id="action_report_date" size="45" value="<?php echo $res_arf[action_report_date];?>"/>
			<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
		</td>
	</tr>
	<!--SPACES FOR PRINTING-->
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<!--SPACES FOR PRINTING-->
	<tr>
		<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONTAKEN");?>:</td>
		<td><textarea name="action_taken" cols="50" rows="10"><?php echo $res_arf[action_taken];?></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
			<input name="action_taken_date"  type="text" class="new_textbox100" id="action_taken_date" size="45" value="<?php echo $res_arf[action_taken_date];?>"/>
			<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RESULTCHECKED");?>:</td>
		<td><textarea name="result_check" cols="50" rows="10"><?php echo $res_arf[result_check];?></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
			<input name="result_check_date"  type="text" class="new_textbox100" id="result_check_date" size="45" value="<?php echo $res_arf[result_check_date];?>"/>
			<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
		</td>
	</tr>
	
</table>
<br>
</body>
</html>
<script type="text/javascript">
window.print();
</script>