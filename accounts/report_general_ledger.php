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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

//echo $s = date('H:i:s',strtotime("3:30 PM"));

include_once '../includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
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
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( "#start_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#end_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<!--UI JQUERY DATE PICKER-->
<script type="text/javascript">
$(function() 
{
	$("#sort_table1")
		.tablesorter({ 
						// pass the headers argument and assing a object 
						headers: 
						{ 
							0:{sorter: false}, 
							1:{sorter: false},
							2:{sorter:false},
							//2:{sorter: "text"},
							3:{sorter: false},
							4:{sorter: false}, 
							5:{sorter: false}, 
							6:{sorter: false},
							7:{sorter: false}, 
							8:{sorter: false},
							9:{sorter: false}, 
							10:{sorter: false}, 
						} 
					})			
		.tablesorterPager({container: $("#pager"),size: $(".pagesize option:selected").val()});
});
</script>
<!--*******************************************************************-->

<script type="text/javascript">
function show_details(a){
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display==''){
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="../images/plus.gif" alt="Loading" />';
	}else{
		document.getElementById(a).style.display='';
		document.getElementById(arrow).innerHTML='<img src="../images/minus.gif" alt="Loading" />';
	}
}
</script>
<!--
<script language="javascript" type="text/javascript">
function setvalue(pid,sid,cid,type,val){
	
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
			document.getElementById('lblset').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblset').innerHTML=c;
		}
	}

	ajaxRequest.open("GET", "group_course_process.php?action=setstatus&" + "&pid=" + pid + "&sid=" + sid + "&cid=" + cid + "&type=" + type + "&val=" + val, true);
	ajaxRequest.send(null); 
}
</script>
-->
<script type="text/javascript">
function gotfocus(){
  document.getElementById('name').focus();
}
</script>

