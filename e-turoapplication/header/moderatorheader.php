<?php
	include_once'../class/classuser.php';
	$c=new Cuser();

?>

<header class="header">
	<section class="flex">
		<div class="d-flex">
			<div ><img src="../../img/eturo.jpg" class="rounded-pill" width="60px" height="60px"></a></div>
			<h4 class="logo mt-4">E-TURO</h4>
			<!--div class="hidename mt-2"><button class="logo mt-2 bg-white " type="button"  onclick="home()"> E-TURO</button></div-->
		</div>
		
		<div class="icons">
			<div  onclick="logout()" class="fas fa-solid fa-right-from-bracket"></div>
		</div>
	</section>
</header> 

<script>
	function logout(){
		window.open("../../logout.php","_self");
	}
</script>
