<!DOCTYPE html>
<html>
<head><title>Logout Page</title></head>
<body>
<?php
session_start();
$username = $_SESSION["username"];
printf("<h1>Goodbye %s!</h1>\n",
	    htmlentities($username));
//sleep(3000);//delay before returning to the home page

$page = 'login.html';
echo "<button onclick='location.href = \"$page\";'>Log back in</button>";
destory_session();
?>

</body>
</html>