

var myObject = {
    validation: function () {
        var username = $( "input[type=text][name=username]" ).val();
        var password = $( "input[type=password][name=pass]" ).val();
        if (username == "" || username == undefined ) {
        	alert("please enter username");
        	$( ".username" ).focus();
        }
        else if(password == "" || password == undefined)
        {
        	alert("please enter password");
        	( ".pass" ).focus();
        }
        
    }
}
