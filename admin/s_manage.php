<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

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
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 25});
	});
	</script>
<!--*******************************************************************-->
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

function openWindow( page )
{
	window.open(page, '_blank');
	window.focus();
}
</script>
<script type="text/javascript">
function gotfocus()
{
  document.getElementById('fname').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>),gotfocus();">
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
		
		<form id="frm" name="frm" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
			
			
			<table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="13%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_S_MANAGE_SEARCH_STUDENT");?></td>
                  <td width="15%" id="lblname">&nbsp;</td>
                  <td width="9%" align="left">&nbsp;</td>
                  <td width="16%" align="left">&nbsp; </td>
                  <td width="47%" align="left"><a href="news_add.php"></a></td>
                </tr>
                <tr>
                  <td height="36" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" ><table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="79" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("ADMIN_S_MANAGE_FIRSTNAME");?> :</td>
                      <td width="106" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="77" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?> :</td>
                      <td width="133" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="73" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("ADMIN_S_MANAGE_MOBILENO");?> :</td>
                      <td width="125" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="53" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("ADMIN_S_MANAGE_EMAIL");?> :</td>
                      <td width="138" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="145" align="right" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1" border="0" align="left" /></td>
                    </tr>
                  </table></td>
                  </tr>
            </table>
			
			</td>
          </tr>
		  
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
			
			
			<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000"  class="tablesorter" id="sort_table" >
			<thead>
                <tr class="logintext">
                  <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTNAME");?></th>
                  <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></th>
                  <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_MOBILENO");?></th>
                  <th width="27%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></th>
                  <th colspan="3" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                </tr>
				</thead>
                <?php
					
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "email LIKE '$_REQUEST[email]%'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE  '$_REQUEST[stid]%' AND email LIKE '%$_REQUEST[email]%'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE  '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "id>0";
					}
					//End 4.
					
					$i = 1;
					$color = "#ECECFF";
					$num=$dbf->countRows('student',$condition);
					foreach($dbf->fetchOrder('student',$condition,"id DESC") as $val){
					 $valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");
					
					?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                  <td align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val[id];?>" style="cursor:pointer;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[student_id];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[email];?></td>
                  <td width="5%" align="center" valign="middle" class="contenttext">
                  <a href="authonication.php?student_id=<?php echo $val[id];?>" onClick="javascript:openWindow(this.href);return false;" >
                  <img src="../images/home.png" width="16" height="16" border="0" title="<?php echo ICON_STUDENT_HOME ?>"></a></td>
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
			
			</td>
          </tr>
		   <?php
					if($num!=0)
					{
					?>
                
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option  value="10">10</option>
                    <option selected="selected" value="25">25</option>
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
                <td height="25" colspan="8" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
              <?php
					}
					?>
              <tr>
                <td height="25" colspan="7" align="center" valign="middle" class="no_record"></td>
              </tr>
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
