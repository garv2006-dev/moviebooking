<?php
// ================== DATABASE CONNECTION ==================
$host = "localhost";
$username = "root";
$password = "";
$database = "mydb";
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ================== BACKEND LOGIC ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // ===== ADD OFFER =====
    if ($_POST['action'] === 'addOffer') {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';

        $imagePath = "";
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
            }
        }

        $stmt = $conn->prepare("INSERT INTO offers (name, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $price, $description, $imagePath);
        if ($stmt->execute()) {
            echo "Offer added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        exit;
    }

    // ===== UPDATE OFFER =====
    if ($_POST['action'] === 'updateOffer') {
        $id = intval($_POST['id']);
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';
        $imagePath = $_POST['oldImage'] ?? '';

        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
            }
        }

        $stmt = $conn->prepare("UPDATE offers SET name=?, price=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $price, $description, $imagePath, $id);
        if ($stmt->execute()) {
            echo "Offer updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        exit;
    }

    // ===== DELETE OFFER =====
    if ($_POST['action'] === 'deleteOffer') {
        $id = intval($_POST['id']);
        $conn->query("DELETE FROM offers WHERE id = $id");
        echo "Offer deleted successfully!";
        exit;
    }
}

// ===== FETCH OFFERS =====
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getOffers') {
    $result = $conn->query("SELECT * FROM offers ORDER BY id DESC");
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Offers</title>
  <script src="https://kit.fontawesome.com/cd0fb7a211.js" crossorigin="anonymous"></script>
   <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css"
    />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f4f7fa; padding: 20px; }
    h1, h2 { text-align: center; color: #1d4ed8; margin-bottom: 1.5rem; }
    .form-section { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); max-width: 600px; margin: auto; display:none; }
    input, textarea, button { width: 100%; margin-bottom: 12px; padding: 10px; border: 1px solid #ccc; border-radius: 8px; }
    button { background-color: #2563eb; color: white; font-weight: bold; transition: 0.3s ease; cursor: pointer; }
    button:hover { background-color: #1d4ed8; }
    .preview-img { max-width: 100%; max-height: 200px; display: none; margin: 10px 0; border-radius: 8px; object-fit: contain; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f4f4f4; }
    img { border-radius: 6px; }
  </style>
</head>
<body>

<h2 id="formTitle">Add Offer</h2>
<div class="form-section" id="offerForm">
  <form id="offerData" enctype="multipart/form-data">
    <input type="hidden" name="id" id="offerId">
    <input type="hidden" name="oldImage" id="oldImage">
    <input type="file" name="image" id="offerImage" accept="image/*">
    <img id="offerPreview" class="preview-img" />
    <input type="text" name="name" id="offerName" placeholder="Offer Name">
    <input type="number" name="price" id="offerPrice" placeholder="Offer Price">
    <textarea name="description" id="offerDescription" placeholder="Offer Description" rows="3"></textarea>
    <button type="submit" id="saveBtn">Add Offer</button>
  </form>
</div>

<h2>Offer List</h2>
<button class="btn btn-primary mb-3" onclick="showAddForm()">+ Add Offer</button>
<table class="table table-bordered" id="offerTable">
  <thead>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Price (₹)</th>
      <th>Description</th>
      <th>Edit</th>
      <th>Delete</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody id="offerList"></tbody>
</table>

<script>
const offerForm = document.getElementById("offerForm");
const offerData = document.getElementById("offerData");
const offerImage = document.getElementById("offerImage");
const offerPreview = document.getElementById("offerPreview");
const formTitle = document.getElementById("formTitle");
const saveBtn = document.getElementById("saveBtn");

let editOfferId = null;

// Preview image
offerImage.addEventListener("change", function() {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = e => {
      offerPreview.src = e.target.result;
      offerPreview.style.display = "block";
    };
    reader.readAsDataURL(file);
  }
});

// Show Add Form
function showAddForm() {
  clearForm();
  formTitle.textContent = "Add Offer";
  saveBtn.textContent = "Add Offer";
  offerForm.style.display = "block";
  offerForm.scrollIntoView({ behavior: 'smooth' });
}

// Clear Form
function clearForm() {
  offerData.reset();
  document.getElementById("offerId").value = "";
  document.getElementById("oldImage").value = "";
  offerPreview.src = "";
  offerPreview.style.display = "none";
  editOfferId = null;
}

// Fetch Offers
function fetchOffers() {
  fetch("?action=getOffers")
    .then(res => res.json())
    .then(data => {
      const list = document.getElementById("offerList");
      list.innerHTML = "";
      data.forEach(offer => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td><img src="${offer.image}" style="width: 60px; height: 60px; object-fit: cover;"></td>
          <td>${offer.name}</td>
          <td>₹${offer.price}</td>
          <td>${offer.description}</td>
          <td><i class="fa-regular fa-pen-to-square" style="cursor:pointer;color:blue" onclick="editOffer(${offer.id}, '${offer.name}', '${offer.price}', '${offer.description}', '${offer.image}')"></i></td>
          <td><i class="fa-solid fa-trash" style="cursor:pointer;color:red" onclick="deleteOffer(${offer.id})"></i></td>
          <td><i class="fa-solid fa-eye" style="cursor:pointer;" onclick="window.open('offer.php', '_self')"></i></td>
        `;
        list.appendChild(tr);
      });
    });
}

// Delete Offer
function deleteOffer(id) {
  if (confirm("Delete this offer?")) {
    const fd = new FormData();
    fd.append("action", "deleteOffer");
    fd.append("id", id);

    fetch("", { method: "POST", body: fd })
      .then(res => res.text())
      .then(msg => {
        alert(msg);
        fetchOffers();
      });
  }
}

// Edit Offer
function editOffer(id, name, price, description, image) {
  document.getElementById("offerId").value = id;
  document.getElementById("offerName").value = name;
  document.getElementById("offerPrice").value = price;
  document.getElementById("offerDescription").value = description;
  document.getElementById("oldImage").value = image;
  offerPreview.src = image;
  offerPreview.style.display = "block";
  formTitle.textContent = "Update Offer";
  saveBtn.textContent = "Save Changes";
  offerForm.style.display = "block";
  window.scrollTo({ top: 0, behavior: "smooth" });
}

// Save Offer (Add/Update)
offerData.addEventListener("submit", function(e) {
  e.preventDefault();
  const fd = new FormData(offerData);
  fd.append("action", document.getElementById("offerId").value ? "updateOffer" : "addOffer");

  fetch("", { method: "POST", body: fd })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      clearForm();
      offerForm.style.display = "none";
      fetchOffers();
    });
});

document.addEventListener("DOMContentLoaded", fetchOffers);
</script>
</body>
</html>
