<?php
	session_start();
	$userid=$_SESSION['uname'];

	$n=5;
	$characters = '0123456789';
	$roomid = '';
 
	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$roomid .= $characters[$index];
	}
	
	include_once'../class/class.php';
	$u=new User();

?>
<html lang="en">
	<head>
		<title>SUBSCRIPTIONS</title>
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
	
	<?php include_once'../header/sidebar.php';?>  
	<?php include_once'../header/header.php';?>  
	<?php include_once'../design/design2.php';?>  
	
	<div id="addedtoboard"></div>
	<?php include_once'SearchedResult.php'?>
	
	
	<section class="courses" id="roomdetails" <?=$show?>>
		<h1 class="heading">My Subscriptions</h1>
		<div class="box-container">
			
			<?php
				$data=$u->displayaddedrooms($userid);
				if($data->num_rows>0){
				while($row = $data->fetch_assoc()){
					$date=$row['datecreated'];
					$dt=date('M d, Y',strtotime($date));
					
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
					}
					
					$contents=$u->displaycontents($row['roomid']);
					$c=1;
					while($row2 = $contents->fetch_assoc()){
						$c++;
					}
					$countcompleted=$u->countcompleted($row['roomid']);
					$percent=($countcompleted/5)*100;
					$displaylinks=$u->displaylinks($row['roomid']);
					
					echo'
						<div class="box" >
							<h5 class="text-dark">Progress ('.$percent.'%)</h5>
							<div class="progress" style="height: 25px;">
								<div class="progress-bar fs-3"  role="progressbar" style="width: '.$percent.'%;" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100">'.$percent.'%</div>
							</div>
							<hr>
							<div class="d-flex justify-content-between">
								<div><h2 class="title">'.$row['roomname'].'</h2></div>
								<input type="text" name="roomid" hidden value="'.$roomid.'">
							</div>
							<div class="thumb">
								<img src="../images/'.$img.'"  alt="" onclick="viewroom(&quot;'.$row['userid'].'&quot;,&quot;'.$row['roomid'].'&quot;)">
							</div>
							<div class="tutor mt-4" onclick="openprofile(&quot;'.$row['userid'].'&quot;)">
								<img src="../images/sub.png" alt="">
								<div class="info">
								   <h5>'.$fn.' '.$ln.'</h5>
								   <span>'.$dt.'</span>
								</div>
							</div>
						</div>
					';
				}
				
				}else{
					echo '
					<div class="d-flex mt-5 justify-content-center" id="webdesign">
						<div class="text-center">
							<img src="../images/subsc.jpg" style="width:100px; height:100px;" class="rounded-pill mt-5">
							<h3 class="mt-3">No subscriptions yet!</h3>
							<h4 class="mt-1">Click "Search" to see the list of courses</h4>
						</div>
					</div>
					';
				}
			?>
		</div>
	</section>

	<!--script src="../js/script.js"></script-->
	</body>
</html>

<script>
	//document.getElementById("roomdetails").style.display="<?=$show?>";
	function showprofile(student_id, nm, course){
		window.open("../student/searchedstudent.php?student_id=" + student_id + "&&nm=" + nm + "&&course="+course, "_self");
	}
	function viewroom(userid,roomid){
		window.open("roomdetails.php?userid="+userid+"&&roomid="+roomid,"_self");
	}
	function openprofile(userid){
		window.open("studentprofile.php?userid="+userid,"_self");
	}
	function view(id,uid,cid,roomid,title,contentdetails,file,status,contentstatus,dt){
		window.open("viewlinkcontents.php?id="+id+"&&userid="+uid+"&&contentid="+cid+"&&roomid="+roomid+"&&contenttitle="+title+"&&contentdetails="+contentdetails+"&&file="+file+"&&status="+status+"&&contentstatus="+contentstatus+"&&dt="+dt,"_self");
	}
	function join(roomid){
		//alert(rid);
		window.open("../../videoconference/index.php?roomID="+roomid,"_new");
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
	function ContentList(){
		window.open("contentlist.php","_self")
	}
	
</script>

<style>
	@media only screen and (min-width: 768px) {
		#webdesign{
			width: 1000px;
		}
	}
</style>