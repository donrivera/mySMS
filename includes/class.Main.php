<?php
include_once 'config.php';
include_once 'class.dbFunctions.php';

//Involves Any User operations*********************************************************************************************************************
class User extends Dbfunctions{
	
	//Database connect 
	function __construct(){
		$db = new DB_Class();
	}
	
	//TOTAL ROWS
	function countRows($tblName, $optCondition=""){
		if(trim($optCondition) != ""){
			$condition = " WHERE " . $optCondition;
		}else{
			$condition = "";
		}		
		$sql="SELECT * FROM " . $tblName . $condition;
		//echo $sql="SELECT * FROM " . $tblName . $condition;
		$result = mysql_query($sql);
		if(!$result){
			trigger_error("Problem selecting data");
		}
		$num=mysql_num_rows($result);
		return $num;
	}
	
	function getDiscountPercent($course_fee, $discount_amount){
		return ($discount_amount / $course_fee) * 100;
	}
	
	//FETCH SINGLE ROW or specific Column FROM A TABLE (Kishor - 17-09-2011)
	function strRecordID($tblName,$field,$optCondition=""){
		if(trim($optCondition) != ""){
			$sql = "SELECT ".$field." from ".$tblName." WHERE " . $optCondition;
		}else{
			$sql = "SELECT ".$field." from ".$tblName;
		}
		//echo $sql;
		$result = mysql_query($sql);
		return mysql_fetch_array($result);
	}
	// ********************************END**************************************
	
	//FETCH SINGLE ROW FROM A TABLE
	function fetchSingle($tblName,$optCondition=""){
		if(trim($optCondition) != ""){
			$condition = " WHERE " . $optCondition;
		}else{
			$condition = "";
		}		
		$sql="SELECT * FROM " . $tblName . $condition;
		$result = mysql_query($sql);
		return mysql_fetch_array($result);
	}

	//INSERT DATA INTO TABLE AND GET THE INSERTED ID******************************************************************************	
	function insertToTable($tblName, $string){
		$rs= mysql_query("INSERT INTO " . $tblName . " VALUES(". $string.")");
		if($rs){
			$lastId=mysql_insert_id();
			return $lastId;
		}else{
			return 0;
		}
	}
	// ********************************END****************************************************************************************	
		
	//INSERT TO TABLE USING SET METHOD************************************************************************************************
	function insertSet($tblName,$string){
		$string = "INSERT INTO  " . $tblName . " SET " .  $string;
		$rs= mysql_query($string);
		if($rs){
			$lastId=mysql_insert_id();
			return $lastId;
		}else{
			return 0;
		}
	}
	// ********************************END****************************************************************************************	
		
	//DELETE DATA FROM TABLE
	function deleteFromTable($tblName, $condition){
		if(trim($condition) != ""){
			$condition = " WHERE " . $condition;
		}else{
			$condition = "";
		}
		$rs= mysql_query("DELETE FROM " . $tblName . $condition);
	}
	// ********************************END****************************************************************************************	
	
	//UPDATE  TABLE
	function updateTable($tblName,$string, $condition){
		
		if($condition == ""){
			$update_string = "UPDATE " . $tblName . " SET " .  $string;
		}else{
			$update_string = "UPDATE " . $tblName . " SET " .  $string .' Where '. $condition;	
		}
		//echo $update_string;exit;		 	
		$rs= mysql_query($update_string);		
	}
	// ********************************END****************************************************************************************	

