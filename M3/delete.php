<!DOCTYPE html>
<!--
This file displays all storie and comments a logged in user has created and gives an option to select one.
Once this specifc file is selected, it is deleted upon the submit button being pressed. The user is then redirected
back to their profile. 
-->
<html>
<head>
<title>Delete A Posting</title>
<link rel="stylesheet" href="style.css">
</head>
</html>
<?php
require 'database.php';
printf("<div class = title><strong>Delete a posting</strong></div>",$title);
session_start();
$username = $_SESSION['username'];

//list all their stories
print("<strong>Stories</strong>");
$lookup_stories = "SELECT id,title FROM stories WHERE creator = '$username'";
$result_stories = mysqli_query($mysqli, $lookup_stories);
?>
<form method = post>
<?php 
if (mysqli_num_rows($result_stories) > 0) {
  while($row = mysqli_fetch_assoc($result_stories)) {
    $title = $row['title'];
    $id = $row['id'];
    printf("<input type=radio id=del name=del value=%s>",$id);
    printf("<label for=%s >%s</label><br>",$id,$title);
   // printf("<div class=story><a href=story_view.php?id=$id>%s</a></div>",$title);
}
}
//List all their comments as part of the same form.
?>
<br><strong>Comments</strong><br>
<?php
$lookup_comments = "SELECT id,story_title, com_text FROM comments WHERE username = '$username'";
$result_comments = mysqli_query($mysqli, $lookup_comments);

if (mysqli_num_rows($result_comments) > 0) {
    while($row = mysqli_fetch_assoc($result_comments)) {
      $com_text = $row['com_text'];
      $id = $row['id'];
      $story_title = $row['story_title'];
      printf("<input type=radio id=del name=del value=-%s>",$id);
      printf("<label for=%s >%s - %s</label><br>",$story_id,$story_title, $com_text);
  }
} ?>
<input type=submit value=Submit></form>
<?php
if(isset($_POST['del'])){//they selected something to delete
  $val = $_POST['del'];
  if($val > 0){ //A story was selected
    // Delete the row from the table
    $del = "DELETE FROM stories WHERE id=$val";
    if (mysqli_query($mysqli, $del)) {
      $mysqli->close();
      header("Location: profile.php");
      exit;
    } else {
      echo "Error deleting record: " . mysqli_error($mysqli);
    }
  }
  else{// A comment was selected
    $lookup_comments = "SELECT id FROM comments WHERE username = '$username'";
    $result_comments = mysqli_query($mysqli, $lookup_comments);
    $val = -1*$val;
    $del = "DELETE FROM comments WHERE id=$val";
    if (mysqli_query($mysqli, $del)) {
      $mysqli->close();
      header("Location: profile.php");
      exit;
    } else {
      echo "Error deleting record: " . mysqli_error($mysqli);
    }
  }
}
$mysqli->close();
?>