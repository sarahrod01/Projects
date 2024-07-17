<?php
	include_once'../class/class.php';
	include_once'../class/classdisplay.php';
	$u=new User();
	$d=new Display();

?>

<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }
	.dropdown-toggle::after {
		display: none;
	}
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

<header class="header">
    <section class="flex">
		<div class="d-flex col-4" onclick="home()">
			<div style="margin-left: -20px;"><img src="../../img/eturo.jpg" class="rounded-pill" width="60px" height="60px"></div>
		</div>
		
		<!--form method="POST" class="search-form">
			<input type="text" oninput="searchstudent(this.value)" style="width: 300px;" required placeholder="Search" maxlength="100">
			<button class="fas fa-search" style="margin-left: 60px;"></button>
		</form-->
        <div class="icons" style="margin-left: 60px;">
            <div id="menu-btn" onclick="menubtn()"  class="fas fa-bars"></div>
            <div id="search-btn" onclick="searchbtn()" class="fas fa-search"></div>
        </div>
			
		<div class="btn-group mt-4 mg">
			<div class="dropdown-toggle mb-3 dropleft bell-icon"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><h1><i class="fas fa-bell " ></i></h1></div>
				<span><small><h4><span class="badge bg-danger mb-5 mb-5 text-white rounded-pill" id="unread" style="margin-top: -2px; margin-left:-5px">
				
				</span></h4></small></span>
				<div class="dropdown-menu dmenu fixcard overflow-auto" style="height: 500px;">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<h3 class="ml-3">Notifications</h3>
									<hr>
									<div class="row">
										<div class="col-3">
											<button type="button" class="mb-3 ml-2 rounded-pill form-control" onclick="viewallnotifications(&quot;<?=$userid?>&quot;)">All</button>
										</div>
										<div class="col-3">
											<button type="button" class="mb-3 rounded-pill form-control" onclick="viewunread(&quot;<?=$userid?>&quot;)" style="margin-left:-20px;">Unread</button>
										</div>
									</div>
									<div id="viewnotif">
									<?php
										$data=$d->displaynotif($userid);
									
										$unread=0;
										while($row=$data->fetch_assoc()){
											$date=$row['dt'];
											$dt=date('M d, Y',strtotime($date));
											$checkjoined=$d->checkjoined($userid,$row['rid']);
											if($row['tblname'] == 'tbllinks'){
												while($row2=$checkjoined->fetch_assoc()){
													if($row['notifstatus']=='unread'){
														$unread++;
														echo'
															<div class="card" style="background-color: #D8D8D8; " onclick="viewlink(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;,&quot;'.$row['rid'].'&quot;)">
																<div class="card-body">
																	<div>
																		<h5 hidden >id: '.$row['contentid'].'</h5>
																		<h5>'.$row['sname'].' posted new link in '.$row['rname'].'</h5>
																		<div>'.$dt.'</div>			
																	</div>
																</div>
															</div>
														';
													}else{
														echo'
															<div class="card" onclick="viewlink(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;,&quot;'.$row['rid'].'&quot;)">
																<div class="card-body">
																	<div>
																		<h5 hidden >id: '.$row['contentid'].'</h5>
																		<h5>'.$row['sname'].' posted new link in '.$row['rname'].'</h5>
																		<div>'.$dt.'</div>			
																	</div>
																</div>
															</div>
														';
													}
												}
											}else if($row['tblname'] == 'tblcontents'){
												$post='posted new content';
												while($row2=$checkjoined->fetch_assoc()){
													if($row['notifstatus']=='unread'){
														$unread++;
														echo'
															<div class="card" style="background-color: #D8D8D8; " onclick="viewcontent(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;)">
																<div class="card-body">
																	<div>
																		<h5 hidden >id: '.$row['contentid'].'</h5>
																		<h5>'.$row['sname'].' '.$post.' in '.$row['rname'].'</h5>
																		<div>'.$dt.'</div>			
																	</div>
																</div>
															</div>
														';
													}else{
														echo'
															<div class="card"  onclick="viewcontent(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;)">
																<div class="card-body">
																	<div>
																		<h5 hidden >id: '.$row['contentid'].'</h5>
																		<h5>'.$row['sname'].' '.$post.' in '.$row['rname'].'</h5>
																		<div>'.$dt.'</div>			
																	</div>
																</div>
															</div>
														';
													}
												}
											}else{
												$post='commented on your content';
													$getstudentinfo=$u->getstudentname($row['sname']);
													if($tbl = $getstudentinfo->fetch_assoc()){
														$student_id=$tbl['userid'];
														$fn=$tbl['firstname'];
														$mn=$tbl['middlename'];
														$ln=$tbl['lastname'];
														$course=$tbl['coursename'];
														
														$name=$fn.' '.$ln;
													}
													if($row['notifstatus']=='unread'){
														$unread++;
														echo'
															<div class="card" style="background-color: #D8D8D8; " onclick="viewcontent(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;)">
																<div class="card-body">
																	<div>
																		<h5 hidden >id: '.$row['contentid'].'</h5>
																		<h5>'.$name.' '.$post.' in '.$row['rname'].'</h5>
																		<div>'.$dt.'</div>			
																	</div>
																</div>
															</div>
														';
													}else{
														echo'
															<div class="card"  onclick="viewcontent(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;)">
																<div class="card-body">
																	<div>
																		<h5 hidden >id: '.$row['contentid'].'</h5>
																		<h5>'.$name.' '.$post.' in '.$row['rname'].'</h5>
																		<div>'.$dt.'</div>			
																	</div>
																</div>
															</div>
														';
													}
												
											}
											
											
											
										}
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		<h1><div onclick="logout()" class="fas fa-right-from-bracket ml-4 mt-2" ></div></h1>
    </section>
