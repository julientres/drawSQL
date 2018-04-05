<?php
require_once('../../application/forms/From.php');
require_once('../../application/forms/Where.php');
require_once('../../application/forms/ExecutionQuery.php');
require_once('../../application/forms/Select.php');
require_once('../../application/forms/Join.php');
require_once('../../application/forms/HelpDataEntry.php');

if(!isset($_SESSION['nbSelect'])) $_SESSION['nbSelect'] = 0;
if(!isset($_SESSION['nbFrom'])) $_SESSION['nbFrom'] = 0;
if(!isset($_SESSION['nbWhere'])) $_SESSION['nbWhere'] = 0;
if(!isset($_SESSION['nbJoin'])) $_SESSION['nbJoin'] = 0;

if (isset($_POST['fromInput'])) {
    $help = new HelpDataEntry();
    $fromSelect = $_POST['fromInput'];
    $column = $help->columnsFromTable($fromSelect, $_SESSION['bdd']);
    $name = $help->showResultsColumns($column);
    $_SESSION['name'] = $name;
    echo $help->showResultsColumns($column);
}
if (isset($_POST['joinInput'])) {
    $help = new HelpDataEntry();
    $joinSelect = $_POST['joinInput'];
    $join = $help->columnsFromTable($joinSelect, $_SESSION['bdd']);
    $help->showResultsColumns($join);
}

if(isset($_POST['session'])){

}

// DEBUT SELECT //
if (isset($_GET['select'])) {
    $id = $_GET['select'];
    $_SESSION[$id] = ['id'=>$id, 'object'=>null, 'table'=>null];
    echo true;
}
if (isset($_POST['select'])) {
    $id = $_POST['select'];
    if($_SESSION[$id]['object'] != null){
        $object = unserialize($_SESSION[$id]['object']);
        $table = $_SESSION[$id]['table'];
        $column = $object->getColumn();
        $res = ['column' => $column, 'res' => true, 'id' => $id, 'table' =>$table];
        echo json_encode($res);
    }else{
        $res = ['column' => null, 'res' => false, 'id' => $id];
        echo json_encode($res);
    }
}
if (isset($_GET['selectGenerer'])) {
    if ($_GET['selectGenerer']) {
        $column = $_GET['selectGenerer'];
        $id = $_GET['id'];
        $table = $_GET['table'];
        $_SESSION['nbSelect'] += 1;
        $select = new Select("" . $column . "");
        $_SESSION[$id]['object'] = serialize($select);
        $_SESSION[$id]['table'] = $table;
        echo true;
    } else {
        echo false;
    }
}
if(isset($_POST['table'])){
    $nb = $_SESSION['nbFrom'];
    $table = array();
    $nameId = array();
    $res = array();
    for($i=1; $i<=$nb;$i++){
        $id = "from".$i;
        array_push($nameId,$id);
        if($_SESSION[$id]['object'] != null){
            $object =  unserialize($_SESSION[$id]['object']);
            $tableSelected = $object->getTable();
            array_push($table,$tableSelected);
        }
    }
    array_push($res,$table);
    array_push($res,$nameId);
    echo json_encode($res);
}

// FIN SELECT //

