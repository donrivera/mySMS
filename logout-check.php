<script type="text/javascript">
window.onbeforeunload = function(){ myUnloadEvent(); }
function myUnloadEvent() {
    //alert ('Calling some alert messages here');
    var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			//document.getElementById('showt').innerHTML="---";
		}
		if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;	
			//document.getElementById('showt').innerHTML=c;
		}
	}
	ajaxRequest.open("GET", "logout-ajax.php", true);
	ajaxRequest.send(null);
}
</script>