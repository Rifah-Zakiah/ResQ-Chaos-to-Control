<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | ResQ</title>
  <link rel="stylesheet" href="css/rstyle.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="icon" href="img/roundlogo.png">
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
            <a href="login.php" class="btn btn-neutral"><i class="fa-solid fa-sign-in"></i>Login</a>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <!-- Login Section -->
   <br><br><br>
  <section class="container" style="margin:145px; text-align: center;">
    <h2 style="margin-bottom: 2rem;">Register Your Account</h2>
    <div style="display: flex; justify-content: center; gap: 4rem; flex-wrap: wrap;">
      <a href="victimregistration.php" class="btn btn-primary btn-lg">Victim</a>
      <a href="volunteerregistration.php" class="btn btn-secondary btn-lg">Volunteer</a>
    </div>
    
  </section>
  <br><br><br>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-about">
          <div class="logo-placeholder"><img src="img/roundlogo.png" alt="ResQ Logo"></div>
          <div class="logo-text"><h3>ResQ<span>:</span></h3><p>Chaos To Control</p></div>
          <p>ResQ provides immediate disaster response and long-term recovery solutions for communities in need.</p>
          <div class="social-links">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="footer-links">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="about.html">About Us</a></li>
            <li><a href="">Disaster Updates</a></li>
            <li><a href="volunteerregistration.php">Volunteer</a></li>
            <li><a href="donate.html">Donate</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h3>Resources</h3>
          <ul>
            <li><a href="what-to-do.html">Preparedness</a></li>
            <li><a href="#">Relief Programs</a></li>
            <li><a href="#">Workshops</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h3>Contact Us</h3>
          <ul>
            <li><i class="fa-solid fa-phone"></i> +1-800-555-RESQ</li>
            <li><i class="fa-solid fa-envelope"></i> info@resq.org</li>
            <li><i class="fa-solid fa-location-dot"></i> ResQ HQ, Disaster Lane</li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 ResQ Disaster Management. All rights reserved.</p>
        <div class="footer-bottom-links">
          <a href="#">Privacy</a>
          <a href="#">Terms</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
