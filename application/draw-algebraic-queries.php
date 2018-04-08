<?php
require_once('../fonctions.php');
require_once('forms/HelpDataEntry.php');
$returnBDD = doConnexion();

$help = new HelpDataEntry();
$table = $help->allTables($_SESSION['bdd']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DrawSQL - drawing</title>
    <meta content="" name="description">
    <meta content="RTAI - ANGLES HIOT SOLE TRESCARTES" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="html, css, js, bootstrap, fabric.js, intreract.js, requêtes algébriques" name="keywords">
    <link rel="stylesheet" href="librairies/bootstrap-4.0.0-dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../asset/css/drawing-style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">


</head>
<body>
<div id="menu">
    <?php
    if ($returnBDD['success'] == true) {
        require_once('modules/navbar/navbar-drawing.php');
    } else {
        require_once('modules/navbar/navbar-default.php');
        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fas fa-ban'></i><strong> Erreur !</strong> Vous devez être connecté pour accéder à ce contenu. <a href='home.php' class='alert-link'>Se connecter</a>
					</div>";
    }
    ?>
</div>

<?php if ($returnBDD['success'] == true) : ?>

    <div id="main">
        <div id="options">
            <ul class="list-group list-group-horizontal">
                <button id="delete" class="list-group-item list-group-item-action" type="button" data-toggle="tooltip"
                        data-placement="left" title="Supprimer un objet"><i class="fas fa-trash-alt"></i></button>
                <button id="clear" class="list-group-item list-group-item-action" data-toggle="tooltip"
                        data-placement="left" title="Effacer tous les objets présents dans la zone de dessin"><i
                            class="fas fa-eraser"></i></button>
            </ul>
        </div>

        <div id="forms">
            <ul class="list-group">
                <button id="fromObject" class="list-group-item list-group-item-action" data-form="2"
                        data-toggle="tooltip"
                        data-placement="right" title="FROM">
                    <svg height="50" width="100">
                        <circle id="polyFrom" r="20" cx="50" cy="25" fill="#FFFFFF" stroke="#000"
                                stroke-width="2"></circle>
                    </svg>
                </button>

                <button id="selectObject" class="list-group-item list-group-item-action" data-form="1"
                        data-toggle="tooltip"
                        data-placement="right" title="SELECT">
                    <svg width="100" height="50">
                        <path id="polySelect" d="M10 10L30 40L70 40L90 10z" fill="#FFFFFF" stroke="#000"
                              stroke-width="2"></path>
                    </svg>
                </button>

                <button id="whereObject" class="list-group-item list-group-item-action" data-form="3"
                        data-toggle="tooltip"
                        data-placement="right" title="WHERE">
                    <svg height="50" width="100">
                        <path id="polyWhere" d="M10 5L10 45L90 32L90 18z" fill="#FFFFFF" stroke="#000"
                              stroke-width="2"></path>
                    </svg>
                </button>
                <button id="joinObject" class="list-group-item list-group-item-action" data-form="4"
                        data-toggle="tooltip"
                        data-placement="right" title="JOIN">
                    <svg height="50" width="100">
                        <path id="polyJoin" d="M20 10L20 40L80 10L80 40z" fill="#FFFFFF" stroke="#000"
                              stroke-width="2"></path>
                    </svg>
                </button>
                <button id="subQueryObject" class="list-group-item list-group-item-action" data-form="5"
                        data-toggle="tooltip" data-placement="right" title="SOUS-REQUÊTE">
                    <svg height="80" width="100">
                        <path id="polySubQuery" d="M20 40L35 33L35 10L80 10L80 70L35 70L35 48z" fill="#FFFFFF"
                              stroke="#000"
                              stroke-width="2"></path>
                    </svg>
                </button>
            </ul>
        </div>
        <div id="drawing">
            <div id="grille">
            </div>

            <div id="line-container">
            </div>
        </div>
    </div>

    <!-- Modal Select -->
    <div class="modal fade" id="modalSelect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="textModal">
                    <select class="custom-select" id="table">
                        <optgroup id="optGroupSelect" label="Choisir une table">

                        </optgroup>
                    </select>
                    <br>
                    <div id="divSelect">
                        <div id="boxCheckbox">

                        </div>
                        <div id="boxSelect">
                            <div>
                                <button id="min" class="btn btn-outline-secondary">MIN</button>
                                <button id="max" class="btn btn-outline-secondary">MAX</button>
                                <button id="count" class="btn btn-outline-secondary">COUNT</button>
                                <button id="avg" class="btn btn-outline-secondary">AVG</button>
                                <button id="sum" class="btn btn-outline-secondary">SUM</button>
                                <br>
                                <button id="having" class="btn btn-outline-secondary">HAVING</button>
                                <button id="groupby" class="btn btn-outline-secondary">GROUP BY</button>
                                <button id="orderby" class="btn btn-outline-secondary">ORDER BY</button>
                            </div>
                        </div>
                        <div id="function_select">
                        </div>
                    </div>
                    <input type="hidden" id="inputSelectId" value="">
                    <input type="hidden" id="idTable" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" id="btdModalSelect" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal From -->
    <div class="modal fade" id="modalFrom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">From</h5>
                </div>
                <div class="modal-body" id="textModal">
                    <select class="custom-select" id="from">
                        <optgroup label="Choisir une table">
                            <option value="null"></option>
                            <?php
                            foreach ($table as $t) {
                                echo '<option value="' . $t["TABLE_NAME"] . '">' . $t["TABLE_NAME"] . '</option>';
                            }
                            ?>
                        </optgroup>
                    </select>
                    <input type="hidden" id="inputFromId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" id="btdModalFrom" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Where -->
    <div class="modal fade" id="modalWhere" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Where</h5>
                </div>
                <div class="modal-body" id="textModal">
                    <select class="custom-select" id="table2">
                        <optgroup id="optGroupTable" label="Choisir une table">

                        </optgroup>
                    </select>
                    <br>
                    <br>
                    <select class="custom-select" id="where1">
                        <optgroup id="optGroupColonne" label="Choisir une colonne">

                        </optgroup>
                    </select>
                    <br>
                    <br>

                    <select class="custom-select" id="where2">
                        <optgroup id="optGroupOper" label="Choisir une propri">
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
                        </optgroup>
                    </select>
                    <br>
                    <br>
                    <input type="text" class="form-control input-group" id="where3" maxlength="100">
                    <br>
                    <div id="divBetween">
                        <p>And</p>
                        <input type="text" class="input-group" id="where4">
                    </div>

                </div>
                <input id="inputWhereId" type="hidden" value="">
                <input id="inputFromForm" type="hidden" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" id="btdModalWhere" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Join -->
    <div class="modal fade" id="modalJoin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Join</h5>
                </div>
                <div class="modal-body" id="textModal">
                    <!--<label>Lier forme</label>
                    <select class="custom-select" id="tableJoin1">
                        <optgroup id="optGroupLie" label="Choisir une forme à lier">
                            <?php
                            /*$nbS = $_SESSION['nbSelect'];
                            $nbF = $_SESSION['nbFrom'];
                            $nbW = $_SESSION['nbWhere'];
                            $nbJ = $_SESSION['nbJoin'];
                            for($i=1; $i<=$nbF;$i++){
                                $id = "from".$i;
                                if($_SESSION[$id]['object'] != null){
                                    echo "<option value='" .$_SESSION[$id]['id']. "'>" . $_SESSION[$id]['table'] .  "</option>";
                                }
                            }
                            for($i=1; $i<=$nbW;$i++){
                                $id = "where".$i;
                                if($_SESSION[$id]['object'] != null){
                                    echo "<option value='" .$_SESSION[$id]['from']. "'>" . $_SESSION[$id]['table'] .  "</option>";
                                }
                            }
                            for($i=1; $i<=$nbJ;$i++){
                                $id = "join".$i;
                                if($_SESSION[$id]['object'] != null){
                                    $object =  unserialize($_SESSION[$id]['object']);
                                    $tableSelected = $object->getTable();
                                }
                            }*/
                            ?>
                        </optgroup>
                    </select>-->
                    <div class="join-modal rigth">
                        <label>Table 2</label>
                        <select class="custom-select" id="tableJoin2">
                            <optgroup id="optGroupJoinTab2" label="Choisir une table">

                            </optgroup>
                        </select>
                        <label>Valeur 2</label>
                        <select class="custom-select" id="value2">
                            <optgroup id="optGroupJoin2" label="Choisir une colonne">

                            </optgroup>
                        </select>
                    </div>
                    <div class="join-modal">
                        <label>Table 1</label>
                        <select class="custom-select" id="tableJoin1">
                            <optgroup id="optGroupJoinTab1" label="Choisir une table">

                            </optgroup>
                        </select>
                        <label>Valeur 1</label>
                        <select class="custom-select" id="value1">
                            <optgroup id="optGroupJoin1" label="Choisir une colonne">

                            </optgroup>
                        </select>
                    </div>
                    <input type="hidden" id="inputJoinId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" id="btdModalJoin" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>


    <div id="footer">
        <?php
        require_once('modules/footer/footer.php');
        ?>
    </div>

<?php endif; ?>

<script defer src="librairies/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js"></script>
<script src="librairies/jquery-3.3.1.min.js"></script>
<script src="librairies/popper.min.js" type="text/javascript"></script>
<script src="librairies/svg.min.js" type="text/javascript"></script>
<script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="librairies/interact.min.js" type="text/javascript"></script>
<script src="../asset/js/drawing-js.js" type="text/javascript"></script>
<script src="../asset/js/ajaxPost.js" type="text/javascript"></script>
<script src="../asset/js/ajaxGet.js" type="text/javascript"></script>
</body>
</html>