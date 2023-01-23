<!DOCTYPE html>
<html lang="en">
<head><title>Uploading File</title></head>
<body>
	<?php
	session_start();

	$filename = (string) basename($_FILES['uploadedfile']['name']);
	if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
        $_SESSION["error"] = "Invalid filename";
        header("Location: upload_failure.php");
		exit;
	}

	$username = (string) $_SESSION['username'];
	if( !preg_match('/^[\w_\-]+$/', $username) ){
        $_SESSION["error"] = "Invalid filename";
        header("Location: upload_failure.php");
		exit;
	}

	$full_path = (string) sprintf("/srv/uploads/%s/%s", $username, $filename);

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
		header("Location: upload_success.html");
		exit;
	}
	else{
		header("Location: upload_failure.php");
		exit;
	}
	?>
</body>
</html>