</header> 	
<div class="myrescss" id="display"></div>

<script>
	document.getElementById("unread").innerHTML="<?=$unread?>";
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
	function logout(){
		window.open("../../logout.php","_self");
	}
	function viewcontent(id,userid){
		window.open("viewcontent.php?id="+id+"&&userid="+userid,"_self");
	}
	function viewlink(id,userid,roomid){
		window.open("viewlinkcontents.php?id="+id+"&&userid="+userid+"&&roomid="+roomid,"_self");
	}
	
	document.querySelectorAll('.dropdown-menu').forEach(function (dropdown) {
		dropdown.addEventListener('click', function (event) {
			event.stopPropagation();
		}); 
	});
	
	function viewallnotifications(userid){
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				document.getElementById("viewnotif").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "../ajax/ajaxviewallnotif.php?userid="+userid, true);
        xhttp.send();
	}
	function viewunread(userid){
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				document.getElementById("viewnotif").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "../ajax/ajaxviewunreadnotif.php?userid="+userid, true);
        xhttp.send();
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
  .icons{
	  margin-left: 100px;
  }
  .hidename{
	  display:none;
  }
  .negative-margin{
	  margin-left: -30px;
  }
  .fixcard{
	  margin-right: 95px;
  }
}

/* Responsive styles for web view */
@media only screen and (min-width: 768px) {
  .myrescss{
    margin-left: 270px;
    margin-top: -20px;
    position: absolute;
    width: 1320px;
	font-size: 20px;
  }
  #menu-btn{
     display:none;
  }
  .mg{
	  margin-left: -200px;
  }
  .hd{
	  display:none;
  }
}
/* Default styles */
.bell-icon {
    margin-left: 270px; /* Default left margin */
	margin-top: 5px;
}

/* Media query for mobile devices */
@media (max-width: 767px) {
    .bell-icon {
        margin-left: 10px; /* Adjusted left margin for mobile devices */
    }
}
/* Default styles */
.dmenu {
    width: 350px; /* Default width */
    margin-left: -100px; /* Default left margin */
}

/* Media query for mobile devices */
@media (max-width: 767px) {
    .dmenu {
        width: 90vw; /* Adjusted width for mobile devices */
        margin-left: -45vw; /* Adjusted left margin for mobile devices */
    }
}


</style>