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

if ($passwd == "mercury") {
    setcookie("mercury_auth", $token);
    header("Location: /index.php");
} else {
    echo "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC\" crossorigin=\"anonymous\"><div class=\"text-center\"><p class=\"h1\">ACCESS FORBIDDEN</p><br><img src=\"https://www.cursor.cc/cursor3d/80683.png\"></div>";
}
?>
