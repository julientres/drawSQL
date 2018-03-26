<?php
require_once('/../../fonctions.php');

class HelpDataEntry
{

    public function __construct()
    {
    }


    public function allTables($nameBdd)
    {
        $bdd = doConnexion();
        $str = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='" . $nameBdd . "' ";
        $query = $bdd['object']->prepare($str);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function columnsFromTable($table, $schema)
    {
        $bdd = doConnexion();
        $str = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . $table . "' AND TABLE_SCHEMA='" . $schema . "'";
        $query = $bdd['object']->prepare($str);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }


    public function showResultsColumns($resultat)
    {
        $data = [];
        foreach ($resultat as $r) {
            array_push($data,$r['COLUMN_NAME']);
        }
        echo json_encode($data);
    }
}