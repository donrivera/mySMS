<?php
ob_start();
session_start();

if($_REQUEST[tno]=="")
{
	echo "Please choose date.";
	exit;
}

include_once '../includes/hijri.php';

$DateConv=new Hijri_GregorianConvert;
$format="YYYY/MM/DD";
//$date=$_REQUEST[tno];
//change date format
$x=explode("-",$_REQUEST[tno]);
$date=$x[2]."-".$x[1]."-".$x[0];
echo "Your selected date :".date("d-m-Y",strtotime($date))."<br><br>Gregorian to Hijri Result: ".$DateConv->GregorianToHijri($date,$format);
?>