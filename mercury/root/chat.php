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

$cookie_name = "mercury_auth";

if(isset($_COOKIE[$cookie_name])) {
	if($_COOKIE[$cookie_name] != $token) {
    	echo "<script>window.top.location.href = \"/authentication.html\";</script>";
    }
} else {
	header("Location: /authentication.html");
}

$file = fopen("../raw_msgs.txt", "r");
if(filesize("../raw_msgs.txt") > 0) {
	$content = fread($file,filesize("../raw_msgs.txt"));
	echo nl2br($content);
	fclose($file);
}
?>