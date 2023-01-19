<!DOCTYPE html>
<html>
<head><title>File Viewing</title></head>
<body>

<?php
if(isset($_POST['view'])){
    $filename = $_POST['view'];
    session_start();
    $username = $_SESSION["username"];
    printf("filename: %s", $filename);

    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	    echo "Invalid filename";
	    exit;
    }

// Get the username and make sure that it is alphanumeric with limited other characters.
// You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
// since we will be concatenating the string to load files from the filesystem.
$username = $_SESSION['username'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}
printf("filename: %s", $filename);

$full_path = sprintf("/srv/uploads/%s/%s", $username, $filename);

// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($full_path);

// Finally, set the Content-Type header to the MIME type of the file, and display the file.
/*header("Content-Type: ".$mime);
header('content-disposition: inline; filename="'.$filename.'";');
readfile($full_path);*/

}
?>
</body>
</html>