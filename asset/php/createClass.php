<?php
require_once('../../application/forms/From.php');
require_once('../../application/forms/Where.php');
require_once('../../application/forms/ExecutionQuery.php');
require_once('../../application/forms/Select.php');
require_once('../../application/forms/Join.php');
require_once('../../application/forms/OrderBy.php');
require_once('../../application/forms/Having.php');
require_once('../../application/forms/GroupBy.php');
require_once('../../application/forms/HelpDataEntry.php');

if (!isset($_SESSION['nbSelect'])) $_SESSION['nbSelect'] = 0;
if (!isset($_SESSION['nbFrom'])) $_SESSION['nbFrom'] = 0;
if (!isset($_SESSION['nbWhere'])) $_SESSION['nbWhere'] = 0;
if (!isset($_SESSION['nbJoin'])) $_SESSION['nbJoin'] = 0;
if (!isset($_SESSION['nbOrder'])) $_SESSION['nbOrder'] = 0;
if (!isset($_SESSION['nbGroup'])) $_SESSION['nbGroup'] = 0;
if (!isset($_SESSION['nbHaving'])) $_SESSION['nbHaving'] = 0;

if (isset($_POST['fromInput'])) {
    $help = new HelpDataEntry();
    if ($_SESSION[$_POST['fromInput']] != null) {
        $array = ["join"];
        $object = $_SESSION[$_POST['fromInput']]['object'];
        $join = unserialize($object);
        $table = $join->getTableJ();
        $tableJoin = $join->getTableJoin();
        $column1 = $help->columnsFromTable($table, $_SESSION['bdd']);
        $name1 = $help->showResultsColumns($column1);
        $column2 = $help->columnsFromTable($tableJoin, $_SESSION['bdd']);
        $name2 = $help->showResultsColumns($column2);

        foreach (json_decode($name1) as $value) {
            array_push($array, $table . "." . $value->name);
        }
        foreach (json_decode($name2) as $value) {
            array_push($array, $tableJoin . "." . $value->name);
        }
        $tabColumn = [];
        array_push($tabColumn, $column1);
        array_push($tabColumn, $column2);

        $_SESSION['column'] = $tabColumn;
        echo json_encode($array);
    } else {
        $fromSelect = $_POST['fromInput'];
        $column = $help->columnsFromTable($fromSelect, $_SESSION['bdd']);
        $_SESSION['column'] = $column;
        //var_dump($_SESSION['column']);
        $name = $help->showResultsColumns($column);
        $_SESSION['name'] = json_decode($name);
        echo $help->showResultsColumns($column);
    }
}


