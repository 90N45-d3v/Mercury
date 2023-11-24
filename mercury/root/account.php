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
	<title>Mercury - Settings</title>

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
			background: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(34,34,34,1) 100%);
			border: none;
			outline: solid;
			outline-width: 0.08rem;
			outline-color: #343a40;
		}

		.respButton:hover {
			color: #FFBF80;
			outline-color: #FFBF80;
		}

		.respTextInput {
			height: 2.5rem;
			color: #FFBF80;
			background-color: #000000;
			border: none;
			outline: dashed;
			outline-width: 0.08rem;
			outline-color: #343a40;
		}

		.respTextInput:hover {
			outline-color: #FFBF80;
		}

		.respTextInput:focus {
			outline: solid;
			outline-color: #FFBF80;
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


		.m-widget {
			background-color: #1a1a1a;
			outline: solid;
			outline-width: 0.15rem;
			outline-color: #252628;
		}

		.m-outline {
			outline: solid;
			outline-width: 0.08rem;
			outline-color: #252628;
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script type="text/javascript">
		function auth_redirect() {
			window.location.replace("/authentication.html");
		}

		function logout() {
			document.cookie = "mercury_usr=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "mercury_auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			message("Logged out successfully.");
			setTimeout(auth_redirect, 5000);
		}

		function reload() {
			location.reload()
		}

		function changePwd() {
			val0 = document.getElementById("pwd0").value;
			val1 = document.getElementById("pwd1").value;

			if (val0 != val1) {
				message("<b>FAIL: </b>To change your password, both entries must be equal.")
			} else if (val0 == "") {
				message("<b>FAIL: </b>To change your password, you must enter a new one.")
			} else {
				document.getElementById("changePwd").submit();
			}
		}

		function message(text) {
			let message = '<div style="z-index: 9999; position: fixed; top: 1vw; padding-left: 1.5vw; padding-right: 1.5vw; animation-name: slide-in-left; animation-duration: 1.5s; width: 100%; display: flex; align-items: center;"><div class="alert alert-dark alert-dismissible fade show m-outline" role="alert" style="max-width: 500px; border: none; color: #FFBF80; background-color: #1a1a1a;" id="systemMsg">' + text + '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div></div>'
			$('body').append(message);
		}

		function closeMessage(id) {
			const alert = bootstrap.Alert.getOrCreateInstance("#systemMsg");
			alert.close()
		}

		$(document).ready(function() {
			if (typeof message_con != "undefined" && message_con) {
				if (message_con == "Logged out all devices successfully.") {
					message(message_con);
					setTimeout(reload, 5000);
				} else {
					message(message_con);
					setTimeout(closeMessage, 10000);
				}
			}
		});

	</script>
</head>

<body style="background-color: #000000;">
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
								<a class="rounded btn text-center respHeaderButton" title="Return" href="/index.php">
									<svg style="margin: 4;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
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
		<div style="display: flex; flex-flow: wrap;">
			<div style="max-width: 100%;">
				<div class="rounded m-widget m-shadow" style="width: 400px; max-width: 100%;">
					<div style="padding: 1rem;">
						<h4 style="color: #FFBF80; margin-bottom: 1rem;">Login Credentials</h4>
						<div class="container" style="max-width: 100%">
							<form method="post" id="changePwd">
								<div style="display: flex; flex-flow: wrap;">
									<div style="margin-right: 10px;">
										<input class="rounded respTextInput text-center" type="password" id="pwd0" name="pwd0" placeholder="New Password" class="text-center" style="margin-bottom: 10px;">
										<br>
										<input class="rounded respTextInput text-center" type="password" id="pwd1" name="pwd1" placeholder="Repeat Password" class="text-center" style="margin-bottom: 10px;">
									</div>
									<button class="rounded text-center respButton" type="button" id="button" onclick="changePwd()"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Update</a></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<br>
				<div class="rounded m-widget m-shadow" style="width: 400px; max-width: 100%;">
					<div style="padding: 1rem;">
						<h4 style="color: #FFBF80; margin-bottom: 1rem;">Current Sessions</h4>
						<div class="container" style="max-width: 100%;">
							<button class="rounded text-center respButton" type="submit" id="submit" name="logout" onclick="logout()" style="margin-bottom: 10px;"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Log this device out</a></button>
							<form method="post">
								<button class="rounded text-center respButton" type="submit" id="submit" name="massLogout"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Log out all your devices</a></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
HTML;

function message($text) {
	echo "<script>let message_con = \"" . $text . "\";</script>";
}

function changePwd($new_pwd) {
	$path = "../user/" . $_COOKIE["mercury_usr"] . "/pwd.txt";
	$pwd_file = fopen($path, "w+");
	$pwd_hash = password_hash($new_pwd, PASSWORD_BCRYPT);
	fwrite($pwd_file, $pwd_hash);
	fclose($pwd_file);
	message("Password changed successfully.");
}

function massLogout() {
	$token_path = "../user/" . $_COOKIE["mercury_usr"] . "/token.txt";
	$n = 20;
	$date = date("Ymd");
	$token = bin2hex(random_bytes($n)) . $date;

	$file = fopen($token_path, "w+");
	fwrite($file, $token);
	fclose($file);

	message("Logged out all devices successfully.");
}

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
			} else if (array_key_exists('massLogout', $_POST)) {
				massLogout();
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