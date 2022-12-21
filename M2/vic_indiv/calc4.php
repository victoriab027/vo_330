<!DOCTYPE html>
<head><title>Hello World</title></head>
<body>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

<p>
		<label for="num1">Number 1:</label>
		<input type="text" name="name" id="name" />
	</p>
	<p>
		<input type="submit" value="Print in Bold" />
	</p>
</form>

<?php
if(isset($_POST['val1']) && isset($_POST['val2']) && isset($_POST['operator'] ))
{
	$operator = $_POST['operator'];
	$x1 = $_POST['val1'];
	$x1 = $_POST['val2'];

	if($operator=="+")
	{
		print "hello";	
	$ans= $x1+$x2;
	}
	else if($operator=="-")
	{
		$ans= $x1-$x2;
	}
	else if($operator=="*")
	{
		$ans =$x1*$x2;
	}
	else if($operator=="/")
	{
		$ans= $x1/$x2;
	}
	echo $ans;
}
?>


Number 1
<input type="number" id="val1" name="val1">

<br><br>

Operator

<select name="operator">
<option>+</option>
<option>-</option>
<option>*</option>
<option>/</option>
</select>

<br><br>

Number 2
<input type="number" id="val2" name="val2">

<br><br>


<input type="submit" value="Calculate">

<br><br>

<br>
<div id="result">Output = </div>
<!--?= $ans?--> 




</body><grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration></html>