<html>
	<head>
		<title>DOCUMENTS</title>
	</head>
	<body>
		<iframe style="height: 96vh; width: 210vh" id="uploadedcontents" class="form-control"></iframe>
	</body>
</html>
<script>
	document.getElementById("uploadedcontents").src= "https://view.officeapps.live.com/op/embed.aspx?src=https://eturo.online/e-turoapplication/images/<?=$_GET['filename']?>";
</script>