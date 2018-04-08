$(".alert-success").show("slow").delay(2000).hide("slow");

$(document).ready(function () {
    var str = 'result=true';
    $.ajax({
        url: "../asset/php/createClass.php",
        type: "POST",
        data: str,
        success: function (data) {

            data = JSON.parse(data);
            console.log(data);
            if(data[0]['resultat']['try']){
                //Evite de réecrire tous
                tabResultat = data[0]['resultat']['res'];
                tabColumn = data[1]['column'];

                console.log(tabResultat);
                console.log(tabColumn);

                if(tabColumn[1][0] != null){
                    //Définit la taille des tableaux
                    size = data[0]['resultat'].length;

                    //Pour chaque valeur du tableau de column je boucle
                    for(var items in tabColumn) {
                        for (var itemsB in tabColumn) {
                            if(tabColumn[items][itemsB] != null){
                                $('#nameColumns').append('<th scope="col">' + tabColumn[items][itemsB]['COLUMN_NAME'] +'</th>');
                            }
                        }

                    }

                    if(tabResultat == ""){
                        $('#valueColumns').append('<td colspan="' + size2 + '">Aucun résultat trouvé</td>');
                    }else{
                        //Pour chaque valeur du tableau des resultats, je boucle et je reboucle pour afficher en fonction des columns
                        for(var item in tabResultat) {
                            $('#valueColumns').append('<tr>');
                            for(var itemCA in tabColumn){
                                for (var itemCB in tabColumn){
                                    $('#valueColumns').append('<td>' + tabResultat[item][tabColumn[itemCA][itemCB]['COLUMN_NAME']] +'</td>');
                                }
                            }
                            $('#valueColumns').append('</tr>');
                        }
                    }
                }else{
                    //Définit la taille des tableaux
                    size = data[0]['resultat'].length;
                    size2 = data[1]['column'].length;

                    //Pour chaque valeur du tableau de column je boucle
                    for(var items in tabColumn) {
                        if(tabColumn[items] == null){

                        }else{
                            $('#nameColumns').append('<th scope="col">' + tabColumn[items]['COLUMN_NAME'] +'</th>');
                        }
                    }

                    if(tabResultat == ""){
                        $('#valueColumns').append('<td colspan="' + size2 + '">Aucun résultat trouvé</td>');
                    }else{
                        //Pour chaque valeur du tableau des resultats, je boucle et je reboucle pour afficher en fonction des columns
                        for(var item in tabResultat) {
                            $('#valueColumns').append('<tr>');
                            for(var i = 0; i < size2; i++){
                                $('#valueColumns').append('<td>' + tabResultat[item][tabColumn[i]['COLUMN_NAME']] +'</td>');
                            }
                            $('#valueColumns').append('</tr>');
                        }
                    }
                }

            }else{
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