<?php
$token = "22ed7f2bdd3fa4c20cbac4356a7db51583afa4ff7a2ae35ad3f091f4d65b478581edda9e832194a24c04c3b55be8888d16eb4670c7ce8f1c8663e1fe6f999e0d";
$cookie_name = "mercury_auth";
$msg_location = "message";

if($_COOKIE[$cookie_name] != $token) {
    header("Location: /authentication.php");
} else {
    $message = $_POST[$msg_location] . "\n";
    $file = fopen("raw_msgs.txt", "a");
    fwrite($file, $message);
}
?>
