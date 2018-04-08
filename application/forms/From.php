<?php
	class From{
		private $table;

        public function __construct($table) {
            $this->table = $table;
        }
        public function getTable(){
            return $this->table;
        }
	}
