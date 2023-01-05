<?php
$token = "22ed7f2bdd3fa4c20cbac4356a7db51583afa4ff7a2ae35ad3f091f4d65b478581edda9e832194a24c04c3b55be8888d16eb4670c7ce8f1c8663e1fe6f999e0d";
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
	<meta name="description" content="Mercury - Web Messanger">

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
	<div class="text-center">
		<iframe src="raw_chat.php" class="rounded" height="65%" width="90%" title="ChatFrame" id="chat" style="animation-name: slide-right; animation-duration: 1.5s; position: relative;"></iframe>
		<iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

		<form method="post" action="send_message.php" target="dummyframe">
			<code><input type="text" name="message" id="message" placeholder="Type something..." class="rounded" style="color: #FFBF80; background-color: #1a1a1a; border: none; outline: none; width: 90%; height: 6%; animation-name: slide-left; animation-duration: 1.5s; position: relative;"></code>
		</form>
	</div>
	<br>
	<div class="container text-center text-muted">
		<footer id="copyright" style="cursor: pointer;"></footer>
	</div>
</body>
</html>
