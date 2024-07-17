<?php
    session_start();
    $userid = $_SESSION['userid'];
	
	include_once'../class/classuser.php';
	$c=new Cuser();
	include_once'../class/classdisplay.php';
	$d=new display();
?>

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
    <?php include_once '../design/design3.php'; ?>  
    <?php include_once '../design/design2.php'; ?>  
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
	<div class="row justify-content-center mt-4">
		<div class="col-md-12">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<table class="table table-bordered">
								<thead class="thead-dark">
									<tr>
										<th scope="col" ><h4>List of Contents</h4></th>
									</tr>
								</thead>
								<tbody>
									<?php
									include_once'../class/classdisplay.php';
										$d=new display();
										$data=$d->displaycoursecontents($_GET['courseid']);
										
										while($row=$data->fetch_assoc()){
											$ctitle=$row['contenttitle'];
											$cdetails=$row['contentdetails'];
											$du=$row['dateuploaded'];
											echo'
												<tr>
													<td>
														<div class="d-flex">
															<div>
																<div>'.$ctitle.'</div>
																<div>'.$cdetails.'</div>
																<div>'.date('M d, Y',strtotime($du)).'</div>
																
															
											';
										
									?>
														<?php 
															$changefilestatus=explode(",",$row['status']);
															$contents=explode(",",$row['file']);
															for($c=0; $c<count($contents); $c++){
																$filepathinfo=pathinfo($contents[$c]);
																$filepathextension=$filepathinfo['extension'];
																if($changefilestatus[$c] == 'approved'){
																	if($filepathextension=='mp4' || $filepathextension=='mkv'){
															
														?>
														<section class="watch-video">
														<div class="video-container">
														<div class="video">
																	<?php
																		//$contents=explode(",",$file2);
																		//$changefilestatus=explode(",",$status2);
																		if($changefilestatus[0] == 'approved'){
																			echo'
																				<video src="../images/'.$contents[0].'" controls id="myVideo"></video>
																				<div class="row mt-2">
																					<div class="col-md-12">
																						<div class="card">
																							<div class="card-body">
																							<h4>Materials</h4>
																			';
																		}
																		for($c=1; $c<count($contents); $c++){
																			$pathinfo=pathinfo($contents[$c]);
																			$fileextension=$pathinfo['extension'];
																			if($changefilestatus[$c] == 'approved'){
																				if($fileextension=='pdf'){
																					$icon='text-danger fas fa-file-pdf';
																				}else if($fileextension=='docx' || $fileextension=='doc'){
																					$icon=' fas fa-file-word';
																					
																				}else if($fileextension=='ppt' || $fileextension=='pptx'){
																					$icon='text-danger fas fa-file-powerpoint';
																					
																				}else if($fileextension=='xlsx' || $fileextension=='xlsx'){
																					$icon='text-success fas fa-file-excel';
																					
																				}else{
																					$icon='fas fa-file';
																					
																				}
																				
																				echo'
																					<a style="font-size: 16px;" href="#" onclick="openfile(&quot;'.$contents[$c].'&quot;)"><i class="'.$icon.' mr-2" style="font-size: 15px;"></i> '.$contents[$c].'</a><br>		
																				';
																			}
																			
																		}
																	?>
																		</div>
																	</div>
																</div>
															</div> 
														</div>
														</div>
														</section>
														<?php }else{?>
														<section class="watch-video">
														<div class="video-container">
														<div class="video">
															<?php
																for($c=1; $c<count($contents); $c++){
																	$pathinfo=pathinfo($contents[$c]);
																	$fileextension=$pathinfo['extension'];
																	if($changefilestatus[$c] == 'approved'){
																		if($fileextension=='pdf'){
																			$icon='text-danger fas fa-file-pdf';
																		}else if($fileextension=='docx' || $fileextension=='doc'){
																			$icon=' fas fa-file-word';
																			
																		}else if($fileextension=='ppt' || $fileextension=='pptx'){
																			$icon='text-danger fas fa-file-powerpoint';
																			
																		}else if($fileextension=='xlsx' || $fileextension=='xlsx'){
																			$icon='text-success fas fa-file-excel';
																			
																		}else{
																			$icon='fas fa-file';
																			
																		}
																		
																		echo'
																			<a style="font-size: 16px;" href="#" onclick="openfile(&quot;'.$contents[$c].'&quot;)"><i class="'.$icon.' mr-2" style="font-size: 15px;"></i> '.$contents[$c].'</a><br>		
																		';
																	}
																	
																}
															?>
														</div>
														</div>
														</section>
														<?php }}}?>
														<div class="row">
															<div class="col-md-12">
																<h4>Comments:</h4>
																<?php
																include_once'../class/classdisplay.php';
																$d=new display();
																
																$getcomment=$d->getallcomment($row['contentid']);
																//echo $_GET['contentid'];
																while($row2=$getcomment->fetch_assoc()){
																	
																	echo'
																		<div id="Result" class="mt-3" ></div>
																		<div class="d-flex">
																			<div><img src="../images/sub.png" alt="" style="width: 50px; margin-left:20px;"></div>
																			<div>
																				<input type="text" hidden value="'.$row2['commentid'].'">
																				<h4 class="mt-1 ml-2">'.$row2['firstname'].' '.$row2['lastname'].'</h4>
																				<h5 class="ml-2" style="margin-top: -5px;">'.$row2['coursename'].'</h5>
																				<h3 class="ml-2" style="margin-top: -5px;" >'.$row2['comment'].'</h3>
																				<input type="text" hidden name="comment" value="'.$row2['comment'].'">
																				<div class="d-flex">
																					<div><h6 class="ml-2" style="margin-top: -8px;">'.$row2['datecommented'].'</h6></div>
																					
																				</div>
																			</div>
																			
																		</div>
																	';
																//echo $row2['comment'];
																}
																?>
															</div>
														</div>
													</div>
												</div>
											</td>
										</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<div>
		</div>
	</div>
</body>


<script>
	function openfile(filename){
		window.open("pdffile.php?filename="+filename,"_new");
	}
	function deletecomment(commentid,comment){
		alert (comment);
		var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			 document.getElementById("Result").innerHTML = this.responseText;
			 window.open("moderatecontents.php?courseid="+"<?=$_GET['courseid']?>"+"&&name="+"<?=$_GET['name']?>","_new");
			 
			}
		  };
		  xhttp.open("GET", "../ajax/ajaxdelete_comment.php?commentid="+commentid+"&&comment="+comment, true);
		  xhttp.send();
	}
</script>