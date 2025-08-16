<?php
// ===== Database Connection =====
$host = "localhost";
$username = "root";
$password = "";
$database = "mydb";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ===== Handle Add Movie Request =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['price'], $_POST['image']) && !isset($_POST['id'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image']; // base64

    $stmt = $conn->prepare("INSERT INTO movies (name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $price, $image);

    if ($stmt->execute()) {
        echo "Movie added successfully";
    } else {
        echo "Database insert failed: " . $stmt->error;
    }
    exit;
}

// ===== Handle Fetch Movies Request =====
if (isset($_GET['fetch']) && $_GET['fetch'] == 1) {
    $result = $conn->query("SELECT * FROM movies");
    $movies = [];
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
    echo json_encode($movies);
    exit;
}

// ===== Handle Delete Movie Request =====
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Movie deleted successfully";
    } else {
        echo "Delete failed: " . $stmt->error;
    }
    exit;
}

// ===== Handle Update Movie Request =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'], $_POST['price'], $_POST['image']) && $_POST['id'] !== '') {
    $id    = intval($_POST['id']);
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE movies SET name = ?, price = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $price, $image, $id);

    if ($stmt->execute()) {
        echo "Movie updated successfully";
    } else {
        echo "Database update failed: " . $stmt->error;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - CineBook</title>
  <script src="https://kit.fontawesome.com/cd0fb7a211.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f4f7fa; padding: 20px; }
    h1, h2 { text-align: center; color: #1d4ed8; margin-bottom: 1.5rem; }
    .form-section { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); max-width: 600px; margin: auto; margin-bottom: 40px; display:none; }
    input, textarea, select, button { width: 100%; margin-bottom: 12px; padding: 10px; border: 1px solid #ccc; border-radius: 8px; }
    button { background-color: #2563eb; color: white; font-weight: bold; transition: 0.3s ease; cursor: pointer; }
    button:hover { background-color: #1d4ed8; }
    .preview-img { max-width: 100%; max-height: 200px; display: none; margin: 10px 0; border-radius: 8px; object-fit: contain; }
    .movie-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .movie-table th, .movie-table td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    .movie-table th { background-color: #f4f4f4; }
    .movie-table img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
    .fa-trash { color: red; }
    .fa-pen-to-square { color: #2563eb; }
  </style>
</head>
<body>

<h1>Admin Panel - CineBook</h1>

<div class="form-section" id="movieFormSection">
  <h2 id="formTitle">Add Movie</h2>
  <input type="hidden" id="movieId">
  <input type="file" id="movieImage" accept="image/*">
  <img id="moviePreview" class="preview-img" />
  <input type="text" id="movieName" placeholder="Movie Name">
  <input type="number" id="moviePrice" placeholder="Ticket Price">
  <button id="saveBtn" onclick="saveMovie()">Add Movie</button>
</div>

<h2>Movie List</h2>
<button class="btn btn-primary mb-3" onclick="showAddForm()">+ Add Movie</button>
<table class="movie-table">
  <thead>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Price (₹)</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody id="movieList"></tbody>
</table>

<script>
const movieImage = document.getElementById("movieImage");
const moviePreview = document.getElementById("moviePreview");
const movieIdField = document.getElementById("movieId");
const formSection = document.getElementById("movieFormSection");
const formTitle = document.getElementById("formTitle");
const saveBtn = document.getElementById("saveBtn");

// Preview Image
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

// Show Add Form
function showAddForm() {
  clearForm();
  formTitle.textContent = "Add Movie";
  saveBtn.textContent = "Add Movie";
  formSection.style.display = "block";
}

// Save Movie (Add or Update)
function saveMovie() {
  const id = movieIdField.value;
  const name = document.getElementById("movieName").value.trim();
  const price = document.getElementById("moviePrice").value.trim();
  const image = moviePreview.src;

  if (!name || !price || !image.startsWith('data:image')) {
    alert("Please fill all fields and upload an image.");
    return;
  }

  const formData = new URLSearchParams();
  if (id) formData.append('id', id);
  formData.append('name', name);
  formData.append('price', price);
  formData.append('image', image);

  fetch("", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: formData.toString()
  })
  .then(res => res.text())
  .then(msg => {
    alert(msg);
    clearForm();
    formSection.style.display = "none";
    renderMovies();
  });
}

// Fetch Movies
function renderMovies() {
  fetch("?fetch=1")
    .then(res => res.json())
    .then(movies => {
      const list = document.getElementById("movieList");
      list.innerHTML = "";
      movies.forEach((movie, index) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td><img src="${movie.image}" alt="${movie.name}"></td>
          <td>${movie.name}</td>
          <td>₹${movie.price}</td>
          <td><i class="fa-regular fa-pen-to-square" style="cursor:pointer;" onclick="editMovie(${movie.id})"></i></td>
          <td><i class="fa-solid fa-trash" style="cursor:pointer;" onclick="deleteMovie(${movie.id})"></i></td>
        `;
        list.appendChild(tr);
      });
    });
}

// Delete Movie
function deleteMovie(id) {
  if (!confirm("Delete this movie?")) return;
  fetch("?delete=" + id)
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      renderMovies();
    });
}

// Edit Movie
function editMovie(id) {
  fetch("?fetch=1")
    .then(res => res.json())
    .then(movies => {
      const movie = movies.find(m => m.id == id);
      if (!movie) return;

      movieIdField.value = movie.id;
      document.getElementById("movieName").value = movie.name;
      document.getElementById("moviePrice").value = movie.price;
      moviePreview.src = movie.image;
      moviePreview.style.display = "block";

      formTitle.textContent = "Update Movie";
      saveBtn.textContent = "Save Changes";
      formSection.style.display = "block";
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Clear Form
function clearForm() {
  movieIdField.value = "";
  document.getElementById("movieName").value = "";
  document.getElementById("moviePrice").value = "";
  document.getElementById("movieImage").value = "";
  moviePreview.src = "";
  moviePreview.style.display = "none";
}

document.addEventListener("DOMContentLoaded", renderMovies);
</script>
</body>
</html>
