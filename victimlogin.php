<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "db_dmrs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";
$success_message = "";

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $login_id = mysqli_real_escape_string($conn, trim($_POST['loginId']));
    $victim_id = mysqli_real_escape_string($conn, trim($_POST['Id']));
    $login_password = mysqli_real_escape_string($conn, $_POST['loginPassword']);
    
    // Basic validation
    if (empty($login_id) || empty($victim_id) || empty($login_password)) {
        $error_message = "All fields are required.";
    } else {
        // Check if victim exists with the given ID and email
        $sql = "SELECT * FROM Victim WHERE id = '$victim_id' AND email = '$login_id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $victim = $result->fetch_assoc();
            
            // For demo purposes, we'll accept any password
            // In production, you should verify against stored password
            
            // Store victim information in session
            $_SESSION['victim_logged_in'] = true;
            $_SESSION['victim_id'] = $victim['id'];
            $_SESSION['victim_name'] = $victim['name'];
            $_SESSION['victim_email'] = $victim['email'];
            
            $success_message = "Login successful! Welcome, " . $victim['name'] . "!";
            
            // Redirect to profile page after 2 seconds
            header("refresh:2;url=victim_profile.php");
            
        } else {
            $error_message = "Invalid ID or email. Please check your credentials.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Victim Login | ResQ</title>
  <link rel="stylesheet" href="css/rstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    .login-container {
      max-width: 500px;
      margin: 160px auto 80px;
      background-color: var(--color-white);
      padding: 3rem;
      border-radius: 1rem;
      box-shadow: var(--shadow-md);
      text-align: center;
    }
    .login-container h2 {
      font-size: 2.8rem;
      color: var(--color-primary);
      margin-bottom: 2rem;
    }
    .form-input {
      width: 100%;
      padding: 1.2rem;
      margin-bottom: 1.5rem;
      border: 1px solid var(--color-light-gray);
      border-radius: 0.5rem;
      font-size: 1.4rem;
      font-family: 'Poppins', sans-serif;
    }
    .btn-login {
      background-color: var(--color-primary);
      color: var(--color-white);
      padding: 1.2rem;
      width: 100%;
      font-weight: bold;
      font-size: 1.6rem;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
      margin-top: 1rem;
    }
    .btn-login:hover {
      background-color: var(--color-dark);
    }
    .login-footer {
      margin-top: 2rem;
      font-size: 1.4rem;
    }
    .login-footer a {
      color: var(--color-primary);
      text-decoration: underline;
    }
    .success-message {
      color: #27ae60;
      background-color: #d5f4e6;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 2rem;
      border: 1px solid #27ae60;
    }
    .error-message {
      color: #e74c3c;
      background-color: #fdf2f2;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 2rem;
      border: 1px solid #e74c3c;
    }
    .field-error {
      color: #e74c3c;
      font-size: 1.2rem;
      margin-top: -1rem;
      margin-bottom: 1rem;
      text-align: left;
      display: none;
    }
    .error-border {
      border-color: #e74c3c !important;
    }
  </style>
</head>
<body>

