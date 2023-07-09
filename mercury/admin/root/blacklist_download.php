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

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=blacklist.txt");
header("Content-Length: ". filesize("../blacklist.txt"));
readfile("../blacklist.txt");
?>