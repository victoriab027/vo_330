<!DOCTYPE html>
<!--
This page displays all the comments across all stories of the news site. It sorts them with the most recent comment
displayed on the top.
-->
<head>
<title>Comments</title>
<link rel="stylesheet" href="style.css">
</head>
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