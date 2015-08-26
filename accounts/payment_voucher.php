<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
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
<script type="text/javascript" src="dropdowntabs.js"></script>

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">
<script type="text/javascript" src="../modal/thickbox.js"></script>
<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
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
	$(document).ready(function() 
	{
		$("#frm").validationEngine()
		//$.validationEngine.loadValidation("#date")
		//alert($("#formID").validationEngine({returnIsValid:true}))
		//$.validationEngine.buildPrompt("#date","This is an example","error")	 		 // Exterior prompt build example
		//$.validationEngine.closePrompt(".formError",true) 							// CLOSE ALL OPEN PROMPTS
	});
	// JUST AN EXAMPLE OF CUSTOM VALIDATI0N FUNCTIONS : funcCall[validate2fields]
	function validate2fields()
	{
		if($("#firstname").val() =="" ||  $("#lastname").val() == ""){return false;}else{return true;}
	}
	$(function() 
	{
		$( ".datepick" ).datepicker(
		{
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>	
<!--JQUERY VALIDATION ENDS-->
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
        <td width="79%" align="left" valign="top" style="border:solid 1px; border-color:#999; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><!----></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="view_payment_voucher.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                  <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28"></td>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext">Payment Voucher</span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="voucher_process.php?action=payment" name="frm" method="post" id="frm">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" >
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<?php
											//$pay_voucher=$dbf->genericQuery("SELECT COUNT(*) FROM acct_financial_transactions");
											$pay_voucher=$dbf->getDataFromTable("acct_financial_transactions","COUNT(id)","id !='' AND transaction_type_code='PM'");
											$pay_voucher +=1;
										if($_REQUEST['msg']=='duplicate'):
											echo "<font color='red'>Duplicate Entry...</font>";
										else:
										?>
										No.<input type="text" name="payment_voucher_id" value="<?=$pay_voucher?>"/>
										<?php 
										endif;
										?>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>Date:</td>
									<td><?=date("d/m/Y")?></td>
									<td>
										Amount<input type="text" name="amount"/>
									</td>
								</tr>
								<tr>
									<td>
										Paid For Mr./Ms./s: 
										
									</td>
									<td colspan="2">
										<select width="50" name="party_code">
											<option>Select From List/s&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<?php
												$parties=$dbf->genericQuery("SELECT id,party_name FROM acct_parties");
												foreach($parties as $party):
											?>
											<option value="<?=$party['id']?>"><?=$party['party_name']?></option>
											<?php endforeach;?>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										The Sum Of S.R.:
									</td>
									<td colspan="2"><input type="text" name="amount_words"/></td>
								</tr>
								<tr>
									<td>
										Being:
									</td>
									<td colspan="2"><input type="text" name="amount_words"/></td>
								</tr>
								<tr>
									<td>
										Bank Name:
									</td>
									<td colspan="2">
										<select name="bank_code" width="50">
											<option>Select Bank List/s&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											
											<?php
												$bank=$dbf->genericQuery("SELECT id,bank_name FROM acct_bank");
												foreach($bank as $bnk):
											?>
											<option value="<?=$bnk['id']?>"><?=$bnk['bank_name']?></option>
											<?php endforeach;?>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										Account No:
									</td>
									<td colspan="2"><input type="text" name="acct_no"/></td>
								</tr>
								<tr>
									<td>
										Check No:
									</td>
									<td colspan="2"><input type="text" name="check_no"/></td>
								</tr>
								<tr>
									<td>
										Type of Check:
									</td>
									<td colspan="2">
										<?php
											$rd_cash=$dbf->getDataFromTable("acct_chart_accounts","account_number","account_name='Cash in Hand'");
											$rd_check=$dbf->getDataFromTable("acct_chart_accounts","account_number","account_name='Checks Under Payment'");
											$rd_bank=$dbf->getDataFromTable("acct_chart_accounts","account_number","account_name='Other Creditors'");
										?>
										<input type="radio" name="check_type" value="<?=$rd_cash?>">Cash<br/>
										<input type="radio" name="check_type" value="<?=$rd_check?>">Check<br/>
										<input type="radio" name="check_type" value="<?=$rd_bank?>">Bank Transfer
									</td>
								</tr>
								<tr>
									<td>
										Choose from List: 
										
									</td>
									<td colspan="2">
									<select width="50">
											<option>Select From List/s&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										Date:
									</td>
									<td colspan="2"><input type="text" name="choose_calendar" class="datepick"/></td>
								</tr>
								<tr>
									<td>
										Amount Transfer:
									</td>
									<td colspan="2"><input type="text" name="amt_transfer"/></td>
								</tr>
								<tr>
									<td>
										Currency Transfer:
									</td>
									<td colspan="2"><input type="text" name="cur_transfer"/></td>
								</tr>
								<tr>
									<td>
										IBAN No.:
									</td>
									<td colspan="2"><input type="text" name="iban_no"/></td>
								</tr>
								<tr>
									<td colspan="3">
											Accounting Directive:<br/>
											<table border="1">
												<tr>
													<td>Value</td>
													<td>Description</td>
													<td>Debit Account</td>
													<td>Type of Document</td>
													<td>Document Source</td>
													<td>Cost Center</td>
												</tr>
												<tr>
													<td><input type="text" name="acc_dir_value[]"/></td>
													<td><input type="text" name="acc_dir_desc[]"/></td>
													<td>
														<?php $dbf->selectAcctChart("acc_dir_no[]","D")?>
													</td>
													<td><select name="acc_dir_doc_type[]"><option>Type</option></select></td>
													<td><input type="text" name="acc_dir_doc_src[]"/></td>
													<td>
														<select  name="acc_dir_cost_ctr[]">
															<option>Cost Center</option>
															<?php
																$cost_center=$dbf->genericQuery("SELECT id,name FROM centre ORDER BY id");
																foreach($cost_center as $cost_ctr):
																	$ctr_name=explode('-',$cost_ctr['name']);
															?>
															
															<option value="<?=$cost_ctr['id']?>"><?=$ctr_name[0]?></option>
															<?php endforeach;?>
														</select>
													</td>
												</tr>
												<tr>
													<td><input type="text" name="acc_dir_value[]"/></td>
													<td><input type="text" name="acc_dir_desc[]"/></td>
													<td>
														<?php $dbf->selectAcctChart("acc_dir_no[]","C")?>
													</td>
													<td><select name="acc_dir_doc_type[]"><option>Type</option></select></td>
													<td><input type="text" name="acc_dir_doc_src[]"/></td>
													<td>
														<select  name="acc_dir_cost_ctr[]">
															<option>Cost Center</option>
															<?php
																$cost_center=$dbf->genericQuery("SELECT id,name FROM centre ORDER BY id");
																foreach($cost_center as $cost_ctr):
																	$ctr_name=explode('-',$cost_ctr['name']);
															?>
															
															<option value="<?=$cost_ctr['id']?>"><?=$ctr_name[0]?></option>
															<?php endforeach;?>
														</select>
													</td>
												</tr>
												<tr>
													<td>Total:<input type="text" name="total_amount"/></td>
												</tr>
											</table>
									</td>
								</tr>
								<tr>
									<td>
										<BR/>
										Memo:
									</td>
									<td colspan="3"><BR/><textarea rows="4" cols="50" name="remarks"></textarea></td>
								</tr>
								<tr>
									<td></td>
									<td><br/><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
									<td></td>
									<td></td>
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
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_PAYMENT_MANAGE_NEWPAYMENT");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="voucher_process.php?action=payment" name="frm" method="post" id="frm">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" >\
								<!--
								<tr>
									<td width="33%" height="30">&nbsp;</td>
									<td width="1%">&nbsp;</td>
									<td width="30%">&nbsp;</td>
									<td width="1%">&nbsp;</td>
									<td width="25%">&nbsp;</td>
									<td width="10%">&nbsp;</td>
								</tr>
								<tr>
									<td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
									<td>&nbsp;</td>
									<td align="right" valign="middle"><input name="name" type="text" class="validate[required] new_textbox1" id="name" value=""/></td>
									<td>&nbsp;</td>
									<td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_PAYMENT_MANAGE_PAYMENTTYPE");?></td>
									<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								</tr>
								<tr>
									<td height="30" colspan="6" align="left" valign="middle"></td>
								</tr>
								<tr>
									<td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
									<td>&nbsp;</td>
									<td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
									<td>&nbsp;</td>
									<td align="left" valign="middle">&nbsp;</td>
									<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								</tr>
								<tr>
								<td height="10" colspan="6" align="left" valign="middle"></td>
								</tr>
								-->
								<tr>
								<td></td>
								<td>Payment Voucher</td>
								<td></td>
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
