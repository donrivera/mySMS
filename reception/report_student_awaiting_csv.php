<?php
ob_start();
session_start();

include_once('../includes/ExportToExcel.class.php');

//Object initialization

$exp=new ExportToExcel();
$exp->exportWithPage("report_student_awaiting_csv_data.php","report_student_awaiting.xls");
?>