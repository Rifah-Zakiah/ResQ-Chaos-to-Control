<?php
session_start();

// Check if volunteer is logged in
if (!isset($_SESSION['volunteer_logged_in']) || $_SESSION['volunteer_logged_in'] !== true) {
    header("Location: volunteerlogin.php");
    exit();
}

// Database configuration for fetching volunteer details
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Volunteer Dashboard | ResQ</title>
  <link rel="stylesheet" href="css/rstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    .dashboard-container {
      max-width: 1200px;
      margin: 120px auto 80px;
      padding: 0 2rem;
    }
    .welcome-section {
      background-color: var(--color-white);
      padding: 3rem;
      border-radius: 1rem;
      box-shadow: var(--shadow-md);
      margin-bottom: 3rem;
      text-align: center;
    }
    .welcome-section h1 {
      color: var(--color-primary);
      margin-bottom: 1rem;
    }
    .volunteer-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }
    .info-card {
      background-color: var(--color-white);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: var(--shadow-md);
    }
    .info-card h3 {
      color: var(--color-primary);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
    }
    .info-card h3 i {
      margin-right: 1rem;
      color: var(--color-alert);
    }
    .info-item {
      display: flex;
      justify-content: space-between;
      padding: 0.5rem 0;
      border-bottom: 1px solid var(--color-light-gray);
    }
    .info-item:last-child {
      border-bottom: none;
    }
    .info-label {
      font-weight: 600;
      color: var(--color-dark);
    }
    .info-value {
      color: var(--color-primary);
    }
    .actions-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
    }
    .action-card {
      background-color: var(--color-white);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: var(--shadow-md);
      text-align: center;
      transition: var(--transition-standard);
    }
    .action-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }
    .action-icon {
      font-size: 3rem;
      color: var(--color-alert);
      margin-bottom: 1rem;
    }
    .action-card h4 {
      color: var(--color-primary);
      margin-bottom: 1rem;
    }
    .action-card p {
      color: var(--color-dark);
      margin-bottom: 1.5rem;
    }
    .btn-action {
      background-color: var(--color-primary);
      color: var(--color-white);
      padding: 1rem 2rem;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: var(--transition-standard);
    }
    .btn-action:hover {
      background-color: var(--color-dark);
      color: var(--color-white);
    }
    .logout-btn {
      background-color: var(--color-alert);
      color: var(--color-white);
      padding: 1rem 2rem;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-top: 2rem;
    }
    .logout-btn:hover {
      background-color: #c62828;
      color: var(--color-white);
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
            <span style="color: var(--color-primary); margin-right: 1rem;">Welcome, <?php echo htmlspecialchars($volunteer['name']); ?>!</span>
            <a href="vol_logout.php" class="btn btn-neutral"><i class="fa-solid fa-sign-out"></i> Logout</a>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <!-- Dashboard Content -->
  <main class="dashboard-container">
    <div class="welcome-section">
      <h1>Volunteer Dashboard</h1>
      <p>Welcome back, <?php echo htmlspecialchars($volunteer['name']); ?>! Your volunteer ID is: <strong><?php echo $volunteer['id']; ?></strong></p>
    </div>

    <div class="volunteer-info">
      <div class="info-card">
        <h3><i class="fa-solid fa-user"></i>Personal Information</h3>
        <div class="info-item">
          <span class="info-label">Name:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['name']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Email:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['email']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Phone:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['phone_no']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Date of Birth:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['dob']); ?></span>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fa-solid fa-briefcase"></i>Professional Details</h3>
        <div class="info-item">
          <span class="info-label">Occupation:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['occupation']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Assigned Location:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['assigned_location']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Address:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['address']); ?></span>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fa-solid fa-heart-pulse"></i>Medical Information</h3>
        <div class="info-item">
          <span class="info-label">Blood Group:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['blood_group']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Medical Info:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['medical_info']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Allergies:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['allergy']); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Chronic Disease:</span>
          <span class="info-value"><?php echo htmlspecialchars($volunteer['chronic_disease']); ?></span>
        </div>
      </div>
    </div>

    <div class="actions-section">
      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-tasks"></i>
        </div>
        <h4>View Assignments</h4>
        <p>Check your current volunteer assignments and ongoing tasks.</p>
        <a href="#" class="btn-action">View Assignments</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-calendar-plus"></i>
        </div>
        <h4>Schedule Availability</h4>
        <p>Update your availability for upcoming volunteer opportunities.</p>
        <a href="#" class="btn-action">Set Schedule</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-chart-line"></i>
        </div>
        <h4>Activity Report</h4>
        <p>View your volunteer hours and impact statistics.</p>
        <a href="#" class="btn-action">View Report</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-edit"></i>
        </div>
        <h4>Update Profile</h4>
        <p>Edit your personal information and volunteer preferences.</p>
        <a href="#" class="btn-action">Edit Profile</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-bell"></i>
        </div>
        <h4>Emergency Alerts</h4>
        <p>Receive and respond to emergency volunteer requests.</p>
        <a href="#" class="btn-action">View Alerts</a>
      </div>

      <div class="action-card">
        <div class="action-icon">
          <i class="fa-solid fa-users"></i>
        </div>
        <h4>Team Communication</h4>
        <p>Connect with other volunteers and coordination teams.</p>
        <a href="#" class="btn-action">Join Chat</a>
      </div>
    </div>

    <div style="text-align: center;">
      <a href="logout.php" class="logout-btn">
        <i class="fa-solid fa-sign-out"></i> Logout
      </a>
    </div>
  </main>

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