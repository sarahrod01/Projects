<?php
	session_start();
	$userid=$_SESSION['uname'];

	include_once'../class/class.php';
	$u=new User();
	
	$n=5;
	$characters = '0123456789';
	$commentid = '';
 
	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$commentid .= $characters[$index];
	}

	$data = $u->displaycontentwithid($_GET['id']);
	if($row = $data->fetch_assoc()){
		$id2 = $row['id'];
		$sid2 = $row['userid'];
		$contentid2 = $row['contentid'];
		$roomid2 = $row['roomid'];
		$contenttitle2 = $row['contenttitle'];
		$contentdetails2 = $row['contentdetails'];
		$file2 = $row['file'];
		$status2 = $row['status'];
		$contentstatus2 = $row['contentstatus'];
		$date=$row['dateuploaded'];
		$dt2=date('M d, Y',strtotime($date));

	}

	$data=$u->displayroomdetails($roomid2);
	if($row=$data->fetch_assoc()){
		$date=$row['datecreated'];
		$dt=date('M d, Y',strtotime($date));
		$roomname=$row['roomname'];
		$roomdetails=$row['roomdetails'];
	}

	if(isset($_POST['btncompleted'])){
		$u->updatecontentstatus($contentid2);
	}
	$u->updatenotifstatus($contentid2);

