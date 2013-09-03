<?php
ob_start();
session_start();

include_once('../includes/ExportToExcel.class.php');

//Object initialization

$exp=new ExportToExcel();
$exp->exportWithPage("report_credit_balance_report_csv_data.php","report_credit_balance_report.xls");
?>