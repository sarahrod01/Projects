<div class="side-bar" style="overflow: scroll;">
	<div class="d-flex">
		<div id="close-btn">
			<i class="fas fa-times"></i>
		</div>
	</div>
		<div class="profile">
			<h1><?=$roomname?></h1>
		</div>
	<hr>
	
	<?php
		$data=$u->displaycontents($roomid2);
		$c=1;
		while($row = $data->fetch_assoc()){
			$c++;
		}
		$countcompleted=$u->countcompleted($roomid2);
		$percent=($countcompleted/5)*100;
		$displaylinks=$u->displaylinks($roomid2);
		
	?>
	<?php
		if($userid != $_GET['userid']){	
	?>
	<h5 class="text-dark">Content Progress (<?=$percent?>%)</h5>
	<div class="progress" style="height: 25px;">
		<div class="progress-bar fs-3"  role="progressbar" style="width: <?=$percent?>%;" aria-valuenow="<?=$percent?>" aria-valuemin="0" aria-valuemax="100"><?=$percent?>%</div>
	</div>
	<hr>
	<?php }?>
	<?php
		if($userid == $_GET['userid']){	
	?>
		<div>
			<button class="form-control btn-sm btn-warning" data-toggle="modal" data-target="#postconference"><h5><i class="fa-regular fa-square-plus"></i> Upload Conference</h5></button>
		</div>
		<hr>
	<?php }?>
		<?php
			if($displaylinks->num_rows > 0){
		?>
		<div class="p-2">
			<h4 class="text-danger">Conference Link:</h4>
			<?php
				while($row = $displaylinks->fetch_assoc()){
					$date=$row['dateuploaded'];
					$dt=date('M d, Y',strtotime($date));
					
					$conferencelinkdate=$row['linkdate'];
					$linkdate=date('M d, Y',strtotime($conferencelinkdate));
					
					$timeRange = $row['linktime'];
					$timeParts = explode("-", $timeRange);
					$startTime = strtotime($timeParts[0]);
					$endTime = strtotime($timeParts[1]);
					
					
					if(date('Y-m-d') >= $row['linkdate']){
						$now=strtotime(date('H:i A'));
						if($now < $endTime && $now > $startTime){
							//active
						}else if($now < $startTime){
							//inactive
						}else if($now > $endTime){
							$u->deletelink($row['contentid']);
						}
					}
					
					$string = $row['linkdetails'];
					preg_match_all('/\bhttps?:\/\/\S+\b/', $string, $matches);
					$urls = $matches[0];
					foreach ($urls as $url) {
						$text="<a href=\"$url\" target=\"_blank\">$url</a><br>";
					}	
					$word_to_remove = "http://localhost/e-turo/videoconference/index.php?roomID=";
					$new_string = str_replace($word_to_remove, '', $text);
					$rid = strip_tags($new_string);
					
			?>
			<div class="d-flex justify-content-between mt-2"><h6><a href="#" class="text-dark" style="text-decoration:none" onclick="view(&quot;<?=$row['id']?>&quot;,&quot;<?=$row['userid']?>&quot;,&quot;<?=$row['contentid']?>&quot;,&quot;<?=$row['roomid']?>&quot;,&quot;<?=$row['linktitle']?>&quot;,&quot;<?=$row['linkdetails']?>&quot;,&quot;<?=$dt?>&quot;)"><?=$row['linktitle'].' | '.$linkdate.' | '.$row['linktime']?></a></h6>
			</div>
			<button type="button" class="form-control" onclick="join(&quot;<?=$rid?>&quot;)" class="p-2"><h6>Join</h6></button>
			<?php }?>
		</div>
		<hr>
		<?php }?>
	
	
	<ul>
		<li class="step-wizard-item">
			<span class="progress-count"></span>
			<a href="#" style="text-decoration:none" class="progress-label text-dark" onclick="roominfo(&quot;<?=$_GET['userid']?>&quot;,&quot;<?=$roomid2?>&quot;)">Course Details</a>
		</li>
		<?php
			$data2=$u->displaycontents($roomid2);
			while($row = $data2->fetch_assoc()){
				$date=$row['dateuploaded'];
				$dt=date('M d, Y',strtotime($date));
				$checkjoined=$u->checkjoinedroom($userid, $roomid2);
				$checkcontent=$u->checkcontent($userid, $roomid2);
				$disabled='';
				if($checkjoined->num_rows == 0){
					if($checkcontent->num_rows == 0){
						$disabled = 'pointer-events: none;';
					}
				}
				if(strpos($row['status'],'approved') !== false){
					if($u->completedcontents($row['contentid'],$row['roomid']) == 0){
						echo'
							<li class="step-wizard-item current-item">
								<span class="progress-count"></span>
								<a href="#" style="text-decoration:none; '.$disabled.'" id="c'.$row['id'].'" class="progress-label text-dark" onclick="viewcontent(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;)">'.$row['contenttitle'].'</a>
							</li>
						';
					}else{
						echo'
							<li class="step-wizard-item">
								<span class="progress-count"></span>
								<a href="#" style="text-decoration:none; '.$disabled.'" id="c'.$row['id'].'" class="progress-label text-dark" onclick="viewcontent(&quot;'.$row['id'].'&quot;,&quot;'.$row['userid'].'&quot;)">'.$row['contenttitle'].'</a>
							</li>
						';
					}
				}        	
			}
		?>
		<?php
			$displaycontents=$u->displaycontents($roomid2);
			$cid="";
			while($row = $displaycontents->fetch_assoc()){
				$completedcontents=$u->displaycompletedcontents($row['contentid'],$row['roomid']);
				while($row = $completedcontents->fetch_assoc()){
					$cid=$cid."'".$row['contentid']."',";
				}
			}
			$cid=rtrim($cid,',');
			if($cid != ''){
				$notcompleted=$u->displaynotcompletedcontents($cid,$roomid2);
				while($row = $notcompleted->fetch_assoc()){
					if($row['contentid'] != ''){
						$none = 'pointer-events: none;';
					}else{
						$none='';
					}
				}
				
			}
		?>
		<li class="step-wizard-item">
			<span class="progress-count"></span>
			<a href="#" style="text-decoration:none; <?=$none?>"  class="progress-label text-dark" onclick="certcompletion(&quot;<?=$roomid2?>&quot;)">Certificate of Completion</a>
		</li>
	</ul>
