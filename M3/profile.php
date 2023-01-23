<!DOCTYPE html>
<!--
  This page dispalys the user's current profile. It shows their username, profile picture, and all stories and comments
  they've posted. It then gives them a chance to change their profile picture, edit stories and comments, or delete storeis 
  and commetns they've posted
-->
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
  .nav_button {
    background-color: rgb(156, 148, 148);
    width: 15%;
    border: solid;
    border-color: white;
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
    height: 20px;
    margin-top: 15px;
    background-color: rgb(82, 64, 64);
    color: white;
    padding: 10px;
    font-size: 17px;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  .com_box {
    width: 80%;
    height: 50px;
	  margin: 10px;
    padding: 10px;
    background-color: #ccc;
    border: 1px solid #333;
    font-size: 13px;
	  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  .story {
    width: 550px;
    height: 30px;
	  padding: 5px;
	  margin: 10px;
    background-color: #ccc;
    border: 1px solid #333;
	  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
</style>
<html>
    <title>User Profile</title>
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

//not a registered user
if($reg == false){
printf("You are logged in a guest. Would you like to <a href=new_user.php>create an account</a>? ");
}
//are a registred user 
else { ?>
<h1>
<?php $result = $mysqli->query("SELECT username,profile_picture FROM users"); 
    if($result->num_rows > 0){ ?> 
      <?php while($row_pic = $result->fetch_assoc()){
      if($row_pic['username'] == $username){ ?> 
         <?php if($row_pic['profile_picture'] == null){ ?> <img style=height:60px;width:60px; src = "/blank.png"></img><?php } else { ?>
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_pic['profile_picture']); ?>" height = "60" width = "60" /> 
      <?php  } } } }?> 

<?php
printf("%s's Profile</h1>",$username);

//Display their stories
printf("<div class = title>Story contributions</div>");

$lookup_stories = "SELECT id,title FROM stories WHERE creator = '$username'";
$com_result_stories = mysqli_query($mysqli, $lookup_stories);

if (mysqli_num_rows($com_result_stories) > 0) {
  while($row = mysqli_fetch_assoc($com_result_stories)) {
    $title = $row['title'];
    $id = $row['id'];
    printf("<div class=story><a href=story_view.php?id=$id>%s</a></div>",$title);
}
} else {
  echo "0 stories";
}

//Dispaly all their comment
printf("<div class = title>Comments</div>",$title);

$lookup = "SELECT story_title,story_id,com_text FROM comments WHERE username = '$username'";
$com_result = mysqli_query($mysqli, $lookup);

if (mysqli_num_rows($com_result) > 0) {
  while($row = mysqli_fetch_assoc($com_result)) {
    $story_title = $row['story_title'];
    $story_id = $row['story_id'];?>
    <div class=com_box>
    <?php $result = $mysqli->query("SELECT username,profile_picture FROM users"); 
    if($result->num_rows > 0){ ?> 
      <?php while($row_pic = $result->fetch_assoc()){
      if($row_pic['username'] == $username){ ?> 
        <?php if($row_pic['profile_picture'] == null){ ?> <img style=height:30px;width:30px; src = "/blank.png"></img><?php } else { ?>
          <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_pic['profile_picture']); ?>" height = "30" width = "30" /> 
      <?php  } } } }
    printf("<strong>%s</strong> - <a href=story_view.php?id=$story_id>%s</a><br>%s</div>",$username,$story_title, $row['com_text']);
}
} else {
  echo "0 comments";
}

//DELETE SECTION
printf("<div class = title><a style= color:white; text-decoration:none; href = delete.php><strong>Delete Postings</strong></a></div>");

//CHANGE PFP SECTION
printf("<div class = title><a style= color:white; text-decoration:none; href = upload.html><strong>Change Profile Picture</strong></a></div>");

$mysqli->close();
}
?>
