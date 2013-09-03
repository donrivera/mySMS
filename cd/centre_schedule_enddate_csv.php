<?php
ob_start();
session_start();

include_once('../includes/ExportToExcel.class.php');

//Object initialization

$exp=new ExportToExcel();
$exp->exportWithPage("centre_schedule_enddate_csv_data.php","report_schedule_enddate.xls");
?>