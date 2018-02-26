<?php
	class Select extends Form{
		private $column;
		private $aggregate;

		public function __construct($image, $column, $aggregate) {
			super($image);
			$this->column = $column;
			$this->aggregate = $aggregate;
		}

		public function convertToSQL($c, $a) {
			$strC = implode(",", $c);
			$strA = implode(",", $a);

			$querySelect = array("index" => 1,
							"query" => "SELECT " . $a . $c);

			return $querySelect;
		}
	}
?>