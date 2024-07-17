<section class="courses">
	<div class="box-container">
		<?php
			include_once'../class/classdisplay.php';
			$u=new Display();
			$searchstudent=$u->searchstudentname($_GET['name']);
			$searchroomname=$u->searchroomname($_GET['name']);

			echo'
			
			<form method="post">
				<div class="row" style="margin-left: 10px;">
				';
			
				while($row = $searchstudent->fetch_assoc()){
					$date=$row['datecreated'];
					$dt=date('M d, Y',strtotime($date));
					if($row['image']==''){
						$img='def5.jpg';
					}else{
						$img=$row['image'];
					}
					
					echo'		
						<div class="col-md-12 bg-white " style="border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #d6d4d7; " >
							<button type="submit" name="studentsearch" class="w-100 text-left  bg-white" style="font-size: 15px;"  value="'.$row['studentname'].'">
							'.$row['studentname'].'
							</button>
						</div>
					';	
				}
				
				while($row = $searchroomname->fetch_assoc()){
					$date=$row['datecreated'];
					$dt=date('M d, Y',strtotime($date));
					if($row['image']==''){
						$img='def5.jpg';
					}else{
						$img=$row['image'];
					}

					echo'
					
					<div class="col-md-12 bg-white" style="border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #d6d4d7; ">
						<button type="submit" name="roomsearch" class=" w-200 text-left bg-white" style="font-size: 15px;"  value="'.$row['studentname'].'">
							'.$row['roomname'].'
						</button>
					</div>
					
					';	

				}
			echo'
				</div>
			</form>
		';
		?>
	</div>
</section>

<style>
.negative-margin2 {
	margin-right: -10px;
	margin-left: -50px;
	margin-top: -5px;
}
</style>