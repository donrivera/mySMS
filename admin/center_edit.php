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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

$res = $dbf->strRecordID("centre","*","id='$_REQUEST[id]'");

include_once '../includes/language.php';

?>
	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big')
{
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

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]=='')
{
	$LANGUAGE = "EN";
}
else
{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN')
{
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR')
{
?>
<script src="js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>		
<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()
});

// JUST AN EXAMPLE OF CUSTOM VALIDATI0N FUNCTIONS : funcCall[validate2fields]
function validate2fields(){
	if($("#firstname").val() =="" ||  $("#lastname").val() == ""){
		return false;
	}else{
		return true;
	}
}

//Except Characters
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
</script>	
<!--JQUERY VALIDATION ENDS-->
<style>
/*input:focus, textarea:focus, select:focus{background-color:#FDE7C8;}*/
.combo190 {width:192px;font:Arial, Helvetica, sans-serif; font-size:8px; background-color:#ECF1FF;}
</style>
<script type="text/javascript" language="javascript">
function showclassroom()
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
			document.getElementById('showclass').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('showclass').innerHTML=c;
		}
	}

	var tno = document.getElementById('class').value;

	ajaxRequest.open("GET", "center_class.php" + "?tno=" + tno +"&cid="+ <?php echo $_REQUEST[id];?>, true);
	ajaxRequest.send(null); 
}

function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
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

