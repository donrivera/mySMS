<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Receptionist")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

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
<?php if($_SESSION[lang]=="EN"){?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
    <?php } else{?>
    <script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          0: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
    <?php }?>
<!--*******************************************************************-->

<!--------Phone Number Validation----------------->
<script type="text/javascript" language="javascript">
function PhoneNo(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90)))
	{
		return false;
	}
	else
	{
		return true;
	}
}

function gotfocus()
{
  document.getElementById('fname').focus();
}
</script>

<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger(){
    if(countdown_number > 0){
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0){
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){ ?>
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="54%" height="30" class="centercolumntext"> <?php echo constant("RECEPTION_S_MANAGE_VIEWSTUDENT");?></td>
                  <td width="22%" id="lblname">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp; </td>
                  <td width="8%" align="left"><a href="news_add.php"></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="62" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("RECEPTION_SEARCH_FIRSTNAME");?></td>
                      <td width="155" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox12" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="58" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("RECEPTION_SEARCH_STUDENTID");?></td>
                      <td width="149" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox12" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="56" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("RECEPTION_SEARCH_MOBILENO");?></td>
                      <td width="135" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox12" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="73" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("RECEPTION_SEARCH_EMAIL");?></td>
                      <td width="135" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox12" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="148" align="right" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1" border="0" align="left" /></td>
                    </tr>
                  </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
              <thead>
                <tr class="pedtext">
                  <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_S_MANAGE_STUDENTID");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_S_MANAGE_MOBILENO");?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_S_MANAGE_EMAILADDRESS");?></th>
                  <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_S_MANAGE_STUDENTCOMMENT");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_S_MANAGE_STATUS");?></th>
                </tr>
              </thead>
              <?php
			  	
				$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
					{
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
					{
						$condition = "student_id LIKE '$_REQUEST[stid]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
					{
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
					{
						$condition = "email LIKE '$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
					{
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
					{
						$condition = "first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
					{
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND email LIKE '$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
					{
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
					{
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
					{
						$condition = "student_id LIKE  '$_REQUEST[stid]%' AND email LIKE '%$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
					{
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
					{
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
					{
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}					
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
					{
						$condition = "student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
					{
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE  '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_SESSION[centre_id]' ";
					}
					else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
					{
						$condition = "id>0 And centre_id='$_SESSION[centre_id]' ";
					}
					//End 4.
					
			  	
				$color = "#ECECFF";
				$i = 1;
				$num=$dbf->countRows('student',$condition);
				foreach($dbf->fetchOrder('student',$condition,"first_name") as $val) {
				
				$valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");
			  ?>
              <tr class="mycon" bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[student_id];?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[email];?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[student_comment];?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $valc[name];?></td>
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
            </table></td>
          </tr>
          <?php
			if($num!=0)
			{
			?>
		
          <tr>
            <td bgcolor="#FFFFFF">
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
                <td height="25" colspan="8" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
              <?php
					}
					?>
              <tr>
                <td height="25" colspan="7" align="center" valign="middle" bgcolor="#F8F9FB" class="no_record"></td>
              </tr>
            </table>
            
            </td>
          </tr>
        </table>
        </form></td>
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
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        <form id="frm2" name="frm" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="14%" height="30" align="left"></td>
                  <td width="17%" id="lblname2">&nbsp;</td>
                  <td width="10%" align="left">&nbsp;</td>
                  <td width="41%" align="left">&nbsp;</td>
                  <td width="18%" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_SEARCH_SEARCHSTUDENT");?>&nbsp;</td>
                </tr>
                <tr>
                  <td height="36" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" ><table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_search");?>" class="btn2"/></td>
                      <td width="149" height="36" align="right" valign="middle" bgcolor="#FFFFFF" ><input name="fname2" type="text" class="new_textbox12" id="fname2" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="79" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?></td>
                      <td width="109" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="stid2" type="text" class="new_textbox12" id="stid2" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="93" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></td>
                      <td width="117" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="mobile2" type="text" class="new_textbox12" id="mobile2" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="87" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;: <?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></td>
                      <td width="115" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="email2" type="text" class="new_textbox12" id="email2" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="77" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;: <?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#FFFFFF">
              <table width="100%" border="1" cellpadding="0" bordercolor="#000000" cellspacing="0" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr class="logintext">
                  	<th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    <th width="14%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                    <th width="23%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:20px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?></th>
                    <th width="13%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:10px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTID");?></th>
                    <th width="18%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:20px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_MOBILENO");?></th>
                    <th width="24%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:20px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTNAME");?></th>
                    
                  </tr>
                </thead>
                <?php		
				$centre_id = $_SESSION['centre_id'];
			  	$condition = '';
				//Concate the Condition
				//1.
				if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
					$condition = "student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
					$condition = "student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
					$condition = "email LIKE '$_REQUEST[email]%'  And centre_id='$centre_id'";
				}
				//End 1.
				
				//2.
				else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
				}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
				}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
					$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
					$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
					$condition = "student_id LIKE  '$_REQUEST[stid]%' AND email LIKE '%$_REQUEST[email]%' And centre_id='$centre_id'";
				}
				//End 2.
				
				//3.
				else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$centre_id'";
				}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
				}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
					$condition = "student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
				}
				//End 3.
				
				//4.
				else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
					$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE  '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
				}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
					$condition = "id>'0' And centre_id='$centre_id'";
				}
				//End 4.
				
			  
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student',$condition);
				foreach($dbf->fetchOrder('student',$condition,"id DESC ") as $val){					 
					$num_comment=$dbf->countRows('student_comment',"student_id='$val[id]'");
					$valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");			 					
			  ?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='s_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">                
                  <td width="4%" align="center" valign="middle" ><?php echo $dbf->VVIP_Icon($val["id"]);?></td>
                  <td width="4%" align="center" valign="middle" >
                  <a href="authonication.php?student_id=<?php echo $val[id];?>" onClick="javascript:openWindow(this.href);return false;" >
                  <img src="../images/home.png" width="16" height="16" border="0" title="<?php echo ICON_STUDENT_HOME ?>"></a></td>                
                  <td align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-right:5px;"><?php echo $val[email];?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-right:5px;"><?php if($val[student_id] > 0) { echo $val[student_id]; } ?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-right:5px;"><?php echo $val[student_mobile];?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-right:5px;">
				  <?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>                  
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
              </table></td>
            </tr>
            <?php if($num!=0) {?>
            <tr>
              <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                  <td width="76%" align="center">&nbsp;</td>
                  <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first" title="Prev"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev" title="Prev"/>
                    <input name="text2" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                    <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                    <select name="select2" class="pagesize">
                      <option value="10">10</option>
                      <option selected="selected" value="25">25</option>
                      <option value="50">50</option>
                    </select>
                  </div></td>
                </tr>
                <?php
			   }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="8" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php
					}
					?>
                <tr>
                  <td height="25" colspan="7" align="center" valign="middle" bgcolor="#F8F9FB" class="no_record"></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    
    </td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
