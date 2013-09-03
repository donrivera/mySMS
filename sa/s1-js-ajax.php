<?php
echo $_REQUEST[lang];
if($_REQUEST[lang]=='en')
{

echo '<script type="text/javascript" src="arabic_files/free-translator.js"></script>';

}
else
{

echo '<script type="text/javascript" src="arabic_files/free-translator_ar.js"></script>';

}
?>