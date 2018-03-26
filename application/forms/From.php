<?php
	class From{
		private $table;

        public function __construct($table) {
            $this->table = $table;
        }

        public function convertToSQL() {
            $queryFrom = "FROM ".$this->table;

            return $queryFrom;
        }

        public function getTable(){
            return $this->table;
        }
	}
