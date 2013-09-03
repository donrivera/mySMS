<?php
include_once dirname(__FILE__) .'/class.Main.php';
//////////////////////////////////////////////////////
//   Convert Characters, work as url encoder.
//   Note:Our system will decode this format only.
//////////////////////////////////////////////////////
function UrlEncoding($str)
       {          $strResult="";
                   for($i=0;$i<=strlen($str);$i++)
                        {
                         $strResult .= (ord(substr($str,$i,1)))."+";
                         }
                         return $strResult;
       }
//////////////////////////////////////////////////////
//   Get  SMS Credits
//////////////////////////////////////////////////////
function GetCredits($UserName,$UserPassword){
      @$url = "http://saudisms.net/gw/Balance.php?userName=".$UserName."&userPassword=".$UserPassword;
          if (!(@$fp =fopen($url,"r"))){
               $FainalResult = "Erorr Connecting to Gateway.";
                                                  }else{
             @$FainalResult =@fread(@$fp,50);
              @fclose(@$fp);
             @$FainalResult=(integer)str_replace(" ","",@$FainalResult);
                                                  }
return $FainalResult;
}
//////////////////////////////////////////////////////
//   Send SMS Messages
//////////////////////////////////////////////////////
function SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message){
	
	/*$dbf = new User();
	$UserPassword = $dbf->getDataFromTable("sms_gateway", "password", "password <> ''");
	$UserPassword = base64_decode(base64_decode($UserPassword));*/
	
	$Message_before=iconv("UTF-8","Windows-1256",$Message);
	$Message=UrlEncoding($Message_before);
	
$url = "http://saudisms.net/gw/?userName=".$UserName."&userPassword=".$UserPassword."&numbers=".$Numbers."&userSender=".$Originator."&msg=".$Message."&By=API";
          if (!(@$fp =fopen($url,"r"))){
               return "Erorr Connecting to Gateway.";
                                                   }else{
             @$FainalResult =@fread(@$fp, 10);
             @fclose(@$fp);
             @$FainalResult=(integer)str_replace(" ","",@$FainalResult);
if($FainalResult=="1"){
return "SMS Sent Successfully.";
}elseif($FainalResult=="1010"){
return "Missing Data, Message content or Numbers.";
}elseif($FainalResult=="1020"){
return "Wrong Login Combination.";
}elseif($FainalResult=="1030"){
return "Same message with same destinations exist in queue, Wait 10 seconds befoure resending it.";
}elseif($FainalResult=="1040"){
return "Unrecognized Charset.";
}elseif($FainalResult=="1050"){
return "Msg Empty. Reason, message fileration remove message content.";
}elseif($FainalResult=="1060"){
return "Insufficient Credits to procces sending.";
}elseif($FainalResult=="1070"){
return "Your Credits is 0, Insufficient to procces sending.";
}elseif($FainalResult=="1080"){
return "Message Not Sent, Error Sending Message.";
}elseif($FainalResult=="1090"){
return "Repetition filter catch the message.";
}elseif($FainalResult=="1100"){
return "Sorry, Message Not Sent. Try later.";
}elseif($FainalResult=="1110"){
return "Sorry, Bad Originator (Sender Name) you used. Try another Originator.";
}elseif($FainalResult=="1120"){
return "Sorry,The country you are trying to send to is not covered by our network.";
}elseif($FainalResult=="1130"){
return "Sorry, Consult our network administrator regarding defiend netowrk for you account.";
}elseif($FainalResult=="1140"){
return "Sorry, You exceeded maximum messages parts. Try sending fewer parts.";
}else{
return $FainalResult;
}

} 

}
/////////////////////// End Of Functions ///////////////////////
?>