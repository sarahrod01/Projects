<?php
	$contentid=$_GET['contentid'];
	$splitst=$_GET['splitst'];
	$userid=$_GET['userid'];
	$file=$_GET['file'];
	$act=$_GET['act'];
	
	include_once'../class/classroom.php';
	$r = new room();

		$result = $r->acceptcontent($contentid,$splitst,$userid,$file,$act);

?>