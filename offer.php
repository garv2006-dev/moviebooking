<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "mydb";

// Handle API requests first
if (isset($_GET['fetch']) && $_GET['fetch'] == 1) {
    header('Content-Type: application/json; charset=utf-8');
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(["error" => "Database connection failed"]);
        exit;
    }

    $result = $conn->query("SELECT * FROM offers");
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Query failed"]);
        exit;
    }

    $offers = [];
    while ($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
    echo json_encode($offers);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CineBook Offers</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./style/offer.css" />
</head>
<body>
 <header>
    <nav>
      <div class="logo">
        <i class="fas fa-film"></i>
        <span>CineBook</span>
      </div>
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="offer.php" class="active">Offers</a></li>
        <li><a href="contact.php">Contact</a></li>
          <li><a href="booking.html">my booking</a></li>
      </ul>
      <div class="auth-buttons">
        <button class="btn-login" onclick="window.location.href='http://localhost/garv/new/index.php'">
          Login
        </button>
        <!-- <input type="button" value="login" onclick="window.location.href='http://localhost/garv/new/index.php';" /> -->
        <!-- <button class="btn-login"  onclick="window.location.href='http://localhost/new/index.php';" >
                Login
          </button> -->


        <!-- <button class="btn-signup">Sign Up</button> -->
      </div>
      <div class="hamburger" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
      </div>
    </nav>
  </header>

  <main class="container">
    <h1 class="mb-4 text-center">CineBook Special Offers</h1>
    <div id="offersDisplay" class="row g-4"></div>
  </main>

  <footer class="cinema-footer">
    <div class="footer-container">
      <div class="footer-logo">
        <img src="https://via.placeholder.com/150x50?text=Cinema+Logo" alt="Cinema Logo" />
        <p>Experience the magic of movies</p>
      </div>

      <div class="footer-links">
        <div class="links-column">
          <h3>Movies</h3>
          <ul>
            <li><a href="#">Now Showing</a></li>
            <li><a href="#">Coming Soon</a></li>
            <li><a href="#">IMAX</a></li>
            <li><a href="#">3D Movies</a></li>
            <li><a href="#">Classics</a></li>
          </ul>
        </div>

        <div class="links-column">
          <h3>Information</h3>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms & Conditions</a></li>
          </ul>
        </div>

        <div class="links-column">
          <h3>Experience</h3>
          <ul>
            <li><a href="#">Dolby Cinema</a></li>
            <li><a href="#">VIP Lounges</a></li>
            <li><a href="#">Food & Drinks</a></li>
            <li><a href="#">Gift Cards</a></li>
            <li><a href="#">Group Bookings</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-newsletter">
        <h3>Subscribe to our newsletter</h3>
        <p>Get the latest movie news and special offers</p>
        <form class="newsletter-form">
          <input type="email" placeholder="Your email address" required />
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="social-links">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
      </div>

      <div class="copyright">
        <p>&copy; 2023 Cinema Name. All Rights Reserved.</p>
      </div>

      <div class="payment-methods">
        <i class="fab fa-cc-visa"></i>
        <i class="fab fa-cc-mastercard"></i>
        <i class="fab fa-cc-amex"></i>
        <i class="fab fa-cc-paypal"></i>
        <i class="fab fa-apple-pay"></i>
      </div>
    </div>
  </footer>
  <script>
 document.addEventListener("DOMContentLoaded", function () {
  async function loadOffers() {
    const offersDisplay = document.getElementById("offersDisplay");
    offersDisplay.innerHTML = '<p class="text-center">Loading offers...</p>';

    try {
      const response = await fetch('offer.php?fetch=1');
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

      const offers = await response.json();
      if (!offers.length) {
        offersDisplay.innerHTML = '<p class="no-offers">No special offers available. Check back later!</p>';
        return;
      }

      offersDisplay.innerHTML = offers.map((offer, index) => `
        <div class="col-md-4">
          <div class="movie-offer-card h-100">
            <img src="${offer.image}" alt="${offer.name}" class="w-100">
            <div class="card-body">
              <h5 class="card-title">${offer.name}</h5>
              <p class="card-text">${offer.description}</p>
              <div class="price-container mb-3">
                <span class="text-danger fw-bold">₹${offer.price}</span>
              </div>
              <a href="offersit.html" class="btn btn-primary w-100 book-offer-link" data-index="${index}">Book Now</a>
            </div>
          </div>
        </div>
      `).join('');

      // Save offer details when clicking Book Now
      document.querySelectorAll(".book-offer-link").forEach((link, i) => {
        link.addEventListener("click", (e) => {
          // Only save to localStorage, let the href handle navigation
          localStorage.setItem("selectedMovieName", offers[i].name);
          localStorage.setItem("selectedMoviePrice", offers[i].price);
          // Don't prevent default - let it go to offersit.html
        });
      });

    } catch (error) {
      offersDisplay.innerHTML = '<p class="error">Failed to load offers. Please try again later.</p>';
    }
  }

  loadOffers();
});

     document.addEventListener("DOMContentLoaded", function () {
      const authButtons = document.querySelector(".auth-buttons");

     
      fetch('new/session_check.php')
        .then(response => response.json())
        .then(data => {
          if (data.loggedIn) {
            
            authButtons.innerHTML = `
              <div class="user-info">
                <a href="new/logout_page.php" style="text-decoration: none; color: white; font-size: 1.1em; padding: 8px 15px; background-color: #007bff; border-radius: 5px;">
                  ${data.username}
                </a>
              </div>
            `;
          }
         
        })
        .catch(error => console.error('Error checking session:', error));
    });

  </script>
</body>
</html>
