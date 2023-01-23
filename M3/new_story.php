<!DOCTYPE html>
<!--
This page is direct to if the user chooses to add a new story. It presents and resolves a form for the logged in 
user to give a title, body text, and link. Once this data has been added to the database and table of stories, 
the user is redirected to the index page.
-->
<html>
<title>Bears News</title>
<header>
    <h1>Bears News</h1>
    <nav>
      <ul>
        <li><a href="news_index.php">Home</a></li>
        <li><a href="comments.php">Comments</a></li>
        <li><a href="top_users.php">Top Users</a></li>
		<li><a href="profile.php">Profile</a></li>
		<li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</html>
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

<?php
require 'database.php';
printf("<div class = title><strong>Add a story</strong></div>",$title);
session_start();
$username = $_SESSION['username']; ?>

<form  method=post>
  <label for=new_title>Title:</label><br>
  <input type=text id=new_title name=new_title><br>
	<label for=new_text>Body text:</label><br>
  <textarea  id=new_text name=new_text cols=100 rows=10></textarea><br>
	<label for=new_link>Link:</label><br>
  <input type=text id=new_link name=new_link><br>
  <input type=submit value=Submit>
</form>

<?php
  if(isset($_POST['new_title'])&& isset($_POST['new_text'])&&isset($_POST['new_link'])){//they submitted a story and filled in all value
	//add this title to the SQL database
	$first = $_POST['new_title'];
	$second = $_POST['new_text'];
	$third = $_POST['new_link'];
	$sql = "INSERT INTO stories (title, story, link, creator) VALUES ('$first', '$second', '$third', '$username')";

	if ($mysqli->query($sql) === TRUE) {
    header("Location: news_index.php");
    exit;
	} else {
    	echo "Error: " . $sql . "<br>" . $mysqli->error;
	}
}
$mysqli->close();
?>