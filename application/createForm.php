<?php
$_SESSION['host']  = "localhost";
$_SESSION['port'] = "3306";
$_SESSION['bdd'] = "siscram";
$_SESSION['user'] = "root";
$_SESSION['passwd'] = "";

require_once('forms/HelpDataEntry.php');

$help = new HelpDataEntry();
$table = $help->allTables($_SESSION['bdd']);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="librairies/bootstrap-4.0.0-dist/css/bootstrap.min.css" type="text/css">
    <script defer src="librairies/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js"></script>
    <script src="librairies/jquery-3.3.1.min.js"></script>
    <script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../asset/css/result-style.css" type="text/css">
    <title>Création Form</title>
</head>
<body>
<header>

</header>
<main style="margin-left: 15px">
    <br>
    <form id="formSQL" method="POST" action="function.php">
        Select : <input type="text" name="select"><br>
        <br>
        From : <select name="from">
            <?php
            foreach($table as $t){
                echo '<option value="'.$t["TABLE_NAME"].'">'. $t["TABLE_NAME"]. '</option>';
            }
            ?>
        </select>
        <br>
        <br>
        <input type="submit" value="Créer SQL">
    </form>
    <div id="addDiv">

    </div>
</main>
<footer>
</footer>
<script>
    $(document).ready(function(){
        $('#formSQL').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data : $(this).serialize(),
                success : function(data){
                        $('#addDiv').append(data);
                },
                error : function (data) {
                    console.log("erreur");
                }
            });
        });
    });
</script>
</body>
</html>
