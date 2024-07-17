<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E-TURO</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <?php include_once'design.php';?>
</head>

<body>


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 txt"><i class="fa fa-book me-3"></i>E-TURO</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="courses.php" class="nav-item nav-link">Courses</a>
                <!--<div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>-->
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
	
	<div  class="container-fluid">
		<div class="row mt-1">
			<div class="col-md-12">
				<div class="row mt-4 justify-content-center align-items-center">
					<div class="col-md-6 p-3">
						<div class="card" >
							<div class="card-body bg-light">
							<div class="d-flex justify-content-center">
								<div>
									<img src="img/eturo.jpg" class="rounded-pill" height="100px" width="100px" alt="EtuRo Logo">
								</div>
							</div>
							<h1 class="mt-3 text-center" >Welcome to E-TURO </h1>
							<form method="POST">
								<div class="row mt-4 p-2 justify-content-center">
									<div class="col-lg-12">
									<input type="text" name="username" class="form-control form-control-lg text-center rounded-3" placeholder="Enter Username..." required>
									</div>
								</div>
								<div class="row mt-2 p-2 justify-content-center">         
									<div class="col-lg-12">
										<input type="password" name="password" class="form-control form-control-lg text-center rounded-3" placeholder="Enter Password..." required>
									</div>
								</div>
								<div class="row mt-4 p-2 justify-content-center">
									<div class="col-lg-4">
										<button type="submit" name="btnlogin" class="form-control form-control-lg text-white rounded-3" style="background-color: #ba8ad1;">Login</button>
									</div>
								</div>
								<div class="mt-4"></div>
								<div class="mt-4"></div>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>

<script>
function closeAlert(){
		document.getElementById("alertError").style.display="none";
	}
	setTimeout(closeAlert,3000);
</script>

 <?php
        include_once 'e-turoapplication/class/classuser.php';
        $u = new Cuser();

        include 'api/src/apifunction.php';
        $un = 'user'; //api username 
        $pw = 'pass'; //api password

        if (isset($_POST['btnlogin'])) {
            $uname = $_POST['username'];
            $pword = $_POST['password'];

            $result = studentlog($uname, $pword);

            if ($result === false) {
                // Display error message in the modal
                echo '
                    <script>
                        $(document).ready(function(){
                            $("#login").modal("show");
                            $("#error-container").html("Invalid username or password.");
                        });
                    </script>
                ';
            } else {
                $data = $u->login($uname, $pword);
                if ($row = $data->fetch_assoc()) {
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['userid'] = $row['userid'];
                    $_SESSION['uname'] = $row['username'];
					 $_SESSION['nm'] = $row['firstname'].' '.$row['lastname'];
                    if ($row['role'] == 'admin') {
                        echo '
                            <script>
                                window.open("/e-turo/e-turoapplication/admin/home.php", "_self");
                            </script>
                        ';
                    } else if ($row['role'] == 'moderator') {
                        echo '
                            <script>
                                window.open("/e-turo/e-turoapplication/moderator/dashboard.php", "_self");
                            </script>
                        ';
                    }else{
						$check=$u->checkstudentname($uname);	
						if($row2 = $check->fetch_assoc()){
							if($pword == $row['password']){
								echo '
									<script>
										window.open("/e-turo/e-turoapplication/student/home.php", "_self");
									</script>
								';
							}else{
								echo '
									<script>
										$(document).ready(function(){
											$("#login").modal("show");
											$("#error-container").html("Incorrect Password, Please try again.");
										});
									</script>
								';
							}
						}
					} 
                }else{
					if (count($re->data) > 0) {
						$student_id = $re->data[0]->Student_Id;
						$ln = $re->data[0]->LastName;
						$fn = $re->data[0]->FirstName;
						$mn = $re->data[0]->MiddleName;
						$course = $re->data[0]->Course;
						
						$_SESSION['uname'] = $student_id;
						
						$u->addstudent($student_id,$uname,$pword,$ln,$mn,$fn,$course);
						
						echo '
							<script>
								window.open("/e-turo/e-turoapplication/student/home.php", "_self");
							</script>
						';
					}else {
						echo '
							<script>
								$(document).ready(function(){
									$("#login").modal("show");
									$("#error-container").html("Incorrect Username or Password, Please try again.");
								});
							</script>
						';
					}
				}
            }
        }
    ?>
	
<style>
    @media only screen and (max-width: 767px) {
        /*html{
            margin-top:30px;
        }*/
    }
	.center {
      display: absolute;
      justify-content: center;
      align-items: center;

    }
	
</style>