// DEBUT SELECT //
if (isset($_GET['select'])) {
    $id = $_GET['select'];
    $_SESSION[$id] = ['id' => $id, 'object' => null, 'table' => null];
    echo true;
}
if (isset($_POST['select'])) {
    $id = $_POST['select'];
    if ($_SESSION[$id]['object'] != null) {
        $object = unserialize($_SESSION[$id]['object']);
        $table = $_SESSION[$id]['table'];
        $column = $object->getColumn();
        $res = ['column' => $column, 'res' => true, 'id' => $id, 'table' => $table];
        echo json_encode($res);
    } else {
        $res = ['column' => null, 'res' => false, 'id' => $id];
        echo json_encode($res);
    }
}
if (isset($_GET['selectGenerer'])) {
    if ($_GET['selectGenerer']) {
        $column = $_GET['column'];
        $id = $_GET['id'];
        $table = $_GET['table'];
        $_SESSION['nbSelect'] += 1;

        if ($_GET['group'] != null) {
            $group = new GroupBy("" . $_GET['group'] . "");
            $_SESSION['nbGroup'] = +1;
            $idG = "group" . $_SESSION['nbGroup'];
            $_SESSION[$idG]['id'] = $idG;
            $_SESSION[$idG]['object'] = serialize($group);
            $_SESSION[$id]['group'] = serialize($group);
        }
        if ($_GET['having'] != null) {
            $having = new Having("" . $_GET['having'] . "");
            $_SESSION['nbHaving'] = +1;
            $idH = "having" + $_SESSION['nbHaving'];
            $_SESSION[$idH]['id'] = $idH;
            $_SESSION[$idH]['object'] = serialize($having);
            $_SESSION[$id]['having'] = $idH;
        }
        if ($_GET['order'] != null) {
            $order = new OrderBy("" . $_GET['order'] . "");
            $_SESSION['nbOrder'] = +1;
            $idO = "order" + $_SESSION['nbOrder'];
            $_SESSION[$idO]['id'] = $idO;
            $_SESSION[$idO]['object'] = serialize($order);
            $_SESSION[$id]['order'] = $idO;
        }
        $count = $_GET['count'];
        $min = $_GET['min'];
        $max = $_GET['max'];
        $sum = $_GET['sum'];
        $avg = $_GET['avg'];
        $selectObj = new Select("" . $column . "", "" . $min. "", "" . $max. "", "" . $count . "", "" . $avg . "", "" . $sum . "");
        $_SESSION[$id]['object'] = serialize($selectObj);
        $_SESSION[$id]['table'] = $table;
        echo true;
    } else {
        echo false;
    }
}
if (isset($_POST['table'])) {
    $nbFrom = $_SESSION['nbFrom'];
    $nbJoin = $_SESSION['nbJoin'];
    $nbWhere = $_SESSION['nbWhere'];
    $table = array();
    $nameId = array();
    $res = array();
    for ($i = 1; $i <= $nbFrom; $i++) {
        $id = "from" . $i;
        array_push($nameId, $id);
        if ($_SESSION[$id]['object'] != null) {
            $object = unserialize($_SESSION[$id]['object']);
            $tableSelected = $object->getTable();
            array_push($table, $tableSelected);
        }
    }
    for ($i = 1; $i <= $nbJoin; $i++) {
        $id = "join" . $i;
        array_push($nameId, $id);
        if ($_SESSION[$id]['object'] != null) {
            $tableSelected = "join" . $i;;
            array_push($table, $tableSelected);
        }
    }
    array_push($res, $table);
    array_push($res, $nameId);
    echo json_encode($res);
}
if (isset($_POST['dataLinkSelect'])) {
    if ($_POST['dataLinkSelect']) {
        $id = $_POST['tableId'];
        $idSelect = $_POST['idSelect'];

        if ($_SESSION[$id]['link'] != null) {
            $link = $_SESSION[$id]['link'];
            $res = ['link' => $link,'id' => $idSelect];
            echo json_encode($res);
        } else {
            $link = $_SESSION[$id]['id'];
            $res = ['link' => $link, 'id' => $idSelect];
            echo json_encode($res);
        }

    } else {
        echo false;
    }
}
// FIN SELECT //

// DEBUT FROM //
if (isset($_GET['from'])) {
    $id = $_GET['from'];
    $_SESSION[$id] = ['id' => $id, 'object' => null, 'link' => null];
    echo true;
}
if (isset($_POST['from'])) {
    $id = $_POST['from'];
    if ($_SESSION[$id]['object'] != null) {
        $object = unserialize($_SESSION[$id]['object']);
        $table = $object->getTable();
        $res = ['table' => $table, 'res' => true, 'id' => $id];
        echo json_encode($res);
    } else {
        $res = ['table' => null, 'res' => false, 'id' => $id];
        echo json_encode($res);
    }
}
if (isset($_GET['fromGenerer'])) {
    if ($_GET['fromGenerer']) {
        $table = $_GET['fromGenerer'];
        $id = $_GET['id'];
        $from = new From("" . $table . "");
        $_SESSION['nbFrom'] += 1;
        $_SESSION[$id]['object'] = serialize($from);
        $_SESSION[$id]['table'] = $table;
        echo true;
    } else {
        echo false;
    }
}
// FIN FROM //

