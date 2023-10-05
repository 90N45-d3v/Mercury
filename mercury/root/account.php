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

function message($text) {
	echo "<script>let message_con = \"" . $text . "\";</script>";
}

function changePwd($new_pwd) {
	$path = "../user/" . $_COOKIE["mercury_usr"] . "/pwd.txt";
    $file = fopen($path, "w+");
    fwrite($file, $new_pwd);
    fclose($file);
	message("Password changed successfully.");
}

function logout() {
	setcookie("mercury_usr", "", time() - 3600);
	setcookie("mercury_auth", "", time() - 3600);
	message("Logged out successfully.");
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
?>
<html>
<head>
	<link rel="SHORTCUT ICON" type="image/x-icon" href="m_icon.png"/>
	<link rel="icon" type="image/x-icon" href="m_icon.png" />

	<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
	<meta http-equiv="content-type" content="text/html" charset="utf-8">

	<meta name="author" content="90N45">
	<meta name="description" content="Mercury - Web-Based Communication System">
	<title>Mercury - Admin's Dashboard</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

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

		@keyframes slide-in-left {
			0% {opacity: 0.0; top: -1000px}
			100% {opacity: 1; top: 0px}
		}

		.opacity-out {
			-webkit-mask-image: linear-gradient(to top, black 80%, transparent 100%);
			mask-image: linear-gradient(to top, black 80%, transparent 100%);
		}

		.respButton {
			color: #6c757d;
		}

		.respButton:hover {
			color: #FFBF80;
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script type="text/javascript">
		function copyright_date() {
			let date =  new Date().getFullYear();
			document.getElementById("copyright").innerHTML = "<p style=\"animation-name: fade-in; animation-duration: 3s;\"> &copy; " + date + " 90N45<br>All rights reserved. </p>";
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
			let message = '<div class="alert alert-dark alert-dismissible fade show" role="alert" style="position: fixed; top: 1vw; margin-left: 1.5vw; margin-right: 1.5vw; animation-name: slide-in-left; animation-duration: 1.5s; color: #FFBF80; background-color: #1a1a1a;" id="systemMsg">' + text + '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>'
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
				} else if (message_con == "Logged out successfully.") {
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
	<br>
	<div class="text-center">
		<img src="logo.png" rel="preload" onclick="copyright_date()" class="rounded" alt="Mercury" height="10%" style="">
	</div>
	<br>
	<div class="container">
		<div style="display: flex; flex-flow: wrap;">
			<div style="max-width: 100%">
				<h4 style="color: #FFBF80;">Login Credentials</h4>
				<div class="container" style="max-width: 100%">
					<form method="post" id="changePwd">
						<input class="rounded text-center" type="password" id="pwd0" name="pwd0" placeholder="Password" class="text-center" style="color: #FFBF80; background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-right: 5px; margin-bottom: 5px;">
						<button class="rounded text-center respButton" type="button" id="button" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-bottom: 5px;" onclick="changePwd()">OK</button>
						<br id="UserPwdInputBreak">
						<input class="rounded text-center" type="password" id="pwd1" name="pwd1" placeholder="Repeat Password" class="text-center" style="color: #FFBF80; background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-right: 5px; margin-bottom: 5px;">
					</form>
				</div>
				<br>
				<h4 style="color: #FFBF80;">Current Sessions</h4>
				<div class="container" style="max-width: 100%">
					<form method="post">
						<button class="rounded text-center respButton" type="submit" id="submit" name="logout" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Log this device out</button>
					</form>
					<form method="post">
						<button class="rounded text-center respButton" type="submit" id="submit" name="massLogout" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Log out all devices that are currently online</button>
					</form>
				</div>
			</div>
		</div>
		<div class="container text-center">
			<button class="rounded text-center" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;"><a class="respButton" style="text-decoration: none;" href="index.php">Back</a></button>
		</div>
	</div>
	<div class="container text-center text-muted">
		<footer id="copyright" style="cursor: pointer;"></footer>
	</div>
</body>
</html>
