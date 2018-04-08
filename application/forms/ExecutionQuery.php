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
        if (isset($this->where)) {
            $str = "" . $this->select . " " . $this->from . " " . $this->where . ";";
        } elseif (isset($this->join)) {
            $str = "" . $this->select . " " . $this->from . " WHERE " . $this->join . ";";
        } elseif (isset($this->join) && isset($this->where)) {
            $str = "" . $this->select . " " . $this->from . " WHERE " . $this->join . " AND " . $this->where . ";";
        } else {
            $str = "" . $this->select . " " . $this->from . ";";
        }
        $query = $bdd['object']->prepare($str);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
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

