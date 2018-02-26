<?php
	class OrderBy extends Form {
		private $column;
		private $order;

		public function __construct($image, $column, $order) {
			super($image);
			$this->column = $column;
			$this->order = $order;
		}

		public function convertToSQL($c, $o) {
			$queryOrderBy = array("index" => 7,
							"query" => "ORDER BY ");

			return $queryOrderBy;
		}
	}
?>