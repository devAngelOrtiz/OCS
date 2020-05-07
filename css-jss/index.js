$(document).ready(function(){
    $('#login').submit(function(){
     
       var datos= {
			"usuario" : $('#usuario').val(),
			"contra" : $('#contra').val(),
		};

		$.ajax({
			data:  datos,
	    	url:   'css-jss/index.php',
	        type:  'post',
	        beforeSend: function () {
           		$('#boton').attr("disabled", true);
           		$('#boton').css("background", "#808080");
	        },
	        success:  function (response) {
	        	$('#boton').attr("disabled", false);
           		$('#boton').css("background", "#3498DB");
           		if(response=="true")
	            	location.href = "consola.php";
	            else
	            	$("#error").html("<center><span class='texterror'>"+response+"</span></center>");
	            	setInterval(function(){$("#error").html("");},5000);
	        }
	    });
        return false;
 
    });
});