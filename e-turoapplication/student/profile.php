<?php
	session_start();
	$userid=$_SESSION['uname'];
	
	include_once'../class/class.php';
	$u=new User();
	
	$getstudentinfo=$u->getstudentname($userid);
	if($tbl = $getstudentinfo->fetch_assoc()){
		$student_id=$tbl['userid'];
		$fn=$tbl['firstname'];
		$mn=$tbl['middlename'];
		$ln=$tbl['lastname'];
		$course=$tbl['coursename'];
	}
	
	$n=5;
	$characters = '0123456789';
	$roomid = '';
 
	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$roomid .= $characters[$index];
	}
	
	include_once'../class/classdisplay.php';
		$d=new Display();
		$data=$d->myrooms($userid);
		
		
	$n=5;
	$characters = '0123456789';
	$coverid = '';
 
	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$coverid .= $characters[$index];
	}
	
	if(isset($_POST['btnaddcover'])){
	$coverid=$_POST['coverid'];
	include_once'cover.php';
	}
	
	if(isset($_POST['btnupdatefeature'])){
	include_once'updatecover.php';
	}
			
?>

<html lang="en">
	<head>
		<title>PROFILE</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../design/design.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
	
	<body>
		<?php include_once'../header/studentheader.php';?>  
		<?php //include_once'../header/sidebar.php';?>  
		<?php include_once'../design/design3.php';?>  

		
		<?php
			include_once'../class/classdisplay.php';
			$d=new Display();
			if (isset($_POST['btnaddtoboard'])) {
			$roomid = $_POST['btnaddtoboard'];

			$data = $u->checkdashboard($userid, $roomid);

			$roomAlreadyAdded = false;
			while ($row = $data->fetch_assoc()) {
				if ($roomid == $row['roomid']) {
					$roomAlreadyAdded = true;
					break;
				}
			}

			if ($roomAlreadyAdded) {
				echo '<h3><div id="removeMessage" class="alert alert-info text-center text-success">Already added to dashboard!</div></h3>';
			} else {
				$message = $u->addtoDash($userid, $roomid);
				echo '<h3><div id="removeMessage" class="alert alert-info text-center text-success">' . $message . '</div></h3>';
			}
		}
	?>
		
		<?php include_once'SearchedResult.php';
			include_once'../class/class.php';
			$u=new User();
			$hide='';
			$datac=$u->selectcover($userid);
			if($row=$datac->fetch_assoc()){
				if($row['image']!=''){
					$hide='hidden';
					echo'
					<div class="row justify-content-center ">
						<div class="col-md-10 ">
							<div class="row">
								<div class="col-md-12 ">
									<img src="../images/'.$row['image'].'" class="rounded  adjustable-height" >
								</div>
							</div>
							<div class="row justify-content-end">
								<div class="col-md-2 ">
									<button type="button" class="form-control rounded coverPhotoBtn" data-toggle="modal" data-target="#editfeature"><h3 style="margin-top: -5px;"><i class="fas fa-camera"></i> Edit cover photo</h3></button>
								</div>
							</div>
						</div>
					</div>
				';
				}else{
					echo '';
				}
			}
			
		?>
			<form method="POST" enctype="multipart/form-data">
				<!-- Modal Add Featured-->
				<div class="modal fade" id="addfeature" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add cover photo...</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <input type="text" value="<?=$coverid?>" hidden name="coverid">
					  <div class="modal-body">
						<h4><input type="file"  name="fileToUpload"  maxlength="10" class="box"></h4>
					  </div>
					  <div class="modal-footer">
						<button type="submit" name="btnaddcover" class="btn btn-primary">Upload</button>
					  </div>
					</div>
				  </div>
				</div>
			</form>
				
			<form method="POST" enctype="multipart/form-data">	
				<!-- Modal Edit Featured -->
				<div class="modal fade" id="editfeature" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Edit cover photo...</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <input type="text" hidden name="coverid">
					  <div class="modal-body">
						<h4><input type="file"  name="fileToUpload"  maxlength="10" class="box"></h4>
					  </div>
					  <div class="modal-footer">
						<button type="submit" name="btnupdatefeature" class="btn btn-primary">Update</button>
					  </div>
					</div>
				  </div>
				</div>
			</form>
				
				<div class="row justify-content-center ">
					<div class="col-md-10 ">
						<div class="d-flex mt-3">
							<div class="tutor ">
								<img class="rounded-pill" width="100px" height="100px" src="../images/sub.png" alt="">
							</div>
							<div class="mt-4 ml-3">
								<h2><?=$fn.' '.$ln?></h2>
								<h3><?=$course?></h3>
								<h4>No. of Posted Contents: <span class="text-danger"><?=$u->count_studentroom($userid)?></span></h4>
								<button type="button" class="form-control rounded-pill" <?php echo $hide; ?> data-toggle="modal" data-target="#addfeature"><h4 ><i class="fas fa-plus"></i> Add feature</h4></button>
							</div>
						</div>
					</div>
				</div>
				
		
		<section class="courses" >
		<div class="d-flex justify-content-between">
			<div><h1>My Contents</h1></div>
		</div>

		<hr>
		<div class="box-container">
			
			<?php
				if($data->num_rows > 0){
					
					while($row = $data->fetch_assoc()){
						$date=$row['datecreated'];
						$dt=date('M d, Y',strtotime($date));
						
						if($row['image']==''){
							$img='def5.jpg';
						}else{
							$img=$row['image'];
						}
						
						
						echo'
							<div class="box" >
								<div class="d-flex justify-content-between">
									<div><h2 class="title">'.$row['roomname'].'</h2></div>
									<input type="text" name="roomid" hidden value="'.$roomid.'">
								</div>
								<div class="thumb">
									<img src="../images/'.$img.'"  alt="" onclick="viewroom(&quot;'.$userid.'&quot;,&quot;'.$row['roomid'].'&quot;)">
									<div class="mt-1">'.$dt.'</div>
								</div>
								
							</div>
						
						';
					}
				}else{
					echo '
						<div class="row mt-5 justify-content-center" id="webdesign">
							<div class="text-center">
								<img src="../images/subsc.jpg" style="width:100px; height:100px;" class="rounded-pill mt-5">
								<h4 class="mt-3">Your courses will be displayed here!</h4>
								<h5 class="mt-1">Upload and record more interesting videos,<br> Every course you make will appear here.</h5>
							</div>
						</div>
					';
				}
			?>
		</div>
	</section>
		<script src="../js/script.js"></script>
	</body>
