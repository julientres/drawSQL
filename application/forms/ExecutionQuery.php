<?php
	require_once('/../../fonctions.php');

	class ExecutionQuery {
		private $select;
		private $from;
		/*
		private $where;
		private $join;
		private $having;
		private $orderBy;
		private $groupBy;
		private $subQuery;
		*/

		public function __construct($select, $from) {
			$this->select = $select;
			$this->from = $from;
		}

        public function exec() {
            $bdd = doConnexion();
            $str = "" . $this->select . " " . $this->from .";";
            $query = $bdd['object']->prepare($str);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
        public function searchNameColumn($table){
            $bdd = doConnexion();
            $str = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" . $table . "';";
            $query = $bdd['object']->prepare($str);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function showResults($resultat,$nameColumn) {
            foreach($resultat as $r) {
                echo '<p>';
                foreach ($nameColumn as $nC) {
                    echo $r[$nC['COLUMN_NAME']];
                    echo " ";
                }
                echo '</p>';
            }
		}
	}
?>