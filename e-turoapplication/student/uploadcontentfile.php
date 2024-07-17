<?php
	$uploadDir = "../images/";
	$uploadedFiles = [];
	$fstatus = [];
	$fileCount = count($_FILES['files']['name']);

	for ($i = 0; $i < $fileCount; $i++) {
		$fileName = basename($_FILES['files']['name'][$i]);
		$imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		$targetFilePath = $uploadDir . $fileName;

		if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFilePath)) {
			if ($imageFileType == 'mp4') {
				array_unshift($uploadedFiles, $fileName);
			} else {
				array_push($uploadedFiles, $fileName);
			}
			$fstatus[] = 'pending';
		} else {
			echo "Error uploading the file $fileName.<br>";
		}
	}

	$contentfile = implode(',', $uploadedFiles);
	$filestatus = implode(',', $fstatus);
	echo $result=$u->postcontent($userid,$studentname,$contentid,$_GET['roomid'],$contentname,$contentdetails,$contentfile,$filestatus);
	'
		<script>
			window.open("roomdetails.php?roomid="+roomid,"_self");
		</script>
	';
?>