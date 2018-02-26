<?php
	class Where extends Form{
		private $column;
		private $value;

		public function __construct($image, $column, $value) {
			super($image);
			$this->column = $column;
			$this->value = $value;
		}

		public function convertToSQL($c, $v) {
			$queryWhere = array("index" => 4,
							"query" => "WHERE ");

			return $queryWhere;
		}
	}
?>