</html>
<script>
	 function viewroom(userid, roomid) {
        window.open("roomdetails.php?userid=" + userid + "&&roomid=" + roomid, "_self");
    }
	function closeAlert(){
		document.getElementById("removeMessage").style.display="none";
	}
	setTimeout(closeAlert,2000);
	
	function userbtn(){
        let profile = document.querySelector('.header .flex .profile');

        document.querySelector('#user-btn').onclick = () =>{
            profile.classList.toggle('active');
            search.classList.remove('active');
        }
    }
    function menubtn(){
        let sideBar = document.querySelector('.side-bar');

        document.querySelector('#menu-btn').onclick = () =>{
            sideBar.classList.toggle('active');
            body.classList.toggle('active');
        }

        document.querySelector('#close-btn').onclick = () =>{
            sideBar.classList.remove('active');
            body.classList.remove('active');
        }
    }
    function searchbtn(){
        let search = document.querySelector('.header .flex .search-form');

        document.querySelector('#search-btn').onclick = () =>{
            search.classList.toggle('active');
            profile.classList.remove('active');
        }
    }
</script>
<style>
	.card{
		background-color: #f5e3fc;
	}
	.negative-margin2{
			margin-left: 20px;
		}
	.negative-margin{
			margin-left: -10px;
		}
	.txt { font-size: 15px; } 
	.txtstn { font-size: 30px; } 
	.adjustable-height {
		width: 100%;
		max-height: 250px; /* Default height for web view */
	}

	@media (max-width: 768px) {
    .adjustable-height {
        max-height: 120px; /* Height for mobile view */
    }
	
	/*Media query for mobile devices (up to 767px width) */
	@media only screen and (max-width: 767px) {
		#coverPhotoBtn {
			/* Add styles specific to mobile view */
			font-size: 5px; /* Adjust font size */
			padding:10px ; /* Adjust padding */
			width: 150px;
			margin-left: 210px;
			margin-top: -20px;
			
		}
	}

	
	@media only screen and (min-width: 768px) {
		#webdesign{
			width: 1000px;
		}
	}		
</style>

