<?php
	abstract class Form {

		public function __construct() {
		}

		abstract public function convertToSQL();
	}
?>