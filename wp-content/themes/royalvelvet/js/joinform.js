jQuery(document).ready(function(){

	jQuery("#input_3_1").attr("name","input_3_1");
	jQuery("#input_3_2").attr("type","email");
	jQuery("#input_3_2").attr("name","input_3_2");
	jQuery("#input_3_3").attr("name","input_3_3");
	jQuery("#input_3_4").attr("name","input_3_4");
	
	jQuery('.fancybox-iframe').contents().find('#input_3_1').attr("name","input_3_1");

	
	
	
	jQuery("#gform_submit_button_3").click(function(){
		
	var name = document.getElementById("input_3_1").value;
	if(name == '') {
		alert('Please enter Name.');
		return false;
	}
	var email = document.getElementById("input_3_2").value;
	if(email == '') {
		alert('Please enter Email Address.');
		return false;
	}
	else if (validateEmail(document.getElementById('input_3_2').value))
	{
		alert('Please enter a Valid Email Address');
		return false;
	}
	
	var address = document.getElementById("input_3_3").value;
	if(address == '') {
		alert('please enter your address');
		return false;
	}
	 
	var dateofbirth = document.getElementById("input_3_4").value;
	if(dateofbirth == '') {
		alert('please enter your Date of Birth.');
		return false;
	}
	else{
		// dateofbirth returns in format mm-dd-yyyy
		var month = parseInt(dateofbirth.substring(0,2)); // returns month
		var day = parseInt(dateofbirth.substring(3,5));
		var year = parseInt(dateofbirth.substring(6,10));
		var min_age = 13;
		var theirDate = new Date((year + min_age), month, day);
	    var today = new Date;
	
	        if ((today.getTime() - theirDate.getTime()) < 0) {

		alert("You must be at least 13 years old to join!");
		return false;
	       }
	     else {
		return true;
		  } 	
	}
	
	function validateEmail(email){
		eval("re = /\.+\\@\.+\\.\.+/;");
		if (email.search(re) != -1) {
			return false;
		} else {
			return true;
		}
	}
		return true;
		jQuery( "#gform_3" ).submit();
	
   });
});
