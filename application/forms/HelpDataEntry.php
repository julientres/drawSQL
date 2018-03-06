<?php
require_once('/../../fonctions.php');

class HelpDataEntry
{

    public function __construct(){}


    public function allTables($nameBdd)
    {
        $bdd = doConnexion();
        $str = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='" . $nameBdd . "' ";
        $query = $bdd['object']->prepare($str);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function columnsFromTable()
    {
    }
}