<?php
function displayall($ay){
	global $re;
	global $file;
	global $un;
	global $pw;
	$opts = array(
		'http'=>array(
		'method'=>"GET",
		'header'=>array(
						"ay: ".$ay,
						"un: ".$un,
						"pw: ".$pw."\r\n"	
			)
  )
);
	$context = stream_context_create($opts);
	$file = file_get_contents('http://api.ictedu.ph/student.php', false, $context);
	$re=json_decode($file);
}


function student($studentid){
	global $re;
	global $file;
	global $un;
	global $pw;
	$opts = array(
		'http'=>array(
		'method'=>"GET",
		'header'=>array(
						"studentid: ".$studentid,
						"un: ".$un,
						"pw: ".$pw."\r\n"	
			)
  )
);
	$context = stream_context_create($opts);
	$file = file_get_contents('http://api.ictedu.ph/searchstudent.php', false, $context);
	$re=json_decode($file);
}


function instructorlog($uname,$pword){
	global $re;
	global $file;
	global $un;
	global $pw;
	$opts = array(
		'http'=>array(
		'method'=>"GET",
		'header'=>array(
						"uname: ".$uname,
						"pword: ".$pword,
						"un: ".$un,
						"pw: ".$pw."\r\n"	
			)
  )
);
	$context = stream_context_create($opts);
	$file = file_get_contents('http://api.ictedu.ph/instructorlogin.php', false, $context);
	$re=json_decode($file);
}

function studentlog($uname,$pword){
	global $re;
	global $file;
	global $un;
	global $pw;
	$opts = array(
		'http'=>array(
		'method'=>"GET",
		'header'=>array(
						"uname: ".$uname,
						"pword: ".$pword,
						"un: ".$un,
						"pw: ".$pw."\r\n"	
			)
  )
);
	$context = stream_context_create($opts);
	$file = file_get_contents('http://api.ictedu.ph/studentlogin.php', false, $context);
	$re=json_decode($file);
}

?>