<!-- Navbar (same as registration page) -->
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
            <li><a href="emer_cont.html"><i class="fa-solid fa-life-ring"></i> Emergency Contacts</a></li>
            <li><a href="search_shelter.php"><i class="fa-solid fa-map-pin"></i> Shelter</a></li>
            <li><a href="donate.html"><i class="fa-solid fa-hand-holding-dollar"></i> Donate</a></li>
            <li><a href="what-to-do.html"><i class="fa-solid fa-book"></i> What to do?</a></li>
            <li><a href="about.html"><i class="fa-solid fa-users"></i> About Us</a></li>
          </ul>
          <div class="nav-actions">
            <!-- <button class="search-btn"><i class="fa-solid fa-search"></i><a href="search.html"></a></button> -->
            <a href="needhelp.php" class="btn btn-alert"><i class="fa-solid fa-circle-exclamation"></i>Need Help</a>
            <a href="login.php" class="btn btn-neutral"><i class="fa-solid fa-sign-in"></i>Login</a>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <!-- Login Form -->
  <section class="container">
    <div class="login-container">
      <h2>Victim Login</h2>
      
      <?php if (!empty($success_message)): ?>
        <div class="success-message">
          <?php echo $success_message; ?>
          <br><small>Redirecting to profile...</small>
        </div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
        <div class="error-message">
          <?php echo $error_message; ?>
        </div>
      <?php endif; ?>
      
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateLogin(event)">
        <input type="email" name="loginId" id="loginId" placeholder="Email Address" class="form-input" 
               value="<?php echo isset($_POST['loginId']) ? htmlspecialchars($_POST['loginId']) : ''; ?>" required />
        <div id="loginIdError" class="field-error">Please enter your email address</div>

        <input type="number" name="Id" id="Id" placeholder="Your Victim ID" class="form-input" 
               value="<?php echo isset($_POST['Id']) ? htmlspecialchars($_POST['Id']) : ''; ?>" required />
        <div id="IdError" class="field-error">Please enter your victim ID</div>

        <input type="password" name="loginPassword" id="loginPassword" placeholder="Password" class="form-input" required />
        <div id="loginPasswordError" class="field-error">Please enter your password</div>

        <button type="submit" class="btn-login">Login</button>
      </form>

      <div class="login-footer">
        Don't have an account? <a href="victimregistration.php">Register here</a>.<br>
        <a href="forget_vic_password.php">Forgot password?</a>
      </div>
    </div>
  </section>

 <!-- Footer -->
 <footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-about">
        <div class="logo-placeholder">
          <img src="img/roundlogo.png" alt="ResQ Logo">
        </div>
          
          <div class="logo-text">
            <h3>ResQ<span>:</span></h3>
            <p>Chaos To Control</p>
          </div>
        <p>ResQ is dedicated to providing immediate response and long-term recovery solutions for communities affected by natural disasters.</p>
        <div class="social-links">
          <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
          <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
      </div>
      
      <div class="footer-links">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="about.html">About Us</a></li>
          <li><a href="#">Disaster Updates</a></li>
          <li><a href="#">How We Help</a></li>
          <li><a href="#">Volunteer</a></li>
          <li><a href="#">Donate</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
      
      <div class="footer-links">
        <h3>Resources</h3>
        <ul>
          <li><a href="emer_cont.html">Emergency Preparedness</a></li>
          <li><a href="#">Disaster Response Guide</a></li>
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
        <div class="newsletter">
          <h4>Subscribe to our newsletter</h4>
          <form class="newsletter-form">
            <input type="email" placeholder="Your email address">
            <button type="submit" class="btn btn-primary">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
    
    <div class="footer-bottom">
      <p>&copy; 2023 ResQ Disaster Management. All rights reserved.</p>
      <div class="footer-bottom-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Cookie Policy</a>
      </div>
    </div>
  </div>
</footer>

  <script>
    function validateLogin(event) {
      let isValid = true;
      
      // Clear previous errors
      document.querySelectorAll('.field-error').forEach(el => {
        el.style.display = 'none';
      });
      document.querySelectorAll('.error-border').forEach(el => {
        el.classList.remove('error-border');
      });

      // Validate email
      const loginId = document.getElementById('loginId').value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!loginId) {
        showError('loginIdError', 'Please enter your email address');
        isValid = false;
      } else if (!emailRegex.test(loginId)) {
        showError('loginIdError', 'Please enter a valid email address');
        isValid = false;
      }

      // Validate ID
      const victimId = document.getElementById('Id').value.trim();
      if (!victimId) {
        showError('IdError', 'Please enter your victim ID');
        isValid = false;
      } else if (isNaN(victimId) || victimId <= 0) {
        showError('IdError', 'Please enter a valid victim ID (number only)');
        isValid = false;
      }

      // Validate password
      const password = document.getElementById('loginPassword').value;
      if (!password) {
        showError('loginPasswordError', 'Please enter your password');
        isValid = false;
      }

      return isValid;
    }

    function showError(id, message) {
      const errorElement = document.getElementById(id);
      errorElement.textContent = message;
      errorElement.style.display = 'block';
      
      const inputId = id.replace('Error', '');
      const inputElement = document.getElementById(inputId);
      if (inputElement) {
        inputElement.classList.add('error-border');
      }
    }

    // Allow pressing Enter to submit form
    document.getElementById('loginForm').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        validateLogin(e);
      }
    });
  </script>
</body>
</html>