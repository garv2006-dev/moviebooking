<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/cd0fb7a211.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="contact.css" />
    <title>Document</title>
    <script>
      function data() {
        var a = document.getElementById("n1").value;
        var b = document.getElementById("n2").value;
        if (a == "" || b == "") {
          alert("all fild are medantary");
          return false;
        } else if (b.length < 10 || b.length > 10) {
          alert("10 digit plz");
          return false;
        } else {
          alert("hello");
          return true;
        }
      }
    </script>
  </head>
  <body>
   <header>
      <nav>
        <div class="logo">
          <i class="fas fa-film"></i>
          <span>CineBook</span>
        </div>
        <ul class="nav-links">
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="offers.php">Offers</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="auth-buttons">
          <button class="btn-login" onclick="window.location.href='login.php'">
            Login
          </button>
          <!-- <button class="btn-signup">Sign Up</button> -->
        </div>
        <div class="hamburger" onclick="toggleMenu()">
          <i class="fas fa-bars"></i>
        </div>
      </nav>
    </header>
    <div class="contact-form">
      <div class="container1">
        <div class="form-wrapper">
          <div class="company-address">
            <div class="add-gruop">
              <i class="fa-solid fa-location-dot fa-2x"> </i>
              <h1 class="md-headin text-grey">location</h1>
              <p>DHANMORA, VEDROD, KATARGAM ,SURAT - 365650</p>
            </div>
            <div class="address-group">
              <i class="fa-duotone fa-solid fa-envelope fa-2x"></i>
              <h1 class="md-headin text-grey">e-maile</h1>
              <p> PROJECT@0707GMAIL.COM</p>
            </div>
            <div class="add-gruop">
              <i class="fa-duotone fa-solid fa-phone fa-2x"></i>
              <h1 class="md-headin text-grey">+ call</h1>
              <p>+91 7069909314</p>
            </div>
            <img src="./img/istockphoto-511061090-612x612.jpg" alt="" />
          </div>
          <form onsubmit="data()" class="company-form">
            <h1 class="lg-headin text-grey">CONTECT US</h1>
            <br />
            <p>
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugit,
              quo!
            </p>
            <div class="form-group">
              <label>USERNAME</label>
              <input
                type="TEXT"
                placeholder="ENTER THE USERNAME"
                required
              /><br /><br />
            </div>
            <div class="form-group">
              <label>EMAIL</label>
              <input
                type="email"
                placeholder="ENTER THE EMAIL"
                id="n1"
                required
              /><br /><br />
            </div>
            <div class="form-group">
              <label>PHONE</label>
              <input
                type="password"
                placeholder="ENTER THE PHONE NUMBER"
                id="n2"
              /><br /><br />
            </div>
            <div class="form-group">
              <label>MESSAGE</label>
              <textarea placeholder="ENTER THE MESSAGE"></textarea>
            </div>

            <button type="submit" value="">SUBMIT</button>
          </form>
        </div>
      </div>
    </div>

     <footer class="cinema-footer">
      <div class="footer-container">
        <div class="footer-logo">
          <img
            src="https://via.placeholder.com/150x50?text=Cinema+Logo"
            alt="Cinema Logo"
          />
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
  </body>
</html>