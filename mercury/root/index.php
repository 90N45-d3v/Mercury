<?php
$content = <<< HTML
<html>
<head>
	<link rel="SHORTCUT ICON" type="image/x-icon" href="m_icon.png"/>
	<link rel="icon" type="image/x-icon" href="m_icon.png" />

	<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
	<meta http-equiv="content-type" content="text/html" charset="utf-8">

	<meta name="author" content="90N45">
	<meta name="description" content="Mercury - Web-Based Communication System">
	<title>Mercury - Communication System</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

	<style>
		::-webkit-scrollbar {
			width: 12px;
		}

		::-webkit-scrollbar-track {
			background-color: #000000;
			border-radius: 0px;
			outline: solid;
			outline-width: 0.08rem;
			outline-color: #343a40;
		}

		::-webkit-scrollbar-thumb {
			border-radius: 10px;
			-webkit-box-shadow: inset 0 0 6px rgba(255, 191, 128, 7);
		}

		::placeholder {
			color: #495057;
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

		@keyframes slide-in-left {
			0% {opacity: 0.0; top: -1000px}
			100% {opacity: 1; top: 0px}
		}

		.opacity-out {
			-webkit-mask-image: linear-gradient(to top, black 80%, transparent 100%);
			mask-image: linear-gradient(to top, black 80%, transparent 100%);
		}

		.respButton {
			min-height: fit-content;
			height: 2.5rem;
			text-decoration: none;
			color: #495057;
			background: #1a1a1a;
			border: none;
			outline: solid;
			outline-width: 0.08rem;
			outline-color: #252628;
		}

		.respButton:hover {
			color: #FFBF80;
			outline-color: #FFBF80;
		}

		.respTextInput {
			color: #FFBF80;
			background-color: #1a1a1a;
			border: none;
			outline: solid;
			outline-width: 0.08rem;
			outline-color: #252628;
		}

		.respHeaderButton {
			text-decoration: none;
			color: #FFBF80;
			background: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(34,34,34,1) 100%);
			border: none;
			outline: solid;
			outline-width: 0.08rem;
			outline-color: #FFBF80;
		}

		.respHeaderButton:hover {
			background: linear-gradient(0deg, rgba(255,169,84,1) 0%, rgba(255,191,128,1) 100%);
			background-color: #FFBF80;
			color: #1a1a1a;
		}

		.m-outline {
			outline: solid;
			outline-width: 0.08rem;
			outline-color: #252628;
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script type="text/javascript">

		var offline = false;

		document.addEventListener("keyup", function(event) {
			if (event.key === 'Enter' || event.code === 'Enter' || event.which === '13') {
				document.getElementById("message").value = "";
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
					if (data != "403") {
						document.getElementById("chat").innerHTML = data;
						if (last_chat_state !== "" && last_chat_state !== document.getElementById("chat").innerHTML) {
							console.log("New message");
							if (document.visibilityState === "hidden") {
								sendNotification("Mercury", "Someone sent you a message!");
							}
						}
					} else {
						if (document.cookie.match(/^(.*;)?\s*mercury_usr\s*=\s*[^;]+(.*)?$/) !== null) {
							window.location = "/authentication.html"
						}
					}
				});
				if (offline) {
					offline = false;
				}
			} else {
				if (offline == false) {
					message("<b>YOU ARE OFFLINE...</b> Please stay connected to the Internet to receive any further messages!")
					offline = true;
				}
			}
		}

		function buttonTriggerSend() {
			document.getElementById("sendMessage").requestSubmit();
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

		function message(text) {
			let message = '<div class="alert alert-dark alert-dismissible fade show m-outline" role="alert" style="border: none; z-index: 9999; position: fixed; top: 1vw; margin-left: 1.5vw; margin-right: 1.5vw; animation-name: slide-in-left; animation-duration: 1.5s; color: #FFBF80; background-color: #1a1a1a;" id="systemMsg">' + text + '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>'
			$('body').append(message);
		}

		function closeMessage(id) {
			const alert = bootstrap.Alert.getOrCreateInstance("#systemMsg");
			alert.close()
		}

		function auth_redirect() {
			window.location.replace("/authentication.html");
		}

		function logout() {
			document.cookie = "mercury_usr=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "mercury_auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			message("Logged out successfully.");
			setTimeout(auth_redirect, 5000);
		}

		setInterval(update, 2000);
		notifyPermission();
	</script>
</head>

<body style="background-color: #000000; height: 100%; overflow: hidden;">
	<div>
		<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" style="border-bottom: solid; border-color: #FFBF80; border-width: 1px; background: #1a1a1a;">
			<div class="container-fluid">				
				<a class="navbar-brand" href="https://github.com/90N45-d3v/Mercury">
					<img src="logo.png" height="40px">
				</a>
				<div>
					<ul class="nav ms-auto">
						<li class="nav-item">
							<div class="container text-center">
								<a class="rounded btn text-center respHeaderButton" title="Settings" style="margin-right: 10px;" href="account.php">
									<svg style="margin: 4;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
										<path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
										<path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
									</svg>
								</a>
								<a class="rounded btn text-center respHeaderButton" title="Log out" onclick="logout();">
									<svg style="margin: 4;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
										<path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
									</svg>
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm" style="visibility: hidden;">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">
					<img src="logo.png" height="30px">
				</a>
				<div>
					<ul class="nav ms-auto">
						<li class="nav-item">
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="m-outline rounded" style="height: 65%; width: 100%; background-color: #1a1a1a; position: relative;">
			<div class="opacity-out" style="height:100%; width: 100%;">
				<code id="chat" style="color: #FFBF80; margin: 10px; bottom: 0; position: absolute; animation-name: fade-in-broken; animation-duration: 3s;"></code>
			</div>
		</div>
		<iframe name="dummyframe" id="dummyframe" style="display: none;" onsubmit="clearText()"></iframe>
		<br><br>
		<form method="post" id="sendMessage" action="send_message.php" target="dummyframe">
			<code class="d-flex justify-content-between h-25">
				<input class="rounded respTextInput" type="text" name="message" id="message" placeholder=" Type something..." style="height: 20%; width: 80%; font-size: 12px;">
				<button class="rounded respButton" title="Send" type="button" style="height: 20%; width: 15%;" onclick="buttonTriggerSend()"><img src="send_icon.png" height="40%"/></button>
			</code>
		</form>
	</div>
</body>
</html>
HTML;

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
	    } else {
			if (array_key_exists('pwd0', $_POST)) {
				if (array_key_exists('pwd1', $_POST)) {
					if ($_POST['pwd0'] == $_POST['pwd1']) {
						changePwd($_POST['pwd0']);
					} else {
						message("<b>FAIL: </b>To change the admin password, both entries must be equal.");
					}
				}
			} else if (array_key_exists('logout', $_POST)) {
				logout();
			}
			echo $content;
	    }
	} else {
		header("Location: /authentication.html");
	}
} else {
	header("Location: /authentication.html");
}
?>