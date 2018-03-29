<?php
require_once('../fonctions.php');
$retour = doConnexion();

require_once('forms/From.php');
require_once('forms/Where.php');
require_once('forms/ExecutionQuery.php');
require_once('forms/Select.php');
require_once('forms/Join.php');
require_once('forms/HelpDataEntry.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Algebraic Queries - results</title>
    <meta content="" name="description">
    <meta content="RTAI - ANGLES HIOT SOLE TRESCARTES" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="html, css, js, bootstrap, fabric.js, intreract.js, requêtes algébriques" name="keywords">

    <link rel="stylesheet" href="librairies/bootstrap-4.0.0-dist/css/bootstrap.min.css" type="text/css">
    <script defer src="librairies/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js"></script>
    <script src="librairies/jquery-3.3.1.min.js"></script>
    <script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../asset/css/result-style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
<div id="menu">
    <?php
    if ($retour['success'] == true) {
        require_once('modules/navbar/navbar-result.php');

    } else {
        require_once('modules/navbar/navbar-default.php');
    }
    ?>
</div>

<div id="results">
    <table>
        <tr id="nameColumns">

        </tr>
        <tr id="valueColumns">

        </tr>
    </table>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        var str = 'result=true';
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: str,
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                console.log(data[0]);
                for (var i = 0; i < data.length; i++) {
                    $('#valueColumns').append('<td>'+ data[i].CODEACTIVITE + '</td>');
                }

            },
            error: function (data) {
                console.log(data);
                alert("Erreur de création")
            }
        });
    });

</script>
<?php
/*var_dump(unserialize($_SESSION['select']));
var_dump(unserialize($_SESSION['from']));
var_dump(unserialize($_SESSION['where']));
var_dump(unserialize($_SESSION['join']));
var_dump($_SESSION['exec']);*/
?>
<div id="footer">
    <?php
    require_once('modules/footer/footer.php');
    ?>
</div>

<script src="../asset/js/result-js.js" type="text/javascript"></script>
</body>
</html>