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

$cookie_name = "mercury_auth_admin";

if(isset($_COOKIE[$cookie_name])) {
	if($_COOKIE[$cookie_name] != $token) {
		header("Location: /authentication.html");
	}
} else {
	header("Location: /authentication.html");
}

if(array_key_exists('backup', $_POST)) {
	backupChat();
} else if(array_key_exists('clear', $_POST)) {
	clearHistory();
} else if(array_key_exists('success', $_POST)) {
	successfullLogins();
} else if(array_key_exists('failed', $_POST)) {
	failedLogins();
}

// System Storage
$storage_bytes = disk_free_space("/");
$storage_gb = $storage_bytes / 1000000000;
$storage = round($storage_gb, 2);

// Chat Size
$chat_bytes = filesize("../../raw_msgs.txt");
$chat_mb = $chat_bytes / 1000000;
$chat_size = round($chat_mb, 2);

function backupChat() {
	$zip = new ZipArchive;
	$timestamp = date("Y-m-d-H-i-s");
	$filename = "../Backups/backup-" . $timestamp . ".zip";

	copy("../../raw_msgs.txt", "raw_msgs.txt");

	if ($zip->open($filename, ZipArchive::CREATE) === TRUE) {
		$zip->addFile('raw_msgs.txt');
		$zip->close();
	}

	unlink("raw_msgs.txt");
}

function clearHistory() {
	file_put_contents('../../raw_msgs.txt', '');
}

function successfullLogins() {
	header("Content-Type: application/csv");
	header("Content-Disposition: attachment; filename=success_login.csv");
	header("Content-Length: ". filesize("../Logs/success_login.csv"));
	readfile("../Logs/success_login.csv");
}

function failedLogins() {
	header("Content-Type: application/csv");
	header("Content-Disposition: attachment; filename=fail_login.csv");
	header("Content-Length: ". filesize("../Logs/fail_login.csv"));
	readfile("../Logs/fail_login.csv");
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
	</script>
</head>

<body style="background-color: #000000;">
	<br>
	<div class="text-center">
		<img src="logo.png" rel="preload" onclick="copyright_date()" class="rounded" alt="Mercury" height="10%" style="animation-name: fade-in; animation-duration: 3s; position: relative;">
	</div>
	<br>
	<div class="container">
		<div style="display: flex; flex-flow: wrap;">
			<div style="max-width: 100%">
				<h4 style="color: #FFBF80;">Server Status</h4>
				<div class="container" style="width: 500px; max-width: 100%">
					<p class="text-secondary">System Storage: <b><?php echo $storage; ?> GB</b></p>
					<p class="text-secondary">Chat Size: <b><?php echo $chat_size; ?> MB</b></p>
				</div>
				<br>
				<h4 style="color: #FFBF80;">Conversation</h4>
				<div class="container" style="width: 500px; max-width: 100%">
					<form method="post">
						<button class="rounded text-center respButton" type="submit" id="submit" name="backup" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Backup Chat</button>
					</form>
				</div>
				<div class="container" style="width: 500px; max-width: 100%">
					<form method="post">
						<button class="rounded text-center respButton" type="submit" id="submit" name="clear" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Clear History</button>
					</form>
				</div>
				<br>
			</div>
			<div style="max-width: 100%">
				<h4 style="color: #FFBF80;">User</h4>
				<div class="container" style="width: 500px; max-width: 100%">
					<form method="post">
						<button class="rounded text-center respButton" type="submit" id="submit" name="success" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Download Successfull Logins (150 Max.)</button>
					</form>
				</div>
				<div class="container" style="width: 500px; max-width: 100%">
					<form method="post">
						<button class="rounded text-center respButton" type="submit" id="submit" name="failed" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Download Failed Login Attempts (100 Max.)</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container text-center text-muted">
		<footer id="copyright" style="cursor: pointer;"></footer>
	</div>
</body>
</html>
