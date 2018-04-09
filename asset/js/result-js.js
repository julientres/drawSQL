$(".alert-success").show("slow").delay(2000).hide("slow");

$(document).ready(function () {
    var str = 'result=true';
    $.ajax({
        url: "../asset/php/createClass.php",
        type: "POST",
        data: str,
        success: function (data) {

            data = JSON.parse(data);
            var type = true;
            if (data[0]['resultat']['try']) {
                //Evite de réecrire tous
                tabResultat = data[0]['resultat']['res'];
                tabColumn = data[1]['column'];

                console.log(tabResultat);
                console.log(tabColumn);


                if(tabColumn[0]['COLUMN_NAME'] != null){
                    var tab1 = []
                    for (var column in tabColumn){
                        tab1.push(tabColumn[column]['COLUMN_NAME']);

                    }
                    type = false;
                    tabColumn = tab1;
                }
                if (tabColumn != null) {

                    //La taille des tableaux
                    size = 0;

                    //Pour chaque valeur du tableau de column je boucle
                    for (var items in tabColumn) {
                        if (tabColumn[items] != null) {
                            size++;
                            $('#nameColumns').append('<th scope="col">' + tabColumn[items] + '</th>');
                        }


                    }

                    if (tabResultat.length == 0) {
                        $('#valueColumns').append('<td colspan="' + size + '">Aucun résultat trouvé</td>');
                    } else {
                        //Pour chaque valeur du tableau des resultats, je boucle et je reboucle pour afficher en fonction des columns
                        for (var item in tabResultat) {
                            $('#valueColumns').append('<tr>');
                            for (var itemCA in tabColumn) {
                                var text = tabColumn[itemCA];
                                if (text.includes('MAX') || text.includes('MIN') || text.includes('COUNT') || text.includes('AVG') || text.includes('SUM')) {
                                    $('#valueColumns').append('<td>' + tabResultat[item][text] + '</td>');
                                }else{
                                    var array = tabColumn[itemCA].split('.');
                                    for(var i in array){
                                        if(type){
                                            if(tabResultat[item][array[i]] == null){

                                            }else{
                                                $('#valueColumns').append('<td>' + tabResultat[item][array[i]] + '</td>');
                                            }

                                        }else{
                                            if(tabResultat[item][array[i]] == null){

                                            }else{
                                                $('#valueColumns').append('<td>' + tabResultat[item][array[i]] + '</td>');
                                            }

                                        }
                                    }
                                }
                            }
                            $('#valueColumns').append('</tr>');
                        }
                    }
                } else {
                    //Définit la taille des tableaux
                    size = data[0]['resultat'].length;
                    size2 = data[1]['column'].length;

                    //Pour chaque valeur du tableau de column je boucle
                    for (var items in tabColumn) {
                        if (tabColumn[items] == null) {

                        } else {
                            $('#nameColumns').append('<th scope="col">' + tabColumn[items]['COLUMN_NAME'] + '</th>');
                        }
                    }

                    if (tabResultat.length == 0) {
                        $('#valueColumns').append('<td colspan="' + size2 + '">Aucun résultat trouvé</td>');
                    } else {
                        //Pour chaque valeur du tableau des resultats, je boucle et je reboucle pour afficher en fonction des columns
                        for (var item in tabResultat) {
                            $('#valueColumns').append('<tr>');
                            for (var i = 0; i < size2; i++) {
                                $('#valueColumns').append('<td>' + tabResultat[item][tabColumn[i]['COLUMN_NAME']] + '</td>');
                            }
                            $('#valueColumns').append('</tr>');
                        }
                    }
                }

            } else {
                err = data[0]['resultat']['res'];
                $('#err').html(err);
            }


        },
        error: function (data) {
            console.log(data);
            alert("Erreur de création")
        }
    });
});