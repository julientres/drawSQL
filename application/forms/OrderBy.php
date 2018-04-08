<?php
	class OrderBy{
		private $column;
		private $order;

		public function __construct($column, $order) {
			$this->column = $column;
			$this->order = $order;
		}

		public function getColumn(){
            return $this->column;
        }

	}
