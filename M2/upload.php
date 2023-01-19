<!DOCTYPE html>
<html>
<head><title>Uploading a File</title></head>
<body>

<?php
session_start();
$username = $_SESSION['username'];
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
    header("Location: upload_success.html");
	exit;
}else{
	switch ($_FILES['uploadedfile']['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            break;
        case UPLOAD_ERR_PARTIAL:
            $message = "The uploaded file was only partially uploaded";
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = "No file was uploaded";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $message = "Missing a temporary folder";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $message = "Failed to write file to disk";
            break;
        case UPLOAD_ERR_EXTENSION:
            $message = "File upload stopped by extension";
            break;
        default:
            $message = "Unknown upload error";
            break;
    }
	$_SESSION["error"] = $message;
    header("Location: upload_failure.php");
	exit;
}
//$_SESSION["error"] = 
?>

</body>
</html>