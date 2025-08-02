<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CineBook Offers</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <style>
    /* Page-specific styles for the Offers page */
    body {
      font-family: "Poppins", sans-serif;
      background: #f4f7fa;
      margin: 0;
      padding-top: 80px;
      /* Adjust for fixed header */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      /* Ensure footer stays at the bottom */
    }

    h1 {
      text-align: center;
      color: #e50914;
      margin-bottom: 30px;
      padding-top: 20px;
      /* Add some padding above the main title */
    }

    .category-section {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      margin-bottom: 40px;
      max-width: 1100px;
      margin-left: auto;
      margin-right: auto;
    }

    .category-section h2 {
      color: #e50914;
      margin-bottom: 20px;
      border-bottom: 2px solid #e0e7ff;
      padding-bottom: 10px;
    }

    /* PROFESSIONAL MOVIE OFFER CARD STYLE */
    .movie-offer-card {
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      /* Ensures image corners are rounded */
      display: flex;
      flex-direction: column;
      /* Stack image and content vertically */
      height: 100%;
      /* Ensure cards in a row have same height */
    }

    .movie-offer-card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-bottom: 1px solid #eee;
    }

    .movie-details {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
      /* Allows content area to expand */
      text-align: center;
    }

    .movie-details h4 {
      margin: 0 0 10px;
      color: #333;
      font-weight: 700;
      font-size: 1.25rem;
    }

    .movie-details .description {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 15px;
      flex-grow: 1;
    }

    .movie-details .price-container {
      margin-bottom: 15px;
    }

    .offer-price {
      color: #dc3545;
      /* Bootstrap danger color for emphasis */
      font-weight: bold;
      font-size: 1.2rem;
    }

    .book-button-container {
      margin-top: auto;
      /* Pushes button to the bottom */
    }

    .book-button-container .btn {
      width: 80%;
      max-width: 200px;
      padding: 10px 15px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 8px;
    }

    .no-offers {
      text-align: center;
      color: #777;
      padding: 40px 20px;
      background: #fff;
      border-radius: 12px;
      max-width: 900px;
      margin: auto;
    }

    main {
      flex-grow: 1;
      padding: 20px 0;
    }

    /* Styles for header and footer */
    header {
      background-color: #333;
      color: white;
      padding: 1rem 0;
      position: fixed;
      /* Make header fixed */
      width: 100%;
      top: 0;
      left: 0;
      z-index: 1000;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .logo {
      display: flex;
      align-items: center;
      font-size: 1.5rem;
      font-weight: bold;
    }

    .logo i {
      margin-right: 10px;
    }

    .nav-links {
      list-style: none;
      display: flex;
      margin: 0;
      padding: 0;
    }

    .nav-links li {
      margin-right: 20px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: #e50914;
      /* Bootstrap primary color */
    }

    .auth-buttons button {
      background-color: #e50914;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .auth-buttons button:hover {
      background-color: #e50914;
    }

    .btn-signup {
      background-color: #28a745;
      /* Bootstrap success color */
      margin-left: 10px;
    }

    .btn-signup:hover {
      background-color: #218838;
    }

    .hamburger {
      display: none;
      font-size: 1.8rem;
      cursor: pointer;
    }

    @media (max-width: 768px) {

      .nav-links,
      .auth-buttons {
        display: none;
        flex-direction: column;
        width: 100%;
        text-align: center;
        background-color: #333;
        position: absolute;
        top: 60px;
        left: 0;
        padding: 20px 0;
        z-index: 999;
      }

      .nav-links.active,
      .auth-buttons.active {
        display: flex;
      }

      .nav-links li,
      .auth-buttons button {
        margin: 10px 0;
      }

      .hamburger {
        display: block;
      }
    }

    .cinema-footer {
      background-color: #111;
      color: #fff;
      padding: 40px 20px 20px;
      font-family: "Poppins", sans-serif;
    }

    .footer-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      max-width: 1200px;
      margin: auto;
      gap: 40px;
    }

    .footer-logo {
      flex: 1 1 250px;
    }

    .footer-logo img {
      width: 150px;
      margin-bottom: 10px;
    }

    .footer-logo p {
      font-size: 14px;
      color: #ccc;
    }

    .footer-links {
      display: flex;
      flex: 2 1 500px;
      gap: 30px;
    }

    .links-column {
      flex: 1;
    }

    .links-column h3 {
      font-size: 16px;
      margin-bottom: 15px;
      color: #fff;
    }

    .links-column ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .links-column ul li {
      margin-bottom: 10px;
    }

    .links-column ul li a {
      text-decoration: none;
      color: #ccc;
      font-size: 14px;
      transition: color 0.3s ease;
    }

    .links-column ul li a:hover {
      color: #fff;
    }

    .footer-newsletter {
      flex: 1 1 300px;
    }

    .footer-newsletter h3 {
      margin-bottom: 10px;
      font-size: 16px;
    }

    .footer-newsletter p {
      font-size: 14px;
      margin-bottom: 15px;
      color: #ccc;
    }

    .newsletter-form {
      display: flex;
      flex-direction: column;
    }

    .newsletter-form input {
      padding: 10px;
      margin-bottom: 10px;
      border: none;
      border-radius: 5px;
      font-size: 14px;
    }

    .newsletter-form button {
      padding: 10px;
      background-color: #e50914;
      color: #fff;
      border: none;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .newsletter-form button:hover {
      background-color: #b20710;
    }

    /* Footer Bottom */
    .footer-bottom {
      border-top: 1px solid #333;
      margin-top: 40px;
      padding-top: 20px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin-inline: auto;
      gap: 20px;
    }

    .social-links a {
      margin-right: 10px;
      color: #ccc;
      font-size: 18px;
      transition: color 0.3s ease;
    }

    .social-links a:hover {
      color: #fff;
    }

    .payment-methods i {
      font-size: 24px;
      margin-left: 10px;
      color: #ccc;
      transition: color 0.3s ease;
    }

    .payment-methods i:hover {
      color: #fff;
    }

    .copyright p {
      font-size: 14px;
      color: #aaa;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .footer-container {
        flex-direction: column;
        align-items: center;
        gap: 30px;
      }

      .footer-links {
        flex-direction: column;
        align-items: center;
      }

      .footer-newsletter {
        width: 100%;
      }

      .footer-bottom {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .payment-methods i {
        margin-left: 5px;
        margin-right: 5px;
      }
    }
  </style>
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
      </ul>
      <div class="auth-buttons">
         <button class="btn-login" onclick="window.location.href='http://localhost/garv/new/index.php'">
            Login
          </button>
        <!-- <button class="btn-signup">Sign Up</button> -->
      </div>
      <div class="hamburger">
        <i class="fas fa-bars"></i>
      </div>
    </nav>
  </header>

  <main>
    <h1>CineBook Special Offers</h1>
    <div id="offersDisplay" class="container-fluid"></div>
  </main>

  <footer class="cinema-footer">
    <div class="footer-container">
      <!-- Footer content can be added here -->
    </div>
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
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const hamburger = document.querySelector(".hamburger");
      const navLinks = document.querySelector(".nav-links");
      const authButtons = document.querySelector(".auth-buttons");

      hamburger.addEventListener("click", function () {
        navLinks.classList.toggle("active");
        authButtons.classList.toggle("active");
      });

      loadOffers(); // Load offers when the page loads
    });

    // Load offers from localStorage and display
    function loadOffers() {
      const offersDisplay = document.getElementById("offersDisplay");
      // Correctly load from the 'offers' key in localStorage
      const allOffers = JSON.parse(localStorage.getItem("offers")) || [];

      // Clear previous content
      offersDisplay.innerHTML = "";

      if (allOffers.length === 0) {
        offersDisplay.innerHTML =
          '<p class="no-offers">No special offers available at the moment. Add some from the admin panel!</p>';
        return;
      }

      const greenOffers = allOffers.filter(
        (offer) => offer.category === "Green"
      );
      const silverOffers = allOffers.filter(
        (offer) => offer.category === "Silver"
      );
      const goldOffers = allOffers.filter(
        (offer) => offer.category === "Gold"
      );

      function renderCategory(categoryName, offerList) {
        if (offerList.length > 0) {
          let categoryHtml = `
              <div class="category-section">
                <h2>${categoryName} Category Offers</h2>
                <div class="row justify-content-center">
            `;
          offerList.forEach((offer) => {
            categoryHtml += `
                  <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex">
                    <div class="movie-offer-card flex-grow-1">
                        <img src="${offer.image}" class="card-img-top" alt="${offer.name}">
                        <div class="movie-details">
                            <h4 class="card-title">${offer.name}</h4>
                            <p class="description">${offer.description}</p>
                            <div class="price-container">
                                <span class="offer-price">₹${offer.price}</span>
                            </div>
                            <div class="book-button-container">
                                <a href="location.html" class="btn btn-primary">BOOK NOW</a>
                            </div>
                        </div>
                    </div>
                  </div>
              `;
          });
          categoryHtml += `
                </div>
              </div>
            `;
          offersDisplay.innerHTML += categoryHtml;
        }
      }

      renderCategory("Gold", goldOffers);
      renderCategory("Silver", silverOffers);
      renderCategory("Green", greenOffers);
    }
  </script>
</body>

</html>