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
	} else {

		// System Storage
		$storage_bytes = disk_free_space("/");
		$storage_gb = $storage_bytes / 1000000000;
		$storage = round($storage_gb, 2);

		// Chat Size
		$chat_bytes = filesize("../../raw_msgs.txt");
		$chat_mb = $chat_bytes / 1000000;
		$chat_size = round($chat_mb, 2);

		function message($text) {
			echo "<script>let message_con = \"" . $text . "\";</script>";
		}

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

			message("Chat backed up successfully as backup-" . $timestamp . ".zip");
		}

		function clearHistory() {
			file_put_contents('../../raw_msgs.txt', '');
			message("History cleared successfully.");
		}

		function addIP($ip) {
			$path = "../blacklist.txt";
			$list = file_get_contents($path);

			if (str_contains($list, $ip) != true) {
				$list .= $ip . "\n";
				file_put_contents($path, $list);
			}

			message("Added IP successfully: " . $ip);
		}

		function removeIP($ip) {
			$path = "../blacklist.txt";
			$list = file_get_contents($path);

			$list = str_replace($ip . "\n", "", $list);
			file_put_contents($path, $list);

			message("Removed IP successfully: " . $ip);
		}

		function addUser($username, $pwd) {
			$user_path = "../../user/" . $username;
			if (file_exists($user_path) != true) {
				mkdir($user_path);
				$pwd_file = fopen($user_path . "/pwd.txt", "w");
				fwrite($pwd_file, $pwd);
				fclose($pwd_file);

				$token_file = fopen($user_path . "/token.txt", "w");
				$n = 20;
				$date = date("Ymd");
				$token = bin2hex(random_bytes($n)) . $date;
				fwrite($token_file, $token);
				fclose($token_file);

				message("New user registered successfully: " . $username);
			} else {
				message("<b>FAIL: </b>You tried to create an already existing user.");
			}
		}

		function removeUser($username) {
			$user_path = "../../user/" . $username;
			if (file_exists($user_path)) {
				$files = glob($user_path ."/*");
				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					}
				}

				rmdir($user_path);

				message("User deleted successfully: " . $username);
			} else {
				message("<b>FAIL: </b>User didn't exist: " . $username);
			}
		}

		function changeAdminPwd($new_pwd) {
		    $file = fopen("../pwd.txt", "w+");
		    fwrite($file, $new_pwd);
		    fclose($file);
			message("Admin's password changed successfully.");
		}

		if (array_key_exists('backup', $_POST)) {
			backupChat();

		} else if (array_key_exists('clear', $_POST)) {
			clearHistory();

		} else if (array_key_exists('ip_restr', $_POST)) {
			if ($_POST['ip_restr'] == "add") {
				addIP($_POST['ip']);
			} else if ($_POST['ip_restr'] == "rm") {
				removeIP($_POST['ip']);
			}

		} else if (array_key_exists('rm_ip', $_POST)) {
			removeIP($_POST['ip']);

		} else if (array_key_exists('user_mgmt', $_POST)) {
			if ($_POST['user_mgmt'] == "add") {
				addUser($_POST['username'], $_POST['UserPwdInput']);
			} else if ($_POST['user_mgmt'] == "rm") {
				removeUser($_POST['username']);
			}

		} else if (array_key_exists('pwd0', $_POST)) {
			if (array_key_exists('pwd1', $_POST)) {
				if ($_POST['pwd0'] == $_POST['pwd1']) {
					changeAdminPwd($_POST['pwd0']);
				} else {
					message("<b>FAIL: </b>To change the admin password, both entries must be equal.");
				}
			}
		}

		$content = <<< HTML
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

				input[type='radio'] {
				    accent-color: #FFBF80;
				}

				.confirmText {
					color: #FFBF80;
					background-color: #000000;
				}
			</style>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
			<script type="text/javascript">
				function copyright_date() {
					let date =  new Date().getFullYear();
					document.getElementById("copyright").innerHTML = "<p style=\"animation-name: fade-in; animation-duration: 3s;\"> &copy; " + date + " 90N45<br>All rights reserved. </p>";
				}

				function togglePwdInput(bool) {
					if (bool === true) {
						document.getElementById("UserPwdInput").hidden = false;
						document.getElementById("UserPwdInput").required = true;
						document.getElementById("UserPwdInputBreak").hidden = false;
					} else {
						document.getElementById("UserPwdInput").hidden = true;
						document.getElementById("UserPwdInput").required = false;
						document.getElementById("UserPwdInputBreak").hidden = true;
					}
				}

				function changeAdminPwd() {
					val0 = document.getElementById("pwd0").value;
					val1 = document.getElementById("pwd1").value;

					if (val0 != val1) {
						message("<b>FAIL: </b>To change the admin password, both entries must be equal.")
					} else if (val0 == "") {
						message("<b>FAIL: </b>To change the admin password, you must enter a new one.")
					} else {
						document.getElementById("changeAdminPwd").submit();
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
						message(message_con);
						setTimeout(closeMessage, 10000);
					}
				});

			</script>
		</head>

		<body style="background-color: #000000;">
			<br>
			<div class="text-center">
				<img src="logo.png" rel="preload" onclick="copyright_date()" class="rounded" alt="Mercury" height="10%">
			</div>
			<br>
			<div class="container">
				<div style="display: flex; flex-flow: wrap; justify-content: space-between;">
					<div style="max-width: 100%">
						<h4 style="color: #FFBF80;">Server Status</h4>
						<div class="container" style="max-width: 100%">
							<p class="text-secondary">System Storage: <b>{$storage} GB</b></p>
							<p class="text-secondary">Chat Size: <b>{$chat_size} MB</b></p>
						</div>
						<br>
						<h4 style="color: #FFBF80;">IP Restriction</h4>
						<div class="container" style="max-width: 100%">
							<form method="post" style="margin-bottom: 35px;">
								<input class="rounded text-center" type="text" id="ip" name="ip" placeholder="IP Address" class="text-center" style="color: #FFBF80; background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;" onkeyup="" required>
								<button class="rounded text-center respButton" type="submit" id="submit" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-bottom: 15px;">OK</button>
								<br>
								<input type="radio" name="ip_restr" value="add" checked>
								<label for="age1" class="text-secondary">Block</label><br>
								<input type="radio" name="ip_restr" value="rm">
								<label for="age1" class="text-secondary">Unblock</label>
							</form>
							<form method="post" action="blacklist_download.php">
								<button class="rounded text-center respButton" type="submit" id="submit" name="ip_list" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Download Blocked IP List</button>
							</form>
						</div>
						<br>
						<h4 style="color: #FFBF80;">Logins</h4>
						<div class="container" style="max-width: 100%">
							<form method="post" action="success_login_download.php">
								<button class="rounded text-center respButton" type="submit" id="submit" name="success" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Download Successfull Logins (1250 Max.)</button>
							</form>
							<form method="post" action="fail_login_download.php">
								<button class="rounded text-center respButton" type="submit" id="submit" name="failed" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Download Failed Login Attempts (1250 Max.)</button>
							</form>
						</div>
						<br>
					</div>
					<div style="max-width: 100%">
						<h4 style="color: #FFBF80;">User Management</h4>
						<div class="container" style="max-width: 100%">
							<form method="post">
								<input class="rounded text-center" type="text" id="username" name="username" placeholder="Username" class="text-center" style="color: #FFBF80; background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-right: 5px;" onkeyup="" required>
								<button class="rounded text-center respButton" type="submit" id="submit" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-bottom: 5px;">OK</button>
								<br id="UserPwdInputBreak">
								<input class="rounded text-center" type="password" id="UserPwdInput" name="UserPwdInput" placeholder="Password" class="text-center" style="color: #FFBF80; background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;" onkeyup="" required>
								<br>
								<input type="radio" id="user_mgmt" name="user_mgmt" value="add" onclick="togglePwdInput(true)" style="margin-top: 15px;" checked>
								<label for="age1" class="text-secondary">Add this account</label><br>
								<input type="radio" id="user_mgmt" name="user_mgmt" value="rm" onclick="togglePwdInput(false)">
								<label for="age1" class="text-secondary">Remove this account</label>
							</form>
						</div>
						<br>
						<h4 style="color: #FFBF80;">Conversation</h4>
						<div class="container" style="max-width: 100%">
							<form method="post">
								<button class="rounded text-center respButton" type="submit" id="submit" name="backup" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Backup Chat</button>
							</form>
						</div>
						<div class="container" style="max-width: 100%">
							<form method="post">
								<button class="rounded text-center respButton" type="submit" id="submit" name="clear" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80;">Clear History</button>
							</form>
						</div>
						<br>
					</div>
					<div style="max-width: 100%">
						<h4 style="color: #FFBF80;">Admin's Login</h4>
						<div class="container" style="max-width: 100%">
							<form method="post" id="changeAdminPwd">
								<input class="rounded text-center" type="password" id="pwd0" name="pwd0" placeholder="Password" class="text-center" style="color: #FFBF80; background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-right: 5px; margin-bottom: 5px;">
								<button class="rounded text-center respButton" type="button" id="button" style="background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-bottom: 5px;" onclick="changeAdminPwd()">OK</button>
								<br id="UserPwdInputBreak">
								<input class="rounded text-center" type="password" id="pwd1" name="pwd1" placeholder="Repeat Password" class="text-center" style="color: #FFBF80; background-color: #000000; border-color: #1a1a1a; border-style: solid; outline-color: #FFBF80; margin-right: 5px; margin-bottom: 5px;">
							</form>
						</div>
						<br>
					</div>
				</div>
			</div>
			<div class="container text-center text-muted">
				<footer id="copyright" style="cursor: pointer;"></footer>
			</div>
		</body>
		</html>
		HTML;

		echo $content;
	}
} else {
	header("Location: /authentication.html");
}
?>