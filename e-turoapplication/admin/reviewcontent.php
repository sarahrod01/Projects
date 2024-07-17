<?php
	session_start();
	$userid=$_SESSION['userid'];
	
	include_once'../class/classuser.php';
	$c=new Cuser();
	include_once'../class/classdisplay.php';
	$d=new display();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>HOME</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../design/design.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
	
	<body>
	<?php include_once'../design/design3.php';?>  
	<?php include_once'../design/design2.php';?> 
	<header class="header">
		<section class="flex">
			<div class="d-flex">
				<div ><img src="../../img/eturo.jpg" class="rounded-pill" width="60px" height="60px"></a></div>
				<a href="home.php" class="logo mt-3">E-TURO</a>
				<!--div class="hidename mt-2"><button class="logo mt-2 bg-white " type="button"  onclick="home()"> E-TURO</button></div-->
			</div>
			<div class="icons">
				<div  onclick="logout()" class="fas fa-solid fa-right-from-bracket"></div>
			</div>

			<div class="profile">
				<img src="../images/pic-1.jpg" class="image" alt="">
				<h3 class="name"><?=$c->getName($userid)?></h3>
				<p class="role">admin</p>
			</div>
		</section>
	</header> 
	<form method="post">
		<?php
		
			
			include_once'../class/classdisplay.php';
			$d=new display();
		    include_once'../class/classroom.php';
			$r = new room();
			
			$data=$d->displaycontent($_GET['contentid']);
			if($row=$data->fetch_assoc()){
				$file=$row['file'];
			}
							
		
			if(isset($_POST['btndecline'])){
				$contentid=$_POST['contentid'];
				
				echo'
					<script>
						alert("'.$r-> approvedtodecline($_GET['contentid']).'");
						window.open("dashboard.php","_self");
					</script>
				';
			}
			
			if(isset($_POST['btnaccept'])){
				$contentid=$_POST['contentid'];
				
				echo'
					<script>
						alert("'.$r->declinedtoapprove($_GET['contentid']).'");
						window.open("dashboard.php","_self");
					</script>
			';
		}
		
		?>
		<div class="container">
			<div class="row mt-4">
				<div class="col-md-10">
					<div class="card">
						<div class="card-body">
							<div class="d-flex ">
							<input type="text" hidden name="contentid"  value="<?=$_GET['contentid']?>">
								<div class=" ms-3 mt-2">
									<img src="../images/pic-7.jpg" class="rounded-circle" height="50" width="50">
								</div>
								<div class="d-flex flex-column  negative-margin2">
									<div class="mt-3 " ></div>
									<div ><h4 class="text-dark"><?=$_GET['name']?></h4></div>
									<div ><h5 class="text-dark"><?=$row['contenttitle']?></h5></div>
									<div ><h5 class="text-dark"><?=$row['contentdetails']?></h5></div>
									
								</div>
								
								
							</div>
							<div class="row mt-2 p-5">
								<div class="col-md-5 "  height="100px" >
									<!--div class="video " >
										<!--?php
											//$fileextension=strrchr($file,'.');
											if($fileextension == '.mvk'){
												echo'
													<video src="../images/'.$file.'" controls id="video"></video>
												';
											}else if($fileextension == '.mp4'){
												echo'
													<video src="../images/'.$row['file'].'" controls id="video"></video>
												';
											}else if($fileextension == '.docx'){
												echo'
													<a href="../images/'.$file.'"><img src="../images/word.png" controls id="video"></a>
												';
											}else{
												echo'
													<img src="../images/'.$file.' " controls id="video" >
												';
											}
											
											
										?>
									</div-->
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<?php
									include_once'../class/classdisplay.php';
									$d=new display();
									
									$data=$d->getallcomment($_GET['contentid']);
									//echo $_GET['contentid'];
									while($row=$data->fetch_assoc()){
										echo'
											<div id="Result"></div>
											<div class="d-flex">
												<div><img src="../images/sub.png" alt="" style="width: 50px; margin-left:20px;"></div>
												<div>
													<input type="text" hidden value="'.$row['commentid'].'">
													<h4 class="mt-1 ml-2">'.$row['firstname'].' '.$row['lastname'].'</h4>
													<h5 class="ml-2" style="margin-top: -5px;">'.$row['coursename'].'</h5>
													<h3 class="ml-2" style="margin-top: -5px;" >'.$row['comment'].'</h3>
													<input type="text" hidden name="comment" value="'.$row['comment'].'">
													<div class="d-flex">
														<div><h6 class="ml-2" style="margin-top: -8px;">'.$row['datecommented'].'</h6></div>
													</div>
												</div>
												
											</div>
										';
									}
									?>
									
								</div>
							</div>
							
							<div class="row mt-2 justify-content-center">
								<div class="col-md-4">
									<button type="submit" name="btnaccept" class="btn btn-primary">APPROVE</button>
								</div>
								<div class="col-md-4">
									<button type="submit" class="btn btn-danger" name="btndecline">DECLINE</button>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</form>
	<script src="../js/script.js"></script>
	</body>
</html>

<script>
	function deletecomment(commentid,comment){
		var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			 document.getElementById("Result").innerHTML = this.responseText;
			}
		  };
		  xhttp.open("GET", "../ajax/ajaxdelete_comment.php?commentid="+commentid+"&&comment="+comment, true);
		  xhttp.send();
	}
</script>

<style>
.negative-right-margin{
		margin-top:5px;
		margin-right:10px;
	}
	.negative-margin2{
		margin-left: 20px;
	}
	.negative-marginl{
		margin-left: 10px;
	}
	.negative-margin{
		margin-left: -30px;
	}
	
	.txtb{height: 40px;}
	.txt { font-size: 15px; } 
	.table-responsive{-md}
	img, video {
      max-width: 250%;
     
    }

    /* Media queries for responsive design */
    @media screen and (max-width: 600px) {
      /* Adjust styles for small screens (e.g., Android phones) */
      img, video {
        width: 100%;
      }
    }
</style>
