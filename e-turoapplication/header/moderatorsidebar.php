<?php
	//session_start();
	$userid=$_SESSION['userid'];

	include_once'../class/classuser.php';
	$c=new Cuser();

?>
<div class="side-bar">
	<div id="close-btn">
		<i class="fas fa-times"></i>
	</div>

	<div class="profile">
		<img src="../images/sub.png" class="image" alt="">
		<h3 class="name"><?=$c->getName($userid)?></h3>
		<p class="role">moderator</p>
		
	</div>
	<?php
		include_once'../class/class.php';
		$u=new User();
		
	?>
	<nav class="navbar">
		<a href="managecontent.php"><i class="fas fa-home"></i><span>Manage Contents <small><span class="badge bg-danger ms-1 text-white"><?=$u->count_studentpost()?></span></small></span></a>
	</nav>
</div>