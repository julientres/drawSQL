<?php
	abstract class Form {
		private $image;

		public function __construct($image) {
			$this->image = $image;
		}

		abstract public function convertToSQL();
	}
?>