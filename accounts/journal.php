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
	//$("#frm").validationEngine()
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
function add(){
	var x = document.getElementById('count').value;
	var z='div'+x;
	document.getElementById(z).style.display = "block";
	x++;
	
	document.getElementById('count').value = x;
}
function del(){
		
	var x = document.getElementById('count').value;

	if(x==2){
		alert("You can not delete default row.");
		return false;
	}
	x = x - 1;
	var z='div'+x;
	document.getElementById(z).style.display = "none";	
	document.getElementById('count').value = x;
}
</script>
<script>
// we used jQuery 'keyup' to trigger the computation as the user type
$('.deb').keyup(function () 
{
	// initialize the sum (total price) to zero
    var sum = 0;
    // we use jQuery each() to loop through all the textbox with 'price' class
    // and compute the sum for each loop
    $('.deb').each(function() {
        sum += Number($(this).val());
    });
     
    // set the computed value to 'totalPrice' textbox
    $('#total_deb').val(sum);
     
});
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
                <td width="8%" align="left"><a href="payment_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext">Journal Entry</span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="voucher_process.php?action=journal" name="frm" method="post" id="frm">
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
										$jrl_voucher=$dbf->getDataFromTable("acct_financial_transactions","COUNT(id)","id !='' AND transaction_type_code='JL'");
										$jrl_voucher +=1;
										if($_REQUEST['msg']=='duplicate'):
											echo "<font color='red'>Duplicate Entry...</font>";
										elseif($_REQUEST['msg']=='balance'):
											echo "<font color='red'>Debit/Credit Not Balanced...</font>";
										else:
										?>
										No.<input type="text" name="payment_voucher_id" value="<?=$jrl_voucher?>"/>
										<?php 
										endif;
										?>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>Date:</td>
									<td><?=date("d/m/Y")?></td>
									<td><input type="hidden" name="choose_calendar" value="<?=date("Y-m-d")?>"/></td>
								</tr>
								<tr>
									<td colspan="3">
											<div id="div1"> </div>
											<div style="clear:both;">
												<table border="1">
													<tr>
														<th>Debit</th>
														<th>Credit</th>
														<th>Account Name</th>
														<th>Description</th>
														<th>Documents</th>
														<th>Date</th>
														<th>Cost Center</th>
													</tr>
													<tr>
														<td><input type="text" name="deb[]" class="deb"/></td>
														<td><input type="text" name="cre[]" id="cre"/></td>
														<td>
															<!--
															<select name="acc_name[]">
																<option value="">Acc</option>
																<?php
																	$account=$dbf->genericQuery("	SELECT DISTINCT(account_name),id
																									FROM acct_chart_accounts
																									ORDER BY account_sign");
																	foreach($account as $acct):
																?>
																<option value="<?=$acct['id']?>"><?=$acct['account_name']?></option>
																<?php endforeach;?>
															</select>
															-->
															<?=$dbf->selectAcctChart("acc_dir_no[]","")?>
														</td>
														<td><input type="text" name="desc[]"/></td>
														<td>
															<select  name="document[]">
																<option value="">Documents</option>
															</select>
														</td>
														<td><input type="text" name="date[]"/></td>
														<td>
															<select  name="acc_dir_cost_ctr[]">
																<option value="">Cost Center</option>
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
														<td><input type="text" name="deb[]" class="deb"/></td>
														<td><input type="text" name="cre[]" id="cre"/></td>
														<td>
															<!--
															<select name="acc_name[]">
																<option value="">Acc</option>
																<?php
																	$account=$dbf->genericQuery("	SELECT DISTINCT(account_name),id
																									FROM acct_chart_accounts
																									ORDER BY account_sign");
																	foreach($account as $acct):
																?>
																<option value="<?=$acct['id']?>"><?=$acct['account_name']?></option>
																<?php endforeach;?>
															</select>
															-->
															<?=$dbf->selectAcctChart("acc_dir_no[]","")?>
														</td>
														<td><input type="text" name="desc[]"/></td>
														<td>
															<select  name="document[]">
																<option value="">Documents</option>
															</select>
														</td>
														<td><input type="text" name="date[]"/></td>
														<td>
															<select  name="acc_dir_cost_ctr[]">
																<option value="">Cost Center</option>
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
												</table>
											</div>
											<input name="count" type="hidden" id="count" value="2" />
											<?php for($i=2; $i<9;$i++){?>
											<div id="div<?=$i;?>" style="display:none;">
												<table border="1">
													<tr>
														<td><input type="text" name="deb[]" class="deb"/></td>
														<td><input type="text" name="cre[]" id="cre"/></td>
														<td>
															<!--
															<select name="acc_name[]">
																<option value="">Acc</option>
																<?php
																	$account=$dbf->genericQuery("	SELECT DISTINCT(account_name),id
																									FROM acct_chart_accounts
																									ORDER BY account_sign");
																	foreach($account as $acct):
																?>
																<option value="<?=$acct['id']?>"><?=$acct['account_name']?></option>
																<?php endforeach;?>
															</select>
															-->
															<?=$dbf->selectAcctChart("acc_dir_no[]","")?>
														</td>
														<td><input type="text" name="desc[]"/></td>
														<td>
															<select  name="document[]">
																<option value="">Documents</option>
															</select>
														</td>
														<td><input type="text" name="date[]"/></td>
														<td>
															<select  name="acc_dir_cost_ctr[]">
																<option value="">Cost Center</option>
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
												</table>
											</div>
											<?php }?>
											<table border="1">
												<tr>
													<td><input type="text" name="total_deb[]" id="total_deb" value="Total Debit"/></td>
													<td><input type="text" name="total_cre[]" id="total_cre" value="Total Credit"/></td>
												</tr>
												<tr>
													<td width="7%" align="center">
														<!--<img src="../images/plus-circle.png" width="20" height="20" onClick="add();"/>-->
														<a href="#" onClick="add();">Add New Line</a>
													</td>
													<td width="7%" align="center"><!--valign="middle" bgcolor="#000033"-->
														<!--<img src="../images/minus1.png" width="18" height="18" onClick="del();"/>-->
														<a href="#" onClick="del();">Remove Line</a>
													</td>
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
					<td></td>
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
