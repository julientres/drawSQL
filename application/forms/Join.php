<?php
class Join{
    public $table;
    public $join;
    public $value1;
    public $value2;
    public $tableJoint;

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
    public function getJoin(){
        return $this->join;
    }
    public function getValue1(){
        return $this->value1;
    }
    public function getValue2(){
        return $this->value2;
    }
    public function getTableJ(){
        return $this->table;
    }
}