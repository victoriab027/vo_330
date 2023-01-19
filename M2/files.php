<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<html>
<head><title>Simple File Sharing Site</title></head>
<body>

<?php
session_start();
$username = $_SESSION["username"];
$files = scandir("/files"); // FILL THIS IN!
printf("<h1>Welcome <strong>%s</strong>!</h1>\n",
	    htmlentities($username));
?>

<?php
$dir = '/srv/uploads/' . $username;

// Scan the directory and get all the files
$files = scandir($dir);
?>
<h3>Your Files</h3>
<form>
  Search: <input type="text" name="search"><br><br>
</form>
<?php
// Get the search value from the input field
$search = (string) $_GET['search'];
if( !preg_match('/^[\w_\.\-]+$/', $search) ){
  print_r('Inavlid Search Query:');
}
else if (empty($search)){
  foreach ($files as $file) {
    // Ignore . and .. directories
    if ($file != '.' && $file != '..') {
      // Check if the file name contains the search value
        echo $file . '<br>';
    }
  }
} else{
print_r('Search Query:'.$search);
print_r("<br>");

// Loop through the files and print them
foreach ($files as $file) {
  // Ignore . and .. directories
  if ($file != '.' && $file != '..') {
    // Check if the file name contains the search value
    if (stripos($file, $search) !== false) {
      echo $file . '<br>';
    }
  }
}
}
?>

<h3>View a File</h3>
<form name = "view" method = "POST" action = "view.php">
    <select name = "view">
        <?php 
        foreach ($files as $file) {
            // Ignore . and .. directories
            if ($file != '.' && $file != '..') {
                echo "<option value='$file'>$file</option>";
            }
          }
        ?>
        
    </select>
    <br>
    <input type="submit" value="Submit" />
</form>

<h3>Upload a File</h3>
<form enctype="multipart/form-data" action = "upload.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input type="submit" value="Upload File" />
	</p>
</form> 

<h3>Delete a File</h3>
<form name = "delete" method = "POST" action = "delete.php">
    <select name = "delete">
        <?php 
        $_SESSION["username"] = $username;
        foreach ($files as $file) {
            // Ignore . and .. directories
            if ($file != '.' && $file != '..') {
                echo "<option value='$file'>$file</option>";
            }
          }
        ?>
        
    </select>
    <br>
    <input type="submit" value="Delete" />
</form> 

<h3>Logout</h3>
<?php
$page = 'logout.php';

echo "<button onclick='location.href = \"$page\";'>Logout</button>";
?>

</body>
</html>