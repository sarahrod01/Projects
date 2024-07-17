<?php
	session_start();
	$userid=$_SESSION['userid'];

	include_once'../class/classuser.php';
	$c=new Cuser();
	include_once'../class/classdisplay.php';
	$d=new display();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>HOME</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../design/design.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
	
	<?php
		include_once'../class/classuser.php';
		$u=new Cuser();
		if(isset($_POST['btnupdateinfo'])){
		$userid=$_POST['userid'];
		$fname=$_POST['fname'];
		$mname=$_POST['mname'];
		$lname=$_POST['lname'];
		$email=$_POST['email'];
		$contact=$_POST['contact'];
		$address=$_POST['address'];
		$course=$_POST['course'];
		echo'
			<script>
				alert("'.$u->updatemoderator($lname,$fname,$mname,$email,$contact,$address,$course,$userid).'")
			</script>
		';
		
		}
	?>
	<body>
	
	<?php include_once '../design/design3.php'; ?>  
    <?php include_once '../design/design2.php'; ?>  

	<header class="header">
		<section class="flex">
			<div class="d-flex">
				<div ><img src="../../img/eturo.jpg" class="rounded-pill" width="60px" height="60px"></a></div>
				<a href="home.php" class="logo mt-3">E-TURO</a>
				<!--div class="hidename mt-2"><button class="logo mt-2 bg-white " type="button"  onclick="home()"> E-TURO</button></div-->
			</div>
			<div class="icons">
				<div  onclick="logout()" class="fas fa-solid fa-right-from-bracket"></div>
			</div>

			<div class="profile">
				<img src="../images/pic-1.jpg" class="image" alt="">
				<h3 class="name"><?=$c->getName($userid)?></h3>
				<p class="role">admin</p>
			</div>
		</section>
	</header> 
	<div class="container">
				<div class="d-flex justify-content-between heading">
				<div>
					<h1 class=" mt-5">HI, <?= $_SESSION['nm'] ?>! </h1>
				</div>
				<div class="col-sm-3 col-8">
					<a href="#" class="inline-btn" style="margin-top:20px; margin-left:60px" data-toggle="modal" data-target="#addmoderator">Add Moderator</a>
				</div>
			</div>

				<?php include_once'addmoderator.php'?>
			
				<div class="row mt-2 justify-content-center">
					<div class="col-md-12 allign-center">
					
						<table class="table table-bordered table-hover table-light" >
						  <thead class="thead-dark">
							<tr>
							  <th scope="col" class="text-primary"><h3>Id Number</h3></th>
							  <th scope="col" class="text-primary"><h3>Name</h3></th>
							  <th scope="col" class="text-primary"><h3>Contact</h3></th>
							  <th scope="col" class="text-primary"><h3>Address</h3></th>
							  <th scope="col" class="text-primary"><h3>Status</h3></th>
							</tr>
						  </thead>
						  <tbody>
							
							<?php
								include_once'../class/classuser.php';
								$u=new Cuser();
								$data=$u->displaymoderators();
								while($row=$data->fetch_assoc()){
									$name= $row['firstname'].' '.$row['lastname'];
									
									if($u->getStatus($row['userid'])=='active'){
										$chk='checked';
										}else{
										$chk='';
										}
								echo'
								<tr id="display">
								  <td  data-toggle="modal" href="#" data-target="#editinfo" onclick="editinfo(&quot;'.$row['userid'].'&quot;,&quot;'.$row['lastname'].'&quot;,&quot;'.$row['firstname'].'&quot;,&quot;'.$row['middlename'].'&quot;,&quot;'.$row['email'].'&quot;,&quot;'.$row['address'].'&quot;,&quot;'.$row['contact'].'&quot;,&quot;'.$row['coursename'].'&quot;)"><h4>'.$row['userid'].'</h4></td>
								  <td><h4>'.$name.'</h4></td>
								  <td><h4>'.$row['contact'].'</h4></td>
								  <td><h4>'.$row['address'].'</h4></td>
								  <td class="text-center negative-right-margin"><h3><input class="form-check-input negative-right-margin"  onclick="updateStatus(this,&quot;'.$row['userid'].'&quot;)" '.$chk.' type="checkbox" value="'.$row['userid'].'" class="mt-2 ms-4"></h3>
								  </td>
								</tr>
								';
							}
							?>
							
							
						</tbody>
					</table>
				
				
					<div class="row  mt-5">
						<div class="col-md-12">			
						<h1 class="mt-5">Content Moderation</h1>
						<hr>
							<div class="row mt-4" >
								<div class="col-md-4">
									<div class="row mt-4 ">
										<div class="col-md-12">
											<input type="search" placeholder="Search Course..." oninput="searchcourse(this.value)" class="form-control" style="font-size: 18px;">
										</div>
									</div>
									<div class="card bg-light mt-5 overflow-auto" style="height: 400px;" >    
										<div class="card-body" > 
										<h3 class="heading" >Student Courses <span class="badge bg-danger text-white rounded-pill"><?=$d->countcourses()?></span></h3>
											<table class="table table-bordered" >
												<thead class="thead-dark">
													<tr>
														<th scope="col" ><h4>List of Courses</h4></th>
														<th scope="col" class="text-center"><h4>Action</h4></th>
													</tr>
												</thead>
												<tbody id="displaycourses">
													
														<?php
														
														$data=$d->displaystudentcourses();
														
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
															<tr >
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
														
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-md-8">
									<div class="row mt-4 justify-content-end">
										<div class="col-md-4">
											<select class="form-control" id="contentHistory" style="font-size: 18px;">
												<option class="text-center" value="approved">APPROVED</option>
												<option class="text-center" value="declined">DECLINED</option>
											</select>
										</div>
									</div>
									<?php
										 include_once '../class/classdisplay.php';
										 $d = new display();
									?>
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="card bg-light mt-5 overflow-auto" style="height: 400px;">    
												<div class="card-body">  
														<h3 class="heading" id="tableTitle">Approved Contents <span class="badge bg-danger text-white rounded-pill"><?=$d->countapproved()?></span></h3>
													<table class="table table-bordered">
														<thead class="thead-dark">
															<tr>
																<th scope="col"><h4>Name</h4></th>
																<th scope="col"><h4>Action</h4></th>
															</tr>
														</thead>
														<tbody id="contentTable">
															<?php 
															   $data = $d->PendingContents('approved');
																while ($row = $data->fetch_assoc()) {
																	echo '
																		<tr>
																			<th scope="row">
																				<div class="d-flex">
																					<div><img src="../images/sub.png" width="50px"></div>
																					<div style="margin-left: 10px;"><h4>'.$row['studentname'].' posted new content about "'.$row['contenttitle'].'"</h4> <h5>'.$row['coursename'].'</h5> <h6>'.$row['dateuploaded'].'</h6> </div>
																				</div>
																			</th>
																			<td class="text-center"><button type="button" onclick="updateContents(\''.$row['contentid'].'\', \''.$row['studentname'].'\')" class="rounded-circle shadow-none mt-4"><i class="fas fa-eye"></i></button></td>
																		</tr>
																	';
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		
	
		<form method="post">
			<!-- Modal -->
			<div class="modal fade p-4" id="editinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
				<div class="modal-content">
				  <div class="modal-header">
					<h1 class="modal-title" id="exampleModalLabel">Update Information</h1 >
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<div class="row">
						<div class="col-md-4">
						<h3>Userid</h3>
							<input readonly class="form-control txtb txt" name="userid" id="userid">
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
						<h3>Lastname</h3>
							<input type="text" class="form-control txtb txt	" name="lname" id="lname">
						</div>
						<div class="col-md-4">
						<h3>Firstname</h3>
							<input type="text" class="form-control txtb txt	" name="fname" id="fname">
						</div>
						<div class="col-md-4">
						<h3>Middlename</h3>
							<input type="text" class="form-control txtb txt	" name="mname" id="mname">
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-6">
						<h3>Email</h3>
							<input type="text" class="form-control txtb txt	" name="email" id="email">
						</div>
						<div class="col-md-6">
						<h3>Address</h3>
							<input type="text" class="form-control txtb txt	" name="address" id="address">
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-6">
							<h3>Contact</h3>
							<input type="text" class="form-control txtb txt	" name="contact" id="contact">
						</div>
						<div class="col-md-4">
							<h3>Course</h3>
							<select class="form-control tbox txt	"  name="course" name="course" id="course" maxlength="50" required class="box">
								<option>Select course...</option>
								<option value="Bachelor of Science in Computer Science">BSCS</option>
								<option value="Bachelor of Science in Office Administration">BSOA</option>
								<option value="Bachelor of Science in Entrepreneurship">BSEN</option>
								<option value="Bachelor of Science in Accounting Information System
								">BSAIS</option>
								<option value="Bachelor of Technical Teacher Education">BTTED</option>
							</select>
						</div>
					</div>
				  </div>
				  <div class="modal-footer">
						<div class="row mt-2 justify-content-center">
							<div class="col-md-6 ">
								<button type="submit" name="btnupdateinfo" class="btn btn-primary">UPDATE</button>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
							</div>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</form>
		<script src="../js/script.js"></script>
	</body>
</html>

<script>
	function updateStatus(ths,userid){
		var userid=ths.value;
		var stat=ths.checked;
		if(ths.checked==true){
			stat='active';
		}else{
			stat='blocked';
		}
		var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			alert (this.responseText);
			}
		  };
		  xhttp.open("GET", "../ajax/ajaxstatus.php?userid="+userid+"&&stat="+stat, true);
		  xhttp.send();
		
		
	}
	function editinfo(userid,lname,fname,mname,email,address,contact,course){
		document.getElementById("userid").value=userid;
		document.getElementById("lname").value=lname;
		document.getElementById("fname").value=fname;
		document.getElementById("mname").value=mname;
		document.getElementById("email").value=email;
		document.getElementById("address").value=address;
		document.getElementById("contact").value=contact;
		document.getElementById("course").value=course;
		
	}
	function searchmoderator(name) {
			
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if(name!=""){
					document.getElementById("display").innerHTML = this.responseText;
					
				}else{
					document.getElementById("display").innerHTML = "";
					
				}
				//alert(this.responseText)
			}
		};
		xhttp.open("GET", "../ajax/ajaxmoderator.php?name=" + name, true);
		xhttp.send();
		
	}
	function logout(){
		window.open("../../logout.php","_self");
	}
	document.getElementById('contentHistory').addEventListener('change', function() {
        let status = this.value;
        let userid = '<?= $userid ?>';
        if (status === 'pending') {
            location.reload(); // Reload the page to show pending contents
        } else {
            loadHistory(status);
        }
    });

    function updateContents(contentid, name) {
		var poststatus=document.getElementById("contentHistory").value;
        window.open("updatecontent.php?contentid=" + contentid + "&&name=" + name +"&&poststatus="+poststatus, "_self");
    }
	function ViewContent(contentid, name) {
        window.open("reviewcontent.php?contentid=" + contentid + "&&name=" + name, "_self");
    }

    function loadHistory(status) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("contentTable").innerHTML = this.responseText;
                document.getElementById("tableTitle").textContent = status.charAt(0).toUpperCase() + status.slice(1).toLowerCase() + ' Content';
            }
        };
        xhttp.open("GET", "../ajax/ajaxapprovedcontents.php?status=" + status, true);
        xhttp.send();
    }
	function coursescontent(courseid,name){
		window.open("moderatecontents.php?courseid="+courseid+"&&name="+name,"_new");
	}
	function searchcourse(course){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("displaycourses").innerHTML=this.responseText;
				//alert (this.responseText);
			}
		};
		xhttp.open("GET", "../ajax/ajaxsearchcourse.php?course="+course, true);
		xhttp.send();
	}
</script>
<style>
.negative-right-margin{
		margin-top:5px;
		margin-right:10px;
	}
	.negative-margin2{
		margin-left: 30px;
	}
	.negative-margin{
		margin-left: -30px;
	}
	
	.txtb{height: 40px;}
	.txt { font-size: 18px; } 
	.table-responsive{-md}
</style>
