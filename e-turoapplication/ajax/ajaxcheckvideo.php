<?php
	include_once'../class/class.php';
	$u=new User();
	
	$userid=$_GET['userid'];
	$contentid=$_GET['contentid'];
	$roomid=$_GET['roomid'];
	$id=$_GET['id'];

	if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['video_finished']) && $_GET['video_finished'] === 'true') {
		$u->addtocompletedcontents($userid,$contentid,$roomid);

		$data=$u->displaycontents($roomid);
		$cid="";
		while($row = $data->fetch_assoc()){
			$completedcontents=$u->displaycompletedcontents($row['contentid'],$row['roomid']);
			while($row = $completedcontents->fetch_assoc()){
				$cid=$cid."'".$row['contentid']."',";
			}
		}
		$cid=rtrim($cid,',');
		//echo $cid;
		$notcompleted=$u->displaynotcompletedcontents($cid,$roomid);
		if($row = $notcompleted->fetch_assoc()){
			echo $row['id'];
		}else{
			echo $u->getfirstcompleted($roomid);
		}
	} 
?>