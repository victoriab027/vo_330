<!DOCTYPE html>
<!-- 
This is the index/home page of the entire news website. It displays the stories, the username of the loggedin user (or guest)
if they are a guest. If they are regisrted user, it also gives a chance to add a story
-->
<html lang = "en">
<head>
<title>Bears News</title>
<link rel="stylesheet" href="style.css">
</head>
  <header>
    <h1>Bears News</h1>
    <nav>
      <ul>
        <li><a href="news_index.php">Home</a></li>
        <li><a href="comments.php">Comments</a></li>
    <li><a href="profile.php">Profile</a></li>
    <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</html>
<?php
require 'database.php';

session_start();
$username = $_SESSION["username"];
$reg = $_SESSION["reg"];
$try = $_SESSION["guest"];

printf("<p>Welcome %s<p>",$username);

// list all the sotries from the database, regardless of creator
printf("<div class = title>Stories</div>");

$stmt = $mysqli->prepare("SELECT title,id FROM stories WHERE title = ?");

$stmt = $mysqli->prepare("select title,id from stories order by title");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->bind_result($title,$id);

while($stmt->fetch()){
	printf("<div class=box><b><a href=story_view.php?id=$id>%s</a></b><br></div>",$title);
}

// Only regisretd user can add stories
if($reg == true){
  printf("<div class = title><strong><a style=color:white; text-decoration:none;  href = new_story.php>Add a story</strong></a></div>",$title);
}
mysqli_close($mysqli);
?>



