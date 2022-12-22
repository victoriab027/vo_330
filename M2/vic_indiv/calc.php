<!DOCTYPE html>
<html>
<head><title>Simple Calculator</title></head>
<body>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
	<p>
		<label for="num1">Number 1:</label>
		<input type="number" name="num1" id="num1" />
	</p>
    <select name = "op">
        <option>"+"</option>
        <option>-</option>
        <option>*</option>
        <option>/</option>
    </select>
    <br><br>
    <p>
		<label for="num2">Number 2:</label>
		<input type="number" name="num2" id="num2" />
	</p>
	<p>
		<input type="submit" value="Calculate" />
	</p>
</form>

<?php
if(isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['op'])){
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $op = $_POST['op'];
    if($op == "+"){
        $ans = $num1 + $num2;
    }
    else if ($op == "-"){
        $ans = $num1 - $num2;
    }
    else if ($op == "*"){
        $ans = $num1 * $num2;
    }
    else if ($op == "/"){
        $ans = $num1 / $num2;
    }

	printf("<p>Result = %s</p>\n",
		htmlentities($_POST['name'])
	);
}
?>
</body>
</html>