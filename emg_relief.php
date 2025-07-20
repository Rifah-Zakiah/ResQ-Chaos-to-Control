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

$search_results = [];
$search_query = "";
$search_performed = false;

// Process search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_query'])) {
    $search_query = mysqli_real_escape_string($conn, trim($_POST['search_query']));
    $search_performed = true;
    
    if (!empty($search_query)) {
        // Search by both location AND type for comprehensive results
        $sql = "SELECT * FROM Relief WHERE location LIKE '%$search_query%' OR type LIKE '%$search_query%' ORDER BY type, location";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $search_results[] = $row;
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
  <meta name="description" content="ResQ Emergency Relief Search - Find relief supplies and distribution centers in your location">
  <title>Emergency Relief Supplies | ResQ: Chaos To Control</title>
  
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
      --color-relief: #2E7D32;
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
      color: var(--color-relief);
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

    .search-input {
      width: 100%;
      padding: 2rem 2.5rem 2rem 6rem;
      font-size: 1.8rem;
      border: 2px solid var(--color-light-gray);
      border-radius: 1.5rem;
      background-color: var(--color-background);
      transition: var(--transition-standard);
      font-family: 'Poppins', sans-serif;
    }

    .search-input:focus {
      outline: none;
      border-color: var(--color-relief);
      box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
    }

    .search-icon {
      position: absolute;
      left: 2rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 2.2rem;
      color: var(--color-relief);
    }

    .search-button {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background-color: var(--color-relief);
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
      background-color: #1b5e20;
      transform: translateY(-50%) translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .search-examples {
      margin-top: 2rem;
      padding: 2rem;
      background: rgba(46, 125, 50, 0.05);
      border-radius: 1rem;
      border-left: 4px solid var(--color-relief);
    }

    .search-examples h4 {
      color: var(--color-relief);
      font-size: 1.6rem;
      margin-bottom: 1rem;
      font-family: 'Playfair Display', serif;
    }

    .search-examples p {
      color: var(--color-dark);
      font-size: 1.4rem;
      margin-bottom: 0.5rem;
    }

    .search-examples strong {
      color: var(--color-relief);
    }

    /* Search Results */
    .results-container {
      max-width: 80rem;
      margin: 0 auto;
    }

    .results-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .results-title {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      color: var(--color-dark);
      margin-bottom: 1rem;
    }

    .results-count {
      font-size: 1.6rem;
      color: var(--color-relief);
    }

    .relief-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(35rem, 1fr));
      gap: 3rem;
      margin-bottom: 4rem;
    }

    .relief-card {
      background: var(--color-white);
      padding: 3rem;
      border-radius: 1.5rem;
      box-shadow: var(--shadow-md);
      transition: var(--transition-standard);
      border-left: 5px solid var(--color-relief);
      position: relative;
    }

    .relief-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }

    .relief-header {
      display: flex;
      align-items: center;
      margin-bottom: 2.5rem;
    }

    .relief-icon {
      width: 6rem;
      height: 6rem;
      background: linear-gradient(135deg, var(--color-relief), #4caf50);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 2rem;
    }

    .relief-icon i {
      font-size: 2.5rem;
      color: var(--color-white);
    }

    .relief-info h3 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      color: var(--color-dark);
      margin-bottom: 0.5rem;
      text-transform: capitalize;
    }

    .relief-type {
      background: linear-gradient(135deg, var(--color-relief), #4caf50);
      color: var(--color-white);
      padding: 0.5rem 1rem;
      border-radius: 2rem;
      font-size: 1.2rem;
      font-weight: 600;
      text-transform: uppercase;
    }

    .relief-details {
      margin-top: 2rem;
    }

    .detail-row {
      display: flex;
      align-items: flex-start;
      margin-bottom: 1.5rem;
      padding: 1rem 0;
      border-bottom: 1px solid var(--color-light-gray);
    }

    .detail-row:last-child {
      border-bottom: none;
    }

    .detail-icon {
      color: var(--color-relief);
      margin-right: 1.5rem;
      width: 2rem;
      font-size: 1.6rem;
      margin-top: 0.2rem;
    }

    .detail-content {
      flex: 1;
    }

    .detail-label {
      font-weight: 600;
      color: var(--color-dark);
      margin-bottom: 0.3rem;
    }

    .detail-value {
      color: var(--color-primary);
      font-size: 1.5rem;
    }

    .quantity-highlight {
      background: rgba(46, 125, 50, 0.1);
      padding: 1.5rem;
      border-radius: 1rem;
      margin-top: 2rem;
      text-align: center;
    }

    .quantity-number {
      font-size: 3rem;
      font-weight: 700;
      color: var(--color-relief);
      margin-bottom: 0.5rem;
    }

    .quantity-label {
      font-size: 1.3rem;
      color: var(--color-dark);
    }

    .relief-id-badge {
      position: absolute;
      top: 2rem;
      right: 2rem;
      background: rgba(46, 125, 50, 0.1);
      color: var(--color-relief);
      padding: 0.8rem 1.5rem;
      border-radius: 2rem;
      font-size: 1.2rem;
      font-weight: 600;
      border: 2px solid var(--color-relief);
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

      .search-input {
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

      .relief-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .relief-card {
        padding: 2rem;
      }

      .relief-id-badge {
        position: static;
        display: inline-block;
        margin-top: 1rem;
      }
    }

    @media (max-width: 480px) {
      .search-title {
        font-size: 2.8rem;
      }

      .search-container {
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
        <h1 class="search-title">Emergency Relief Supplies</h1>
        <p class="search-subtitle">Find Relief & Supply Distribution</p>
        <p class="search-description">
          Search for relief supplies and distribution centers by location or relief type. Find available food, water, medical supplies, clothing, and other emergency resources.
        </p>
      </div>

      <!-- Search Form -->
      <div class="search-container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="search-form">
          <i class="fa-solid fa-search search-icon"></i>
          <input 
            type="text" 
            name="search_query"
            class="search-input" 
            placeholder="Enter location OR relief type (e.g., 'Downtown' or 'Food' or 'Medical Supplies')" 
            value="<?php echo htmlspecialchars($search_query); ?>"
            required>
          <button type="submit" class="search-button">
            <i class="fa-solid fa-boxes-stacked"></i> Find Relief
          </button>
        </form>

        <div class="search-examples">
          <h4><i class="fa-solid fa-lightbulb"></i> Search Examples</h4>
          <p><strong>By Location:</strong> "Downtown", "City Center", "Main Street", "District 5"</p>
          <p><strong>By Relief Type:</strong> "Food", "Water", "Medical Supplies", "Clothing", "Blankets"</p>
        </div>

        <div class="emergency-info">
          <h3><i class="fa-solid fa-boxes-stacked"></i> Relief Distribution</h3>
          <p>
            For immediate life-threatening emergencies, call <strong>911</strong> first. 
            This search helps you find available relief supplies and distribution centers for non-emergency assistance.
          </p>
        </div>
      </div>

      <!-- Search Results -->
      <?php if ($search_performed): ?>
        <div class="results-container">
          <div class="results-header">
            <h2 class="results-title">Relief Supplies Available</h2>
            <p class="results-count">
              <?php echo count($search_results); ?> relief supply location(s) found for "<?php echo htmlspecialchars($search_query); ?>"
            </p>
          </div>

          <?php if (count($search_results) > 0): ?>
            <div class="relief-grid">
              <?php foreach ($search_results as $relief): ?>
                <div class="relief-card">
                  <div class="relief-id-badge">
                    ID #<?php echo htmlspecialchars($relief['id']); ?>
                  </div>
                  
                  <div class="relief-header">
                    <div class="relief-icon">
                      <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <div class="relief-info">
                      <h3><?php echo htmlspecialchars($relief['type']); ?></h3>
                      <span class="relief-type">Relief Supply</span>
                    </div>
                  </div>

                  <div class="relief-details">
                    <div class="detail-row">
                      <i class="fa-solid fa-tag detail-icon"></i>
                      <div class="detail-content">
                        <div class="detail-label">Relief Type</div>
                        <div class="detail-value"><?php echo htmlspecialchars($relief['type']); ?></div>
                      </div>
                    </div>

                    <div class="detail-row">
                      <i class="fa-solid fa-map-marker-alt detail-icon"></i>
                      <div class="detail-content">
                        <div class="detail-label">Distribution Location</div>
                        <div class="detail-value"><?php echo htmlspecialchars($relief['location']); ?></div>
                      </div>
                    </div>

                    <div class="detail-row">
                      <i class="fa-solid fa-id-badge detail-icon"></i>
                      <div class="detail-content">
                        <div class="detail-label">Supply ID</div>
                        <div class="detail-value">#<?php echo htmlspecialchars($relief['id']); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="quantity-highlight">
                    <div class="quantity-number"><?php echo htmlspecialchars($relief['quantity']); ?></div>
                    <div class="quantity-label">Units Available</div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="no-results">
              <i class="fa-solid fa-search"></i>
              <h3>No Relief Supplies Found</h3>
              <p>No relief supplies found for this location or type. Try searching with different keywords or contact local relief organizations directly.</p>
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
            <div class="logo-placeholder"><img src="img/roundlogo.png" alt="ResQ Logo"></div>
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
            <li><a href="#">Disaster Updates</a></li>
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