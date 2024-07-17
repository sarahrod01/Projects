<?php
	include_once'../class/classuser.php';
	$u=new user();
	$userid=$_GET['userid'];
	$stat=$_GET['stat'];
	
	echo $u->UpdateStatus($userid,$stat);
?>