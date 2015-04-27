function date_change()
{
	dateParts = document.getElementById('date_value').value;	
	totalunit = document.getElementById('totalunit').value;
	frequency = document.getElementById('frequency').value;
	unit=document.getElementById('unit').value;
	unit_per_week= frequency * unit;
	if(totalunit == ''){
		alert("Select the Units");
		document.getElementById('totalunit').focus();
		document.getElementById('gr_course_endt').value = '';
	}else{
		totalunit = (parseInt(totalunit)/unit_per_week) * 7;
		newDays = totalunit;	
		new_computed_units = (newDays  % 2 == 0 ? Math.floor(newDays) : Math.ceil(newDays));
		var myDate=new Date(dateParts);
		var x = myDate.setDate(myDate.getDate()+parseInt(new_computed_units));
		var end_day= myDate.getDay();
		var end_date=new Date(x);
		switch(end_day)
		{
			case 0:{var z = end_date.setDate(myDate.getDate() - parseInt(3));}break;
			case 1:{var z = end_date.setDate(myDate.getDate() - parseInt(1));}break;
			case 2:{var z = end_date.setDate(myDate.getDate() - parseInt(1));}break;
			case 3:{var z = end_date.setDate(myDate.getDate() - parseInt(1));}break;
			case 4:{var z = end_date.setDate(myDate.getDate() - parseInt(1));}break;
			case 5:{var z = end_date.setDate(myDate.getDate() + parseInt(2));}break;
			case 6:{var z = end_date.setDate(myDate.getDate() + parseInt(1));}break;
			default:{var z = end_date.setDate(myDate.getDate());}break;
		}
		var d  = end_date.getDate();
		var day = (d < 10) ? '0' + d : d;
		var m = end_date.getMonth()+1;
		var month = (m < 10) ? '0' + m : m;	
		var yy = end_date.getFullYear();
		var year = (yy < 1000) ? yy + 1900 : yy;
		new_end_date = year + "-" + month + "-" + day;
		document.getElementById('gr_course_endt').value = new_end_date;//Date.parseExact("2010-11-29", "yyyy-MM-dd");
	}
}