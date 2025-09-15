<?php

    session_start();

    $_SESSION['username'] = "Sajib"; //username নামে session variable তৈরি হলো, যার value হলো "Sajib"
    $_SESSION['favCat'] = "Books"; //favCat নামে session variable তৈরি হলো, যার value হলো "Books"

    echo "Session Created Successfully <br>";

?>

<!-- $_SESSION হলো একটি superglobal array যা session variables রাখে। -->
<!-- $_SESSION হলো একটি array যেখানে তুমি user-specific তথ্য store করতে পারো যাতে page এর মধ্যে বা পরবর্তী page এ তা ব্যবহার করতে পারো। -->