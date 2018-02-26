<?php
	class From extends Form {
		private $table;

		public function __construct($image, $table) {
			super($image);
			$this->table = $table;
		}

		public function convertToSQL($t) {
			$queryFrom = array("index" => 2,
							"query" => "FROM ".$t);

			return $queryFrom;
		}
	}
?>