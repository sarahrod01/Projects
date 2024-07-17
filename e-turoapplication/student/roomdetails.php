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
		$studentname=$fn.' '.$ln;
	}
	
	$sid2 = $_GET['userid'];
	$roomid2 = $_GET['roomid'];

	$data=$u->displayroomdetails($_GET['roomid']);
	if($row=$data->fetch_assoc()){
		$date=$row['datecreated'];
		$dt=date('M d, Y',strtotime($date));
		$roomname=$row['roomname'];
		$roomdetails=$row['roomdetails'];
	}
	if(isset($_POST['btnjoin'])){
		$u->savetodashboard($userid,$_GET['roomid']);
		$joinsuccess=$u->joinroom($userid, $_GET['roomid']);
		$successJoining=$joinsuccess;
	}
	if(isset($_POST['btnleave'])){
		$leaveroom=$u->leaveroom($userid, $_GET['roomid']);
		header('location:home.php');
	}
?>
<html lang="en">
	<head>
		<title>VIDEO PLAYLIST</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../design/design.css">
		<link rel="stylesheet" href="../design/style.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
	<body>
	
		<?php include_once'../header/roomsidebar.php';?>  
		<?php include_once'../header/roomheader.php';?>  
		<?php include_once'../design/design2.php';?>  
		
		
		<?php
			include_once '../class/classbadwords.php';
			$b = new words();
			
			$n=5;
			$characters = '0123456789';
			$contentid = '';
		 
			for ($i = 0; $i < $n; $i++) {
				$index = rand(0, strlen($characters) - 1);
				$contentid .= $characters[$index];
			}
			
			if(isset($_POST['btnpost'])){
				$contentid=$contentid;
				$contentname=$_POST['contentname'];
				$contentdetails=$_POST['contentdetails'];
				$file="";
				
				// Explode $roomname and $roomdetails
				$explodename = explode(' ', $contentname);
				$explodedetails = explode(' ', $contentdetails);

				$w = '';

				foreach ($explodename as $word) {
					// Explode by '0' and concatenate to $w
					$explodedcname = explode('0', $word);
					foreach ($explodedcname as $text) {
						$res = str_replace( array( '\'', '"',',' , ';', '<', '>', '.', '*', '-', '+', '#', '@', '&', '(', ')', '/'), '', $text);
						$w .= "'" . $res . "',";
					}
				}

				foreach ($explodedetails as $word) {
					// Explode by '0' and concatenate to $w
					$explodedcdetails = explode('0', $word);
					foreach ($explodedcdetails as $text) {
						$res = str_replace( array( '\'', '"',',' , ';', '<', '>', '.', '*', '-', '+', '#', '@', '&', '(', ')', '/'), '', $text);
						$w .= "'" . $res . "',";
					}
				}

				// Remove the trailing comma
				$w = rtrim($w, ',');

				
				$data = $b->listwords($w);

				if ($row = $data->fetch_assoc()) {
					$errorMessage = '<em>"Sorry, it contains inappropriate words."</em>';
				} else {
					$result = include_once'uploadcontentfile.php';
					$successMessage = $result;
					include_once'testme.php';
				}
			}
			
			$image=$u->selectphoto($_GET['roomid']);
			if($image ==  ''){
				$image = 'def5.jpg';
			}else{
				//echo $image;
			}
		
			//echo $contentid;
		?>

		<section class="playlist-details">
			<h1 class="heading">COURSE DETAILS</h1>
			<?php
				if (isset($successJoining)) {
					echo '<h3><div class="alert alert-info text-center text-success" id="removeMessage">'.$successJoining.'</div><h3>';
				} 
			?>
			<?php
				if (isset($leaveroom)) {
					echo '<h3><div class="alert alert-info text-center text-danger" id="removeMessage">'.$leaveroom.'</div><h3>';
				} 
			?>
			<?php
				if (isset($successMessage)) {
					echo '<h3><div class="alert alert-info text-center text-success" id="removeMessage">Content Added Successfully!!</div><h3>';
				} elseif (isset($errorMessage)) {
					echo '';
				}
			?>
			<div class="row">
				<div class="column">
					<div class="thumb">
						<img src="../images/<?php echo $image; ?>"  alt="">
					</div>
				</div>
				<div class="column">
					<?php
						if($student_id != $userid){
					?>
						<div class="tutor">
							<img src="../images/sub.png" alt="">
							<div>
								<h4><?=$fn.' '.$ln?></h4>
								<span><?=$dt?></span>
							</div>
						</div>
					<?php }?>
					<form method="POST">
						<div class="details">
							<h1><?=$roomname?></h1>
							<p><?=$roomdetails?></p>
							<?php
								$data=$u->checkjoinedroom($userid, $_GET['roomid']);
								if($data->num_rows == 0){
									$checkcontent=$u->checkcontent($userid, $_GET['roomid']);
									if($checkcontent->num_rows == 0){
										echo'<button type="submit" class="inline-btn bg-secondary" name="btnjoin">Join Room</button>';
									}else{
										echo'
											<button type="button" class="inline-btn bg-secondary" data-toggle="modal" data-target="#postcontent">Add Content</button>
											<button type="button" class="inline-btn" onclick="conference()">Generate Conference Link</button>
										';
									}
								}else{
									echo'
										<button type="submit" class="inline-btn bg-danger" name="btnleave">Leave Room</button>
									';	
								}
							?>
						</div>
					</form>
				</div>
			</div>
			<div class="modal p-4" id="postcontent" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h1 class="modal-title">POST CONTENT</h1>
							<button type="button" class="close " data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true"><h1>&times;</h1></span>
							</button>
						</div>
						<div class="modal-body">
							<section class="contact">
								<div class="row" style="margin-top:-20px;">
								<form method="post" enctype="multipart/form-data">
									<h4 hidden>CONTENT ID</h4>
									<input type="text" name="contentid" value="<?=$contentid?>" required class="box" hidden>
									<h4>CONTENT TITLE</h4>
									<input type="text" placeholder="enter content name" name="contentname" required class="box">
									<h4>CONTENT DETAILS</h4>
									<textarea type="text" placeholder="enter content details" name="contentdetails" required class="box"></textarea>
									<h4>CONTENT FILE</h4>
									<input type="file" name="files[]" class="box" accept=".jpg,.jpeg,.png,.pptx,.pdf,.docx,.MP4,.mkv" multiple required>
									<?php
										if (isset($errorMessage)) {
											echo '<h3><p class="text-danger">' . $errorMessage . '</p><h3>';
										}
									?>
								</div>
							</section>
						</div>
						<div class="modal-footer">
							<button type="submit" name="btnpost" class="btn">ADD</button>
							<button type="button" class="btn" data-dismiss="modal">CLOSE</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<script src="../js/script.js"></script>
	</body>
	
	<script>
	  $(document).ready(function(){
		<?php
		  // Check if there is an error message, and if so, display the modal
		  if (isset($errorMessage)) {
			echo '$("#postcontent").modal("show");';
		  }
		?>
	  });
	</script>
	
</html>

<script>
	function conference(){
		window.open("../../videoconference/index.php","_new");
	}
	function back(){
		var back=history.go(-1);
		window.back;
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