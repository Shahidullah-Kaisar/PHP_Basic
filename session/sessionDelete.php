<?php
    session_start();

    session_unset();
    session_destroy();

    echo "Your are Logged Out";
?>