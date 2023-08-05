<?php
$passwd = $_POST['pwd'];
$token_file = fopen("../token.txt", "r");
$token = fread($token_file,filesize("../token.txt"));
$n = 20;
$date = date("Ymd");

if (str_contains($token, $date)) {
    fclose($token_file);
} else {
    fclose($token_file);
    $token_file = fopen("../token.txt", "w+");
    $token = bin2hex(random_bytes($n)) . $date;
    fwrite($token_file, $token);
    fclose($token_file);
}

$pwd_file = fopen("../pwd.txt", "r");
$passwd_r = fread($pwd_file,filesize("../pwd.txt"));

if ($passwd == $passwd_r) {
    setcookie("mercury_auth_admin", $token);
    header("Location: /index.php");
} else {
    echo "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC\" crossorigin=\"anonymous\"><div class=\"text-center\"><p class=\"h1\">ACCESS FORBIDDEN</p><br><img src=\"https://www.cursor.cc/cursor3d/80683.png\"></div>";
}
?>
