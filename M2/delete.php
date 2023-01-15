<!DOCTYPE html>
<html>
<head><title>Delete a File</title></head>
<body>

<?php

if(isset($_POST['delete'])){
    $filename = $_POST['delete'];
    session_start();
    $username = $_SESSION["username"];
    $filepath = '/srv/uploads/'.$username ;
    $file = $filepath . '/'  . $filename;
    printf($file);
    if (file_exists($file)){
        unlink($file);
    }
    header("Location: delete_success.html");

}
?>
</body>
</html>