// DEBUT WHERE //
if (isset($_GET['where'])) {
    $id = $_GET['where'];
    $_SESSION[$id] = ['id' => $id, 'object' => null];
    echo true;
}
if (isset($_POST['where'])) {
    $id = $_POST['where'];
    if ($_SESSION[$id]['object'] != null) {
        $where = unserialize($_SESSION[$id]['object']);
        $table = $_SESSION[$id]['table'];
        $column = $where->getColumn();
        $operate = $where->getOperate();
        $value1 = $where->getValue();
        $value2 = $where->getValue2();
        $idFrom = $_SESSION[$id]['from'];
        $res = ['table' => $table, 'column' => $column, 'operate' => $operate, 'value1' => $value1, 'value2' => $value2, 'res' => true, 'id' => $id, "idFrom" => $idFrom];
        echo json_encode($res);
    } else {
        $res = ['table' => null, 'res' => false, 'id' => $id];
        echo json_encode($res);
    }
}
if (isset($_GET['whereGenerer'])) {
    if ($_GET['whereGenerer']) {
        $table = $_GET['whereGenerer'];
        $column = $_GET['columnWhere'];
        $id = $_GET['id'];
        $operate = $_GET['operate'];
        $value1 = $_GET['value1'];
        $value2 = $_GET['value2'];
        $idFrom = $_GET['idFrom'];
        if ($operate == "IS NULL" || $operate == "IS NOT NULL") {
            $where = new Where("" . $column . "", "" . $operate . "");
        } else if ($operate == "BETWEEN") {
            $where = new Where("" . $column . "", "" . $operate . "", "" . $value1 . "", "" . $value2 . "");
        } else {
            $where = new Where("" . $column . "", "" . $operate . "", "" . $value1 . "");
        }
        $_SESSION['nbWhere'] += 1;
        $_SESSION[$id]['from'] = $_GET['idFrom'];
        //var_dump($_SESSION[$idFrom]['link']);
        $_SESSION[$idFrom]['link'] = $_GET['id'];
        print_r($_SESSION[$idFrom]['link']);
        $_SESSION[$id]['object'] = serialize($where);
        $_SESSION[$id]['table'] = $table;
        echo true;
    } else {
        echo false;
    }
}
if (isset($_POST['table2'])) {
    $nb = $_SESSION['nbFrom'];
    $table = array();
    $nameId = array();
    $res = array();
    for ($i = 1; $i <= $nb; $i++) {
        $id = "from" . $i;
        array_push($nameId, $id);
        if ($_SESSION[$id]['object'] != null) {
            $object = unserialize($_SESSION[$id]['object']);
            $tableSelected = $object->getTable();
            array_push($table, $tableSelected);
        }
    }
    array_push($res, $table);
    array_push($res, $nameId);
    echo json_encode($res);
}
// FIN WHERE //

// DEBUT JOIN //
if (isset($_GET['join'])) { //Quand on reçoit GET join
    $id = $_GET['join'];
    $_SESSION[$id] = ['id' => $id, 'object' => null]; //Créer une session avec un id et un object associé
    echo true;
}
if (isset($_POST['join'])) { //Quand on reçoit POST join
    $id = $_POST['join'];
    if ($_SESSION[$id]['object'] != null) { //Test si il existe l'oject
        $object = $_SESSION[$id]['object'];
        $join = unserialize($object);
        $table = $join->getTableJ();
        $tableJoin = $join->getTableJoin();
        $value1 = $join->getValue1();
        $value2 = $join->getValue2();
        //Récupere les informations de la jointure pour la renvoyer en json
        $res = ['table' => $table, 'res' => true, 'id' => $id, 'tableJoin' => $tableJoin, 'value1' => $value1, 'value2' => $value2];
        echo json_encode($res);
    } else {
        $res = ['table' => null, 'res' => false, 'id' => $id];
        echo json_encode($res);
    }
}
if (isset($_GET['joinGenerer'])) { //Quand on reçoit $_GET joinGenerer
    if ($_GET['joinGenerer']) {
        $table = $_GET['joinGenerer'];
        $id = $_GET['id'];
        $tableJoin = $_GET['tableJoin'];
        $value1 = $_GET['value1'];
        $value2 = $_GET['value2'];
        $join = new Join("" . $tableJoin . "", "" . $table . "", "" . $value1 . "", "" . $value2 . "");
        $_SESSION['nbJoin'] += 1;
        $_SESSION[$id]['object'] = serialize($join);
        echo true;
    } else {
        echo false;
    }
}
if (isset($_POST['dataLink'])) { // Quand on reçoit en POST dataLink, on execute
    if ($_POST['dataLink']) {
        $id1 = $_POST['tableId'];
        $id2 = $_POST['tableJoinId'];
        $idJoin = $_POST['idJoin'];
        //On récupere toutes les infos
        if ($_SESSION[$id1]['link'] != null ) {
            $link1 = $_SESSION[$id1]['link'];
            $link2 = $_SESSION[$id2]['id'];
            $res = ['link1' => $link1, 'link2' => $link2, 'id' => $idJoin];
            echo json_encode($res);
        }
        else  if ($_SESSION[$id2]['link'] != null) {
            $link1 = $_SESSION[$id1]['id'];
            $link2 = $_SESSION[$id2]['link'];
            $res = ['link1' => $link1, 'link2' => $link2, 'id' => $idJoin];
            echo json_encode($res);
        }
        else if($_SESSION[$id1]['link'] != null && $_SESSION[$id2]['link'] != null){
            $link1 = $_SESSION[$id1]['link'];
            $link2 = $_SESSION[$id2]['link'];
            $res = ['link1' => $link1, 'link2' => $link2, 'id' => $idJoin];
            echo json_encode($res);
        }
        else {
            $link1 = $_SESSION[$id1]['id'];
            $link2 = $_SESSION[$id2]['id'];
            $res = ['link1' => $link1, 'link2' => $link2, 'id' => $idJoin];
            echo json_encode($res);
        }

    } else {
        echo false;
    }
}
if (isset($_POST['table3'])) { // Quand on reçoit en POST table3, on execute
    $nb = $_SESSION['nbFrom'];
    $table = array();
    $nameId = array();
    $res = array();
    for ($i = 1; $i <= $nb; $i++) { //On va récupere chaque table avec leurs id pour le modal
        $id = "from" . $i;
        array_push($nameId, $id);
        if ($_SESSION[$id]['object'] != null) {
            $object = unserialize($_SESSION[$id]['object']);
            $tableSelected = $object->getTable();
            array_push($table, $tableSelected);
        }
    }
    array_push($res, $table);
    array_push($res, $nameId);
    echo json_encode($res);
}
// FIN JOIN //

