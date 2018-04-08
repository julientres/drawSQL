<?php
class Join{
    public $table;
    public $value1;
    public $value2;
    public $tableJoint;

    public function __construct($tableJoint,$table,$value1,$value2) {
        $this->table = $table;
        $this->value1 = $value1;
        $this->value2 = $value2;
        $this->tableJoint = $tableJoint;
    }

    public function getTableJoin(){
        return $this->tableJoint;
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