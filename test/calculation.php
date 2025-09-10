<?php
//variable
    $name="Shahidullah";
    $age=24;
    echo "My name is $name and I am $age years old. <br>";

//Simple Calculation
    $a=10;
    $b=20;

    echo "Sum: ". ($a + $b). "<br>";
    echo "Difference: ". ($b-$a). "<br>";

// If-else
    if ($age >= 18) {
        echo "You are an adult.<br>";
    } else {
        echo "You are not an adult.<br>";
    }

//loop
    for($i=1; $i<=5; $i++){
        echo "Number: ". $i. "<br>";
    }
?>