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
		$discount=($discount_amount / $course_fee) * 100;
		return round($discount,2);
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
		$string = $string.' ('.$group["group_name"].', '.date('d/m/Y', strtotime($group["start_date"])).' - '.date('d/m/Y', strtotime($group["end_date"])).', '.$dbf->printClassTimeFormat($group["group_start_time"],$group["group_end_time"]).')';
		return $string;

	}
	
	//Get student student Balance
	function BalanceAmount($student_id, $course_id){
		
		$dbf = new User();
		
		$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
		$course = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
		$advance_discount=$dbf->getDataFromTable("student_fees","discount","student_id='$student_id' AND course_id='$course_id'");
		$camt = (($course - $res_enroll["discount"]) - $advance_discount) + $res_enroll["other_amt"];
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
	function timeSlotAvailable($teacher_id, $start_date, $start_time,$day)
	{
		$dbf = new User();
		$user_start_time=date('Hi',strtotime(date("H:i:s", strtotime($start_time)) . " +1 minutes"));
		$q=$dbf->fetchOrder(	'student_group',
								"teacher_id='$teacher_id' 
								AND ('$start_date' BETWEEN start_date AND end_date)
								AND ('$user_start_time' BETWEEN group_time And group_time_end)
								AND status !='Completed' AND class_day LIKE '%$day%'
								","");
		if(count($q)==1)
		{$result=true;}
		else{$result=false;}
		return $result;
	}
	//Get time available or not
	function teacherSlotAvailable($teacher_id,$start_date,$end_date,$start_time,$end_time,$days="")
	{
		
		$dbf = new User();
		$start = $start_time + 1;
		$end = $end_time-1;
		$s_time=(strlen($start)===3?"0".$start:$start);
		$e_time=(strlen($end)===3?"0".$end:$end);
		$q=$dbf->genericQuery("
								SELECT group_name
								FROM student_group
								WHERE teacher_id='$teacher_id'
								AND (
										(start_date BETWEEN '$start_date' AND '$end_date' OR end_date BETWEEN '$start_date' AND '$end_date')
									)
                                AND (
										('$s_time' BETWEEN group_time AND group_time_end)
										OR 
										('$e_time' BETWEEN group_time AND group_time_end)
									)
								AND status !='Completed' AND class_day LIKE '%$days%'
							  ");
		if($q <= 0 || empty($q)):
		$result=false;
		elseif($q>0):
		$result=true;
		else:
		$result=false;
		endif;
		return $result;
		
		#check dates
		/*
		$check_dates=$dbf->genericQuery("
											SELECT group_name
											FROM student_group
											WHERE teacher_id='$teacher_id'
											AND ('$start_date' BETWEEN start_date And end_date) 
												  OR
												('$end_date' BETWEEN start_date And end_date) 
												");
		if(empty($check_dates) || $check_dates==null)
		{
			echo "Add New Group...";
		}
		else
		{
			$check_time=$dbf->genericQuery("
											SELECT group_name
											FROM student_group
											WHERE teacher_id='$teacher_id'
											 AND (
										('$s_time' BETWEEN group_time AND group_time_end)
										OR 
										('$e_time' BETWEEN group_time AND group_time_end)
									)");
			if(empty($check_time) || $check_time==null)
			{
				echo "Add New Group...";
			}
			else
			{
				echo "Redirect...";
			}
		}
		echo var_dump($check_dates);
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
		
		$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift1='X' OR shift1='L' OR shift1='E')");
		$shift1 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift2='X' OR shift2='L' OR shift2='E')");
		$shift2 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift3='X' OR shift3='L' OR shift3='E')");
		$shift3 = $count_att_3["COUNT(id)"];
		
		
		$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift4='X' OR shift4='L' OR shift4='E')");
		$shift4 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift5='X' OR shift5='L' OR shift5='E')");
		$shift5 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift6='X' OR shift6='L' OR shift6='E')");
		$shift6 = $count_att_3["COUNT(id)"];
		
		
		$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift7='X' OR shift7='L' OR shift7='E')");
		$shift7 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift8='X' OR shift8='L' OR shift8='E')");
		$shift8 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND (shift9='X' OR shift9='L' OR shift9='E')");
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
	function GenerateInvoiceNo($centre_id)
	{
		$dbf = new User();
		$invoice_from = $dbf->getDataFromTable("centre","invoice_from","id='$centre_id'");
		$invoice_sl = $dbf->getDataFromTable("student_fees","MAX(id)","centre_id='$centre_id'");
		$invoice_sl +=1;
		return $inv_no = date("y").date("m").$invoice_from.str_pad($invoice_sl, 8, "0", STR_PAD_LEFT);
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
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%')";
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
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%') AND ".$alias."student_id LIKE '$stid%'";
		}else if($fname!='' && $stid=='' && $mobile!='' && $email==''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%') AND ".$alias."student_mobile LIKE '$mobile%'";
		}else if($fname!='' && $stid=='' && $mobile=='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%') AND ".$alias."email LIKE '$email%'";
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
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%') AND ".$alias."student_id LIKE '$stid%' AND ".$alias."student_mobile LIKE '$mobile%'";
		}else if($fname!='' && $stid!='' && $mobile=='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%') AND ".$alias."student_id LIKE '$stid%' AND ".$alias."email LIKE '$email%'";
		}else if($fname!='' && $stid=='' && $mobile!='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%') AND ".$alias."student_mobile LIKE '$mobile%' AND ".$alias."email LIKE '$email%'";
		}else if($fname=='' && $stid!='' && $mobile!='' && $email!=''){
			$condition = "".$alias."student_id LIKE '$stid%' AND ".$alias."student_mobile LIKE '$mobile%' AND ".$alias."email LIKE '$email%'";
		}
		//End 3.
		
		//4.
		else if($fname!='' && $stid!='' && $mobile!='' && $email!=''){
			$condition = "(".$alias."family_name LIKE '$fname%' OR ".$alias."family_name1 LIKE '$fname%' OR ".$alias."first_name LIKE '$fname%' OR ".$alias."first_name1 LIKE '$fname%') AND ".$alias."student_id LIKE  '$stid%' AND ".$alias."student_mobile LIKE '$mobile%' AND ".$alias."email LIKE '$email%'";
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
	function GetBillNo($student_id, $course_id)
	{
		$enroll=$this->genericQuery("
										SELECT e.id
										FROM student_enroll e 
										INNER JOIN student_group_dtls sgd ON e.student_id=sgd.student_id
										INNER JOIN student_group sg ON sgd.parent_id=sg.id
										WHERE e.student_id='$student_id' AND e.course_id='$course_id' AND sg.status IN('Continue','Not Started') 
									");
		foreach($enroll as $e):$enroll_id=$e['id'];endforeach;
		$enroll_dtls = (empty($enroll_id)?"":$enroll_id);
		#$enroll_dtls = $this->strRecordID('student_enroll', "*", "student_id='$student_id' And course_id='$course_id'");
		$course_dtls = $this->strRecordID('course', "*", "id='$course_id'");
		//Invoice No
		// Return values like Enrollment Serial No + Course Code + Student Serial No
		#str_pad($enroll_dtls["id"], 8, "0", STR_PAD_LEFT).$course_dtls["code"].str_pad($student_id, 8, "0", STR_PAD_LEFT);
		return $inv_no = "00".$enroll_dtls.$course_dtls["code"].str_pad($student_id, 8, "0", STR_PAD_LEFT);
	}
	# CORE SCHEDULING 
	# Created On: 9-22-2013
	# Created By: DON PAR RIVERA
	
	function scheduleCall($prev_num,$student_id,$group,$teacher_id)
	{	
		$dbf = new User();
		#$centre_id=$_SESSION['centre_id'];
		$new_enrolee=$dbf->countRows('student',"id='$student_id'");
		$total_students=$prev_num + $new_enrolee;
		$student_group=$dbf->strRecordID("student_group","start_date","id='$group'");
		$group_s_time=$this->getDataFromTable("student_group","group_time","id='$group'");
		$group_e_time=$this->getDataFromTable("student_group","group_time_end","id='$group'");
		$current_total_unit=$dbf->strRecordID("student_group","units,teacher_id,start_date,unit_per_day","id='$group'");
		$teacher_id=$current_total_unit['teacher_id'];
		$start_date=$current_total_unit['start_date'];
		$query=$dbf->genericQuery("SELECT units FROM group_size WHERE('$total_students' BETWEEN size_from AND size_to)");
		foreach($query as $q):$new_unit=$q['units'];endforeach;
		if($new_unit>$current_total_unit['units'])
		{
			$class_per_week=$this->getDataFromTable("student_group","class_per_week","id='$group'");
			$frequency=(empty($class_per_week)?5:$class_per_week);
			if($frequency==5)
			{
				$no_unit = ($new_unit/($current_total_unit['unit_per_day'] * $frequency)) * 7;	
				$new_no_units=($no_unit %2==0?intval($no_unit):ceil($no_unit));
				$dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($student_group['start_date'])) . "+$new_no_units day"));
				$end_date=$dbf->printClassChangedEndDate($dt1);
			}
			else
			{
				$nno_unit = ($new_unit/($current_total_unit['unit_per_day'] * $frequency));	
				$no_unit = floor($nno_unit) * 7;	
				$new_no_units=($no_unit %2==0?intval($no_unit):ceil($no_unit));
				$dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($student_group['start_date'])) . "+$new_no_units day"));
				$end_date=$dt1;
			}
			$checknextclass= $dbf->genericQuery(" 	SELECT *
													FROM student_group
													WHERE teacher_id='$teacher_id' 
													AND id != '$group'
													AND ('$end_date' BETWEEN start_date AND end_date)
													AND (
															('$group_s_time' BETWEEN group_time AND group_time_end)
															OR 
															('$group_e_time' BETWEEN group_time AND group_time_end)
														)
													AND status NOT IN('Completed','Continue')
												");
			if(empty($checknextclass) || $checknextclass==NULL)
			{//echo"1";
				$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
				#$total_ped_units=$max_ped['max'] *  $current_total_unit['unit_per_day'];
				$total_ped_units=$max_ped['max'];
				if(empty($max_ped) || $max_ped==NULL)
				{	#echo"2";
					$dbf->updateTable("student_group","units='$new_no_units',end_date='$end_date'","id='$group'");
				}
				else
				{	#echo"3";
					$adj=$dbf->computeAdjustments($total_students,$current_total_unit['units'],$total_ped_units,$new_unit);
					$new_computed_units=$adj['units'];
					$dbf->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
				}
			}
			else
			{ //echo "query";
				foreach($checknextclass as $next_class):
					$nc_group_id=$next_class['id'];
					$nc_start_date=$next_class['start_date'];
					$nc_end_date=$next_class['end_date'];
					$nc_group_s_time=$this->getDataFromTable("student_group","group_time","id='$nc_group_id'");
					$nc_group_e_time=$this->getDataFromTable("student_group","group_time_end","id='$nc_group_id'");
					$nc_class_per_week=$next_class['class_per_week'];
					$nc_frequency=(empty($nc_class_per_week)?5:$nc_class_per_week);
					if($nc_frequency==5)
					{
						$nc_units=($next_class['units'] / ($next_class['unit_per_day'] * $nc_frequency)) * 7;
						$nc_set_unit=$next_class['units'];
						$nc_set_days=($nc_units %2==0?intval($nc_units):ceil($nc_units));
						$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 1 day'));
						$new_nc_compute_date=$dbf->printClassEndDate($nc_compute_date);
						$nc_dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($new_nc_compute_date)) . "+$nc_set_days day"));
						$nc_compute_end_date=$dbf->printClassChangedEndDate($nc_dt1);
					}
					else
					{
						$nnc_units=($next_class['units'] / ($next_class['unit_per_day'] * $nc_frequency));
						$nc_units=floor($nnc_units) * 7;
						$nc_set_unit=$next_class['units'];
						$nc_set_days=($nc_units %2==0?intval($nc_units):ceil($nc_units));
						$nc_compute_date = date('Y-m-d',strtotime($end_date .'+ 1 day'));
						$new_nc_compute_date=$dbf->printClassEndDate($nc_compute_date);
						$nc_dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($new_nc_compute_date)) . "+$nc_set_days day"));
						$nc_compute_end_date=$nc_dt1;
					}
					$thirdchecknextclass= $dbf->genericQuery(" 	SELECT *
																FROM student_group
																WHERE teacher_id='$teacher_id' 
																AND (id != '$group' AND id !='$nc_group_id')
																AND ('$nc_compute_end_date' BETWEEN start_date AND end_date)
																AND (
																		('$nc_group_s_time' BETWEEN group_time AND group_time_end)
																		OR 
																		('$nc_group_e_time' BETWEEN group_time AND group_time_end)
																	)
																AND status NOT IN('Completed','Continue')
															");
					if(empty($thirdchecknextclass) || $thirdchecknextclass==NULL)
					{	
						$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
						$total_ped_units=$max_ped['max'];
						if(empty($max_ped) || $max_ped==NULL)
						{	
							$dbf->updateTable("student_group","units='$new_no_units',end_date='$end_date'","id='$group'");
						}
						else
						{	
							$adj=$dbf->computeAdjustments($total_students,$current_total_unit['units'],$total_ped_units,$new_unit);
							$new_computed_units=$adj[units];
							$dbf->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
						}
						$dbf->updateTable("student_group","units='$nc_set_unit',start_date='$new_nc_compute_date',end_date='$nc_compute_end_date'","id='$nc_group_id'");
					}
					else
					{	
						foreach($thirdchecknextclass as $third_class):
							$thirdc_group_id=$third_class['id'];
							$thirdc_start_date=$third_class['start_date'];
							$thirdc_end_date=$third_class['end_date'];
							$thirdc_class_per_week=$third_class['class_per_week'];
							$thirdc_frequency=(empty($thirdc_class_per_week)?5:$thirdc_class_per_week);
							if($thirdc_frequency==5)
							{
								$thirdc_units=($third_class['units'] / ($third_class['unit_per_day'] * $thirdc_frequency)) * 7;
								$thirdc_set_unit=$third_class['units'];
								$thirdc_set_days=($thirdc_units %2==0?intval($thirdc_units):ceil($thirdc_units));
								$thirdc_compute_date = date('Y-m-d',strtotime($nc_compute_end_date .'+ 1 day'));
								$new_thirdc_compute_date=$dbf->printClassEndDate($thirdc_compute_date);
								$thirdc_dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($new_thirdc_compute_date)) . "+$thirdc_set_days day"));
								$thirdc_compute_end_date=$dbf->printClassChangedEndDate($thirdc_dt1);
							}
							else
							{
								$tthirdc_units=($third_class['units'] / ($third_class['unit_per_day'] * $thirdc_frequency));
								$thirdc_units=floor($tthirdc_units) * 7;
								$thirdc_set_unit=$third_class['units'];
								$thirdc_set_days=($thirdc_units %2==0?intval($thirdc_units):ceil($thirdc_units));
								$thirdc_compute_date = date('Y-m-d',strtotime($nc_compute_end_date .'+ 1 day'));
								$new_thirdc_compute_date=$dbf->printClassEndDate($thirdc_compute_date);
								$thirdc_dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($new_thirdc_compute_date)) . "+$thirdc_set_days day"));
								$thirdc_compute_end_date=$thirdc_dt1;
							}
						endforeach;
						
						$max_ped=$dbf->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
						$total_ped_units=$max_ped['max'];
						//echo var_dump($max_ped);
						if(empty($max_ped) || $max_ped==NULL)
						{	
							$dbf->updateTable("student_group","units='$new_no_units',end_date='$end_date'","id='$group'");
						}
						else
						{	
							$adj=$dbf->computeAdjustments($total_students,$current_total_unit['units'],$total_ped_units,$new_unit);
							$new_computed_units=$adj[units];
							$dbf->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
						}
						$dbf->updateTable("student_group","units='$nc_set_unit',start_date='$new_nc_compute_date',end_date='$nc_compute_end_date'","id='$nc_group_id'");
						$dbf->updateTable("student_group","units='$thirdc_set_unit',start_date='$new_thirdc_compute_date',end_date='$thirdc_compute_end_date'","id='$thirdc_group_id'");
					}
				endforeach;
			}
		}
	}
	function computeAdjustments($total_students,$current_total_unit,$max_ped,$new_unit)
	{
		$dbf = new User();
		#echo "TOTAL UPDATED STUDENTS:".$total_students."<BR/>";
		#echo "CURRENT UNITS:".$current_total_unit."<BR/>";
		#echo "GET CURRENT UNITS USED PED CARD:".$max_ped."<BR/>";
		#echo "COURSE COMPLETED:";
		$current_course_completed=($max_ped) / $current_total_unit;
		#echo "<BR/>PERCENTAGE WITH UPDATED UNIT/S:";
		$percentage_with_new_unit=$current_course_completed * $new_unit;
		#echo "<BR/>UPDATED UNIT:";
		$updated_unit=$new_unit - $percentage_with_new_unit;
			if($updated_unit % 2==0):
				$new_computed_units=intval($updated_unit);//floor($updated_unit);(integer) trim('.', $one);
			else:
				$new_computed_units=ceil($updated_unit);
			endif;
		#echo "-".$new_computed_units;
		//$result=array("units"=>$new_computed_units);
		$result=array("units"=>$new_unit);
		return $result;
	}
	
	function getschedLeaves($range,$start,$end,$group_id,$s_days)
	{		
		if(in_array($start,$range))
		{
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
			#$this->updateTable("student_group","start_date='$new_start_date',end_date='$new_end_date'","id='$group_id'");
			#UPDATE CALL DISABLED MARCH 02 2014
			#$this->updateTable("student_group","end_date='$new_end_date'","id='$group_id'");
			#UPDATE CALL DISABLED MARCH 02 2014
			#echo $group_id."-".$new_start_date.$new_end_date."<BR/>";
			
		}
		else
		{
			$days=date('D',strtotime($end.'+ '.$s_days.'  day'));
			switch($days)
			{	case 'Fri':	{$days=$s_days+2;}break;
				case 'Sat':	{$days=$s_days+1;}break;
				default:	{$days=$s_days;}break;
			}
			$new_end_date=date('Y-m-d',strtotime($end.'+ '.$days.'  day'));
			#$this->updateTable("student_group","end_date='$new_end_date'","id='$group_id'");
			//echo $new_start_date.$new_end_date."<BR/>";
			
		}
		return array('date_end'=>$new_end_date);
	}
	function schedLeaves($type,$id="",$start,$end,$center="")
	{
		switch($type)
		{
			case 'Center':	{
								$days=$this->dateDiff($start, $end)+1;
								#echo "<BR/>";
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND ('$start' BETWEEN start_date AND end_date OR '$end' BETWEEN start_date AND end_date) AND status !='Completed' ORDER BY id ASC");
								foreach($groups as $g):
									$group_id=$g['id'];
									$g1_keys[]=$group_id;
									$status=$g['status'];
									switch($status)
									{
										case 'Not Started':	{
																$first_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['start_date'].' +'.$days.' day'))); 
																$frequency=$g['class_per_week'];
																$first_total_days=$this->printUnitToDays($g['units'],$g['unit_per_day'],$frequency);
																$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($first_start_date.' +'.$first_total_days.' day')));
																$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date'","id='$group_id'");
															}break;
										case 'Continue':	{
																$first_start_date=$g['start_date'];
																$first_end_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day'))); 
																$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
															}break;
									}
									#echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
								endforeach;
								$groups2=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND ('$first_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
								foreach($groups2 as $g2):
									$group2_id=$g2['id'];
									$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
									$g2_frequency=$g2['class_per_week'];
									$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
									$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
									$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
									#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									$g2_keys[]=$group2_id;
								endforeach;
								$merge=array_merge($g1_keys,$g2_keys);
								$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
								$groups3=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
								foreach($groups3 as $g3):
									$group3_id=$g3['id'];
									$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$g3_frequency=$g3['class_per_week'];
									$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
									$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
									$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
									#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
								endforeach;
							}break;	
			case 'Teacher':	{	
								$days=$this->dateDiff($start, $end)+1;
								#echo "<BR/>";
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$start' BETWEEN start_date AND end_date OR '$end' BETWEEN start_date AND end_date) AND status !='Completed' ORDER BY id ASC");
								foreach($groups as $g):
									$group_id=$g['id'];
									$g1_keys[]=$group_id;
									$status=$g['status'];
									switch($status)
									{
										case 'Not Started':	{
																$first_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['start_date'].' +'.$days.' day'))); 
																$frequency=$g['class_per_week'];
																$first_total_days=$this->printUnitToDays($g['units'],$g['unit_per_day'],$frequency);
																$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($first_start_date.' +'.$first_total_days.' day')));
																$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date'","id='$group_id'");
															}break;
										case 'Continue':	{
																$first_start_date=$g['start_date'];
																$first_end_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day'))); 
																$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
															}break;
									}
									#echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
								endforeach;
								$groups2=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$first_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
								foreach($groups2 as $g2):
									$group2_id=$g2['id'];
									$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
									$g2_frequency=$g2['class_per_week'];
									$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
									$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
									$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
									#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									$g2_keys[]=$group2_id;
								endforeach;
								$merge=array_merge($g1_keys,$g2_keys);
								$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
								$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
								foreach($groups3 as $g3):
									$group3_id=$g3['id'];
									$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$g3_frequency=$g3['class_per_week'];
									$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
									$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
									$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
									#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
								endforeach;
							}break;
			case 'Exam':	{	
								#echo $start.$end;
								$groups = $this->genericQuery(" SELECT * FROM student_group WHERE group_name='$id'");
								$days=$this->dateDiff($start, $end)+1;
								#echo "<BR/>";
								foreach($groups as $g):
									$group_id=$g['id'];
									$teacher_id=$g['teacher_id'];
									$start_time=$g['group_time'];
									$end_time=$g['group_time_end'];
									$first_end_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day'))); 
									$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
									#echo "Loop 1:".$group_id.$first_end_date."<BR/>";
									$groups2= $this->genericQuery("
																SELECT * FROM student_group 
																WHERE (id !='$g[id]' AND teacher_id='$teacher_id') 
																AND ((start_date BETWEEN '$start' AND '$end' OR end_date BETWEEN '$start' AND '$end'))
																AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end))
															");
									foreach($groups2 as $g2):
										$group2_id=$g2['id'];
										$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
										$g2_frequency=$g2['class_per_week'];
										$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
										$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
										$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
										#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									endforeach;
									$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end)) ");
									foreach($groups3 as $g3):
										$group3_id=$g3['id'];
										$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
										$g3_frequency=$g3['class_per_week'];
										$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
										$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
										$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
										#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
									endforeach;
								endforeach;
							}break;
			default:		{}break;		
		}
	}
	function updategetschedLeaves($end_date,$days,$count_days)
	{
		if($days>$count_days)
		{	
			
			$update_days = $days - $count_days;
			$new_end_date=$this->printClassEndDate(date('Y-m-d',strtotime($end_date.'- '.$update_days.'  day')));
			#echo $new_end_date;
		}
		elseif($days==$count_days)
		{
			$update_days = $days;
			$new_end_date=$this->printClassEndDate(date('Y-m-d',strtotime($end_date.'+ 0  day')));
			
		}
		else
		{	
			$update_days = $count_days - $days ;
			$new_end_date=$this->printClassEndDate(date('Y-m-d',strtotime($end_date.'+ '.$update_days.'  day')));
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
			case 'Center':	{
								$center=$this->strRecordID("centre_vacation","centre_id,no_days","id='$id'");
								$days=$center[no_days];
								$count_days = $this->dateDiff($start,$end)+1;
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND ('$start' BETWEEN start_date AND end_date OR '$end' BETWEEN start_date AND end_date) AND status !='Completed' ORDER BY id DESC");
								foreach($groups as $g):
									$group_id=$g['id'];
									$g1_keys[]=$group_id;
									$status=$g['status'];
									switch($status)
									{
										case 'Not Started':	{	$g_result=$this->updategetschedLeaves($g[start_date],$days,$count_days);
																$first_start_date=$this->printClassEndDate($g_result['date_end']);
																$frequency=$g['class_per_week'];
																$first_total_days=$this->printUnitToDays($g['units'],$g['unit_per_day'],$frequency);
																$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($first_start_date.' +'.$first_total_days.' day')));
																$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date'","id='$group_id'");
															}break;
										case 'Continue':	{
																$first_start_date=$g['start_date'];
																$g_result=$this->updategetschedLeaves($g['end_date'],$days,$count_days);
																$first_end_date=$this->printClassEndDate($g_result['date_end']); 
																$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
															}break;
									}
									$this->updateTable("centre_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
									$parameter_end_date=date('Y-m-d', strtotime($first_end_date.' +2 week'));
									#echo "<BR/>";
									#echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
								endforeach;
								$groups2=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center_id' AND ('$parameter_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
								foreach($groups2 as $g2):
									$group2_id=$g2['id'];
									$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
									$g2_frequency=$g2['class_per_week'];
									$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
									$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
									$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
									#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									$g2_keys[]=$group2_id;
								endforeach;
								$merge=array_merge($g1_keys,$g2_keys);
								$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
								$groups3=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
								foreach($groups3 as $g3):
									$group3_id=$g3['id'];
									$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$g3_frequency=$g3['class_per_week'];
									$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
									$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
									$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
									#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
								endforeach;
							}break;
			case 'Teacher':	{
								
								$teacher_id=$center_id;
								$teacher=$this->strRecordID("teacher_vacation","no_days","id='$id'");
								$days=$teacher[no_days];
								$count_days = $this->dateDiff($start,$end)+1;
								echo "<BR/>";
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher_id' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date) AND status !='Completed' ORDER BY id DESC");
								foreach($groups as $g):
									$group_id=$g['id'];
									$g1_keys[]=$group_id;
									$status=$g['status'];
									switch($status)
									{
										case 'Not Started':	{	$g_result=$this->updategetschedLeaves($g[start_date],$days,$count_days);
																$first_start_date=$this->printClassEndDate($g_result['date_end']);
																$frequency=$g['class_per_week'];
																$first_total_days=$this->printUnitToDays($g['units'],$g['unit_per_day'],$frequency);
																$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($first_start_date.' +'.$first_total_days.' day')));
																$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date'","id='$group_id'");
															}break;
										case 'Continue':	{
																$first_start_date=$g['start_date'];
																$g_result=$this->updategetschedLeaves($g['end_date'],$days,$count_days);
																$first_end_date=$this->printClassEndDate($g_result['date_end']); 
																$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
															}break;
									}
									$this->updateTable("teacher_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
									$parameter_end_date=date('Y-m-d', strtotime($first_end_date.' +2 week'));
									#echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
								endforeach;
								$groups2=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher_id' AND ('$parameter_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
								foreach($groups2 as $g2):
									$group2_id=$g2['id'];
									$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
									$g2_frequency=$g2['class_per_week'];
									$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
									$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
									$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
									#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									$g2_keys[]=$group2_id;
								endforeach;
								$merge=array_merge($g1_keys,$g2_keys);
								$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
								$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher_id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
								foreach($groups3 as $g3):
									$group3_id=$g3['id'];
									$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$g3_frequency=$g3['class_per_week'];
									$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
									$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
									$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
									#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
								endforeach;
							}break;
			case 'Exam':	{
									$exam=$this->strRecordID("exam_vacation","name,no_days","id='$id'");
									$group_name=$exam[name];
									$days=$exam[no_days];
									$count_days = $this->dateDiff($start,$end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE group_name='$group_name'");
									foreach($groups as $g):
									$teacher_id=$g['teacher_id'];
									$start_time=$g['group_time'];
									$end_time=$g['group_time_end'];
									$g_result=$this->updategetschedLeaves($g[end_date],$days,$count_days);
									#echo "Loop 1:".$g[id].$g[end_date].$g_result[date_end]."<BR/>";
									$this->updateTable("exam_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
									$this->updateTable("student_group","end_date='$g_result[date_end]'","id='$g[id]'");
									$first_end_date=$g_result[date_end];
									$parameter_end_date=date('Y-m-d', strtotime($g_result[date_end].' +2 week'));
									$groups2= $this->genericQuery("
																SELECT * FROM student_group 
																WHERE (id !='$g[id]' AND teacher_id='$teacher_id') 
																AND ((start_date BETWEEN '$start' AND '$parameter_end_date' OR end_date BETWEEN '$start' AND '$parameter_end_date'))
																AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end))
															");
										foreach($groups2 as $g2):
											$group2_id=$g2['id'];
											$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day')));
											$g2_frequency=$g2['class_per_week'];
											$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
											$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
											#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
										endforeach;
										$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
										$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end)) ");
										foreach($groups3 as $g3):
											$group3_id=$g3['id'];
											$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
											$g3_frequency=$g3['class_per_week'];
											$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
											$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
											$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
											#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
										endforeach;
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
									$days=$center[no_days];
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND ('$center[frm]' BETWEEN start_date AND end_date) OR ('$center[tto]' BETWEEN start_date AND end_date) AND status !='Completed' ORDER BY end_date DESC");
									foreach($groups as $g):
										$group_id=$g['id'];
										$g1_keys[]=$group_id;
										$status=$g['status'];
										switch($status)
										{
											case 'Not Started':	{	
																	$first_start_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[start_date] .'- '.$days.'  day')));
																	$frequency=$g['class_per_week'];
																	$first_total_days=$this->printUnitToDays($g['units'],$g['unit_per_day'],$frequency);
																	$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($first_start_date.' +'.$first_total_days.' day')));
																	$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date'","id='$group_id'");
																}break;
											case 'Continue':	{
																	$first_start_date=$g['start_date'];
																	$first_end_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day')));
																	$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
																}break;
										}
										echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
										$parameter_end_date=date('Y-m-d', strtotime($first_end_date.' +2 week'));
									endforeach;
									$groups2=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND ('$parameter_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
									foreach($groups2 as $g2):
										$group2_id=$g2['id'];
										$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
										$g2_frequency=$g2['class_per_week'];
										$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
										$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
										$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
										#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
										$g2_keys[]=$group2_id;
									endforeach;
									$merge=array_merge($g1_keys,$g2_keys);
									$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
									$groups3=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
									foreach($groups3 as $g3):
										$group3_id=$g3['id'];
										$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day')));
										$g3_frequency=$g3['class_per_week'];
										$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
										$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
										$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
										#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
									endforeach;
								}break;
			case 'Teacher':		{
									$teacher=$this->strRecordID("teacher_vacation","teacher_id,no_days,frm,tto","id='$id'");
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher[teacher_id]' AND ('$teacher[frm]' BETWEEN start_date AND end_date) OR ('$teacher[tto]' BETWEEN start_date AND end_date) AND status !='Completed' ORDER BY end_date DESC");
									$days=$teacher[no_days];
									foreach($groups as $g):
										$group_id=$g['id'];
										$g1_keys[]=$group_id;
										$status=$g['status'];
										switch($status)
										{
											case 'Not Started':	{	
																	$first_start_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[start_date] .'- '.$days.'  day')));
																	$frequency=$g['class_per_week'];
																	$first_total_days=$this->printUnitToDays($g['units'],$g['unit_per_day'],$frequency);
																	$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($first_start_date.' +'.$first_total_days.' day')));
																	$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date'","id='$group_id'");
																}break;
											case 'Continue':	{
																	$first_start_date=$g['start_date'];
																	$first_end_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day')));
																	$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
																}break;
										}
										#echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
										$parameter_end_date=date('Y-m-d', strtotime($first_end_date.' +2 week'));
									endforeach;
									$groups2=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher[teacher_id]' AND ('$parameter_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
									foreach($groups2 as $g2):
										$group2_id=$g2['id'];
										$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
										$g2_frequency=$g2['class_per_week'];
										$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
										$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
										$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
										#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
										$g2_keys[]=$group2_id;
									endforeach;
									$merge=array_merge($g1_keys,$g2_keys);
									$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
									$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher[teacher_id]' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
									foreach($groups3 as $g3):
										$group3_id=$g3['id'];
										$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
										$g3_frequency=$g3['class_per_week'];
										$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
										$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
										$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
										#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
									endforeach;
								}break;
			case 'Exam':		{
									$exam=$this->strRecordID("exam_vacation","name,no_days","id='$id'");
									$group_name=$exam[name];
									$days=$exam[no_days];
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE group_name='$group_name'");
									foreach($groups as $g):
										$teacher_id=$g['teacher_id'];
										$start_time=$g['group_time'];
										$end_time=$g['group_time_end'];
										$new_end_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day')));
										#echo "<BR/>";
										$this->updateTable("student_group","end_date='$new_end_date'","id='$g[id]'");
										$first_end_date=date('Y-m-d', strtotime($new_end_date.' +1 day'));
										$parameter_end_date=date('Y-m-d', strtotime($new_end_date.' +2 week'));
										$groups2= $this->genericQuery("
																		SELECT * FROM student_group 
																		WHERE (id !='$g[id]' AND teacher_id='$teacher_id') 
																		AND ((start_date BETWEEN '$start' AND '$parameter_end_date' OR end_date BETWEEN '$start' AND '$parameter_end_date'))
																		AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end))
																	");
										foreach($groups2 as $g2):
											$group2_id=$g2['id'];
											$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
											$g2_frequency=$g2['class_per_week'];
											$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day'],$g2_frequency);
											$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
											#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
										endforeach;
										$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
										$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end)) ");
										foreach($groups3 as $g3):
											$group3_id=$g3['id'];
											$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
											$g3_frequency=$g3['class_per_week'];
											$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day'],$g3_frequency);
											$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
											$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
											#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
										endforeach;
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
		$teacher_id=$current_group['teacher_id'];
		$group_s_time=$this->getDataFromTable("student_group","group_time","id='$group'");
		$group_e_time=$this->getDataFromTable("student_group","group_time_end","id='$group'");
		if($new_group['units'] < $current_group['units'])
		{#echo "<BR/>Condition<BR/>";
			
			$frequency=(empty($current_group['class_per_week'])?5:$current_group['class_per_week']);
			if($frequency==5)
			{
				$no_unit = ($new_group['units']/($current_group['unit_per_day'] * $frequency)) * 7;	
				$days=($no_unit %2==0?intval($no_unit):ceil($no_unit));
				$dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($current_group['start_date'])) . "+$days day"));
				$end_date=$this->printClassChangedEndDate($dt1);
			}
			else
			{
				$nno_unit = ($new_group['units']/($current_group['unit_per_day'] * $frequency));	
				$no_unit = floor($nno_unit) * 7;	
				$days=($no_unit %2==0?intval($no_unit):ceil($no_unit));
				$dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($current_group['start_date'])) . "+$days day"));
				$end_date=$dt1;
			}
			$current_group_end_date=strtotime($current_group['end_date'] .'+ 1 week');
			$group1_end_date=date('Y-m-d',$current_group_end_date);
			$second_group=$this->genericQuery(" SELECT * FROM student_group 
												WHERE teacher_id='$teacher_id' 
												AND (id != '$current_group[id]') 
												AND ('$group1_end_date' BETWEEN start_date AND end_date)
												AND (
														('$group_s_time' BETWEEN group_time AND group_time_end)
														OR 
														('$group_e_time' BETWEEN group_time AND group_time_end)
													)
												AND status NOT IN('Completed','Continue')");
			$max_ped=$this->strRecordID("ped_units","MAX(units) as max","group_id='$group'");
			$total_ped_units=$max_ped['max'];
			if(empty($second_group) || $second_group==NULL)
			{	
				if(empty($max_ped) || $max_ped==NULL)
				{
					$this->updateTable("student_group","units='$new_group[units]',end_date='$end_date'","id='$group'");
				}
				else
				{
					$adj=$this->computeAdjustments($prev_num,$current_group['units'],$total_ped_units,$new_group['units']);
					$new_computed_units=$adj['units'];
					$this->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
				}
			}
			else
			{
				foreach($second_group as $sg):
					$second_group_id=$sg['id'];
					$sg_frequency=(empty($sg['class_per_week'])?5:$sg['class_per_week']);
					if($sg_frequency==5)
					{
						$second_count_days=($sg['units']/($sg['unit_per_day'] * $sg_frequency))* 7;
						$second_group_end_date=strtotime($sg['end_date'] .'+ 1 week');
						$second_start_date=date('Y-m-d',strtotime($end_date.' +1 day')); 
						$new_second_start_date=$this->printClassEndDate($second_start_date);
						$count_second_days=($second_count_days %2==0?intval($second_count_days):ceil($second_count_days));
						$second_dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($new_second_start_date)) . "+$count_second_days day"));
						$second_end_date=$this->printClassChangedEndDate($second_dt1);
					}
					else
					{
						$ssecond_count_days=($sg['units']/($sg['unit_per_day'] * $sg_frequency));
						$second_count_days=floor($ssecond_count_days)* 7;
						$second_group_end_date=strtotime($sg['end_date'] .'+ 1 week');
						$second_start_date=date('Y-m-d',strtotime($end_date.' +1 day')); 
						$new_second_start_date=$this->printClassEndDate($second_start_date);
						$count_second_days=($second_count_days %2==0?intval($second_count_days):ceil($second_count_days));
						$second_dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($new_second_start_date)) . "+$count_second_days day"));
						$second_end_date=$second_dt1;
					}
					$group2_end_date=date('Y-m-d',$second_group_end_date);
					$second_group_s_time=$this->getDataFromTable("student_group","group_time","id='$second_group_id'");
					$second_group_e_time=$this->getDataFromTable("student_group","group_time_end","id='$$second_group_id'");
					$third_group= $this->genericQuery(" SELECT * FROM student_group 
														WHERE teacher_id='$teacher_id' 
														AND (id != '$group' AND id !='$second_group[id]')
														AND ('$group2_end_date' BETWEEN start_date AND end_date)
														AND (
																('$second_group_s_time' BETWEEN group_time AND group_time_end)
																OR 
																('$second_group_e_time' BETWEEN group_time AND group_time_end)
															)
														AND status NOT IN('Completed','Continue')");
				
					if(empty($third_group) || $third_group==NULL)
					{
						if(empty($max_ped) || $max_ped==NULL)
						{	
							$this->updateTable("student_group","units='$new_group[units]',end_date='$end_date'","id='$group'");
							#echo "<BR/>Group 1:".$group."-".$new_group[units]."-".$end_date."<BR/>";
						}
						else
						{	
							$adj=$this->computeAdjustments($prev_num,$current_group['units'],$total_ped_units,$new_group['units']);
							$new_computed_units=$adj['units'];
							$this->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
							#echo "<BR/>Group 1:".$group."-units:".$new_computed_units."-".$end_date."<BR/>";
						}
						$this->updateTable("student_group","start_date='$new_second_start_date',end_date='$second_end_date'","id='$second_group_id'");
					}
					else
					{
						foreach($third_group as $tg):
							$third_group_id=$tg['id'];
							$tg_frequency=(empty($tg['class_per_week'])?5:$tg['class_per_week']);
							if($tg_frequency==5)
							{
								$third_count_days=($tg['units']/($tg['unit_per_day'] * $tg_frequency)) * 7;
							}
							else
							{
								$tthird_count_days=($tg['units']/($tg['unit_per_day'] * $tg_frequency));
								$third_count_days=floor($tthird_count_days) * 7;
							}
						endforeach;
						if(empty($max_ped) || $max_ped==NULL)
						{	
							$this->updateTable("student_group","units='$new_group[units]',end_date='$end_date'","id='$group'");
							//echo "<BR/>Group 1:".$group."-".$new_group[units]."-".$end_date."<BR/>";
						}
						else
						{	
							$adj=$this->computeAdjustments($prev_num,$current_group['units'],$total_ped_units,$new_group['units']);
							$new_computed_units=$adj['units'];
							$this->updateTable("student_group","units='$new_computed_units',end_date='$end_date'","id='$group'");
							#echo "<BR/>Group 1:".$group."-units:".$new_computed_units."-".$end_date."<BR/>";
						}
						$this->updateTable("student_group","start_date='$new_second_start_date',end_date='$second_end_date'","id='$second_group_id'");
						$third_start_date=date('Y-m-d',strtotime($second_end_date.'+1 day')); 
						$new_third_start_date=$this->printClassEndDate($third_start_date);
						$count_third_days=($third_count_days %2==0?intval($third_count_days):ceil($third_count_days));
						$third_dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($new_third_start_date)) . "+$count_third_days day"));
						if($tg_frequency==5)
						{
							$third_end_date=$this->printClassChangedEndDate($third_dt1);
						}
						else
						{
							$third_end_date=$third_dt1;
						}
						$this->updateTable("student_group","start_date='$new_third_start_date',end_date='$third_end_date'","id='$third_group_id'");
					}
				endforeach;
			}
		}
	}
	function printStudentName($id)
	{
		$student = $this->strRecordID("student","*","id='$id'");
		$student_name=$student[first_name]."&nbsp;".$student[father_name]."&nbsp;".$student[family_name]."&nbsp;(".$student[family_name1]."&nbsp;".$student[grandfather_name1]."&nbsp;".$student[father_name1]."&nbsp;".$student[first_name1].")";
		return $student_name;
	}
	function printBalanceAmount($student_id,$course_id)
	{
		//$res_enroll = $this->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
		$course = $this->getDataFromTable("course_fee","fees","course_id='$course_id'");
		//$camt = ($course - $res_enroll["discount"]) + $res_enroll["other_amt"];
		$fee = $this->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
		$feeamt = $fee["SUM(paid_amt)"];
		$bal_amt =$course - $feeamt;
		return  $bal_amt;
	}
	function printFundAmount($student_id,$course_id)
	{
		$fee = $this->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
		$feeamt = $fee["SUM(paid_amt)"];
		$bal_amt = $feeamt;
		return  $bal_amt;
	}
	function studentTransferFee($f_sdt,$f_stat,$cou_id,$to_cou_id,$t_sdt,$comm,$user,$ctr)
	{
		$dt = date('Y-m-d h:i:s');
		//$this->GetBillNo($student_id, $course_id);
		$inv=$this->strRecordID("student_fees","invoice_sl","course_id='$to_cou_id' And student_id='$t_sdt'");
		$invoice_sl=$inv["invoice_sl"];
		$fees_string="student_id='$t_sdt',invoice_sl='$invoice_sl',course_id='$to_cou_id',comments='$comm'";
		$this->updateTable("student_fees",$fees_string,"student_id='$f_sdt' AND course_id='$cou_id'");
		$fees_history_string="fld_name='Transfer Fee',chg_from='$f_sdt',chg_to='$t_sdt',by_user='$user',date_time='$dt',student_id='$t_sdt',centre_id='$ctr'";
		$this->insertSet("student_fee_edit_history",$fees_history_string);
		$moving="status_id='2',group_id='0'";
		$this->updateTable("student_moving",$moving,"student_id='$f_sdt'");	
		$moving_history="student_id='$f_sdt',date_time='$dt',user_id='$user',status_id='2'";
		$this->insertSet("student_moving_history",$moving_history);
	}
	function studentTransferFeeByCenter($f_sdt,$cou_id,$f_ctr,$t_ctr,$comm,$user,$ctr)
	{
		$dt = date('Y-m-d h:i:s');
		
		$inv=$this->GetBillNo($f_sdt,$cou_id);
		$fees_string="invoice_sl='$inv',centre_id='$t_ctr',comments='$comm'";
		$this->updateTable("student_fees",$fees_string,"student_id='$f_sdt' AND course_id='$cou_id'");
		$fees_history_string="fld_name='Changed Center',chg_from='$f_ctr',chg_to='$t_ctr',by_user='$user',date_time='$dt',student_id='$f_sdt',centre_id='$ctr'";
		$this->insertSet("student_fee_edit_history",$fees_history_string);
		
		$moving="status_id='3',group_id='0'";
		$this->updateTable("student_moving",$moving,"student_id='$f_sdt'");	
		$moving_history="student_id='$f_sdt',date_time='$dt',user_id='$user',status_id='3'";
		$this->insertSet("student_moving_history",$moving_history);
	}
	function studentTransferClass($f_sdt,$cou_id)
	{
		$grp=$this->strRecordID("student_group_dtls","parent_id","course_id='$cou_id' AND student_id='$f_sdt'");
		
		#Check Pull Schedule
		$this->pullSchedule($grp["parent_id"]);
		# Removing from Fees / Enrollment Table
		$this->deleteFromTable("student_enroll","course_id='$cou_id' And student_id='$f_sdt'");
		$this->deleteFromTable("student_group_dtls","course_id='$cou_id' And student_id='$f_sdt'");
	}
	function processEmail($from,$to,$message,$subject)
	{		
		$res_logo = $this->strRecordID("conditions","*","type='Logo path'");
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-6\n";
		$headers .= "From:".$from."\n";
		$body='<table border="0" cellpadding="5" cellspacing="0" style="border: 1px solid rgb(109, 146, 201);" width="662">
				<tbody>
					<tr>
						<td bgcolor="#FF9900" colspan="2" height="80">
							<img alt="" src="'.$res_logo[name].'" style="width: 105px; height: 30px;" />
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>'.$message.'</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">Thank you,
							<br />
							B</span></span><span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">erlitz AlAhsa,a Dar Al-Khibra Human Resources Development Company</span></span>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
				</table>';
		mail($to,$subject,$body,$headers);
	}
	function printClassTimeFormat($start,$end)
	{
		$s=substr($start,0,5);
		return $s."-".$end; 
	}
	function printClassEndDate($end_date)
	{
		$day= date('D',strtotime(date("Y-m-d", strtotime($end_date))));
		switch($day)
		{	
			case 'Fri':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "+2 day"));}break;
			case 'Sat':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "+1 day"));}break;
			default:	{$new_end_date=$end_date;}break;
		}
		return $new_end_date;
	}
	function printClassChangedEndDate($end_date)
	{
		$day= date('D',strtotime(date("Y-m-d", strtotime($end_date))));
		switch($day)
		{	
			case 'Sun':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "-3 day"));}break;
			case 'Mon':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "-1 day"));}break;
			case 'Tue':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "-1 day"));}break;
			case 'Wed':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "-1 day"));}break;
			case 'Thu':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "-1 day"));}break;
			case 'Fri':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "+2 day"));}break;
			case 'Sat':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "+1 day"));}break;
			default:	{$new_end_date=$end_date;}break;
		}
		return $new_end_date;
	}
	function printUnitToDays($units,$unit_per_day,$frequency)
	{
		$freq=(empty($frequency)?5:$frequency);
		$days = ($units/($unit_per_day * $freq)) * 7;	
		$total_days=($days %2==0?intval($days):ceil($days));
		return $total_days;
	}
	function reverseEndDate($end_date)
	{
		$day= date('D',strtotime(date("Y-m-d", strtotime($end_date))));
		switch($day)
		{	
			case 'Fri':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "-1 day"));}break;
			case 'Sat':	{$new_end_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($end_date)) . "-2 day"));}break;
			default:	{$new_end_date=$end_date;}break;
		}
		return $new_end_date;
	}
	function addCorporateStudent($code,$account,$sub_account,$student_id,$course_id,$user)
	{	#$acct= explode("-",$account);
		#account='$account',
		$cr_date = date('Y-m-d H:i:s A');
		$string="	code='$code',
					account='$account',
					sub_account='$sub_account',
					student_id='$student_id',
					course_id='$course_id',
					date_added='$cr_date',
					user='$user'";
		$this->insertSet("corporate_students",$string);
	}
	function extendSchedule($group,$days,$req_unit)
	{	
		$class=$this->strRecordID("student_group","*","id='$group'");
		$start=$class['end_date'];
		$end=date('Y-m-d', strtotime($start.' +'.$days.' day'));
		$id=$class['teacher_id'];
		#start,end,id(teacher)
		
		#$days=$this->dateDiff($start, $end)+1;
		#echo "<BR/>";
		$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$start' BETWEEN start_date AND end_date OR '$end' BETWEEN start_date AND end_date) AND status !='Completed' ORDER BY id ASC");
		foreach($groups as $g):
			$group_id=$g['id'];
			$g1_keys[]=$group_id;
			$status=$g['status'];
			switch($status)
			{
				case 'Not Started':	{
										$first_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['start_date'].' +'.$days.' day'))); 
										#$first_total_days=$this->printUnitToDays($req_unit,$g['unit_per_day']);
										$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day')));
										$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date',units='$req_unit'","id='$group_id'");
									}break;
				case 'Continue':	{
										$first_start_date=$g['start_date'];
										$first_end_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day'))); 
										$this->updateTable("student_group","end_date='$first_end_date',units='$req_unit'","id='$group_id'");
									}break;
			}
			echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
		endforeach;
		$groups2=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$first_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
		foreach($groups2 as $g2):
			$group2_id=$g2['id'];
			$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
			$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
			$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
			$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
			#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
			$g2_keys[]=$group2_id;
		endforeach;
		$merge=array_merge($g1_keys,$g2_keys);
		$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
		$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
		foreach($groups3 as $g3):
			$group3_id=$g3['id'];
			$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
			$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
			$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
			$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
			#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
		endforeach;
	}
	function processPayment($status,$student_id,$course_id,$payment_type,$fee,$discount)
	{
		$inv_no = $this->GenerateInvoiceNo($_SESSION['centre_id']);
		$inv_sl = $this->GetBillNo($student_id, $course_id);
		$fee_id = $this->getDataFromTable("student_enroll","fee_id","student_id='$student_id' AND course_id='$course_id'");
		$course_fee = $this->getDataFromTable("course_fee","fees","id='$fee_id'");
		$dt = date('Y-m-d h:m:s');
		$dto = date('Y-m-d');
		switch($status)
		{
			case 'advance': {
								$status="	status_id='3',
											date_time='$dt',
											user_id='$_SESSION[id]'";
								$advance="	student_id='$student_id',
											course_id='$course_id',
											paid_amt='$fee',
											fee_amt='$fee',
											fee_date='$dt',
											paid_date='$dt',
											payment_type='$payment_type',
											centre_id='$_SESSION[centre_id]',
											created_date='$dt',
											created_by='$_SESSION[id]',
											type='advance',
											invoice_sl='$inv_sl',
											invoice_no='$inv_no',
											status='1',
											discount='$discount'";
								$this->insertSet("student_fees",$advance);
								$this->updateTable("student_moving",$status,"student_id='$student_id'");	
							}break;
			case 'enroll':  {
								$enroll="	course_fee='$course_fee',
											payment_type='$payment_type',
											enroll_date='$dto',
											discount='$_POST[discount]'";
								$fee="		student_id='$student_id',
											course_id='$course_id',
											paid_amt='$fee',
											fee_amt='$fee',
											fee_date='$dt',
											paid_date='$dt',
											payment_type='$payment_type',
											centre_id='$_SESSION[centre_id]',
											created_date='$dt',
											created_by='$_SESSION[id]',
											type='opening',
											invoice_sl='$inv_sl',
											invoice_no='$inv_no',
											status='1',
											discount='$discount'";
								$status="	course_id='$course_id',
											status_id='5',
											date_time='$dt',
											user_id='$_SESSION[id]'";
								$this->insertSet("student_fees",$fee);
								$this->updateTable("student_enroll",$enroll,"course_id='$course_id' And student_id='$student_id'");
								$this->updateTable("student_moving",$status,"student_id='$student_id'");	
							}break;
		}
	}
	function groupStatus($status)
	{
		return ($status=='Continue'?'Active':$status);
	}
	function studentOnHoldPedCard($student_id,$group_id,$course_id)
	{ 
		#Transfer previous attendance to new Ped Card
		$group_dtls=$this->strRecordID("student_group", "*", "id='$group_id'");
		$attd=$group_dtls['units']/$group_dtls['unit_per_day'];
		$prev_group_id=$this->getDataFromTable("student_moving","group_id","student_id='$student_id'");
		$ped_id=$this->getDataFromTable("ped_units","ped_id","group_id='$group_id'");
		for($a=1;$a<=$attd;$a++):
			$dt = date('Y-m-d');
			$prev_ped_attd=$this->strRecordID("ped_attendance", "*", "group_id='$prev_group_id' AND unit='$a'");
			$attend_date=$this->getDataFromTable("ped_units", "dated", "group_id='$group_id' AND unit='$a'");
			$string="	ped_id='$ped_id',
						teacher_id='$group_dtls[teacher_id]',
						course_id='$course_id',
						student_id='$student_id',
						unit='$a',
						shift1='$prev_ped_attd[shift1]',
						shift2='$prev_ped_attd[shift2]',
						shift3='$prev_ped_attd[shift3]',
						shift4='$prev_ped_attd[shift4]',
						shift5='$prev_ped_attd[shift5]',
						shift6='$prev_ped_attd[shift6]',
						shift7='$prev_ped_attd[shift4]',
						shift8='$prev_ped_attd[shift5]',
						shift9='$prev_ped_attd[shift6]',
						dated='$dt', 
						group_id='$group_id',
						attend_date='$attend_date'";
			$this->insertSet("ped_attendance",$string);
		endfor;
		/*
		$prev_class=$this->genericQuery("	SELECT * FROM `ped_attendance` 
											WHERE student_id='$student_id' 
											AND course_id='$course_id' 
											AND group_id !='$group_id' 
											AND (	shift1 !='' OR 
													shift2 !='' OR 
													shift3 !='' OR 
													shift4 !='' OR 
													shift5 !='' OR 
													shift6 !='' OR 
													shift7 !='' OR 
													shift8 !='' OR 
													shift9 !='') ORDER BY unit");
		#$attd=$class['units']/$class['unit_per_day'];
		foreach($prev_class as $p_class):
		{
			$dt = date('Y-m-d');
			$new_ped_unit=$this->strRecordID("ped_units", "*", "group_id='$group_id' AND units='$p_class['unit']'");
			$string="	ped_id='$new_ped_unit[ped_id]',
						teacher_id='$new_ped_unit[teacher_id]',
						course_id='$course_id',
						student_id='$student_id',
						unit='$p_class[unit]',
						shift1='$new_ped_unit[shift1]',
						shift2='$new_ped_unit[shift2]',
						shift3='$new_ped_unit[shift3]',
						shift4='$new_ped_unit[shift4]',
						shift5='$new_ped_unit[shift5]',
						shift6='$new_ped_unit[shift6]',
						shift7='$new_ped_unit[shift4]',
						shift8='$new_ped_unit[shift5]',
						shift9='$new_ped_unit[shift6]',
						dated='$dt', 
						group_id='$group_id',
						attend_date='$new_ped_unit[attend_date]'";
			$this->insertSet("ped_attendance",$string);
		}
		*/
		#Transfer previous attendance to new Ped Card
	}
	function getInvoiceCode($student_id,$course_id)
	{
		$p_group=$this->genericQuery(" 	SELECT g.status
										FROM  `student_group` g
										INNER JOIN student_group_dtls sgd ON g.id = sgd.parent_id
										WHERE sgd.student_id =  '$student_id'
										AND g.course_id =  '$course_id'
										ORDER BY end_date DESC LIMIT 0,1
									");
		foreach($p_group as $p_grp):$previous_group_status=$p_grp['status'];endforeach;	
		$advance_fee=$this->countRows('student_fees',"student_id='$student_id' And course_id='$course_id' And type='advance'");
		$enroll=$this->genericQuery("
										SELECT e.id
										FROM student_enroll e 
										INNER JOIN student_group_dtls sgd ON e.student_id=sgd.student_id
										INNER JOIN student_group sg ON sgd.parent_id=sg.id
										INNER JOIN student_fees sf ON sg.course_id=sf.course_id AND e.student_id=sf.student_id
										WHERE e.student_id='$student_id' AND e.course_id='$course_id' AND (sg.status IN('Continue','Not Started') OR sf.type!='advance') 
										LIMIT 0,1
									");
		//$student_status=$this->countRows('student_moving',"student_id='$student_id' AND course_id='$course_id' AND status_id==4");
		foreach($enroll as $e):$enroll_id=$e['id'];endforeach;
		#$student_enrolled_id=($advance_fee<0 && $previous_group_status='Completed'?"":$enroll_id);
		if($advance_fee<0 && $previous_group_status='Completed'){$student_enrolled_id="";}
		//elseif($previous_group_status !='Completed' && $advance_fee>0 && student_status==1){$student_enrolled_id="";}
		elseif($previous_group_status !='Completed' && $advance_fee>0){$student_enrolled_id="";}
		elseif($previous_group_status !='Completed'){$student_enrolled_id=$enroll_id;}
		else{$student_enrolled_id=$enroll_id;}
		$course_code=$this->getDataFromTable("course", "code", "id='$course_id'");
		return "00".$student_enrolled_id.$course_code;
	}
	function printProgressAttendance($student_id,$group_id,$unit)
	{
		$count_att_1 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift1='X' OR shift1='L' OR shift1='E')");
		$shift1 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift2='X' OR shift2='L' OR shift2='E')");
		$shift2 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift3='X' OR shift3='L' OR shift3='E')");
		$shift3 = $count_att_3["COUNT(id)"];
		
		$count_att_1 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift4='X' OR shift4='L' OR shift4='E')");
		$shift4 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift5='X' OR shift5='L' OR shift5='E')");
		$shift5 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift6='X' OR shift6='L' OR shift6='E')");
		$shift6 = $count_att_3["COUNT(id)"];
		
		
		$count_att_1 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift7='X' OR shift7='L' OR shift7='E')");
		$shift7 = $count_att_1["COUNT(id)"];
		
		$count_att_2 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift8='X' OR shift8='L' OR shift8='E')");
		$shift8 = $count_att_2["COUNT(id)"];
		
		$count_att_3 = $this->strRecordID("ped_attendance","COUNT(id)","student_id='$student_id' AND group_id='$group_id' AND unit<='$unit' AND (shift9='X' OR shift9='L' OR shift9='E')");
		$shift9 = $count_att_3["COUNT(id)"];
		
		return $shift1+$shift2+$shift3+$shift4+$shift5+$shift6+$shift7+$shift8+$shift9;
	}
}
?>