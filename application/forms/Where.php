<?php
class Where{
    private $column;
    private $operate;
    private $value;
    private $value2;

    public function __construct($column, $operate, $value = null,$value2 = null) {
        if ($value2 != null) {
            $this->value2 = $value2;
        }
        if($value != null) {
            $this->value = $value;
        }
        if($value == null && $value2 == null){
            $this->value = null;
            $this->value2 = null;
        }
        $this->column = $column;
        $this->operate = $operate;
    }

    public function convertToSQL() {
        if($this->value2 == null){
            $queryFrom = "WHERE ".$this->column. " " . $this->operate . " '" .  $this->value . "'";
        }
        if($this->value == null && $this->value2 == null){
            $queryFrom = "WHERE ".$this->column. " " . $this->operate . "";
        }
        if($this->value != null && $this->value2 != null)   {
            $queryFrom = "WHERE ".$this->column. " " . $this->operate . " '" .  $this->value . "' AND '" .$this->value2 ."'";
        }

        return $queryFrom;
    }

    public function getColumn(){
        return $this->column;
    }

    public function getOperate(){
        return $this->operate;
    }

    public function getValue(){
        return $this->value;
    }

    public function getValue2(){
        return $this->value2;
    }
}
