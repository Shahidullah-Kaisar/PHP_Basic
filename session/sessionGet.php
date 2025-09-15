<?php
    session_start();

    if(isset($_SESSION['username'])){
        echo "Welcome ". $_SESSION['username']. "<br>";
        echo "Favourite Category is ". $_SESSION['favCat']. "<br>";
    }else{
        echo "Please login to continue";
    }
    
?>