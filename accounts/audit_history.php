<?php
ob_start();
session_start();
if(!isset($_COOKIE['cook_username']))
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
include_once '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

//Used currency
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

# auto delete blank values
$dbf->deleteFromTable("student_fee_edit_history", "chg_from='' And chg_to=''");

if($_REQUEST["action"] == "delete"){
	
	$dbf->deleteFromTable("student_fee_edit_history", "id='$_REQUEST[hid]'");
	
	header("Location:audit_history.php?centre_id=$_REQUEST[centre_id]");
	exit;
}
?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION["font"]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION["font"]=="small"){
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
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
		// pass the headers argument and assing a object 
		headers: { 
			// assign the secound column (we start counting zero) 
		  2: { 
				// disable it by setting the property sorter to false 
				sorter: false 
			},            
		} 
	})			
	.tablesorterPager({container: $("#pager"), size: 25});
	});
	</script>
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
                <td width="54%" height="30" class="logintext"><?php echo constant("STUDENT_AUDITDATA");?></td>
                <td width="22%" height="30">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" valign="top" align="left">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="1%" align="left" valign="middle">&nbsp;</td>
                      <td width="6%" height="30" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> : &nbsp;</td>
                      <td width="15%" align="left" valign="middle">
                        <select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:150px;">
                          <option value="">--Select--</option>
                          <?php
						foreach($dbf->fetchOrder('centre',"","name") as $valc) {
					  ?>
                          <option value="<?php echo $valc["id"];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="" <?php } ?>><?php echo $valc["name"];?></option>
                          <?php
					   }
					   ?>
                          </select></td>
                      <td width="10%" align="right" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :&nbsp;</td>
                      <td width="12%" align="left" valign="middle"><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST["fname"];?>"></td>
                      <td width="6%" align="right" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :&nbsp;</td>
                      <td width="12%" align="left" valign="middle"><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST["email"];?>"></td>
                      <td width="9%" align="right" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :&nbsp;</td>
                      <td width="14%" align="left" valign="middle"><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST["mobile"];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="15%" align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                      </tr>
                    </table>
                </td>
                </tr>              
            </table>            
            </td>
          </tr>
          <tr>
            <td align="center" valign="middle">
            <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
                <tr class="logintext">
                  <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_ALERT1_MANAGE_DATE");?></th>
                  <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext">Field Name</th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext">Change From</th>
                  <th width="13%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext">Change To</th>
                  <th width="29%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext">Student Name</th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color = "#ECECFF";
					
					$condition = '';
					$centre_id = $_REQUEST["centre_id"];
					//Concate the Condition
					//1.
					if($_REQUEST["fname"]!='' && $_REQUEST["mobile"]=='' && $_REQUEST["email"]==''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') And s.centre_id='$centre_id'";
					}else if($_REQUEST["fname"]=='' && $_REQUEST["mobile"]!='' && $_REQUEST["email"]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST["fname"]=='' && $_REQUEST["mobile"]=='' && $_REQUEST["email"]!=''){
						$condition = "s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST["fname"]!='' && $_REQUEST["mobile"]!='' && $_REQUEST["email"]==''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST["fname"]!='' && $_REQUEST["mobile"]=='' && $_REQUEST["email"]!=''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST["fname"]=='' && $_REQUEST["mobile"]!='' && $_REQUEST["email"]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST["fname"]!='' && $_REQUEST["mobile"]!='' && $_REQUEST["email"]!=''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST["fname"]=='' && $_REQUEST["mobile"]!='' && $_REQUEST["email"]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST["fname"]=='' && $_REQUEST["mobile"]=='' && $_REQUEST["email"]==''){
						$condition = "s.id>'0' And s.centre_id='$centre_id'";
					}
					//End 4.
					//echo $condition;
					$num=$dbf->countRows('student s, student_fee_edit_history h',"s.id=h.student_id And ".$condition);
					foreach($dbf->fetchOrder('student s, student_fee_edit_history h',"s.id=h.student_id And ".$condition, "","h.*") as $alerts){
						$user = $dbf->strRecordID("user","*","id='$alerts[by_user]'");
						$student = $dbf->strRecordID("student","*","id='$alerts[student_id]'");
					?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" >                  
                  <td align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d/m/Y h:i A',strtotime($alerts[date_time]));?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $alerts[fld_name];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $alerts[chg_from];?></td>                  
                  <td align="left" valign="middle"><?php echo $alerts[chg_to];?></td>                  
                  <td align="left" valign="middle"><a href="single-home.php?student_id=<?php echo $alerts[id];?>"><?php echo $student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($alerts["id"]));?></a></td>                  
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
          <?php if($num > 0) { ?>
          <tr>
            <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
              </table>
            </td>
          </tr>
          <?php
			   }
				if($num==0)
				{
				?>
			<tr>
			  <td height="25" colspan="13" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
			</tr>
			<?php
				}
				?>
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
