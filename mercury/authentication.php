<html>
<head>
  <link rel="SHORTCUT ICON" type="image/x-icon" href="m_icon.png"/>
  <link rel="icon" type="image/x-icon" href="m_icon.png" />

  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta http-equiv="content-type" content="text/html" charset="utf-8">

  <meta name="author" content="90N45">
  <meta name="description" content="Mercury - Web Messanger">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    @keyframes fade-in {
      0% {opacity: 0.0;}
      100% {opacity: 1;}
    }

    @keyframes slide-in {
      0% {opacity: 0.0; top: -100px;}
      100% {opacity: 1; top: 0px;}
    }
  </style>

  <script type="text/javascript">
    function copyright_date() {
      let date =  new Date().getFullYear();
      document.getElementById("copyright").innerHTML = "<p style=\"animation-name: fade-in; animation-duration: 3s;\"> &copy; " + date + " 90N45<br>All rights reserved. </p>";
    }
  </script>
</head>

<body style="background-color: #000000;">
  <br>
  <div class="text-center">
    <img src="logo.png" onclick="copyright_date()" class="rounded" alt="Mercury" height="120" style="animation-name: fade-in; animation-duration: 3s; position: relative;">
  </div>
  <br>
  <div class="form-group text-center">
    <form method="post" action="auth_process.php">
      <input type="password" id="pwd" name="pwd" placeholder="🔑" class="text-center" style="color: #FFBF80; background-color: #000000; border: none; outline: none; cursor: default; caret-color: transparent; animation-name: slide-in; animation-duration: 1.5s; position: relative;">
    </form>
  </div>
  <br>
  <div class="container text-center text-muted">
    <footer id="copyright" style="cursor: pointer;"></footer>
  </div>
</html>
