<?php
	class Select{
		private $column;

		public function __construct($column) {
			$this->column = $column;
		}

		public function convertToSQL() {
		    if(is_array($this->column)){
                $strC = implode(",", $this->column);
            }else{
                $strC = $this->column;
            }
   //         if(is_array($this->aggregate)){
       //         $strA = implode(",", $this->aggregate);
       //     }else{
        //        $strA = $this->column;
        //    }


			$querySelect ="SELECT " . $strC;

			return $querySelect;
		}
	}
