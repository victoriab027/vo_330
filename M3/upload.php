<!--
    This file exectues the upload.html image upload form. It reads the input and adds it to the user's profile_picture
    column and row in the database. These are stored as BLOBS.
-->
<?php 
// Include the database configuration file  
require 'database.php'; 
session_start();
$username = $_SESSION['username'];
 
// If file upload form is submitted 
if(isset($_POST["submit"])){ 
    // Read the image file into a binary string
    $data = file_get_contents($_FILES['image']['tmp_name']);

    // Escape the binary string for use in the SQL statement
    $escaped = mysqli_real_escape_string($mysqli, $data);

    // Update the image in the table
    $sql = "UPDATE users SET profile_picture = '$escaped' WHERE username = '$username'";
    if (mysqli_query($mysqli, $sql)) {
        mysqli_close($msqli);
        header("Location: profile.php");
        exit;
    } else {
        echo "Error updating picture: " . mysqli_error($mysqli);
    }
} 
mysqli_close($msqli);
?>