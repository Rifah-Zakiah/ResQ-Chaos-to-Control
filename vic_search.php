<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "db_dmrs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$search_query = "";
$victims = array();

// Process search when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_query = sanitize_input($_GET['search']);
    
    // Prepare SQL query with search conditions
    $sql = "SELECT * FROM Victim WHERE name LIKE ? OR current_location LIKE ?";
    $stmt = $conn->prepare($sql);
    
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $victims[] = $row;
        }
    }
    
    $stmt->close();
}

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="description" content="Search for victims in the ResQ network. Find victims by name or location to coordinate disaster response efforts.">
  <title>Victim Search | ResQ</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/rstyle.css">
  <link rel="icon" href="img/roundlogo.png">
  
  <style>
    /* Victim Search Specific Styles */
    .search-victim-section {
      padding: 80px 0;
      background-color: #F7F7F7;
    }
    
    .search-container {
      max-width: 800px;
      margin: 0 auto 40px;
      position: relative;
    }
    
    .search-input {
      width: 100%;
      padding: 15px 25px;
      border: 2px solid #ddd;
      border-radius: 50px;
      font-size: 1rem;
      font-family: 'Poppins', sans-serif;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    
    .search-input:focus {
      border-color: #C1B7AD;
      box-shadow: 0 4px 20px rgba(52, 152, 219, 0.2);
      outline: none;
    }
    
    .search-btn {
      position: absolute;
      right: 5px;
      top: 5px;
      background-color: #C1B7AD;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 50px;
      cursor: pointer;
      font-size: 1.2rem;
      color: #141311;
      transition: background-color 0.3s;
    }
    
    .search-btn:hover {
      background-color: #8a837c;
    }
    
    .results-count {
      text-align: center;
      margin-bottom: 30px;
      color: #7f8c8d;
      font-size: 1.1rem;
    }
    
    .victims-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }
    
    .victim-card {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .victim-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }
    
    .victim-header {
      background-color: #C1B7AD;
      color: #141311;
      padding: 20px;
      position: relative;
    }
    
    .victim-name {
      margin: 0;
      font-size: 1.8rem;
      font-weight: 600;
    }
    
    .victim-location {
      display: flex;
      align-items: center;
      margin-top: 5px;
      font-size: 1rem;
      opacity: 0.9;
    }
    
    .victim-location i {
      margin-right: 8px;
    }
    
    .victim-body {
      padding: 20px;
    }
    
    .victim-details {
      margin-bottom: 15px;
    }
    
    .detail-row {
      display: flex;
      margin-bottom: 10px;
    }
    
    .detail-label {
      font-weight: 600;
      width: 120px;
      color: #555;
    }
    
    .detail-value {
      flex: 1;
    }
    
    .requirement-value {
      color: #e74c3c;
      font-weight: bold;
    }
    
    .blood-group {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 4px;
      background-color: #e74c3c;
      color: white;
      font-weight: bold;
    }
    
    .victim-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      border-top: 1px solid #eee;
      padding-top: 20px;
    }
    
    .contact-btn {
      background-color: #C1B7AD;
      color: #141311;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
    }
    
    .contact-btn i {
      margin-right: 5px;
    }
    
    .contact-btn:hover {
      background-color: #8a837c;
    }
    
    .help-btn {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
    }
    
    .help-btn:hover {
      background-color: #c0392b;
    }
    
    .no-results {
      text-align: center;
      padding: 50px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      grid-column: 1 / -1;
    }
    
    .no-results-icon {
      font-size: 3rem;
      color: #ddd;
      margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
      .victims-grid {
        grid-template-columns: 1fr;
      }
      
      .detail-row {
        flex-direction: column;
      }
      
      .detail-label {
        width: 100%;
        margin-bottom: 5px;
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
            <a href="needhelp.php" class="btn btn-alert"><i class="fa-solid fa-circle-exclamation"></i> Need Help</a>
            <a href="login.php" class="btn btn-neutral"><i class="fa-solid fa-sign-in"></i> Login</a>
          </div>
        </nav>
        
        <div class="nav-mobile">
          <a href="needhelp.php" class="help-btn-mobile"><i class="fa-solid fa-circle-exclamation"></i></a>
          <button id="menu-toggle" class="menu-toggle" aria-label="Menu">
            <i class="fa-solid fa-bars"></i>
          </button>
        </div>
      </div>
      
      <!-- Mobile menu (hidden by default) -->
      <div id="mobile-menu" class="mobile-menu">
        <nav>
          <ul>
            <li><a href="resq.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="emer_cont.html"><i class="fa-solid fa-life-ring"></i> Emergency Contacts</a></li>
            <li><a href="search_shelter.php"><i class="fa-solid fa-map-pin"></i> Shelter</a></li>
            <li><a href="donate.html"><i class="fa-solid fa-hand-holding-dollar"></i> Donate</a></li>
            <li><a href="what-to-do.html"><i class="fa-solid fa-book"></i> What to do?</a></li>
            <li><a href="about.html"><i class="fa-solid fa-users"></i> About Us</a></li>
            <li class="divider"></li>
            <li><a href="needhelp.php" class="mobile-alert-btn"><i class="fa-solid fa-circle-exclamation"></i> Need Help</a></li>
            <li><a href="login.php"><i class="fa-solid fa-sign-in"></i> Login</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
    <br><br>
  <!-- Victim Search Section -->
  <section class="search-victim-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Search Victims</h2>
        <p class="section-subtitle">Find victims by name or location to coordinate disaster response</p>
      </div>
      
      <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="search-container">
        <input 
          type="text" 
          class="search-input" 
          name="search" 
          placeholder="Search by victim name or location..." 
          value="<?php echo htmlspecialchars($search_query); ?>"
        >
        <button type="submit" class="search-btn">
           Search
        </button>
      </form>
      
      <?php if (!empty($search_query)): ?>
        <div class="results-count">
          <?php echo count($victims); ?> victim(s) found matching "<?php echo htmlspecialchars($search_query); ?>"
        </div>
      <?php endif; ?>
      
      <?php if (!empty($victims)): ?>
        <div class="victims-grid">
          <?php foreach ($victims as $victim): 
            // Calculate age from date of birth
            $dob = new DateTime($victim['dob']);
            $today = new DateTime();
            $age = $dob->diff($today)->y;
          ?>
            <div class="victim-card">
              <div class="victim-header">
                <h3 class="victim-name"><?php echo htmlspecialchars($victim['name']); ?></h3>
                <div class="victim-location">
                  <i class="fas fa-map-marker-alt"></i>
                  <?php echo htmlspecialchars($victim['current_location']); ?>
                </div>
              </div>
              <div class="victim-body">
                <div class="victim-details">
                  <div class="detail-row">
                    <span class="detail-label">Age:</span>
                    <span class="detail-value"><?php echo $age; ?> years</span>
                  </div>
                  <div class="detail-row">
                    <span class="detail-label">Occupation:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($victim['occupation']); ?></span>
                  </div>
                  <div class="detail-row">
                    <span class="detail-label">Blood Group:</span>
                    <span class="detail-value">
                      <span class="blood-group"><?php echo htmlspecialchars($victim['blood_group']); ?></span>
                    </span>
                  </div>
                  <div class="detail-row">
                    <span class="detail-label">Immediate Needs:</span>
                    <span class="detail-value requirement-value"><?php echo htmlspecialchars($victim['requirement']); ?></span>
                  </div>
                  <div class="detail-row">
                    <span class="detail-label">Medical Info:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($victim['medical_info']); ?></span>
                  </div>
                  <div class="detail-row">
                    <span class="detail-label">Allergies:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($victim['allergy']); ?></span>
                  </div>
                </div>
                <div class="victim-actions">
                  <a href="tel:<?php echo htmlspecialchars($victim['phone_no']); ?>" class="contact-btn">
                    <i class="fas fa-phone"></i> Call
                  </a>
                  <a href="mailto:<?php echo htmlspecialchars($victim['email']); ?>" class="contact-btn">
                    <i class="fas fa-envelope"></i> Email
                  </a>
                  <a href="provide_help.php?id=<?php echo $victim['id']; ?>" class="help-btn">
                    <i class="fas fa-hands-helping"></i> Help
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php elseif (!empty($search_query)): ?>
        <div class="no-results">
          <div class="no-results-icon">
            <i class="fas fa-user-slash"></i>
          </div>
          <h3>No victims found</h3>
          <p>We couldn't find any victims matching "<?php echo htmlspecialchars($search_query); ?>"</p>
        </div>
      <?php else: ?>
        <div class="no-results">
          <div class="no-results-icon">
            <i class="fas fa-search"></i>
          </div>
          <h3>Search for victims</h3>
          <p>Enter a name or location in the search box above to find victims</p>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-about">
          <div class="footer-logo">
            <div class="logo-placeholder">
              <img src="img/roundlogo.png" alt="ResQ Logo">
            </div>
            <div class="logo-text">
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
    // Mobile menu toggle functionality
    document.getElementById('menu-toggle').addEventListener('click', function() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
    });
  </script>
</body>
</html>