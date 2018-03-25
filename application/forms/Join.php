<?php
class Join{
    private $table;
    private $join;
    private $value1;
    private $value2;
    private $tableJoint;

    public function __construct($join,$tableJoint,$table,$value1,$value2) {
        $this->table = $table;
        $this->join = $join;
        $this->value1 = $value1;
        $this->value2 = $value2;
        $this->tableJoint = $tableJoint;
    }

    public function convertToSQL() {
        $queryJoin =  $this->join ." ".$this->tableJoint." ON " .$this->table. "." .$this->value1. " = " .$this->tableJoint. "." .$this->value2 . ";";
        return $queryJoin;
    }
    public function getTableJoin(){
        return $this->tableJoint;
    }
}