?>
<html lang="en">
	<head>
		<title>WATCH</title>
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
		
		<?php
			include_once '../class/classbadwords.php';
			$b = new words();
			$scrollToDiv="";
			if(isset($_POST['btncomment'])){
				$comment = $_POST['comment'];
				$explodecomment = explode(' ', $comment);
				$w = '';
				$file="";
				
				foreach ($explodecomment as $word) {
					$explodedText = explode('0', $word);
					foreach ($explodedText as $text) {
						$res = str_replace( array( '\'', '"',',' , ';', '<', '>', '.', '*', '-', '+', '#', '@', '&', '(', ')', '/'), '', $text);
						$w .= "'" . $res . "',";
					}
				}

				$w = rtrim($w, ',');
				
				$data = $b->listwords($w);
				
				if ($row = $data->fetch_assoc()) {
					$inappropriateMessage = "Sorry, your comment is inappropriate.";
				} else {
					include_once'CommentFile.php';
					$scrollToDiv='comment';
				}
			}
		?>
		<?php
			if (isset($successMessage)) {
				echo '<h3><div class="alert alert-info text-center text-success mt-3" id="removeMessage">'.$successMessage.'</div><h3>';
			}
		?>
		<section class="watch-video">
			<div class="video-container">
				<?php 
					$changefilestatus=explode(",",$status2);
					$contents=explode(",",$file2);
					for($c=0; $c<count($contents); $c++){
						$filepathinfo=pathinfo($contents[$c]);
						$filepathextension=$filepathinfo['extension'];
						if($changefilestatus[$c] == 'approved'){
							if($filepathextension=='mp4' || $filepathextension=='mkv'){
					
				?>
				<div class="video">
							<?php
								if($changefilestatus[0] == 'approved'){
									echo'
										<video src="../images/'.$contents[0].'" controls id="myVideo"></video>
										<div class="row mt-2">
											<div class="col-md-12">
												<div class="card">
													<div class="card-body">
													<h4>Materials</h4>
									';
								}
								for($c=1; $c<count($contents); $c++){
									$pathinfo=pathinfo($contents[$c]);
									$fileextension=$pathinfo['extension'];
									if($changefilestatus[$c] == 'approved'){
										if($fileextension=='pdf'){
											$icon='text-danger fas fa-file-pdf';
										}else if($fileextension=='docx' || $fileextension=='doc'){
											$icon=' fas fa-file-word';
											
										}else if($fileextension=='ppt' || $fileextension=='pptx'){
											$icon='text-danger fas fa-file-powerpoint';
											
										}else if($fileextension=='xlsx' || $fileextension=='xlsx'){
											$icon='text-success fas fa-file-excel';
											
										}else{
											$icon='fas fa-file';
											
										}
										
										echo'
											<a style="font-size: 16px;" href="#" onclick="openfile(&quot;'.$contents[$c].'&quot;)"><i class="'.$icon.' mr-2" style="font-size: 15px;"></i> '.$contents[$c].'</a><br>		
										';
									}
									
								}
							?>
								</div>
							</div>
						</div>
					</div> 
				</div>
				<?php }else{?>
				<div class="video">
					<?php
						for($c=0; $c<count($contents); $c++){
							$pathinfo=pathinfo($contents[$c]);
							$fileextension=$pathinfo['extension'];
							if($changefilestatus[$c] == 'approved'){
								if($fileextension=='pdf'){
									$icon='text-danger fas fa-file-pdf';
								}else if($fileextension=='docx' || $fileextension=='doc'){
									$icon=' fas fa-file-word';
									
								}else if($fileextension=='ppt' || $fileextension=='pptx'){
									$icon='text-danger fas fa-file-powerpoint';
									
								}else if($fileextension=='xlsx' || $fileextension=='xlsx'){
									$icon='text-success fas fa-file-excel';
									
								}else{
									$icon='fas fa-file';
									
								}
								
								echo'
									<a style="font-size: 16px;" href="#" onclick="openfile(&quot;'.$contents[$c].'&quot;)"><i class="'.$icon.' mr-2" style="font-size: 15px;"></i> '.$contents[$c].'</a><br>		
								';
							}
							
						}
					?>
				</div>
				<?php }}}?>
				<div class="d-flex justify-content-between">
					<div>
						<h3 class="title"><?=$contenttitle2?></h3>
					</div>
					<?php
						$getstudentinfo=$u->getstudentname($sid2);
						if($tbl = $getstudentinfo->fetch_assoc()){
							$student_id=$tbl['userid'];
							$fn=$tbl['firstname'];
							$mn=$tbl['middlename'];
							$ln=$tbl['lastname'];
						}
					
					?>
					<?php if($userid == $_GET['userid']){?>
					<div>
						<button class="form-control btn-primary btn-lg" onclick="openmaterial()">Add Material</button>
					</div>
					<?php }?>
				</div>
				
				<div id="displaymaterial"></div>
				<div class="info">
					<p class="date"><i class="fas fa-calendar"></i><span><?=$dt2?></span></p>
				</div>
				<?php
					$getstudentinfo=$u->getstudentname($sid2);
					if($tbl = $getstudentinfo->fetch_assoc()){
						$student_id=$tbl['userid'];
						$fn=$tbl['firstname'];
						$mn=$tbl['middlename'];
						$ln=$tbl['lastname'];
					}
				
				?>
				<div class="tutor">
					<img src="../images/sub.png" alt="">
					<div class="col-md-11">
						<div class="row justify-content-between">
							<div><h4><?=$fn.' '.$ln?></h4></div>
						</div>
						<div class="row justify-content-between">
							<span class="mr-5">creator</span>
						</div>
					</div>
				</div>
				<p class="description">
					<?=$contentdetails2?>
				</p>
			</div>
		</section>
		<section class="comments">
			<h1 class="heading">Add Comment</h1>
			<form action="" method="POST"  enctype="multipart/form-data">
				<div class="card p-3" id="comment">
					<div class="card-body ">
						<div class="col-md-12" style="margin-left: -20px">
							<textarea type="text" name="comment" placeholder="enter your comment" required class="form-control txt"></textarea>
						<?php if (isset($inappropriateMessage)) : ?>
							<p style="color: red; font-size: 14px; margin-top: 10px;"><?= $inappropriateMessage ?></p>
						<?php endif; ?>
						<div class="row mt-2">
							<div class="col-md-4 ">
								<input type="file" name="fileToUpload" style="font-size: 10px;" >
							</div>
						</div>
						<input type="submit" value="comment" class="inline-btn" name="btncomment">
						</div>
					</div>	
				</div>	
			</form>
			<h1 class="heading mt-5"><?=$u->countcomment($contentid2)?> comments</h1>
			<div class="box-container">
				
				<?php

					include_once'../class/classdisplay.php';
					$d=new Display();
					$n=5;
					$characters = '0123456789';
					$replyid = '';

					for ($i = 0; $i < $n; $i++) {
						$index = rand(0, strlen($characters) - 1);
						$replyid .= $characters[$index];
					}
					if(isset($_POST['btnreply'])){
						$reply=$_POST['reply'];
						$cmtid=$_POST['cmtid'];
						$cntid=$_POST['cntid'];
						
						echo'
							<script>
								alert("'.$d->savereply($userid,$cntid,$cmtid,$replyid,$reply).'");
							</script>
						';
					}

					$id="";
					$data=$u->displaycomments($contentid2);
					while($row = $data->fetch_assoc()){
						$date=$row['datecommented'];
						$dt=date('M d, Y',strtotime($date));
						
						$getstudentinfo=$u->getstudentname($row['userid']);
						if($tbl = $getstudentinfo->fetch_assoc()){
							$student_id=$tbl['userid'];
							$fn=$tbl['firstname'];
							$mn=$tbl['middlename'];
							$ln=$tbl['lastname'];
						}
						
						$hide='hidden';
						include_once'../class/classdisplay.php';
						$d=new Display();
						if($d->Checkcomment($row['commentid']) > 0){
							$hide='';
						}
						$id=$id."".$row['id'].",";
						echo'
							<div class="box">
								<div class="user" ">
									<img src="../images/sub.png" alt="" style="margin-top: -30px;">
									<div>
										<h5>'.$fn.' '.$ln.'</h5>
										<div><h4>'.$row['comment'].'</h4></div>
										<div class="text-primary"><h5><a href="../images/'.$row['uploadedfile'].'" target="new" width="80px">'.$row['uploadedfile'].'</a></h5></div>
										<span><h6>'.$dt.'</h6></span>
									</div>
								</div>
								<div class="d-flex commentres" >

									<div><h5><input class="bg-white" type="button" onclick="closereply(&quot;'.$row['commentid'].'&quot;,&quot;'.$row['contentid'].'&quot;,&quot;'.$row['id'].'&quot;)" value="Reply"></h5></div>
									<div style="margin-left: 15px;"><h5><input class="bg-white" type="button" onclick="viewreply(&quot;'.$row['commentid'].'&quot;,&quot;'.$row['id'].'&quot;)" value="View Reply" '.$hide.'></h5></div>
								</div>
								<div id="ViewReplies'.$row['id'].'"></div>
								<div id="display'.$row['id'].'"></div>
								<div id="Replies'.$row['id'].'"></div>
							</div>
						';
						
					}
					$id=rtrim($id,',');
				?>

			</div>
		</section>
	</body>
