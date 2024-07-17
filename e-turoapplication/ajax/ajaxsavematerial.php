<?php
	include'../class/class.php';
	$u=new User();
	$target_dir = "../images/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$img=PATHINFO($target_file,PATHINFO_BASENAME);
	$newfile=$target_dir.date('ymdhis').'.'.$imageFileType;
	

	if ($_FILES["fileToUpload"]["size"] > 50000000000) {
		echo '
			<script>
				alert("Sorry, your file is too large.");
			</script>
		';
		$uploadOk = 0;
	}
	if($_FILES["fileToUpload"]["name"]!=""){
		if($imageFileType == "mkv" || $imageFileType == "mp4") {
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
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo $result=$u->updatecontentfile($_GET['id'],$img);

		} else {
			echo $result=$u->updatecontentfile($_GET['id'],$img);
		}
	}
?>