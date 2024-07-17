<?php
	include_once'database.php';
	class Cuser extends database{
		public function login($un,$pw){
			$sql="select * from tbluser where username='$un' and password='$pw'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function addmoderator($userid,$un,$pw,$lname,$fname,$mname,$email,$contact,$address,$course){
			$sql="insert into tbluser values(NULL,'$userid','$un','$pw','$lname','$fname','$mname','$email','$contact','$address','$course','active','moderator')";
			if($this->conn->query($sql)){
			return "Successfully Register!";
			}else{
				return $this->conn->error;
			}
		}
		public function addstudent($userid,$un,$pw,$lname,$fname,$mname,$course){
			$sql="insert into tbluser values(NULL,'$userid','$un','$pw','$lname','$fname','$mname','','','','$course','active','student')";
			if($this->conn->query($sql)){
				//return "Successfully Register!";
			}else{
				return $this->conn->error;
			}
		}
		public function displaymoderators(){
			$sql="select * from tbluser where role='moderator'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function getStatus($userid){
			$sql="select * from tbluser where userid='$userid' ";
			$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['status'];
			}
		}
		public function UpdateStatus($userid,$stat){
			$sql="update tbluser set status='$stat' where userid='$userid' ";
			if($this->conn->query($sql)){
			return 'STATUS UPDATED SUCCESSFULLY!'; 
		}else{
			return $this->conn->error;
		}
		}
		public function updatemoderator($lname,$fname,$mname,$email,$contact,$address,$course,$userid){
			$sql="update tbluser set lastname='$lname', firstname='$fname', middlename='$mname', email='$email', contact='$contact', address='$address', coursename='$course'  where userid='$userid' ";
			if($data=$this->conn->query($sql)){
				return 'SUCCESSFULLY UPDATED!';
			
			}else{
				return $this->conn->query;
			}
			}
		public function getName($userid){
			$sql="select * from tbluser where userid='$userid'";
			$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['firstname'].' '.$row['lastname'];
			}else{
				return $this->conn->query;
			}
		}
		public function searchModerator($name){
			$sql="select * from tbluser where firstname LIKE '$name%'  limit 10";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function checkstudentname($userid){
			$sql="select * from tbluser where userid='$userid'";
			$data=$this->conn->query($sql);
			return $data;
		}
	}
?>