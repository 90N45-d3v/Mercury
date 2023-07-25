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

$file = fopen("../raw_msgs.txt", "r");
if(filesize("../raw_msgs.txt") > 0) {
	$content = fread($file,filesize("../raw_msgs.txt"));
	echo nl2br($content);
	fclose($file);
}
?>