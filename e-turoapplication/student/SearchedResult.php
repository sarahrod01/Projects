<?php
	$show='';
	if(isset($_POST['studentsearch'])){
		$searchstudent=$_POST['studentsearch'];
		$show='hidden';
?>

	<section class="courses">
		<h1 class="heading">Results..</h1>
		
		<form method="POST">
			<div class="box-container">
				<?php
					include_once'../class/classdisplay.php';
					$d=new Display();
					include_once'../class/class.php';
					$u=new User();
					
					$getstudentinfo=$u->searchstudentname($searchstudent);
					if($tbl = $getstudentinfo->fetch_assoc()){
						$student_id=$tbl['userid'];
						$fn=$tbl['firstname'];
						$mn=$tbl['middlename'];
						$ln=$tbl['lastname'];
					}
					$data=$d->searchstudent($student_id);
					while($row = $data->fetch_assoc()){
						if($row['userid']!=$userid){
							$date=$row['datecreated'];
							$dt=date('M d, Y',strtotime($date));
							if($row['image']==''){
								$img='def5.jpg';
							}else{
								$img=$row['image'];
							}
							
							$checkdashboard = $d->checkdashboard($userid, $row['roomid']);
							if($checkdashboard->num_rows > 0){
								$outputbutton='<i class="fas fa-check"></i>';
								$outputbutton2='disabled title="Already added to subscriptions page"';
							}else{
								$outputbutton='<i class="fas fa-plus"></i>';
								$outputbutton2='title="Add to subscriptions page"';
							}
							
							$getstudentinfo=$u->getstudentname($row['userid']);
							if($tbl = $getstudentinfo->fetch_assoc()){
								$student_id=$tbl['userid'];
								$fn=$tbl['firstname'];
								$mn=$tbl['middlename'];
								$ln=$tbl['lastname'];
						
								echo'
									<div class="box" >
										<div class="d-flex justify-content-between">
											<div><h2 class="title">' . $row['roomname'] . '</h2></div>
											<div><button type="button" onclick="addtoboard(&quot;'.$row['roomid'].'&quot;)" class="form-control text-white addbtn" data-toggle="tooltip" data-placement="bottom" '.$outputbutton2.'>'.$outputbutton.'</button></div>
										</div>
										<div class="thumb">
											<img src="../images/'.$img.'"  alt="" onclick="viewroom(&quot;'.$row['userid'].'&quot;,&quot;'.$row['roomid'].'&quot;)">
										</div>
										<div class="tutor mt-2" onclick="openprofile(&quot;'.$row['userid'].'&quot;)">
											<div class="info d-flex">
												<div><img src="../images/sub.png" alt=""></div>
												<div><h5>'.$fn.' '.$ln.'</h5>
												<span>'.$dt.'</span></div>
											</div>
										</div>
									</div>
								';	
							}
						}
					}
				?>
			</div>
		</form>
	</section>
<?php 
	}else if(isset($_POST['roomsearch'])){
		$searchstudent=$_POST['roomsearch'];
		$show='hidden';
?>

	<section class="courses">
		<h1 class="heading">Results..</h1>
		
		<form method="POST">
			<div class="box-container">
				<?php
					include_once'../class/classdisplay.php';
					$d=new Display();
				
					$getstudentinfo=$u->searchstudentname($searchstudent);
					if($tbl = $getstudentinfo->fetch_assoc()){
						$student_id=$tbl['userid'];
						$fn=$tbl['firstname'];
						$mn=$tbl['middlename'];
						$ln=$tbl['lastname'];
					}
					$data=$d->searchstudent($student_id);
					while($row = $data->fetch_assoc()){
						if($row['userid']!=$userid){
							$date=$row['datecreated'];
							$dt=date('M d, Y',strtotime($date));
							if($row['image']==''){
								$img='def5.jpg';
							}else{
								$img=$row['image'];
							}
							
							$checkdashboard = $u->checkdashboard($userid, $row['roomid']);
							if($checkdashboard->num_rows > 0){
								$outputbutton='<i class="fas fa-check"></i>';
								$outputbutton2='disabled title="Already added to subscriptions page"';
							}else{
								$outputbutton='<i class="fas fa-plus"></i>';
								$outputbutton2='title="Add to subscriptions page"';
							}
							
							$getstudentinfo=$u->getstudentname($row['userid']);
							if($tbl = $getstudentinfo->fetch_assoc()){
								$student_id=$tbl['userid'];
								$fn=$tbl['firstname'];
								$mn=$tbl['middlename'];
								$ln=$tbl['lastname'];
									
								echo'
									<div class="box" >
										<div class="d-flex justify-content-between">
											<div><h2 class="title">'.$row['roomname'].'</h2></div>
											<div><button type="button" onclick="addtoboard(&quot;'.$row['roomid'].'&quot;)" class="form-control text-white addbtn" data-toggle="tooltip" data-placement="bottom" '.$outputbutton2.'>'.$outputbutton.'</button></div>
										</div>
										<div class="thumb">
											<img src="../images/'.$img.'"  alt="" onclick="viewroom(&quot;'.$row['userid'].'&quot;,&quot;'.$row['roomid'].'&quot;)">
										</div>
										<div class="tutor mt-2" onclick="openprofile(&quot;'.$row['userid'].'&quot;)">
											<img src="../images/sub.png" alt="">
											<div class="info mt-2">
												<h5>'.$fn.' '.$ln.'</h5>
												<span>'.$dt.'</span>
											</div>
										</div>
									</div>
								';	
							}
						}
					}
				?>
			</div>
		</form>
	</section>
<?php }?>

<script>
	function openprofile(userid){
		window.open("studentprofile.php?userid="+userid,"_self");
	}
	function viewroom(userid,roomid){
		window.open("roomdetails.php?userid="+userid+"&&roomid="+roomid,"_self");
	}
	function addtoboard(roomid){
		//alert(roomid);
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				//alert (this.responseText);
				document.getElementById("addedtoboard").innerHTML=this.responseText;
            }
        };
        xhttp.open("GET", "../ajax/ajaxaddtodashboard.php?userid="+"<?=$userid?>"+"&&roomid="+roomid, true);
        xhttp.send();
	}
</script>
