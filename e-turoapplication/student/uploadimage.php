<?php
	$target_dir = "../images/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$img=PATHINFO($target_file,PATHINFO_BASENAME);
	$newfile=$target_dir.date('ymdhis').'.'.$imageFileType;
	
	if ($_FILES["fileToUpload"]["size"] > 500000000) {
		echo '
			<script>
				alert("Sorry, your file is too large.");
			</script>
		';
		$uploadOk = 0;
	}
	if($_FILES["fileToUpload"]["name"]!=""){
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif")  {
			echo '
				<script>
					alert("Sorry, only JPG, JPEG, PNG, GIF files are allowed.");
				</script>
			';
			$uploadOk = 0;
		}
	}

	if ($uploadOk == 0) {
		echo '
			<script>
				alert("Sorry, your file was not uploaded.");
			</script>
		';
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfile)) {
			echo
				$result=$u->addroom($userid,$studentname,$roomid,$roomname,$roomdetails,$course,basename($newfile));
			'
				<script>
					window.open("roomdetails.php?roomid="+roomid,"_self");
				</script>
			';
		} else {
			echo
			$result=$u->addroom($userid,$studentname,$roomid,$roomname,$roomdetails,$course,'');
			'
				<script>
					window.open("roomdetails.php?roomid="+roomid,"_self");
				</script>
			';
		}
	}
?>