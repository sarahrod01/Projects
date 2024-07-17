<?php
	Class database{
		public $conn;
		
		public function __construct(){
			$this -> conn =	new mysqli('localhost','root','','e-turodatabase');	
		}
		
	}
?>