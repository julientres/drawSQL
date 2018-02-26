<?php
	class Join extends Form{
		private $table;

		public function __construct($image, $table) {
			super($image);
			$this->table = $table;
		}
		
		public function convertToSQL($t) {
			$queryJoin = array("index" => 3,
							"query" => "JOIN ");

			return $queryJoin;
		}
	}
?>