<?php
date_default_timezone_set('Asia/Manila');
include_once'database.php';
Class User extends Database{
	public function addroom($userid,$studentname,$roomid,$roomname,$roomdetails,$course,$image){
		$datecreated=(date('Y-m-d')." ".date('H:i:s'));
		$timestamp=(date('Y-m-d')." ".date('H:i:s'));
		$sql="insert into tblcourses values(NULL,'$userid','$studentname','$roomid','$roomname','$roomdetails','$course','$image','$datecreated','$timestamp')";
		if($this->conn->query($sql)){
			return '';
		}else{
			return $this->conn->error;
		}
	}
	public function displayrooms($userid){
		$sql="select * from tblcourses where userid='$userid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function displayroomdetails($roomid){
		$sql="select * from tblcourses where roomid='$roomid' ";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function postcontent($userid,$studentname,$contentid,$roomid,$contentname,$contentdetails,$file,$status){
		$dateuploaded=(date('Y-m-d')." ".date('H:i:s'));
		$timestamp=(date('Y-m-d')." ".date('H:i:s'));
		if($file!=''){
			$sql="insert into tblcontents values(NULL,'$userid','$studentname','$contentid','$roomid','$contentname','$contentdetails','$file','$status','not completed','unread','$dateuploaded','$timestamp')";
		}else{
			$sql="insert into tblcontents values(NULL,'$userid','$studentname','$contentid','$roomid','$contentname','$contentdetails','','$status','not completed','unread','$dateuploaded','$timestamp')";
		}
		if($this->conn->query($sql)){
			return '';
		}else{
			return $this->conn->error;
		}
	}
	public function createlink($userid,$studentname,$contentid,$roomid,$linkdate,$linktime,$linktitle,$linkdetails){
		$dateuploaded=(date('Y-m-d')." ".date('H:i:s'));
		$timestamp=(date('Y-m-d')." ".date('H:i:s'));
		$sql="insert into tbllinks values(NULL,'$userid','$studentname','$contentid','$roomid','$linkdate','$linktime','$linktitle','$linkdetails','unread','$dateuploaded','$timestamp')";
		if($this->conn->query($sql)){
			return '';
		}else{
			return $this->conn->error;
		}
	}
	public function displaycontents($roomid){
		$sql="select * from tblcontents where roomid='$roomid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function displaylinks($roomid){
		$sql="select * from tbllinks where roomid='$roomid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function displayallcontents(){
		$sql="select * from tblcontents where status='approved'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function addcomment($userid,$contentid,$commentid,$comment,$file){
		$datecommented=(date('Y-m-d')." ".date('H:i:s'));
		$timestamp=(date('Y-m-d')." ".date('H:i:s'));
		$sql="insert into tblcomment values(NULL,'$userid','$contentid','$commentid','$comment','$file','unread','$datecommented','$timestamp')";
		if($this->conn->query($sql)){
			return 'Comment Added';
		}else{
			return $this->conn->error;
		}
	}
	public function displaycomments($contentid){
		$sql="select * from tblcomment where contentid='$contentid' order by id desc";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function countcomment($contentid){
		$sql="select count(commentid) as cntcomment from tblcomment where contentid='$contentid'";
		$data=$this->conn->query($sql);
		if($row=$data->fetch_assoc()){
			return $row['cntcomment'];
		}
	}
	public function checkjoinedroom($userid, $roomid){
		$sql="select * from tbljoinedroom where userid='$userid' and roomid='$roomid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function displayjoinedroom($userid){
		$sql="select roomid from tbljoinedroom where userid='$userid'";
		$data=$this->conn->query($sql);
		if($row=$data->fetch_assoc()){
			return $row['roomid'];
		}
	}
	public function checkcontent($userid, $roomid){
		$sql="select * from tblcourses where userid='$userid' and roomid='$roomid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function joinroom($userid, $roomid){
		$datejoined=(date('Y-m-d')." ".date('H:i:s'));
		$timestamp=(date('Y-m-d')." ".date('H:i:s'));
		$sql="insert into tbljoinedroom values(NULL, '$userid','$roomid','$datejoined','$timestamp')";
		if($this->conn->query($sql)){
			return 'You successfully joined this room!!';
		}else{
			return $this->conn->error;
		}
	}
	public function savetodashboard($userid,$roomid){
		$datejoined=(date('Y-m-d')." ".date('H:i:s'));
		$timestamp=(date('Y-m-d')." ".date('H:i:s'));
		$sql="insert into tbldashboard values(NULL, '$userid','$roomid','$datejoined','$timestamp')";
		if($this->conn->query($sql)){
			
		}else{
			return $this->conn->error;
		}
	}
	public function addtoDash($userid,$roomid){
		$dateadded=(date('Y-m-d')." ".date('H:i:s'));
		$timestamp=(date('Y-m-d')." ".date('H:i:s'));
		$sql="insert into tbldashboard values(NULL,'$userid','$roomid','$dateadded','$timestamp');";
		$sql.="insert into tbljoinedroom values(NULL, '$userid','$roomid','$dateadded','$timestamp')";
		if($this->conn->multi_query($sql)){
			return 'You successfully added the course!! Go to subscriptions page to view added courses.';
		}else{
			return $this->conn->error;
		}
	}
	public function displayaddedrooms($userid){
		$sql="select r.* from tblcourses r inner join tbldashboard d on r.roomid=d.roomid where d.userid='$userid'";
		//$sql="select * from tbldashboard where userid='$userid'";
		$data=$this->conn->query($sql);
		return $data;
		
	}
	public function countcompleted($roomid){
		$sql="select count(contentstatus) as countstatus from tblcompletedcontents where roomid='$roomid'";
		$data=$this->conn->query($sql);
		if($row = $data->fetch_assoc()){
			return $row['countstatus']+1;
		}
	}
	public function updatecontentstatus($contentid){
		$sql="update tblcontents set contentstatus='completed' where contentid='$contentid'";
		if($this->conn->query($sql)){
			return 'status updated';
		}else{
			return $this->conn->error;
		}
	}
	public function updatecontentinfo($contentid,$contenttitle,$contentdetails){
		$sql="update tblcontents set contenttitle='$contenttitle', contentdetails='$contentdetails' where contentid='$contentid'";
		if($this->conn->query($sql)){
			return 'Content Info Updated';
		}else{
			return $this->conn->error;
		}
	}
	public function addtocompletedcontents($userid,$contentid,$roomid){
		$sql="select * from tblcompletedcontents where userid='$userid' and contentid='$contentid'";
		$data=$this->conn->query($sql);
		if($row = $data->fetch_assoc()){
			
		}else{
			$datecompleted=(date('Y-m-d')." ".date('H:i:s'));
			$sql="insert into tblcompletedcontents values(NULL,'$userid','$contentid','$roomid','completed','$datecompleted')";
			if($this->conn->query($sql)){
				return 'Content completed!!';
			}else{
				return $this->conn->error;
			}
		}
	}
	public function selectphoto($roomid){
		$sql="select * from tblcourses where roomid='$roomid'";
		$data=$this->conn->query($sql);
		if($row = $data->fetch_assoc()){
			return $row['image'];
		}else{
			return 'def5.jpg';;
		}
	}
	public function checkdashboard($userid,$roomid){
		$sql="select * from tbldashboard where userid='$userid' and roomid='$roomid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function count_studentpost(){
		$sql="select count(contentid) as countpending from tblcontents where status='pending' ";
		if($data=$this->conn->query($sql)){
			if($row=$data->fetch_assoc()){
				return $row['countpending'];
			}
		}else{
			return 0;
		}
	}
	public function count_joinpost(){
		$sql="select count(contentid) as countpending from tblcontents where status='pending' ";
		if($data=$this->conn->query($sql)){
			if($row=$data->fetch_assoc()){
				return $row['countpending'];
			}
		}else{
			return 0;
		}
	}
	public function displayroomname($roomid){
		$sql="select r.roomname from tblcourses r inner join tblcontents c on c.roomid=r.roomid where c.roomid='$roomid'";
		$data=$this->conn->query($sql);
		if($row = $data->fetch_assoc()){
			return $row['roomname'];
		}
	}
	public function getNextContentId($currentContentId) {
        $nextContentId = $currentContentId + 1;
        $sql = "select id from tblcontents where id = '$nextContentId'";
        $data = $this->conn->query($sql);

        if ($data->num_rows > 0){
			if($row = $data->fetch_assoc()){
				return $row['id'];
			}
        } else {
            return $this->conn->error;
        }
    }
	public function displaycompletedcontents($contentid,$roomid){
		$sql="select * from tblcompletedcontents where contentid = '$contentid' and roomid='$roomid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function getcompletedcontents($roomid){
		$sql="select * from tblcontents where roomid='$roomid' and status='approved'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function completedcontents($contentid,$roomid){
		$sql="select contentstatus from tblcompletedcontents where contentid = '$contentid' and roomid='$roomid'";
		$data=$this->conn->query($sql);
		if($row = $data->fetch_assoc()){
			return 1;
		}else{
			return 0;
		}
	}
	public function displaynotcompletedcontents($contentid,$roomid){
		$sql="select * from tblcontents where contentid not in($contentid) and roomid='$roomid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function updaterooms($roomname,$roomdetails,$course,$img,$roomid){
		if($img == ''){
			$sql="update tblcourses set roomname='$roomname', roomdetails='$roomdetails', course='$course' where roomid='$roomid' ";
		}else{
			$sql="update tblcourses set roomname='$roomname', roomdetails='$roomdetails', course='$course', image='$img' where roomid='$roomid' ";
		}
		if($this->conn->query($sql)){
			return 'Room Updated Successfully!';
		}else{
			return $this->conn->error;
		}
	}
	public function updatenotifstatus($contentid){
		$sql="update tblcontents set notifstatus='read' where contentid='$contentid'";
		if($this->conn->query($sql)){
			return 'status updated';
		}else{
			return $this->conn->error;
		}
	}
	public function updatelinkstatus($contentid){
		$sql="update tbllinks set notifstatus='read' where contentid='$contentid'";
		if($this->conn->query($sql)){
			return 'status updated';
		}else{
			return $this->conn->error;
		}
	}
	public function count_newNotif($userid){
		$sql="select count(notifstatus) as Contentunread from tblcontents where userid != '$userid' and notifstatus='unread'";
		$data=$this->conn->query($sql);
		if($row=$data->fetch_assoc()){
			return $row['Contentunread'];
		}else{
			return 0;
		}
	}
	function displaycontentwithid($id){
		$sql="select * from tblcontents where id='$id'";
		$data=$this->conn->query($sql);
		return $data;
	}
	function displaylinkwithid($id){
		$sql="select * from tbllinks where id='$id'";
		$data=$this->conn->query($sql);
		return $data;
	}
	function leaveroom($userid, $roomid){
		$sql="delete from tbljoinedroom where userid='$userid' and roomid='$roomid';";
		$sql.="delete from tbldashboard where userid='$userid' and roomid='$roomid'";
		if($this->conn->multi_query($sql)){
			return 'You successfully left this room!!';
		}else{
			return $this->conn->error;
		}
	}
	public function count_studentroom($userid){
		$sql="select count(userid) as countroom from tblcourses where userid='$userid' ";
		if($data=$this->conn->query($sql)){
			if($row=$data->fetch_assoc()){
				return $row['countroom'];
			}
		}else{
			return 0;
		}
	}
	public function count_studentcontents($userid){
		$sql="select count(userid) as countpost from tblcontents where userid='$userid' and status='approved'";
		if($data=$this->conn->query($sql)){
			if($row=$data->fetch_assoc()){
				return $row['countpost'];
			}
		}else{
			return 0;
		}
	}
	public function Mycontents($userid){
		$sql="select c.*, r.roomname from tblcontents c inner join tblcourses r on r.roomid=c.roomid where c.userid='$userid' and c.status='approved' limit 1";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function deletelink($contentid){
		$sql="delete from tbllinks where contentid = '$contentid'";
		if($this->conn->query($sql)){
			
		}else{
			return $this->conn->error;
		}
	}
	public function displayreplies($commentid){
		$sql="select * from tblreply where commentid='$commentid' order by datereplied desc limit 4 ";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function displayCourse(){
		$sql="select * from tblcourses";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function getfirstcompleted($roomid){
		$sql="select id from tblcontents where roomid='$roomid' limit 1";
		$data=$this->conn->query($sql);
		if($row=$data->fetch_assoc()){
			return $row['id'];
		}
	}
	public function updatecontentfile($id,$file){
		$sql="update tblcontents set file=CONCAT(file,',$file'),status=CONCAT(status,',pending') where id='$id'";
		if($this->conn->query($sql)){
			
		}else{
			return $this->conn->error;
		}
	}
	public function selectcover($userid){
		$sql="select * from tblcover where userid='$userid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function addcoverphoto($userid,$coverid,$image){
		$dateuploaded=(date('Y-m-d')." ".date('H:i:s'));
		$sql="insert into tblcover values(NULL,'$userid','$coverid','$image','$dateuploaded')";
		if($this->conn->query($sql)){
			//return 'Cover Successfully added!';
		}else{
			return $this->conn->error;
		}
	}
	public function updatecover($userid,$image){
		$dateuploaded=(date('Y-m-d')." ".date('H:i:s'));
		$sql="update tblcover set image='$image'  where userid='$userid'";
		if($this->conn->query($sql)){
			//return 'Cover Successfully updated!';
		}else{
			return $this->conn->error;
		}
	}
	public function getNumber(){
		$sql="select * from tbluser where role='moderator'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function getstudentname($userid){
		$sql="select * from tbluser where userid='$userid'";
		$data=$this->conn->query($sql);
		return $data;
	}
	public function searchstudentname($searchstudent){
		$sql="select * from tbluser where concat(firstname,' ',lastname) = '$searchstudent'";
		$data=$this->conn->query($sql);
		return $data;
	}
}
?>