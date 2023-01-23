<!DOCTYPE html>
<!--
  This page displays a selected story based upon the story id given in the new_index.php loop. It displays the
  title, the creator, their profile picture and the link. Below, it displays all comments asssociated with this
  story. If the user is a registered user, they will see an option to add a comment to this story.
-->
<html>
<title>Bears News</title>
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
  .comments {
    background-color: rgb(97, 83, 83);
    color: white;
    padding: 5px;
    font-size: 15px;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  .link {
    background-color: rgb(230,225,225);
    font-size: 13px;
    color: white;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  a {
    color: rgb(20,20,20);
    text-decoration: none;
  }
  p{
    margin: 15px;
    color: black;
    font-size: 16px;
  }
  .com_box {
    width: 80%;
    height: 50px;
	  margin: 10px;
    padding: 10px;
    background-color: #ccc;
    border: 1px solid #333;
    font-size: 15px;
	  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  .like_num_box{
    width: 5%;
    height: 10px;
    padding: 10px;
    background-color: rgb(224, 193, 193);
    border: 1px solid #333;
    margin-left:10px;
    margin-top:-9px;
    font-size: 13px;
	  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  .title {
      width: 100%;
      height: 20px;
      margin-top: 15px;
      background-color: rgb(82, 64, 64);
      color: white;
      padding: 10px;
      font-size: 17px;
      font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }
</style>
<html>
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
$id = $_GET['id']; 
session_start();
$username = $_SESSION["username"];
$reg = $_SESSION["reg"];?>

<?php
//Figure out what story this we are supposed to display based on the story id sent
$query = "SELECT title,story,link,creator FROM stories WHERE id='$id'";
$result = mysqli_query($mysqli, $query);

// Fetch the result row as an associative array
$row = mysqli_fetch_assoc($result);

// Output the variables
$title =  $row['title'];
$story =  $row['story'];
$link = $row['link'];
$creator = $row['creator'];

// Free the result set
mysqli_free_result($result);

//Outputting the title, link, and creator for the story
printf("<div class = title><strong>%s</strong></div>",$title);
printf("<div class = link><a href = $link target=_blank>Link: $link</a> </div>"); ?>
<div class = link><a>Creator:
<?php 
//the following code loops through the usernames if the username it is on is the same as the
//cretor of this site, it displays their profile picture. If they have no profile picture,
// we dispaly a blank one saved in the instance directory
$result = $mysqli->query("SELECT username,profile_picture FROM users"); 
if($result->num_rows > 0){ 
  while($row_pic = $result->fetch_assoc()){
  if($row_pic['username'] == $creator){ 
    if($row_pic['profile_picture'] == null){ ?> <img style=height:15px;width:15px; src = "/blank.png"></img><?php } else { ?>
      <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_pic['profile_picture']); ?>" height = "15" width = "15" /> 
<?php } } } }
echo $creator; ?>
</a></div>

<?php
//dispaly the body of the story
printf("<p>%s</p>",$story);

// COMMENT SECTION
// here we will dispaly all current comments for this story
printf("<div class = comments>Comments </div>");

$lookup = "SELECT * FROM comments WHERE story_id = '$id'";
$com_result = mysqli_query($mysqli, $lookup);

if (mysqli_num_rows($com_result) > 0) {
  while($row = mysqli_fetch_assoc($com_result)) { ?>
    <div class = com_box>
    <?php $result = $mysqli->query("SELECT username,profile_picture FROM users"); 
    if($result->num_rows > 0){ ?> 
      <?php while($row_pic = $result->fetch_assoc()){
      if($row_pic['username'] == $row['username']){ ?> 
         <?php if($row_pic['profile_picture'] == null){ ?> <img style=height:30px;width:30px; src = "/blank.png"></img><?php } else { ?>
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_pic['profile_picture']); ?>" height = "30" width = "30" /> 
      <?php } } } }?> 
    <?php printf("<strong>%s</strong><br>%s</div>",$row['username'], $row['com_text']);
  }
} else {
  echo "0 comments";
}

//Only if they are a registred user can they have the option to add a comment
if($reg == true){
    printf("<div class = title><a style= color:white; text-decoration:none; href = comment_2.php?id=$id><strong>Add a comment</strong></a></div>");
    $_SESSION['id'] = $id; 
    $_SESSION['stitle'] = $title;
  }
mysqli_close($mysqli);
?>