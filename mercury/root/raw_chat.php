<?php
$file = fopen("../token.txt", "r");
$token = fread($file,filesize("../token.txt"));
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
}
?>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script type="text/javascript">
		function update(){ 
    		location.reload()
    		console.log("Reloaded chat.");
    	}
		setInterval(update, 2000);
	</script>
</head>

<body style="background-color: #1a1a1a;">
	<div style="margin: 10px;">
			<code style="color: #FFBF80;">
				<?php
				$file = fopen("../raw_msgs.txt", "r");
				if(filesize("../raw_msgs.txt") > 0) {
					$content = fread($file,filesize("../raw_msgs.txt"));
					echo nl2br($content);
					fclose($file);
				}
				?>
			</code>
	</div>
</html>
