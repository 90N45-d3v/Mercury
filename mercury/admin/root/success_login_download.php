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
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment; filename=success_login.csv");
		header("Content-Length: ". filesize("../Logs/success_login.csv"));
		readfile("../Logs/success_login.csv");
	}
} else {
	header("Location: /authentication.html");
}
?>