<?php
$file = fopen("../token.txt", "r");
$token = fread($file,filesize("../token.txt"));
date_default_timezone_set("Europe/Berlin");
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
    $msg = $_POST["message"];

    if($msg != "") {
        $nick_name = $_POST["nickname"];
        if($nick_name == "") {
            $nick_name = "Guest";
        }
        $message = "<sub>" . date("H:i") . " </sub>" . "<b>" . $nick_name . "</b> <i>" . $msg . "</i>\n";
        $file = fopen("../raw_msgs.txt", "a");
        fwrite($file, $message);
        fclose($file);
    }
}
?>