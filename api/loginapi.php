<?php
include'src/apifunction.php';
$un='user';//api username 
$pw='pass';//api password

$uname='ICT-LIPA-13-A-00009';//student username
$pword='hQKkexvo';//student password
studentlog($uname,$pword);

if(count($re->data)>0){
	$student_id=$re->data[0]->Student_Id;//get user id from JSON file
	$ln=$re->data[0]->LastName;//get last name id from JSON file
	$fn=$re->data[0]->FirstName;//get first name id from JSON file
	$mn=$re->data[0]->MiddleName;//get middle name id from JSON file
	$course=$re->data[0]->Course;//get middle name id from JSON file
	
	
	
	//convert the variables below to session variables
	echo $student_id.'<br>';
	echo $ln.'<br>';
	echo $fn.'<br>';
	echo $mn.'<br>';
	echo $course.'<br>';
	
	//then redirect to whatever page
}else{
	echo'Unable to Login';
}
	
?>
