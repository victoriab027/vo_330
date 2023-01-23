<!DOCTYPE html>
<html>
<head><title>Upload Return</title></head>
<body>

<?php
if(isset($_POST['menu'])){
    $val = (string) $_POST['menu'];
    if($val == "return"){
        session_start();
        $username = $_SESSION["username"];
        header("Location: files.php?username=$username");
    }
    else if ($val == "logout"){
        //$url = "ec2-52-15-183-223.us-east-2.compute.amazonaws.com/logout.php";
        header("Location: logout.php");
    }
    
}
?>
</body>
</html>