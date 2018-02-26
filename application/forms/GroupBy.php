<?php
	class GroupBy extends Form {
		private $column;

		public function __construct($image, $column) {
			super($image);
			$this->column = $column;
		}

		public function convertToSQL($c) {
			$str = implode(",", $c);
			
			$queryGroupBy = array("index" => 5,
							"query" => "GROUP BY " . $str);

			return $queryGroupBy;
		}
	}
?>