function gotfocus()
{
	document.getElementById('name').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext">&nbsp; <?php echo constant("CENTER");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="center_manage.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <?php if($_REQUEST[msg]=="added") { ?>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                <tr>
                  <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                  <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                  <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("COMMON_RECORDADDMSG");?></td>
                </tr>
            </table></td>
          </tr>
          <?php } ?>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
             <?php if($_SESSION['lang']=='EN'){?>
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_CENTRE_MANAGE_EDITCENTRE");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="center_process.php?action=edit&amp;id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td width="2%">&nbsp;</td>
                          <td width="34%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="53%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="9%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?>: <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="name" type="text" class="validate[required] new_textbox190" id="name" value="<?php echo $res[name];?>" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <?php
                            $currentFile = $_SERVER["PHP_SELF"];
                            $parts = explode('/', $currentFile);
                            $page = $parts[count($parts) - 1];
							
							$cur = str_replace($page,'',$currentFile);
							$cur = str_replace('admin/','',$cur);
							$cur_file = $_SERVER['HTTP_HOST'].$cur.'selfservice'.$res["cen_no"].'.php';
							
							$link_file = $cur.'selfservice'.$res["cen_no"].'.php';
							
                          	$file_name = 'selfservice'.$res['cen_no'].'.php';
                            $file_path = '../'.$file_name;
                            if(file_exists($file_path)){   
                        ?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <?php
                          $centre = base64_encode(base64_encode($res["id"]));
						  ?>
                          <td align="left" valign="middle"><a href="<?php echo $link_file.'?centre_id='.$centre;?>" target="_blank"><?php echo $cur_file;?></a></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <?php
							}
							?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENO");?>: <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="no" type="text" class="validate[required] new_textbox190" id="no" size="45" minlength="4" value="<?php echo $res[cen_no];?>" onKeyPress="return isNumberKey(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRETELNO");?>: <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="tel_no" type="text" class="validate[required] new_textbox190" id="tel_no" size="45" value="<?php echo $res[cen_tel_no];?>" onKeyPress="return PhoneNo(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTREEMAILADD");?>: <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="email_add" type="text" class="validate[required,custom[email]] new_textbox190" id="email_add" size="45" minlength="4" value="<?php echo $res[cen_email];?>"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTREDIRECTORE");?>: <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="dir_name" type="text" class="validate[required] new_textbox190" id="dir_name" size="45" minlength="4" value="<?php echo $res[cen_dir_name];?>"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_INVOICESTART");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <input name="invoice_from" type="text" class="validate[required] new_textbox40" id="invoice_from" value="<?php echo $res[invoice_from];?>" maxlength="2" onKeyPress="return isNumberKey(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="top" class="leftmenu" style="padding-top:7px;"><span class="leftmenu" style="padding-top:7px;"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTREADDRESS");?></span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><table width="280">
                              <tr>
                                <td width="105" align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_STREET");?></td>
                                <td width="159"><input type="text" name="street" id="street" class="new_textbox190" value="<?php echo $res[street_name];?>" /></td>
                              </tr>
                              <tr>
                                <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_AREA");?></td>
                                <td><input type="text" name="area" id="area" class="new_textbox190" value="<?php echo $res[area];?>" /></td>
                              </tr>
                              <tr>
                                <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_PROVINCE");?></td>
                                <td><input type="text" name="province" id="province" class="new_textbox190" value="<?php echo $res[province];?>" /></td>
                              </tr>
                              <tr>
                                <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_COUNTRY");?></td>
                                <td><select name="country" id="country" class="combo190">
                                    <?php
					foreach($dbf->fetchOrder('countries',"","") as $resc) {
					  ?>
                                    <option value="<?php echo $resc['id']?>"<?php if($resc["id"]==$res["country"]) { echo "Selected"; }?>><?php echo $resc['value'] ?></option>
                                    <?php }?>
                                </select></td>
                              </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTREOPENING");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><table width="318">
                              <tr>
                                <td width="145" align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_NOUNITS");?></td>
                                <td width="80">
								<select name="unit" id="unit" class="combo80" >
                                    <option value="0">select</option>
                                    <?php
										for($i=1;$i<37;$i++) {
										  ?>
                                    <option value="<?php echo $i;?>" <?php if($i==$res["unit_day"]) { echo "Selected"; }?>><?php echo $i;?></option>
                                    <?php }?>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <?php
							   $ctime = explode(":",$res["start_time"]);
							   $ctime = $ctime[0];
							   ?>
                                <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_STARTTIME");?></td>
                                <td><select name="start_time" id="start_time" class="combo80">
                                    <option value="0" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?php echo $d;?>" <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
                                <?php
							   $ctime = explode(":",$res["start_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="start_time2" id="start_time2" class="combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="05" <?php if($ctime=="05") { echo "Selected"; }?>>05</option>
                                    <option value="10" <?php if($ctime=="10") { echo "Selected"; }?>>10</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="20" <?php if($ctime=="20") { echo "Selected"; }?>>20</option>
                                    <option value="25" <?php if($ctime=="25") { echo "Selected"; }?>>25</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="35" <?php if($ctime=="35") { echo "Selected"; }?>>35</option>
                                    <option value="40" <?php if($ctime=="40") { echo "Selected"; }?>>40</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                    <option value="50" <?php if($ctime=="50") { echo "Selected"; }?>>50</option>
                                    <option value="55" <?php if($ctime=="55") { echo "Selected"; }?>>55</option>
                                </select></td>
                              </tr>
                              <tr>
                                <?php
							   $ctime = explode(":",$res["end_time"]);
							   $ctime = $ctime[0];
							   ?>
                                <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_ENDTIME");?></td>
                                <td><select name="end_time" id="end_time" class="combo80">
                                    <option value="" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?=$d;?>"  <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
                                <?php
							   $ctime = explode(":",$res["end_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="end_time2" id="end_time2" class="combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="05" <?php if($ctime=="05") { echo "Selected"; }?>>05</option>
                                    <option value="10" <?php if($ctime=="10") { echo "Selected"; }?>>10</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="20" <?php if($ctime=="20") { echo "Selected"; }?>>20</option>
                                    <option value="25" <?php if($ctime=="25") { echo "Selected"; }?>>25</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="35" <?php if($ctime=="35") { echo "Selected"; }?>>35</option>
                                    <option value="40" <?php if($ctime=="40") { echo "Selected"; }?>>40</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                    <option value="50" <?php if($ctime=="50") { echo "Selected"; }?>>50</option>
                                    <option value="55" <?php if($ctime=="55") { echo "Selected"; }?>>55</option>
                                </select></td>
                              </tr>
                              <tr>
                                <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_CLASSSTART");?> : <span class="nametext1">*</span></td>
                                <?php
							   $ctime = explode(":",$res["class_start_time"]);
							   $ctime = $ctime[0];
							   ?>
                                <td><select name="s_starttime" id="s_starttime" class="validate[required] combo80">
                                    <option value="" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?=$d?>" <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
                                <?php
							   $ctime = explode(":",$res["class_start_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="s_starttime2" id="s_starttime2" class="validate[required] combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                </select></td>
                              </tr>
                              <tr>
                                <?php
							   $ctime = explode(":",$res["class_end_time"]);
							   $ctime = $ctime[0];
							   ?>
                                <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_CLASSEND");?> : <span class="nametext1">*</span></td>
                                <td><select name="s_endtime" id="s_endtime" class="validate[required] combo80">
                                    <option value="" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?=$d?>" <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
                                <?php
							   $ctime = explode(":",$res["class_end_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="s_endtime2" id="s_endtime2" class="validate[required] combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                </select></td>
                              </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_NOOFCLASSROOMS");?>: <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="class" type="text" class="validate[required] new_textbox40" id="class" value="<?php echo $res[cen_no_clas];?>" onKeyUp="showclassroom();" onKeyPress="return isNumberKey(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="showclass"><table width="333" cellpadding="2" cellspacing="0">
                              <tr class="logintext">
                                <th width="151" bgcolor="#003399" class="footertext" scope="col"><?php echo constant("ADMIN_CENTRE_MANAGE_CLASSROOM");?></th>
                                <th width="11" bgcolor="#003399" class="footertext" scope="col">&nbsp;</th>
                                <th width="155" align="center" bgcolor="#003399" class="footertext" scope="col"><?php echo constant("ADMIN_CENTRE_MANAGE_NUMBEROFCHAIRS");?></th>
                              </tr>
                              <?php
							   $i = 1;
							   foreach($dbf->fetchOrder('centre_room',"centre_id='$_REQUEST[id]'","id") as $val) {
							   ?>
                              <tr>
                                <th align="center" valign="middle" scope="col"><input name="c<?php echo $i;?>" type="text" class="new_textbox1 required" id="c<?php echo $i;?>" size="45" minlength="4" value="<?php echo $val[name];?>" /></th>
                                <th scope="col">&nbsp;</th>
                                <th align="center" valign="middle" scope="col"><input name="r<?php echo $i;?>" type="text" class="new_textbox1" id="r<?php echo $i;?>" size="45" minlength="4" value="<?php echo $val[no];?>"/></th>
                              </tr>
                              <?php $i++; } ?>
                              <tr>
                                <td colspan="3"><input type="hidden" id="count" name="count" value="<?php echo $i-1;?>" /></td>
                              </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                      </table>
                  </form>
                        
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5" align="left" valign="top"><img src="../images/bot_left.png" width="5" height="4" /></td>
                            <td width="100%" style="background:url(../images/bot_mid.png) repeat-x;"></td>
                            <td width="5" align="right" valign="top"><img src="../images/bot_right.png" width="5" height="4" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
            <?php }else{?>
			<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_CENTRE_MANAGE_EDITCENTRE");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="center_process.php?action=edit&amp;id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                         
                          <td width="7%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="58%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="31%">&nbsp;</td>
                          <td width="2%">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="name" type="text" class="validate[required] new_textbox190" id="name" value="<?php echo $res[name];?>" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                       
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="no" type="text" class="validate[required] new_textbox190" id="no" size="45" minlength="4" value="<?php echo $res[cen_no];?>" onKeyPress="return isNumberKey(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENO");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="tel_no" type="text" class="validate[required] new_textbox190" id="tel_no" size="45" value="<?php echo $res[cen_tel_no];?>" onKeyPress="return PhoneNo(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_CENTRETELNO");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="email_add" type="text" class="validate[required,custom[email]] new_textbox190" id="email_add" size="45" minlength="4" value="<?php echo $res[cen_email];?>"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_CENTREEMAILADD");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="dir_name" type="text" class="validate[required] new_textbox190" id="dir_name" size="45" minlength="4" value="<?php echo $res[cen_dir_name];?>"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_CENTREDIRECTORE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <input name="invoice_from" type="text" class="validate[required] new_textbox40" id="invoice_from" value="<?php echo $res[invoice_from];?>" maxlength="2" onKeyPress="return isNumberKey(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_INVOICESTART");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><table width="280">
                              <tr>                                
                                <td width="159"><input type="text" name="street" id="street" class="new_textbox190" value="<?php echo $res[street_name];?>" /></td>
								<td width="105" align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_STREET");?></td>
                              </tr>
                              <tr>                               
                                <td><input type="text" name="area" id="area" class="new_textbox190" value="<?php echo $res[area];?>" /></td>
								 <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_AREA");?></td>
                              </tr>
                              <tr>                                
                                <td><input type="text" name="province" id="province" class="new_textbox190" value="<?php echo $res[province];?>" /></td>
								<td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_PROVINCE");?></td>
                              </tr>
                              <tr>                                
                                <td><select name="country" id="country" class="combo190">
                                    <?php
									foreach($dbf->fetchOrder('countries',"","") as $resc) {
									  ?>
                                    <option value="<?php echo $resc['id']?>"<?php if($resc["id"]==$res["country"]) { echo "Selected"; }?>><?php echo $resc['value'] ?></option>
                                    <?php }?>
                                </select></td>
								<td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_COUNTRY");?></td>
                              </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="top"  class="leftmenu" style="padding-top:7px;"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTREADDRESS");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><table width="318">
                              <tr>                               
                                <td width="80">
								<select name="unit" id="unit" class="combo80" >
                                    <option value="0">select</option>
                                    <?php
										for($i=1;$i<37;$i++) {
										  ?>
                                    <option value="<?php echo $i;?>" <?php if($i==$res["unit_day"]) { echo "Selected"; }?>><?php echo $i;?></option>
                                    <?php }?>
                                  </select>
                                </td>
								<td>&nbsp;</td>
								<td width="145" align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_NOUNITS");?></td>
                              </tr>
                              <tr>
                                <?php
							   $ctime = explode(":",$res["start_time"]);
							   $ctime = $ctime[0];
							   ?>                               
                                <td><select name="start_time" id="start_time" class="combo80">
                                    <option value="0" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?php echo $d;?>" <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
								
                                <?php
							   $ctime = explode(":",$res["start_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="start_time2" id="start_time2" class="combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="05" <?php if($ctime=="05") { echo "Selected"; }?>>05</option>
                                    <option value="10" <?php if($ctime=="10") { echo "Selected"; }?>>10</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="20" <?php if($ctime=="20") { echo "Selected"; }?>>20</option>
                                    <option value="25" <?php if($ctime=="25") { echo "Selected"; }?>>25</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="35" <?php if($ctime=="35") { echo "Selected"; }?>>35</option>
                                    <option value="40" <?php if($ctime=="40") { echo "Selected"; }?>>40</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                    <option value="50" <?php if($ctime=="50") { echo "Selected"; }?>>50</option>
                                    <option value="55" <?php if($ctime=="55") { echo "Selected"; }?>>55</option>
                                </select></td>
								 <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_STARTTIME");?></td>
                              </tr>
                              <tr>
                                <?php
							   $ctime = explode(":",$res["end_time"]);
							   $ctime = $ctime[0];
							   ?>                                
                                <td><select name="end_time" id="end_time" class="combo80">
                                    <option value="" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?=$d;?>"  <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
                                <?php
							   $ctime = explode(":",$res["end_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="end_time2" id="end_time2" class="combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="05" <?php if($ctime=="05") { echo "Selected"; }?>>05</option>
                                    <option value="10" <?php if($ctime=="10") { echo "Selected"; }?>>10</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="20" <?php if($ctime=="20") { echo "Selected"; }?>>20</option>
                                    <option value="25" <?php if($ctime=="25") { echo "Selected"; }?>>25</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="35" <?php if($ctime=="35") { echo "Selected"; }?>>35</option>
                                    <option value="40" <?php if($ctime=="40") { echo "Selected"; }?>>40</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                    <option value="50" <?php if($ctime=="50") { echo "Selected"; }?>>50</option>
                                    <option value="55" <?php if($ctime=="55") { echo "Selected"; }?>>55</option>
                                </select></td>
								<td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_ENDTIME");?></td>
                              </tr>
                              <tr>                                
                                <?php
							   $ctime = explode(":",$res["class_start_time"]);
							   $ctime = $ctime[0];
							   ?>
                                <td><select name="s_starttime" id="s_starttime" class="combo80">
                                    <option value="" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?=$d?>" <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
                                <?php
							   $ctime = explode(":",$res["class_start_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="s_starttime2" id="s_starttime2" class="combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="05" <?php if($ctime=="05") { echo "Selected"; }?>>05</option>
                                    <option value="10" <?php if($ctime=="10") { echo "Selected"; }?>>10</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="20" <?php if($ctime=="20") { echo "Selected"; }?>>20</option>
                                    <option value="25" <?php if($ctime=="25") { echo "Selected"; }?>>25</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="35" <?php if($ctime=="35") { echo "Selected"; }?>>35</option>
                                    <option value="40" <?php if($ctime=="40") { echo "Selected"; }?>>40</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                    <option value="50" <?php if($ctime=="50") { echo "Selected"; }?>>50</option>
                                    <option value="55" <?php if($ctime=="55") { echo "Selected"; }?>>55</option>
                                </select></td>
								<td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_CLASSSTART");?></td>
                              </tr>
                              <tr>
                                <?php
							   $ctime = explode(":",$res["class_end_time"]);
							   $ctime = $ctime[0];
							   ?>                               
                                <td><select name="s_endtime" id="s_endtime" class="combo80">
                                    <option value="" >select</option>
                                    <?php
									for($i=1;$i<=23;$i++)
									{
									if($i<10)
									{
									$d="0".$i;
									}
									else
									{
									$d=$i;
									}																			
									?>
                                    <option value="<?=$d?>" <?php if($i==$ctime) { echo "Selected"; }?>>
                                    <?=$d?>
                                    </option>
                                    <?
									}
								?>
                                  </select>
                                </td>
                                <?php
							   $ctime = explode(":",$res["class_end_time"]);
							   $ctime = $ctime[1];
							   ?>
                                <td width="77" align="center" valign="middle">
                                <select name="s_endtime2" id="s_endtime2" class="combo80">
                                    <option value="">select</option>
                                    <option value="00" <?php if($ctime=="00") { echo "Selected"; }?>>00</option>
                                    <option value="05" <?php if($ctime=="05") { echo "Selected"; }?>>05</option>
                                    <option value="10" <?php if($ctime=="10") { echo "Selected"; }?>>10</option>
                                    <option value="15" <?php if($ctime=="15") { echo "Selected"; }?>>15</option>
                                    <option value="20" <?php if($ctime=="20") { echo "Selected"; }?>>20</option>
                                    <option value="25" <?php if($ctime=="25") { echo "Selected"; }?>>25</option>
                                    <option value="30" <?php if($ctime=="30") { echo "Selected"; }?>>30</option>
                                    <option value="35" <?php if($ctime=="35") { echo "Selected"; }?>>35</option>
                                    <option value="40" <?php if($ctime=="40") { echo "Selected"; }?>>40</option>
                                    <option value="45" <?php if($ctime=="45") { echo "Selected"; }?>>45</option>
                                    <option value="50" <?php if($ctime=="50") { echo "Selected"; }?>>50</option>
                                    <option value="55" <?php if($ctime=="55") { echo "Selected"; }?>>55</option>
                                </select></td>
								 <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_CENTRE_MANAGE_CLASSEND");?></td>
                              </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="top"> : <?php echo constant("ADMIN_CENTRE_MANAGE_CENTREOPENING");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="class" type="text" class="validate[required] new_textbox40" id="class" value="<?php echo $res[cen_no_clas];?>" onKeyUp="showclassroom();" onKeyPress="return isNumberKey(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_NOOFCLASSROOMS");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>                          
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="showclass"><table width="333" cellpadding="2" cellspacing="0">
                              <tr class="logintext">
                                <th width="151" bgcolor="#003399" class="footertext" scope="col"><?php echo constant("ADMIN_CENTRE_MANAGE_CLASSROOM");?></th>
                                <th width="11" bgcolor="#003399" class="footertext" scope="col">&nbsp;</th>
                                <th width="155" align="center" bgcolor="#003399" class="footertext" scope="col"><?php echo constant("ADMIN_CENTRE_MANAGE_NUMBEROFCHAIRS");?></th>
                              </tr>
                              <?php
							   $i = 1;
							   foreach($dbf->fetchOrder('centre_room',"centre_id='$_REQUEST[id]'","id") as $val) {
							   ?>
                              <tr>
                                <th align="center" valign="middle" scope="col"><input name="c<?php echo $i;?>" type="text" class="new_textbox1 required" id="c<?php echo $i;?>" size="45" minlength="4" value="<?php echo $val[name];?>" /></th>
                                <th scope="col">&nbsp;</th>
                                <th align="center" valign="middle" scope="col"><input name="r<?php echo $i;?>" type="text" class="new_textbox1" id="r<?php echo $i;?>" size="45" minlength="4" value="<?php echo $val[no];?>"/></th>
                              </tr>
                              <?php $i++; } ?>
                              <tr>
                                <td colspan="3"><input type="hidden" id="count" name="count" value="<?php echo $i-1;?>" /></td>
                              </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2" border="0" align="left" /></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                      </table>
                  </form>
                        
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5" align="left" valign="top"><img src="../images/bot_left.png" width="5" height="4" /></td>
                            <td width="100%" style="background:url(../images/bot_mid.png) repeat-x;"></td>
                            <td width="5" align="right" valign="top"><img src="../images/bot_right.png" width="5" height="4" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
			<?php }?>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
</body>
</html>
