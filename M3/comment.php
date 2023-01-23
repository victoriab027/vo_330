<!-- 
This file is the php file that resolves the POST form in comment_2.php. After the user inserts
their comment, it will add it to the database and then direct them back to the story using the 
story id sent from comment_2.php
-->

<?php
require 'database.php';
session_start();
$id = $_SESSION['id'];
$username = $_SESSION['username'];
$title = $_SESSION['stitle'];

if(isset($_POST['comment'])){//they submitted a comment
    //add this comment to the SQL database
    $value2add = $_POST['comment'];
    $sql = "INSERT INTO comments (username, story_title, story_id, com_text) VALUES ('$username', '$title', $id, '$value2add')";

    if ($mysqli->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

    //return to the story that will now have the updated comment.
    mysqli_close($mysqli);
    header("Location:story_view.php?id=$id");
    exit;
}


?>