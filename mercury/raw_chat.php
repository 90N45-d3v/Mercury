<?php
$token = "22ed7f2bdd3fa4c20cbac4356a7db51583afa4ff7a2ae35ad3f091f4d65b478581edda9e832194a24c04c3b55be8888d16eb4670c7ce8f1c8663e1fe6f999e0d";
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
				$file = fopen("raw_msgs.txt", "r");
				if(filesize("raw_msgs.txt") > 0) {
					$content = fread($file,filesize("raw_msgs.txt"));
					echo nl2br($content);
					fclose($file);
				}
				?>
			</code>
	</div>
</html>
