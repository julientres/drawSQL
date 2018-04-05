<?php
	class Select{
		private $column;
		private $min;
		private $max;
		private $count;
		private $avg;
		private $sum;

		public function __construct($column,$min = null,$max = null,$count = null,$avg = null,$sum = null) {
			$this->column = $column;
            $this->max = null;
            $this->count= null;
            $this->avg = null;
            $this->sum = null;
			if($min != null){
                $this->min = $min;
            }
            if($max != null){
                $this->max = $min;
            }
            if($count != null){
                $this->count = $min;
            }
            if($avg != null){
                $this->avg = $min;
            }
            if($sum != null){
                $this->sum = $min;
            }
		}

		public function getColumn(){
			return $this->column;
		}

		public function convertToSQL() {
		    if(is_array($this->column)){
                $strC = implode(",", $this->column);
                $querySelect = "SELECT " . $strC;
            }else{
		        $strC = $this->column;
                $querySelect = "SELECT " . $strC;
            }
            if($this->min != null){
		        $strMin = "MIN(". $this->min. ")";
                $querySelect .= " " . $strMin ;
            }
            if($this->max != null){
                $strMax = "MAX(". $this->min. ")";
                $querySelect .= " " . $strMax ;
            }
            if($this->count != null){
                $strCount = "COUNT(". $this->min. ")";
                $querySelect .= " " . $strCount ;
            }
            if($this->avg != null){
                $strAvg = "MAX(". $this->min. ")";
                $querySelect .= " " . $strAvg ;
            }
            if($this->sum != null){
                $strSum = "SUM(". $this->min. ")";
                $querySelect .= " " . $strSum ;
            }
			return $querySelect;
		}

	}
