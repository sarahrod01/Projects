<?php
	$target_dir = "../images/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$img=PATHINFO($target_file,PATHINFO_BASENAME);
	$newfile=$target_dir.date('ymdhis').'.'.$imageFileType;
	
	if(isset($_POST["btnupdateprofile"])) {
	  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	  if($check !== false) {
		echo '
			<script>
				alert("File is an image - " . $check["mime"] . ".");
			</script>
		';
		$uploadOk = 1;
	  } else {
		echo '
			<script>
				alert("File is not an image.");
			</script>
		';
		$uploadOk = 0;
	  }
	}

	if ($_FILES["fileToUpload"]["size"] > 50000000000) {
		echo '
			<script>
				alert("Sorry, your file is too large.");
			</script>
		';
		$uploadOk = 0;
	}
	if($_FILES["fileToUpload"]["name"]!=""){
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "docx" && $imageFileType != "mkv" && $imageFileType != "mp4") {
			echo '
				<script>
					alert("Sorry, only JPG, JPEG, PNG, GIF, DOCX, PDF, MKV & MP4 files are allowed.");
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
			
					$u->addcomment($userid,$contentid2,$commentid,$comment,basename($newfile));
			echo
			'
				<script>
					window.open("viewcontent.php?roomid="+roomid,"_self");
				</script>
			';
		} else {
			
				$u->addcomment($userid,$contentid2,$commentid,$comment,'');
			echo
			'
				<script>
					window.open("roomdetails.php?roomid="+roomid,"_self");
				</script>
			';
		}
	}
?>