// DEBUT FROM //
if (isset($_GET['from'])) {
    $id = $_GET['from'];
    $_SESSION[$id] = ['id'=>$id, 'object'=>null];
    echo true;
}
if (isset($_POST['from'])) {
    $id = $_POST['from'];
    if($_SESSION[$id]['object'] != null){
        $object = unserialize($_SESSION[$id]['object']);
        $table = $object->getTable();
        $res = ['table' => $table, 'res' => true, 'id' => $id];
        echo json_encode($res);
    }else{
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
    $_SESSION[$id] = ['id'=>$id, 'object'=>null];
    echo true;
}
if (isset($_POST['where'])) {
    $id = $_POST['where'];
    if($_SESSION[$id]['object'] != null){
        $where = unserialize($_SESSION[$id]['object']);
        $table = $_SESSION[$id]['table'];
        $column = $where->getColumn();
        $operate = $where->getOperate();
        $value1 = $where->getValue();
        $value2 = $where->getValue2();
        $idFrom = $_SESSION[$id]['from'];
        $res = ['table' => $table, 'column' => $column, 'operate' => $operate, 'value1' => $value1, 'value2' => $value2, 'res' => true, 'id' => $id,"idFrom" =>$idFrom];
        echo json_encode($res);
    }else{
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
        if($operate == "IS NULL" || $operate == "IS NOT NULL"){
            $where = new Where("" . $column . "", "" . $operate . "");
        }else if($operate == "BETWEEN"){
            $where = new Where("" . $column . "", "" . $operate . "", "" . $value1 . "","" . $value2 . "");
        }else{
            $where = new Where("" . $column . "", "" . $operate . "", "" . $value1 . "");
        }
        $_SESSION['nbWhere'] += 1;
        $_SESSION[$id]['from'] = $_GET['idFrom'];
        $_SESSION[$id]['object'] = serialize($where);
        $_SESSION[$id]['table'] = $table;
        echo true;
    } else {
        echo false;
    }
}
if(isset($_POST['table2'])){
    $nb = $_SESSION['nbFrom'];
    $table = array();
    $nameId = array();
    $res = array();
    for($i=1; $i<=$nb;$i++){
        $id = "from".$i;
        array_push($nameId,$id);
        if($_SESSION[$id]['object'] != null){
            $object =  unserialize($_SESSION[$id]['object']);
            $tableSelected = $object->getTable();
            array_push($table,$tableSelected);
        }
    }
    array_push($res,$table);
    array_push($res,$nameId);
    echo json_encode($res);
}
// FIN WHERE //

// DEBUT JOIN //
if (isset($_GET['join'])) {
    $id = $_GET['join'];
    $_SESSION[$id] = ['id'=>$id, 'object'=>null];
    echo true;
}
if (isset($_POST['join'])) {
    $id = $_POST['join'];
    if($_SESSION[$id]['object'] != null){
        $object = $_SESSION[$id]['object'];
        $join = unserialize($object);
        $table = $join->getTableJ();
        $tableJoin = $join->getTableJoin();
        $value1 = $join->getValue1();
        $value2 = $join->getValue2();
        $join = $join->getJoin();
        $res = ['table' => $table, 'res' => true, 'id' => $id,'tableJoin' => $tableJoin, 'value1'=>$value1,'value2'=>$value2,'join'=>$join];
        echo json_encode($res);
    }else{
        $res = ['table' => null, 'res' => false, 'id' => $id];
        echo json_encode($res);
    }
}
if (isset($_GET['joinGenerer'])) {
    if ($_GET['joinGenerer']) {
        $table = $_GET['joinGenerer'];
        $id = $_GET['id'];
        $tableJoin = $_GET['tableJoin'];
        $value1 = $_GET['value1'];
        $value2 = $_GET['value2'];
        $join = $_GET['join'];
        $join = new Join("" . $join . "", "" . $tableJoin ."", "" .$table . "", "" .$value1 . "" , "". $value2 ."");
        $_SESSION['nbJoin'] += 1;
        $_SESSION[$id]['object'] = serialize($join);
        echo true;
    } else {
        echo false;
    }
}
if (isset($_GET['join'])) {
    if ($_GET['join'] != null) {
        $listJoin = explode(",", $_GET['join']);
        $from = unserialize($_SESSION['from']);
        $table = $from->getTable();
        $join = new Join($listJoin[0], $listJoin[1], $table, $listJoin[2], $listJoin[3]);
        $_SESSION['join'] = serialize($join);
        var_dump($join);
        echo true;
    } else {
        echo false;
    }
}
if(isset($_POST['table3'])){
    $nb = $_SESSION['nbFrom'];
    $table = array();
    $nameId = array();
    $res = array();
    for($i=1; $i<=$nb;$i++){
        $id = "from".$i;
        array_push($nameId,$id);
        if($_SESSION[$id]['object'] != null){
            $object =  unserialize($_SESSION[$id]['object']);
            $tableSelected = $object->getTable();
            array_push($table,$tableSelected);
        }
    }
    array_push($res,$table);
    array_push($res,$nameId);
    echo json_encode($res);
}
// FIN JOIN //

if (isset($_GET['generer'])) {
    if ($_GET['generer']) {
        if (isset($_SESSION['select']) && isset($_SESSION['from']) && isset($_SESSION['where'])
            && isset($_SESSION['join']) || isset($_SESSION['select']) && isset($_SESSION['from'])
            && isset($_SESSION['where']) || isset($_SESSION['select']) && isset($_SESSION['from'])
            && isset($_SESSION['join']) || isset($_SESSION['select']) && isset($_SESSION['from'])) {
            echo true;
        } else {
            echo false;
        }
    }
}

if (isset($_POST['modal'])) {
    if ($_POST['modal']) {
        $myObj = new stdClass();
        $select = unserialize($_SESSION['select']);
        $from = unserialize($_SESSION['from']);

        $tabSelect = $select->convertToSQL();
        $tabFrom = $from->convertToSQL();


        $myObj->select = $tabSelect;

        $myObj->from = $tabFrom;

        if (isset($_SESSION['join'])) {
            $join = unserialize($_SESSION['join']);
            $tabJoin = $join->convertToSQL();
            $myObj->join = $tabJoin;
        }

        if (isset($_SESSION['where'])) {
            $where = unserialize($_SESSION['where']);
            $tabWhere = $where->convertToSQL();
            $myObj->where = $tabWhere;
        }

        $myJson = json_encode($myObj);
        $_SESSION['sql'] = $myJson;
        echo $myJson;
    }
}

if (isset($_POST['result'])) {
    if ($_POST['result']) {
        $select = unserialize($_SESSION['select']);
        $from = unserialize($_SESSION['from']);

        $tabSelect = $select->convertToSQL();
        $tabFrom = $from->convertToSQL();

        if (isset($_SESSION['where'])) {
            $where = unserialize($_SESSION['where']);
            $tabWhere = $where->convertToSQL();
            $execution = new ExecutionQuery($tabSelect, $tabFrom, $tabWhere);
            $_SESSION['exec'] = "" . $tabSelect . " " . $tabFrom . " " . $tabWhere . "";
        } elseif (isset($_SESSION['join'])) {
            $join = unserialize($_SESSION['join']);
            $tabJoin = $join->convertToSQL();
            $execution = new ExecutionQuery($tabSelect, $tabFrom, $tabJoin);
            $_SESSION['exec'] = "" . $tabSelect . " " . $tabFrom . " " . $tabJoin . "";
        } elseif (isset($_SESSION['where']) && isset($_SESSION['join'])) {
            $join = unserialize($_SESSION['join']);
            $tabJoin = $join->convertToSQL();
            $where = unserialize($_SESSION['where']);
            $tabWhere = $where->convertToSQL();
            $execution = new ExecutionQuery($tabSelect, $tabFrom, $tabJoin);
            $_SESSION['exec'] = "" . $tabSelect . " " . $tabFrom . " " . $tabJoin . " " . $tabWhere . "";
        } else {
            $execution = new ExecutionQuery($tabSelect, $tabFrom);
            $_SESSION['exec'] = "" . $tabSelect . " " . $tabFrom . "";
        }
        $result = $execution->exec();
        $table = [];
        array_push($table, array('resultat' => $result));
        $column = $_SESSION['column'];
        //var_dump($column);
        if ($column == '*') {
            $name = $_SESSION['name'];
            array_push($table, array('column' => json_decode($name)));
        } else {
            $name = explode(",", $column);
            $tableName = [];
            for ($i = 0; $i < sizeof($name); $i++) {
                array_push($tableName, array('name' => $name[$i]));
            }
            array_push($table, array('column' => $tableName));
        }

        echo json_encode($table);
    }
}


