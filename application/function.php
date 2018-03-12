<?php
require_once('forms/From.php');
require_once('forms/Where.php');
require_once('forms/ExecutionQuery.php');
require_once('forms/Select.php');
require_once('forms/HelpDataEntry.php');

if (isset($_POST['fromInput1'])) {
    $help = new HelpDataEntry();
    $fromSelect = $_POST['fromInput1'];
    $select = $help->columnsFromTable($fromSelect, $_SESSION['bdd']);
    $help->showResultsColumns($select);
}
if (isset($_POST['fromInput2'])) {
    $help = new HelpDataEntry();
    $fromSelect = $_POST['fromInput2'];
    $select = $help->columnsFromTable($fromSelect, $_SESSION['bdd']);
    $help->showResultsColumnsOption($select);
}

if (isset($_POST['select']) && isset($_POST['from'])) {
    if (isset($_POST['select']) && isset($_POST['from']) && isset($_POST['where1']) && isset($_POST['where2']) && isset($_POST['where3'] )) {
        $select = new Select("" . $_POST['select'] . "");
        $tabSelect = $select->convertToSQL();


        $from = new From("" . $_POST['from'] . "");
        $tabFrom = $from->convertToSQL();


        $where = new Where("" . $_POST['where1'] . "","" . $_POST['where2'] . "","" . $_POST['where3'] . "");
        $tabWhere = $where->convertToSQL();



        $execution = new ExecutionQuery($tabSelect, $tabFrom,$tabWhere);
        $column = $execution->searchNameColumn($_POST['from']);
        $execution->showResults($execution->exec(), $column);
    }else{
        $select = new Select("" . $_POST['select'] . "");
        $from = new From("" . $_POST['from'] . "");

        $tabSelect = $select->convertToSQL();
        $tabFrom = $from->convertToSQL();

        $execution = new ExecutionQuery($tabSelect, $tabFrom);
        $column = $execution->searchNameColumn($_POST['from']);
        $execution->showResults($execution->exec(), $column);
    }
}



