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
    $path = "../admin/Logs/success_login.csv";

    if (count(file($path)) == 150) {
        $log = file_get_contents($path);
        $new = substr($log, strpos($log, "\n")+1);
        file_put_contents($path, $new);
    }

    $date = date("Y.m.d");
    $time = date("H:i:s");

    $log = file_get_contents($path);
    $log .= $date . "," . $time . "," . $_SERVER['REMOTE_ADDR'] . ",\"" . $_SERVER['REMOTE_HOST'] . "\",\"" . $_SERVER['HTTP_USER_AGENT'] . "\"\n";
    file_put_contents($path, $log);

    setcookie("mercury_auth", $token);
    header("Location: /index.php");
} else {
    $path = "../admin/Logs/fail_login.csv";

    if (count(file($path)) == 100) {
        $log = file_get_contents($path);
        $new = substr($log, strpos($log, "\n")+1);
        file_put_contents($path, $new);
    }

    $date = date("Y.m.d");
    $time = date("H:i:s");

    $log = file_get_contents($path);
    $log .= $date . "," . $time . "," . $_SERVER['REMOTE_ADDR'] . ",\"" . $_SERVER['REMOTE_HOST'] . "\",\"" . $_SERVER['HTTP_USER_AGENT'] . "\"\n";
    file_put_contents($path, $log);

    header("Location: /authentication.html");
}
?>
