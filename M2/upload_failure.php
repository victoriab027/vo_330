<!DOCTYPE html>
<html>
<head><title>Upload Failure</title></head>
<body>
<h2>Upload Failed!</h2>
<?php
 session_start();
$printer = (string) $_SESSION["error"];
printf("The error was: <strong>%s</strong><br><br>",$printer)
?>
<p>What would you like to do now?</p>
<form id = "menu" action = "upload_result.php" method="POST">
    <input type="radio" name="menu" value="return" id = "return" checked="">
        <label for="return">Return to User Profile</label><br>
    <input type="radio" name="menu" value="logout" id = "logout">
         <label for="logout">Logout</label><br>
    <input type="submit" value="Submit" />
</form>

</body>
</html>
