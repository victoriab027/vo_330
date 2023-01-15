<?php
require 'database.php';

if(isset($_POST['username']) ){
    $username = $_POST['username'];
    $users = fopen("users.txt", "r");
    $isAUser = false;
    while (($line = fgets($users)) !== false) {
        if ($username == trim($line)) {
            $isAUser = true;
            break;
        }
    }
    fclose($users);
}
 if($isAUser){//is a valid user
    session_start();
    $_SESSION["username"] = $username;
    header("Location: files.php?username=$username");
    exit;   // we call exit here so that the script will stop executing before the connection is broken
   // session_destroy();
}
    else {
        printf("<p><strong>%s</strong> is not a valid username</p>\n",
		htmlentities($_POST['username']));
        $page = 'login.html';
    echo "<button onclick='location.href = \"$page\";'>Log back in</button>";
    }

?>