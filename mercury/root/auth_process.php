<?php
$passwd = $_POST['pwd'];
$file = fopen("../token.txt", "r");
$token = fread($file,filesize("../token.txt"));
$n = 20;
$date = date("Ymd");

if (str_contains($token, $date)) {
    fclose($file);
} else {
    fclose($file);
    $file = fopen("../token.txt", "w+");
    $token = bin2hex(random_bytes($n)) . $date;
    fwrite($file, $token);
    fclose($file);
}

if ($passwd == "doritos") {
    setcookie("mercury_auth", $token);
    header("Location: /index.php");
} else {
    header("Location: /authentication.html");
}
?>
