<html>
	<form method="POST">
		<input type="search" name="student">
		<input type="submit" name="btnsearch" value="Search">
	</form>
</html>

<?php
	include'src/apifunction.php';
	$un='user';//api username 
	$pw='pass';//api password

	//displayall('2018-2019');//display all records per school year
	//student('ICT-LIP-18-D');//search by student id (full id for single student, part of ID for multiple student)
	//search student by lastname/part of last name	
	//echo $file; //prints the JSON file
	student($student);

	$cnt=count($re->data);//data count
	for($c=0;$c<$cnt;$c++){
		$student_id=$re->data[$c]->Student_Id;//get student id from JSON file
		$ln=$re->data[$c]->LastName;//get last name id from JSON file
		$fn=$re->data[$c]->FirstName;//get first name id from JSON file
		$mn=$re->data[$c]->MiddleName;//get middle name id from JSON file
		$course=$re->data[$c]->Course;//get course id from JSON file
	}
		

?>


<style>
	.divtable{
		display: table;
		width: 80%;
	}
	.divRow{
		display: table-row;
	}
	.divCell{
		display: table-cell;
	}
</style>


