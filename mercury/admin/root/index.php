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
				$pwd_hash = password_hash($pwd, PASSWORD_BCRYPT);
				fwrite($pwd_file, $pwd_hash);
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
		    $new_pwd_hash = password_hash($new_pwd, PASSWORD_BCRYPT);
		    fwrite($file, $new_pwd_hash);
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

				input[type='radio'] {
				    accent-color: #FFBF80;
				}

				.confirmText {
					color: #FFBF80;
					background-color: #000000;
				}

				.respButton {
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

					width: 400px;
					max-width: 100%;
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
					document.cookie = "mercury_auth_admin=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
					message("Logged out successfully.");
					setTimeout(auth_redirect, 5000);
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
					let message = '<div class="alert alert-dark alert-dismissible fade show m-outline" role="alert" style="border: none; z-index: 9999; position: fixed; top: 1vw; margin-left: 1.5vw; margin-right: 1.5vw; animation-name: slide-in-left; animation-duration: 1.5s; color: #FFBF80; background-color: #1a1a1a;" id="systemMsg">' + text + '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>'
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
				<div style="display: flex; flex-flow: wrap; justify-content: space-between;">
					<div style="max-width: 100%">
						<div class="rounded m-widget">
							<div style="padding: 1rem;">
								<h4 style="color: #FFBF80; margin-bottom: 1rem;">Server Status</h4>
								<div class="container" style="max-width: 100%">
									<p class="text-secondary">System Storage: <b>{$storage} GB</b></p>
									<p class="text-secondary">Chat Size: <b>{$chat_size} MB</b></p>
								</div>
							</div>
						</div>
						<br>
						<div class="rounded m-widget">
							<div style="padding: 1rem;">
								<h4 style="color: #FFBF80; margin-bottom: 1rem;">User Management</h4>
								<div class="container" style="max-width: 100%">
									<form method="post">
										<input class="rounded respTextInput text-center" type="text" id="username" name="username" placeholder="Username" class="text-center" style="margin-right: 5px; margin-bottom: 10px;" required>
										<button class="rounded text-center respButton" type="submit" id="submit"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">OK</a></button>
										<br id="UserPwdInputBreak">
										<input class="rounded respTextInput text-center" type="password" id="UserPwdInput" name="UserPwdInput" placeholder="Password" class="text-center" style="margin-bottom: 10px;" required>
										<br>
										<input type="radio" id="user_mgmt" name="user_mgmt" value="add" onclick="togglePwdInput(true)" style="margin-top: 5px;" checked>
										<label for="age1" class="text-secondary">Add this account</label><br>
										<input type="radio" id="user_mgmt" name="user_mgmt" value="rm" onclick="togglePwdInput(false)">
										<label for="age1" class="text-secondary">Remove this account</label>
									</form>
								</div>
							</div>
						</div>
						<br>
					</div>
					<div style="max-width: 100%">
						<div class="rounded m-widget">
							<div style="padding: 1rem;">
								<h4 style="color: #FFBF80; margin-bottom: 1rem;">IP Restriction</h4>
								<div class="container" style="max-width: 100%">
									<form method="post" style="margin-bottom: 35px;">
										<input class="rounded respTextInput text-center" type="text" id="ip" name="ip" placeholder="IP Address" class="text-center" style="margin-right: 5px; margin-bottom: 10px;" required>
										<button class="rounded text-center respButton" type="submit" id="submit"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">OK</a></button>
										<br>
										<input type="radio" name="ip_restr" value="add" checked>
										<label for="age1" class="text-secondary">Block</label><br>
										<input type="radio" name="ip_restr" value="rm">
										<label for="age1" class="text-secondary">Unblock</label>
									</form>
									<form method="post" action="blacklist_download.php">
										<button class="rounded text-center respButton" type="submit" id="submit" name="ip_list"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Download Blocked IP List</a></button>
									</form>
								</div>
							</div>
						</div>
						<br>
						<div class="rounded m-widget">
							<div style="padding: 1rem;">
								<h4 style="color: #FFBF80; margin-bottom: 1rem;">Logins</h4>
								<div class="container" style="max-width: 100%">
									<form method="post" action="success_login_download.php" style="margin-bottom: 10px;">
										<button class="rounded text-center respButton" type="submit" id="submit" name="success"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Download Successfull Logins</a></button>
									</form>
									<form method="post" action="fail_login_download.php">
										<button class="rounded text-center respButton" type="submit" id="submit" name="failed"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Download Failed Login Attempts</a></button>
									</form>
								</div>
							</div>
						</div>
						<br>
					</div>
					<div style="max-width: 100%">
						<div class="rounded m-widget">
							<div style="padding: 1rem;">
								<h4 style="color: #FFBF80; margin-bottom: 1rem;">Conversation</h4>
								<div class="container" style="max-width: 100%">
									<form method="post">
										<button class="rounded text-center respButton" type="submit" id="submit" name="backup"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Backup Chat</a></button>
									</form>
								</div>
								<div class="container" style="max-width: 100%">
									<form method="post">
										<button class="rounded text-center respButton" type="submit" id="submit" name="clear"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">Clear History</a></button>
									</form>
								</div>
							</div>
						</div>
						<br>
						<div class="rounded m-widget">
							<div style="padding: 1rem;">
								<h4 style="color: #FFBF80; margin-bottom: 1rem;">Admin's Login</h4>
								<div class="container" style="max-width: 100%">
									<form method="post" id="changeAdminPwd">
										<input class="rounded respTextInput text-center" type="password" id="pwd0" name="pwd0" placeholder="Password" class="text-center" style="margin-right: 5px; margin-bottom: 10px;">
										<button class="rounded text-center respButton" type="button" id="button" onclick="changeAdminPwd()"><a style="margin-left: 0.8rem; margin-right: 0.8rem;">OK</a></button>
										<br id="UserPwdInputBreak">
										<input class="rounded respTextInput text-center" type="password" id="pwd1" name="pwd1" placeholder="Repeat Password" class="text-center" style="margin-right: 5px; margin-bottom: 5px;">
									</form>
								</div>
							</div>
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