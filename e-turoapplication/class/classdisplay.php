<?php
	include_once'database.php';
	class display extends database{
		public function notifs(){
			$sql="select * from tblcontents where status='pending'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function selectfile($contentid){
			$sql="select file from tblcontents where contentid='$contentid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function displaycontent($contentid){
			$sql="select * from tblcontents where contentid='$contentid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function addhomecontents($userid,$contentid,$contentdetails){
			$datecreated=(date('Y-m-d')." ".date('H:i:s'));
			$timestamp=(date('Y-m-d')." ".date('H:i:s'));
			$sql="insert into tblcontents(id,userid,contentid,roomid,contenttitle,contentdetails,file,status,dateuploaded,timestamp) values(NULL,'$userid','$contentid','','','$contentdetails','','','$datecreated','$timestamp')";
			if($this->conn->query($sql)){
			return 'Posted Successfully';
			}else{
				return $this->conn->error;
			}
		}
		public function displayallcontent(){
			$sql="select * from tblcontents where status='' ";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function Comments($userid){
			$sql="select c.*, ct.contenttitle, ct.roomid, ct.studentname from tblcomment c inner join tblcontents ct on c.contentid=ct.contentid where ct.userid != '$userid' and ct.status = 'approved'  order by datecommented desc";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function PostedContents($userid){
			$sql="select c.*, r.roomname from tblcontents c inner join tblcourses r on c.roomid=r.roomid where c.userid != '$userid' and c.status = 'approved' order by dateuploaded desc";
			$data=$this->conn->query($sql);
			return $data; 
		}
		public function PostedLinks($userid){
			$sql="select l.*, r.roomname from tbllinks l inner join tblcourses r on l.roomid=r.roomid where l.userid != '$userid' order by dateuploaded desc";
			$data=$this->conn->query($sql);
			return $data; 
		}
		public function displaynotif($userid){
			$sql="select c.userid, c.id, c.studentname as sname, c.contentid, c.notifstatus, c.roomid as rid, c.contenttitle as ctitle, c.dateuploaded as dt, 'N/A' as ltime, r.roomname as rname, null as cid, null as cmt, 'tblcontents' as tblname from tblcontents c inner join tblcourses r on c.userid=r.userid where c.userid != '$userid' and c.roomid in (select roomid from tbljoinedroom where userid='$userid') group by c.id union select l.userid, l.id, l.studentname as sname, l.contentid, l.notifstatus, l.roomid as rid, l.linktitle as ctitle, l.dateuploaded as dt, l.linktime as ltime, r.roomname as rname, null as cid, null as cmt, 'tbllinks' as tblname from tbllinks l inner join tblcourses r on l.userid=r.userid where l.userid != '$userid' and l.roomid in (select roomid from tbljoinedroom where userid='$userid') group by l.id union 
			select ct.userid, c.id, ct.userid as sname, c.contentid, c.notifstatus, c.roomid as rid, c.contenttitle as ctitle, c.dateuploaded as dt, 'N/A' as ltime, c.contenttitle as rname, ct.commentid as cid, ct.comment as cmt, 'tblcomment' as tblname from tblcomment ct inner join tblcontents c on c.contentid=ct.contentid where c.userid = '$userid' order by dt desc";
			$data=$this->conn->query($sql);
			return $data; 
		}
		public function checkjoined($userid,$roomid){
			$sql="select * from tbljoinedroom where userid='$userid' and roomid='$roomid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function mycontents($userid){
			$sql="select * from tblcontents where userid='$userid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function myrooms($userid){
			$sql="select * from tblcourses where userid='$userid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function Displaysuggested($name,$userid){
			$sql="select * from tblcourses where roomname LIKE '%$name%' and userid LIKE '%$userid%' limit 6";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function RoomContents($roomid){
			$sql="select c.* from tblcontents c inner join tblcourses r on c.roomid=r.roomid where c.roomid='$roomid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function rooms(){
		$sql="select roomid from tblcourses";
		$data=$this->conn->query($sql);
		return $data;
		
		}
		public function deleteroom($roomid){
			$sql="delete from tblcourses where roomid='$roomid'";
			if($this->conn->query($sql)){
				return 'Content Deleted Successfully!';	
			}else{
				return $this->conn->error();
			}
		}
		public function searchstudent($studentid){
			$sql="select * from tblcourses where userid = '$studentid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function searchstudentname($name){
			$sql="select * from tblcourses where studentname LIKE '$name%' group by studentname";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function searchroomname($name){
			$sql="select * from tblcourses where roomname LIKE '%$name%'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function RepliesToComments($commentid){
			$sql="select * from tblreply where commentid='$commentid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		
		public function savereply($userid,$contentid,$commentid,$replyid,$reply){
			$datereplied=(date('Y-m-d')." ".date('H:i:s'));
			$sql="insert into tblreply(id,userid,contentid,commentid,replyid,reply,datereplied) values(NULL,'$userid','$contentid','$commentid','$replyid','$reply','$datereplied')";
			if($this->conn->query($sql)){
			return 'Reply Successfully';
			}else{
				return $this->conn->error;
			}
			//return 'hello';
		}
		public function  Checkcomment($commentid){
			$sql="select sum(id) as replycount from tblreply where commentid='$commentid'";
			$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['replycount'];
			}
		}
		public function Displayroomdetails($roomid){
			$sql="select * from tblcourses where roomid='$roomid' ";
			$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['roomname'];
			}
		}
		public function getName($roomid){
			$sql="select studentname from tblcontents where roomid='$roomid'";
			$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['studentname'];
			}
		}
		public function getdt($roomid){
			$sql="select dateuploaded from tblcontents where roomid='$roomid' order by dateuploaded desc limit 1";
			$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['dateuploaded'];
			}
		}
		public function displayallroom($userid){
			$sql="select * from tblcourses where userid!='$userid' ";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function checkdashboard($userid,$roomid){
			$sql="select * from tbldashboard where userid='$userid' and roomid='$roomid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function PendingContents($status){
			$sql="select c.*, u.coursename from tblcontents c inner join tbluser u on c.userid=u.userid where c.status LIKE '%$status%'  limit 10";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function getallapproved($userid){
			$sql="select cr.*, u.coursename from tblcontentreview cr inner join tbluser u on cr.studentid=u.userid where cr.userid='$userid' and cr.status='approved'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function getalldeclined($userid){
			$sql="select cr.*, u.coursename from tblcontentreview cr inner join tbluser u on cr.studentid=u.userid where cr.userid='$userid' and cr.status='declined'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function getallcomment($contentid){
			//$sql="select cm.*, c.studentname, c.coursename from tblcomment cm inner join tblcontents c on cm.userid=c.userid  where cm.contentid='$contentid'";
			$sql="select cm.*, u.lastname, u.firstname, u.middlename, u.coursename from tblcomment cm inner join tbluser u on cm.userid=u.userid where cm.contentid='$contentid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function countpending(){
		$sql="select count(status) as cntpending from tblcontents where status LIKE '%pending%'";
		$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['cntpending'];
			}
		}
		public function getAllPending(){
			$sql="select * from tblcontents where status='pending'";
			$data=$this->conn->query($sql);
			return $data;
			
		}
		public function Displayallapproved(){
			$sql="select cr.*, c.file, c.dateuploaded, u.coursename from (tblcontentreview cr inner join tblcontents c on cr.contentid=c.contentid) inner join tbluser u on cr.studentid=u.userid where cr.status='approved'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function countapproved(){
		$sql="select count(status) as cntapproved from tblcontents where status='approved'";
		$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['cntapproved'];
			}
		}
		public function getfiles($contentid){
			$sql="select * from tblcontents where contentid='$contentid'";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function displaystudentcourses(){
			$sql="select * from tblcourses order by id desc";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function displaycoursecontents($courseid){
			$sql="select * from tblcontents where roomid='$courseid' and status LIKE '%approved%' order by id desc";
			$data=$this->conn->query($sql);
			return $data;
		}
		public function countcourses(){
		$sql="select count(id) as cntcrs from tblcourses";
		$data=$this->conn->query($sql);
			if($row=$data->fetch_assoc()){
				return $row['cntcrs'];
			}
		}
		Public Function searchcourses($course){
			$sql="select * from tblcourses where roomname LIKE '%$course%' ";
			$data=$this->conn->query($sql);
			return $data;
		}
	}
?>
