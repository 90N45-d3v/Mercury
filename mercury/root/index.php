<?php
if (isset($_COOKIE["mercury_usr"]) && isset($_COOKIE["mercury_auth"])) {
	$user = $_COOKIE["mercury_usr"];
	$user_path = "../user/" . $user;
	if (file_exists($user_path) && $user != "." && $user != "..") {
		$token_path = "../user/" . $user . "/token.txt";
	    $file = fopen($token_path, "r");
	    $date = date("Ymd");
	    $token_r = fread($file,filesize($token_path));

		if (str_contains($token_r, $date)) {
			fclose($file);
		} else {
			header("Location: /authentication.html");
			fclose($file);
		}

	    if ($_COOKIE["mercury_auth"] != $token_r) {
	    	header("Location: /authentication.html");
	    }
	} else {
		header("Location: /authentication.html");
	}
} else {
	header("Location: /authentication.html");
}
?>
<html>
<head>
	<link rel="SHORTCUT ICON" type="image/x-icon" href="m_icon.png"/>
	<link rel="icon" type="image/x-icon" href="m_icon.png" />

	<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
	<meta http-equiv="content-type" content="text/html" charset="utf-8">

	<meta name="author" content="90N45">
	<meta name="description" content="Mercury - Web-Based Communication System">
	<title>Mercury - Communication System</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<style>
		::-webkit-scrollbar {
			width: 12px;
		}

		::-webkit-scrollbar-track {
			background-color: #000000;
			border-radius: 0px;
		}

		::-webkit-scrollbar-thumb {
			border-radius: 10px;
			-webkit-box-shadow: inset 0 0 6px rgba(255, 191, 128, 7);
		}

		@keyframes fade-in {
			0% {opacity: 0.0;}
			100% {opacity: 1;}
		}

		@keyframes fade-in-broken {
			0% {opacity: 0.0;}
			80% {opacity: 0.0;}
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

		.opacity-out {
			-webkit-mask-image: linear-gradient(to top, black 80%, transparent 100%);
			mask-image: linear-gradient(to top, black 80%, transparent 100%);
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script type="text/javascript">
		document.addEventListener("keyup", function(event) {
			if (event.key === 'Enter' || event.code === 'Enter' || event.which === '13') {
				document.getElementById("message").value = "";
				document.getElementById("submit").click();
			}
		})

		function copyright_date() {
			let date =  new Date().getFullYear();
			document.getElementById("copyright").innerHTML = "<p style=\"animation-name: fade-in; animation-duration: 3s;\"> &copy; " + date + " 90N45<br>All rights reserved. </p>";
		}

		function update() {
			if (navigator.onLine === true) {
				$.get("chat.php", function(data, status) {
					last_chat_state = document.getElementById("chat").innerHTML
					document.getElementById("chat").innerHTML = data;
					if (last_chat_state !== "" && last_chat_state !== document.getElementById("chat").innerHTML) {
						console.log("New message");
						if (document.visibilityState === "hidden") {
							sendNotification("Mercury", "Someone sent you a message!");
						}
					}
				});
			} else {
				alert("YOU ARE OFFLINE...\nPlease stay connected to the Internet to receive any further messages");
			}
		}

		function clearText() {
			document.getElementById("message").value = "";
		}

		function notifyPermission() {
			if (Notification.permission !== 'granted') {
				Notification.requestPermission(permission => {
					if(permission === 'granted') {
						sendNotification("Permission granted", "Mercury can now keep you up to date!");
						console.log("OK")
					}
				});
			}
		}

		function sendNotification(title, text) {
			if(Notification.permission === 'granted') {
				const notification = new Notification(title, {
					body: text,
					icon: 'm_icon.png'
				});
			}
		}

		setInterval(update, 2000);
		notifyPermission();
	</script>
</head>

<body style="background-color: #000000;">
	<br>
	<div class="text-center">
		<img src="logo.png" rel="preload" onclick="copyright_date()" class="rounded" alt="Mercury" height="10%" style="animation-name: fade-in; animation-duration: 3s; position: relative;">
	</div>
	<br>
	<div class="container">
		<div style="height: 65%; width: 100%; background-color: #1a1a1a; animation-name: slide-right; animation-duration: 1.5s; position: relative;">
			<div class="opacity-out" style="height:100%; width: 100%;">
				<code id="chat" style="color: #FFBF80; margin: 10px; bottom: 0; position: absolute; animation-name: fade-in-broken; animation-duration: 3s;"></code>
			</div>
		</div>
		<iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
		<br><br>
		<form method="post" action="send_message.php" target="dummyframe" style="animation-name: slide-left; animation-duration: 1.5s; position: relative;">
			<code class="d-flex justify-content-between h-25">
				<input class="rounded" type="text" name="message" id="message" placeholder=" Type something..." style="color: #FFBF80; background-color: #1a1a1a; border: none; outline: none; height: 20%; width: 80%; font-size: 12px;">
				<button class="rounded" type="submit" id="submit" style="color: #FFBF80; background-color: #1a1a1a; border: none; outline: none; height: 20%; width: 15%;"><img src="send_icon.png" height="40%"/></button>
			</code>
		</form>
	</div>
	<div class="container text-center text-muted">
		<footer id="copyright" style="cursor: pointer;"></footer>
	</div>
</body>
</html>
