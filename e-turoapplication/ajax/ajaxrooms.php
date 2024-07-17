<?php
    session_start();
    $userid = $_SESSION['studentid'];

    include_once '../class/class.php';
    include_once '../class/classdisplay.php';
    include '../../api/src/apifunction.php';
	
    $d = new display();
    $u = new User();
	
    $un = 'user'; // api username
    $pw = 'pass'; // api password
	
    $rname = $_GET['rname'];

    $data = $d->Displaysearchrooms($rname);

    if ($data->num_rows > 0) {
        echo '<div class="box-container">';
			while ($row = $data->fetch_assoc()) {
				$date = $row['datecreated'];
				$dt = date('M d, Y', strtotime($date));
				$roomid = $row['roomid'];

				if ($row['image'] == '') {
					$img = 'def5.jpg';
				} else {
					$img = $row['image'];
				}
				student($row['userid']);

				$cnt = count($re->data);

				for($c=0;$c<$cnt;$c++){
					$student_id=$re->data[$c]->Student_Id;//get student id from JSON file
					$ln=$re->data[$c]->LastName;//get last name id from JSON file
					$fn=$re->data[$c]->FirstName;//get first name id from JSON file
					$mn=$re->data[$c]->MiddleName;//get middle name id from JSON file
					$course=$re->data[$c]->Course;//get course id from JSON file
				}
				
				$image=$u->selectphoto($roomid);
				if($image ==  ''){
					$image = 'def5.jpg';
				}else{
					$image = $row['image'];
				}
				

				echo '
					<div class="box">
						<div class="d-flex justify-content-between">
							<div><h2 class="title">'.$row['roomname'].'</h2></div>
							<div><button type="submit" name="btnaddtoboard" value="'.$roomid.'" class="form-control text-white addbtn" data-toggle="tooltip" data-placement="bottom" title="Add to Dashboard"><i class="fas fa-plus"></i><button></div>
						</div>
						<div class="thumb">
							<img src="../images/'.$img.'"  alt="" onclick="viewroom(&quot;'.$userid.'&quot;,&quot;'.$row['roomid'].'&quot;)">
						</div>
						<div class="tutor mt-4">
							<img src="../images/pic-2.jpg" alt="">
							<div class="info">
							   <h5>'.$fn.' '.$ln.'</h5>
							   <span>'.$dt.'</span>
							</div>
						</div>
					</div>
				';
			}
		echo '</div>'; // close the container
	} else {
		echo '<div>No data found</div>';
	}
?>

	