<?php
$course=$_GET['course'];

include_once'../class/classdisplay.php';
$d=new display();

$data=$d->searchcourses($course);
	if($data->num_rows==0){
		echo'
			<tr><td colspan=2 class="text-center text-dark">NO COURSE/S FOUND!</td></tr>
		';
	}
	while($row=$data->fetch_assoc()){
		$courseid=$row['roomid'];
		$coursename=$row['roomname'];
		$image=$row['image'];
		$course=$row['course'];
		$name=$row['studentname'];
		$dc=$row['datecreated'];
		
		if($image!=''){
			$cimg=$image;
		}else{
			$cimg='../images/def5.jpg';
		}
		echo'
		<tr>
			<td>
				<div class="d-flex">
					<div>
						<img src="'.$cimg.'" width="40px">
					</div>
					<div style="margin-left: 10px; font-size: 10px;" class="mt-2">
						<div class="font-weight-bold">COURSE: '.$coursename.'</div>
						<div class="font-italic text-secondary" style="margin-top: -4px;">'.$name.'</div>
						<div class="text-info" style="margin-top: -4px;">'.date('M d, Y',strtotime($dc)).'</div>
					</div> 
				</div>
			</td>
			<td class="text-center">
				<button type="button" class="rounded-circle shadow-none mt-4" onclick="coursescontent(&quot;'.$courseid.'&quot;,&quot;'.$name.'&quot;,&quot;'.$coursename.'&quot;)"> <i class="fas fa-eye"></i></button>
			</td>
		</tr>
		';
	}
?>