<?php
session_start();
if (isset($_COOKIE["mercury_usr"]) && isset($_COOKIE["mercury_auth"])) {
    if (isset($_SESSION['chat'])) {
        $chat = $_SESSION['chat'];
    }
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

$msg = $_POST["message"];

if($msg != "") {
    $msg = str_replace("&", "&amp;", $msg);
    $msg = str_replace("<", "&lt;", $msg);
    $msg = str_replace(">", "&gt;", $msg);

    $nick_name = $_COOKIE["mercury_usr"];
    $message = "<sub>" . date("H:i") . " </sub>" . "<b>" . $nick_name . "</b> <i>" . $msg . "</i>\n";
    $file = fopen("../chats/$chat", "a");
    fwrite($file, $message);
    fclose($file);
}
?>