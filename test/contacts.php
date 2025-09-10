<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "contacts";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $description = $_POST['description'];


    if (!$conn) {
        die("Found Connection Error Problem: " . mysqli_connect_error());
    } else {

        if (!empty($name) && !empty($email) && !empty($description)) {
            $sql = "INSERT INTO `contactData` (`name`, `email`, `description`, `dt`) VALUES ('$name', '$email', '$description', current_timestamp())";

            $result = mysqli_query($conn, $sql);

            if ($result) {  //$result = object অথবা boolean, query এর type এর উপর নির্ভর করে।
                echo '<div class="alert alert-success" role="alert">
                    This is a success alert—check it out!
                  </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                    This is a danger alert—check it out!
                </div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">
                    Please fill in all fields before submitting.
                  </div>';
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <h1>Enter Your Details</h1>

        <form action="/phpF/test/contacts.php" method="post">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name" >
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <h1 class="mb-5">
            <?php

            if ($conn) {
                $sql = "SELECT * FROM `contactData`";
                $result = mysqli_query($conn, $sql); //$result = object অথবা boolean, query এর type এর উপর নির্ভর করে। ekhane sob row thakbe $result er vitore.


                $total = mysqli_num_rows($result); //total row count korbe..

                echo "Total User Data: $total <br>";

                // if ($total > 0) {
                //     while ($row = mysqli_fetch_assoc($result)) { //$result এর ভিতর থেকে একটা row fetch করে associative array আকারে দেয়।
                //         echo $row['sno'] . ". " . $row['name'] . "<br>";
                //     }
                // }

                
                if ($total > 0) {
                    echo "<table class='table table-bordered table-striped'>";
                        echo "<tr class='bg-primary'>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                                echo "<td>" . $row['sno'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['dt'] . "</td>";
                            echo "</tr>";
                        }

                    echo "</table>";
                } else {
                    echo "No records found.";
                }
            }

            ?>
        </h1>

    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>