<?php
session_start();

// Check if volunteer is logged in
if (!isset($_SESSION['volunteer_logged_in']) || $_SESSION['volunteer_logged_in'] !== true) {
    header("Location: volunteerlogin.php");
    exit();
}

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

// Fetch volunteer details
$volunteer_id = $_SESSION['volunteer_id'];
$sql = "SELECT * FROM Volunteer WHERE id = '$volunteer_id'";
$result = $conn->query($sql);
$volunteer = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="description" content="Volunteer Profile - ResQ Disaster Management">
  <title>Volunteer Profile | ResQ: Chaos To Control</title>
  
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

    /* Header Styles - Same as original */
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
    }

    .btn-alert {
      background-color: var(--color-alert);
      color: var(--color-white);
    }

    .btn-neutral {
      background-color: var(--color-background);
      color: var(--color-dark);
      border: 1px solid var(--color-secondary);
    }

    .welcome-text {
      color: var(--color-primary);
      font-weight: 600;
      margin-right: 1rem;
    }

    /* Profile Main Content */
    .profile-main {
      min-height: 100vh;
      padding-top: 12rem;
      padding-bottom: 8rem;
    }

    .profile-header {
      background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-dark) 100%);
      color: var(--color-white);
      padding: 4rem 0;
      border-radius: 2rem;
      margin-bottom: 4rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .profile-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 10px,
        rgba(255,255,255,0.05) 10px,
        rgba(255,255,255,0.05) 20px
      );
      animation: slide 20s linear infinite;
    }

    @keyframes slide {
      0% { transform: translateX(-50px); }
      100% { transform: translateX(50px); }
    }

    .profile-info {
      position: relative;
      z-index: 2;
    }

    .volunteer-avatar {
      width: 12rem;
      height: 12rem;
      background-color: var(--color-white);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 2rem;
      box-shadow: var(--shadow-lg);
    }

    .volunteer-avatar i {
      font-size: 6rem;
      color: var(--color-primary);
    }

    .volunteer-id {
      background-color: rgba(255,255,255,0.2);
      padding: 0.8rem 1.5rem;
      border-radius: 2rem;
      display: inline-block;
      margin-top: 1rem;
      font-weight: 600;
    }

    .profile-content {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 4rem;
      margin-bottom: 4rem;
    }

    .profile-details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
    }

    .detail-card {
      background: var(--color-white);
      padding: 3rem;
      border-radius: 1.5rem;
      box-shadow: var(--shadow-md);
      transition: var(--transition-standard);
    }

    .detail-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }

    .detail-card h3 {
      color: var(--color-primary);
      font-family: 'Playfair Display', serif;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
    }

    .detail-card h3 i {
      margin-right: 1rem;
      font-size: 2rem;
      color: var(--color-alert);
    }

    .detail-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 0;
      border-bottom: 1px solid var(--color-light-gray);
    }

    .detail-item:last-child {
      border-bottom: none;
    }

    .detail-label {
      font-weight: 600;
      color: var(--color-dark);
    }

    .detail-value {
      color: var(--color-primary);
      font-weight: 500;
    }

    .actions-sidebar {
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .action-card {
      background: var(--color-white);
      padding: 2.5rem;
      border-radius: 1.5rem;
      box-shadow: var(--shadow-md);
      text-align: center;
      transition: var(--transition-standard);
    }

    .action-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }

    .action-icon {
      width: 6rem;
      height: 6rem;
      background: linear-gradient(135deg, var(--color-alert), #ff6b6b);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
    }

    .action-icon i {
      font-size: 2.5rem;
      color: var(--color-white);
    }

    .action-card h4 {
      color: var(--color-primary);
      margin-bottom: 1rem;
      font-family: 'Playfair Display', serif;
    }

    .action-card p {
      color: var(--color-dark);
      margin-bottom: 1.5rem;
      font-size: 1.4rem;
    }

    .btn-action {
      background-color: var(--color-primary);
      color: var(--color-white);
      padding: 1rem 2rem;
      border: none;
      border-radius: 0.8rem;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: var(--transition-standard);
      font-weight: 600;
    }

    .btn-action:hover {
      background-color: var(--color-dark);
      color: var(--color-white);
      transform: translateY(-2px);
    }

    .status-badge {
      background: linear-gradient(135deg, #4CAF50, #45a049);
      color: var(--color-white);
      padding: 0.5rem 1.5rem;
      border-radius: 2rem;
      font-size: 1.2rem;
      font-weight: 600;
      display: inline-block;
      margin-left: 1rem;
    }

    /* Footer - Same as original */
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

      .profile-content {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .profile-details {
        grid-template-columns: 1fr;
      }

      .volunteer-avatar {
        width: 10rem;
        height: 10rem;
      }

      .volunteer-avatar i {
        font-size: 5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Header/Navigation - Same as original -->
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
            <li><a href="search_shelter.php"><i class="fa-solid fa-map-pin"></i> Shelter </a></li>
            <li><a href="donate.html"><i class="fa-solid fa-hand-holding-dollar"></i> Donate</a></li>
            <li><a href="what-to-do.html"><i class="fa-solid fa-book"></i> What to do?</a></li>
            <li><a href="about.html"><i class="fa-solid fa-users"></i> About Us</a></li>
          </ul>
          <div class="nav-actions">
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($volunteer['name']); ?>!</span>
            <a href="vol_logout.php" class="btn btn-neutral"><i class="fa-solid fa-sign-out"></i> Logout</a>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <!-- Profile Main Content -->
  <main class="profile-main">
    <div class="container">
      <!-- Profile Header -->
      <div class="profile-header">
        <div class="profile-info">
          <div class="volunteer-avatar">
            <i class="fa-solid fa-user"></i>
          </div>
          <h1><?php echo htmlspecialchars($volunteer['name']); ?></h1>
          <p><?php echo htmlspecialchars($volunteer['occupation']); ?></p>
          <div class="volunteer-id">
            Volunteer ID: <?php echo $volunteer['id']; ?>
            <span class="status-badge">Active</span>
          </div>
        </div>
      </div>

      <!-- Profile Content -->
      <div class="profile-content">
        <div class="profile-details">
          <!-- Personal Information -->
          <div class="detail-card">
            <h3><i class="fa-solid fa-user-circle"></i>Personal Information</h3>
            <div class="detail-item">
              <span class="detail-label">Full Name:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['name']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Email:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['email']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Phone:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['phone_no']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Date of Birth:</span>
              <span class="detail-value"><?php echo date('M d, Y', strtotime($volunteer['dob'])); ?></span>
            </div>
          </div>

          <!-- Professional Details -->
          <div class="detail-card">
            <h3><i class="fa-solid fa-briefcase"></i>Professional Details</h3>
            <div class="detail-item">
              <span class="detail-label">Occupation:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['occupation']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Assigned Location:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['assigned_location']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Home Address:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['address']); ?></span>
            </div>
          </div>

          <!-- Medical Information -->
          <div class="detail-card">
            <h3><i class="fa-solid fa-heart-pulse"></i>Medical Information</h3>
            <div class="detail-item">
              <span class="detail-label">Blood Group:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['blood_group']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Medical Info:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['medical_info']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Allergies:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['allergy']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Chronic Diseases:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['chronic_disease']); ?></span>
            </div>
          </div>

          <!-- Emergency Contact -->
          <div class="detail-card">
            <h3><i class="fa-solid fa-phone-square"></i>Emergency Contact</h3>
            <div class="detail-item">
              <span class="detail-label">Primary Contact:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['phone_no']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Email Contact:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['email']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Location:</span>
              <span class="detail-value"><?php echo htmlspecialchars($volunteer['assigned_location']); ?></span>
            </div>
          </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="actions-sidebar">
          <div class="action-card">
            <div class="action-icon">
              <i class="fa-solid fa-tasks"></i>
            </div>
            <h4>View Involvement</h4>
            <p>Check current volunteer involvements with victims</p>
            <a href="involvement.php" class="btn-action">See involvement</a>
          </div>

          <div class="action-card">
            <div class="action-icon">
              <i class="fa-solid fa-calendar-alt"></i>
            </div>
            <h4>Relief</h4>
            <p>See available Relief in your area</p>
            <a href="emg_relief.php" class="btn-action">See Relief</a>
          </div>

          <div class="action-card">
            <div class="action-icon">
              <i class="fa-solid fa-edit"></i>
            </div>
            <h4>Edit Profile</h4>
            <p>Update your personal information and preferences</p>
            <a href="update_volunteer_profile.php" class="btn-action">Edit Profile</a>
          </div>

          <div class="action-card">
            <div class="action-icon">
              <i class="fa-solid fa-search"></i>
            </div>
            <h4>Search Victims</h4>
            <p>Look for people who needs help</p>
            <a href="vic_search.php" class="btn-action">View Victims</a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer - Same as original -->
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
            <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
          </div>
        </div>
        
        <div class="footer-links">
          <h3>Useful Links</h3>
          <ul>
            <li><a href="about.html">About Us</a></li>
            <li><a href="#">Disaster Updates</a></li>
            <li><a href="#">How We Help</a></li>
            <li><a href="#">Volunteer</a></li>
            <li><a href="donate.html">Donate</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>
        </div>
        
        <div class="footer-links">
          <h3>Resources</h3>
          <ul>
            <li><a href="#">Emergency Preparedness</a></li>
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
        </div>
      </div>
      
      <div class="footer-bottom">
        <p>&copy; 2023 ResQ Disaster Management. All rights reserved.</p>
      </div>
    </div>
  </footer>
</body>
</html>