<!DOCTYPE html>
<!--
This page displays all the comments across all stories of the news site. It sorts them with the most recent comment
displayed on the top.
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
printf("<div class = title>Comments</div>");

//gather comments 
$lookup = "SELECT * FROM comments ORDER BY id DESC";
$com_result = mysqli_query($mysqli, $lookup);

if (mysqli_num_rows($com_result) > 0) {
  while($row = mysqli_fetch_assoc($com_result)) { ?>
    <div class = com_box>
    <?php 
    //the following code loops through the usernames if the username it is on is the same as the
    //user of the comment, it displays their profile picture. If they have no profile picture,
    // we dispaly a blank one saved in the instance directory
    $result = $mysqli->query("SELECT username,profile_picture FROM users"); 
    if($result->num_rows > 0){
      while($row_pic = $result->fetch_assoc()){
      if($row_pic['username'] == $row['username']){
        if($row_pic['profile_picture'] == null){ ?> 
          <img style= height:30px;width:30px; src = "/blank.png"></img>
        <?php } 
        else { ?>
          <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_pic['profile_picture']); ?>" height = "30" width = "30" /> 
      <?php } } } }
    //dispaly the comment
    printf("<strong>%s - <a href=story_view.php?id=%s>%s</a></strong><br>%s</div>",$row['username'],$row['story_id'], $row['story_title'], $row['com_text']);
  }
} else {
  echo "0 comments";
}

$mysqli->close();
?>