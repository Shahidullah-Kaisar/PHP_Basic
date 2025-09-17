<?php
session_start();
require_once "../config/db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare query
    $stmt = mysqli_prepare($conn, "SELECT id, password_hash FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify hashed password
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Blog Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        primaryDark: '#4f46e5',
                        secondary: '#f43f5e',
                        dark: '#1e293b',
                        light: '#f8fafc',
                        gray: '#64748b',
                        grayLight: '#e2e8f0',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .form-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        
        .error-shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% {transform: translateX(0);}
            10%, 30%, 50%, 70%, 90% {transform: translateX(-5px);}
            20%, 40%, 60%, 80% {transform: translateX(5px);}
        }
        
        .gradient-bg {
            background: linear-gradient(120deg, #6366f1 0%, #f43f5e 100%);
        }
    </style>
</head>
<body class="px-4 py-8">
    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-2xl overflow-hidden login-card">
        <!-- Left side - Illustration -->
        <div class="gradient-bg hidden md:flex md:w-1/2 p-10 text-white flex-col justify-center">
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-4">Welcome Back!</h2>
                <p class="text-blue-100">Sign in to manage your blog content and reach your audience.</p>
            </div>
            <div class="space-y-4 mt-8">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <p>Create engaging content</p>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <p>Track your performance</p>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <p>Connect with your audience</p>
                </div>
            </div>
        </div>
        
        <!-- Right side - Login form -->
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-dark">Blog Admin</h1>
                <p class="text-gray mt-2">Sign in to your account</p>
            </div>
            
            <?php if (!empty($error)) : ?>
                <div id="error-message" class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 flex items-center error-shake">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>
            
            <form method="post" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-dark mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Enter your username" 
                            required
                            class="form-input w-full pl-10 pr-4 py-3 border border-grayLight rounded-lg focus:border-primary transition-colors"
                            value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                        >
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-dark mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password" 
                            required
                            class="form-input w-full pl-10 pr-4 py-3 border border-grayLight rounded-lg focus:border-primary transition-colors"
                        >
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember"
                            class="h-4 w-4 text-primary focus:ring-primary border-grayLight rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray">
                            Remember me
                        </label>
                    </div>
                    
                    <a href="#" class="text-sm text-primary hover:text-primaryDark transition-colors">
                        Forgot password?
                    </a>
                </div>
                
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-primary text-white font-medium rounded-lg hover:bg-primaryDark transition-colors flex items-center justify-center"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </form>
            
            <div class="mt-8 text-center">
                <p class="text-gray text-sm">
                    © <?= date('Y') ?> Blog Admin. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Add shake animation to form when there's an error
        <?php if (!empty($error)) : ?>
            document.addEventListener('DOMContentLoaded', function() {
                const formInputs = document.querySelectorAll('input');
                formInputs.forEach(input => {
                    input.classList.add('error-shake');
                    
                    input.addEventListener('animationend', () => {
                        input.classList.remove('error-shake');
                    });
                });
            });
        <?php endif; ?>
    </script>
</body>
</html>