<?php
class Dbfunctions{
	/*public function getFieldList($tblName, $fldName, $aSeparator = ",", $defaultVal = "", $encloseChar="", $optCondition = "")
	{
		if(trim($optCondition) != "")
		{
			$condition = " WHERE " . $optCondition;
		}
		else
		{
			$condition = "";
		}
		
		$fieldList = "";
	
		$tmpSql = "SELECT " . $fldName . " FROM " . $tblName . " " . $condition;
		//echo("<br>SQL=>".$tmpSql."<br>");
		$rs = mysql_query($tmpSql);
		if( (!($rs)) || (!($rec=mysql_fetch_array($rs))) )
		{
			//not found, do nothing
		}
		else
		{
			do 
			{
				if($fieldList != "")
				{
					$fieldList = $fieldList . $aSeparator;
				}
				$fieldList = $fieldList . $encloseChar . $rec[$fldName] . $encloseChar;
			} while(($rec=mysql_fetch_array($rs)));
		}
		
		if($fieldList == "")
		{
			$fieldList = $defaultVal;
		}

		return $fieldList;
	}*/
// ************************END************************************************************

	/*Returns only 1 data *************************/
	/*public function getFirstData($tblName, $fldName,  $optCondition)
	{
	$defaultVal="";
	
		if(trim($optCondition) != "")
		{
			$condition = " WHERE " . $condition;
		}
		else
		{
			$condition = "";
		}
	//echo ("select " . $fldName . " from " . $tblName . " where " . $condition);

		$rs = mysql_query("select " . $fldName . " from " . $tblName . $condition. " LIMIT 0,1");
	
		if( (!($rs)) || (!($rec=mysql_fetch_array($rs))) )
		{
			//not found
			return $defaultVal;
		}
		else if(is_null($rec[0]))
		{
			//found
			return $defaultVal;
		}
		else
		{
			//found
			return $rec[0];
		}
	}*/

// ********************************************END**********************************************************************	
	
	
	
	//CHECKING EXISTANCE  IN A TABLE
	/*public function existsInTable($tblName, $condition)
	{
	
	if(trim($condition) != "")
		{
			$condition = " WHERE " . $condition;
		}
		else
		{
			$condition = "";
		}
		//echo ("select * from " . $tblName . " where " . $condition)."<br>";
		
		$rs = mysql_query("select * from " . $tblName . $condition);
		if( (!($rs)) || (!($rec=mysql_fetch_array($rs))) )
		{
			//not found
			return 0;
		}
		else
		{
			//found
			return 1;
		}
	}*/
// ********************************END****************************************************************************************

//Next Auto increment value of a table.
/*public function autoIncrement($tblName,$string, $condition)
{
$query_next = mysql_query("SHOW TABLE STATUS LIKE '". $tblName."'");
$row_next = mysql_fetch_array($query_next);
 $next_id = $row_next[Auto_increment] ;//exit;
 return $next_id;
}*/
// ********************************END****************************************************************************************	

//FETCH ALL ROWS FROM A TABLE
/*function fetch($tblName,$optCondition="") 
{
	if(trim($optCondition) != "")
	{
	$condition = " WHERE " . $optCondition;
	}
	else
	{
	$condition = "";
	}
	
  $sql="SELECT * FROM " . $tblName . $condition;
 $result = mysql_query($sql);
 if(!$result)
 {
  trigger_error("Problem selecting data");
 }
 while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
  $result_array[] = $row;
 }
if(count($result_array)>0)
{
 return $result_array;	
 }
 else
 {
 $default_val=array();
 return $default_val;
 }
}*/

// ********************************END****************************************************************************************	



//FETCH ALL ROWS FROM A TABLE USING LEFT JOIN
/*function leftJoin($tblName1,$tblName2,$tbl1Param,$tbl2Param,$optCondition="") 
{
	if(trim($optCondition) != "")
	{
	$condition = " WHERE " . $optCondition;
	}
	else
	{
	$condition = "";
	}
	
  $sql="SELECT DISTINCT ". $tblName1.".id FROM " . $tblName1 . " LEFT JOIN ". $tblName2 ." ON ".$tblName1.".".$tbl1Param."=".$tblName2.".".$tbl2Param. $condition;
 $result = mysql_query($sql);
 
 if(!$result){
  trigger_error("Problem selecting data");
 }
 while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
  $result_array[] = $row;
 }
if(count($result_array)>0)
{
 return $result_array;	
 }
 else
 {
 $default_val=array();
 return $default_val;
 }
}*/

// ********************************END****************************************************************************************	


//FETCH ALL ROWS FROM A TABLE USING LEFT JOIN
/*function leftJoinCount($tblName1,$tblName2,$tbl1Param,$tbl2Param,$optCondition="") 
{
	if(trim($optCondition) != "")
	{
	$condition = " WHERE " . $optCondition;
	}
	else
	{
	$condition = "";
	}
	
  $sql="SELECT DISTINCT ". $tblName1.".id FROM " . $tblName1 . " LEFT JOIN ". $tblName2 ." ON ".$tblName1.".".$tbl1Param."=".$tblName2.".".$tbl2Param. $condition;
 $result = mysql_query($sql);
 return mysql_num_rows($result);

}*/

// ********************************END****************************************************************************************

/*Format Date Time to d-M-Y or any other...*/
	/*public function formatMyDateTime($a_date, $a_format, $is_time_stamp = 0, $a_default_value = "")
	{
		if(is_null($a_date))
		{
			return($a_default_value);
		}
		else
		{
			if($is_time_stamp == 1)
			{
				//--- supplied date time is a TimeStamp, so no conversion required
				$tmpdt_stamp = $a_date;
			}
			else
			{
				//--- supplied date time is not a TimeStamp, but a string
				$tmpdt_stamp = strtotime($a_date);
			}
			return(date($a_format, $tmpdt_stamp));
		}
	}
	
	 //calculate years of age (input string: YYYY-MM-DD)
	  public function age($birthday){
		list($year,$month,$day) = explode("-",$birthday);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0)
		  $year_diff--;
		return $year_diff;
	  }*/
  
  
	//Text Area formatting************************************************	
	/*public function textArea($string){
		$str = str_replace("\r",'<br>',$string); 
	 $str=stripslashes($str);	//exit;
	$str=mysql_real_escape_string($str);
	return $str;
	}	*/
	//***********************************************	  

}
?>