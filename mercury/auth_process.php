<?php
$token = "22ed7f2bdd3fa4c20cbac4356a7db51583afa4ff7a2ae35ad3f091f4d65b478581edda9e832194a24c04c3b55be8888d16eb4670c7ce8f1c8663e1fe6f999e0d";
$passwd = $_POST['pwd'];

if ($passwd == "mercury") {
    setcookie("mercury_auth", $token);
    header("Location: /index.php");
} else {
    echo "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC\" crossorigin=\"anonymous\"><div class=\"text-center\"><p class=\"h1\">ACCESS FORBIDDEN</p><br><img src=\"https://www.cursor.cc/cursor3d/80683.png\"></div>";
}
?>
