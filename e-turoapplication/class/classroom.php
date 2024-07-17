<?php
	include_once'database.php';
	class room extends database{
		public function	declinecontent($studentid,$studentname,$contentid,$roomid,$contenttitle,$file,$userid,$reviewby){
			$datereviewed=(date('Y-m-d')." ".date('H:i:s'));
			$sql="update tblcontents set status='declined' where contentid='$contentid';";
			$sql.="insert into tblcontentreview values(NULL,'$studentid','$studentname','$contentid','$roomid','$contenttitle','$file','$userid','$reviewby','declined','$datereviewed')";
			if($this->conn->multi_query($sql)){
				return 'Content Declined!';	
			}else{
				return $this->conn->error();
			}
		}
		public function acceptcontent($contentid,$splitst,$file,$userid,$act){
			$datereviewed=(date('Y-m-d')." ".date('H:i:s'));
			$sql="update tblcontents set status='$splitst' where contentid='$contentid';";
			$sql.="insert into tblcontentreview values(NULL,'$contentid','$file','$userid','$act','$datereviewed')";
			if($this->conn->multi_query($sql)){
				return 'Content Approved!';	
			}else{
				return $this->conn->error();
			}
		}
		public function approvedtodecline($contentid){
			$sql="update tblcontents set status='declined' where contentid='$contentid';";
			$sql.="update tblcontentreview set status='declined' where contentid='$contentid'";
			if($this->conn->multi_query($sql)){
				return 'Content Declined!';	
			}else{
				return $this->conn->error();
			}
		}
		public function declinedtoapprove($contentid){
			$sql="update tblcontents set status='approved' where contentid='$contentid';";
			$sql.="update tblcontentreview set status='approved' where contentid='$contentid'";
			if($this->conn->multi_query($sql)){
				return 'Content Approved!';	
			}else{
				return $this->conn->error();
			}
		}
		public function deleteaddbadword($commentid,$comment){
			$sql="delete from tblcomment where commentid='$commentid';";
			$sql.="insert into tblbadwords values(NULL,'$comment')";
			if($this->conn->multi_query($sql)){
			return 'Comment Deleted successfully!';
			}else{
				return $this->conn->error;
			}
		}
		
	}
?>