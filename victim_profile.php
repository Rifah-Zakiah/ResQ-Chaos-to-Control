<?php
session_start();

// Check if victim is logged in
if (!isset($_SESSION['victim_logged_in']) || $_SESSION['victim_logged_in'] !== true) {
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

// Fetch victim details
$victim_id = $_SESSION['victim_id'];
$sql = "SELECT * FROM Victim WHERE id = '$victim_id'";
$result = $conn->query($sql);
$victim = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Victim Profile | ResQ</title>
  <link rel="stylesheet" href="css/rstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    /* Profile specific styles */
    .profile-container {
      max-width: 1200px;
      margin: 160px auto 80px;
      padding: 0 2rem;
    }

    .profile-header {
      background: linear-gradient(135deg, #E53935 0%, #c62828 100%);
      color: white;
      padding: 4rem 2rem;
      border-radius: 2rem;
      margin-bottom: 3rem;
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

    .victim-avatar {
      width: 12rem;
      height: 12rem;
      background-color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 2rem;
      position: relative;
      z-index: 2;
    }

    .victim-avatar i {
      font-size: 6rem;
      color: #E53935;
    }

    .profile-info {
      position: relative;
      z-index: 2;
    }

    .victim-id {
      background-color: rgba(255,255,255,0.2);
      padding: 0.8rem 1.5rem;
      border-radius: 2rem;
      display: inline-block;
      margin-top: 1rem;
      font-weight: 600;
    }

    .status-badge {
      background: linear-gradient(135deg, #ff9800, #f57c00);
      color: white;
      padding: 0.5rem 1.5rem;
      border-radius: 2rem;
      font-size: 1.2rem;
      font-weight: 600;
      margin-left: 1rem;
    }

    .requirement-highlight {
      background: linear-gradient(135deg, #ff9800, #f57c00);
      color: white;
      padding: 2rem;
      border-radius: 1.5rem;
      margin-bottom: 3rem;
      text-align: center;
    }

    .requirement-highlight h3 {
      color: white;
      margin-bottom: 1rem;
      font-size: 2rem;
    }

    .profile-content {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 3rem;
    }

    .profile-details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
    }

    .detail-card {
      background: white;
      padding: 2.5rem;
      border-radius: 1.5rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .detail-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }

    .detail-card h3 {
      color: var(--color-primary);
      font-size: 1.8rem;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
    }

    .detail-card h3 i {
      margin-right: 1rem;
      font-size: 2rem;
      color: #E53935;
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
      background: white;
      padding: 2rem;
      border-radius: 1.5rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      text-align: center;
      transition: all 0.3s ease;
    }

    .action-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }

    .action-icon {
      width: 6rem;
      height: 6rem;
      background: linear-gradient(135deg, #E53935, #ff6b6b);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
    }

    .action-icon i {
      font-size: 2.5rem;
      color: white;
    }

    .action-card h4 {
      color: var(--color-primary);
      margin-bottom: 1rem;
      font-size: 1.6rem;
    }

    .action-card p {
      color: var(--color-dark);
      margin-bottom: 1.5rem;
      font-size: 1.3rem;
    }

    .btn-action {
      background-color: var(--color-primary);
      color: white;
      padding: 1rem 2rem;
      border: none;
      border-radius: 0.8rem;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      font-weight: 600;
    }

    .btn-action:hover {
      background-color: var(--color-dark);
      color: white;
      transform: translateY(-2px);
    }

    .welcome-text {
      color: var(--color-primary);
      font-weight: 600;
      margin-right: 1rem;
    }

    @media (max-width: 768px) {
      .profile-content {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .profile-details {
        grid-template-columns: 1fr;
      }

      .victim-avatar {
        width: 10rem;
        height: 10rem;
      }

      .victim-avatar i {
        font-size: 5rem;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
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
          <span class="welcome-text">Welcome, <?php echo htmlspecialchars($victim['name']); ?>!</span>
          <a href="vic_logout.php" class="btn btn-neutral"><i class="fa-solid fa-sign-out"></i> Logout</a>
        </div>
      </nav>
    </div>
  </div>
</header>

<!-- Profile Content -->
<div class="profile-container">
  <!-- Profile Header -->
  <div class="profile-header">
    <div class="profile-info">
      <div class="victim-avatar">
        <i class="fa-solid fa-hand-dots"></i>
      </div>
      <h1><?php echo htmlspecialchars($victim['name']); ?></h1>
      <p><?php echo htmlspecialchars($victim['occupation']); ?></p>
      <div class="victim-id">
        Victim ID: <?php echo $victim['id']; ?>
        <span class="status-badge">Needs Help</span>
      </div>
    </div>
  </div>

  <!-- Help Requirement Highlight -->
  <div class="requirement-highlight">
    <h3><i class="fa-solid fa-exclamation-triangle"></i> Help Required</h3>
    <p><strong><?php echo htmlspecialchars($victim['requirement']); ?></strong></p>
  </div>

  <!-- Profile Content -->
  <div class="profile-content">
    <div class="profile-details">
      <!-- Personal Information -->
      <div class="detail-card">
        <h3><i class="fa-solid fa-user-circle"></i>Personal Information</h3>
        <div class="detail-item">
          <span class="detail-label">Full Name:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['name']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Email:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['email']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Phone:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['phone_no']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Date of Birth:</span>
          <span class="detail-value"><?php echo date('M d, Y', strtotime($victim['dob'])); ?></span>
        </div>
      </div>

      <!-- Location Details -->
      <div class="detail-card">
        <h3><i class="fa-solid fa-map-marker-alt"></i>Location Details</h3>
        <div class="detail-item">
          <span class="detail-label">Current Location:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['current_location']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Home Address:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['address']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Occupation:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['occupation']); ?></span>
        </div>
      </div>

      <!-- Medical Information -->
      <div class="detail-card">
        <h3><i class="fa-solid fa-heart-pulse"></i>Medical Information</h3>
        <div class="detail-item">
          <span class="detail-label">Blood Group:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['blood_group']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Medical Info:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['medical_info']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Allergies:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['allergy']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Chronic Diseases:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['chronic_disease']); ?></span>
        </div>
      </div>

      <!-- Emergency Contact -->
      <div class="detail-card">
        <h3><i class="fa-solid fa-phone-square"></i>Emergency Contact</h3>
        <div class="detail-item">
          <span class="detail-label">Primary Contact:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['phone_no']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Email Contact:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['email']); ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Current Location:</span>
          <span class="detail-value"><?php echo htmlspecialchars($victim['current_location']); ?></span>
        </div>
      </div>
    </div>

    <!-- Actions Sidebar -->
    <div class="actions-sidebar">
      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-hand-holding-heart"></i>
        </div>
        <h4>Immediate Help</h4>
        <p>Search for immediate help that you need</p>
        <a href="needhelp.php" class="btn-action">Need help</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-search"></i>
        </div>
        <h4>Search Volunteers</h4>
        <p>Quick access to Volunteers working near you</p>
        <a href="vol_search.php" class="btn-action">See Volunteers</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-edit"></i>
        </div>
        <h4>Edit Profile</h4>
        <p>Update your personal information and emergency contacts</p>
        <a href="update_victim_profile.php" class="btn-action">Edit Profile</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-tasks"></i>
        </div>
        <h4>View Involvement</h4>
        <p>Check current volunteer involvements with victims</p>
        <a href="involvement.php" class="btn-action">View involvement</a>
      </div>

      <!-- <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-map-location-dot"></i>
        </div>
        <h4>See Shelter</h4>
        <p>See Shelter situation near you</p>
        <a href="search_shelter.php" class="btn-action">Update Location</a>
      </div> -->
      
    </div>
  </div>
</div>

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
          <li><a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
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
  </div>
</footer>

</body>
</html>