</head>
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
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <form name="frm" id="frm" method="post">
    <table width="98%" border="0" cellpadding="0" cellspacing="0">
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="15%" height="30" align="left" class="logintext"><?php echo "Ledger";?></td>
                <td width="20%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="30%" align="right" valign="middle" class="logintext">Accounts : &nbsp;</td>
							<td width="40%" align="left" valign="middle">
								<?php
								/*
								<select name="cost_center" id="cost_center" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" ><!--onChange="javascript:document.frm.action='report_journal.php',document.frm.submit();"-->
									<option value="">--Select--</option>
									<option value="All"<?=($_REQUEST['cost_center']=='All'?"selected":"")?>>-- All --</option>
									<?php
										$cost_center=$dbf->genericQuery("SELECT id,name FROM centre ORDER BY id");
										foreach($cost_center as $cost_ctr):
											$ctr_name=explode('-',$cost_ctr['name']);
									?>
									<option value="<?=$cost_ctr['id']?>" <?=($_REQUEST['cost_center']==$cost_ctr['id']?"selected":"")?>><?=$ctr_name[0]?></option>
									<?php 
										endforeach;
									?>
								</select>
								*/?>
								<?php $dbf->selectAcctChart("accounts","All")?>
							</td>
						</tr>
					</table>
				</td>
                <td width="23%" align="left" class="logintext">
				 <?php 
						if($_REQUEST[start_date]!='')
						{
							$start_date = $_REQUEST[start_date];
						}else{$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));}
						if($_REQUEST[end_date]!='')
						{
							$end_date = $_REQUEST[end_date];
						}else{$end_date = $dbf->MonthLastDay(date('m'),date('Y'));}
				?>
					<?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> :&nbsp;
					<input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/>
					<?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> :&nbsp;
					 <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/>
					<!--
						Search:<input type="text" name="search_group"/>
					-->
				</td>
                <td width="7%" align="left">
					<!--
					<input type="submit" value="Search" class="btn1" border="0" align="left" />
					-->
				</td>
                <td width="14%" align="left">
					
					<input type="submit" value="Search" class="btn1" border="0" align="left" />
					
				</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
              <thead>
                <tr class="logintext">
                  <th width="1%" height="6%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                  <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo "Date";?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo "Accounts";?></th>
                 
                </tr>
              </thead>
              <?php
			     $k=1;
					$i = 1;
					$color = "#ECECFF";
					//echo var_dump($_REQUEST['accounts']);
					$accounts=$_REQUEST['accounts'];
					$from=$_REQUEST[start_date];
					$to=$_REQUEST[end_date];
					if($accounts=='All')
					{$cond="transaction_cost_center IN(1,2,3,4,5)";}
					elseif($accounts=='')
					{$cond="";}
					else
					{
						//$cond="transaction_cost_center='$center' AND (transaction_date BETWEEN '$from' And '$to')";
						$cond="((a.account_number='$accounts' OR a.parent_account_number='$accounts') AND (t.transaction_date BETWEEN '$from' And '$to'))";
						
					}
					/*
					if( preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])',$accounts)) 
					{ 
						//echo('Has numbers and letters.');
						$student_transaction=preg_replace('/[^0-9,.]+/i', '', $accounts);
						$sql=$dbf->genericQuery("
												SELECT a.account_number as id,a.account_name,l.transaction_id,l.entry_description,t.transaction_date
												FROM  acct_chart_accounts a
												INNER JOIN acct_general_ledger l ON l.account_number=a.account_number
												INNER JOIN acct_financial_transactions t ON t.id=l.transaction_id
												WHERE ((l.transaction_id='$student_transaction') AND (t.transaction_date BETWEEN '$from' And '$to'))
												GROUP BY a.account_number,t.transaction_date
												ORDER BY l.id
											");
					} 
					else 
					{
						$sql=$dbf->genericQuery("
												SELECT a.account_number as id,a.account_name,l.transaction_id,l.entry_description,t.transaction_date
												FROM  acct_chart_accounts a
												INNER JOIN acct_general_ledger l ON l.account_number=a.account_number
												INNER JOIN acct_financial_transactions t ON t.id=l.transaction_id
												WHERE $cond
												GROUP BY a.account_number,t.transaction_date
												ORDER BY l.id
											");
					}
					*/
					$sql=$dbf->genericQuery("
												SELECT a.account_number as id,a.account_name,l.transaction_id,l.entry_description,t.transaction_date
												FROM  acct_chart_accounts a
												INNER JOIN acct_general_ledger l ON l.account_number=a.account_number
												INNER JOIN acct_financial_transactions t ON t.id=l.transaction_id
												WHERE $cond
												GROUP BY a.account_number,t.transaction_date
												ORDER BY l.id
											");
					//Get number of rows
                    //$num=$dbf->countRows('acct_financial_transactions',"id='1'".$cond,"");
					$num=count($sql);
					$num_dtls=count($sql);
					
					//Loop start
					foreach($sql as $val)
					{
					?>
					<tr bgcolor="<?php echo $color;?>" onmouseover="this.bgColor='#FDE6D0'" onmouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
						<td width="1%" height="6%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span> </a></td>
						<td width="3%" height="25" align="center" valign="middle" class="mycon"><?=$val['transaction_date']; ?></td>
						<td width="11%" align="center" valign="middle" class="mycon" style="padding-left:5px;">
							<?=$val['account_name']; ?>
						</td>
               
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
					?>
					</tr>
					<tr style="display:none;" id="<?php echo $val[id];?>">
						<td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
						<td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
						<td height="25" colspan="9" align="left"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
						<?php 
							if($num_dtls <=0 ) 
							{ 
						?>
								<table width="400" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
									<tr>
										<td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">
											&nbsp;&nbsp;<?php echo constant("ADMIN_VIEW_GROUP_HISTORY_TEXT2");?>
										</td>
									</tr>
								</table>
						<?php
							}
							else
							{	
						?>
								<table width="900" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
									<tr class="pedtext">
										<!--<td width="4%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo "Account Name";?></td>-->
										<td width="10%" height="25" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo "Debit";?></td>
										<td width="10%" height="25" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo "Credit";?></td>
										<!--<td width="10%" height="25" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo "Balance";?></td>-->
									</tr>
									<?php
										//Get currency
										$color1="#ECECFF";
										$j=1;
										$sql1=$dbf->genericQuery("SELECT * FROM acct_general_ledger WHERE account_number='$val[id]'  ORDER BY id");
							
										foreach($sql1 as $valinv)
										{	//$pay_type=$val['transaction_type_code'];
											$is_student = 1;					
											if($is_student > 0)
											{
									?>
									<?php 
												$amount=$valinv['entry_amount'];
												$dr=($valinv['entry_amount']<=0?$valinv['entry_amount']:"");
												$cr=($valinv['entry_amount']>=0?$valinv['entry_amount']:"");
												$dr_amount=number_format(abs($dr),2);
										
									?>
									<tr bgcolor="<?php echo $color1;?>" onmouseover="this.bgColor='#FDE6D0'" onmouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
										<!--
										<td align="center" valign="middle">
											<?=$dbf->getDataFromTable("acct_chart_accounts","account_name","account_number='".$valinv['account_number']."'");?>
										</td>
										-->
										<td height="25" align="center" valign="middle"><?=($dr_amount==0)?"":$dr_amount;?></td>
										<td align="center" valign="middle"><?=($cr==0)?"":$cr;?></td>
										<!--<td align="center" valign="middle">-->
											<?php 
												$sum +=$cr + -abs($dr);
												//echo number_format($sum,2);
											?>
										<!--</td>-->
									</tr>
									<?php
											if($color1=="#ECECFF"){$color1 = "#FBFAFA";}else{$color1="#ECECFF";}						
											}
								$j++;
										}
									?>
								<tr>
									<td align="center">Total:</td>
									<td align="center"><?=number_format($sum,2)?></td>
								</tr>
								</table>
						<?php
							}
						?>
						</td>
					</tr>
              <?php
					$k++;
					}
				?>
            </table>
			</td>
          </tr>
		  <?php
			if($num!=0)
			{
			?>             
          <tr>
              <td height="300" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                  <td width="76%" align="center">&nbsp;</td>
                  <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                    <input name="text" type="text" class="pagedisplay trans" size="5" readonly="readonly" style="border:solid 1px; border-color:#FFCC00;"/>
                    <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                    <select name="select" class="pagesize">
                      <option  value="20" selected="selected">10</option>
                      <option  value="40">20</option>
					  <option  value="60">30</option>
					</select>
                  </div></td>
                </tr>
                <?php
			   }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php
					}
					?>
                
              </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php }?>
</body>
</html>
