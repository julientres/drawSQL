<?php
require_once('/../../fonctions.php');

class ExecutionQuery
{
    private $select;
    private $from;
    private $where;
    private $join;
    /*
    private $join;
    private $having;
    private $orderBy;
    private $groupBy;
    private $subQuery;
    */

    public function __construct($select, $from, $where = null,$join = null)
    {
        if ($where != null) {
            $this->select = $select;
            $this->from = $from;
            $this->where = $where;
        }elseif ($join != null) {
            $this->select = $select;
            $this->from = $from;
            $this->join = $join;
        }elseif ($join != null && $where != null){
            $this->select = $select;
            $this->from = $from;
            $this->where = $where;
            $this->join = $join;
        }else {
            $this->select = $select;
            $this->from = $from;
        }
    }

    public function exec()
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

