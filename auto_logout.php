<?php
ob_start();
session_start();

//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");

$inactive = $res_logout[name]; // Set timeout period in seconds

if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
						
        session_destroy();
    }
}
?>