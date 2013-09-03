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
$date=$_REQUEST[tno];

$dt = $date;

$date = explode("/",$date);

$d = $date[0];
$m = $date[1];
$y = $date[2];

$date = $y."/".$m."/".$d;

echo "Your selected date :".$dt."<br><br>Hijri to Gregorian Result: ".$result=$DateConv->HijriToGregorian($date,$format);
?>