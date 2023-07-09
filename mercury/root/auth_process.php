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

$path = "../admin/blacklist.txt";
$ip_list = file_get_contents($path);

if (str_contains($ip_list, $_SERVER['REMOTE_ADDR'])) {
    http_response_code(403);
    die('<html>
        <head>
        <link rel="SHORTCUT ICON" type="image/x-icon" href="m_icon.png"/>
        <link rel="icon" type="image/x-icon" href="m_icon.png" />
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta http-equiv="content-type" content="text/html" charset="utf-8">
        <title>Mercury - Access Forbidden</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        </head>
        <body class="text-center" style="background-color: #000000;">
        <img src="logo.png" rel="preload" class="rounded" alt="Mercury" height="120">
        <br>
        <br>
        <p><small><code style="color: #FFBF80; animation-name: fade-in; animation-duration: 6s; position: relative;">You have been banned. You can no longer log in.</code></small></p>
        </body>
        ');
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
