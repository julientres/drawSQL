<?php
$_SESSION['host'] = "localhost";
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
        Select :
        <div id="divSelect"></div>
        <br>
        <br>
        From : <select id="from">
            <option value="null"></option>
            <?php
            foreach ($table as $t) {
                echo '<option value="' . $t["TABLE_NAME"] . '">' . $t["TABLE_NAME"] . '</option>';
            }
            ?>
        </select>
        <br>
        <br>
        Jointure :
        <select id="join1">
            <option value=""></option>
            <option value="inner join">Inner join</option>
            <option value="left join">Left join</option>
            <option value="right join">Right join</option>
        </select>
        <select id="join2">
            <option value="null"></option>
            <?php
            foreach ($table as $t) {
                echo '<option value="' . $t["TABLE_NAME"] . '">' . $t["TABLE_NAME"] . '</option>';
            }
            ?>
        </select>
        <br>
        <br>
        Where : <select id="where1">


        </select>
        <select id="where2">
            <option value=""></option>
            <option value="=">=</option>
            <option value="<>"><></option>
            <option value="!=">!=</option>
            <option value=">">></option>
            <option value="<"><</option>
            <option value=">=">>=</option>
            <option value="<="><=</option>
            <option value="IN">IN</option>
            <option value="BETWEEN">BETWEEN</option>
            <option value="LIKE">LIKE</option>
            <option value="IS NULL">IS NULL</option>
            <option value="IS NOT NULL">IS NOT NULL</option>
        </select>
        <input type="text" id="where3" value="">
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
    $(document).ready(function () {
        $('#formSQL').on('submit', function (e) {
            var dataSelect = "select=";
            $("input[type='checkbox']:checked").each(
                function () {
                    dataSelect += $(this).val();
                    dataSelect += "%2C";
                });
            var str = dataSelect.substring(0, dataSelect.length-3);
            str += "&from=" + $('#from').find(":selected").text();
            if($('#where1').find(":checked").text() != "" && $('#where2').find(":checked").text() != "" && $('#where3').val() != ""){
                str += "&where1=" + $('#where1').find(":checked").text();
                str += "&where2=" + $('#where2').find(":checked").text();
                str += "&where3=" + $('#where3').val();
            }
            if($('#join1').find(":checked").text() != "" && $('#join2').find(":checked").text()){
                str += "&join1=" + $('#join1').find(":checked").text();
                str += "&join2=" + $('#join2').find(":checked").text();
            }
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: str,
                success: function (data) {
                    $('#addDiv').html(data);
                },
                error: function (data) {
                    console.log("erreur");
                }
            });
        });
        $('#from').on('change', function (e) {
            var dataForm = "fromInput1=" + $(this).find(":selected").text();
            e.preventDefault();
            $.ajax({
                url: 'function.php',
                type: 'POST',
                data: dataForm,
                success: function (data) {
                    $('#divSelect').html(data);
                },
                error: function (data) {
                    console.log("erreur");
                }
            });
        });
        $('#from').on('change', function (e) {
            var dataForm = "fromInput2=" + $(this).find(":selected").text();
            e.preventDefault();
            $.ajax({
                url: 'function.php',
                type: 'POST',
                data: dataForm,
                success: function (data) {
                    var text = '<option value="null"> </option>' + data;
                    $('#where1').html(text);

                },
                error: function (data) {
                    console.log("erreur");
                }
            });
        });
    });
</script>
</body>
</html>
