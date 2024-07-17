

<?php 
    $status = $_GET['status'];  // Get the status from the AJAX call   
	include_once '../class/classdisplay.php';
    $d = new display();
	$data = $d->PendingContents($status);
	while ($row = $data->fetch_assoc()) {
		echo '
			<tr>
				<th scope="row">
					<div class="d-flex">
						<div><img src="../images/sub.png" width="50px"></div>
						<div style="margin-left: 10px;"><h4>'.$row['studentname'].' posted new content about "'.$row['contenttitle'].'"</h4> <h5>'.$row['coursename'].'</h5> <h6>'.$row['dateuploaded'].'</h6> </div>
					</div>
				</th>
				<td><button type="button" onclick="updateContents(\''.$row['contentid'].'\', \''.$row['studentname'].'\')" class="btn-primary form-control mt-4">View</button></td>
			</tr>
		';
	}
?>
