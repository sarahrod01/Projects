<?php
	$getstudentinfo=$u->getstudentname($userid);
	if($tbl = $getstudentinfo->fetch_assoc()){
		$student_id=$tbl['userid'];
		$fn=$tbl['firstname'];
		$mn=$tbl['middlename'];
		$ln=$tbl['lastname'];
		$course=$tbl['coursename'];
	}
?>
	<style>
	  .icons {
		margin-left: 150px; /* Default margin for desktop view */
	  }

	  @media only screen and (max-width: 768px) {
		/* Adjust margin for screens smaller than 768px (typically mobile devices) */
		.icons {
		  margin-left: 50px; /* Adjust margin for smaller screens */
		}
	  }
	</style>



	<header class="header">
		<section class="flex">
		    <div class="d-flex col-4" onclick="home()">
				<div class="negative-margin"><img src="../../img/eturo.jpg" class="rounded-pill" width="60px" height="60px"></a></div>
				<div class="hidename mt-2"><button class="logo mt-2 bg-white " type="button"> E-TURO</button></div>
			</div>
			<form method="POST" class="search-form">
				<input type="text" oninput="searchstudent(this.value)" required placeholder="Search" maxlength="100">
				<button class="fas fa-search"></button>
			</form>

			<div class="icons" style="margin-left: 100px;">
				<div id="search-btn" onclick="searchbtn()" class="fas fa-search"></div>
			</div>

			<div class="dropdown dropleft ">
					<img src="../images/sub.png"  class=" dropdown-toggle rounded-pill " height="40px" width="40px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="">
					<div class="dropdown-menu drp mt-5" width="300px" aria-labelledby="dropdownMenuButton">
						<div class="d-flex dropdown-item">
							<div><img src="../images/sub.png"  class=" rounded-pill mr-2" height="50px" width="50px" type="button"></div>
							<div class=" mt-4"><h4><?=$fn.' '.$ln?></h4>
							<h5><a class="  mb-5 text-primary" href="profile.php"> View your Profile</a><h5></div>
						</div>
						<hr>
						<h3><a class="dropdown-item mt-4" href="home.php"><i class="fas fa-circle-check"></i> Subscriptions</a><h3>
						<h3><a class="dropdown-item mt-4" href="rooms.php"><i class="fa-solid fa-chalkboard-user"></i> Create Content</a><h3>
						<h3><a class="dropdown-item mt-4" href="../../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign-out</a><h3>
				  </div>
			</div>
		</section>
	</header> 
	<div class="myrescss" id="display" ></div>
				
			

	<script>
		function searchstudent(name) {
			
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(name!=""){
						document.getElementById("display").innerHTML = this.responseText;
						
					}else{
						document.getElementById("display").innerHTML = "";
						
					}
				}
			};
			xhttp.open("GET", "../ajax/ajaxsuggestion.php?name=" + name, true);
			xhttp.send();
			
		}
		function home(){
		window.open("../student/home.php","_self");
	}
	</script>

	<style>
	/* Responsive styles for mobile devices */
	@media only screen and (max-width: 767px) {
	  .myrescss {
		margin-left: -25px; /* Adjust as needed */
		margin-top: 35px; /* Adjust as needed */
		position: static; /* Change to static for mobile */
		width: auto; /* Adjust as needed */
		font-size: 15px;
		
	  }
	  /*header{
		margin-top:30px;
	  }*/
	  .hidename{
		display:none;
	  }
	  .negative-margin{
		  margin-left: -30px;
	  }
	  .fixcard{
		  margin-right: 95px;
	  }
	  .icons{
		  margin-left: 100px;
	  }
	}

	/* Responsive styles for web view */
	@media only screen and (min-width: 768px) {
	  .myrescss{
		margin-left: 190px;
		margin-top:-21px;
		position: absolute;
		width: 1320px;
		font-size: 20px;
	  }
	  
	}
	.drp{
		background: #e1dfe2;
	}
	</style> 