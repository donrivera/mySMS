<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'berlitzk_smtest');

class DB_Class
{
	function __construct()
	{

		$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or	die('Oops connection error -> ' . mysql_error());
		mysql_select_db(DB_DATABASE, $connection)
		or die('Database error -> ' . mysql_error());		

		mysql_query("SET character_set_results=utf8", $connection);
		mb_language('uni');
		mb_internal_encoding('UTF-8');
		mysql_select_db(DB_DATABASE, $connection);
		mysql_query("set names 'utf8'",$connection);		

		# Set Timezone
		ini_set('date.timezone', 'Asia/Riyadh');
		

		# Set timezone from which is Admin set
		/*$timezone_qty = "select * from conditions where type='TimeZone'";
		$timezone_res = mysql_fetch_array($timezone_qty);
		$timezone = $timezone_res["name"];
		ini_set('date.timezone', '$timezone');*/
	}
}

?>