if (isset($_GET['idDeleteForm'])) { // Quand on reçoit en GET idDeleteForm, on execute
    $formSessionArr = array();
    $formSession = "";
    $get = $_GET['idDeleteForm']; //On récupère un id ou plusieurs pour les formes à supprimer

    if (is_array($get)) { //On test si c'est un tableau
        foreach ($get as $value) { //Pour chaque id d'une forme j'ajoute dans mon tableau
            array_push($formSessionArr, $value);
        }
        //Détruis les variable en session
        foreach ($formSessionArr as $value) {
            unset($_SESSION[$value]);
        }
        unset($_SESSION['nbSelect']);
        unset($_SESSION['nbFrom']);
        unset($_SESSION['nbWhere']);
        unset($_SESSION['nbJoin']);
        unset($_SESSION['nbGroup']);
        unset($_SESSION['nbOrder']);
        unset($_SESSION['nbHaving']);
        unset($_SESSION['column']);
        echo true;
    } else {
        $formSession = $get;
        $form = $_SESSION[$get]['object'];
        //Détruis les variable en session en fonction de l'id envoyé
        //On test si l'object est égale à une forme pour détruire son nombre associé
        if (is_a($form, 'Select')) unset($_SESSION['nbSelect'], $_SESSION['column']);
        if (is_a($form, 'From')) unset($_SESSION['nbFrom']);
        if (is_a($form, 'Where')) unset($_SESSION['nbWhere']);
        if (is_a($form, 'Join')) unset($_SESSION['nbJoin']);
        if (is_a($form, 'GroupBy')) unset($_SESSION['nbGroup']);
        if (is_a($form, 'OrderBy')) unset($_SESSION['nbOrder']);
        if (is_a($form, 'Having')) unset($_SESSION['nbHaving']);
        unset($_SESSION[$formSession]);
        echo true;
    }
}

