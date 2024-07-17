<?php
    session_start();
    $userid = $_SESSION['userid'];
	
	include_once'../class/classdisplay.php';
	$d=new display();
?>

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

<body>
    <?php include_once '../design/design3.php'; ?>  
    <?php include_once '../design/design2.php'; ?>  
    <?php include_once '../header/moderatorheader.php'; ?>  
		
			<div class="row justify-content-center mt-4">
				<div class="col-md-10">			
					<h1 class="heading">HI, <?= $_SESSION['nm'] ?>! </h1>
							<div class="row mt-4" >
								<div class="col-md-4">
									<div class="row mt-4 ">
										<div class="col-md-12">
											<input type="search" placeholder="Search Course..." oninput="searchcourse(this.value)" class="form-control" style="font-size: 18px;">
										</div>
									</div>
									<div class="card bg-light mt-5 overflow-auto" style="height: 400px;">    
										<div class="card-body"> 
										<h3 class="heading" >Student Courses <span class="badge bg-danger text-white rounded-pill"><?=$d->countcourses()?></span></h3>
											<table class="table table-bordered ">
												<thead class="thead-dark ">
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
												<option class="text-center" value="pending">FOR APPROVAL</option>
												<option class="text-center" value="approved">APPROVED</option>
												<option class="text-center" value="declined">DECLINED</option>
											</select>
										</div>
									</div>
									<?php
										 include_once '../class/classdisplay.php';
										 $d = new display();
										 
										 $data1 = $d->getAllPending();
										 if($row1 = $data1->fetch_assoc()){
											 
										 }
															
									?>
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="card bg-light mt-5">    
												<div class="card-body overflow-auto" style="height: 400px;">  
														<h3 class="heading" id="tableTitle">For Approval <span class="badge bg-danger text-white rounded-pill"><?=$d->countpending()?></span></h3>
													<table class="table table-bordered">
														<thead class="thead-dark">
															<tr>
																<th scope="col"><h4>Name</h4></th>
																<th scope="col"><h4>Action</h4></th>
															</tr>
														</thead>
														<tbody id="contentTable">
															<?php 
															   $data = $d->PendingContents('pending');
															   if($data->num_rows==0){
																	echo'
																		<tr><td colspan=2 class="text-center text-dark">NO DATA  FOUND!</td></tr>
																	';
																}
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
	
</body>
</html>

<script>
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
