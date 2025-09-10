<?php
    $x=10;
    $str="Sajib";
    $str2="Sajib is Good Boy";
    $pi=3.1416;

    var_dump($x);
    echo "<br>";

    var_dump($str);
    echo "<br>";
    
    var_dump($pi);
    echo "<br>";

    $fruits = array("Apple", "Orrange", "Banana");

    echo "The string" . "length is" . strlen($str2); // . dia string concatenation kora hoi

    echo "<br>";
    for($i=0;$i<3;$i++){
        
        echo $fruits[$i];
        echo "<br>";
    }
?>