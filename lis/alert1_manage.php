<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

?>	

<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION[font]=="small"){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}else{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          5: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },6: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },7: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },8: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },10: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
<!--*******************************************************************-->



<script language="javascript" type="text/javascript">
function setvalue(id,type,val)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			document.getElementById('lblname').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblname').innerHTML=c;
		}
	}

	ajaxRequest.open("GET", "link_process.php?action=setstatus&" + "&id=" + id + "&type=" + type + "&val=" + val, true);
	ajaxRequest.send(null); 
}
function setvalue(id,type,val)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			document.getElementById('lblname').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblname').innerHTML=c;
		}
	}

	ajaxRequest.open("GET", "alert1_process.php?action=setstatus&" + "&id=" + id + "&type=" + type + "&val=" + val, true);
	ajaxRequest.send(null); 
}
</script>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top">
        
        <form name="frm" id="frm" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_ALERT1_MANAGE_ALERTS_MANAGEMENT");?></td>
                <td width="22%" id="lblname">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="alert1_add.php">
				<input name="button" type="button" class="btn1" value="<?php echo constant("btn_add_btn");?>" align="left" border="0" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="3%" align="left" valign="middle">&nbsp;</td>
                <td width="9%" height="30" align="right" valign="middle" class="red_smalltext"><?php //echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?>&nbsp;</td>
                <td width="88%" align="left" valign="middle">&nbsp;</td>
              </tr>
            </table>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
                <tr class="logintext">
                  <th width="2%" height="33" align="center" valign="middle" bgcolor="#99CC99"></th>
                  <th width="7%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_DATE");?></th>
                  <th width="8%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_ALERTTYPE");?></th>
                  <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_IMPORTANTINFO");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_INFORMATION");?></th>
                  <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_CENTREDIRECTER");?></th>
                  <th width="6%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_STUDENTADV");?></th>
                  <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_RECEIPTION");?></th>
                  <th width="6%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_STUDENT");?></th>
                  <th width="5%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_TEACHER");?></th>
                  <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                </tr>
				</thead>
                <?php
					$i = 1;
					$color = "#ECECFF";
					$num=$dbf->countRows('alerts',"");
					foreach($dbf->fetchOrder('alerts',"","id DESC") as $val)
					{
						$valc = $dbf->strRecordID("common","*","id='$val[alert_id]'");					
					?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">                
                  <td height="25" align="center" valign="middle" class="contenttext" onClick="javascript:window.location.href='alert1_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;"><?php echo $i;?></td>
                  <td height="25" align="left" valign="middle" class="contenttext" onClick="javascript:window.location.href='alert1_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;"><?php echo $val[dt];?></td>
                  <td align="left" valign="middle" class="contenttext" onClick="javascript:window.location.href='alert1_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;"><?php echo $valc[name];?></td>
                  <td align="left" valign="middle" class="contenttext" onClick="javascript:window.location.href='alert1_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;"><?php echo $val[imp_info];?></td>
                  <td align="left" valign="middle" class="contenttext" onClick="javascript:window.location.href='alert1_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;"><?php echo $val[infor];?></td>
                  
                  <td align="center" valign="middle"><input name="cd" type="checkbox" id="cd" value="<?php echo $val[cen_dr];?>" <?php if($val[cen_dr]=="1"){?> checked="checked" <?php }?> onChange="setvalue(<?php echo $val[id];?>,'cd',this.checked)" /></td>
                  
                  <td align="center" valign="middle"><input name="sa" type="checkbox" id="sa" value="<?php echo $val[stu_ad];?>" <?php if($val[stu_ad]==1){?> checked="checked" <?php }?>  onchange="setvalue(<?php echo $val[id];?>,'sa',this.checked)" /></td>
                  
                  <td align="center" valign="middle"><input name="re" type="checkbox" id="re" value="<?php echo $val[rep];?>" <?php if($val[rep]==1){?>  checked="checked" <?php }?>  onchange="setvalue(<?php echo $val[id];?>,'re',this.checked)" /></td>
                  
                  <td align="center" valign="middle"><input name="st" type="checkbox" id="st" value="<?php echo $val[student];?>" <?php if($val[student]==1){?>  checked="checked" <?php }?>  onchange="setvalue(<?php echo $val[id];?>,'st',this.checked)" /></td>
                  
                  <td align="center" valign="middle"><input name="te" type="checkbox" id="te" value="<?php echo $val[teacher];?>" <?php if($val[teacher]==1){?> checked="checked" <?php }?>  onchange="setvalue(<?php echo $val[id];?>,'te',this.checked)" /></td>
                  
                  <td width="9%" align="center" valign="middle">
				  <?php if($val["status"]==0) { ?><a href="alert1_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to desable the News"></a><?php } else { ?><a href="alert1_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Enable the News"></a><?php } ?> </td>
                  
                  <td width="3%" align="center" valign="middle"><a href="alert1_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                  
                  <td width="3%" align="center" valign="middle"><a href="alert1_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
                  <?php
					  $i = $i + 1;
					   if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
					  }
					  ?>
                </tr>
              
                <tr>
                  <td height="25" colspan="13" align="center" valign="middle" bgcolor="#F8F9FB" ></td>
                </tr>
            </table>
			
			</td>
          </tr>
		   <?php
					if($num!=0)
					{
					?>
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
			   <?php
			   }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="13" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?
					}
					?>
             
            </table></td>
          </tr>
        </table>
        </form>
        
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
</body>
</html>
