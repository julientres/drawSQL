<?php
require_once('/../../fonctions.php');

class ExecutionQuery
{
    public function __construct()
    {
    }

    public function execQuery($sql)
    {
        $bdd = doConnexion();
        $str = $sql;
        $query = $bdd['object']->prepare($str);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}

