<script>
	function TextMe(to,msg){
		const myHeaders = new Headers();
		myHeaders.append("Authorization", "App c8f1576b2b619d2758e19a13b2b357e4-ef8407e8-4c5a-4b2f-a13b-5e87f939148b");
		myHeaders.append("Content-Type", "application/json");
		myHeaders.append("Accept", "application/json");

		const raw = JSON.stringify({
			"messages": [
				{
					"destinations": to,
					"from": "ServiceSMS",
					"text": msg
				}
			]
		});

		const requestOptions = {
			method: "POST",
			headers: myHeaders,
			body: raw,
			redirect: "follow"
		};

		fetch("https://2ve82z.api.infobip.com/sms/2/text/advanced", requestOptions)
			.then((response) => response.text())
			.then((result) => console.log(result))
			.catch((error) => console.error(error));
	}
</script>

<?php
	include_once'../class/class.php';
	$u=new User();
	
	$data=$u->getNumber();
	$ct='';
	while($row=$data->fetch_assoc()){
		$ct .= '{"to":'.$row['contact'].'},';
	}
	$contact = rtrim($ct, ',');
	$to = '['.$contact.']';
	//echo $to;
	$msg="You have new pending content to approve from E-turo. Visit the E-turo app and review it.";
	
	
	echo '
		<script>
			TextMe('.$to.',"'.$msg.'");
		</script>
	';
?>