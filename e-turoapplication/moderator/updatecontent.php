<?php
	session_start();
	$userid=$_SESSION['userid'];

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
	
	<?php include_once'../header/moderatorheader.php';?>
	<?php include_once'../design/design3.php';?>  
	<?php include_once'../design/design2.php';?> 
	<form method="post">
		<?php
			
			$poststatus=$_GET['poststatus'];
			
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
						alert("'.$r->declinecontent($row['userid'],$_GET['name'],$_GET['contentid'],$row['roomid'],$row['contenttitle'],$row['file'],$userid,$_SESSION['nm']).'");
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
							<?php
								if($poststatus=='pending'){
									$pstat='For Approval';
								}else if($poststatus=='approved'){
									$pstat='Approved Contents';
								}else{
									$pstat='Declined Contents';
								}
							?>
								<h3 class="heading"><?=$pstat;?></h3>
							<div class="d-flex ">
							<input type="text" hidden name="contentid"  value="<?=$_GET['contentid']?>">
								<div class=" ms-3 mt-2">
									<img src="../images/sub.png" class="rounded-circle" height="50" width="50">
								</div>
								<div class="d-flex flex-column  negative-margin2">
									<div class="mt-3 " ></div>
									<div ><h4 class="text-dark"><?=$_GET['name']?></h4></div>
									<div ><h5 class="text-dark"><?=$row['contenttitle']?></h5></div>
									<div ><h5 class="text-dark"><?=$row['contentdetails']?></h5></div>
									
								</div>
								
								
							</div>
							<div class="row  p-5">
								<div class="col-md-12 "   >
								
									<table class="table table-bordered">
										<thead class="thead-dark">
											<tr>
												<th scope="col"><h3>File Name</h3></th>
												<th scope="col" class="text-center"><h3>Action</h3></th>
											</tr>
										</thead>
										<tbody >
									<?php
									include_once '../class/classdisplay.php';

									$d = new display();

									$data = $d->getfiles($_GET['contentid']);
									$stat='';
									$c=0;
									
									if($row = $data->fetch_assoc()) {
										$fileArray = explode(',', $row['file']);
										$stat=$row['status'];
										//echo $stat;
										$explodeStat=explode(',', $stat);
										//Print_r ($explodeStat);
										foreach ($fileArray as $file) {
											if($explodeStat[$c]==$poststatus){
											$extension = pathinfo($file, PATHINFO_EXTENSION);
											
											
											switch (strtolower($extension)) {
												case 'pdf':
													$icon = 'text-danger fas fa-file-pdf';
													break;
												case 'doc':
												case 'docx':
													$icon = 'text-primary fas fa-file-word';
													break;
												case 'ppt':
												case 'pptx':
													$icon = 'text-danger fas fa-file-powerpoint';
													break;
												case 'xls':
												case 'xlsx':
													$icon = 'text-success fas fa-file-excel';
													break;
												default:
													$icon = 'fas fa-file';
													break;
											}
											
											echo '
												<tr>
													<td><h3><i class="'.$icon.' mr-2" style="font-size: 15px;"></i>' . htmlspecialchars($file) . '</h3></td>
													<td class="text-center">
														<button type="button" class="bg-white" data-toggle="modal" data-target="#exampleModal" onclick="vfile(&quot;'.$_GET['contentid'].'&quot;,&quot;'.$file.'&quot;,&quot;'.$c.'&quot;)"><h3><i class="fa fa-eye"></i></h3></button>
													</td>
												</tr>
											'; 
										}
										$c++;
										}
									}
									?>

									</tbody>
								</table>

								</div>
							</div>

								<!-- Modal -->
								<div class="modal fade "  id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog  modal-lg" >
									<div class="modal-content">
									  <div class="modal-header">
										<input type="text" hidden id="contentid">
										<h4 class="modal-title"  id="file"></h4>
										<input type="text" hidden id="c">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
											<iframe  style="height: 70vh;" id="uploadedcontents" class="form-control"></iframe>
											<video  style="height: 70vh;" controls id="uploadedvideocontents" class="form-control"></video>
										
									  </div>
									  <div class="modal-footer">
										<div class="row justify-content-center">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-4">
														<button type="submit" onclick="stat(&quot;approved&quot;)" class="btn btn-primary"><i class="fas fa-check "></i></button>
													</div>
													<div class="col-md-4">
														<button type="submit"onclick="stat(&quot;declined&quot;)" class="btn btn-danger" name="btndecline"><i class="fas fa-times"></i></button>
													</div>
												</div>
											</div>
										</div>
										
									  </div>
									</div>
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
	var st = "<?= $stat;?>";
	var fl = "<?=$row['file']?>";
	var userid="<?=$userid?>";
	var splitst= st.split(",");
	var splitfl= fl.split(",");
	function vfile(contentid,file,c){
		document.getElementById("contentid").value=contentid;
		document.getElementById("file").innerHTML=file;
		document.getElementById("c").value=c;
		var index=file.lastIndexOf(".");
		//alert(file.substring(index+1));
		var ext=file.substring(index+1);
		
		if(ext=='docx' || ext=='xlsx' || ext=='pptx' || ext=='pdf' ){
			document.getElementById("uploadedcontents").src= "https://view.officeapps.live.com/op/embed.aspx?src=https://eturo.online/e-turoapplication/images/"+file;
				document.getElementById("uploadedvideocontents").style.display="none";
				document.getElementById("uploadedcontents").style.display="block";
		}else if (ext=='mp4' || ext=='mkv'){
			document.getElementById("uploadedvideocontents").src= "../images/"+file;
			document.getElementById("uploadedvideocontents").style.display="block";
			document.getElementById("uploadedcontents").style.display="none";
		}
		
	}
	function stat(s){
	var indx=document.getElementById("c").value;
		splitst[indx]=s;
		
		var contentid="<?=$_GET['contentid']?>";
		//alert (splitst);
		 var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			 //alert (this.responseText);
			}
		  };
		  xhttp.open("GET", "../ajax/ajaxapproved.php?contentid="+contentid+"&&splitst="+splitst+"&&userid="+userid+"&&file="+fl+"&&act="+s, true);
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

