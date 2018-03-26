<?php
require_once('../../application/forms/From.php');
require_once('../../application/forms/Where.php');
require_once('../../application/forms/ExecutionQuery.php');
require_once('../../application/forms/Select.php');
require_once('../../application/forms/Join.php');
require_once('../../application/forms/HelpDataEntry.php');


if (isset($_POST['fromInput'])) {
    $help = new HelpDataEntry();
    $fromSelect = $_POST['fromInput'];
    $select = $help->columnsFromTable($fromSelect, $_SESSION['bdd']);
    $help->showResultsColumns($select);
}
if (isset($_POST['joinInput'])) {
    $help = new HelpDataEntry();
    $joinSelect= $_POST['joinInput'];
    $join = $help->columnsFromTable($joinSelect, $_SESSION['bdd']);
    $help->showResultsColumns($join);
}

if(isset($_POST['select'])){
    if($_POST['select']){
        $select = new Select("".$_POST['select']."");
        $_SESSION['select'] = serialize($select);
        var_dump($select);
        echo true;
    }else{
        echo false;
    }
}
if(isset($_POST['from'])){
    if($_POST['from']){
        $from = new From("".$_POST['from']."");
        $_SESSION['from'] = serialize($from);
        var_dump($from);
        echo true;
    }else{
        echo false;
    }
}
if(isset($_POST['join'])){
    if($_POST['join'] != null){
        $listJoin = explode(",", $_POST['join']);
        $from = unserialize($_SESSION['from']);
        $table = $from->getTable();
        $join = new Join($listJoin[0],$listJoin[1],$table,$listJoin[2],$listJoin[3]);
        $_SESSION['join'] = serialize($join);
        var_dump($join);
        echo true;
    }else{
        echo false;
    }
}

if(isset($_POST['where1']) && isset($_POST['where2']) && isset($_POST['where3'] )){
    if($_POST['where1']){
        if($_POST['where4'] == null){
            $where = new Where("".$_POST['where1']."", "". $_POST['where2'] ."", "".$_POST['where3']."");
            $_SESSION['where'] = serialize($where);
            var_dump($where);
            echo true;
        }else{
            $where = new Where("".$_POST['where1']."", "". $_POST['where2'] ."", "".$_POST['where3']."","".$_POST['where4']."");
            $_SESSION['where'] = serialize($where);
            var_dump($where);
            echo true;
        }
    }else{
        echo false;
    }
}
if(isset($_POST['generer'])){
    if($_POST['generer']){
        if (isset($_SESSION['select']) && isset($_SESSION['from']) && isset($_SESSION['where'])
            && isset($_SESSION['join']) || isset($_SESSION['select']) && isset($_SESSION['from'])
            && isset($_SESSION['where']) || isset($_SESSION['select']) && isset($_SESSION['from'])
            && isset($_SESSION['join']) || isset($_SESSION['select']) && isset($_SESSION['from'])){
            echo true;
        }else{
            echo false;
        }
    }
}
if(isset($_POST['modal'])) {
    if ($_POST['modal']) {
        $myObj = new stdClass();
        $select = unserialize($_SESSION['select']);
        $from = unserialize($_SESSION['from']);

        $tabSelect = $select->convertToSQL();
        $tabFrom = $from->convertToSQL();


        $myObj->select = $tabSelect;

        $myObj->from = $tabFrom;

        if(isset($_SESSION['join'])){
            $join = unserialize($_SESSION['join']);
            $tabJoin = $join->convertToSQL();
            $myObj->join = $tabJoin;
        }

        if(isset($_SESSION['where'])){
            $where = unserialize($_SESSION['where']);
            $tabWhere = $where->convertToSQL();
            $myObj->where = $tabWhere;
        }

        $myJson = json_encode($myObj);

        echo $myJson;
    }
}
if(isset($_POST['result'])){
    if($_POST['result']){
        $select = unserialize($_SESSION['select']);
        $from = unserialize($_SESSION['from']);

        $tabSelect = $select->convertToSQL();
        $tabFrom = $from->convertToSQL();

        if(isset($_SESSION['where'])){
            $where = unserialize($_SESSION['where']);
            $tabWhere = $where->convertToSQL();
            $execution = new ExecutionQuery($tabSelect, $tabFrom,$tabWhere);
            $_SESSION['exec'] = "" . $tabSelect  . " " . $tabFrom  . " " .  $tabWhere . "";
        }elseif (isset($_SESSION['join'])){
            $join = unserialize($_SESSION['join']);
            $tabJoin = $join->convertToSQL();
            $execution = new ExecutionQuery($tabSelect,$tabFrom,$tabJoin);
            $_SESSION['exec'] = "" . $tabSelect  . " " . $tabFrom  . " " . $tabJoin . "";
        }elseif (isset($_SESSION['where']) && isset($_SESSION['join'])) {
            $join = unserialize($_SESSION['join']);
            $tabJoin = $join->convertToSQL();
            $where = unserialize($_SESSION['where']);
            $tabWhere = $where->convertToSQL();
            $execution = new ExecutionQuery($tabSelect,$tabFrom,$tabJoin);
            $_SESSION['exec'] = "" . $tabSelect . " ". $tabFrom . " " .$tabJoin . " " . $tabWhere . "";
        }
        else{
            $execution = new ExecutionQuery($tabSelect, $tabFrom);
            $_SESSION['exec'] = "" . $tabSelect  . " " . $tabFrom ."";
        }
        $columnA = $execution->searchNameColumn($from->getTable());
        $columnB = $execution->searchNameColumn($join->getTableJoin());

        $result = $execution->exec();
        $column = array($columnA,$columnB,$result);
        echo json_encode(array($column));
    }
}