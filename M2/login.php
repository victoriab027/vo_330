<?php
#ensure that the database is connected
# check if the username is sent (via post) 
if(isset($_POST['username']) ){
    # if so create a variable pointing to the inputted username
    $username = (string) $_POST['username'];
    # open users.txt and loop through the file
    ///srv/uploads/%s/%s
    $users = fopen("/srv/users.txt", "r");
    $isAUser = false;
    while (($line = fgets($users)) !== false) {
        if ($username == trim($line)) {
            $isAUser = true;
            break;
            # check if the user is a user and if so sest the helper var to true and break loop
        }
    }
    fclose($users);
}
 if($isAUser){//true if username is a valid user
    session_start(); //start session in order to pass the username as a session variable
    $_SESSION["username"] = $username;
    header("Location: files.php?username=$username");
    exit;   // we call exit here so that the script will stop executing before the connection is broken
}
    else { // what to do if username is not in valid users list
        printf("<p><strong>%s</strong> is not a valid username</p>\n",
		htmlentities($_POST['username']));#tell user that they did not enter valid name and gives button to try to login in again
        $page = 'login.html';
    echo "<button onclick='location.href = \"$page\";'>Log back in</button>";
    }

?>