<!DOCTYPE html>
<html>
<head><title>Bold Printer</title></head>
<body>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
	<p>
		<label for="name">Name:</label>
		<input type="text" name="name" id="name" />
	</p>
	<p>
		<input type="submit" value="Print in Bold" />
	</p>
</form>

<?php
if(isset($_POST['name'])){
	printf("<p><strong>%s</strong></p>\n",
		htmlentities($_POST['name'])
	);
}
?>
</body>
</html>