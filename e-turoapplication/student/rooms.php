<?php
    session_start();
    $userid = $_SESSION['uname'];
    

    include_once '../class/class.php';
    $u = new User();

	$n=5;
	$characters = '0123456789';
	$roomid = '';

	$rname='';
	$rdetails='';
	$crs='';
 
	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$roomid .= $characters[$index];
	}

	include_once '../class/classbadwords.php';
	$b = new words();

	if (isset($_POST['btnaddroom'])) {
		$roomname = $_POST['roomname'];
		$roomdetails = $_POST['roomdetails'];
		$course = $_POST['course'];
		$image = '';

		$getstudentinfo=$u->getstudentname($userid);
		if($tbl = $getstudentinfo->fetch_assoc()){
			$student_id=$tbl['userid'];
			$fn=$tbl['firstname'];
			$mn=$tbl['middlename'];
			$ln=$tbl['lastname'];
			
			$studentname=$fn.' '.$ln;
		}
		// Explode $roomname and $roomdetails
		$explodename = explode(' ', $roomname);
		$explodedetails = explode(' ', $roomdetails);

		$w = '';

		foreach ($explodename as $word) {
			// Explode by '0' and concatenate to $w
			$explodedrname = explode('0', $word);
			foreach ($explodedrname as $text) {
				$res = str_replace( array( '\'', '"',',' , ';', '<', '>', '.', '*', '-', '+', '#', '@', '&', '(', ')', '/'), '', $text);
				$w .= "'" . $res . "',";
			}
		}

		foreach ($explodedetails as $word) {
			// Explode by '0' and concatenate to $w
			$explodedrdetails = explode('0', $word);
			foreach ($explodedrdetails as $text) {
				$res = str_replace( array( '\'', '"',',' , ';', '<', '>', '.', '*', '-', '+', '#', '@', '&', '(', ')', '/'), '', $text);
				$w .= "'" . $res . "',";
			}
		}

		// Remove the trailing comma
		$w = rtrim($w, ',');

		// Check for inappropriate words
		$data = $b->listwords($w);

		if ($row = $data->fetch_assoc()) {
            $errorMessage = '<em>"Sorry, it contains inappropriate words."</em>';
        }else {
            $result = include_once'uploadimage.php';
            $successMessage = $result;
        }
	} 
	
	if (isset($_POST['btnsaveinfo'])) {
		$rid=$_POST['rid'];
		$rname = $_POST['rname'];
		$rdetails = $_POST['rdetails'];
		$crs = $_POST['crs2'];

		$getstudentinfo=$u->getstudentname($userid);
		if($tbl = $getstudentinfo->fetch_assoc()){
			$student_id=$tbl['userid'];
			$fn=$tbl['firstname'];
			$mn=$tbl['middlename'];
			$ln=$tbl['lastname'];
			
			$studentname=$fn.' '.$ln;
		}
		//$image = '';

		// Explode $roomname and $roomdetails
		$explodename = explode(' ', $rname);
		$explodedetails = explode(' ', $rdetails);

		$w = '';

		foreach ($explodename as $word) {
			// Explode by '0' and concatenate to $w
			$explodedrname = explode('0', $word);
			foreach ($explodedrname as $text) {
				$res = str_replace( array( '\'', '"',',' , ';', '<', '>', '.', '*', '-', '+', '#', '@', '&', '(', ')', '/'), '', $text);
				$w .= "'" . $res . "',";
			}
		}

		foreach ($explodedetails as $word) {
			// Explode by '0' and concatenate to $w
			$explodedrdetails = explode('0', $word);
			foreach ($explodedrdetails as $text) {
				$res = str_replace( array( '\'', '"',',' , ';', '<', '>', '.', '*', '-', '+', '#', '@', '&', '(', ')', '/'), '', $text);
				$w .= "'" . $res . "',";
			}
		}

		// Remove the trailing comma
		$w = rtrim($w, ',');

		// Check for inappropriate words
		$data = $b->listwords($w);

		if ($row = $data->fetch_assoc()) {
            $errorUpdate = '<em>"Sorry, it contains inappropriate words."</em>';
        }else {
            $result = include_once'roomimage.php';
            $successUpdate = $result;
        }
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CREATED CONTENTS</title>
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
  
<?php include_once '../header/sidebar.php';?>  
<?php include_once '../header/header.php';?>  
<?php include_once '../design/design2.php';?>  

<?php include_once 'SearchedResult.php';?>  

<section class="courses" id="roomdetails" <?=$show?>>
    <div class="d-flex heading justify-content-between"><div><h1>Created Courses</h1></div>
		<?php
			$datar=$d->myrooms($userid); 
			if($datar->num_rows>0){
				echo'
					<div class="col-md-3" style="margin-top: -7px;"><button type="button" class="btn" data-toggle="modal" data-target="#addroom">Add Courses</button></div>
				';
			}
		?>
	</div>
    <?php
		if (isset($successMessage)) {
			echo '<h3><div class="alert alert-info text-center text-success" id="removeMessage">Room Added Successfully!!</div><h3>';
		} elseif (isset($errorMessage)) {
			echo '';
		}
	?>
	<?php
		if (isset($successUpdate)) {
			echo '<h3><div class="alert alert-info text-center text-success" id="removeMessage">Room Updated Successfully!!</div><h3>';
		} elseif (isset($errorMessage)) {
			echo '';
		}
	?>
	<?php
		include_once'../class/classdisplay.php';
		$d=new display();
		
		if(isset($_POST['btndelete'])){
			$rid=$_POST['btndelete'];
			$del=$d->deleteroom($rid);
			$delsuccess=$del;
		}
	?>
	<?php
		if (isset($delsuccess)) {
			echo '<h3><div id="removeMessage" class="alert alert-info text-center text-success">'.$delsuccess.'</div><h3>';
		}
	?>
	
	<?php
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
	
		<div class="box-container">
				<?php
				include_once'../class/classdisplay.php';
				$d=new Display();
				
				if($datar->num_rows>0){
				while($row = $datar->fetch_assoc()){
					$date=$row['datecreated'];
					$dt=date('M d, Y',strtotime($date));
					$roomid=$row['roomid'];
					
					
					if($row['image']==''){
						$img='def5.jpg';
					}else{
						$img=$row['image'];
					}
					
					$getstudentinfo=$u->getstudentname($row['userid']);
					if($tbl = $getstudentinfo->fetch_assoc()){
						$student_id=$tbl['userid'];
						$fn=$tbl['firstname'];
						$mn=$tbl['middlename'];
						$ln=$tbl['lastname'];
						
						$studentname=$fn.' '.$ln;
					}
					if($userid == $student_id){
						$hidden='hidden';
					}
					
					echo'
					<form method="POST">
						<div class="box">
								<div class="d-flex justify-content-between">
									<div><h2 class="title">'.$row['roomname'].'</h2></div>
									<div class="dropdown">
										<i class="fa fa-ellipsis-h mt-1 txtstn" class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" aria-hidden="true"></i>
										<div class="dropdown-menu" style="margin-left: -50px;">
											<button type="button" onclick="editroom(&quot;'.$row['roomid'].'&quot;,&quot;'.$row['roomname'].'&quot;,&quot;'.$row['roomdetails'].'&quot;,&quot;'.$row['course'].'&quot;)" class="dropdown-item text-primary" data-toggle="modal" data-target="#exampleModal"><h4>Edit</h4></button>
											<button type="submit" name="btndelete" value="'.$roomid.'" class="dropdown-item text-danger"><h4>Delete</h4></button>
										</div>
									</div>
									<input type="text" name="roomid" hidden value="'.$roomid.'">
								</div>
								<div class="thumb">
									<img src="../images/'.$img.'"  alt="" onclick="viewroom(&quot;'.$userid.'&quot;,&quot;'.$row['roomid'].'&quot;)">
								</div>
								<div class="tutor mt-2" '.$hidden.' onclick="openprofile(&quot;'.$userid.'&quot;)">
									<img src="../images/sub.png" alt="" >
									<div class="info">
									<h5>'.$fn.' '.$ln.'</h5>
									<span>'.$dt.'</span>
									</div>
								</div>
							</div>
						</form>
						
					';
					}
				}else{
					echo '
					<div class="row mt-5 justify-content-center" style="width:1000px;">
						<div class="text-center">
							<img src="../images/subsc.jpg" style="width:100px; height:100px;" class="rounded-pill mt-5">
							<h4 class="mt-3">Add your first Course here!</h4>
							<h5 class="mt-1">Upload and record more interesting videos,<br> Every course you make will appear here.</h5>
							<div class="col-md-12 mt-1" style="margin-top: -7px;"><button type="button" class="btn" data-toggle="modal" data-target="#addroom"><i class="fas fa-add"></i> Add Course</button></div>
						</div>
					</div>
					';
				}
					
				?>
		</div>
</section>

<div class="modal p-4" id="exampleModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">Course Details</h1>
				<button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><h1>&times;</h1></span>
				</button>
			</div>
			<div class="modal-body">
				<section class="contact">
					<div class="row">
						<form method="post" enctype="multipart/form-data">
							<input type="text" hidden id="rid" name="rid">
							<h4>COURSE NAME</h4>
							<input type="text" id="rname" value="<?=$rname?>" name="rname" class="box">
							<h4>COURSE DETAILS</h4>
							<textarea type="text" id="rdetails" name="rdetails" class="box"><?=$rdetails?></textarea>
							<h4>PROGRAM/S</h4>
							<input type="text" name="crs" id="crs" class="form-control" hidden>
							<input type="text" name="crs2" id="crs2" class="form-control" hidden>
							<div class="row mt-3 ml-1" style="font-size: 15px;">
								<div class="d-flex">
									<input type="checkbox" id="selectedcourse1" onclick="editcourse()" value="BSCS" name="editcrs"><span >BSCS</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" id="selectedcourse2" onclick="editcourse()" value="BSOA" name="editcrs"><span >BSOA</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" id="selectedcourse3" onclick="editcourse()" value="BSEN" name="editcrs"><span >BSEN</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" id="selectedcourse4" onclick="editcourse()" value="BSAIS" name="editcrs"><span >BSAIS</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" id="selectedcourse5" onclick="editcourse()" value="BTTE" name="editcrs"><span >BTTE</span>
								</div>
							</div>
							<h4 class="mt-5">IMAGE</h4>
							<input type="file"  name="fileToUpload"  maxlength="50" class="box">
							<?php if (!empty($errorUpdate)) {echo '<div id="removeMessage" class="alert alert-danger txt mt-3">' . $errorUpdate . '</div>';} ?>
						<div class="modal-footer">
							<button type="submit" name="btnsaveinfo"  class="btn btn-primary">Save changes</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>	
					</div>
				</section>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="modal p-4" id="addroom" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">ADD COURSE</h1>
				<button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><h1>&times;</h1></span>
				</button>
			</div>
			<div class="modal-body">
				<section class="contact">
					<div class="row">
						<form method="post" enctype="multipart/form-data">
							<h4 hidden>COURSE ID</h4>
							<input type="text" placeholder="enter room id" name="roomid" value="<?=$roomid?>" required maxlength="50" class="box" hidden>
							<h4>COURSE NAME</h4>
							<input type="text" placeholder="enter room name" name="roomname" required maxlength="50" class="box">
							<h4>COURSE DETAILS</h4>
							<textarea type="text" placeholder="enter room details" name="roomdetails" class="box"></textarea>
							<h4>PROGRAM/S</h4>
							<input type="text" name="course" id="course" class="form-control" hidden>
							<div class="row mt-3 ml-1" style="font-size: 15px;">
								<div class="d-flex">
									<input type="checkbox" onclick="choosecourse()" value="BSCS" name="selectcourse"><span >BSCS</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" onclick="choosecourse()" value="BSOA" name="selectcourse"><span >BSOA</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" onclick="choosecourse()" value="BSEN" name="selectcourse"><span >BSEN</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" onclick="choosecourse()" value="BSAIS" name="selectcourse"><span >BSAIS</span>
								</div>
								<div class="d-flex">
									<input type="checkbox" onclick="choosecourse()" value="BTTE" name="selectcourse"><span >BTTE</span>
								</div>
							</div>
							<h4 class="mt-5">IMAGE</h4>
							<input type="file"  name="fileToUpload"  maxlength="50" class="box">
								<?php
								if (!empty($errorMessage)) {
									echo '<div class="alert alert-danger txt mt-2" id="removeMessage">' . $errorMessage . '</div>';
								}
							?>
						<div class="modal-footer">
						<button type="submit" name="btnaddroom" class="btn">ADD</button>
						<button type="button" class="btn" data-dismiss="modal">CLOSE</button>
					</div>	
					</div>
				</section>
			</div>
			
			</form>
		</div>
	</div>
</div>
</body>
</html>

<style>
.bgcard{
	background-color: #f5e3fc;
}
.txt { font-size: 15px; } 
.txtstn { font-size: 20px; } 
</style>

<script>
	//document.getElementById("roomdetails").style.display="<?=$show?>";
    function viewroom(userid, roomid) {
        window.open("roomdetails.php?userid=" + userid + "&&roomid=" + roomid, "_self");
    }
	function editroom(roomid,roomname,roomdetails,courses){
		document.getElementById("rname").value=roomname;
		document.getElementById("rid").value=roomid;
		document.getElementById("rdetails").value=roomdetails;
		document.getElementById("crs").value=courses;
		document.getElementById("crs2").value=courses;
		var splitcourses=courses.split(",");
		for (var i = 0; i < splitcourses.length; i++) {
			if(splitcourses[i] == "BSCS"){	
				document.getElementById("selectedcourse1").checked=true;
			}
			if(splitcourses[i] == "BSOA"){	
				document.getElementById("selectedcourse2").checked=true;
			}
			if(splitcourses[i] == "BSEN"){	
				document.getElementById("selectedcourse3").checked=true;
			}
			if(splitcourses[i] == "BTTE"){	
				document.getElementById("selectedcourse4").checked=true;
			}
			if(splitcourses[i] == "BSAIS"){	
				document.getElementById("selectedcourse5").checked=true;
			}
		}
		
		
	}
	function studentprofile(userid){
		window.open("studentprofile.php?userid="+userid,"_self");
	}
	function closeAlert(){
		document.getElementById("removeMessage").style.display="none";
	}
	setTimeout(closeAlert,2000);
	
	function choosecourse(){
		var choose=document.getElementsByName('selectcourse');
		var c=choose.length;
		var chosencourse='';
		for(var cnt=0;cnt<c;cnt++){
			if(choose[cnt].checked == true){
				chosencourse+=choose[cnt].value+',';
			}
		}
		document.getElementById('course').value=chosencourse.slice(0,-1);
	}
	function editcourse(){
		var choose=document.getElementsByName('editcrs');
		var c=choose.length;
		var editcourse='';
		for(var cnt=0;cnt<c;cnt++){
			if(choose[cnt].checked == true){
				editcourse+=choose[cnt].value+',';
			}
		}
		document.getElementById('crs2').value=editcourse.slice(0,-1);
	}
    
	function clearErrorMessage() {
        $("#errorMessage").text('');
    }

    $(document).ready(function () {
        <?php
        if (isset($errorMessage)) {
            echo '$("#addroom").modal("show");';
        }
        ?>
        
        $('#addroom').on('hidden.bs.modal', function () {
            clearErrorMessage();
        });
    });
	
		function clearErrorUpdate() {
        $("#errorUpdate").text('');
    }

    $(document).ready(function () {
        <?php
        if (isset($errorUpdate)) {
            echo '$("#exampleModal").modal("show");';
        }
        ?>
        
        $('#exampleModal').on('hidden.bs.modal', function () {
            clearErrorUpdate();
        });
    });
	function conference(){
		window.open("../../videoconference/index.php","_new");
	}

	document.getElementById("crs").value="<?=$crs?>";
	
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
	function openprofile(userid){
		window.open("studentprofile.php?userid="+userid,"_self");
	}
</script>
