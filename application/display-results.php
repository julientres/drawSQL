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
<div id="req_SQL" class="form-group">
    <h3>Requête SQL</h3>
    <?php
    $req = $_SESSION['sql'];
    echo "<code>" .$req['select'] . "</code><br>";
    echo "<code>" . $req['from'] . "</code><br>";
    if($req['where'] != null){
        echo "<code>" . $req['where'] . "</code><br>";
    }
    if($req['having'] != null){
        echo "<code>" . $req['order'] . "</code><br>";
    }
    if($req['group'] != null){
        echo "<code>" . $req['group'] . "</code><br>";
    }
    if($req['order'] != null){
        echo "<code>" . $req['order'] . "</code><br>";
    }
    ?>
</div>
<div id="results">
    <h3>Résultat</h3>
    <div id="err"></div>
    <table class="table table-bordered">
        <thead>
            <tr id="nameColumns">
            </tr>
        </thead>
        <tbody id="valueColumns">
        </tbody>
    </table>
</div>

<div id="footer">
    <?php
    require_once('modules/footer/footer.php');
    ?>
</div>

<script src="../asset/js/result-js.js" type="text/javascript"></script>
</body>
</html>