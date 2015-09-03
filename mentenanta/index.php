<?php
require_once '../inc/database.php';
if (!isset($maintenance) || $maintenance === false) {
	header('Location: ../');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mentenanta!</title>
	<link rel="stylesheet" type="text/css" href="../css/yeti.css">
	<link rel="stylesheet" type="text/css" href="../css/theme.css">
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
</head>
<body>
	<div class="container">
		<br/>
		<div class="well" style=" font-size:24px;">
			<center><i class="fa fa-warning" style="color:orange;"></i>&nbsp;Momentan serverul sau websiteul este in mentenanta<br/></center>
		</div>
	</div>
</body>
</html>