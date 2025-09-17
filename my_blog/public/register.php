<?php
session_start();
require_once "../config/db.php";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Both username and password are required!";
    } else {
        // Check if username already exists
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_fetch_assoc($result)) {
            $error = "Username already taken!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO users (username, password_hash) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt_insert, "ss", $username, $hashed_password);
            if (mysqli_stmt_execute($stmt_insert)) {
                $success = "User registered successfully! You can now <a href='login.php' class='text-primary hover:underline'>login</a>.";
            } else {
                $error = "Database error: Could not register user.";
            }
            mysqli_stmt_close($stmt_insert);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Blog Admin</title>
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
                        success: '#10b981',
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
        
        .register-card {
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
        
        .password-strength {
            height: 4px;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="px-4 py-8">
    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-2xl overflow-hidden register-card">
        <!-- Left side - Illustration -->
        <div class="gradient-bg hidden md:flex md:w-1/2 p-10 text-white flex-col justify-center">
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-4">Join Our Community!</h2>
                <p class="text-blue-100">Create an account to start publishing your content and sharing your ideas.</p>
            </div>
            <div class="space-y-4 mt-8">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <p>Create and publish blog posts</p>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <p>Track your audience engagement</p>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <p>Join a community of writers</p>
                </div>
            </div>
        </div>
        
        <!-- Right side - Registration form -->
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-dark">Create Account</h1>
                <p class="text-gray mt-2">Join us to start publishing content</p>
            </div>
            
            <?php if (!empty($error)) : ?>
                <div id="error-message" class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 flex items-center error-shake">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)) : ?>
                <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span><?= $success ?></span>
                </div>
            <?php endif; ?>
            
            <form method="post" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-dark mb-2">
                        Username <span class="text-secondary">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Choose a username" 
                            required
                            class="form-input w-full pl-10 pr-4 py-3 border border-grayLight rounded-lg focus:border-primary transition-colors"
                            value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                        >
                    </div>
                    <p class="text-xs text-gray mt-2">Must be 3-20 characters, letters and numbers only</p>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-dark mb-2">
                        Password <span class="text-secondary">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Create a strong password" 
                            required
                            class="form-input w-full pl-10 pr-4 py-3 border border-grayLight rounded-lg focus:border-primary transition-colors"
                            oninput="checkPasswordStrength()"
                        >
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    
                    <!-- Password strength meter -->
                    <div class="mt-2">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs text-gray">Password strength</span>
                            <span id="password-strength-text" class="text-xs">-</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1">
                            <div id="password-strength-bar" class="password-strength h-1 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <ul class="text-xs text-gray mt-2 space-y-1">
                        <li id="length-requirement" class="flex items-center">
                            <i class="fas fa-times text-red-400 mr-1 w-4"></i>
                            <span>At least 8 characters</span>
                        </li>
                        <li id="number-requirement" class="flex items-center">
                            <i class="fas fa-times text-red-400 mr-1 w-4"></i>
                            <span>Contains a number</span>
                        </li>
                    </ul>
                </div>
                
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="terms"
                        class="h-4 w-4 text-primary focus:ring-primary border-grayLight rounded"
                        required
                    >
                    <label for="terms" class="ml-2 block text-sm text-gray">
                        I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>
                    </label>
                </div>
                
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-primary text-white font-medium rounded-lg hover:bg-primaryDark transition-colors flex items-center justify-center"
                >
                    <i class="fas fa-user-plus mr-2"></i> Create Account
                </button>
            </form>
            
            <div class="mt-8 text-center">
                <p class="text-gray">
                    Already have an account? 
                    <a href="login.php" class="text-primary font-medium hover:underline">Sign in here</a>
                </p>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray text-sm">
                    © <?= date('Y') ?> Blog Admin. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('#password + div button i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
        // Check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const lengthReq = document.getElementById('length-requirement');
            const numberReq = document.getElementById('number-requirement');
            
            let strength = 0;
            let hasLength = password.length >= 8;
            let hasNumber = /\d/.test(password);
            
            // Update requirements
            lengthReq.innerHTML = `<i class="fas fa-${hasLength ? 'check' : 'times'} text-${hasLength ? 'green' : 'red'}-400 mr-1 w-4"></i><span>At least 8 characters</span>`;
            numberReq.innerHTML = `<i class="fas fa-${hasNumber ? 'check' : 'times'} text-${hasNumber ? 'green' : 'red'}-400 mr-1 w-4"></i><span>Contains a number</span>`;
            
            // Calculate strength
            if (hasLength) strength += 50;
            if (hasNumber) strength += 50;
            
            // Update strength bar and text
            strengthBar.style.width = `${strength}%`;
            
            if (strength === 0) {
                strengthBar.className = 'password-strength h-1 rounded-full bg-red-500';
                strengthText.textContent = 'Weak';
                strengthText.className = 'text-xs text-red-500';
            } else if (strength === 50) {
                strengthBar.className = 'password-strength h-1 rounded-full bg-yellow-500';
                strengthText.textContent = 'Medium';
                strengthText.className = 'text-xs text-yellow-500';
            } else if (strength === 100) {
                strengthBar.className = 'password-strength h-1 rounded-full bg-green-500';
                strengthText.textContent = 'Strong';
                strengthText.className = 'text-xs text-green-500';
            }
        }
        
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
        
        // Initialize password strength check if page has error
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.value) {
                checkPasswordStrength();
            }
        });
    </script>
</body>
</html>