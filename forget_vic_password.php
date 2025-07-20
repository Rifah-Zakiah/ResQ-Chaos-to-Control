<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_dmrs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$error = "";
$step = isset($_GET['step']) ? $_GET['step'] : 1;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        // Step 1: Email verification
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        
        if (empty($email)) {
            $error = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } else {
            // Check if email exists in victim table
            $sql = "SELECT id, name FROM Victim WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $victim = $result->fetch_assoc();
                $_SESSION['reset_victim_id'] = $victim['id'];
                $_SESSION['reset_victim_email'] = $email;
                $_SESSION['reset_victim_name'] = $victim['name'];
                header("Location: forget_vic_password.php?step=2");
                exit();
            } else {
                $error = "No victim account found with this email address.";
            }
        }
    } elseif (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        // Step 2: Password reset
        if (!isset($_SESSION['reset_victim_id'])) {
            header("Location: forget_vic_password.php?step=1");
            exit();
        }
        
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);
        
        // Validation
        $errors = [];
        
        if (empty($new_password)) {
            $errors[] = "New password is required";
        } elseif (strlen($new_password) < 6) {
            $errors[] = "Password must be at least 6 characters long";
        }
        
        if ($new_password !== $confirm_password) {
            $errors[] = "Password confirmation does not match";
        }
        
        if (empty($errors)) {
            // Update password in database
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $victim_id = $_SESSION['reset_victim_id'];
            
            $sql = "UPDATE Victim SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashed_password, $victim_id);
            
            if ($stmt->execute()) {
                // Clear session variables
                unset($_SESSION['reset_victim_id']);
                unset($_SESSION['reset_victim_email']);
                unset($_SESSION['reset_victim_name']);
                
                header("Location: forget_vic_password.php?step=3");
                exit();
            } else {
                $error = "Error updating password. Please try again.";
            }
        } else {
            $error = implode("<br>", $errors);
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ResQ Victim Password Reset - Reset your victim account password">
    <title>Reset Victim Password | ResQ: Chaos To Control</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="icon" href="img/roundlogo.png">
    
    <style>
        /* Reset and Base Styles */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --color-dark: #141311;
            --color-primary: #574537;
            --color-secondary: #C1B7AD;
            --color-light-gray: #D7D2CF;
            --color-background: #F7F7F7;
            --color-white: #FFFFFF;
            --color-alert: #E53935;
            --color-success: #2E7D32;
            --color-victim: #D32F2F;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.08);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1), 0 5px 10px rgba(0,0,0,0.05);
            --transition-standard: all 0.3s ease;
        }

        html {
            font-size: 62.5%;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
            line-height: 1.6;
            color: var(--color-dark);
            background: linear-gradient(135deg, var(--color-background) 0%, var(--color-light-gray) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .container {
            width: 100%;
            max-width: 50rem;
        }

        /* Reset Container */
        .reset-container {
            background: var(--color-white);
            padding: 4rem;
            border-radius: 2rem;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .reset-header {
            margin-bottom: 3rem;
        }

        .reset-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .logo-placeholder {
            width: 6rem;
            height: 6rem;
            margin-right: 1.5rem;
            background-color: transparent;
        }

        .logo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .logo-text h1 {
            color: var(--color-primary);
            font-size: 2.5rem;
            margin-bottom: 0;
            font-family: 'Playfair Display', serif;
        }

        .logo-text h1 span {
            color: var(--color-dark);
            font-weight: 400;
        }

        .tagline {
            font-size: 1.4rem;
            font-style: italic;
            color: var(--color-primary);
            margin-bottom: 0;
        }

        .reset-icon {
            width: 8rem;
            height: 8rem;
            background: linear-gradient(135deg, var(--color-victim), #e57373);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .reset-icon i {
            font-size: 3.5rem;
            color: var(--color-white);
        }

        .reset-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: var(--color-dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .reset-subtitle {
            font-size: 1.6rem;
            color: var(--color-victim);
            margin-bottom: 1rem;
        }

        .reset-description {
            font-size: 1.4rem;
            color: var(--color-primary);
            line-height: 1.6;
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .step {
            display: flex;
            align-items: center;
            position: relative;
        }

        .step-number {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.4rem;
            margin-right: 1rem;
            transition: var(--transition-standard);
        }

        .step.active .step-number {
            background: var(--color-victim);
            color: var(--color-white);
        }

        .step.completed .step-number {
            background: var(--color-success);
            color: var(--color-white);
        }

        .step.inactive .step-number {
            background: var(--color-light-gray);
            color: var(--color-primary);
        }

        .step-text {
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--color-dark);
        }

        .step:not(:last-child)::after {
            content: '';
            width: 3rem;
            height: 2px;
            background: var(--color-light-gray);
            margin: 0 1.5rem;
        }

        /* Messages */
        .message {
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            font-weight: 500;
            text-align: left;
        }

        .message.success {
            background-color: rgba(46, 125, 50, 0.1);
            color: var(--color-success);
            border-left: 4px solid var(--color-success);
        }

        .message.error {
            background-color: rgba(229, 57, 53, 0.1);
            color: var(--color-alert);
            border-left: 4px solid var(--color-alert);
        }

        /* Form Styles */
        .reset-form {
            text-align: left;
        }

        .form-group {
            margin-bottom: 2.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 0.8rem;
            font-size: 1.4rem;
        }

        .form-label i {
            margin-right: 0.8rem;
            color: var(--color-victim);
            width: 1.5rem;
        }

        .form-input {
            width: 100%;
            padding: 1.5rem;
            border: 2px solid var(--color-light-gray);
            border-radius: 1rem;
            font-size: 1.6rem;
            transition: var(--transition-standard);
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-background);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-victim);
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
            background-color: var(--color-white);
        }

        .btn {
            width: 100%;
            padding: 1.5rem 2rem;
            border: none;
            border-radius: 1rem;
            font-size: 1.6rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-standard);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-victim), #e57373);
            color: var(--color-white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background-color: var(--color-light-gray);
            color: var(--color-dark);
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background-color: var(--color-secondary);
        }

        .btn i {
            margin-right: 0.8rem;
        }

        /* Success State */
        .success-content {
            text-align: center;
        }

        .success-icon {
            width: 10rem;
            height: 10rem;
            background: linear-gradient(135deg, var(--color-success), #4caf50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .success-icon i {
            font-size: 4rem;
            color: var(--color-white);
        }

        .success-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--color-dark);
            margin-bottom: 1rem;
        }

        .success-message {
            font-size: 1.6rem;
            color: var(--color-primary);
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .password-info {
            background: rgba(211, 47, 47, 0.05);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--color-victim);
        }

        .password-info h4 {
            color: var(--color-victim);
            font-size: 1.6rem;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
        }

        .password-info p {
            color: var(--color-dark);
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .reset-container {
                padding: 3rem 2rem;
            }

            .reset-title {
                font-size: 2.3rem;
            }

            .step-indicator {
                flex-direction: column;
                gap: 1rem;
            }

            .step:not(:last-child)::after {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .reset-container {
                padding: 2rem 1.5rem;
            }

            .reset-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="reset-container">
            <!-- Header -->
            <div class="reset-header">
                <div class="reset-logo">
                    <div class="logo-placeholder">
                        <img src="img/roundlogo.png" alt="ResQ Logo">
                    </div>
                    <div class="logo-text">
                        <h1>ResQ<span>:</span></h1>
                        <p class="tagline">Chaos To Control</p>
                    </div>
                </div>
            </div>

            <?php if ($step == 1): ?>
                <!-- Step 1: Email Verification -->
                <div class="step-indicator">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <div class="step-text">Email</div>
                    </div>
                    <div class="step inactive">
                        <div class="step-number">2</div>
                        <div class="step-text">Reset</div>
                    </div>
                    <div class="step inactive">
                        <div class="step-number">3</div>
                        <div class="step-text">Complete</div>
                    </div>
                </div>

                <div class="reset-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <h1 class="reset-title">Reset Victim Password</h1>
                <p class="reset-subtitle">Step 1: Email Verification</p>
                <p class="reset-description">
                    Enter your registered email address to begin the password reset process.
                </p>

                <?php if (!empty($error)): ?>
                    <div class="message error">
                        <i class="fa-solid fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="reset-form">
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fa-solid fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="email" name="email" class="form-input" 
                               placeholder="Enter your registered email address" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-search"></i> Find Account
                    </button>

                    <a href="victimlogin.php" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back to Login
                    </a>
                </form>

            <?php elseif ($step == 2): ?>
                <!-- Step 2: Password Reset -->
                <div class="step-indicator">
                    <div class="step completed">
                        <div class="step-number"><i class="fa-solid fa-check"></i></div>
                        <div class="step-text">Email</div>
                    </div>
                    <div class="step active">
                        <div class="step-number">2</div>
                        <div class="step-text">Reset</div>
                    </div>
                    <div class="step inactive">
                        <div class="step-number">3</div>
                        <div class="step-text">Complete</div>
                    </div>
                </div>

                <div class="reset-icon">
                    <i class="fa-solid fa-key"></i>
                </div>

                <h1 class="reset-title">Set New Password</h1>
                <p class="reset-subtitle">Step 2: Create New Password</p>
                <p class="reset-description">
                    Account found for: <strong><?php echo htmlspecialchars($_SESSION['reset_victim_name']); ?></strong><br>
                    Enter your new password below.
                </p>

                <?php if (!empty($error)): ?>
                    <div class="message error">
                        <i class="fa-solid fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <div class="password-info">
                    <h4><i class="fa-solid fa-shield-alt"></i> Password Requirements</h4>
                    <p>• Minimum 6 characters long</p>
                    <p>• Use a combination of letters, numbers, and symbols</p>
                    <p>• Choose something you can remember but others can't guess</p>
                </div>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?step=2" class="reset-form">
                    <div class="form-group">
                        <label for="new_password" class="form-label">
                            <i class="fa-solid fa-lock"></i> New Password
                        </label>
                        <input type="password" id="new_password" name="new_password" class="form-input" 
                               placeholder="Enter your new password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">
                            <i class="fa-solid fa-lock"></i> Confirm New Password
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-input" 
                               placeholder="Confirm your new password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Update Password
                    </button>

                    <a href="forget_vic_password.php?step=1" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back to Email
                    </a>
                </form>

            <?php elseif ($step == 3): ?>
                <!-- Step 3: Success -->
                <div class="step-indicator">
                    <div class="step completed">
                        <div class="step-number"><i class="fa-solid fa-check"></i></div>
                        <div class="step-text">Email</div>
                    </div>
                    <div class="step completed">
                        <div class="step-number"><i class="fa-solid fa-check"></i></div>
                        <div class="step-text">Reset</div>
                    </div>
                    <div class="step completed">
                        <div class="step-number"><i class="fa-solid fa-check"></i></div>
                        <div class="step-text">Complete</div>
                    </div>
                </div>

                <div class="success-content">
                    <div class="success-icon">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>

                    <h1 class="success-title">Password Reset Complete!</h1>
                    <p class="success-message">
                        Your victim account password has been successfully updated. 
                        You can now log in with your new password.
                    </p>

                    <a href="victimlogin.php" class="btn btn-primary">
                        <i class="fa-solid fa-sign-in-alt"></i> Login to Your Account
                    </a>

                    <a href="resq.php" class="btn btn-secondary">
                        <i class="fa-solid fa-home"></i> Back to Home
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>