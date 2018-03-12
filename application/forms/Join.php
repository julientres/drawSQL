<?php
	class Join{
		private $table;
        private $join;

		public function __construct($table,$join) {
			$this->table = $table;
            $this->join = $join;
		}
		
		public function convertToSQL($equal) {
			$queryJoin =  $this->join ." ".$this->table." ON ". $equal . ";";
			return $queryJoin;
		}
	}
?>