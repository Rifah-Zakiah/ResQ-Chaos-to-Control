<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="description" content="ResQ: Providing immediate response and long-term recovery solutions for communities affected by disasters. Get emergency assistance, resources, and support.">
  <title>ResQ: Chaos To Control | Disaster Management</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/rstyle.css">
  <link rel="icon" href="img/roundlogo.png">
  <!-- Open Graph tags -->
  <meta property="og:title" content="ResQ: Disaster Management Solutions" />
  <meta property="og:description" content="Providing immediate response and recovery solutions for communities affected by disasters." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://resq-disaster.com" />
  <meta property="og:image" content="https://images.unsplash.com/photo-1615066390971-03e4e1c36ddf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&h=630" />
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
            <li><a href="#"><i class="fa-solid fa-house"></i> Home</a></li>
            <!--  -->
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
          <a href="#" class="help-btn-mobile"><i class="fa-solid fa-circle-exclamation"></i></a>
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
            <li><a href="resq.php"><i class="fa-solid fa-house"></i> Home</a></li>
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

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-bg"></div>
    <div class="overlay"></div>
    
    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title fade-in">When Disaster Strikes, <span>We Respond</span></h1>
        <p class="hero-text fade-in">Providing immediate assistance, resources, and coordination during emergencies to help communities recover and rebuild.</p>
        
        <div class="feature-highlights fade-in">
          <div class="feature-card">
            <div class="feature-icon alert-icon">
              <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <p>24/7 Emergency Response</p>
          </div>
          <div class="feature-card">
            <div class="feature-icon primary-icon">
              <i class="fa-solid fa-users"></i>
            </div>
            <p>10,000+ Volunteers</p>
          </div>
          <div class="feature-card">
            <div class="feature-icon secondary-icon">
              <i class="fa-solid fa-clock"></i>
            </div>
            <p>Rapid Deployment</p>
          </div>
        </div>
        
        <div class="hero-buttons fade-in">
          <a href="needhelp.php" class="btn btn-alert btn-lg"><span>I Need Help</span> <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
    
    <div class="wave-divider">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="wave-fill"></path>
      </svg>
    </div>
  </section>

  <!-- Emergency Services Section -->
  <section class="services" id="services">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Emergency Services</h2>
        <p class="section-subtitle">Immediate assistance for communities in need</p>
      </div>
      
      <div class="services-grid">
        <div class="service-card">
          <div class="service-img">
            <img src="https://images.unsplash.com/photo-1599059813005-11265ba4b4ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400" alt="Medical aid team">
          </div>
          <div class="service-content">
            <h3>Medical Response</h3>
            <p>Emergency medical services and first aid for disaster victims, including field hospitals and mobile clinics.</p>
            <a href="emg_medic.php" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
        
        <div class="service-card">
          <div class="service-img">
            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400" alt="Evacuation process">
          </div>
          <div class="service-content">
            <h3>Evacuation Support</h3>
            <p>Coordinated evacuation operations to safely relocate communities from disaster zones to secure shelters.</p>
            <a href="emg_evac.php" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
        
        <div class="service-card">
          <div class="service-img">
            <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400" alt="Supply distribution">
          </div>
          <div class="service-content">
            <h3>Supply Distribution</h3>
            <p>Essential supplies including food, water, blankets, and hygiene kits delivered to affected communities.</p>
            <a href="emg_relief.php" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Volunteer Section -->
  <section class="volunteer" id="volunteer">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Make a Difference</h2>
        <p class="section-subtitle">Join our volunteer network and help communities rebuild</p>
      </div>
      
      <div class="volunteer-grid">
        <div class="volunteer-content">
          <h3>Why Volunteer With Us?</h3>
          <ul class="volunteer-features">
            <li><i class="fa-solid fa-check"></i> Comprehensive training programs</li>
            <li><i class="fa-solid fa-check"></i> Flexible time commitments</li>
            <li><i class="fa-solid fa-check"></i> Various skills needed</li>
            <li><i class="fa-solid fa-check"></i> Make a real impact</li>
          </ul>
          <p>From disaster response to recovery and rebuilding, our volunteers are the backbone of our operations. No experience is necessary – we provide all the training you need.</p>
          <div class="volunteer-stats">
            <div class="stat">
              <span class="stat-number">10K+</span>
              <span class="stat-text">Active Volunteers</span>
            </div>
            <div class="stat">
              <span class="stat-number">45+</span>
              <span class="stat-text">Countries</span>
            </div>
            <div class="stat">
              <span class="stat-number">24/7</span>
              <span class="stat-text">Deployment</span>
            </div>
          </div>
          <a href="volunteerregistration.php" class="btn btn-primary">Become a Volunteer</a>
        </div>
        <div class="volunteer-image">
          <img src="img/volunteerbd.jpg" alt="Volunteers helping after disaster">
        </div>
      </div>
    </div>
  </section>


  <!-- Disaster Updates Section
  <section class="updates" id="updates">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Disaster Updates</h2>
        <p class="section-subtitle">Latest information on ongoing disasters and recovery efforts</p>
      </div>
      
      <div class="updates-grid">
        <div class="update-card">
          <div class="update-img">
            <img src="https://images.unsplash.com/photo-1547683905-f686c993aae5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400" alt="Flood in Southeast Asia">
            <div class="update-badge ongoing">Ongoing</div>
          </div>
          <div class="update-content">
            <div class="update-category">Flood</div>
            <h3>Southeast Asia Monsoon Flooding</h3>
            <p>Heavy monsoon rains have caused severe flooding across multiple countries in Southeast Asia, affecting over 2 million people.</p>
            <div class="update-footer">
              <span class="update-time"><i class="fa-solid fa-clock"></i> 2 hours ago</span>
              <a href="#" class="update-link">Read More</a>
            </div>
          </div>
        </div>
        
        <div class="update-card">
          <div class="update-img">
            <img src="https://images.unsplash.com/photo-1560813962-ff3d8fcf59ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400" alt="Wildfire in Western US">
            <div class="update-badge ongoing">Ongoing</div>
          </div>
          <div class="update-content">
            <div class="update-category">Wildfire</div>
            <h3>Western United States Wildfires</h3>
            <p>Multiple wildfires continue to burn across western states, with firefighters working to contain the spread in difficult conditions.</p>
            <div class="update-footer">
              <span class="update-time"><i class="fa-solid fa-clock"></i> 5 hours ago</span>
              <a href="#" class="update-link">Read More</a>
            </div>
          </div>
        </div>
        
        <div class="update-card">
          <div class="update-img">
            <img src="https://images.unsplash.com/photo-1580100586938-02822d99c4a8?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400" alt="Hurricane recovery">
            <div class="update-badge recovery">Recovery</div>
          </div>
          <div class="update-content">
            <div class="update-category">Hurricane</div>
            <h3>Caribbean Hurricane Recovery</h3>
            <p>Recovery efforts continue after Hurricane Maria struck several Caribbean islands, with focus on rebuilding infrastructure and housing.</p>
            <div class="update-footer">
              <span class="update-time"><i class="fa-solid fa-clock"></i> 1 day ago</span>
              <a href="#" class="update-link">Read More</a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="view-all">
        <a href="#" class="btn btn-neutral">View All Updates <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>
  </section> -->

  <!-- Donate Section -->
  <section class="volunteer" id="volunteer">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Be a Lifesaver</h2>
        <p class="section-subtitle">Support our mission—donate now and bring hope to those in need.</p>
      </div>
      
      <div class="volunteer-grid">
        <div class="volunteer-content">
          <h3>Why Donate With Us?</h3>
          <ul class="volunteer-features">
            <li><i class="fa-solid fa-check"></i> 100% of your donation goes to people in crisis</li>
            <li><i class="fa-solid fa-check"></i> Transparent use of funds/li>
            <li><i class="fa-solid fa-check"></i> Various skills needed</li>
            <li><i class="fa-solid fa-check"></i> One-time or recurring donations—your choice</li>
          </ul>
          <p>Whether it's responding to natural disasters, delivering emergency blood to hospitals, or supporting vulnerable communities, your donation fuels every step of our mission. No amount is too small—your contribution creates a ripple of impact.</p>
          <div class="volunteer-stats">
            <div class="stat">
              <span class="stat-number">5K+</span>
              <span class="stat-text">Lives directly impacted</span>
            </div>
            <div class="stat">
              <span class="stat-number">100+</span>
              <span class="stat-text"> Blood banks supported</span>
            </div>
            <div class="stat">
              <span class="stat-number">365 days</span>
              <span class="stat-text">Active emergency response</span>
            </div>
          </div>
          <a href="donate.html" class="btn btn-primary">Donate</a>
        </div>
        <div class="volunteer-image">
          <img src="css/donate.png" alt="Volunteers helping after disaster">
        </div>
      </div>
    </div>
  </section>

  <!-- Preparedness Section -->
  <!-- <section class="preparedness" id="preparedness">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Be Prepared</h2>
        <p class="section-subtitle">Resources and guides to help you prepare for emergencies</p>
      </div>
      
      <div class="resources-grid">
        <div class="resource-card">
          <div class="resource-icon">
            <i class="fa-solid fa-house-tsunami"></i>
          </div>
          <h3>Flood Preparedness</h3>
          <p>Learn how to prepare your home and family for potential flooding, including evacuation plans and emergency kits.</p>
          <a href="#" class="btn btn-secondary">See Guide</a>
        </div>
        
        <div class="resource-card">
          <div class="resource-icon">
            <i class="fa-solid fa-fire"></i>
          </div>
          <h3>Wildfire Safety</h3>
          <p>Essential safety tips for wildfire-prone areas, including home preparations and evacuation procedures.</p>
          <a href="#" class="btn btn-secondary">See Guide</a>
        </div>
        
        <div class="resource-card">
          <div class="resource-icon">
            <i class="fa-solid fa-hurricane"></i>
          </div>
          <h3>Hurricane Readiness</h3>
          <p>Comprehensive guide to hurricane preparedness, including boarding up windows and stockpiling supplies.</p>
          <a href="#" class="btn btn-secondary">See Guide</a>
        </div>
        
        <div class="resource-card">
          <div class="resource-icon">
            <i class="fa-solid fa-house-medical"></i>
          </div>
          <h3>First Aid Skills</h3>
          <p>Basic first aid knowledge that can save lives during disasters when medical help is delayed.</p>
          <a href="#" class="btn btn-secondary">See Guide</a>
        </div>
      </div>
    </div>
  </section> -->

  <!-- Testimonials Section -->
  <section class="testimonials" id="testimonials">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Voices from the Community</h2>
        <p class="section-subtitle">Stories of resilience, recovery, and community support</p>
      </div>
      
      <div class="testimonials-slider">
        <div class="testimonial-card">
          <div class="testimonial-header">
            <div class="quote-icon">
              <i class="fa-solid fa-quote-left"></i>
            </div>
            <div class="testimonial-rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
          </div>
          <p class="testimonial-text">"The ResQ team was there for us when we lost everything in the flood. Their immediate response and continued support has been invaluable during our recovery process."</p>
          <div class="testimonial-author">
            <div class="author-img">
              <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&h=100" alt="Jamal Wahid">
            </div>
            <div class="author-info">
              <h4>Jamal Wahid</h4>
              <p>Flood Survivor</p>
            </div>
          </div>
        </div>
        
        <div class="testimonial-card">
          <div class="testimonial-header">
            <div class="quote-icon">
              <i class="fa-solid fa-quote-left"></i>
            </div>
            <div class="testimonial-rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
          </div>
          <p class="testimonial-text">"As a volunteer with ResQ, I've seen firsthand the incredible impact our teams make. The organization's commitment to helping communities rebuild is truly inspiring."</p>
          <div class="testimonial-author">
            <div class="author-img">
              <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&h=100" alt="Sarah Khan">
            </div>
            <div class="author-info">
              <h4>Sarah Khan</h4>
              <p>ResQ Volunteer</p>
            </div>
          </div>
        </div>
        
        <div class="testimonial-card">
          <div class="testimonial-header">
            <div class="quote-icon">
              <i class="fa-solid fa-quote-left"></i>
            </div>
            <div class="testimonial-rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star-half-alt"></i>
            </div>
          </div>
          <p class="testimonial-text">"The disaster preparedness workshops by ResQ gave our community the knowledge and tools we needed to stay safe during the recent wildfire emergency."</p>
          <div class="testimonial-author">
            <div class="author-img">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&h=100" alt="Mohammad Sharif">
            </div>
            <div class="author-info">
              <h4>Mohammad Sharif</h4>
              <p>Community Leader</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <div class="container">
      <div class="cta-content">
        <h2>Ready to Make a Difference?</h2>
        <p>Join our network of volunteers or donate to support communities in need.</p>
        <div class="cta-buttons">
          <a href="volunteerregistration.php" class="btn btn-primary btn-lg">Volunteer Now</a>
          <a href="donate.html" class="btn btn-outline btn-lg">Donate</a>
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
            <li><a href="emg_relief.php">Relief Programs</a></li>
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