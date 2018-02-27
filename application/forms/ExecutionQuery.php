<?php
	require_once('../../fonctions.php');
	require_once('HelpDataEntry.php');

	class ExecutionQuery {
		private $select;
		private $from;
		private $where;
		private $join;
		private $having;
		private $orderBy;
		private $groupBy;
		private $subQuery;

		public function __construct($select, $from, $where, $join, $having, $orderBy, $groupBy, $subQuery) {
			$this->select = $select;
			$this->from = $from;
			$this->where = $where;
			$this->join = $join;
			$this->having = $having;
			$this->orderBy = $orderBy;
			$this->groupBy = $groupBy;
			$this->subQuery = $subQuery;
		}

		public function exec($s, $f, $w, $j, $h, $o, $g, $s) {
			$str = "";
			$query = $bdd->prepare($query);	
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		public function showResults($res) {
			echo '<table class="table">';
       		echo '<thead class="thead-light">';
            echo '<tr>';
            echo '<th scope="col">#</th>';
            echo '<th scope="col"></th>';          
            echo '</tr>';
         	echo '</thead>';
        	echo '<tbody>';
       
            foreach($res as $r) {
                echo '<tr>';
                echo '<td>'.$r.'</td>';
                echo '</tr>';
            }
        
        	echo '</tbody>';
    		echo '</table>';
		}
	}
?>