var checkHostOk = false;
var checkPortOk = false;
var checkBDDOk = false;
var checkUserOk = false;

$(document).ready(function() {
    $("#btnCo").attr("disabled", true);
    $("#btnReset").attr("disabled", true);

    $(function() {
	  	$('input[name=host]').keyup(function() {
    		checkInput($('#host'));
    		checkAllInputs();
	    })
	    $('input[name=host]').blur(function() {
    		checkInput($('#host'));
    		checkAllInputs();
	    })

	    $('input[name=port]').keyup(function() {
	    	checkInput($('#port'));
	    	checkAllInputs();
	    })
	    $('input[name=port]').blur(function() {
    		checkInput($('#port'));
    		checkAllInputs();
	    })

	    $('input[name=bdd]').keyup(function() {
	    	checkInput($('#bdd'));
	    	checkAllInputs();
	    })
	    $('input[name=bdd]').blur(function() {
    		checkInput($('#bdd'));
    		checkAllInputs();
	    })

		$('input[name=user]').keyup(function() {
		   	checkInput($('#user'));
		   	checkAllInputs();
		})
		$('input[name=user]').blur(function() {
    		checkInput($('#user'));
    		checkAllInputs();
	    })
    })

    $("#btnCo").click(function() {
    	
    })

    $("#btnReset").click(function() {
	    var i = $("#connexion_form").find("input[type=text]");
       	$.each(i , function() {
       		$(i).removeClass('errorBorder');
			$(i).removeClass('successBorder');
       	})

       	$('.errorMsg').html("");
       	$("#btnCo").attr("disabled", true);
    	$("#btnReset").attr("disabled", true);

    	checkHostOk = false;
		checkPortOk = false;
		checkBDDOk = false;
		checkUserOk = false;
   	})	
});		

function loadError(champ, erreur) {
	if(erreur) {
		$(champ).removeClass('successBorder');	
		$(champ).addClass('errorBorder');	
		var div = $(champ).attr("name");
		switch(div) {
			case 'host':
				$("#inputHostError").html("Le champ [Host] est obligatoire");
				break;
			case 'port':
				$("#inputPortError").html("Le champ [Port] est obligatoire");
				break;
			case 'bdd':
				$("#inputBDDError").html("Le champ [BDD] est obligatoire");
				break;
			case 'user':
				$("#inputUserError").html("Le champ [Identifiant] est obligatoire");
				break;
		}
	}	
	else {
		$(champ).removeClass('errorBorder');	
		$(champ).addClass('successBorder');
		var div = $(champ).attr("name");
		switch(div) {
			case 'host':
				$("#inputHostError").html("");
				break;
			case 'port':
				$("#inputPortError").html("");
				break;
			case 'bdd':
				$("#inputBDDError").html("");
				break;
			case 'user':
				$("#inputUserError").html("");
				break;
		}
	}
}	

function checkAllInputs() {
	if (checkHostOk && checkPortOk && checkBDDOk && checkUserOk) {
        $('#btnCo').attr('disabled', false);
	}
	else {
	    $('#btnCo').attr('disabled', true);		    
   	}

   	if (checkHostOk || checkPortOk || checkBDDOk || checkUserOk) {
		$('#btnReset').attr('disabled', false);
	}
	else {
	    $('#btnReset').attr('disabled', true);			    
   	}
}	

function checkInput(input) {			
	if ($(input).val() !='') {
		loadError($(input), false);
		if($(input).attr("name") == 'host') checkHostOk = true;
		else if($(input).attr("name") == 'port') checkPortOk = true;
		else if($(input).attr("name") == 'bdd') checkBDDOk = true;
		else if($(input).attr("name") == 'user') checkUserOk = true;
	}
	else {
   		loadError($(input), true);
   		if($(input).attr("name") == 'host') checkHostOk = false;
		else if($(input).attr("name") == 'port') checkPortOk = false;
		else if($(input).attr("name") == 'bdd') checkBDDOk = false;
		else if($(input).attr("name") == 'user') checkUserOk = false;
   	}
}