<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - CineBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f7fa;
      margin: 0;
      padding: 20px;
    }
    h1, h2 {
      text-align: center;
      color: #1d4ed8;
      margin-bottom: 1.5rem;
    }
    .form-section, .movie-section, .offer-section {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      margin-bottom: 40px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    input, textarea, select, button {
      width: 100%;
      margin-bottom: 12px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    button {
      background-color: #2563eb;
      color: white;
      font-weight: bold;
      transition: 0.3s ease;
      cursor: pointer;
    }
    button:hover {
      background-color: #1d4ed8;
    }
    .preview-img {
      max-width: 100%;
      max-height: 200px;
      display: none;
      margin: 10px 0;
      border-radius: 8px;
      object-fit: contain;
    }
    .card-grid {
      display: flex;
      flex-direction: column;
      gap: 20px;
      max-width: 800px;
      margin: auto;
    }
    .movie-card, .offer-card {
      background: white;
      padding: 16px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .movie-card img, .offer-card img {
      width: 100px;
      height: 100px;
      border-radius: 8px;
      object-fit: cover;
    }
    .card-content {
      flex: 1;
    }
    .actions {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
    .actions button {
      width: auto;
      padding: 8px 12px;
    }
    .btn-danger {
      background-color: #dc3545;
    }
    .btn-danger:hover {
      background-color: #bb2d3b;
    }
    .btn-secondary {
      background-color: #6c757d;
    }
    .btn-secondary:hover {
      background-color: #5c636a;
    }
    .form-check-label {
      font-weight: 500;
    }
    #offerFormContainer {
      display: none;
    }
  </style>
</head>
<body>

<h1>Admin Panel - CineBook</h1>

<!-- Movie Form -->
<div class="form-section movie-section">
  <h2>Add Movie</h2>
  <input type="file" id="movieImage" accept="image/*">
  <img id="moviePreview" class="preview-img" />
  <input type="text" id="movieName" placeholder="Movie Name">
  <input type="number" id="moviePrice" placeholder="Ticket Price">
  <button onclick="addMovie()" >Add Movie</button>
</div>

<!-- Checkbox to show Offer Form -->
<div class="form-section text-center">
  <div class="form-check form-switch d-inline-block">
    <input class="form-check-input" type="checkbox" id="showOfferFormCheckbox">
    <label class="form-check-label" for="showOfferFormCheckbox">Show Offer Page</label>
  </div>
</div>

<!-- Offer Form Container-->
<div id="offerFormContainer">
  <div class="form-section offer-section">
    <h2>Add Offer</h2>
    <input type="file" id="offerImage" accept="image/*">
    <img id="offerPreview" class="preview-img" />
    <input type="text" id="offerName" placeholder="Offer Name">
    <input type="number" id="offerPrice" placeholder="Offer Price">
    <textarea id="offerDescription" placeholder="Offer Description" rows="3"></textarea>
    <select id="offerCategory">
      <option value="" disabled selected>Select Category</option>
      <option value="Gold">Gold</option>
      <option value="Green">Green</option>
      <option value="Silver">Silver</option>
    </select>
    <button onclick="addOffer()">Add Offer</button>
  </div>
</div>

<!-- Display Area -->
<h2>Movie List</h2>
<div id="movieList" class="card-grid"></div>

<h2>Offer List</h2>
<div id="offerList" class="card-grid"></div>

<script>
  // DOM Elements
  const movieImage = document.getElementById("movieImage");
  const moviePreview = document.getElementById("moviePreview");
  const offerImage = document.getElementById("offerImage");
  const offerPreview = document.getElementById("offerPreview");
  const showOfferFormCheckbox = document.getElementById("showOfferFormCheckbox");
  const offerFormContainer = document.getElementById("offerFormContainer");

  // State Variables
  let movieUpdateIndex = null;
  let offerUpdateIndex = null;

  // Event Listeners
  movieImage.addEventListener("change", function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        moviePreview.src = e.target.result;
        moviePreview.style.display = "block";
      };
      reader.readAsDataURL(file);
    }
  });

  offerImage.addEventListener("change", function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        offerPreview.src = e.target.result;
        offerPreview.style.display = "block";
      };
      reader.readAsDataURL(file);
    }
  });

  showOfferFormCheckbox.addEventListener("change", function() {
    offerFormContainer.style.display = this.checked ? "block" : "none";
  });

  // Movie Functions


  function addMovie() {
  const name = document.getElementById("movieName").value.trim();
  const price = document.getElementById("moviePrice").value.trim();
  const image = moviePreview.src;

  if (!name || !price || !image.startsWith('data:image')) {
    alert("Please fill all movie fields and upload an image.");
    return;
  }

  // Store in localStorage
  let movies = JSON.parse(localStorage.getItem("movies")) || [];
  const movie = { name, price, image };

  if (typeof movieUpdateIndex !== "undefined" && movieUpdateIndex !== null) {
    movies[movieUpdateIndex] = movie;
  } else {
    movies.push(movie);
  }

  localStorage.setItem("movies", JSON.stringify(movies));

  // Send to backend PHP
  fetch("add_movie.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}&image=${encodeURIComponent(image)}`
  })
    .then(res => res.text())
    .then(response => {
      alert(response);
      clearMovieForm();
      renderMovies();
    })
    .catch(error => console.error('Error:', error));
}



  function renderMovies() {
    const list = document.getElementById("movieList");
    const movies = JSON.parse(localStorage.getItem("movies")) || [];
    list.innerHTML = '';

    movies.forEach((movie, index) => {
      const div = document.createElement('div');
      div.className = 'movie-card';
      div.innerHTML = `
        <img src="${movie.image}" alt="${movie.name}">
        <div class="card-content">
          <h4>${movie.name}</h4>
          <p>Price: ₹${movie.price}</p>
          <div class="actions">
            <button class="btn btn-sm btn-danger" onclick="deleteMovie(${index})">Delete</button>
            <button class="btn btn-sm btn-primary" onclick="editMovie(${index})">Update</button>
            <button class="btn btn-sm btn-secondary" onclick="window.location.href='index.html'">Go to Home</button>
          </div>
        </div>
      `;
      list.appendChild(div);
    });
  }

  function deleteMovie(index) {
    if (confirm('Are you sure you want to delete this movie?')) {
      let movies = JSON.parse(localStorage.getItem("movies")) || [];
      movies.splice(index, 1);
      localStorage.setItem("movies", JSON.stringify(movies));
      renderMovies();
    }
  }

  function editMovie(index) {
    let movies = JSON.parse(localStorage.getItem("movies")) || [];
    const movie = movies[index];
    document.getElementById("movieName").value = movie.name;
    document.getElementById("moviePrice").value = movie.price;
    moviePreview.src = movie.image;
    moviePreview.style.display = "block";
    movieUpdateIndex = index;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function clearMovieForm() {
    document.getElementById("movieName").value = "";
    document.getElementById("moviePrice").value = "";
    document.getElementById("movieImage").value = "";
    moviePreview.src = "";
    moviePreview.style.display = "none";
    movieUpdateIndex = null;
  }

  // Offer Functions
 function addOffer() {
  const name = document.getElementById('offerName').value.trim();
  const price = document.getElementById('offerPrice').value.trim();
  const description = document.getElementById('offerDescription').value.trim();
  const category = document.getElementById('offerCategory').value;
  const image = offerPreview.src;

  if (!name || !price || !description || !category || !image.startsWith('data:image')) {
    alert('Please fill all offer fields and upload an image.');
    return;
  }

  const offer = { name, price, description, category, image };
  let offers = JSON.parse(localStorage.getItem('offers')) || [];

  if (typeof offerUpdateIndex !== "undefined" && offerUpdateIndex !== null) {
    offers[offerUpdateIndex] = offer;
  } else {
    offers.push(offer);
  }

  localStorage.setItem('offers', JSON.stringify(offers));

  // Send to backend PHP
  fetch("add_offer.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}&description=${encodeURIComponent(description)}&category=${encodeURIComponent(category)}&image=${encodeURIComponent(image)}`
  })
    .then(res => res.text())
    .then(response => {
      alert(response);
      clearOfferForm();
      renderOffers();
    })
    .catch(error => console.error('Error:', error));
}


  function renderOffers() {
    const list = document.getElementById('offerList');
    const offers = JSON.parse(localStorage.getItem('offers')) || [];
    list.innerHTML = '';

    offers.forEach((offer, index) => {
      const div = document.createElement('div');
      div.className = 'offer-card';
      div.innerHTML = `
        <img src="${offer.image}" alt="${offer.name}">
        <div class="card-content">
          <h4>${offer.name} (${offer.category})</h4>
          <p><strong>Price:</strong> ₹${offer.price}</p>
          <p>${offer.description}</p>
          <div class="actions">
            <button class="btn btn-sm btn-danger" onclick="deleteOffer(${index})">Delete</button>
            <button class="btn btn-sm btn-primary" onclick="editOffer(${index})">Update</button>
            <button class="btn btn-sm btn-secondary" onclick="window.location.href='index.html'">Go to Home</button>
          </div>
        </div>
      `;
      list.appendChild(div);
    });
  }

  function deleteOffer(index) {
    if (confirm('Are you sure you want to delete this offer?')) {
      let offers = JSON.parse(localStorage.getItem('offers')) || [];
      offers.splice(index, 1);
      localStorage.setItem('offers', JSON.stringify(offers));
      renderOffers();
    }
  }

  function editOffer(index) {
    let offers = JSON.parse(localStorage.getItem('offers')) || [];
    const offer = offers[index];
    document.getElementById('offerName').value = offer.name;
    document.getElementById('offerPrice').value = offer.price;
    document.getElementById('offerDescription').value = offer.description;
    document.getElementById('offerCategory').value = offer.category;
    offerPreview.src = offer.image;
    offerPreview.style.display = 'block';
    offerUpdateIndex = index;
    
    showOfferFormCheckbox.checked = true;
    offerFormContainer.style.display = 'block';
    window.scrollTo({ top: offerFormContainer.offsetTop, behavior: 'smooth' });
  }

  function clearOfferForm() {
    document.getElementById('offerName').value = '';
    document.getElementById('offerPrice').value = '';
    document.getElementById('offerDescription').value = '';
    document.getElementById('offerCategory').value = '';
    document.getElementById('offerImage').value = '';
    offerPreview.src = '';
    offerPreview.style.display = 'none';
    offerUpdateIndex = null;
  }

  // Initial Load
  document.addEventListener('DOMContentLoaded', function() {
    renderMovies();
    renderOffers();
  });
</script>
</body>
</html>