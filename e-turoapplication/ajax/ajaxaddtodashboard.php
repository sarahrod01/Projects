<?php
	include_once'../class/class.php';
	$u=new User();
	
	$data = $u->checkdashboard($_GET['userid'], $_GET['roomid']);

	$roomAlreadyAdded = false;
	while ($row = $data->fetch_assoc()) {
		if ($roomid == $row['roomid']) {
			$roomAlreadyAdded = true;
			break;
		}
	}
	if ($roomAlreadyAdded) {
		echo '<h3><div id="removeMessage" class="alert alert-info text-center text-success">Already added to Subscriptions!</div></h3>';
	} else {
		$message = $u->addtoDash($_GET['userid'], $_GET['roomid']);
		echo '<h3><div id="removeMessage" class="alert alert-info text-center text-success">' . $message . '</div></h3>';
	}
?>