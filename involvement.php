<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="description" content="ResQ: View volunteer relief assignments">
  <title>ResQ: Relief Assignments | Disaster Management</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/rstyle.css">
  <style>
    /* Additional styles for enhanced table */
    .assignment-container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      overflow: hidden;
      margin: 2rem 0;
    }

    .assignment-table {
      width: 100%;
      border-collapse: collapse;
      font-family: 'Inter', sans-serif;
    }

    .assignment-table thead {
      background: #2c3e50;
      color: white;
    }

    .assignment-table th {
      padding: 1rem;
      text-align: left;
      font-weight: 500;
      text-transform: uppercase;
      font-size: 1.5rem;
      letter-spacing: 0.5px;
    }

    .assignment-table td {
      padding: 1rem;
      border-bottom: 1px solid #f0f0f0;
      color: #555;
    }

    .assignment-table tr:last-child td {
      border-bottom: none;
    }

    .assignment-table tr:hover {
      background-color: #f9f9f9;
    }

    .assignment-table .status-badge {
      display: inline-block;
      padding: 0.3rem 0.6rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .badge-active {
      background: #e3f7e8;
      color: #28a745;
    }

    .badge-completed {
      background: #f0e7ff;
      color: #6f42c1;
    }

    .table-actions {
      display: flex;
      gap: 0.5rem;
    }

    .table-actions .btn-icon {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      cursor: pointer;
      transition: all 0.2s;
    }

    .btn-view {
      background: #3498db;
    }

    .btn-edit {
      background: #f39c12;
    }

    .btn-delete {
      background: #e74c3c;
    }

    .table-actions .btn-icon:hover {
      transform: translateY(-2px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .assignment-table {
        display: block;
      }
      
      .assignment-table thead {
        display: none;
      }
      
      .assignment-table tr {
        display: block;
        margin-bottom: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      
      .assignment-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #eee;
      }
      
      .assignment-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #2c3e50;
        margin-right: 1rem;
        flex: 1;
      }
      
      .assignment-table td > span {
        flex: 2;
        text-align: right;
      }
    }

    .section-header {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .section-title {
      font-size: 5rem;
      color: #2c3e50;
      margin-bottom: 0.5rem;
      font-family: 'Playfair Display', serif;
    }

    .section-subtitle {
      color: #7f8c8d;
      font-size: 2rem;
    }
  </style>
  <link rel="icon" href="img/roundlogo.png">
</head>
<body>
 <!-- Header/Navigation -->
  <header id="header" class="header">
    <div class="container">
      <div class="navbar">
        <div class="logo">
          <!-- Empty logo placeholder for future PNG logo -->
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
            <!-- <button class="search-btn" aria-label="Search"><i class="fa-solid fa-search"></i><a href="search.html"></a></button> -->
            <a href="needhelp.php" class="btn btn-alert"><i class="fa-solid fa-circle-exclamation"></i> Need Help</a>
            <a href="login.php" class="btn btn-neutral"><i class="fa-solid fa-sign-in"></i> Login</a>
          </div>
        </nav>
        
        <div class="nav-mobile">
          <!-- <button class="search-btn-mobile" aria-label="Search"><i class="fa-solid fa-search"></i><a href="search.html"></a></button> -->
          <a href="needhelp.php" class="help-btn-mobile"><i class="fa-solid fa-circle-exclamation"></i></a>
          <button id="menu-toggle" class="menu-toggle" aria-label="Menu">
            <i class="fa-solid fa-bars"></i>
          </button>
        </div>
      </div>
      
      <!-- Mobile search (hidden by default) -->
      <div id="mobile-search" class="mobile-search">
        <div class="search-container">
          <input type="text" placeholder="Search for disasters or resources...">
          <i class="fa-solid fa-search"></i>
        </div>
      </div>
      
      <!-- Mobile menu (hidden by default) -->
      <div id="mobile-menu" class="mobile-menu">
        <nav>
          <ul>
            <li><a href="resq.html"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="emer_cont.html"><i class="fa-solid fa-life-ring"></i> Emergency Contacts</a></li>
            <li><a href="search_shelter.html"><i class="fa-solid fa-map-pin"></i> Shelter</a></li>
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
<br><br><br><br>
  <!-- Main Content Section -->
  <section class="services" id="services">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Relief Assignment Records</h2>
        <br><br>
        <p class="section-subtitle">View all volunteer assignments with detailed information</p>
      </div>
      
      <div class="assignment-container">
        <div class="table-responsive">
          <?php
          // Database connection
          $servername = "localhost";
          $username = "root"; // Replace with your database username
          $password = ""; // Replace with your database password
          $dbname = "db_dmrs";

          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // SQL query to join all tables
          $sql = "SELECT 
                      i.volunteer_id, 
                      vtr.name AS volunteer_name, 
                      vtr.phone_no AS volunteer_phone,
                      vtr.email AS volunteer_email,
                      i.victim_id, 
                      vtm.name AS victim_name, 
                      vtm.phone_no AS victim_phone,
                      vtm.current_location,
                      i.relief_id, 
                      r.type AS relief_type,
                      r.quantity,
                      r.location AS relief_location
                  FROM Involves i
                  JOIN Volunteer vtr ON i.volunteer_id = vtr.id
                  JOIN Victim vtm ON i.victim_id = vtm.id
                  JOIN Relief r ON i.relief_id = r.id
                  ORDER BY i.victim_id";

          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              echo '<table class="assignment-table">
                      <thead>
                          <tr>
                              <th>Volunteer</th>
                              <th>Victim</th>
                              <th>Location</th>
                              <th>Relief Details</th>
                              <th>Status</th>
                              
                          </tr>
                      </thead>
                      <tbody>';

              // Output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td data-label=\"Volunteer\">
                            <strong>".$row["volunteer_name"]."</strong><br>
                            <small>ID: ".$row["volunteer_id"]."</small><br>
                            <small><i class=\"fa-solid fa-phone\"></i> ".$row["volunteer_phone"]."</small><br>
                            <small><i class=\"fa-solid fa-envelope\"></i> ".$row["volunteer_email"]."</small>
                          </td>
                          <td data-label=\"Victim\">
                            <strong>".$row["victim_name"]."</strong><br>
                            <small>ID: ".$row["victim_id"]."</small><br>
                            <small><i class=\"fa-solid fa-phone\"></i> ".$row["victim_phone"]."</small>
                          </td>
                          <td data-label=\"Location\">
                            <i class=\"fa-solid fa-location-dot\"></i> ".$row["current_location"]."
                          </td>
                          <td data-label=\"Relief\">
                            <strong>".$row["relief_type"]."</strong><br>
                            <small>ID: ".$row["relief_id"]."</small><br>
                            <small>Qty: ".$row["quantity"]."</small><br>
                            <small><i class=\"fa-solid fa-map-marker-alt\"></i> ".$row["relief_location"]."</small>
                          </td>
                          <td data-label=\"Status\">
                            <span class=\"status-badge badge-active\">Active</span>
                          </td>
                          
                        </tr>";
              }
              echo '</tbody></table>';
          } else {
              echo '<div class="no-results" style="text-align: center; padding: 2rem; background: white; border-radius: 12px;">
                      <i class="fa-solid fa-triangle-exclamation" style="font-size: 2rem; color: #f39c12; margin-bottom: 1rem;"></i>
                      <h3 style="color: #2c3e50; margin-bottom: 0.5rem;">No Assignments Found</h3>
                      <p style="color: #7f8c8d;">There are currently no volunteer assignments recorded in the system.</p>
                    </div>';
          }
          $conn->close();
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-about">
          <div class="footer-logo">
            <div class="logo-placeholder">
                <div class="logo-placeholder">
                    <img src="img/roundlogo.png" alt="ResQ Logo">
                  </div>
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
            <li><a href="#">About Us</a></li>
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

  <!-- JavaScript -->
  <script src="js/script.js"></script>
  <script>
    // Add interactive functionality
    document.addEventListener('DOMContentLoaded', function() {
      // Add click handlers for action buttons (example)
      const viewButtons = document.querySelectorAll('.btn-view');
      viewButtons.forEach(button => {
        button.addEventListener('click', function() {
          const row = this.closest('tr');
          const volunteerName = row.querySelector('td:nth-child(1) strong').textContent;
          alert(`Viewing details for assignment with ${volunteerName}`);
        });
      });

      // Make entire row clickable on mobile
      if (window.innerWidth <= 768) {
        const rows = document.querySelectorAll('.assignment-table tr');
        rows.forEach(row => {
          row.addEventListener('click', function() {
            this.classList.toggle('expanded');
          });
        });
      }
    });
  </script>
</body>
</html>