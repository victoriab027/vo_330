<!DOCTYPE html>
<html>
<head><title>Uploading a File</title></head>
<body>

<?php
session_start();
$username = $_SESSION['username'];
//printf("Username = %s<br>",$username);
// Get the filename and make sure it is valid
$filename = basename($_FILES['uploadedfile']['name']);
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
    $_SESSION["error"] = "Invalid filename";
	header("Location: upload_failure.php");
    exit;
}

// Get the username and make sure it is valid
$username = $_SESSION['username'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	$_SESSION["error"] = "Invalid username";
	header("Location: upload_failure.php");
    exit;
}

$full_path = sprintf("/srv/uploads/%s/%s", $username, $filename);

if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
	//printf("Upload SUCCESS");
    header("Location: upload_success.html");
	exit;
}else{
	//printf("Upload FAILED");
    header("Location: upload_failure.php");
	exit;
}
?>

</body>
</html>