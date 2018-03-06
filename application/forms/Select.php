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
            $querySelect = "SELECT " . $strC;

			return $querySelect;
		}
	}
