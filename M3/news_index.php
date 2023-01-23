<!DOCTYPE html>
<!-- 
This is the index/home page of the entire news website. It displays the stories, the username of the loggedin user (or guest)
if they are a guest. If they are regisrted user, it also gives a chance to add a story
-->
<html>
<head>
<title>Bears News</title>
</head>

<style>
  header {
    background-color: rgb(119, 101, 101);
    color: white;
    padding: 10px;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    margin-bottom: 20px;
  }
  nav {
    display: flex;
    background-color: rgb(156, 148, 148);
    padding: 0px;
    justify-content: space-between;
  }
  nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
  }
  nav li {
    margin: 0 0px;
    border: solid;
    padding: 15px;
  }
  nav a {
    color: white;
    text-decoration: none;
  }
	.box {
    width: 550px;
    height: 30px;
	  padding: 5px;
	  margin: 10px;
    background-color: #ccc;
    border: 1px solid #333;
	  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  .title {
    width: 100%;
    height: 25px;
    margin-top: 15px;
    background-color: rgb(82, 64, 64);
    color: white;
    padding: 10px;
    font-size: 20px;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
</style>
  
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



