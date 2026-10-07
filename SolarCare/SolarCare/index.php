<?php
session_start();

// Database configuration
$host = '127.0.0.1';
$dbname = 'solarcare_db';
$user = 'root';
$pass = '';

$error = '';
$success = '';

try {
    // Connect to MySQL server (without specifying DB first to create it if needed)
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");
    
    // Create users table if it doesn't exist
    $tableQuery = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM('standard', 'admin') DEFAULT 'standard',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($tableQuery);
} catch (PDOException $e) {
    $error = "Database Connection Error: " . $e->getMessage();
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'register') {
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($fullName) || empty($email) || empty($password)) {
            $error = "All fields are required for registration.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } elseif ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } else {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $error = "Email is already registered.";
            } else {
                // Insert new user
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
                if ($insert->execute([$fullName, $email, $hash])) {
                    $success = "Registration successful! You can now log in.";
                } else {
                    $error = "An error occurred during registration.";
                }
            }
        }
    } elseif ($action === 'login') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $error = "Email and password are required.";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($userRow && password_verify($password, $userRow['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $userRow['id'];
                $_SESSION['full_name'] = $userRow['full_name'];
                $_SESSION['role'] = $userRow['role'];
                
                // Redirect based on role
                if ($userRow['role'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: standard_user.php");
                }
                exit;
            } else {
                $error = "Invalid email or password.";
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
    <title>SolarCare - Login & Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --error: #ef4444;
            --success: #10b981;
            --input-bg: rgba(15, 23, 42, 0.6);
            --input-border: #334155;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,0.2) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,0.2) 0, transparent 50%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
            perspective: 1000px;
        }

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 0.75rem;
            color: var(--text-main);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .btn {
            width: 100%;
            padding: 0.875rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
            margin-top: 1rem;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .toggle-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .toggle-text span {
            color: var(--primary);
            cursor: pointer;
            font-weight: 500;
            transition: color 0.2s;
        }

        .toggle-text span:hover {
            color: #60a5fa;
            text-decoration: underline;
        }

        /* Form states */
        #register-form {
            display: none;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: fadeIn 0.3s ease;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Floating particles background effect */
        .glow {
            position: absolute;
            width: 150px;
            height: 150px;
            background: var(--primary);
            filter: blur(100px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.4;
            top: -50px;
            right: -50px;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="glow"></div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <?php echo htmlspecialchars($success); ?>
                </div>
                <script>
                    // Switch to login form on success
                    window.onload = () => toggleForms('login');
                </script>
            <?php endif; ?>

            <!-- LOGIN FORM -->
            <div id="login-form">
                <div class="auth-header">
                    <h1>SolarCare</h1>
                    <p>Welcome back! Sign in to manage your system.</p>
                </div>
                
                <form method="POST" action="index.php">
                    <input type="hidden" name="action" value="login">
                    
                    <div class="form-group">
                        <label for="login-email">Email Address</label>
                        <input type="email" id="login-email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                    
                    <button type="submit" class="btn">Sign In</button>
                </form>
                
                <div class="toggle-text">
                    Don't have an account? <span onclick="toggleForms('register')">Register here</span>
                </div>
            </div>

            <!-- REGISTER FORM -->
            <div id="register-form">
                <div class="auth-header">
                    <h1>Create Account</h1>
                    <p>Join SolarCare to monitor your solar array.</p>
                </div>
                
                <form method="POST" action="index.php">
                    <input type="hidden" name="action" value="register">
                    
                    <div class="form-group">
                        <label for="reg-name">Full Name</label>
                        <input type="text" id="reg-name" name="full_name" class="form-control" required placeholder="John Doe">
                    </div>
                    
                    <div class="form-group">
                        <label for="reg-email">Email Address</label>
                        <input type="email" id="reg-email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="reg-password">Password</label>
                        <input type="password" id="reg-password" name="password" class="form-control" required placeholder="At least 6 characters" minlength="6">
                    </div>

                    <div class="form-group">
                        <label for="reg-confirm">Confirm Password</label>
                        <input type="password" id="reg-confirm" name="confirm_password" class="form-control" required placeholder="Must match password" minlength="6">
                    </div>
                    
                    <button type="submit" class="btn">Create Account</button>
                </form>
                
                <div class="toggle-text">
                    Already have an account? <span onclick="toggleForms('login')">Sign in</span>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        function toggleForms(formType) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const card = document.querySelector('.auth-card');
            
            // Add a little pop effect when swapping
            card.style.transform = 'scale(0.98)';
            setTimeout(() => card.style.transform = 'scale(1)', 150);

            if (formType === 'register') {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                // Reset URL to avoid re-submitting registration state
                window.history.replaceState({}, document.title, "index.php");
            } else {
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
            }
        }

        // If there was a registration error, keep the registration form open
        <?php if (!empty($error) && isset($_POST['action']) && $_POST['action'] === 'register'): ?>
            toggleForms('register');
        <?php endif; ?>
    </script>
</body>
</html>
