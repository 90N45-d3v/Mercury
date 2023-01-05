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

if($_COOKIE[$cookie_name] != $token) {
    header("Location: /authentication.html");
} else {
    $msg_location = "message";
    $message = "[" . date("H:i") . "] ". $_POST[$msg_location] . "\n";
    $file = fopen("../raw_msgs.txt", "a");
    fwrite($file, $message);
    fclose($file);
}
?>
