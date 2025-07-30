<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineBook - Movie Ticket Booking</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="index.css" />
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

    <div class="card-container">
      <div class="container">
        <div class="row justify-content-center">
          <div
            id="movieDisplay"
            class="card-container d-flex flex-wrap justify-content-center"
          >
            <div class="card" style="width: 18rem">
              <img
                src="./img/PUSHPA2.jpg"
                class="card-img-top"
                alt="PUSHPA-2"
              />
              <div class="card-body">
                <h5 class="card-title">PUSHPA-2</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
            <div class="card" style="width: 18rem">
              <img src="./img/animal.png" class="card-img-top" alt="ANIMAL" />
              <div class="card-body">
                <h5 class="card-title">ANIMAL</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
            <div class="card" style="width: 18rem">
              <img src="./img/LEO.webp" class="card-img-top" alt="LEO" />
              <div class="card-body">
                <h5 class="card-title">LEO</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
            <div class="card" style="width: 18rem">
              <img
                src="./img/hasin dill ruba.jpg"
                class="card-img-top"
                alt="HASIN DULLRUBA"
              />
              <div class="card-body">
                <h5 class="card-title">HASIN DULLRUBA</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
            <div class="card" style="width: 18rem">
              <img src="./img/garv.jpg" class="card-img-top" alt="RAJKUMAR" />
              <div class="card-body">
                <h5 class="card-title">RAJKUMAR</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
            <div class="card" style="width: 18rem">
              <img src="./img/salar.jpg" class="card-img-top" alt="SALAR" />
              <div class="card-body">
                <h5 class="card-title">SALAR</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
            <div class="card" style="width: 18rem">
              <img
                src="./img/family star.jpg"
                class="card-img-top"
                alt="FAMILY STAR"
              />
              <div class="card-body">
                <h5 class="card-title">FAMILY STAR</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
            <div class="card" style="width: 18rem">
              <img src="./img/Amaran.jpg" class="card-img-top" alt="AMARAN" />
              <div class="card-body">
                <h5 class="card-title">AMARAN</h5>
                <a href="location.php" class="btn btn-primary">BOOK</a>
              </div>
            </div>
          </div>
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
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script>
      // Mobile Menu Toggle
      document.addEventListener("DOMContentLoaded", function () {
        const hamburger = document.querySelector(".hamburger");
        const navLinks = document.querySelector(".nav-links");
        const authButtons = document.querySelector(".auth-buttons");

        hamburger.addEventListener("click", function () {
          navLinks.classList.toggle("active");
          authButtons.classList.toggle("active");
        });
        movieList.appendChild(card);

        // Reset fields
        document.getElementById("movieName").value = "";
        document.getElementById("moviePrice").value = "";
        document.getElementById("movieImage").value = "";
        preview.style.display = "none";
        preview.src = "";
      });
    </script>
    <script>
      // Load movies from localStorage and display
      function loadMovies() {
        const movieDisplay = document.getElementById("movieDisplay");
        const movies = JSON.parse(localStorage.getItem("movies")) || [];

        movieDisplay.innerHTML = "";

        movies.forEach((movie) => {
          const card = document.createElement("div");
          card.className = "card m-2";
          card.style.width = "18rem";
          card.innerHTML = `
        <img src="${movie.image}" class="card-img-top" alt="${movie.name}" />
        <div class="card-body">
          <h5 class="card-title">${movie.name}</h5>
          <p class="card-text">Price: ₹${movie.price}</p>
          <a href="location.php" class="btn btn-primary">BOOK</a>
        </div>
      `;
          movieDisplay.appendChild(card);
        });
      }

      // Call loadMovies when page loads
      window.addEventListener("DOMContentLoaded", loadMovies);
    </script>
  </body>
</html>