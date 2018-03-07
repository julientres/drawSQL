<?php
require_once('forms/From.php');
require_once('forms/ExecutionQuery.php');
require_once('forms/Select.php');
require_once('forms/HelpDataEntry.php');

if (isset($_POST['fromInput'])) {
    $help = new HelpDataEntry();
    $fromSelect = $_POST['fromInput'];
    $select = $help->columnsFromTable($fromSelect, $_SESSION['bdd']);
    $help->showResultsColumns($select);
}

if (isset($_POST['select']) && isset($_POST['from'])) {

    $select = new Select("" . $_POST['select'] . "");
    $from = new From("" . $_POST['from'] . "");


    $tabSelect = $select->convertToSQL();
    $tabFrom = $from->convertToSQL();

    $execution = new ExecutionQuery($tabSelect, $tabFrom);


    $column = $execution->searchNameColumn($_POST['from']);

    $execution->showResults($execution->exec(), $column);

}


