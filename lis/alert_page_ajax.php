<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
	
			ob_clean();
			$VALUE=$_POST['val']; 
			$_POST['pagenumber']=0; 							
				$totalcount=$dbf->countRows("alerts","lis='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')");
				$perpage=1;
				$limitstart=$_POST['pagenumber'] * $perpage;
				$limitend=$perpage;
				$totalpage=ceil($totalcount/$perpage);	
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
        <script type="text/javascript">
		function pagination(url,val,page){	
		$.post(url,{"val":val,"pagenumber":page},function(res){	
		$('#response').html(res);
		});
		}
		</script>
		<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />       
		<body>
		<?php if($_SESSION['lang']=='EN'){?>
        
		<div style="width:550px;height:150px;" id="response">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			  <td width="3" align="left" valign="top">&nbsp;</td>
			  <td align="right" valign="top" bgcolor="#FF9900" style="padding-right:3px;">
              <?php if($_REQUEST["page_from"] == "dashboard"){ ?>
              <img src="../images/close.png" width="22" height="20" onClick="javascript:self.parent.tb_remove();" style="cursor:pointer;">
              <?php } ?>
			  </td>
			</tr>
			<tr>
			  <td width="3" align="left" valign="top">&nbsp;</td>
			  <td align="center" valign="top">&nbsp;</td>
			</tr>
			<tr>
				<td height="1" colspan="3" bgcolor="#d8dfea"></td>
			</tr>
			<tr>
			  <td width="3" align="left" valign="top">&nbsp;</td>
			  <td align="center" valign="top">
			   <?php
			   		
				foreach($dbf->fetchOrder('alerts',"lis='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')","dt DESC LIMIT $limitstart,$limitend") as $valalert) {
			
					//Update in alerts_read table
					if($dbf->countRows("alerts_read", "alert_id='$valalert[id]' And user_id='$_SESSION[id]'") == 0){
						$dttm = date('Y-m-d h:i:s');
						$string = "alert_id='$valalert[id]',user_id='$_SESSION[id]',dated='$dttm'";
						$dbf->insertSet("alerts_read",$string);
					}
					
				?>
				<table width="450" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
					<td width="4">&nbsp;</td>
					<td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						  <td width="26%" align="left" valign="middle" class="hometest_name"><?php echo constant("STUDENT_ADVISOR_ALERT_POSTEDBYADMIN");?></td>
						 <td width="74%" align="left" valign="middle" class="hometest_time">
						 <?php echo date("l, d M Y",strtotime($valalert["dt"]));?>&nbsp;,<?php echo $valalert["tm"];?></td>
						</tr>
						<tr>
						  <td height="5"></td>
						  <td height="5"></td>
						</tr>
						<?php
						 $valm = $dbf->strRecordID("common","*","id='$valalert[alert_id]'"); ?>
						<?php if($valalert["imp"]=="1") { ?>
						<tr>
						  <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="14%" align="left" valign="middle" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_ALERT_MARKAS");?> : </td>
								<td width="9%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
								<td width="77%" align="left" valign="middle" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_ALERT_IMPORTANT");?></td>
							  </tr>
						  </table></td>
						</tr>
						<?php } ?>
						<tr>
						  <td colspan="2" align="left" valign="top" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_ALERT_MSGTYPE");?> : <?php echo $valm["name"];?></td>
						</tr>
						<tr>
						  <td colspan="2" align="left" valign="top" class="tabledetailtext"><?php echo $valalert["imp_info"];?></td>
						</tr>
					</table></td>
				  </tr>
				  <tr>
					<td height="10" colspan="3"></td>
				  </tr>
				  <tr>
					<td height="1" colspan="3" bgcolor="#d8dfea"></td>
				  </tr>
				</table>
				<?php $i++; } ?></td>
			</tr>
			<tr>
			  <td align="left" valign="top"></td>
			  <td height="3" align="center" valign="top"></td>
			</tr>
			<tr>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="center" valign="top">
              <div class="pagination">
				<?php if($_POST['pagenumber']>0){?>
                    <a href="javascript:void(0);"onclick="pagination('alert_page_ajax.php','<? echo $_POST['val']?>','<? echo $_POST['pagenumber']-1?>');"><< Prev</a>
                <?php }else{?>
                        <span class="disabled">Prev</span>
                <?php } ?>
                <span class="current">Page: <? echo $_POST['pagenumber']+1?>/<? echo $totalpage?></span
                ><?php if($totalpage >($_POST['pagenumber']+1)){ ?>
                        <a href="javascript:void(0);"onclick="pagination('alert_page_ajax.php','<? echo $_POST['val']?>','<? echo $_POST['pagenumber']+1?>');">Next »</a>
                <?php } else{?>
                        <span class="disabled">Next</span>
                <?php } ?>		
            </div>
              </td>
			</tr>
		</table>
		</div>
        
		<?php } else { ?>
        <div style="width:550px;height:150px;" id="response">
		<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" style="padding-right:3px;">
      <?php if($_REQUEST["page_from"] == "dashboard"){ ?>
      <img src="../images/close.png" width="22" height="20" onClick="javascript:self.parent.tb_remove();" style="cursor:pointer;">
      <?php } ?>
      </td>
    </tr>
    <tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
    	<td height="1" colspan="3" bgcolor="#d8dfea"></td>
    </tr>
    <tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">
       <?php		
		foreach($dbf->fetchOrder('alerts',"lis='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')","dt DESC LIMIT $limitstart,$limitend") as $valalert) {
			
			//Update in alerts_read table
			if($dbf->countRows("alerts_read", "alert_id='$valalert[id]' And user_id='$_SESSION[id]'") == 0){
				$dttm = date('Y-m-d h:i:s');
				$string = "alert_id='$valalert[id]',user_id='$_SESSION[id]',dated='$dttm'";
				$dbf->insertSet("alerts_read",$string);
			}
		?>
        <table width="450" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  
                 <td width="74%" align="right" valign="middle" class="hometest_time">
				 <?php echo date("l, d M Y",strtotime($valalert["dt"]));?>&nbsp;,<?php echo $valalert["tm"];?></td>
                 <td width="26%" align="right" valign="middle" class="hometest_name"><?php echo constant("STUDENT_ADVISOR_ALERT_POSTEDBYADMIN");?></td>
                </tr>
                <tr>
                  <td height="5"></td>
                  <td height="5"></td>
                </tr>
                <?php
                 $valm = $dbf->strRecordID("common","*","id='$valalert[alert_id]'"); ?>
                <?php if($valalert["imp"]=="1") { ?>
                <tr>
                  <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                       
                        
                        <td width="77%" align="right" valign="middle" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_ALERT_IMPORTANT");?></td>
                        <td width="9%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                         <td width="14%" align="right" valign="middle" class="hometest_time"> : <?php echo constant("STUDENT_ADVISOR_ALERT_MARKAS");?></td>
                      </tr>
                  </table></td>
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="2" align="right" valign="top" class="hometest_time"><?php echo $valm["name"];?> : <?php echo constant("STUDENT_ADVISOR_ALERT_MSGTYPE");?></td>
                </tr>
                <tr>
                  <td colspan="2" align="right" valign="top" class="tabledetailtext"><?php echo $valalert["imp_info"];?></td>
                </tr>
            </table></td>
            <td width="4">&nbsp;</td>          
            <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
          </tr>
          <tr>
            <td height="10" colspan="3"></td>
          </tr>
          <tr>
            <td height="1" colspan="3" bgcolor="#d8dfea"></td>
          </tr>
        </table>
        <?php $i++; } ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">
	  
      <div class="pagination">
				
                <?php if($totalpage >($_POST['pagenumber']+1)){ ?>
                        <a href="javascript:void(0);"onclick="pagination('alert_page_ajax.php','<? echo $_POST['val']?>','<? echo $_POST['pagenumber']+1?>');">&lt;&lt; <?php echo constant("PAGE_NEXT");?></a>
                <?php } else{?>
                        <span class="disabled"><?php echo constant("PAGE_NEXT");?></span>
                <?php } ?>
                
          <span class="current"><? echo $_POST['pagenumber']+1?>/<? echo $totalpage?> : <?php echo constant("PAGE_PAGENO");?></span>
				
                <?php if($_POST['pagenumber']>0){?>
                    <a href="javascript:void(0);"onclick="pagination('alert_page_ajax.php','<? echo $_POST['val']?>','<? echo $_POST['pagenumber']-1?>');"><?php echo constant("PAGE_PREV");?> &gt;&gt;</a>
                <?php }else{?>
                        <span class="disabled"><?php echo constant("PAGE_PREV");?></span>
                <?php } ?>
                
				
            </div></td>
    </tr>
</table>
		</div>
        <?php } ?>
		</body>

   