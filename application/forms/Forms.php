<?php
	abstract class Form {
		private $image;

		public function __construct($image) {
			$this->image = $image;
		}

		abstract public function setAggregate() {}

		abstract public function convertToSQL() {}
	}
?>