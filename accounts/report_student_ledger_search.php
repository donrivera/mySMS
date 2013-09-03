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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');

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
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->
<script type="text/javascript" language="javascript">
function PhoneNo(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90))){
		return false;
	}else{
		return true;
	}
}
function openWindow(page){
	window.open(page, '_blank');
	window.focus();
}
function gotfocus(){
  document.getElementById('fname').focus();
}
</script>
<body onLoad="gotfocus();">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
          5: { 
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
		
		<form id="frm" name="frm" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
			<table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="13%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_SEARCH_SEARCHSTUDENT");?></td>
                  <td width="15%" id="lblname">&nbsp;</td>
                  <td width="9%" align="left">&nbsp;</td>
                  <td width="48%" align="left">&nbsp;</td>
                  <td width="15%" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td height="36" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >
                  <table width="100%" height="80" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu" ><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> :</td>
                      <td height="36" align="left" valign="middle" bgcolor="#FFFFFF" >
                      <select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">-- Centre --</option>
							<?php
                            foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
                            ?>
							<option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
							<?php
							   }
							   ?>
                      </select></td>
                      <td height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
                      <td height="36" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      <td height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
                      <td height="36" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      <td height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
                      <td height="36" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="82" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu" ><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :</td>
                      <td width="140" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="93" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?> :</td>
                      <td width="107" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="80" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :</td>
                      <td width="110" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="50" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :</td>
                      <td width="116" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="151" align="right" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                    </tr>
                  </table></td>
                  </tr>
            </table>
			
			</td>
          </tr>
		  
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
			
			
			<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA"  class="tablesorter" id="sort_table" >
			<thead>
                <tr>
                  <th width="4%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                  <th width="27%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTNAME");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></th>
                  <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></th>
                  <th width="26%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAILADDRESS");?></th>
                  <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("COMMON_ACTION");?></th>
                  </tr>
				</thead>
                <?php
					
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "student_id LIKE '$_REQUEST[stid]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "email LIKE '$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%') OR student_first_name LIKE '$_REQUEST[fname]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE  '$_REQUEST[stid]%' AND email LIKE '%$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE  '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$_REQUEST[centre_id]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "id>'0' And centre_id='$_REQUEST[centre_id]'";
					}
					//End 4.
					
					$i = 1;
					$color = "#ECECFF";
					$num=$dbf->countRows('student',$condition);
					foreach($dbf->fetchOrder('student',$condition,"id DESC") as $val){
						$num_comment=$dbf->countRows('student_comment',"student_id='$val[id]'");
					?>
                <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;" >
                  <td align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val[id];?>"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php if($val[student_id] > 0) { echo $val[student_id]; } ?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
                  <?php
				  $numg=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
				  ?>
                  <td width="8%" align="center" valign="middle">
                  <a href="report_student_ledger.php?student_id=<?php echo $val[id]; ?>"><img src="../images/course.png" width="20" height="20" border="0" title="View Ledger"></a></a></td>
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
			if($num!=0){
			?>                
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option value="10">10</option>
                    <option selected="selected" value="25">25</option>
                    <option value="50">50</option>
                  </select>
                </div></td>
              </tr>
			    <?php
				}
				if($num==0){
				?>
              <tr>
                <td height="25" colspan="8" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
              <?php
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