</div>

<div class="modal p-4" id="postconference" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">CREATE CONFERENCE</h1>
				<button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><h1>&times;</h1></span>
				</button>
			</div>
			<div class="modal-body">
				<section class="contact">
					<div class="row" style="margin-top:-20px;">
					<form method="post" enctype="multipart/form-data">
						<h4>Conference Date</h4>
						<input type="date" name="linkdate" required class="box">
						<div class="d-flex justify-content-between">
							<div class="w-50">
								<h4>From</h4>
								<input type="time" name="linkfrom" required class="box">
							</div class="w-50">
							<div>
								<h4>To</h4>
								<input type="time" name="linkto" required class="box">
							</div>
						</div>
						<h4>CONFERENCE TITLE</h4>
						<input type="text" placeholder="enter content name" name="linktitle" required class="box">
						<h4>CONFERENCE LINK</h4>
						<textarea type="text" placeholder="enter conference link" name="linkdetails" required class="box"></textarea>
						<?php
							if (isset($errorMessage)) {
								echo '<h3><p class="text-danger">' . $errorMessage . '</p><h3>';
							}
						?>
					</div>
				</section>
			</div>
			<div class="modal-footer">
				<button type="submit" name="btnpostconference" class="btn">CREATE</button>
				<button type="button" class="btn" data-dismiss="modal">CLOSE</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php
	if(isset($_POST['btnpostconference'])){
		$n=5;
		$characters = '0123456789';
		$contentid = '';
	 
		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$contentid .= $characters[$index];
		}
		
		$linkdate=$_POST['linkdate'];
		$from=date("h:i A", strtotime($_POST['linkfrom']));
		$to=date("h:i A", strtotime($_POST['linkto']));
		$linktime=$from.'-'.$to;
		$linktitle=$_POST['linktitle'];
		$linkdetails=$_POST['linkdetails'];
		
		$u->createlink($userid,$studentname,$contentid,$roomid2,$linkdate,$linktime,$linktitle,$linkdetails);
	}
?>
<style>
	.activelink{
		color: blue;
		font-size: 15px;
	}
</style>
<script>
	setactive();
	function setactive(){
		var contentid="c<?=$_GET['id']?>";
		//alert(contentid);
		var page=document.getElementById(contentid);
		page.className="mt-5 bg-white activelink";
		
	}
	function roominfo(userid,roomid){
		window.open("roomdetails.php?userid="+userid+"&&roomid="+roomid,"_self");
	}
	function certcompletion(roomid){
		window.open("certcompletion.php?roomid="+roomid,"_new");
	}
	function viewcontent(id,userid){
		window.open("viewcontent.php?id="+id+"&&userid="+userid,"_self");
	}
	function view(id,uid,cid,roomid,linktitle,linkdetails,dt){
		window.open("viewlinkcontents.php?id="+id+"&&userid="+uid+"&&contentid="+cid+"&&roomid="+roomid+"&&linktitle="+linktitle+"&&linkdetails="+linkdetails+"&&dt="+dt,"_self");
	}
	function join(roomid){
		//alert(rid);
		window.open("../../videoconference/index.php?roomID="+roomid,"_new");
	}

    function back(){
		var back=history.go(-1);
		window.back;
	}
	
</script>