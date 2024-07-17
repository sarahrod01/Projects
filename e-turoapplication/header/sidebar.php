<?php
	include_once '../class/class.php';
	$u = new User();
	
	$getstudentinfo=$u->getstudentname($userid);
	if($tbl = $getstudentinfo->fetch_assoc()){
		$fn=$tbl['firstname'];
		$mn=$tbl['middlename'];
		$ln=$tbl['lastname'];
	}
	
	$url=$_SERVER['REQUEST_URI'];
	$filename=basename($url);
?>
<div class="side-bar">
	<div id="close-btn">
		<i class="fas fa-times"></i>
	</div>

	<div class="profile">
		<img src="../images/sub.png" class="image" alt="">
		<h3 class="name"><?=$fn.' '.$ln?></h3>
		<p class="role">Student</p>
	</div>
	<nav class="navbar">
		<div class="row">
			<div class="col-md-12 ">
				<button type="button" onclick="home()" class="mt-5 bg-white" id="navname1"><h2 
				><i class="fa-solid fa-circle-check"></i><span> Subscriptions</span><h2></button>
			</div>
			<div class="col-md-12 ">
				<button type="button" onclick="rooms()" class="mt-5 bg-white" id="navname2"><h2><i class="fa-solid fa-chalkboard-user"></i><span> Create Course</span></h2></button>
			</div>
			<div class="col-md-12 ">
				<button type="button" onclick="Prof()" class="mt-5 bg-white" id="navname3"><h2><i class="fas fa-user"></i><span> My Profile</span></h2></button>
			</div>
		</div>
	</nav>
</div>
<style>
	.activelink{
		color: blue;
	}
</style>
<script>
	setactive("<?=$filename?>");
	function setactive(filename){
		var page1=document.getElementById("navname1");
		var page2=document.getElementById("navname2");
		var page3=document.getElementById("navname3");
		if(filename=='home.php'){
			page1.className="mt-5 bg-white activelink";
		}else if(filename=='rooms.php'){
			page2.className="mt-5 bg-white activelink";
		}else if(filename=='profile.php'){
			page3.className="mt-5 bg-white activelink";
		}
	}
	function home() {
		window.open("../student/home.php", "_self");
	}

	function ccontent() {
		window.open("../student/rooms.php", "_self");
	}

	function rooms() {
		window.open("../student/rooms.php", "_self");
	}

	function Prof() {
		window.open("../student/profile.php", "_self");
	}
</script>


