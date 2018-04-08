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
        try {
            $str = $sql;
            $query = $bdd['object']->prepare($str);
            $query->execute();
            $result = $query->fetchAll();
            $res = ['try' => true, 'res'=>$result];
            return $res;
        }
        catch (PDOException $e) {
            $res = ['try' => false, 'res'=>$e->getMessage()];
            return $res;
        }


    }
}

