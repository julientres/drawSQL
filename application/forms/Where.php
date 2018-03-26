<?php
class Where{
    private $column;
    private $operate;
    private $value;
    private $value2;

    public function __construct($column, $operate, $value,$value2 = null) {
        if ($value2 != null) {
            $this->column = $column;
            $this->operate = $operate;
            $this->value = $value;
            $this->value2 = $value2;
        } else {
            $this->column = $column;
            $this->operate = $operate;
            $this->value = $value;
            $this->value2 = null;
        }
    }

    public function convertToSQL() {
        if($this->value2 == null){
            $queryFrom = "WHERE ".$this->column. " " . $this->operate . " '" .  $this->value . "'";
        }else{
            $queryFrom = "WHERE ".$this->column. " " . $this->operate . " '" .  $this->value . "' AND '" .$this->value2 ."'";
        }
        return $queryFrom;
    }
}
