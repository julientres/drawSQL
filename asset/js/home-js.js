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

    $("#btnReset").click(function() {
	    var i = $("#connexion_form").find("input[type=text]");
       	$.each(i , function() {
       		$(i).removeClass('errorBorder');
			$(i).removeClass('successBorder');
			$(i).css("backgroundColor", "");
       	})

       	var d1 = $("#connexion_form").find("div[class=errorMsg]");
       	$.each(d1 , function() {
       		$(d1).html("");
       	})

       	var d2 = $("#connexion_bloc").find("div[class=msg]");
       	$.each(d2 , function() {
       		$(d2).html("");
       	})

       	$('#btnCo').attr('disabled', true);
       	$('#btnReset').attr('disabled', true);
       	$("#connexion_form")[0].reset();	
    	checkHostOk = false;
		checkPortOk = false;
		checkBDDOk = false;
		checkUserOk = false;
   	})

   	$("#connexion_form").submit(function(e) {
   		e.preventDefault();
    	$.ajax({
    		url:'../asset/php/check-database.php',
    		type:'POST',
    		data:$(this).serialize(),
    		dataType:'JSON',    		
    		success:function(data) {
    			if(data.success) {
    				$("#successForm").html("<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><i class='fas fa-check-circle'></i><strong> Succès !</strong> Connexion à la base de données réussie avec succès ! Vous allez être redirigé dans 2 secondes.</div>");
	    			window.setTimeout(function() {
					    window.location.href = 'draw-algebraic-queries.php';
					}, 2000);
    			} else {
	    			$("#errorForm").html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><i class='fas fa-ban'></i><strong> Erreur !</strong> Impossible de se connecter à la base de données. "+data.object+"</div>");
	    			$("#infoForm").html("<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><i class='fas fa-info-circle'></i><strong> Information :</strong> Vérifiez que les champs du formulaire soient corrects puis essayez à nouveau</div>");	
    			}
    		},
    		error:function(data) {
    			console.log(data);
    		}
    	})
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
				$("#host").css("backgroundColor", "#FBE3E4");
				break;
			case 'port':
				$("#inputPortError").html("Le champ [Port] est obligatoire");
				$("#port").css("backgroundColor", "#FBE3E4");
				break;
			case 'bdd':
				$("#inputBDDError").html("Le champ [BDD] est obligatoire");
				$("#bdd").css("backgroundColor", "#FBE3E4");
				break;
			case 'user':
				$("#inputUserError").html("Le champ [Identifiant] est obligatoire");
				$("#user").css("backgroundColor", "#FBE3E4");
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
				$("#host").css("backgroundColor", "");
				break;
			case 'port':
				$("#inputPortError").html("");
				$("#port").css("backgroundColor", "");
				break;
			case 'bdd':
				$("#inputBDDError").html("");
				$("#bdd").css("backgroundColor", "");
				break;
			case 'user':
				$("#inputUserError").html("");
				$("#user").css("backgroundColor", "");
				break;
		}
	}
}	

function checkAllInputs() {
	if (checkHostOk && checkPortOk && checkBDDOk && checkUserOk) {
        $('#btnCo').removeAttr("disabled");	
	}
	else {
	    $('#btnCo').attr('disabled', true); 
   	}

   	if (checkHostOk || checkPortOk || checkBDDOk || checkUserOk) {
		 $('#btnReset').removeAttr("disabled");
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