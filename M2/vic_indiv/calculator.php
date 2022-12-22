<?php
// calculator.php

// Check if the form has been submitted
if (isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['operation'])) {
  // Get the form values
  $num1 = $_POST['num1'];
  $num2 = $_POST['num2'];
  $operation = $_POST['operation'];

  // Perform the calculation
  switch ($operation) {
    case 'add':
      $result = $num1 + $num2;
      break;
    case 'subtract':
      $result = $num1 - $num2;
      break;
    case 'multiply':
      $result = $num1 * $num2;
      break;
    case 'divide':
      $result = $num1 / $num2;
      break;
  }

  // Return the result
  echo $result;
}