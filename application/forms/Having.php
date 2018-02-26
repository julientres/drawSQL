<?php
	class Having extends Form {
		private $column;
		private $operation;

		public function __construct($image, $column, $operation) {
			super($image);
			$this->column = $column;
			$this->operation = $operation;
		}

		public function convertToSQL($c, $o) {
			$result = array("index" => 6,
							"query" => "HAVING");

			return $result;
		}
	}
?>