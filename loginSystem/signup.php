<?php
    include 'partials/db_config.php';

    $showAlert=false;
    $showError=false;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username=$_POST["username"];
        $email=$_POST["email"];
        $password=$_POST["password"];
        $cpassword=$_POST["cpassword"];
        $terms_accepted=isset($_POST["termsCheck"]) ? true : false ;

        if(!$terms_accepted){
            $showError = "You must accept the terms & conditions.";
        }else{
            if($password != $cpassword){
                $showError = "Passwords do not match.";
            }else{
                $existSql = "SELECT * FROM user_data WHERE email='$email' ";
                $result = mysqli_query($conn, $existSql);

                $numExistRows = mysqli_num_rows($result);

                if($numExistRows > 0){
                    $showError = "Email is already registered.";
                }else{
                    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO `user_data` (`username`, `email`, `password`, `dt`) 
                            VALUES ('$username', '$email', '$hashPassword', current_timestamp())";

                    $result = mysqli_query($conn, $sql);

                    if($result){
                        $showAlert = true;
                    }else{
                        $showError = "Error occurred. Please try again.";
                    }
                }
            }
        }

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

    <?php require 'partials/_navbar.php' ?>

    <?php
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your account has been created. <a href="login.php">Login here</a>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
        }

        if ($showError) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> ' . $showError . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
        }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-4 border border-danger">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Sign Up First</h2>
                        <hr class="w-25 mx-auto">
                            <form action="/phpF/loginSystem/signup.php" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-semibold">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cpassword" class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Your Password" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="termsCheck" name="termsCheck">
                                    <label class="form-check-label" for="termsCheck">I agree to the terms & conditions</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>