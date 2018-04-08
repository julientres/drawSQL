<?php
	class SubQuery{
		private $select;
		private $from;
		private $where;
		private $join;
		private $having;
		private $orderBy;
		private $groupBy;
		private $numberOfForms;

		public function __construct($select, $from, $where, $join, $having, $orderBy, $groupBy, $numberOfForms) {
			$this->select = $select;
			$this->from = $from;
			$this->where = $where;
			$this->join = $join;
			$this->having = $having;
			$this->orderBy = $orderBy;
			$this->groupBy = $groupBy;
			$this->numberOfForms = $numberOfForms;
		}

		public function convertToSQL($s, $f, $w, $j, $h, $o, $g, $n) {
			$querySubQuery = array("index1" => "4bis",
							"index2" => "6bis",
							"query" => "");

			return $querySubQuery;
		}
	}
?>