$(".alert-success").show("slow").delay(2000).hide("slow");

$(document).ready(function () {
    var str = 'result=true';
    $.ajax({
        url: "../asset/php/createClass.php",
        type: "POST",
        data: str,
        success: function (data) {

            data = JSON.parse(data);
            console.log(data[0]['resultat']);
            console.log(data[1]['column']);

            //Evite de réecrire tous
            tabResultat = data[0]['resultat'];
            tabColumn = data[1]['column'];

            //Définit la taille des tableaux
            size = data[0]['resultat'].length;
            size2 = data[1]['column'].length;

            //Pour chaque valeur du tableau de column je boucle
            for(var items in tabColumn) {
                $('#nameColumns').append('<th scope="col">' + tabColumn[items]['name'] +'</th>');
            }

            //Pour chaque valeur du tableau des resultats, je boucle et je reboucle pour afficher en fonction des columns
            for(var item in tabResultat) {
                $('#valueColumns').append('<tr>');
                for(var i = 0; i < size2; i++){
                    $('#valueColumns').append('<td>' + tabResultat[item][tabColumn[i]['name']] +'</td>');
                }
                $('#valueColumns').append('</tr>');
            }



        },
        error: function (data) {
            console.log(data);
            alert("Erreur de création")
        }
    });
});