</html>

<script>
    var video = document.getElementById('myVideo');
    video.addEventListener('ended', function() {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '../ajax/ajaxcheckvideo.php?video_finished=true&&contentid='+"<?=$contentid2?>"+"&&id="+"<?=$id2?>"+"&&roomid="+"<?=$roomid2?>"+"&&userid="+"<?=$userid?>", true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			console.log(xhr.responseText);
			//alert(xhr.responseText);
			
			window.open("viewcontent.php?id="+xhr.responseText+"&&userid="+"<?=$userid?>","_self");
        }
      };
      xhr.send();
    });
	var isOpen = false;
	function replycomment(commentid,contentid,cid) {
		var uid="<?=$userid?>";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				var ReplyElement = document.getElementById("Replies"+cid);
				var reply = this.responseText;
				var replyLength = reply.trim().length;

				if (isOpen) {
					ReplyElement.innerHTML = "";
					isOpen = false;
				} else{
					ReplyElement.innerHTML = reply;
					isOpen = true;
				}
            }
        };
        xhttp.open("GET", "../ajax/ajaxreplies.php?commentid=" + commentid + "&&contentid=" +contentid+"&&userid="+uid+"&&id="+cid, true);
        xhttp.send();
    }
	function viewreply(commentid,cid) {
        var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var viewRepliesElement = document.getElementById("ViewReplies"+cid);
				var content = this.responseText;
				var contentLength = content.trim().length;

				if (isOpen) {
					viewRepliesElement.innerHTML = "";
					isOpen = false;
				} else{
					viewRepliesElement.innerHTML = content;
					isOpen = true;
				}
			}
		};
        xhttp.open("GET", "../ajax/ajaxviewreplies.php?commentid="+commentid, true);
        xhttp.send();
    }
	function closeAlert(){
		document.getElementById("removeMessage").style.display="none";
	}
	setTimeout(closeAlert,2000);
	function myreply(id,uid,contentid,commentid){
		var reply=document.getElementById("reply").value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("display"+id).innerHTML = this.responseText;
				document.getElementById("reply").value="";
				//alert (this.responseText);
				
            }
        };
        xhttp.open("GET", "../ajax/ajaxaddreply.php?userid="+uid+"&&contentid="+contentid+"&&commentid="+commentid+"&&reply="+reply, true);
        xhttp.send();
	}
	function closereply(commentid,contentid,cid){
		var allid="<?=$id?>";
		var splitid=allid.split(",");
		for (var i = 0; i < splitid.length; i++) {
			//if (id != splitid[i]) {
				document.getElementById("Replies"+splitid[i]).innerHTML="";
			//}
		}
		replycomment(commentid,contentid,cid);
	}
	document.addEventListener('DOMContentLoaded', function(){
		var scrollToDiv="<?=$scrollToDiv?>";
		if(scrollToDiv){
			var targetDiv=document.getElementById(scrollToDiv);
			if(targetDiv){
				targetDiv.scrollIntoView();
			}
		}
	});
	
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
	function openmaterial(){
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("displaymaterial").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "../ajax/ajaxopenmaterial.php", true);
        xhttp.send();
	}
	function savematerial(){
		var fileInput=document.getElementById("fileToUpload");
		var files=fileInput.files;
		
		for(i=0; i<files.length; i++){
			var fileToUpload = fileInput.files[i];
			var formData = new FormData();
			formData.append('fileToUpload',fileToUpload);
			
			var xhttp = new XMLHttpRequest();
			xhttp.open("POST", "../ajax/ajaxsavematerial.php?id="+"<?=$_GET['id']?>");
			xhttp.onload = function(){
				if(xhttp.status==200){
					window.open("viewcontent.php?id="+"<?=$_GET['id']?>"+"&&userid="+"<?=$_GET['userid']?>","_self");
				}
			};
			xhttp.send(formData);
		}
	}
	function openfile(filename){
		//alert(filename);
		window.open("pdffile.php?filename="+filename,"_new");
	}
	function editcontent(id,contentid,contenttitle,contentdetails){
		document.getElementById("cid").value=id;
		document.getElementById("contentid2").value=contentid;
		document.getElementById("contentname2").value=contenttitle;
		document.getElementById("contentdetails2").value=contentdetails;
	}
</script>

<style>
	.txtb{height: 40px;}
	.txt { font-size: 15px; } 
	.table-responsive{-md}
	.textarea {
		width: 100%;
		padding: 10px;
		margin-top: 10px;
		resize: vertical;
	}
	
		
	.txtb{height: 40px;}
	.txt { font-size: 15px; } 
	.table-responsive{-md}

	.commentres {
    margin-top: -25px;
    margin-left: 65px;
    max-width: 100%;
    overflow-x: auto;
}

/* Media query for mobile view */
@media only screen and (max-width: 768px) {
    .commentres {
        margin-top: -20px;
        margin-left: 50px;
        overflow-x: hidden; /* Hide horizontal overflow on smaller screens */
    }
}

</style>