	/*Returns data value if data exists in a table (suitable for integer or string data) *************************/
	function getDataFromTable($tblName, $fldName,  $optCondition){
		$defaultVal="";	
		if(trim($optCondition) != ""){
			$condition = $optCondition ;
		}else{
			$condition = "";
		}
		//echo ("select " . $fldName . " from " . $tblName . " where " . $condition);	
		$rs = mysql_query("select " . $fldName . " from " . $tblName . " where " . $condition);
	
		if((!($rs)) || (!($rec=mysql_fetch_array($rs)))){
			//not found
			return $defaultVal;
		}else if(is_null($rec[0])){
			//found
			return $defaultVal;
		}else{
			//found
			return $rec[0];
		}
	}
	/*Query to use JOINS BY (DON PAR RIVERA)*/
	function genericQuery($sql)
	{
		$result = mysql_query($sql);
		if(!$result){
			trigger_error("Problem selecting data");
		}
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$result_array[] = $row;
		}
		if(count($result_array)>0){
			return $result_array;	
		}else{
			$default_val=array();
			return $default_val;
		}
	}
	/*Query to use JOINS BY (DON PAR RIVERA)*/
	// ********************************************END**********************************************************************	
	
	//FETCH ALL ROWS FROM A TABLE WITH ORDER BY (Kishor - 16-09-2011)
	function fetchOrder($tblName,$optCondition="",$orderby="",$field="",$groupby="",$having=""){
		if($field==""){
			$sql = "SELECT * FROM ".$tblName;
		}else{
			$sql = "SELECT ".$field." FROM ".$tblName;
		}
		if(trim($optCondition) != ""){
			$sql = $sql." WHERE " . $optCondition;
		}
		if(trim($orderby) != "" && $groupby == ""){
			$sql = $sql." order by " . $orderby;
		}
		if($groupby != "" && $field != "" && $orderby == ""){
			$sql = $sql." group by " . $groupby;
		}
		if($groupby != "" && $field != "" && $orderby != ""){
			$sql = $sql." group by " . $groupby . " ORDER BY " . $orderby;
		}
		//echo $sql;		
		$result = mysql_query($sql);
		if(!$result){
			trigger_error("Problem selecting data");
		}
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$result_array[] = $row;
		}
		if(count($result_array)>0){
			return $result_array;	
		}else{
			$default_val=array();
			return $default_val;
		}
	}
	//========== End FetchOrder function ===============
	
	//SUM OF TWO TIME --Kishor--14-May-2012 (e.i $hour_one = "01:20:20";  $hour_two = "05:50:20";)
	function AddTwoTime($hour_one, $hour_two){
		$h =  strtotime($hour_one);
		$h2 = strtotime($hour_two);
		
		$minute = date("i", $h2);
		$second = date("s", $h2);
		$hour = date("H", $h2);
				
		$convert = strtotime("+$minute minutes", $h);
		$convert = strtotime("+$second seconds", $convert);
		$convert = strtotime("+$hour hours", $convert);
		$new_time = date('H:i:s', $convert);

		return $new_time;
	}
	
	//Get Class Time
	//You have to Pass the Start time and Number of Units per day
	// 1 Unit = 45 Minutes
	//Example : $dbf->GetClassTime("08:00 AM", 2); It should be 12 hours format i.e (02:15 PM)
	//Output : 09:30 AM
	function GetClassTime($class_start_time, $no_of_unit_perDay){
		$unit = $no_of_unit_perDay * 45;		
		$st = substr($class_start_time,0,5);
		$st = $st.":00";
		
		//Minute to time
		$en = m2h($unit).":00";
		
		//Adding two time (start with adding minutes)
		$u = AddTwoTime($st, $en);
		
		return date('h:i A',strtotime($u));
	}
	
	function m2h($mins) {
		if ($mins < 0) {
			$min = abs($mins);
		} else {
			$min = $mins;
		}
		
		$H = floor($min / 60);
		$M = ($min - ($H * 60)) / 100;
		$hours = $H+$M;
		if ($mins < 0) {
			$hours = $hours * (-1);
		}
		$expl = explode(".", $hours);
		$Hr = $expl[0];
		if (empty($expl[1])) {
			$expl[1] = 00;
		}
		$Mn = $expl[1];
		if (strlen($Mn) < 1) {
			$Mn = $Mn . 0;
		}
		if($Mn < 10){
			$Mn = str_pad($Mn, 2, "0", STR_PAD_RIGHT);
		}
		$hours = str_pad($Hr, 2, "0", STR_PAD_LEFT).":".$Mn;
		return $hours;
	} 
	
	/** dated : 17-Jul-2012 by Kishor Singh
     * This Function Converting the English number to Arabic
     * required the English value [0-9]
     * 
     * This is internal function
     * 
     * $dbf->enNo2ar('09-06-1986','-') : Output :- ٠٩-٠٦-١٩٨٦
     */
	function enNo2ar($nEng,$separator){						  
		$arNum = '٠,١,٢,٣,٤,٥,٦,٧,٨,٩';
		
		$ex_arNum = explode(',',$arNum);
		
		for($x = 0; $x < strlen($nEng); $x++){
			$m = substr($nEng,$x,1);
			if($str == ''){
				if(!is_numeric($m)){
					$str = $separator;
				}else{
					$str = $ex_arNum[$m];
				}
			}else{
				if(!is_numeric($m)){
					$str = $str.$separator;
				}else{
					$str = $str.$ex_arNum[$m];
				}
			}
		}
		return $str;
	}
	//==========================================
	
	 /** dated : 22-May-2012
     * This Function Converting the given text to UTF-16
     * UTF-16 required when sending SMS
     * 
     * This function support Arabic,English and the special chars only
     * For other language try to move your hands
     * 
     * This is internal function
     * 
     * @param string $text2convert
     * @return utf-16_string
     */
    function Convert2UTF16($text2convert){
        $utf16 = array(
        "060D" => "¡" ,
        "060D" => "¡",
        '061B' => "º",
        '061F' => "¿",
        '0621' => "Á",
        '0622' => "Â",
        '0623' => "Ã",
        '0624' => "Ä",
        '0625' => "Å",
        '0626' => "Æ",
        '0627' => "Ç",
        '0628' => "È",
        '0629' => "É",
        '062A' => "Ê",
        '062B' => "Ë",
        '062C' => "Ì",
        '062D' => "Í",
        '062E' => "Î",
        '062F' => "Ï",
        '0630' => "Ð",
        '0631' => "Ñ",
        '0632' => "Ò",
        '0633' => "Ó",
        '0634' => "Ô",
        '0635' => "Õ",
        '0636' => "Ö",
        '0637' => "Ø",
        '0638' => "Ù",
        '0639' => "Ú",
        '063A' => "Û",
        '0641' => "Ý",
        '0642' => "Þ",
        '0643' => "ß",
        '0644' => "á",
        '0645' => "ã",
        '0646' => "ä",
        '0647' => "å",
        '0648' => "æ",
        '0649' => "ì",
        '064A' => "í",
        '0640' => "Ü",
        '064B' => "ð",
        '064C' => "ñ",
        '064D' => "ò",
        '064E' => "ó",
        '064F' => "õ",
        '0650' => "ö",
        '0651' => "ø",
        '0652' => "ú",
        '0021' => "!",
        '0022' => "\"",
        '0023' => "#",
        '0024' => "$",
        '0025' => "%",
        '0026' => "&",
        '0027' => "\'",
        '0028' => "(",
        '0029' => ")",
        '002A' => "*",
        '002B' => "+",
        '002C' => ",",
        '002D' => "-",
        '002E' => ".",
        '002F' => "/",
        '0030' => "0",
        '0031' => "1",
        '0032' => "2",
        '0033' => "3",
        '0034' => "4",
        '0035' => "5",
        '0036' => "6",
        '0037' => "7",
        '0038' => "8",
        '0039' => "9",
        '003A' => ":",
        '003B' => ";",
        '003C' => "<",
        '003D' => "=",
        '003E' => ">",
        '003F' => "?",
        '0040' => "@",
        '0041' => "A",
        '0042' => "B",
        '0043' => "C",
        '0044' => "D",
        '0045' => "E",
        '0046' => "F",
        '0047' => "G",
        '0048' => "H",
        '0049' => "I",
        '004A' => "J",
        '004B' => "K",
        '004C' => "L",
        '004D' => "M",
        '004E' => "N",
        '004F' => "O",
        '0050' => "P",
        '0051' => "Q",
        '0052' => "R",
        '0053' => "S",
        '0054' => "T",
        '0055' => "U",
        '0056' => "V",
        '0057' => "W",
        '0058' => "X",
        '0059' => "Y",
        '005A' => "Z",
        '005B' => "[",
        '005C' => "\\",
        '005D' => "]",
        '005E' => "^",
        '005F' => "_",
        '0060' => "`",
        '0061' => "a",
        '0062' => "b",
        '0063' => "c",
        '0064' => "d",
        '0065' => "e",
        '0066' => "f",
        '0067' => "g",
        '0068' => "h",
        '0069' => "i",
        '006A' => "j",
        '006B' => "k",
        '006C' => "l",
        '006D' => "m",
        '006E' => "n",
        '006F' => "o",
        '0070' => "p",
        '0071' => "q",
        '0072' => "r",
        '0073' => "s",
        '0074' => "t",
        '0075' => "u",
        '0076' => "v",
        '0077' => "w",
        '0078' => "x",
        '0079' => "y",
        '007A' => "z",
        '007B' => "{",
        '007C' => "|",
        '007D' => "}",
        '007E' => "~",
        '00A9' => "©",
        '00AE' => "®",
        '00F7' => "÷",
        '00F7' => "×",
        '00A7' => "§",
        '0020' => " ",
        '000D' => "\n");
        for($i=0;$i<strlen($text2convert);$i++)
        {
            foreach ($utf16 as $key => $value) {
                if ($text2convert[$i] == $value)
                $utf16string .= $key;
            }
        }
        return $utf16string;
    }
	
	//String cut to a limited words*****************
	function cut($string, $max_length){
		if (strlen($string) > $max_length){
			$string = substr($string, 0, $max_length);
			$pos = strrpos($string, " ");
			if($pos === false) {
					return substr($string, 0, $max_length)."...";
			}
				return substr($string, 0, $pos)."...";
		}else{
			return $string;
		}
	}	
	//***********************************************
	
	//FIND URL OF THE SITE *******************************************************
	function get_server() {
		$protocol = 'http';
		if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
			$protocol = 'https';
		}
		$host = $_SERVER['HTTP_HOST'];
		$baseUrl = $protocol . '://' . $host;
		if (substr($baseUrl, -1)=='/') {
			$baseUrl = substr($baseUrl, 0, strlen($baseUrl)-1);
		}
		return $baseUrl;
	}
	//****************************************************************************
	
	function WeekStartDay($date){
		$timestamp = strtotime($date);
		$dayOfWeek = date('N', $timestamp);		
		$startDate = mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + $weekStart, date('Y', $timestamp));
		$endDate = mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + 6 + $weekStart, date('Y', $timestamp));
		return date('Y-m-d', $startDate);
	}
	
	function WeekEndDay($date){
		$timestamp = strtotime($date);
		$dayOfWeek = date('N', $timestamp);		
		$startDate = mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + $weekStart, date('Y', $timestamp));
		$endDate = mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + 6 + $weekStart, date('Y', $timestamp));
		return date('Y-m-d', $endDate);
	}
	
	function LastWeekStartDay(){
		return date('Y-m-d',time()+((-7) - date('w'))*24*3600);
	}
	
	function LastWeekEndDay(){
		return date('Y-m-d',time()+((-1) - date('w'))*24*3600); 
	}
	
	//Arabic Student Name
	function StudentName($student_id){
	
		$dbf = new User();
		
		$student = $dbf->strRecordID("student","*","id='$student_id'");
				
		if($student["first_name1"] != '' || $student["father_name"] != '' || $student["family_name"] != ''){
			$string = $string.' ('.$student["first_name1"].' '.$student["father_name"].' '.$student["grandfather_name"].' '.$student["family_name"].')';
			//$string = $student["family_name"];
		}
		return $string;
	}
	
	//Arabic Student Name
	function FullGroupInfo($group_id){
	
		$dbf = new User();
		
		$group = $dbf->strRecordID("student_group","*","id='$group_id'");
		//$string = $string.' ('.$group["group_name"].', '.date('d/m/Y', strtotime($group["start_date"])).' - '.date('d/m/Y', strtotime($group["end_date"])).', '.$group["group_time"].'-'.$dbf->GetGroupTime($grroup["id"]).')';
		$string = $string.' ('.$group["group_name"].', '.date('d/m/Y', strtotime($group["start_date"])).' - '.date('d/m/Y', strtotime($group["end_date"])).', '.$group["group_start_time"].'-'.$group["group_end_time"].')';
		return $string;

	}
	
	//Get student student Balance
	function BalanceAmount($student_id, $course_id){
		
		$dbf = new User();
		
		$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
		$course = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
		
		$camt = ($course - $res_enroll["discount"]) + $res_enroll["other_amt"];
		$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
		$feeamt = $fee["SUM(paid_amt)"];
		
		return $bal_amt = $camt - $feeamt;
	}
	
	//Get student student Balance
	function GetStudentPaidAmount($student_id){
		
		$dbf = new User();
		
		foreach($dbf->fetchOrder('student_group_dtls',"student_id='$student_id'","") as $enroll) {
			
			$course_id = $enroll["course_id"];
			
			$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
			$course = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
			$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
			
			$feeamt = $fee["SUM(paid_amt)"]+$res_enroll["ob_amt"];
			$paid_amt = $paid_amt + $feeamt;
		}		
		return $paid_amt;
	}
	
	//Get time available or not
	function timeSlotAvailable($teacher_id, $start_date, $start_time){
		
		$dbf = new User();
		
		//$user_start_time = strtotime($start_time) + 1;		
		$user_start_time=date('Hi',strtotime(date("H:i:s", strtotime($start_time)) . " +1 minutes"));
		//$result = false;
		/*				
		foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And  ('$user_start_time' BETWEEN group_time And group_time_end)","") as $enroll) 
		{
			echo count($enroll);
			//$result=(count($enroll)==1? true : false);
			//$db_start_time = strtotime($enroll["group_time"]);
			//$db_end_time = strtotime($enroll["group_time_end"]);
			//$range=range($db_start_time,$db_end_time);
			//if(in_array($user_start_time,$range)):$result=true;
			//else:$result=false;
			//endif;
			//if($user_start_time >= $db_start_time && $user_start_time < $db_end_time){
			//	$result = true;
			//	break;
			//}
		}
		*/
		$q=$dbf->fetchOrder(	'student_group',
								"teacher_id='$teacher_id' 
								AND ('$start_date' BETWEEN start_date AND end_date)
								AND ('$user_start_time' BETWEEN group_time And group_time_end)
								","");
		//echo count($q)."-".$user_start_time;
		if(count($q)==1)
		{$result=true;}
		else{$result=false;}
		return $result;
	}
	
	//Get time available or not
	function teacherSlotAvailable($teacher_id,$start_date,$end_date,$start_time, $end_time){
		
		$dbf = new User();
		//echo $start_time.$end_time."<BR/>";
		$start = $start_time+1;
		$end = $end_time+1;
		$q=$dbf->fetchOrder(	'student_group',
								"teacher_id='$teacher_id' 
								 AND ('$end_date' BETWEEN start_date And end_date) 
								 AND (('$start' BETWEEN group_time AND group_time_end) OR ('$end' BETWEEN group_time AND group_time_end))
								","");
		
		echo $q;
		if($q <= 0 || empty($q)):
		$result=false;
		elseif($q>0):
		$result=true;
		else:
		$result=false;
		endif;
		return $result;
		
		/*
		$result = false;
		foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And  ('$start_date' BETWEEN start_date And end_date)","") as $enroll) {
			
			$frm = strtotime($enroll["group_time"]);
			$tto = strtotime($enroll["group_time_end"]);
			$range=range($frm,$tto);
			if(in_array($start,$range) && in_array($end,$range)):echo $start.$end;$result=false;
			else:$result=true;
			endif;
			//if($start <= $tto && $end >= $frm){
			//	$result = true;
			//	break;
			//}
			
			//if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){
			//	if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){
			//		echo "ok";
			//		$result = true;
			//		break;
			//	}else{
			//		echo "no";
			//	}
			//}
		}
		return $result;
		*/
		
	}
	//Get Group Timing
	function GetGroupTime($group_id){
		
		$dbf = new User();
		
		//Group details
		$group = $dbf->strRecordID("student_group","*","id='$group_id'");
		
		//Get Unit
		$val_unit = $dbf->strRecordID("common","*","id='$group[units]'");
		
		//Time calculation
		$unit = $val_unit["name"];
		$unit = $unit * 45;
										
		$event_time = $group["group_time"];
		$event_length = $unit;
		 
		$timestamp = strtotime("$event_time");
		$etime = strtotime("+$event_length minutes", $timestamp);
		return $next_time = date('h:i A', $etime);	
	}
	
	//DATE DIFFERENT IN TWO DATE --Kishor--25-Jan-2012
	function dateDiff($start, $end){
		$start_ts = strtotime($start);
		$end_ts = strtotime($end);
		$diff = $end_ts - $start_ts;
		return round($diff / 86400);
	}
	
	function MonthFirstDay($month, $year){
		if(empty($month)){
			$month = date('m');
		}
		if(empty($year)){
			$year = date('Y');
		}
		$result = strtotime("{$year}-{$month}-01");
		return date('Y-m-d', $result);
	}
	
	function MonthLastDay($month, $year){
		if(empty($month)){
			$month = date('m');
		}
		if(empty($year)){
			$year = date('Y');
		}
		$result = strtotime("{$year}-{$month}-01");
		$result = strtotime('-1 second', strtotime('+1 month', $result));
		return date('Y-m-d', $result);
	}
	
	//Get student student Balance
	function No_Of_Attendance($student_id, $group_id){
		
		$dbf = new User();
		
		$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift1='X'");
		$shift1 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift2='X'");
		$shift2 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift3='X'");
		$shift3 = $count_att_3["COUNT(id)"];
		
		
		$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift4='X'");
		$shift4 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift5='X'");
		$shift5 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift6='X'");
		$shift6 = $count_att_3["COUNT(id)"];
		
		
		$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift7='X'");
		$shift7 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift8='X'");
		$shift8 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND shift9='X'");
		$shift9 = $count_att_3["COUNT(id)"];
		
		return $shift1+$shift2+$shift3+$shift4+$shift5+$shift6+$shift7+$shift8+$shift9;
	}
	
	//DATE DIFFERENT IN TWO DATE --Kishor--06-Sept-2012
	function TimeDiff($dtime,$atime){
		
		$nextDay=$dtime>$atime?1:0;
		$dep=explode(':',$dtime);
		$arr=explode(':',$atime);
		$diff=abs(mktime($dep[0],$dep[1],0,date('n'),date('j'),date('y'))-mktime($arr[0],$arr[1],0,date('n'),date('j')+$nextDay,date('y')));
		$hours=floor($diff/(60*60));
		$mins=floor(($diff-($hours*60*60))/(60));
		$secs=floor(($diff-(($hours*60*60)+($mins*60))));
		if(strlen($hours)<2){$hours="0".$hours;}
		if(strlen($mins)<2){$mins="0".$mins;}
		if(strlen($secs)<2){$secs="0".$secs;}
		return $hours.':'.$mins.':'.$secs;
	}
	
	//Generate Invoice No --Kishor--11-Sept-2012 ()
	function GenerateInvoiceNo($centre_id){
		
		$dbf = new User();
		$invoice_from = $dbf->getDataFromTable("centre","invoice_from","id='$centre_id'");
		
		//Start Generate Invoice Number
		//Maximum Serial No of the Centre in Student Table
		//$invoice_sl = $dbf->getDataFromTable("student_fees","MAX(invoice_sl)","centre_id='$centre_id'");
		$invoice_sl = $dbf->getDataFromTable("student_fees","COUNT(*)","centre_id='$centre_id'");
		//Check serial no exist or not
		if($invoice_sl == '0'){
			$inv_no = "1";
		}else{
			$inv_no = $invoice_sl + 1;
		}
		
		//Invoice No
		return $inv_no = date("y").date("m").$invoice_from.str_pad($inv_no, 5, "0", STR_PAD_LEFT);
	}
	
    function int_to_words($amount){
		$nwords = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen", "twenty", 30 => "thirty", 40 => "forty", 50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty", 90 => "ninety" );
		$x = $amount;
		if(!is_numeric($x)){
			$w = '#';
		}else if(fmod($x, 1) != 0){
			$w = '#';
		}else{
			if($x < 0){
				$w = 'minus ';
				$x = -$x;
			}else{
				$w = '';
			}
			if($x < 21){
				$w .= $nwords[$x];
			}else if($x < 100){
				$w .= $nwords[10 * floor($x/10)];
				$r = fmod($x, 10);
				if($r > 0){
					$w .= '-'. $nwords[$r];
				}
			}else if($x < 1000){
				$w .= $nwords[floor($x/100)] .' hundred';
				$r = fmod($x, 100);
				if($r > 0){
					$w .= ' and '. int_to_words($r);
				}
			}else if($x < 100000){
				$w .= int_to_words(floor($x/1000)) .' thousand';
				$r = fmod($x, 1000);
				if($r > 0){
					$w .= ' ';
					if($r < 100){
						$w .= 'and ';
					}
					$w .= int_to_words($r);
				}
			} else {
				$w .= int_to_words(floor($x/100000)) .' lakh';
				$r = fmod($x, 100000);
				if($r > 0){
					$w .= ' ';
					if($r < 100){
						$word .= 'and ';
					}
					$w .= int_to_words($r);
					}
				}
			}
		return $w;
	}
	
	function convert_number_to_words($number){
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);
	   
		if (!is_numeric($number)) {
			return false;
		}
	   
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}
	   
		$string = $fraction = null;
	   
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
	   
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->convert_number_to_words($remainder);
				}
				break;
		}
	   
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
	   
		return $string;
	}
	
	function GetFinalAmount($centre_id, $start_date, $end_date){
		
		$dbf = new User();
		$res = $dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$start_date' AND '$end_date') And status='1'");
		$amt = $res["SUM(paid_amt)"];
				
		# If any discount for this Month
		$res=$dbf->strRecordID('student_enroll', 'SUM(discount)',"centre_id='$centre_id' And (enroll_date BETWEEN '$start_date' AND '$end_date')");
		$amt = $amt - $res["SUM(discount)"];
		
		# If any discount for this Month
		$res=$dbf->strRecordID('student_enroll', 'SUM(other_amt)',"centre_id='$centre_id' And (enroll_date BETWEEN '$start_date' AND '$end_date')");
		$amt = $amt + $res["SUM(other_amt)"];
	}
	
	# Get a strings which is search by the User
	# Created By : Kishor Sing
	# Created On : 02-Apr-2013
	function getSearchStrings($fname, $stid, $mobile, $email, $centre_id = "", $alias = "", $optional_condition = ""){
		
		$condition = '';
		//Concate the Condition
		//1.
		
		if($fname!='' && $stid=='' && $mobile=='' && $email==''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%')";
		}else if($fname=='' && $stid!='' && $mobile=='' && $email==''){
			$condition = $alias."student_id LIKE '$stid%'";
		}else if($fname=='' && $stid=='' && $mobile!='' && $email==''){
			$condition = $alias."student_mobile LIKE '$mobile%'";
		}else if($fname=='' && $stid=='' && $mobile=='' && $email!=''){
			$condition = $alias."email LIKE '$email%'";
		}
		//End 1.
		
		//2.
		else if($fname!='' && $stid!='' && $mobile=='' && $email==''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%') AND ".$alias."student_id LIKE '$stid%'";
		}else if($fname!='' && $stid=='' && $mobile!='' && $email==''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%') AND ".$alias."student_mobile LIKE '$mobile%'";
		}else if($fname!='' && $stid=='' && $mobile=='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%') AND ".$alias."email LIKE '$email%'";
		}else if($fname=='' && $stid!='' && $mobile!='' && $email==''){
			$condition = "".$alias."student_mobile LIKE '$mobile%' AND ".$alias."student_id LIKE '$stid%'";
		}else if($fname=='' && $stid=='' && $mobile!='' && $email!=''){
			$condition = "".$alias."student_mobile LIKE '$mobile%' AND ".$alias."email LIKE '$email%'";
		}else if($fname=='' && $stid!='' && $mobile=='' && $email!=''){
			$condition = "".$alias."student_id LIKE  '$stid%' AND ".$alias."email LIKE '%$email%'";
		}
		//End 2.
		
		//3.
		else if($fname!='' && $stid!='' && $mobile!='' && $email==''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%') AND ".$alias."student_id LIKE '$stid%' AND ".$alias."student_mobile LIKE '$mobile%'";
		}else if($fname!='' && $stid!='' && $mobile=='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%') AND ".$alias."student_id LIKE '$stid%' AND ".$alias."email LIKE '$email%'";
		}else if($fname!='' && $stid=='' && $mobile!='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%') AND ".$alias."student_mobile LIKE '$mobile%' AND ".$alias."email LIKE '$email%'";
		}else if($fname=='' && $stid!='' && $mobile!='' && $email!=''){
			$condition = "".$alias."student_id LIKE '$stid%' AND ".$alias."student_mobile LIKE '$mobile%' AND ".$alias."email LIKE '$email%'";
		}
		//End 3.
		
		//4.
		else if($fname!='' && $stid!='' && $mobile!='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."student_first_name LIKE '$fname%') AND ".$alias."student_id LIKE  '$stid%' AND ".$alias."student_mobile LIKE '$mobile%' AND ".$alias."email LIKE '$email%'";
		}else if($fname=='' && $stid=='' && $mobile=='' && $email==''){
			$condition = $alias."id > '0'";
		}
		//End 4.
		
		if($centre_id > 0){
			$condition = $condition." And ".$alias."centre_id='$centre_id'";
		}
		if($optional_condition != ""){
			$condition = $condition."".$optional_condition;
		}
		return $condition;
	}
	
	# Concate all the variables
	# Created On : 10-05-2013
	# Created By : BLET
	function GetCart_StudentName($en_firstname, $en_father, $en_grand, $en_lastname, $ar_firstname, $ar_father, $ar_grand, $ar_lastname){
		
		# English Concate
		$full_student_name = $en_firstname;
		if($en_father != ""){
			$full_student_name = $full_student_name.' '.$en_father;
		}
		if($en_grand != ""){
			$full_student_name = $full_student_name.' '.$en_grand;
		}
		if($en_lastname != ""){
			$full_student_name = $full_student_name.' '.$en_lastname;
		}
		if($ar_firstname != ""){
			$full_student_name = $full_student_name.' '.$ar_firstname;
		}		
		if($ar_father != ""){
			$full_student_name = $full_student_name.' '.$ar_father;
		}
		if($ar_grand != ""){
			$full_student_name = $full_student_name.' '.$ar_grand;
		}
		if($ar_lastname != ""){
			$full_student_name = $full_student_name.' '.$ar_lastname;
		}
		return $full_student_name;
	}
	
	# Get number of courses enrolled By the Students
	# Rerurn the VIP or VVIP icon or Blank
	# Created On : 10-05-2013
	# Created By : BLET
	function VVIP_Icon($student_id){
		$dbf = new User();
		$more=$dbf->countRows('student_group_dtls',"student_id='$student_id'");	
		if($more > 1 && $more < 2) {
        	echo '<img src="../images/VIPLogo.png" width="25" height="16" />';
        }else if($more > 2) {
        	echo '<img src="../images/vvip.gif" width="25" height="16" />';
        }else{
			echo '';
		}
	}
	
	# Get number of courses enrolled By the Students
	# Rerurn the VIP or VVIP icon or Blank
	# Created On : 10-05-2013
	# Created By : BLET
	function VVIP_Big_Icon($student_id){
		$dbf = new User();
		$more=$dbf->countRows('student_group_dtls',"student_id='$student_id'");	
		if($more > 1 && $more < 2) {
        	echo '<img src="../images/vip.jpg" width="73" height="39">';
        }else if($more > 2) {
        	echo '<img src="../images/vvipd.png" width="73" height="39">';
        }else{
			echo '';
		}
	}
	
	# Get Bill number of courses enrolled By the Students
	# Created On : 10-05-2013
	# Created By : BLET
	function GetBillNo($student_id, $course_id){
		
		$dbf = new User();
		$enroll_dtls = $dbf->strRecordID('student_enroll', "*", "student_id='$student_id' And course_id='$course_id'");
		$course_dtls = $dbf->strRecordID('course', "*", "id='$course_id'");
		
		//Invoice No
		// Return values like Enrollment Serial No + Course Code + Student Serial No
		return $inv_no = str_pad($enroll_dtls["id"], 2, "0", STR_PAD_LEFT).$course_dtls["code"].str_pad($student_id, 5, "0", STR_PAD_LEFT);
	}
	# CORE SCHEDULING 
	# Created On: 9-22-2013
	# Created By: DON PAR RIVERA
	
	function scheduleCall($prev_num,$student_id,$group,$teacher_id)
	{	
		$dbf = new User();
		$new_enrolee=$dbf->countRows('student',"id='$student_id'");
		$total_students=$prev_num + $new_enrolee;
		$student_group=$dbf->strRecordID("student_group","start_date","id='$group'");
		$current_total_unit=$dbf->strRecordID("student_group","units,teacher_id,start_date","id='$group'");
		$teacher_id=$current_total_unit['teacher_id'];
		$start_date=$current_total_unit['start_date'];
		$query=$dbf->genericQuery("SELECT units FROM centre_group_size WHERE('$total_students' BETWEEN size_from AND size_to)");
		foreach($query as $q):
			$week_total=round($q['units']/10,0);
			$new_unit=$q['units'];
		endforeach;
		$compute_date = strtotime($student_group['start_date'] .'+ '.$week_total.' week');
		$end_date=date('Y-m-d',$compute_date);
		$checknextclass= $dbf->genericQuery(" 	SELECT *
												FROM student_group
												WHERE teacher_id='$teacher_id' 
												AND id != '$group'
												AND ('$end_date' BETWEEN start_date AND end_date)
											");
		if(empty($checknextclass) || $checknextclass==NULL)
		{echo"1";
			$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
			if(empty($max_ped) || $max_ped==NULL)
			{echo"2";
				
				$dbf->updateTable("student_group","units='$new_unit',end_date='$end_date'","id='$group'");
			}
			else
			{	echo"3";
				$adj=$dbf->computeAdjustments($total_students,$current_total_unit['units'],$max_ped['max'],$new_unit);
				$new_computed_units=$adj[units];
				$dbf->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
			}
		}
		else
		{ echo "query";
			foreach($checknextclass as $next_class):
				$nc_group_id=$next_class[id];
				$nc_start_date=$next_class[start_date];
				$nc_end_date=$next_class[end_date];
				$nc_units=$next_class[units] / 10;
				$nc_set_unit=$next_class[units];
			endforeach;
			//$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
			//$days = (strtotime($end_date) - strtotime($nc_start_date)) / (60 * 60 * 24);
			//echo "<BR/>".$difference_weeks=($days <0 ? $days * -1 /7 : $days/7);
			//$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
			$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 1 day'));
			if(date("D",$nc_compute_date)==Fri)
			{$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 2 day'));}
			$nc_compute_end_date=date('Y-m-d',strtotime($nc_compute_date.'+'.$nc_units.'week'));
			$thirdchecknextclass= $dbf->genericQuery(" 	SELECT *
														FROM student_group
														WHERE teacher_id='$teacher_id' 
														AND (id != '$group' AND id !='$nc_group_id')
														AND ('$nc_compute_end_date' BETWEEN start_date AND end_date)
													");
			if(empty($thirdchecknextclass) || $thirdchecknextclass==NULL)
			{	
				$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
				
				if(empty($max_ped) || $max_ped==NULL)
				{	
					$dbf->updateTable("student_group","units='$new_unit',end_date='$end_date'","id='$group'");
				}
				else
				{	
					$adj=$dbf->computeAdjustments($total_students,$current_total_unit['units'],$max_ped['max'],$new_unit);
					$new_computed_units=$adj[units];
					$dbf->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
				}
				
				$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 1 day'));
				if(date("D",$nc_compute_date)==Fri)
				{$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 2 day'));}
				$nc_compute_end_date=date('Y-m-d',strtotime($nc_compute_date.'+'.$nc_units.'week'));
				$dbf->updateTable("student_group","units='$nc_set_unit',start_date='$nc_compute_date',end_date='$nc_compute_end_date'","id='$nc_group_id'");
				
			}
			else
			{	
				foreach($thirdchecknextclass as $third_class):
					$thirdc_group_id=$third_class[id];
					$thirdc_start_date=$third_class[start_date];
					$thirdc_end_date=$third_class[end_date];
					$thirdc_units=$third_class[units] / 10;
					$thirdc_set_units=$third_class[units];
				endforeach;
				//echo "adjust current group end date".$end_date."<BR/>";
				//echo "adjust second group end_date".$nc_end_date=$next_class[end_date]."<BR/>";
				$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
				//echo var_dump($max_ped);
				if(empty($max_ped) || $max_ped==NULL)
				{	
					$dbf->updateTable("student_group","units='$new_unit',end_date='$end_date'","id='$group'");
				}
				else
				{	
					$adj=$dbf->computeAdjustments($total_students,$current_total_unit['units'],$max_ped['max'],$new_unit);
					$new_computed_units=$adj[units];
					$dbf->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
				}
				$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 1 day'));
				if(date("D",$nc_compute_date)==Fri)
				{$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 2 day'));}
				$nc_compute_end_date=date('Y-m-d',strtotime($nc_compute_date.'+'.$nc_units.'week'));
				$dbf->updateTable("student_group","units='$nc_set_unit',start_date='$nc_compute_date',end_date='$nc_compute_end_date'","id='$nc_group_id'");
				//ADJUSTMENT FRO 3rd Schedule
				$thirdc_compute_date = date('Y-m-d',strtotime($nc_compute_end_date .'+ 1 day'));
				if(date("D",$thirdc_compute_date)==Fri)
				{$thirdc_compute_date = date('Y-m-d',strtotime($nc_compute_end_date .'+ 2 day'));}
				$thirdc_compute_end_date=date('Y-m-d',strtotime($thirdc_compute_date.'+'.$thirdc_units.'week'));
				$dbf->updateTable("student_group","units='$thirdc_set_units',start_date='$thirdc_compute_date',end_date='$thirdc_compute_end_date'","id='$thirdc_group_id'");
			}
		}
	}
	function computeAdjustments($total_students,$current_total_unit,$max_ped,$new_unit)
	{
		$dbf = new User();
		echo "TOTAL UPDATED STUDENTS:".$total_students."<BR/>";
		echo "CURRENT UNITS:".$current_total_unit."<BR/>";
		echo "GET CURRENT UNITS USED PED CARD:".$max_ped."<BR/>";
		echo "COURSE COMPLETED:";
		$current_course_completed=$max_ped / $current_total_unit;
		echo "PERCENTAGE WITH UPDATED UNIT/S:";
		$percentage_with_new_unit=$current_course_completed * $new_unit;
		echo "<BR/>";
		echo "UPDATED UNIT:";
		$updated_unit=$new_unit - $percentage_with_new_unit;
			if($updated_unit % 2==0):
				echo $new_computed_units=intval($updated_unit);//floor($updated_unit);(integer) trim('.', $one);
			else:
				echo $new_computed_units=ceil($updated_unit);
			endif;
		$result=array("units"=>$new_computed_units);
		return $result;
	}
	function getschedLeaves($range,$start,$end,$group_id,$s_days)
	{		//echo $s_days;
		if(in_array($start,$range))
		{//echo "1<BR/>";	//$s_days=$this->dateDiff($start, $end)+1;
			$s_week_day=date('D',strtotime($start.'+ '.$s_days.'  day'));
			switch($s_week_day)
			{
				case 'Fri':	{$s_new_days=$s_days+2;}break;
				case 'Sat':	{$s_new_days=$s_days+1;}break;
				default:	{$s_new_days=$s_days;}break;
			}
			$new_start_date=date('Y-m-d',strtotime($start.'+ '.$s_new_days.'  day'));
			$e_week_day=date('D',strtotime($end.'+ '.$s_new_days.'  day'));
			switch($e_week_day)
			{
				case 'Fri':	{$e_days=$s_new_days+2;}break;
				case 'Sat':	{$e_days=$s_new_days+1;}break;
				default:	{$e_days=$s_new_days;}break;
			}
			$new_end_date=date('Y-m-d',strtotime($end.'+ '.$e_days.'  day'));
			$this->updateTable("student_group","start_date='$new_start_date',end_date='$new_end_date'","id='$group_id'");
			//echo $start."-".$end."<BR/>";
			//echo $new_start_date."-".$new_end_date."<BR/>";
		}
		else
		{//echo "2<BR/>";
			$days=date('D',strtotime($end.'+ '.$s_days.'  day'));
			switch($days)
			{	case 'Fri':	{$days=$s_days+2;}break;
				case 'Sat':	{$days=$s_days+1;}break;
				default:	{$days=$s_days;}break;
			}
			$new_end_date=date('Y-m-d',strtotime($end.'+ '.$days.'  day'));
			$this->updateTable("student_group","end_date='$new_end_date'","id='$group_id'");
			//echo $new_start_date."-".$new_end_date."<BR/>";
		}
		return array('date_end'=>$new_end_date);
	}
	function schedLeaves($type,$id="",$start,$end,$center="")
	{
		
		switch($type)
		{
			case 'Center':		{	
									$days=$this->dateDiff($start, $end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
									//echo var_dump($groups);
									$range = array($start); 
									while ($start != $end) 
									{ 
										$start=date('Y-m-d', strtotime($start.' +1 day')); 
										$range[] = $start; 
									} 
									foreach($groups as $g):
										//$range=range($start,$end);
										$g_result=$this->getschedLeaves($range,$g[start_date],$g[end_date],$g[id],$days);
										$groups1=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND (id != '$g[id]') AND ('$g_result[date_end]' BETWEEN start_date AND end_date)");
										foreach($groups1 as $g1):
											$range1result=range($start,$end);
											//$range1=range($g1[start_date],$g_result[date_end]);
											//echo $g1[start_date]."-".$g1[end_date]."<BR/>";
											
											$range1 = array($g1[start_date]); 
											while ($g1[start_date] != $g_result[date_end]) 
											{ 
												$g1[start_date]=date('Y-m-d', strtotime($g1[start_date].' +1 day')); 
												$range1[] = $g1[start_date]; 
											}
											if(in_array($g1[start_date],$range1))
											{
												$second_start_date=date('Y-m-d', strtotime($g_result[date_end].' +1 day')); 
												$second_end_date=date('Y-m-d', strtotime($g1[end_date].' +'.$days.' day'));
												//echo "UPDATE TO DB:".$second_start_date."-".$second_end_date;
												$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$g1[id]'");
											}
											else
											{$g1_result=$this->getschedLeaves($range1result,$g1[start_date],$g1[end_date],$g1[id],$days);}
										endforeach;
									endforeach;
									
									
								}break;
			case 'Teacher':		{	
									
									$days=$this->dateDiff($start, $end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
									//echo var_dump($groups);
									$range = array($start); 
									while ($start != $end) 
									{ 
										$start=date('Y-m-d', strtotime($start.' +1 day')); 
										$range[] = $start; 
									} 
									foreach($groups as $g):
										$g_result=$this->getschedLeaves($range,$g[start_date],$g[end_date],$g[id],$days);
										$groups1=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND (id != '$g[id]') AND ('$g_result[date_end]' BETWEEN start_date AND end_date)");
										foreach($groups1 as $g1):
											$range1result=range($start,$end);
											//$range1=range($g1[start_date],$g_result[date_end]);
											//echo $g1[start_date]."-".$g1[end_date]."<BR/>";
											$range1 = array($g1[start_date]); 
											while ($g1[start_date] != $g_result[date_end]) 
											{ 
												$g1[start_date]=date('Y-m-d', strtotime($g1[start_date].' +1 day')); 
												$range1[] = $g1[start_date]; 
											}
											if(in_array($g1[start_date],$range1))
											{
												$second_start_date=date('Y-m-d', strtotime($g_result[date_end].' +1 day')); 
												$second_end_date=date('Y-m-d', strtotime($g1[end_date].' +'.$days.' day'));
												//echo "UPDATE TO DB:".$second_start_date."-".$second_end_date;
												$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$g1[id]'");
											}
											else
											{$g1_result=$this->getschedLeaves($range1result,$g1[start_date],$g1[end_date],$g1[id],$days);}
										endforeach;
									endforeach;
								}break;
			case 'Exam':		{	echo $type.$id.$start.$end;
									$days=$this->dateDiff($start, $end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE (group_name='$id' AND centre_id='$center') AND (('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date))");
									echo var_dump($groups);
									$range = array($start); 
									while ($start != $end) 
									{ 
										$start=date('Y-m-d', strtotime($start.' +1 day')); 
										$range[] = $start; 
									} 
									foreach($groups as $g):
										$g_result=$this->getschedLeaves($range,$g[start_date],$g[end_date],$g[id],$days);
										$groups1=$this->genericQuery("SELECT * FROM student_group WHERE (group_name='$id' AND centre_id='$center') AND (id != '$g[id]') AND ('$g_result[date_end]' BETWEEN start_date AND end_date)");
										//echo var_dump($groups1);
										foreach($groups1 as $g1):
											$range1result=range($start,$end);
											//$range1=range($g1[start_date],$g_result[date_end]);
											//echo $g1[start_date]."-".$g1[end_date]."<BR/>";
											$range1 = array($g1[start_date]); 
											while ($g1[start_date] != $g_result[date_end]) 
											{ 
												$g1[start_date]=date('Y-m-d', strtotime($g1[start_date].' +1 day')); 
												$range1[] = $g1[start_date]; 
											}
											if(in_array($g1[start_date],$range1))
											{
												$second_start_date=date('Y-m-d', strtotime($g_result[date_end].' +1 day')); 
												$second_end_date=date('Y-m-d', strtotime($g1[end_date].' +'.$days.' day'));
												//echo "UPDATE TO DB:".$second_start_date."-".$second_end_date;
												$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$g1[id]'");
											}
											else
											{$g1_result=$this->getschedLeaves($range1result,$g1[start_date],$g1[end_date],$g1[id],$days);}
										endforeach;
									endforeach;
								}break;
			default:			{}break;
		}
		
		
	}
	function updategetschedLeaves($end_date,$days,$count_days)
	{
		if($days>$count_days)
		{	
			//echo $days.$count_days;
			$update_days = $days - $count_days;
			$new_end_date=date('Y-m-d',strtotime($end_date.'- '.$update_days.'  day'));
		}
		elseif($days==$count_days)
		{
			$update_days = $days;
			$new_end_date=date('Y-m-d',strtotime($end_date.'+ 0  day'));
		}
		else
		{	
			$update_days = $count_days - $days ;
			$new_end_date=date('Y-m-d',strtotime($end_date.'+ '.$update_days.'  day'));
		}
		/*
			$day=date('D',strtotime($end_date.'+'.$updatedays.'  day'));
			switch($day)
			{	case 'Fri':	{$days=$days+2;}break;
				case 'Sat':	{$days=$days+1;}break;
				default:	{$days=$days;}break;
			}
		*/
		return array('date_end'=>$new_end_date);
	}
	function updateSchedLeaves($type,$id="",$start,$end,$center_id="")
	{
		switch($type)
		{
			case 'Center':		{
									$center=$this->strRecordID("centre_vacation","centre_id,no_days","id='$id'");
									$days=$center[no_days];
									$count_days = $this->dateDiff($start,$end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE id='$center_id' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
									foreach($groups as $g):
										$g_result=$this->updategetschedLeaves($g[end_date],$days,$count_days);
										//echo $g[end_date]."<BR/>".$g_result[date_end]."<BR/>".$g[id];
										$this->updateTable("centre_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
										$this->updateTable("student_group","end_date='$g_result[date_end]'","id='$g[id]'");
										$groups1=$this->genericQuery("SELECT * FROM student_group WHERE (id != '$g[id]') AND ('$g_result[date_end]' BETWEEN start_date AND end_date)");
										foreach($groups1 as $g1):
											//echo $g1[id];//.$g1[start_date].$g1[end_date];
											$second_start_date=date('Y-m-d',strtotime($g_result[date_end].' +1 day')); 
											$second_end_date=$this->updategetschedLeaves($g1[end_date],$days,$count_days);
											//echo "<BR/>".$second_start_date."<BR/>".$second_end_date[date_end]."<BR/>".$g1[id];
											//echo "UPDATE TO DB:".$second_start_date."-".$second_end_date;
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date[date_end]'","id='$g1[id]'");
										endforeach;
									endforeach;
								}break;
			case 'Teacher':		{
									$teacher_id=$center_id;
									$teacher=$this->strRecordID("teacher_vacation","no_days","id='$id'");
									$days=$teacher[no_days];
									$count_days = $this->dateDiff($start,$end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher_id' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
									foreach($groups as $g):
										$g_result=$this->updategetschedLeaves($g[end_date],$days,$count_days);
										//echo $g[end_date]."<BR/>".$g_result[date_end]."<BR/>".$g[id];
										$this->updateTable("teacher_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
										$this->updateTable("student_group","end_date='$g_result[date_end]'","id='$g[id]'");
										$groups1=$this->genericQuery("SELECT * FROM student_group WHERE (id != '$g[id]') AND ('$g_result[date_end]' BETWEEN start_date AND end_date)");
										foreach($groups1 as $g1):
											//echo $g1[id];//.$g1[start_date].$g1[end_date];
											$second_start_date=date('Y-m-d',strtotime($g_result[date_end].' +1 day')); 
											$second_end_date=$this->updategetschedLeaves($g1[end_date],$days,$count_days);
											//echo "<BR/>".$second_start_date."<BR/>".$second_end_date[date_end]."<BR/>".$g1[id];
											//echo "UPDATE TO DB:".$second_start_date."-".$second_end_date;
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date[date_end]'","id='$g1[id]'");
										endforeach;
									endforeach;
								}break;
			case 'Exam':		{
									$exam=$this->strRecordID("exam_vacation","name,no_days","id='$id'");
									$group_name=$exam[name];
									
									$count_days = $this->dateDiff($start,$end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE group_name='$group_name' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
									foreach($groups as $g):
										$g_result=$this->updategetschedLeaves($g[end_date],$days,$count_days);
										//echo "<BR/>".$g_result[date_end].$g[id];
										$this->updateTable("exam_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
										$this->updateTable("student_group","end_date='$g_result[date_end]'","id='$g[id]'");
									endforeach;
								}break;
		}
	}
	function deleteSchedLeaves($type,$id="")
	{
		switch($type)
		{
			case 'Center':		{	
									
									$center=$this->strRecordID("centre_vacation","centre_id,no_days,frm,tto","id='$id'");
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND ('$center[frm]' BETWEEN start_date AND end_date) OR ('$center[tto]' BETWEEN start_date AND end_date)");
									$days=$center[no_days];
									foreach($groups as $g):
										$new_end_date=date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day'));
										$this->updateTable("student_group","end_date='$new_end_date'","id='$g[id]'");
										$current_group_end_date=strtotime($g['end_date'] .'+ 1 week');
										$group1_end_date=date('Y-m-d',$current_group_end_date);
										$groups1=$this->genericQuery("SELECT * FROM student_group WHERE (id != '$g[id]') AND ('$group1_end_date' BETWEEN start_date AND end_date)");
										
										foreach($groups1 as $g1):
											$second_start_date=date('Y-m-d',strtotime($new_end_date.' +1 day')); 
											$second_end_date=date('Y-m-d',strtotime($g1[end_date] .'- '.$days.'  day'));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$g1[id]'");
										endforeach;
									endforeach;
									
								}break;
			case 'Teacher':		{
									$teacher=$this->strRecordID("teacher_vacation","teacher_id,no_days,frm,tto","id='$id'");
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher[teacher_id]' AND ('$teacher[frm]' BETWEEN start_date AND end_date) OR ('$teacher[tto]' BETWEEN start_date AND end_date)");
									$days=$teacher[no_days];
									foreach($groups as $g):
										$new_end_date=date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day'));
										$this->updateTable("student_group","end_date='$new_end_date'","id='$g[id]'");
										$current_group_end_date=strtotime($g['end_date'] .'+ 1 week');
										$group1_end_date=date('Y-m-d',$current_group_end_date);
										$groups1=$this->genericQuery("SELECT * FROM student_group WHERE (id != '$g[id]') AND ('$group1_end_date' BETWEEN start_date AND end_date)");
										foreach($groups1 as $g1):
											$second_start_date=date('Y-m-d',strtotime($new_end_date.' +1 day')); 
											$second_end_date=date('Y-m-d',strtotime($g1[end_date] .'- '.$days.'  day'));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$g1[id]'");
										endforeach;
									endforeach;
								}break;
			case 'Exam':		{
									$exam=$this->strRecordID("exam_vacation","name,no_days","id='$id'");
									$group_name=$exam[name];
									$days=$exam[no_days];
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE group_name='$group_name' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
									foreach($groups as $g):
										$new_end_date=date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day'));
										$this->updateTable("student_group","end_date='$new_end_date'","id='$g[id]'");
									endforeach;
								}break;
			default:			{}break;
		}
	}
	function pullSchedule($group)
	{	//echo "Function".$group."<BR/>";
		$prev_num = $this->countRows('student_group_dtls',"parent_id='$group'")-1;
		$new_group = $this->strRecordID("group_size","units","(size_to>='$prev_num' And size_from<='$prev_num')");
		$current_group=$this->strRecordID("student_group","*","id='$group'");
		$teacher_id=$current_group[teacher_id];
		if($new_group[units] < $current_group[units])
		{
			
			$weeks=$new_group[units]/10;
			$compute_date = strtotime($current_group['start_date'] .'+ '.$weeks.' week');
			$end_date=date('Y-m-d',$compute_date);
			$current_group_end_date=strtotime($current_group['end_date'] .'+ 1 week');
			$group1_end_date=date('Y-m-d',$current_group_end_date);
			$second_group=$this->genericQuery(" SELECT * FROM student_group 
												WHERE teacher_id='$teacher_id' 
												AND (id != '$current_group[id]') 
												AND ('$group1_end_date' BETWEEN start_date AND end_date)");
			if(empty($second_group) || $second_group==NULL)
			{	//echo "Group 1:".$group."-".$new_group[units]."-".$end_date."<BR/>";
				$this->updateTable("student_group","units='$new_group[units]',end_date='$end_date'","id='$group'");
			}
			else
			{
				foreach($second_group as $sg):
					$second_group_id=$sg[id];
					$second_count_weeks=$sg[units]/10;
					$second_group_end_date=strtotime($sg['end_date'] .'+ 1 week');
				endforeach;
				$group2_end_date=date('Y-m-d',$second_group_end_date);
				$third_group= $this->genericQuery(" SELECT * FROM student_group 
													WHERE teacher_id='$teacher_id' 
													AND (id != '$group' AND id !='$second_group[id]')
													AND ('$group2_end_date' BETWEEN start_date AND end_date)");
				if(empty($third_group) || $third_group==NULL)
				{
					$this->updateTable("student_group","units='$new_group[units]',end_date='$end_date'","id='$group'");
					$second_start_date=date('Y-m-d',strtotime($end_date.' +1 day')); 
					$second_compute_date = strtotime($second_start_date .'+ '.$second_count_weeks.' week');
					$second_end_date=date('Y-m-d',$second_compute_date);
					$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$second_group_id'");
					//echo "Group 1".$group.$new_group[units].$end_date."<BR/>";
					//echo "Group 2".$second_group_id.$second_start_date.$second_end_date."<BR/>";
				}
				else
				{
					foreach($third_group as $tg):
						$third_group_id=$tg[id];
						$third_count_weeks=$tg[units]/10;
					endforeach;
					$this->updateTable("student_group","units='$new_group[units]',end_date='$end_date'","id='$group'");
					$second_start_date=date('Y-m-d',strtotime($end_date.' +1 day')); 
					$second_compute_date = strtotime($second_start_date .'+ '.$second_count_weeks.' week');
					$second_end_date=date('Y-m-d',$second_compute_date);
					$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$second_group_id'");
					$third_start_date=date('Y-m-d',strtotime($second_end_date.'+1 day')); 
					$third_compute_date = strtotime($third_start_date .'+ '.$third_count_weeks.' week');
					$third_end_date=date('Y-m-d',$third_compute_date);
					//echo "Group 1:".$group."-".$new_group[units]."-".$end_date."<BR/>";
					//echo "Group 2:".$second_group_id."-".$second_start_date.$second_end_date."<BR/>";
					//echo "Group 3:".$third_group_id."-".$third_start_date.$third_end_date."<BR/>";
					$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$third_group_id'");
				}
			}
		}
	}
}
?>