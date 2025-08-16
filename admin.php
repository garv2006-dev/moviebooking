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

// ===== Add Movie =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_movie') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $sql = "INSERT INTO movies (name, price, image) VALUES ('$name', '$price', '$image')";
    $conn->query($sql);
}

// ===== Add Offer =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_offer') {
    $title = $_POST['title'];
    $discount = $_POST['discount'];
    $sql = "INSERT INTO offers (title, discount) VALUES ('$title', '$discount')";
    $conn->query($sql);
}

// ===== Fetch Data =====
$movies = $conn->query("SELECT * FROM movies");
$offers = $conn->query("SELECT * FROM offers");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section { display: none; }
        .table img { width: 60px; }
    </style>
</head>
<body class="p-4">

<h2 class="mb-4">Admin Dashboard</h2>

<!-- Dropdown -->
<div class="mb-4">
    <select id="formSelector" class="form-select w-50">
        <option value="">-- Select Action --</option>
        <option value="addmovie.php">Add Movie</option>
        <option value="addoffer.php">Add Offer</option>
    </select>
</div>

<!-- Add Movie Form -->
<div id="movieForm" class="form-section">
    <h4>Add Movie</h4>
    <form method="POST">
        <input type="hidden" name="action" value="add_movie">
        <div class="mb-2"><input type="text" name="name" class="form-control" placeholder="Movie Name" required></div>
        <div class="mb-2"><input type="number" name="price" class="form-control" placeholder="Price" required></div>
        <div class="mb-2"><input type="text" name="image" class="form-control" placeholder="Image URL" required></div>
        <button class="btn btn-primary">Add Movie</button>
    </form>
</div>

<!-- Add Offer Form -->
<div id="offerForm" class="form-section">
    <h4>Add Offer</h4>
    <form method="POST">
        <input type="hidden" name="action" value="add_offer">
        <div class="mb-2"><input type="text" name="title" class="form-control" placeholder="Offer Title" required></div>
        <div class="mb-2"><input type="number" name="discount" class="form-control" placeholder="Discount %" required></div>
        <button class="btn btn-primary">Add Offer</button>
    </form>
</div>

<!-- Search -->
<div class="mt-5 mb-3">
    <input type="text" id="searchInput" class="form-control w-50" placeholder="Search...">
</div>

<!-- Movies Table -->
<h4>Movies</h4>
<table class="table table-bordered table-striped" id="moviesTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $movies->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><img src="<?= $row['image'] ?>"></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Offers Table -->
<h4>Offers</h4>
<table class="table table-bordered table-striped" id="offersTable">
    <thead>
        <tr>
            <th>Title</th>
            <th>Discount (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $offers->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['description'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
document.getElementById('formSelector').addEventListener('change', function() {
    document.querySelectorAll('.form-section').forEach(f => f.style.display = 'none');
    if (this.value === 'movie') document.getElementById('movieForm').style.display = 'block';
    if (this.value === 'offer') document.getElementById('offerForm').style.display = 'block';
});

// Search Filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll("#moviesTable tbody tr, #offersTable tbody tr").forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter) ? "" : "none";
    });
});

document.getElementById('formSelector').addEventListener('change', function () {
    if (this.value) {
        window.location.href = this.value; // Redirect to selected page
    }
});
</script>

</body>
</html>
