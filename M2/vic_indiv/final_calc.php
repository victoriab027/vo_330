
<?php
    if(isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['op'])){
        $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $op = $_POST['op'];
    
    switch($op){
        case '+':
            $ans = $num1 + $num2;
            break;
        case '-':
            $ans = $num1 - $num2;
            break;
        case '*':
            $ans = $num1 * $num2;
            break;
        case '/':
            $ans = $num1 / $num2;
            break;
    }

    echo $ans;
    }
?>