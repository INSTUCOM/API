/*
Date created: Sunday July 3, 2016
Time created: 09:29
Date modified:
Author:Deewai inc.
*/



$(document).ready(function(){
	var set;
	//$(".signals").data("status","fff");
	//$(".signals").attr("data-test","fff");
	//var $off = "<button type=\"button\" class=\"btn btn-danger signals\" id=\"danger\">OFF</button>";
   
	$(document).on("click",".add-device", function(){
		var formdata = $(".devices").serialize();
		
		//alert(formdata);
		$.ajax({
				url: 	"controller/add_deviceController.php",
				data: 	formdata,
				type: 	"POST",
				error: 	function(XMLHttpRequest, textStatus, errorThrown) {

					// usualy on headers 404 or Internal Server Error
					_toastr("ERROR 404 - An error occured while converting to binary","top-right","error",false);

				},

				success: function(data) {
					//alert(data);
					if(data == "error"){
						_toastr("Error, Please try again!","top-right","error",false);
					}
					else if(data == "added"){
						_toastr("Successfully Saved!","top-right","success",false);
					}
					else if (data == "empty"){
						_toastr("Some empty fields were found!","top-right","warning",false);
					}
					else{
						_toastr("Device pin already registered!","top-right","warning",false);
					}
					// data = data.trim(); // remove output spaces
                    // if(data != "false"){
					// 	returnvalue =  "true";
					// 	//return false;
					// }
                }
				
    });
	return false;
	});
    
    
    
    
    
});


//send a signal to the raspberry pi by changing database values
function send_signal(id,set){
	var returnvalue = null;
	//alert(set);
	//alert(set);
    $.ajax({
				url: 	"controller/send_signalController.php",
				data: 	{ajax:"true",device_id:id, new_status:set},
				type: 	"POST",
				error: 	function(XMLHttpRequest, textStatus, errorThrown) {

					// usualy on headers 404 or Internal Server Error
					_toastr("ERROR 404 - An error occured while converting to binary","top-right","error",false);

				},

				success: function(data) {
					//alert(data);
					data = data.trim(); // remove output spaces
                    if(data != "false"){
						returnvalue =  "true";
						//return false;
					}
                }
				
    });
	$(".p").val(returnvalue);
	console.log(returnvalue);
	return returnvalue;

}


