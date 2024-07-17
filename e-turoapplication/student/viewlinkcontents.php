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

    $sid2 = $_GET['userid'];
	$roomid2 = $_GET['roomid'];
	
	$data = $u->displaylinkwithid($_GET['id']);
	$contentid2 = "";
	$linktitle2 = "";
	$linkdetails2 = "";
	$dt2= "";
	if($row = $data->fetch_assoc()){
		$id2 = $row['id'];
		$sid2 = $row['userid'];
		$contentid2 = $row['contentid'];
		$roomid2 = $row['roomid'];
		$linktitle2 = $row['linktitle'];
		$linkdetails2 = $row['linkdetails'];
		$date=$row['dateuploaded'];
		$dt2=date('M d, Y',strtotime($date));
	}

	$data=$u->displayroomdetails($_GET['roomid']);
	if($row=$data->fetch_assoc()){
		$date=$row['datecreated'];
		$dt=date('M d, Y',strtotime($date));
		$roomname=$row['roomname'];
		$roomdetails=$row['roomdetails'];
	}
	
	$n=5;
	$characters = '0123456789';
	$commentid = '';
 
	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$commentid .= $characters[$index];
	}

	$u->updatelinkstatus($contentid2);
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

		<?php include_once'../header/header.php';?>  
		<?php include_once'../header/roomsidebar.php';?>  
		
		<?php
			include_once '../class/classbadwords.php';
			$b = new words();
			if(isset($_POST['btncomment'])){
				$comment=$_POST['comment'];
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
					$u->addcomment($userid, $_GET['contentid'], $commentid, $comment, $file);
				}
			}
		?>
		<?php
			$text = strip_tags($linkdetails2);
			$contentdetails = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $text);	
		?>
		<?php
			if($contentid2 != ""){
				
		?>
		<section class="watch-video">
			<div class="video-container">
				<div class="video">
					<h1><?=$contentdetails?></h1>
				</div>
				<h3 class="title mt-5"><?=$linktitle2?></h3>
				<div class="info">
					<p class="date"><i class="fas fa-calendar"></i><span><?=$dt2?></span></p>
				</div>
				<div class="tutor">
					<img src="../images/sub.png" alt="">
					<div>
						<h4><?=$fn.' '.$ln?></h4>
						<span>creator</span>
					</div>
				</div>
			</div>
		</section>
		<section class="comments">
			<h1 class="heading"><?=$u->countcomment($contentid2)?> comments</h1>
			<form action="" method="POST">
				<div class="card p-3">
					<h3>add comments</h3>
					<div class="card-body ">
						<div class="col-md-12" style="margin-left: -20px">
							<textarea type="text" name="comment" placeholder="enter your comment" required class="form-control txt"></textarea>
						<?php if (isset($inappropriateMessage)) : ?>
							<p style="color: red; font-size: 14px; margin-top: 10px;"><?= $inappropriateMessage ?></p>
						<?php endif; ?>
						<input type="submit" value="comment" class="inline-btn" name="btncomment">
						</div>
					</div>	
				</div>	
			</form>
			<h1 class="heading mt-4">user comments</h1>
			<div class="box-container">
				<?php
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
							$course=$tbl['coursename'];
						}
						echo'
							<div class="box">
								<div class="user">
									<img src="../images/pic-2.jpg" alt="">
									<div>
										<h3>'.$fn.' '.$ln.'</h3>
										<span>'.$dt.'</span>
									</div>
								</div>
								<div class="comment-box">'.$row['comment'].'</div>
							</div>
						';
					}
				?>

			</div>
		</section>
		<?php }else{?>
		<section class="watch-video">
			<div class="video-container">
				<h2>This link is already expired!</h2>
			</div>
		</section>
		<?php }?>

		<script src="../js/script.js"></script>
   
	</body>
</html>

<script>
    var video = document.getElementById('myVideo');

    video.addEventListener('ended', function() {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '../ajax/ajaxcheckvideo.php?video_finished=true&&contentid='+"<?=$_GET['contentid']?>"+"&&id="+"<?=$_GET['id']?>"+"&&roomid="+"<?=$_GET['roomid']?>", true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			console.log(xhr.responseText);
			window.open("viewcontent.php?id="+xhr.responseText,"_self");
        }
      };
      xhr.send();
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
</style>
