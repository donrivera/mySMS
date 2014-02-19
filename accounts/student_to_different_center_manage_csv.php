<?php
ob_start();
session_start();

include_once('../includes/ExportToExcel.class.php');

//Object initialization

$exp=new ExportToExcel();
$exp->exportWithPage("student_to_different_center_manage_csv_data.php","student_to_different_center_manage.xls");
?>