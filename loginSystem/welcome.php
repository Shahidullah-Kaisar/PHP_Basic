<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | ISecure</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 60px 20px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .feature-icon {
            font-size: 2rem;
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php require 'partials/_navbar.php' ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Welcome to <span class="text-warning">ISecure</span></h1>
            <p>Your trusted platform for secure login & account management.</p>
            <a href="login.php" class="btn btn-light btn-lg rounded-pill shadow-sm me-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
            <a href="signup.php" class="btn btn-outline-light btn-lg rounded-pill shadow-sm">
                <i class="bi bi-person-plus me-1"></i> Signup
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-white shadow rounded">
                        <div class="feature-icon mb-3"><i class="bi bi-shield-lock-fill"></i></div>
                        <h5>Secure Login</h5>
                        <p>Keep your account safe with our strong authentication system.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white shadow rounded">
                        <div class="feature-icon mb-3"><i class="bi bi-speedometer2"></i></div>
                        <h5>Fast & Reliable</h5>
                        <p>Enjoy quick access without compromising on security.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white shadow rounded">
                        <div class="feature-icon mb-3"><i class="bi bi-people-fill"></i></div>
                        <h5>User Friendly</h5>
                        <p>Simple and easy-to-use design for everyone.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <small>© 2025 ISecure. All rights reserved.</small>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>