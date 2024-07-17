<?php
	include_once'database.php';
		class words extends database{
			public function listwords($word){
				$sql="select * from tblbadwords where words in ($word)";
				$data=$this->conn->query($sql);
				return $data;
			}
			
		}
?>