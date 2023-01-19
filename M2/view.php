<?php
/*
Most of this code is taken from the CSE330S Wiki for PHP
https://classes.engineering.wustl.edu/cse330/index.php?title=PHP#GET:_Passing_Variables_via_URL 
*/


if(isset($_POST['view'])){
    $filename = $_POST['view'];
    session_start();
    $username = $_SESSION["username"];

    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	    echo "Invalid filename";
	    exit;
    }

// Get the username and make sure that it is alphanumeric with limited other characters.
// You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
// since we will be concatenating the string to load files from the filesystem.
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}

$file_path = "/srv/uploads/" . $username . "/" . $filename;

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file_path);

printf("mime: %s",$mime);

if (file_exists($file_path)) {
    if($mime == 'image/png' || $mime == 'image/jpeg' || $mime == 'image/jpg'){ // If it's an image, display like hmtl
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $contentType = finfo_file($finfo, $file_path);
        finfo_close($finfo);

        header('Content-Type: ' . $contentType);
        readfile($file_path);

        /*echo "<br>";
        printf("filename: %s <br>",$filename);
        printf("path: %s <br>",$file_path);
        printf("path: %s <br>",realpath($file_path));
        printf('<img src = "gary.jpg">');
        printf('<img src = "%s" alt = "Selected Image">',$file_path);*/
    }
    //HTML: <iframe src="path/to/directory/file.pdf" width="800" height="600"></iframe>
   else {
        header('Content-Description: File Transfer');
        header('Content-Type: '.$mime);//.mime_content_type($file_path)
        header('Content-Disposition: inline; filename="'.$filename.'"');//basename($file_path)
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
      //  header("X-Sendfile: $file_path");
        exit;
       // readfile($file_path);
    }
} else {
    printf("File not found.");
    //header('Location: files.php');
}

/*
// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file_path);

// Finally, set the Content-Type header to the MIME type of the file, and display the file.

header("Content-Type: ".$mime);
header('Content-disposition: inline; filename="'.$filename.'";');
readfile($file_path);
*/
}
?>