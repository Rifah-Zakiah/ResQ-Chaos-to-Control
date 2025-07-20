<?php
session_start();

// Check if victim is logged in
if (!isset($_SESSION['victim_id'])) {
    header("Location: victimlogin.php");
    exit();
}

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

$victim_id = $_SESSION['victim_id'];
$message = "";
$error = "";

// Fetch current victim data
$sql = "SELECT * FROM Victim WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $victim_id);
$stmt->execute();
$result = $stmt->get_result();
$victim = $result->fetch_assoc();

if (!$victim) {
    $error = "Victim profile not found.";
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $phone_no = mysqli_real_escape_string($conn, trim($_POST['phone_no']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $occupation = mysqli_real_escape_string($conn, trim($_POST['occupation']));
    $dob = mysqli_real_escape_string($conn, trim($_POST['dob']));
    $current_location = mysqli_real_escape_string($conn, trim($_POST['current_location']));
    $requirement = mysqli_real_escape_string($conn, trim($_POST['requirement']));
    $medical_info = mysqli_real_escape_string($conn, trim($_POST['medical_info']));
    $blood_group = mysqli_real_escape_string($conn, trim($_POST['blood_group']));
    $allergy = mysqli_real_escape_string($conn, trim($_POST['allergy']));
    $chronic_disease = mysqli_real_escape_string($conn, trim($_POST['chronic_disease']));
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validation
    $errors = [];
    
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($phone_no)) $errors[] = "Phone number is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    
    // Password validation if new password is provided
    if (!empty($new_password)) {
        if (strlen($new_password) < 6) {
            $errors[] = "New password must be at least 6 characters long";
        }
        if ($new_password !== $confirm_password) {
            $errors[] = "Password confirmation does not match";
        }
    }
    
    if (empty($errors)) {
        // Update profile data
        if (!empty($new_password)) {
            // Update with new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE Victim SET name=?, address=?, phone_no=?, email=?, occupation=?, dob=?, current_location=?, requirement=?, medical_info=?, blood_group=?, allergy=?, chronic_disease=?, password=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssssssi", $name, $address, $phone_no, $email, $occupation, $dob, $current_location, $requirement, $medical_info, $blood_group, $allergy, $chronic_disease, $hashed_password, $victim_id);
        } else {
            // Update without changing password
            $sql = "UPDATE Victim SET name=?, address=?, phone_no=?, email=?, occupation=?, dob=?, current_location=?, requirement=?, medical_info=?, blood_group=?, allergy=?, chronic_disease=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssi", $name, $address, $phone_no, $email, $occupation, $dob, $current_location, $requirement, $medical_info, $blood_group, $allergy, $chronic_disease, $victim_id);
        }
        
        if ($stmt->execute()) {
            $message = "Profile updated successfully!";
            // Refresh victim data
            $sql = "SELECT * FROM Victim WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $victim_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $victim = $result->fetch_assoc();
        } else {
            $error = "Error updating profile: " . $conn->error;
        }
    } else {
        $error = implode("<br>", $errors);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ResQ Victim Profile Update - Edit your victim information">
    <title>Update Victim Profile | ResQ: Chaos To Control</title>
    
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
            background-color: var(--color-background);
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 120rem;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: var(--transition-standard);
            padding: 2rem 0;
            background-color: var(--color-background);
            box-shadow: var(--shadow-sm);
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            transition: var(--transition-standard);
        }

        .logo-placeholder {
            width: 5rem;
            height: 5rem;
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
            font-size: 2rem;
            margin-bottom: 0;
            transition: var(--transition-standard);
            font-family: 'Playfair Display', serif;
        }

        .logo-text h1 span {
            color: var(--color-dark);
            font-weight: 400;
        }

        .tagline {
            font-size: 1.2rem;
            font-style: italic;
            color: var(--color-primary);
            margin-bottom: 0;
            transition: var(--transition-standard);
        }

        .nav-desktop {
            display: flex;
            align-items: center;
        }

        .nav-desktop ul {
            display: flex;
            gap: 0.5rem;
            list-style: none;
        }

        .nav-desktop a {
            display: flex;
            align-items: center;
            padding: 0.8rem 2.2rem;
            border-radius: 0.5rem;
            color: var(--color-dark);
            font-size: 1.4rem;
            font-weight: 500;
            transition: var(--transition-standard);
            text-decoration: none;
        }

        .nav-desktop a:hover {
            color: var(--color-primary);
            background-color: var(--color-light-gray);
        }

        .nav-desktop a i {
            margin-right: 0.6rem;
            font-size: 1.4rem;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            margin-left: 1.5rem;
            gap: 1.2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1.2rem 2.4rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: var(--transition-standard);
            cursor: pointer;
            border: none;
            font-family: 'Inter', sans-serif;
            text-align: center;
            box-shadow: var(--shadow-sm);
            text-decoration: none;
            font-size: 1.4rem;
        }

        .btn-alert {
            background-color: var(--color-alert);
            color: var(--color-white);
        }

        .btn-victim {
            background-color: var(--color-victim);
            color: var(--color-white);
        }

        .btn-neutral {
            background-color: var(--color-background);
            color: var(--color-dark);
            border: 1px solid var(--color-secondary);
        }

        /* Main Content */
        .main-content {
            min-height: 100vh;
            padding-top: 12rem;
            padding-bottom: 8rem;
            background: linear-gradient(135deg, var(--color-background) 0%, var(--color-light-gray) 100%);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .profile-title {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            color: var(--color-dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .profile-subtitle {
            font-size: 1.8rem;
            color: var(--color-victim);
            margin-bottom: 1rem;
        }

        .profile-description {
            font-size: 1.6rem;
            color: var(--color-primary);
            max-width: 60rem;
            margin: 0 auto;
        }

        .profile-container {
            max-width: 90rem;
            margin: 0 auto;
            background: var(--color-white);
            padding: 4rem;
            border-radius: 2rem;
            box-shadow: var(--shadow-lg);
        }

        .form-header {
            display: flex;
            align-items: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--color-light-gray);
        }

        .form-icon {
            width: 6rem;
            height: 6rem;
            background: linear-gradient(135deg, var(--color-victim), #e57373);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 2rem;
        }

        .form-icon i {
            font-size: 2.5rem;
            color: var(--color-white);
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: var(--color-victim);
            font-size: 1.4rem;
        }

        /* Messages */
        .message {
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            font-weight: 500;
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
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
            gap: 2.5rem;
            margin-bottom: 3rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
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

        .form-textarea {
            resize: vertical;
            min-height: 10rem;
        }

        .form-select {
            cursor: pointer;
        }

        /* Password Section */
        .password-section {
            background: rgba(211, 47, 47, 0.05);
            padding: 2.5rem;
            border-radius: 1.5rem;
            margin-bottom: 3rem;
            border-left: 4px solid var(--color-victim);
        }

        .password-section h3 {
            color: var(--color-victim);
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .password-section p {
            color: var(--color-dark);
            margin-bottom: 2rem;
            font-size: 1.4rem;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 2rem;
            justify-content: space-between;
            align-items: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid var(--color-light-gray);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-victim), #e57373);
            color: var(--color-white);
            padding: 1.5rem 3rem;
            border: none;
            border-radius: 1rem;
            font-size: 1.6rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-standard);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background-color: var(--color-light-gray);
            color: var(--color-dark);
            padding: 1.5rem 3rem;
            border: none;
            border-radius: 1rem;
            font-size: 1.6rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-standard);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-secondary:hover {
            background-color: var(--color-secondary);
        }

        /* Footer */
        .footer {
            background-color: var(--color-dark);
            color: var(--color-white);
            padding: 5rem 0 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
            gap: 4rem;
            margin-bottom: 3rem;
        }

        .footer-about {
            max-width: 35rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .footer-logo .logo-placeholder {
            width: 4rem;
            height: 4rem;
            background-color: var(--color-primary);
            border-radius: 0.5rem;
            margin-right: 1rem;
        }

        .footer-logo h3 {
            color: var(--color-white);
            margin-bottom: 0;
            font-family: 'Playfair Display', serif;
        }

        .footer-logo h3 span {
            color: var(--color-primary);
        }

        .footer-logo p {
            color: var(--color-light-gray);
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .footer-about p {
            color: var(--color-light-gray);
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .social-links {
            display: flex;
            gap: 1.5rem;
        }

        .social-links a {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            background-color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-size: 1.8rem;
            transition: var(--transition-standard);
            text-decoration: none;
        }

        .social-links a:hover {
            background-color: var(--color-white);
            color: var(--color-primary);
            transform: translateY(-3px);
        }

        .footer-links h3 {
            color: var(--color-white);
            margin-bottom: 2rem;
            font-family: 'Playfair Display', serif;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: var(--color-light-gray);
            transition: var(--transition-standard);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--color-white);
            padding-left: 0.5rem;
        }

        .footer-contact h3 {
            color: var(--color-white);
            margin-bottom: 2rem;
            font-family: 'Playfair Display', serif;
        }

        .footer-contact ul {
            list-style: none;
            margin-bottom: 2rem;
        }

        .footer-contact li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: var(--color-light-gray);
        }

        .footer-contact i {
            color: var(--color-primary);
            margin-right: 1rem;
            width: 2rem;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 3rem;
            border-top: 1px solid var(--color-secondary);
            color: var(--color-light-gray);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .nav-desktop {
                display: none;
            }

            .profile-title {
                font-size: 3rem;
            }

            .profile-container {
                padding: 3rem 2rem;
                margin: 0 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 1.5rem;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .profile-title {
                font-size: 2.5rem;
            }

            .profile-container {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <header id="header" class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <div class="logo-placeholder">
                        <img src="img/roundlogo.png" alt="ResQ Logo">
                    </div>
                    <div class="logo-text">
                        <h1>ResQ<span>:</span></h1>
                        <p class="tagline">Chaos To Control</p>
                    </div>
                </div>
                
                <nav class="nav-desktop">
                    <ul>
                        <li><a href="resq.php"><i class="fa-solid fa-house"></i> Home</a></li>
                        <li><a href="donate.html"><i class="fa-solid fa-hand-holding-dollar"></i> Donate</a></li>
                        <li><a href="what-to-do.html"><i class="fa-solid fa-book"></i> What to do?</a></li>
                        <li><a href="victim_profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
                        <li><a href="needhelp.php"><i class="fa-solid fa-circle-exclamation"></i> Emergency</a></li>
                    </ul>
                    <div class="nav-actions">
                        <span class="btn btn-victim"><i class="fa-solid fa-user-injured"></i> <?php echo htmlspecialchars($victim['name']); ?></span>
                        <a href="Vic_logout.php" class="btn btn-neutral"><i class="fa-solid fa-sign-out"></i> Logout</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Profile Header -->
            <div class="profile-header">
                <h1 class="profile-title">Update Victim Profile</h1>
                <p class="profile-subtitle">Edit Your Information</p>
                <p class="profile-description">
                    Update your personal information, contact details, and assistance requirements. 
                    Keep your profile current to help us provide you with the most appropriate support and services.
                </p>
            </div>

            <!-- Profile Form -->
            <div class="profile-container">
                <div class="form-header">
                    <div class="form-icon">
                        <i class="fa-solid fa-user-edit"></i>
                    </div>
                    <div>
                        <h2 class="form-title">Edit Profile Information</h2>
                        <p class="form-subtitle">Update your personal details and assistance needs</p>
                    </div>
                </div>

                <!-- Messages -->
                <?php if (!empty($message)): ?>
                    <div class="message success">
                        <i class="fa-solid fa-check-circle"></i> <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="message error">
                        <i class="fa-solid fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Update Form -->
                <?php if ($victim): ?>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <!-- Personal Information -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fa-solid fa-user"></i> Full Name *
                            </label>
                            <input type="text" id="name" name="name" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fa-solid fa-envelope"></i> Email Address *
                            </label>
                            <input type="email" id="email" name="email" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['email']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_no" class="form-label">
                                <i class="fa-solid fa-phone"></i> Phone Number *
                            </label>
                            <input type="tel" id="phone_no" name="phone_no" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['phone_no']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="dob" class="form-label">
                                <i class="fa-solid fa-calendar"></i> Date of Birth
                            </label>
                            <input type="date" id="dob" name="dob" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['dob']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="occupation" class="form-label">
                                <i class="fa-solid fa-briefcase"></i> Occupation
                            </label>
                            <input type="text" id="occupation" name="occupation" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['occupation']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="blood_group" class="form-label">
                                <i class="fa-solid fa-tint"></i> Blood Group
                            </label>
                            <select id="blood_group" name="blood_group" class="form-input form-select">
                                <option value="">Select Blood Group</option>
                                <option value="A+" <?php echo ($victim['blood_group'] == 'A+') ? 'selected' : ''; ?>>A+</option>
                                <option value="A-" <?php echo ($victim['blood_group'] == 'A-') ? 'selected' : ''; ?>>A-</option>
                                <option value="B+" <?php echo ($victim['blood_group'] == 'B+') ? 'selected' : ''; ?>>B+</option>
                                <option value="B-" <?php echo ($victim['blood_group'] == 'B-') ? 'selected' : ''; ?>>B-</option>
                                <option value="AB+" <?php echo ($victim['blood_group'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                                <option value="AB-" <?php echo ($victim['blood_group'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                                <option value="O+" <?php echo ($victim['blood_group'] == 'O+') ? 'selected' : ''; ?>>O+</option>
                                <option value="O-" <?php echo ($victim['blood_group'] == 'O-') ? 'selected' : ''; ?>>O-</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="address" class="form-label">
                                <i class="fa-solid fa-home"></i> Address
                            </label>
                            <textarea id="address" name="address" class="form-input form-textarea" 
                                      placeholder="Enter your full address"><?php echo htmlspecialchars($victim['address']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="current_location" class="form-label">
                                <i class="fa-solid fa-map-marker-alt"></i> Current Location
                            </label>
                            <input type="text" id="current_location" name="current_location" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['current_location']); ?>"
                                   placeholder="Your current location during emergency">
                        </div>

                        <div class="form-group">
                            <label for="requirement" class="form-label">
                                <i class="fa-solid fa-hands-helping"></i> Assistance Requirements
                            </label>
                            <textarea id="requirement" name="requirement" class="form-input form-textarea" 
                                      placeholder="Describe what assistance you need"><?php echo htmlspecialchars($victim['requirement']); ?></textarea>
                        </div>
                    </div>

                    <!-- Medical Information -->
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="medical_info" class="form-label">
                                <i class="fa-solid fa-user-md"></i> Medical Information
                            </label>
                            <textarea id="medical_info" name="medical_info" class="form-input form-textarea" 
                                      placeholder="Any relevant medical information, conditions, or medications"><?php echo htmlspecialchars($victim['medical_info']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="allergy" class="form-label">
                                <i class="fa-solid fa-exclamation-triangle"></i> Allergies
                            </label>
                            <input type="text" id="allergy" name="allergy" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['allergy']); ?>"
                                   placeholder="List any allergies">
                        </div>

                        <div class="form-group">
                            <label for="chronic_disease" class="form-label">
                                <i class="fa-solid fa-heartbeat"></i> Chronic Conditions
                            </label>
                            <input type="text" id="chronic_disease" name="chronic_disease" class="form-input" 
                                   value="<?php echo htmlspecialchars($victim['chronic_disease']); ?>"
                                   placeholder="List any chronic conditions">
                        </div>
                    </div>

                    <!-- Password Update Section -->
                    <div class="password-section">
                        <h3><i class="fa-solid fa-lock"></i> Change Password</h3>
                        <p>Leave blank if you don't want to change your password. New password must be at least 6 characters long.</p>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="new_password" class="form-label">
                                    <i class="fa-solid fa-key"></i> New Password
                                </label>
                                <input type="password" id="new_password" name="new_password" class="form-input" 
                                       placeholder="Enter new password (optional)">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="form-label">
                                    <i class="fa-solid fa-key"></i> Confirm New Password
                                </label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-input" 
                                       placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="victim_profile.php" class="btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Back to Profile
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-save"></i> Update Profile
                        </button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <div class="footer-logo">
                        <div class="logo-placeholder"></div>
                        <div>
                            <h3>ResQ<span>:</span></h3>
                            <p>Chaos To Control</p>
                        </div>
                    </div>
                    <p>ResQ is dedicated to providing immediate response and long-term recovery solutions for communities affected by natural disasters.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="#">Disaster Updates</a></li>
                        <li><a href="about.html">How We Help</a></li>
                        <li><a href="volunteerregistration.php">Volunteer</a></li>
                        <li><a href="donate.html">Donate</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="emer_cont.html">Emergency Preparedness</a></li>
                        <li><a href="what-to-do.html">Disaster Response Guide</a></li>
                        <li><a href="#">Relief Programs</a></li>
                        <li><a href="#">Training Workshops</a></li>
                        <li><a href="#">Community Resilience</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fa-solid fa-phone"></i> Emergency: +1-800-555-RESQ</li>
                        <li><i class="fa-solid fa-envelope"></i> info@resq-disaster.org</li>
                        <li><i class="fa-solid fa-location-dot"></i> 123 Response Avenue, Resilience City, RC 10001</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 ResQ Disaster Management. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>