<?php
	include_once'../class/classdisplay.php';
	$d=new display();
	
	$data=$d->displaynotif($_GET['userid']);
	while($row=$data->fetch_assoc()){
		$date=$row['dt'];
		$dt=date('M d, Y',strtotime($date));
		if($row['notifstatus']=='unread'){
			echo'
				<div class="card" style="background-color: #D8D8D8;">
					<div class="card-body">
						<div>
							<h5 hidden >id: '.$row['contentid'].'</h5>
							<h5>'.$row['sname'].' posted new content in '.$row['rname'].'</h5>
							<div>'.$dt.'</div>			
						</div>
					</div>
				</div>
			';
		}
		
	}
	
	/*$postedcomments=$d->Comments($_GET['userid']);
	while($row=$postedcomments->fetch_assoc()){
		$checkjoined=$d->checkjoined($_GET['userid'],$row['roomid']);
		while($row2=$checkjoined->fetch_assoc()){
			$date=$row['datecommented'];
			$dt=date('M d, Y',strtotime($date));
			if($row['notifstatus']=='unread'){
				echo'
					<div class="card" style="background-color: #D8D8D8;">
						<div class="card-body">
							<div>
								<h5 hidden >id: '.$row['contentid'].'</h5>
								<h5>'.$row['studentname'].' commented on your post</h5>
								<div>'.$dt.'</div>			
							</div>
						</div>
					</div>
				';
			}
		}
	}
	$postedlinks=$d->PostedLinks($_GET['userid']);
	while($row=$postedlinks->fetch_assoc()){
		$checkjoined=$d->checkjoined($_GET['userid'],$row['roomid']);
		while($row2=$checkjoined->fetch_assoc()){
			$date=$row['dateuploaded'];
			$dt=date('M d, Y',strtotime($date));
			
			$linkdate=$row['linkdate'];
			$ldt=date('M d, Y',strtotime($linkdate));
			if($row['notifstatus']=='unread'){
				echo'
					<div class="card" style="background-color: #D8D8D8;">
						<div class="card-body">
							<div>
								<h5 hidden >id: '.$row['contentid'].'</h5>
								<h5>'.$row['studentname'].' posted a conference link | '.$ldt.' | '.$row['linktime'].'</h5>
								<div>'.$dt.'</div>			
							</div>
						</div>
					</div>
				';
			}
		}
	}
	$data=$d->PostedContents($_GET['userid']);
	while($row=$data->fetch_assoc()){
		$checkjoined=$d->checkjoined($_GET['userid'],$row['roomid']);
		while($row2=$checkjoined->fetch_assoc()){
			$date=$row['dateuploaded'];
			$dt=date('M d, Y',strtotime($date));
			if($row['notifstatus']=='unread'){
				echo'
					<div class="card" style="background-color: #D8D8D8;" onclick="viewcontent(&quot;'.$row['userid'].'&quot;,&quot;'.$row['contentid'].'&quot;,&quot;'.$row['roomid'].'&quot;,&quot;'.$row['contenttitle'].'&quot;,&quot;'.$row['contentdetails'].'&quot;,&quot;'.$row['file'].'&quot;,&quot;'.$row['status'].'&quot;,&quot;'.$row['contentstatus'].'&quot;,&quot;'.$row['dateuploaded'].'&quot;)">
						<div class="card-body">
							<div>
								<h5 hidden >id: '.$row['contentid'].'</h5>
								<h5>'.$row['studentname'].' posted new content in '.$row['roomname'].'</h5>
								<div>'.$dt.'</div>			
							</div>
						</div>
					</div>
				';
			}
		}
	}*/
?>