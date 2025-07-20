<?php
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

$volunteers = [];
$shelters = [];
$medical_responses = [];
$evacuation_supports = [];
$search_query = "";
$search_performed = false;

// Process search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_location'])) {
    $search_query = mysqli_real_escape_string($conn, trim($_POST['search_location']));
    $search_performed = true;
    
    if (!empty($search_query)) {
        // Search volunteers by assigned_location
        $sql = "SELECT * FROM Volunteer WHERE assigned_location LIKE '%$search_query%' ORDER BY name";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $volunteers[] = $row;
            }
        }
        
        // Search shelters by location
        $sql = "SELECT * FROM Shelter WHERE location LIKE '%$search_query%' ORDER BY name";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $shelters[] = $row;
            }
        }
        
        // Search medical response by location
        $sql = "SELECT * FROM Medical_Response WHERE location LIKE '%$search_query%' ORDER BY name";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $medical_responses[] = $row;
            }
        }
        
        // Search evacuation support by location
        $sql = "SELECT * FROM Evacuation_Support WHERE location LIKE '%$search_query%' ORDER BY name";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $evacuation_supports[] = $row;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="description" content="ResQ Emergency Help - Find volunteers, shelters, medical response and evacuation support in your location">
  <title>Need Help | ResQ: Chaos To Control</title>
  
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
      --color-medical: #2E7D32;
      --color-fire: #D84315;
      --color-police: #1565C0;
      --color-volunteer: #7B1FA2;
      --color-shelter: #795548;
      --color-evacuation: #FF8F00;
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
      padding: 0.6rem 1.2rem;
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

    .search-btn {
      background: none;
      border: none;
      cursor: pointer;
      color: var(--color-dark);
      padding: 0.8rem;
      border-radius: 50%;
      transition: var(--transition-standard);
    }

    /* Emergency Search Main Content */
    .emergency-search-main {
      min-height: 100vh;
      padding-top: 12rem;
      padding-bottom: 8rem;
      background: linear-gradient(135deg, var(--color-background) 0%, var(--color-light-gray) 100%);
    }

    .search-hero {
      text-align: center;
      margin-bottom: 6rem;
    }

    .search-title {
      font-family: 'Playfair Display', serif;
      font-size: 4.5rem;
      color: var(--color-dark);
      margin-bottom: 2rem;
      font-weight: 700;
    }

    .search-subtitle {
      font-size: 2rem;
      color: var(--color-alert);
      margin-bottom: 1rem;
    }

    .search-description {
      font-size: 1.6rem;
      color: var(--color-dark);
      max-width: 60rem;
      margin: 0 auto;
    }

    .search-container {
      max-width: 80rem;
      margin: 0 auto;
      background: var(--color-white);
      padding: 4rem;
      border-radius: 2rem;
      box-shadow: var(--shadow-lg);
      margin-bottom: 4rem;
    }

    .search-form {
      position: relative;
    }

    .location-input {
      width: 100%;
      padding: 2rem 2.5rem 2rem 6rem;
      font-size: 1.8rem;
      border: 2px solid var(--color-light-gray);
      border-radius: 1.5rem;
      background-color: var(--color-background);
      transition: var(--transition-standard);
      font-family: 'Poppins', sans-serif;
    }

    .location-input:focus {
      outline: none;
      border-color: var(--color-alert);
      box-shadow: 0 0 0 4px rgba(229, 57, 53, 0.1);
    }

    .search-icon {
      position: absolute;
      left: 2rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 2.2rem;
      color: var(--color-alert);
    }

    .search-button {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background-color: var(--color-alert);
      color: var(--color-white);
      border: none;
      padding: 1.5rem 3rem;
      border-radius: 1rem;
      font-size: 1.6rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition-standard);
    }

    .search-button:hover {
      background-color: #c62828;
      transform: translateY(-50%) translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .emergency-info {
      margin-top: 4rem;
      padding: 3rem;
      background-color: rgba(229, 57, 53, 0.05);
      border-radius: 1.5rem;
      border-left: 5px solid var(--color-alert);
    }

    .emergency-info h3 {
      color: var(--color-alert);
      font-size: 2rem;
      margin-bottom: 1.5rem;
      font-family: 'Playfair Display', serif;
    }

    .emergency-info p {
      color: var(--color-dark);
      font-size: 1.6rem;
      margin-bottom: 0;
    }

    /* Results Container */
    .results-container {
      max-width: 120rem;
      margin: 0 auto;
    }

    .results-overview {
      background: var(--color-white);
      padding: 3rem;
      border-radius: 1.5rem;
      box-shadow: var(--shadow-md);
      margin-bottom: 4rem;
      text-align: center;
    }

    .results-overview h2 {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      color: var(--color-dark);
      margin-bottom: 2rem;
    }

    .overview-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .stat-card {
      background: linear-gradient(135deg, var(--color-background), var(--color-light-gray));
      padding: 2rem;
      border-radius: 1rem;
      text-align: center;
    }

    .stat-number {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      font-size: 1.4rem;
      color: var(--color-primary);
    }

    .stat-card.volunteers .stat-number { color: var(--color-volunteer); }
    .stat-card.shelters .stat-number { color: var(--color-shelter); }
    .stat-card.medical .stat-number { color: var(--color-medical); }
    .stat-card.evacuation .stat-number { color: var(--color-evacuation); }

    /* Section Styles */
    .help-section {
      margin-bottom: 5rem;
    }

    .section-header {
      display: flex;
      align-items: center;
      margin-bottom: 3rem;
      padding: 2rem;
      background: var(--color-white);
      border-radius: 1rem;
      box-shadow: var(--shadow-sm);
    }

    .section-icon {
      width: 6rem;
      height: 6rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 2rem;
    }

    .section-icon i {
      font-size: 2.5rem;
      color: var(--color-white);
    }

    .section-info h3 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    .section-info .count {
      font-size: 1.4rem;
      font-weight: 600;
    }

    /* Volunteer Section */
    .volunteers .section-icon { background: linear-gradient(135deg, var(--color-volunteer), #9c27b0); }
    .volunteers .section-info h3 { color: var(--color-volunteer); }
    .volunteers .section-info .count { color: var(--color-volunteer); }

    /* Shelter Section */
    .shelters .section-icon { background: linear-gradient(135deg, var(--color-shelter), #8d6e63); }
    .shelters .section-info h3 { color: var(--color-shelter); }
    .shelters .section-info .count { color: var(--color-shelter); }

    /* Medical Section */
    .medical .section-icon { background: linear-gradient(135deg, var(--color-medical), #4caf50); }
    .medical .section-info h3 { color: var(--color-medical); }
    .medical .section-info .count { color: var(--color-medical); }

    /* Evacuation Section */
    .evacuation .section-icon { background: linear-gradient(135deg, var(--color-evacuation), #ffa726); }
    .evacuation .section-info h3 { color: var(--color-evacuation); }
    .evacuation .section-info .count { color: var(--color-evacuation); }

    /* Card Grids */
    .help-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(35rem, 1fr));
      gap: 2.5rem;
    }

    .help-card {
      background: var(--color-white);
      padding: 2.5rem;
      border-radius: 1.5rem;
      box-shadow: var(--shadow-md);
      transition: var(--transition-standard);
      position: relative;
    }

    .help-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }

    .help-card.volunteer { border-left: 5px solid var(--color-volunteer); }
    .help-card.shelter { border-left: 5px solid var(--color-shelter); }
    .help-card.medical { border-left: 5px solid var(--color-medical); }
    .help-card.evacuation { border-left: 5px solid var(--color-evacuation); }

    .card-header {
      display: flex;
      align-items: center;
      margin-bottom: 2rem;
    }

    .card-icon {
      width: 5rem;
      height: 5rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1.5rem;
    }

    .card-icon i {
      font-size: 2rem;
      color: var(--color-white);
    }

    .card-info h4 {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
      color: var(--color-dark);
      margin-bottom: 0.3rem;
    }

    .card-type {
      padding: 0.3rem 0.8rem;
      border-radius: 1rem;
      font-size: 1rem;
      font-weight: 600;
      text-transform: uppercase;
      color: var(--color-white);
    }

    .volunteer .card-icon { background: var(--color-volunteer); }
    .volunteer .card-type { background: var(--color-volunteer); }
    .shelter .card-icon { background: var(--color-shelter); }
    .shelter .card-type { background: var(--color-shelter); }
    .medical .card-icon { background: var(--color-medical); }
    .medical .card-type { background: var(--color-medical); }
    .evacuation .card-icon { background: var(--color-evacuation); }
    .evacuation .card-type { background: var(--color-evacuation); }

    .card-details {
      margin-top: 1.5rem;
    }

    .detail-row {
      display: flex;
      align-items: flex-start;
      margin-bottom: 1rem;
      padding: 0.8rem 0;
      border-bottom: 1px solid var(--color-light-gray);
    }

    .detail-row:last-child {
      border-bottom: none;
    }

    .detail-icon {
      margin-right: 1rem;
      width: 1.5rem;
      font-size: 1.4rem;
      margin-top: 0.2rem;
    }

    .volunteer .detail-icon { color: var(--color-volunteer); }
    .shelter .detail-icon { color: var(--color-shelter); }
    .medical .detail-icon { color: var(--color-medical); }
    .evacuation .detail-icon { color: var(--color-evacuation); }

    .detail-content {
      flex: 1;
    }

    .detail-label {
      font-weight: 600;
      color: var(--color-dark);
      margin-bottom: 0.2rem;
      font-size: 1.3rem;
    }

    .detail-value {
      color: var(--color-primary);
      font-size: 1.4rem;
    }

    .contact-highlight {
      margin-top: 1.5rem;
      padding: 1.2rem;
      border-radius: 1rem;
      text-align: center;
    }

    .volunteer .contact-highlight { background: rgba(123, 31, 162, 0.1); }
    .shelter .contact-highlight { background: rgba(121, 85, 72, 0.1); }
    .medical .contact-highlight { background: rgba(46, 125, 50, 0.1); }
    .evacuation .contact-highlight { background: rgba(255, 143, 0, 0.1); }

    .contact-number {
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 0.3rem;
    }

    .volunteer .contact-number { color: var(--color-volunteer); }
    .shelter .contact-number { color: var(--color-shelter); }
    .medical .contact-number { color: var(--color-medical); }
    .evacuation .contact-number { color: var(--color-evacuation); }

    .contact-label {
      font-size: 1.1rem;
      color: var(--color-dark);
    }

    .status-badge {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      padding: 0.5rem 1rem;
      border-radius: 1.5rem;
      font-size: 1rem;
      font-weight: 600;
      text-transform: uppercase;
    }

    .shelter .status-badge {
      background: rgba(121, 85, 72, 0.1);
      color: var(--color-shelter);
      border: 2px solid var(--color-shelter);
    }

    .availability-badge {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      padding: 0.5rem 1rem;
      border-radius: 1.5rem;
      font-size: 1rem;
      font-weight: 600;
    }

    .medical .availability-badge {
      background: rgba(46, 125, 50, 0.1);
      color: var(--color-medical);
      border: 2px solid var(--color-medical);
    }

    .evacuation .availability-badge {
      background: rgba(255, 143, 0, 0.1);
      color: var(--color-evacuation);
      border: 2px solid var(--color-evacuation);
    }

    .no-results {
      text-align: center;
      padding: 4rem;
      background: var(--color-white);
      border-radius: 1.5rem;
      box-shadow: var(--shadow-md);
    }

    .no-results i {
      font-size: 6rem;
      color: var(--color-light-gray);
      margin-bottom: 2rem;
    }

    .no-results h3 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      color: var(--color-dark);
      margin-bottom: 1rem;
    }

    .no-results p {
      color: var(--color-primary);
      font-size: 1.6rem;
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

      .search-title {
        font-size: 3.5rem;
      }

      .search-container {
        padding: 3rem 2rem;
        margin: 0 1rem;
      }

      .location-input {
        padding: 1.8rem 2rem 1.8rem 5rem;
        font-size: 1.6rem;
      }

      .search-button {
        position: static;
        width: 100%;
        margin-top: 2rem;
        transform: none;
      }

      .search-button:hover {
        transform: translateY(-2px);
      }

      .help-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .help-card {
        padding: 2rem;
      }

      .status-badge,
      .availability-badge {
        position: static;
        display: inline-block;
        margin-top: 1rem;
      }

      .overview-stats {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 480px) {
      .search-title {
        font-size: 2.8rem;
      }

      .search-container {
        padding: 2rem 1.5rem;
      }

      .overview-stats {
        grid-template-columns: 1fr;
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
            <li><a href="emer_cont.html"><i class="fa-solid fa-life-ring"></i> Emergency Contacts</a></li>
            <li><a href="search_shelter.php"><i class="fa-solid fa-map-pin"></i> Shelter</a></li>
            <li><a href="donate.html"><i class="fa-solid fa-hand-holding-dollar"></i> Donate</a></li>
            <li><a href="what-to-do.html"><i class="fa-solid fa-book"></i> What to do?</a></li>
            <li><a href="about.html"><i class="fa-solid fa-users"></i> About Us</a></li>
          </ul>
          <div class="nav-actions">
            <!-- <button class="search-btn"><i class="fa-solid fa-search"></i></button> -->
            <a href="needhelp.php" class="btn btn-alert"><i class="fa-solid fa-circle-exclamation"></i>Need Help</a>
            <a href="login.php" class="btn btn-neutral"><i class="fa-solid fa-sign-in"></i>Login</a>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <!-- Emergency Search Main Content -->
  <main class="emergency-search-main">
    <div class="container">
      <!-- Search Hero -->
      <div class="search-hero">
        <h1 class="search-title">Need Help?</h1>
        <p class="search-subtitle">Find All Emergency Resources</p>
        <p class="search-description">
          Search for volunteers, shelters, medical response teams, and evacuation support in your area. Get comprehensive emergency assistance information for your location.
        </p>
      </div>

      <!-- Search Form -->
      <div class="search-container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="search-form">
          <i class="fa-solid fa-map-marker-alt search-icon"></i>
          <input 
            type="text" 
            name="search_location"
            class="location-input" 
            placeholder="Enter your location (e.g., 'Downtown', 'City Center', 'Main Street')" 
            value="<?php echo htmlspecialchars($search_query); ?>"
            required>
          <button type="submit" class="search-button">
            <i class="fa-solid fa-search"></i> Find Help
          </button>
        </form>

        <div class="emergency-info">
          <h3><i class="fa-solid fa-exclamation-triangle"></i> Life-Threatening Emergency</h3>
          <p>
            For immediate life-threatening emergencies, call <strong>911</strong> immediately. 
            This search helps you find all available emergency resources and support in your area.
          </p>
        </div>
      </div>

      <!-- Search Results -->
      <?php if ($search_performed): ?>
        <div class="results-container">
          <!-- Results Overview -->
          <div class="results-overview">
            <h2>Emergency Resources in "<?php echo htmlspecialchars($search_query); ?>"</h2>
            <div class="overview-stats">
              <div class="stat-card volunteers">
                <div class="stat-number"><?php echo count($volunteers); ?></div>
                <div class="stat-label">Volunteers</div>
              </div>
              <div class="stat-card shelters">
                <div class="stat-number"><?php echo count($shelters); ?></div>
                <div class="stat-label">Shelters</div>
              </div>
              <div class="stat-card medical">
                <div class="stat-number"><?php echo count($medical_responses); ?></div>
                <div class="stat-label">Medical Teams</div>
              </div>
              <div class="stat-card evacuation">
                <div class="stat-number"><?php echo count($evacuation_supports); ?></div>
                <div class="stat-label">Evacuation Support</div>
              </div>
            </div>
          </div>

          <!-- Volunteers Section -->
          <?php if (count($volunteers) > 0): ?>
            <div class="help-section volunteers">
              <div class="section-header">
                <div class="section-icon">
                  <i class="fa-solid fa-hands-helping"></i>
                </div>
                <div class="section-info">
                  <h3>Available Volunteers</h3>
                  <p class="count"><?php echo count($volunteers); ?> volunteer(s) found</p>
                </div>
              </div>
              
              <div class="help-grid">
                <?php foreach ($volunteers as $volunteer): ?>
                  <div class="help-card volunteer">
                    <div class="card-header">
                      <div class="card-icon">
                        <i class="fa-solid fa-user-plus"></i>
                      </div>
                      <div class="card-info">
                        <h4><?php echo htmlspecialchars($volunteer['name']); ?></h4>
                        <span class="card-type">Volunteer</span>
                      </div>
                    </div>

                    <div class="card-details">
                      <div class="detail-row">
                        <i class="fa-solid fa-briefcase detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Occupation</div>
                          <div class="detail-value"><?php echo htmlspecialchars($volunteer['occupation']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-map-marker-alt detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Assigned Location</div>
                          <div class="detail-value"><?php echo htmlspecialchars($volunteer['assigned_location']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-tint detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Blood Group</div>
                          <div class="detail-value"><?php echo htmlspecialchars($volunteer['blood_group']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-id-badge detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Volunteer ID</div>
                          <div class="detail-value">#<?php echo htmlspecialchars($volunteer['id']); ?></div>
                        </div>
                      </div>
                    </div>

                    <div class="contact-highlight">
                      <div class="contact-number"><?php echo htmlspecialchars($volunteer['phone_no']); ?></div>
                      <div class="contact-label">Contact Number</div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Shelters Section -->
          <?php if (count($shelters) > 0): ?>
            <div class="help-section shelters">
              <div class="section-header">
                <div class="section-icon">
                  <i class="fa-solid fa-home"></i>
                </div>
                <div class="section-info">
                  <h3>Emergency Shelters</h3>
                  <p class="count"><?php echo count($shelters); ?> shelter(s) found</p>
                </div>
              </div>
              
              <div class="help-grid">
                <?php foreach ($shelters as $shelter): ?>
                  <div class="help-card shelter">
                    <div class="status-badge"><?php echo htmlspecialchars($shelter['status']); ?></div>
                    
                    <div class="card-header">
                      <div class="card-icon">
                        <i class="fa-solid fa-shield-alt"></i>
                      </div>
                      <div class="card-info">
                        <h4><?php echo htmlspecialchars($shelter['name']); ?></h4>
                        <span class="card-type">Emergency Shelter</span>
                      </div>
                    </div>

                    <div class="card-details">
                      <div class="detail-row">
                        <i class="fa-solid fa-map-marker-alt detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Location</div>
                          <div class="detail-value"><?php echo htmlspecialchars($shelter['location']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-info-circle detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Status</div>
                          <div class="detail-value"><?php echo htmlspecialchars($shelter['status']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-id-badge detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Shelter ID</div>
                          <div class="detail-value">#<?php echo htmlspecialchars($shelter['id']); ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Medical Response Section -->
          <?php if (count($medical_responses) > 0): ?>
            <div class="help-section medical">
              <div class="section-header">
                <div class="section-icon">
                  <i class="fa-solid fa-user-md"></i>
                </div>
                <div class="section-info">
                  <h3>Medical Response Teams</h3>
                  <p class="count"><?php echo count($medical_responses); ?> team(s) found</p>
                </div>
              </div>
              
              <div class="help-grid">
                <?php foreach ($medical_responses as $medical): ?>
                  <div class="help-card medical">
                    <div class="availability-badge"><?php echo htmlspecialchars($medical['availability_hours']); ?></div>
                    
                    <div class="card-header">
                      <div class="card-icon">
                        <i class="fa-solid fa-heartbeat"></i>
                      </div>
                      <div class="card-info">
                        <h4><?php echo htmlspecialchars($medical['name']); ?></h4>
                        <span class="card-type">Medical Response</span>
                      </div>
                    </div>

                    <div class="card-details">
                      <div class="detail-row">
                        <i class="fa-solid fa-map-marker-alt detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Service Location</div>
                          <div class="detail-value"><?php echo htmlspecialchars($medical['location']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-clock detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Availability</div>
                          <div class="detail-value"><?php echo htmlspecialchars($medical['availability_hours']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-id-badge detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Response ID</div>
                          <div class="detail-value">#<?php echo htmlspecialchars($medical['id']); ?></div>
                        </div>
                      </div>
                    </div>

                    <div class="contact-highlight">
                      <div class="contact-number"><?php echo htmlspecialchars($medical['contact_no']); ?></div>
                      <div class="contact-label">Emergency Contact</div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Evacuation Support Section -->
          <?php if (count($evacuation_supports) > 0): ?>
            <div class="help-section evacuation">
              <div class="section-header">
                <div class="section-icon">
                  <i class="fa-solid fa-truck"></i>
                </div>
                <div class="section-info">
                  <h3>Evacuation Support</h3>
                  <p class="count"><?php echo count($evacuation_supports); ?> service(s) found</p>
                </div>
              </div>
              
              <div class="help-grid">
                <?php foreach ($evacuation_supports as $evacuation): ?>
                  <div class="help-card evacuation">
                    <div class="availability-badge"><?php echo htmlspecialchars($evacuation['availability_hours']); ?></div>
                    
                    <div class="card-header">
                      <div class="card-icon">
                        <i class="fa-solid fa-people-carry"></i>
                      </div>
                      <div class="card-info">
                        <h4><?php echo htmlspecialchars($evacuation['name']); ?></h4>
                        <span class="card-type">Evacuation Support</span>
                      </div>
                    </div>

                    <div class="card-details">
                      <div class="detail-row">
                        <i class="fa-solid fa-map-marker-alt detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Service Location</div>
                          <div class="detail-value"><?php echo htmlspecialchars($evacuation['location']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-clock detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Availability</div>
                          <div class="detail-value"><?php echo htmlspecialchars($evacuation['availability_hours']); ?></div>
                        </div>
                      </div>

                      <div class="detail-row">
                        <i class="fa-solid fa-id-badge detail-icon"></i>
                        <div class="detail-content">
                          <div class="detail-label">Service ID</div>
                          <div class="detail-value">#<?php echo htmlspecialchars($evacuation['id']); ?></div>
                        </div>
                      </div>
                    </div>

                    <div class="contact-highlight">
                      <div class="contact-number"><?php echo htmlspecialchars($evacuation['contact_no']); ?></div>
                      <div class="contact-label">Evacuation Contact</div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- No Results Message -->
          <?php if (count($volunteers) == 0 && count($shelters) == 0 && count($medical_responses) == 0 && count($evacuation_supports) == 0): ?>
            <div class="no-results">
              <i class="fa-solid fa-search"></i>
              <h3>No Emergency Resources Found</h3>
              <p>No volunteers, shelters, medical teams, or evacuation support found in this location. Try searching with a broader area or contact emergency services directly.</p>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-about">
          <div class="footer-logo">
            <div class="logo-placeholder"> <img src="img/roundlogo.png" alt="ResQ Logo"></div>
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
          <h3>Quick Links</h3>
          <ul>
            <li><a href="about.html">About Us</a></li>
            <li><a href="what-to-do.html">Disaster Updates</a></li>
            <li><a href="#">How We Help</a></li>
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