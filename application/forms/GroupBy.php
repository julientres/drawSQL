<?php
	class GroupBy{
		private $column;

		public function __construct($column) {
			$this->column = $column;
		}

        public function getColumn()
        {
            return $this->column;
        }

        public function convertToSQL() {
            $queryFrom = "GROUP BY ".$this->column;

            return $queryFrom;
        }
	}
