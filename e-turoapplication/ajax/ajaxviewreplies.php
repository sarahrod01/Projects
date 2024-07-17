<?php
	include_once'../class/class.php';
	$u=new User();
	
	include'../../api/src/apifunction.php';
	$un='user';//api username 
	$pw='pass';//api password
	
	$data=$u->displayreplies($_GET['commentid']);
	while($row = $data->fetch_assoc()){
		$date=$row['datereplied'];
		$dt=date('M d, Y',strtotime($date));
		
		student($row['userid']);

		$cnt=count($re->data);//data count
		for($c=0;$c<$cnt;$c++){
			$student_id=$re->data[$c]->Student_Id;//get student id from JSON file
			$ln=$re->data[$c]->LastName;//get last name id from JSON file
			$fn=$re->data[$c]->FirstName;//get first name id from JSON file
			$mn=$re->data[$c]->MiddleName;//get middle name id from JSON file
			$course=$re->data[$c]->Course;//get course id from JSON file
			$pic=$re->data[$c]->Pic;//get course id from JSON file
			
			if($pic==''){
				$pic='../images/sub.png';
			}else{
				$pic;
			}
		}
		echo'
			<div class="box " style="margin-left: 50px;">
				<div class="user">
					<img src="../images/sub.png" style="width: 40px; height: 40px;" alt="">
					<div>
						<h5>'.$fn.' '.$ln.'</h5>
						<div><h4>'.$row['reply'].'</h4></div>
						<span><h6>'.$dt.'</h6></span>
					</div>
				</div>
			</div>
		';
	}
?>