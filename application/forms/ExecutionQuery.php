<?php
require_once('/../../fonctions.php');

class ExecutionQuery
{
    private $select;
    private $from;
    private $where;

    /*
    private $where;
    private $join;
    private $having;
    private $orderBy;
    private $groupBy;
    private $subQuery;
    */

    public function __construct($select, $from, $where = null)
    {
        if ($where != null) {
            $this->select = $select;
            $this->from = $from;
            $this->where = $where;
        } else {
            $this->select = $select;
            $this->from = $from;
            $this->where = null;
        }
    }

    public function exec()
    {
        $bdd = doConnexion();
        if (isset($this->where)) {
            $str = "" . $this->select . " " . $this->from . " " . $this->where . ";";
        } else {
            $str = "" . $this->select . " " . $this->from . ";";
        }
        $query = $bdd['object']->prepare($str);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }


    public function showResults($resultat, $nameColumn)
    {
        foreach ($resultat as $r) {
            echo '<p>';
            foreach ($nameColumn as $nC) {
                echo $r[$nC['COLUMN_NAME']];
                echo " ";
            }
            echo '</p>';
        }
    }
}

?>