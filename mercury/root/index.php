<?php
$file = fopen("../token.txt", "r");
$token = fread($file,filesize("../token.txt"));
$date = date("Ymd");

if (str_contains($token, $date)) {
    fclose($file);
} else {
	header("Location: /authentication.html");
    fclose($file);
}

$cookie_name = "mercury_auth";

if($_COOKIE[$cookie_name] != $token) {
    header("Location: /authentication.html");
}
?>
<html>
<head>
	<link rel="SHORTCUT ICON" type="image/x-icon" href="m_icon.png"/>
	<link rel="icon" type="image/x-icon" href="m_icon.png" />

	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text/html" charset="utf-8">

	<meta name="author" content="90N45">
	<meta name="description" content="Mercury - Web-Based Communication System">
	<title>Mercury - Communication System</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<style>
		@keyframes fade-in {
			0% {opacity: 0.0;}
			100% {opacity: 1;}
		}

		@keyframes slide-left {
			0% {opacity: 0.0; left: -200px;}
			100% {opacity: 1; left: 0px;}
		}

		@keyframes slide-right {
			0% {opacity: 0.0; right: -200px;}
			100% {opacity: 1; right: 0px;}
		}
	</style>

	<script type="text/javascript">
		function copyright_date() {
			let date =  new Date().getFullYear();
			document.getElementById("copyright").innerHTML = "<p style=\"animation-name: fade-in; animation-duration: 3s;\"> &copy; " + date + " 90N45<br>All rights reserved. </p>";
		}

		document.addEventListener("keyup", function(event) {
			if (event.key === 'Enter' || event.code === 'Enter' || event.which === '13') {
				document.getElementById("message").value = "";
				document.getElementById("submit").click()
			}
		})
	</script>
</head>

<body style="background-color: #000000;">
	<br>
	<div class="text-center">
		<img src="logo.png" onclick="copyright_date()" class="rounded" alt="Mercury" height="10%" style="animation-name: fade-in; animation-duration: 3s; position: relative;">
	</div>
	<br>
	<div class="container text-center">
		<iframe src="chat.php" class="rounded" height="65%" width="100%" title="ChatFrame" id="chat" style="animation-name: slide-right; animation-duration: 1.5s; position: relative;"></iframe>
		<iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
		<br><br>
		<form method="post" action="send_message.php" target="dummyframe" style="animation-name: slide-left; animation-duration: 1.5s; position: relative;">
			<code class="d-flex justify-content-between h-25">
				<input class="rounded" type="text" name="nickname" id="nickname" placeholder=" Name" style="color: #FFBF80; background-color: #1a1a1a; border: none; outline: none; height: 20%; width: 20%; font-size: 12px;">
				<input class="rounded" type="text" name="message" id="message" placeholder=" Type something..." style="color: #FFBF80; background-color: #1a1a1a; border: none; outline: none; height: 20%; width: 60%; font-size: 12px;">
				<button class="rounded" type="submit" id="submit" style="color: #FFBF80; background-color: #1a1a1a; border: none; outline: none; height: 20%; width: 15%;"><img src="send_icon.png" height="40%"/></button>
			</code>
		</form>
	</div>
	<div class="container text-center text-muted">
		<footer id="copyright" style="cursor: pointer;"></footer>
	</div>
</body>
</html>
