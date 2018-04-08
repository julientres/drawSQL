<?php
	class Having{
		private $column;
		private $operation;

		public function __construct($column, $operation) {
			$this->column = $column;
			$this->operation = $operation;
		}
		public function getColumn(){
		    return $this->column;
        }
        public function getOpera(){
            return $this->operation;
        }

        public function convertToSQL() {
            $queryFrom = "HAVING ".$this->column. " " . $this->operation;

            return $queryFrom;
        }
	}