if (isset($_POST['modal'])) { // Quand on reçoit en POST modal, on execute
    if ($_POST['modal']) {
        //On récupere les sessions contenant le nombre de forme créé pour chaque object
        $nbFrom = $_SESSION['nbFrom'];
        $nbJoin = $_SESSION['nbJoin'];
        $nbWhere = $_SESSION['nbWhere'];
        $nbSelect = $_SESSION['nbSelect'];
        $nbOrder = $_SESSION['nbOrder'];
        $nbGroup = $_SESSION['nbGroup'];
        $nbHaving = $_SESSION['nbHaving'];

        //On crée un tableau pour chaque object
        $from = array();
        $join = array();
        $where = array();
        $select = array();
        $order = array();
        $having = array();
        $group = array();


        //Pour chaque forme on va récupérer les infos pour créer la requête
        //Pour chaque object existant on récupère l'object puis on rentre les infos important dans son tableau
        for ($i = 0; $i <= $nbOrder; $i++) {
            $id = "order" . $i;
            if ($_SESSION[$id]['object'] != null) {
                $orderObj = unserialize($_SESSION[$id]['object']);
                $tableOrder = $orderObj->getColumn();
                array_push($order, $tableOrder);
            }
        }
        //Pour chaque object existant on récupère l'object puis on rentre les infos important dans son tableau
        for ($i = 0; $i <= $nbHaving; $i++) {
            $id = "having" . $i;
            if ($_SESSION[$id]['object'] != null) {
                $havingObj = unserialize($_SESSION[$id]['object']);
                $tableHaving = ['column' => $havingObj->getColumn(), 'operate' => $havingObj->getOpera()];
                array_push($having, $tableHaving);
            }
        }
        //Pour chaque object existant on récupère l'object puis on rentre les infos important dans son tableau
        for ($i = 0; $i <= $nbGroup; $i++) {
            $id = "group" . $i;
            if ($_SESSION[$id]['object'] != null) {
                $groupObj = unserialize($_SESSION[$id]['object']);
                $tableGroup = $groupObj->getColumn();
                array_push($group, $tableGroup);
            }
        }
        //Pour chaque object existant on récupère l'object puis on rentre les infos important dans son tableau
        for ($i = 0; $i <= $nbFrom; $i++) {
            $id = "from" . $i;
            if ($_SESSION[$id]['object'] != null) {
                $object = unserialize($_SESSION[$id]['object']);
                $tableFrom = $object->getTable();
                array_push($from, $tableFrom);
            }
        }
        //Pour chaque object existant on récupère l'object puis on rentre les infos important dans son tableau
        for ($i = 0; $i <= $nbJoin; $i++) {
            $id = "join" . $i;
            if ($_SESSION[$id]['object'] != null) {
                $joinObj = unserialize($_SESSION[$id]['object']);
                $table = $joinObj->getTableJ();
                $tableJoin = $joinObj->getTableJoin();
                $value1 = $joinObj->getValue1();
                $value2 = $joinObj->getValue2();
                $tableSelected = ['table' => $table, 'tableJoin' => $tableJoin, 'value1' => $value1, 'value2' => $value2];
                array_push($join, $tableSelected);
            }
        }
        //Pour chaque object existant on récupère l'object puis on rentre les infos important dans son tableau
        for ($i = 0; $i <= $nbWhere; $i++) {
            $id = "where" . $i;
            if ($_SESSION[$id]['object'] != null) {
                $whereObj = unserialize($_SESSION[$id]['object']);
                $column = $whereObj->getColumn();
                $operate = $whereObj->getOperate();
                $value1 = $whereObj->getValue();
                $value2 = $whereObj->getValue2();
                $table = $_SESSION[$id]['table'];
                $tableWhere = ['table' => $table, 'column' => $column, 'operate' => $operate, 'value1' => $value1, 'value2' => $value2];
                array_push($where, $tableWhere);
            }
        }
        //Pour chaque object existant on récupère l'object puis on rentre les infos important dans son tableau
        for ($i = 0; $i <= $nbSelect; $i++) {
            $id = "select" . $i;
            if ($_SESSION[$id]['object'] != null) {
                $selectObj = unserialize($_SESSION[$id]['object']);
                $column = $selectObj->getColumn();
                $min = $selectObj->getMin();
                $max = $selectObj->getMax();
                $count = $selectObj->getCount();
                $avg = $selectObj->getAvg();
                $sum = $selectObj->getSum();
                $tableSelected = ['column' => $column, 'min' => $min, 'max' => $max, 'count' => $count, 'avg' => $avg, 'sum' => $sum];
                array_push($select, $tableSelected);

            }
        }

        //On prépare la requête en prenant chaque tableau et les inserer ensemble pour en faire une requête
        //On récupère les champs du select
        if (isset($select) && !empty($select)) {//Si il existe un select
            $sqlSelect = "SELECT ";
            $columnSelect = array();
            if($select[0]['column'] != null){
                $sqlSelect .= $select[0]['column'] . ",";
                $columnSelect = explode(",", $select[0]['column']);
                foreach($items as $columnSelect){
                    array_push($columnSelect,$columnSelect[$items]);
                }
            }
            if($select[0]['min'] != null){
                $sqlSelect .= "MIN(" . $select[0]['min'] . "), ";
                $minColumn = "MIN(" . $select[0]['min'] . ")";
                array_push($columnSelect,$minColumn);
            }
            if($select[0]['max'] != null){
                $sqlSelect .= "MAX(" . $select[0]['max'] . "), ";
                $maxColumn = "MAX(" . $select[0]['max'] . ")";
                array_push($columnSelect,$maxColumn);
            }
            if($select[0]['count'] != null){
                $sqlSelect .= "COUNT(" .$select[0]['count'] . "), ";
                $countColumn = "COUNT(" .$select[0]['count'] . ")";
                array_push($columnSelect,$countColumn);
            }
            if($select[0]['avg'] != null){
                $sqlSelect .= "AVG(" .$select[0]['avg'] . "), ";
                $avgColumn = "AVG(" . $select[0]['avg'] . ")";
                array_push($columnSelect,$avgColumn);
            }
            if($select[0]['sum'] != null){
                $sqlSelect .= "SUM(" .$select[0]['sum'] . "), ";
                $sumColumn = "SUM(" . $select[0]['sum'] . ")";
                array_push($columnSelect,$sumColumn);
            }
            $sqlSelect = rtrim($sqlSelect, ", ");
        } else {
            $sqlSelect = null;
        }

        //On récupère les champs du from
        if (isset($from) && !empty($from)) { //Si il existe un from
            $sqlFrom = " FROM ";
            foreach ($from as $value) {
                $sqlFrom .= $value . ",";
            }
            $sqlFrom = rtrim($sqlFrom, ", "); //Pour enlever la dernière virgule
        } else {
            $sqlFrom = null;
        }

        //On récupère les champs de la jointure
        if (isset($join) && !empty($join)) { //Si il existe une jointure
            $sqlWhere = " WHERE " . $join[0]['table'] . "." . $join[0]['value1'] . "=" . $join[0]['tableJoin'] . "." . $join[0]['value2'];
            foreach ($where as $value) {
                $sqlWhere .= " AND " . $value['table'] . "." . $value['column'] . $value['operate'] . "'" . $value['value1'] . "'";
            }
        } else if (isset($where) && !empty($where)) { //Si il existe une restriction
            $sqlWhere = " WHERE ";
            foreach ($where as $value) {
                $sqlWhere .= $value['table'] . "." . $value['column'] . $value['operate'] . "'" . $value['value1'] . "'";
                if (count($where) > 1) $sqlWhere .= " AND ";
            }
        } else {
            $sqlWhere = null;
        }
        //On récupère les champs du Group By
        if (isset($group) && !empty($group)) { //Si il existe un group by
            $sqlGroup = " GROUP BY " . $group[0];
        } else {
            $sqlGroup = null;
        }
        //$sqlOrder = " ORDER BY " . $order->getColumn();
        if($columnSelect[0] == "*"){
            $columnSelect = $_SESSION['column'];
        }
        //On encodre en json les parties pour faire la requête
        $sql = ['select' => $sqlSelect, 'from' => $sqlFrom, 'where' => $sqlWhere, 'group' => $sqlGroup, 'column' => $columnSelect];
        //On place la requête sql en session pour la récupérer dans la page résultat
        $_SESSION['sql'] = $sql;
        echo json_encode($sql);
    }
}


if (isset($_POST['result'])) { // Quand on reçoit en POST result, on execute
    if ($_POST['result']) {

        //On récupère la requête sql en session et découpe en partie
        $sql = $_SESSION['sql'];
        $select = $sql['select'];
        $from = $sql['from'];
        $where = $sql['where'];
        $group = $sql['group'];
        //Assemble la requête
        $req = $select . " " . $from . " " . $where . " " . $group;
        $execution = new ExecutionQuery();
        $result = $execution->execQuery($req); //Execute la requête
        $table = [];
        array_push($table, array('resultat' => $result)); //Place le résultat dans le tableau
        $column = $sql['column'];
        array_push($table, array('column' => $column)); //Place les colonnes associés dans le tableau pour le tableau des résultats

        echo json_encode($table);
    }
}


