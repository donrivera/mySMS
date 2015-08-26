<html>
<head>
<script language="javascript" type="text/javascript">
function add()
{
	var x = document.getElementById('count').value;
	var z='div'+x;
	document.getElementById(z).style.display = "block";
	x++;
	document.getElementById('count').value = x;
}
function del()
{
	var x = document.getElementById('count').value;
	if(x==1)
	{
		alert("You can not delete default row.");
		return false;
	}
	x = x - 1;
	var z='div'+x;
	document.getElementById(z).style.display = "none";	
	document.getElementById('count').value = x;
}
</script>	
</head>
<body>
	<table>
		<tr>
			<td  bgcolor="#000033" class="logintext">&nbsp; <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_TXT");?></td>
			<td  bgcolor="#000033"><img src="../images/plus-circle.png" width="20" height="20" onClick="add();"/></td>
            <td  bgcolor="#000033"><img src="../images/minus1.png" width="18" height="18" onClick="del();"/></td>
        </tr>
		<tr>
			<td colspan="3">
				<div id="div1"> </div>
                <div style="clear:both;">
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="45%" align="left" valign="middle"><input name="pdate1" type="text" class="datepick new_textbox100" id="pdate1" readonly="readonly" size="45" minlength="4"/></td>
                            <td width="30%" align="left" valign="middle"><input name="amt1" type="text" class="new_textbox100" id="amt1" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                            <td width="20%" align="left" valign="middle">&nbsp;<?php echo $res_currency[symbol];?></td>
                        </tr>
                    </table>
                </div>
				<input name="count" type="hidden" id="count" value="1" />
                <?php for($i=6; $i<15;$i++){?>
                <div id="div<?php echo $i;?>" style="display:none;">
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="45%" align="left" valign="middle"><input name="pdate<?php echo $i;?>" type="text" class="datepick new_textbox100" readonly="readonly" id="pdate<?php echo $i;?>" size="45" minlength="4"/></td>
                            <td width="29%" align="left" valign="middle"><input name="amt<?php echo $i;?>" type="text" class="new_textbox100" id="amt<?php echo $i;?>" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                            <td width="21%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                        </tr>
                    </table>
                </div>
			</td>
		</tr>
	</table>
</body>
</html>