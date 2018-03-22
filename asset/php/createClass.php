<?php
require_once('../../application/forms/From.php');
require_once('../../application/forms/Where.php');
require_once('../../application/forms/ExecutionQuery.php');
require_once('../../application/forms/Select.php');
require_once('../../application/forms/HelpDataEntry.php');


if (isset($_POST['fromInput'])) {
    $help = new HelpDataEntry();
    $fromSelect = $_POST['fromInput'];
    $select = $help->columnsFromTable($fromSelect, $_SESSION['bdd']);
    $help->showResultsColumns($select);
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
        if(isset($_SESSION['select']) && isset($_SESSION['from'])){
            echo true;
        }elseif (isset($_SESSION['select']) && isset($_SESSION['from']) && isset($_SESSION['where'])){
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


        $where = unserialize($_SESSION['where']);
        if(isset($where)){
            $tabWhere = $where->convertToSQL();
            $myObj->where = $tabWhere;
        }

        $myJson = json_encode($myObj);

        echo $myJson;
    }
}
if(isset($_POST['result'])){
    if($_POST['result']){
        $where = unserialize($_SESSION['where']);
        $select = unserialize($_SESSION['select']);
        $from = unserialize($_SESSION['from']);
        if(isset($where)){
            $tabWhere = $where->convertToSQL();
            $tabSelect = $select->convertToSQL();
            $tabFrom = $from->convertToSQL();


            $execution = new ExecutionQuery($tabSelect, $tabFrom,$tabWhere);
            $column = $execution->searchNameColumn($from->getTable());
            $execution->showResults($execution->exec(), $column);
        }else{
            $select = unserialize($_SESSION['select']);
            $from = unserialize($_SESSION['from']);

            $where = unserialize($_SESSION['where']);
            $tabSelect = $select->convertToSQL();
            $tabFrom = $from->convertToSQL();


            $execution = new ExecutionQuery($tabSelect, $tabFrom);
            $column = $execution->searchNameColumn($from->getTable());
            $execution->showResults($execution->exec(), $column);
        }


    }
}