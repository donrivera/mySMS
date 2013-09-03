<?php
ob_start();
session_start();

require 'I18N/Arabic.php';
$Arabic = new I18N_Arabic('Transliteration');

$name = $_REQUEST[tno];
echo $Arabic->en2ar($name);
?>
