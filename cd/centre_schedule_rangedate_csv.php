<?php
ob_start();
session_start();

include_once('../includes/ExportToExcel.class.php');

//Object initialization

$exp=new ExportToExcel();
$exp->exportWithPage("centre_schedule_rangedate_csv_data.php","report_schedule_rangedate.xls");
?>