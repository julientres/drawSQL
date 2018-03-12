<?php
	class Where{
		private $column;
		private $operate;
		private $value;

		public function __construct($column, $operate, $value) {
			$this->column = $column;
			$this->operate = $operate;
            $this->value = $value;
		}

        public function convertToSQL() {
            $queryFrom = "WHERE ".$this->column. " " . $this->operate . " '" .  $this->value . "'";

            return $queryFrom;
        }
	}
?>