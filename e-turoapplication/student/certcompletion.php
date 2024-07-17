<?php
	session_start();
	$userid=$_SESSION['studentid'];
	
	require_once('../fpdf/fpdf.php');
	$pdf = new fpdf('L', 'mm', 'A4');
	
	$getstudentinfo=$u->getstudentname($userid);
	if($tbl = $getstudentinfo->fetch_assoc()){
		$student_id=$tbl['userid'];
		$fn=$tbl['firstname'];
		$mn=$tbl['middlename'];
		$ln=$tbl['lastname'];
		$course=$tbl['coursename'];
	}
				
	include_once'../class/classdisplay.php';
	$d=new Display();
	$roomname=$d->Displayroomdetails($_GET['roomid']);
	$certdetails='This certificate serves as a testament to your dedication, perseverance, and continuous pursuit of knowledge to learn and explore new fields in "'.$roomname.'". Your accomplishments in this course are commendable and reflect your passion for learning and growth.';
	
	$date = $d->getdt($_GET['roomid']); 
	$formatted_date = date("d M, Y", strtotime($date));
	$Displaydate='Given this '.$formatted_date.'';
	

	
	$pdf->AddPage();
	$pdf->Image('../../img/ictedlogo.png', 73, 3, 12, 0);
	$pdf->SetFont('times', 'I', 20);
	$pdf->SetTextColor(189, 191, 255);
	$pdf->Cell(0, 0, 'ICT-ED Institute of Science and Technology', 20, 1, 'C');
	$pdf->SetFont('times', '', 20);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(290, 45, 'E-TURO', 0, 1,'C');
	$pdf->Image('../../img/eturo.jpg', 120, 22, 20, 0);
	$pdf->SetFont('times', '', 30);
	$pdf->SetTextColor(185,126,252);
	$pdf->Cell(0, 0, 'Certificate of Completion', 0, 1,'C');
	$pdf->SetFont('times', '', 20);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(0, 40, 'This certificate is presented to', 0, 1,'C');
	$pdf->SetFont('times', 'U', 30);
	$pdf->SetTextColor(185,126,252);
	$pdf->Cell(0, -10, $fn.' '.$ln, 0, 1,'C');
	$pdf->SetFont('times', '', 15);
	$pdf->Cell(0, 20, '', 0, 1,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->MultiCell(275, 10, $certdetails,0,'C');
	$pdf->SetFont('times', 'I', 13);
	$pdf->Cell(0, 30, $Displaydate, 0, 1,'C');
	$pdf->SetFont('times', 'U', 15);
	$pdf->Cell(0, 13, $d->getName($_GET['roomid']), 0, 1,'C');
	$pdf->SetFont('times', '', 15);
	$pdf->Cell(0, -3, 'Student Facilitator', 0, 1,'C');
	$pdf->SetFont('times', '', 15);
	$pdf->Output();
?>
