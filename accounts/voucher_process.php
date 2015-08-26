<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

switch($_REQUEST[action])
{
	case 'payment':	{	
						$transaction = array(
										'party_id'						=> $_POST['party_code'],
										'transaction_pay_type'			=> $_POST['check_type'],
										'transaction_amount' 			=> $_POST['amount'],
										'bank_code'						=> $_POST['bank_code'],
										'bank_no'						=> $_POST['acct_no'],
										'bank_check_no'					=> $_POST['check_no'],
										'transaction_date'      	 	=> $_POST['choose_calendar'],
										'remarks'     					=> $_POST['remarks']						
										);
						$acct_dir=array(
										'account_value' 				=> $_POST['acc_dir_value'],
										'account_desc'      	 		=> $_POST['acc_dir_desc'],
										'account_no'     				=> $_POST['acc_dir_no'],
										//'account_doc_type'			=> $_POST['acc_dir_doc_type'],
										//'account_src'					=> $_POST['acc_dir_doc_src'],
										'cost_center'					=> $_POST['acc_dir_cost_ctr']
										);
						$result=$dbf->paymentVoucher($transaction,$acct_dir);
						if($result==false):
							header("Location:payment_voucher.php?msg=duplicate");
						else:header("Location:report_journal.php");
						endif;
					}break;
	case 'receipt':	{
						
						$transaction = array(
										'party_id'						=> $_POST['party_code'],
										'transaction_pay_type'			=> $_POST['check_type'],
										'transaction_amount' 			=> $_POST['amount'],
										'bank_code'						=> $_POST['bank_code'],
										'bank_no'						=> $_POST['acct_no'],
										'bank_check_no'					=> $_POST['check_no'],
										'transaction_date'      	 	=> $_POST['choose_calendar'],
										'remarks'     					=> $_POST['remarks'],
										'party_code'					=> "CP"
										);
						$acct_dir=array(
										'account_value' 				=> $_POST['acc_dir_value'],
										'account_desc'      	 		=> $_POST['acc_dir_desc'],
										'account_no'     				=> $_POST['acc_dir_no'],
										'cost_center'					=> $_POST['acc_dir_cost_ctr']
										);
						
						$result=$dbf->receiptVoucher($transaction,$acct_dir);
						if($result==false):
							header("Location:receipt_voucher.php?msg=duplicate");
						else:header("Location:report_journal.php");
						endif;
					}break;
	case 'journal': {
						$debit=array_sum($_POST['deb']);
						$credit=array_sum($_POST['cre']);
						if($debit != $credit)
						{
							header("Location:journal.php?msg=balance");
						}
						else
						{
							$transaction = array(
											//'party_id'					=> $_POST['party_code'],
											//'transaction_pay_type'		=> $_POST['check_type'],
											'transaction_amount' 			=> $credit,
											//'bank_code'					=> $_POST['bank_code'],
											//'bank_no'						=> $_POST['acct_no'],
											//'bank_check_no'				=> $_POST['check_no'],
											'transaction_date'      	 	=> $_POST['choose_calendar'],
											'remarks'     					=> $_POST['remarks'],
											//'party_code'					=> "CP"
											);
							$acct_dir=array(
											'account_debit'					=> $_POST['deb'],
											'account_credit'				=> $_POST['cre'],
											'account_desc'      	 		=> $_POST['acc_dir_desc'],
											'account_no'     				=> $_POST['acc_dir_no'],
											'cost_center'					=> $_POST['acc_dir_cost_ctr']
											);
								
							$result=$dbf->insertJournal($transaction,$acct_dir);
							if($result==false):
							header("Location:journal.php?msg=duplicate");
							else:header("Location:report_journal.php");
							endif;
						}
					}break;
	default:		{echo "Please Select Voucher Action";}break;
}
?>