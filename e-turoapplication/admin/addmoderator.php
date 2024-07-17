<?php

	function getId($n) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
	 
		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
	 
		return $randomString;
	}

	function getPass($p) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
	 
		for ($i = 0; $i < $p; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
	 
		return $randomString;
	}
	
	$id=getId(8);
	$pw=getPass(8);
	
	include_once'../class/classuser.php';
	$u=new Cuser();
	if(isset($_POST['btnregister'])){
		$un=$_POST['un'];
		$fname=$_POST['fname'];
		$mname=$_POST['mname'];
		$lname=$_POST['lname'];
		$email=$_POST['email'];
		$contact=$_POST['contact'];
		$address=$_POST['address'];
		$course=$_POST['course'];
		
		echo'
			<script>
				alert("'.$u->addmoderator($id,$un,$pw,$lname,$fname,$mname,$email,$contact,$address,$course).'")
			</script>
		';
	
	}
	
?>

<div class="modal p-5" id="addmoderator" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">ADD MODERATOR</h1>
				<button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><h1>&times;</h1></span>
				</button>
			</div>
			<div class="modal-body">
				<section class="contact">
					<div class="row">
						<form method="post">
							<div class="row ">
								<div class="col-md-12">
									<div class="row ">
										<div class="col-md-6">
											<h4> ID NUMBER</h4>
											<input type="text" placeholder="enter id number..." readonly value="<?=$id?>" required maxlength="50" class="box" >
										</div>
									</div>
									<div class="row mt-2 ">
										<div class="col-md-4">
											<h4>FIRST NAME</h4>
											<input type="text" placeholder="enter first name..." name="fname" required maxlength="50" class="box" >
										</div>
										<div class="col-md-3">
											<h4>MIDDLE NAME</h4>
											<input type="text" placeholder="enter middle name..." name="mname" required maxlength="50" class="box" >
										</div>
										<div class="col-md-4">
											<h4>LAST NAME</h4>
											<input type="text" placeholder="enter last name..." name="lname" required maxlength="50" class="box" >
										</div>
									</div>
									<div class="row mt-3 ">
										<div class="col-md-6">
											<h4>EMAIL</h4>
											<input type="text" placeholder="enter email..." name="email" required maxlength="50" class="box" >
										</div>
										<div class="col-md-5">
											<h4>CONTACT</h4>
											<input type="text" placeholder="enter contact..." name="contact" required maxlength="50" class="box" >
										</div>
									</div>
									<div class="row mt-3 ">
										<div class="col-md-6">
											<h4>ADDRESS</h4>
											<input type="text" placeholder="enter address..." name="address" required maxlength="50" class="box" >
										</div>
										<div class="col-md-4">
											<h4>COURSE</h4>
											<select class="form-control sbox txt"  name="course" maxlength="50" required class="box">
												<option>Select course...</option>
												<option value="Bachelor of Science in Computer Science">BSCS</option>
												<option value="Bachelor of Science in Office Administration">BSOA</option>
												<option value="Bachelor of Science in Entrepreneurship">BSEN</option>
												<option value="Bachelor of Science in Accounting Information System
												">BSAIS</option>
												<option value="Bachelor of Technical Teacher Education">BTTED</option>
											</select>
										</div>
									</div>
									
									<div class="row mt-4">
										<div class="col-md-5">
											<h4>USERNAME</h4>
											<input type="text" name="un"  required maxlength="50" class="box" >
										</div>
										<div class="col-md-5">
											<h4>PASSWORD</h4>
											<input type="text" value="<?=$pw?>" readonly  required maxlength="50" class="box" >
										</div>
									</div>
								</div>
							</div>
						</div>
				</section>
			</div>
			<div class="modal-footer">
				<div class="row mt-2 justify-content-center">
					<div class="col-md-6 ">
						<button type="submit" name="btnregister" class="btn btn-primary">REGISTER</button>
					</div>
					<div class="col-md-6">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<style>
.sbox{height: 45px;}
.txt { font-size: 15px; } 
</style>