<?php
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

$success_message = "";
$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone_no = mysqli_real_escape_string($conn, trim($_POST['contact']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $occupation = mysqli_real_escape_string($conn, trim($_POST['occupation']));
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $current_location = mysqli_real_escape_string($conn, trim($_POST['location']));
    $requirement = mysqli_real_escape_string($conn, trim($_POST['requirement']));
    $medical_info = mysqli_real_escape_string($conn, trim($_POST['medical']));
    $blood_group = mysqli_real_escape_string($conn, trim($_POST['blood']));
    $allergy = mysqli_real_escape_string($conn, trim($_POST['allergies']));
    $chronic_disease = mysqli_real_escape_string($conn, trim($_POST['disease']));
    
    // Basic validation
    if (empty($name) || empty($email) || empty($phone_no) || empty($address) || 
        empty($occupation) || empty($dob) || empty($current_location) || 
        empty($requirement) || empty($medical_info) || empty($blood_group) || 
        empty($allergy) || empty($chronic_disease)) {
        $error_message = "All fields are required.";
    } else {
        // Check if email already exists
        $check_email = "SELECT id FROM Victim WHERE email = '$email'";
        $result = $conn->query($check_email);
        
        if ($result->num_rows > 0) {
            $error_message = "Email already exists. Please use a different email address.";
        } else {
            // Insert data into database (id will be auto-incremented)
            $sql = "INSERT INTO Victim (name, address, phone_no, email, occupation, dob, current_location, requirement, medical_info, blood_group, allergy, chronic_disease) 
                    VALUES ('$name', '$address', '$phone_no', '$email', '$occupation', '$dob', '$current_location', '$requirement', '$medical_info', '$blood_group', '$allergy', '$chronic_disease')";
            
            if ($conn->query($sql) === TRUE) {
                $success_message = "Registration successful! Your victim ID is: " . $conn->insert_id;
                // Clear form data after successful submission
                $_POST = array();
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
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
  <title>Victim Registration | ResQ</title>
  <link rel="stylesheet" href="css/rstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    .form-container {
      max-width: 600px;
      margin: auto;
      background-color: var(--color-white);
      padding: 3rem;
      border-radius: 1rem;
      box-shadow: var(--shadow-md);
      text-align: center;
    }
    .form-container h2 {
      font-size: 2.8rem;
      color: var(--color-primary);
      margin-bottom: 1rem;
    }
    .form-container p.description {
      color: var(--color-dark);
      font-size: 1.4rem;
      margin-bottom: 2rem;
    }
    .form-input, .form-select, .form-textarea {
      width: 100%;
      padding: 1.2rem;
      margin-bottom: 1.5rem;
      border: 1px solid var(--color-light-gray);
      border-radius: 0.5rem;
      font-size: 1.4rem;
      font-family: 'Poppins', sans-serif;
    }
    .btn-submit {
      background-color: var(--color-primary);
      color: var(--color-white);
      padding: 1.2rem;
      width: 100%;
      font-weight: bold;
      font-size: 1.6rem;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
    }
    .btn-submit:hover {
      background-color: var(--color-dark);
    }
    .form-footer {
      margin-top: 2rem;
      font-size: 1.4rem;
    }
    .form-footer a {
      color: var(--color-primary);
      text-decoration: underline;
    }
    .form-gender {
      text-align: left;
      margin-bottom: 1.5rem;
    }
    .form-gender label {
      margin-right: 1rem;
      font-size: 1.4rem;
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

<!-- Include Navbar -->
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
            <li><a href="about.html"><i class="fa-solid fa-users"></i> About Us</a></li>
            <li><a href="emer_cont.html"><i class="fa-solid fa-life-ring"></i> Emergency Contacts</a></li>
            <li><a href="search_shelter.php"><i class="fa-solid fa-map-pin"></i> Shelter</a></li>
            <li><a href="donate.html"><i class="fa-solid fa-hand-holding-dollar"></i> Donate</a></li>
            <li><a href="what-to-do.html"><i class="fa-solid fa-book"></i> What to do?</a></li>
          </ul>
          <div class="nav-actions">
            <!-- <button class="search-btn"><i class="fa-solid fa-search"></i><a href="search.html"></a></button> -->
            <a href="needhelp.php" class="btn btn-alert"><i class="fa-solid fa-circle-exclamation"></i>Need Help</a>
            <a href="vic_login.php" class="btn btn-neutral"><i class="fa-solid fa-sign-in"></i>Login</a>
          </div>
        </nav>
      </div>
    </div>
    
  </header>

  <!-- Registration Form -->
  <section class="container" style="margin-top: 160px;">
    <div class="form-container">
      <h2>Register as a Victim</h2>
      <p class="description">Kindly fill in this form to register.</p>

      <?php if (!empty($success_message)): ?>
        <div class="success-message">
          <?php echo $success_message; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
        <div class="error-message">
          <?php echo $error_message; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm(event)">
        
        <input type="text" name="name" id="name" placeholder="Full Name" class="form-input" 
               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required />
        <div id="nameError" class="field-error">Please enter your full name</div>

        <input type="email" name="email" id="email" placeholder="Email" class="form-input" 
               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required />
        <div id="emailError" class="field-error">Please enter a valid email address</div>

        <input type="text" name="contact" id="contact" placeholder="Contact Number (e.g. 01712345678)" class="form-input" 
               value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" required />
        <div id="contactError" class="field-error">Please enter a valid 11-digit phone number</div>

        <div class="form-gender">
          <label>Date of Birth:</label><br>
          <input type="date" name="dob" id="dob" placeholder="Date of Birth" class="form-input" 
                 value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" required />
        </div>
        <div id="dobError" class="field-error">Please enter your date of birth</div>

        <input type="text" name="address" id="address" placeholder="Full Address (e.g. 123 Main St, City)" class="form-input" 
               value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required />
        <div id="addressError" class="field-error">Please enter a complete address</div>

        <input type="text" name="location" id="location" placeholder="Current Location (District, City)" class="form-input" 
               value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>" required />
        <div id="locationError" class="field-error">Please enter your current location</div>

        <input type="text" name="occupation" id="occupation" placeholder="Occupation" class="form-input" 
               value="<?php echo isset($_POST['occupation']) ? htmlspecialchars($_POST['occupation']) : ''; ?>" required />
        <div id="occupationError" class="field-error">Please enter your occupation</div>

        <input type="text" name="requirement" id="requirement" placeholder="What help do you need? (Food, Shelter, Medical, etc.)" class="form-input" 
               value="<?php echo isset($_POST['requirement']) ? htmlspecialchars($_POST['requirement']) : ''; ?>" required />
        <div id="requirementError" class="field-error">Please specify what help you need</div>

        <input type="text" name="medical" id="medical" placeholder="Medical Info (or 'None')" class="form-input" 
               value="<?php echo isset($_POST['medical']) ? htmlspecialchars($_POST['medical']) : ''; ?>" required />
        <div id="medicalError" class="field-error">Please enter medical information or 'None'</div>

        <input type="text" name="blood" id="blood" placeholder="Blood Group (e.g. A+)" class="form-input" 
               value="<?php echo isset($_POST['blood']) ? htmlspecialchars($_POST['blood']) : ''; ?>" required />
        <div id="bloodError" class="field-error">Please enter a valid blood group (e.g. A+, B-, O+)</div>

        <input type="text" name="allergies" id="allergies" placeholder="Allergies (or 'None')" class="form-input" 
               value="<?php echo isset($_POST['allergies']) ? htmlspecialchars($_POST['allergies']) : ''; ?>" required />
        <div id="allergiesError" class="field-error">Please enter allergy information or 'None'</div>

        <input type="text" name="disease" id="disease" placeholder="Chronic Disease (or 'None')" class="form-input" 
               value="<?php echo isset($_POST['disease']) ? htmlspecialchars($_POST['disease']) : ''; ?>" required />
        <div id="diseaseError" class="field-error">Please enter chronic disease information or 'None'</div>

        <input type="password" id="password" placeholder="Password (min 8 characters)" class="form-input" />
        <div id="passwordError" class="error-message">Password must be at least 8 characters with 1 uppercase, 1 lowercase, and 1 number</div>

        <input type="password" id="confirmPassword" placeholder="Confirm Password" class="form-input" />
        <!-- <div id="confirmPasswordError" class="error-message">Passwords do not match</div> -->

        <button type="submit" class="btn-submit">Register</button>
      </form>

      <div class="form-footer">
        Already have an account? <a href="login.php">Log in</a>.
      </div>
    </div>
  </section>

  <br><br>

  <script>
    // Validate the entire form
    function validateForm(event) {
      let isValid = true;
      
      // Clear all previous errors
      document.querySelectorAll('.field-error').forEach(el => {
        el.style.display = 'none';
      });
      document.querySelectorAll('.error-border').forEach(el => {
        el.classList.remove('error-border');
      });

      // Validate name (not empty and at least 2 words)
      const name = document.getElementById('name').value.trim();
      if (!name || name.split(' ').length < 2) {
        showError('nameError', 'Please enter your full name (first and last name)');
        isValid = false;
      }

      // Validate email
      const email = document.getElementById('email').value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        showError('emailError', 'Please enter a valid email address');
        isValid = false;
      }

      // Validate contact number (11 digits for Bangladesh)
      const contact = document.getElementById('contact').value.trim();
      const contactRegex = /^01[3-9]\d{8}$/;
      if (!contactRegex.test(contact)) {
        showError('contactError', 'Please enter a valid 11-digit Bangladeshi phone number (e.g. 01712345678)');
        isValid = false;
      }

      // Validate date of birth
      const dob = document.getElementById('dob').value;
      if (!dob) {
        showError('dobError', 'Please enter your date of birth');
        isValid = false;
      } else {
        // Additional check for age (at least 18 years old)
        const dobDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - dobDate.getFullYear();
        const monthDiff = today.getMonth() - dobDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
          age--;
        }
        if (age < 18) {
          showError('dobError', 'You must be at least 18 years old to register');
          isValid = false;
        }
      }

      // Validate address (must contain both numbers and letters)
      const address = document.getElementById('address').value.trim();
      const hasNumbers = /\d/.test(address);
      const hasLetters = /[a-zA-Z]/.test(address);
      if (!address || !hasNumbers || !hasLetters) {
        showError('addressError', 'Please enter a complete address with street number and name');
        isValid = false;
      }

      // Validate current location (not empty)
      const location = document.getElementById('location').value.trim();
      if (!location) {
        showError('locationError', 'Please enter your current location');
        isValid = false;
      }

      // Validate occupation (not empty)
      const occupation = document.getElementById('occupation').value.trim();
      if (!occupation) {
        showError('occupationError', 'Please enter your occupation');
        isValid = false;
      }

      // Validate requirement (not empty)
      const requirement = document.getElementById('requirement').value.trim();
      if (!requirement) {
        showError('requirementError', 'Please specify what help you need');
        isValid = false;
      }

      // Validate medical info (not empty)
      const medical = document.getElementById('medical').value.trim();
      if (!medical) {
        showError('medicalError', 'Please enter medical information or "None"');
        isValid = false;
      }

      // Validate blood group (valid format)
      const blood = document.getElementById('blood').value.trim().toUpperCase();
      const bloodRegex = /^(A|B|AB|O)[+-]$/;
      if (!bloodRegex.test(blood)) {
        showError('bloodError', 'Please enter a valid blood group (e.g. A+, B-, O+)');
        isValid = false;
      }

      // Validate allergies (not empty)
      const allergies = document.getElementById('allergies').value.trim();
      if (!allergies) {
        showError('allergiesError', 'Please enter allergy information or "None"');
        isValid = false;
      }

      // Validate chronic disease (not empty)
      const disease = document.getElementById('disease').value.trim();
      if (!disease) {
        showError('diseaseError', 'Please enter chronic disease information or "None"');
        isValid = false;
      }

      // Validate password (strong password)
      const password = document.getElementById('password').value;
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
      if (!passwordRegex.test(password)) {
        showError('passwordError', 'Password must be at least 8 characters with 1 uppercase, 1 lowercase, and 1 number');
        isValid = false;
      }

      // // Validate password confirmation
      // const confirmPassword = document.getElementById('confirmPassword').value;
      // if (password !== confirmPassword) {
      //   showError('confirmPasswordError', 'Passwords do not match');
      //   isValid = false;
      // }

      return isValid;
    }

    // Helper function to show errors
    function showError(id, message) {
      const errorElement = document.getElementById(id);
      errorElement.textContent = message;
      errorElement.style.display = 'block';
      
      // Find the corresponding input field and add error class
      const inputId = id.replace('Error', '');
      const inputElement = document.getElementById(inputId);
      if (inputElement) {
        inputElement.classList.add('error-border');
      }
    }

    // Add real-time validation for some fields
    document.getElementById('contact').addEventListener('input', function() {
      const contact = this.value.trim();
      const contactRegex = /^01[3-9]\d{0,8}$/;
      if (!contactRegex.test(contact)) {
        this.value = contact.substring(0, 11);
      }
    });

    document.getElementById('blood').addEventListener('input', function() {
      this.value = this.value.toUpperCase();
    });
  </script>
  
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
</body>
</html>