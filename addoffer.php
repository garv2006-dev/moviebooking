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
    header('Content-Type: application/json');

    if ($_POST['action'] === 'addOffer') {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';
        $image = $_POST['image'] ?? '';

        if ($name && $price && $description && strpos($image, 'data:image') === 0) {
            $stmt = $conn->prepare("INSERT INTO offers (name, price, description, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $price, $description, $image);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Offer added successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Missing or invalid fields"]);
        }
        exit;
    }

     // ✅ DELETE Offer
    if ($_POST['action'] === 'deleteOffer') {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM offers WHERE id = $id");
    echo json_encode(["success" => true]);
    exit;
    }


    // ✅ Update Offer
    if ($_POST['action'] === 'updateOffer') {
        $id = intval($_POST['id']);
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';
        $image = $_POST['image'] ?? '';

        if ($id && $name && $price && $description && strpos($image, 'data:image') === 0) {
            $stmt = $conn->prepare("UPDATE offers SET name=?, price=?, description=?, image=? WHERE id=?");
            $stmt->bind_param("ssssi", $name, $price, $description, $image, $id);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Offer updated successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Missing or invalid fields"]);
        }
        exit;
    }

    if ($_POST['action'] === 'deleteOffer') {
        $id = intval($_POST['id']);
        $conn->query("DELETE FROM offers WHERE id = $id");
        echo json_encode(["success" => true]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getOffers') {
    header('Content-Type: application/json');
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
  <title>Admin Dashboard - CineBook</title>
  <script src="https://kit.fontawesome.com/cd0fb7a211.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f4f7fa; padding: 20px; }
    h1, h2 { text-align: center; color: #1d4ed8; margin-bottom: 1.5rem; }
    .form-section { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); max-width: 600px; margin: auto; }
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
  <input type="file" id="offerImage" accept="image/*">
  <img id="offerPreview" class="preview-img" />
  <input type="text" id="offerName" placeholder="Offer Name">
  <input type="number" id="offerPrice" placeholder="Offer Price">
  <textarea id="offerDescription" placeholder="Offer Description" rows="3"></textarea>
  <button id="addOfferBtn" onclick="saveMovie()">Add Offer</button>
</div>

<h2>Offer List</h2>
<button class="btn btn-primary mb-3" onclick="showAddForm()">+ Add Movie</button>
<table class="table table-bordered" id="offerTable">
  <thead>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Price (₹)</th>
      <th>Description</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody id="offerList"></tbody>
</table>

<script>
let editOfferId = null; 

const offerForm = document.getElementById("offerForm");
const offerImage = document.getElementById("offerImage");
const offerPreview = document.getElementById("offerPreview");
const saveBtn = document.getElementById("addOfferBtn");

offerForm.style.display = "none"; // ✅ Hide form initially

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

// ✅ Show Add Form
function showAddForm() {
  clearForm();
  document.getElementById('formTitle').textContent = "Add Offer";
  saveBtn.textContent = "Add Offer";
  offerForm.style.display = "block";
  offerForm.scrollIntoView({ behavior: 'smooth' });
}

// ✅ Clear Form Fields
function clearForm() {
  document.getElementById('offerName').value = '';
  document.getElementById('offerPrice').value = '';
  document.getElementById('offerDescription').value = '';
  offerPreview.src = '';
  offerPreview.style.display = 'none';
  editOfferId = null;
}

// ✅ Fetch and Display Offers
function fetchOffers() {
  fetch("?action=getOffers")
    .then(res => res.json())
    .then(data => {
      const list = document.getElementById('offerList');
      list.innerHTML = '';
      data.forEach(offer => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td><img src="${offer.image}" style="width: 60px; height: 60px; object-fit: cover;"></td>
          <td>${offer.name}</td>
          <td>₹${offer.price}</td>
          <td>${offer.description}</td>
          <td><i class="fa-regular fa-pen-to-square" style="cursor:pointer;color:blue" onclick="editOffer(${offer.id}, '${encodeURIComponent(offer.name)}', '${encodeURIComponent(offer.price)}', '${encodeURIComponent(offer.description)}', '${offer.image}')"></i></td>
          <td><i class="fa-solid fa-trash" style="cursor:pointer;color:red" onclick="deleteOffer(${offer.id})"></i></td>
        `;
        list.appendChild(tr);
      });
    });
}

// ✅ Delete Offer
function deleteOffer(id) {
  if (confirm('Delete this offer?')) {
    fetch("", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `action=deleteOffer&id=${id}`
    }).then(() => fetchOffers());
  }
}

// ✅ Edit Offer
function editOffer(id, name, price, description, image) {
  editOfferId = id;
  document.getElementById('offerName').value = decodeURIComponent(name);
  document.getElementById('offerPrice').value = decodeURIComponent(price);
  document.getElementById('offerDescription').value = decodeURIComponent(description);
  offerPreview.src = image;
  offerPreview.style.display = "block";
  document.getElementById('formTitle').textContent = "Update Offer";
  saveBtn.textContent = "Update Offer";
  offerForm.style.display = "block";
  offerForm.scrollIntoView({ behavior: 'smooth' });
}

// ✅ Add/Update Offer
saveBtn.addEventListener("click", () => {
  const name = document.getElementById('offerName').value.trim();
  const price = document.getElementById('offerPrice').value.trim();
  const description = document.getElementById('offerDescription').value.trim();
  const image = offerPreview.src;

  if (!name || !price || !description || !image.startsWith('data:image')) {
    alert("Please fill all fields");
    return;
  }

  let actionType = editOfferId ? 'updateOffer' : 'addOffer';
  let postData = `action=${actionType}&name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}&description=${encodeURIComponent(description)}&image=${encodeURIComponent(image)}`;
  if (editOfferId) postData += `&id=${editOfferId}`;

  fetch("", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: postData
  })
  .then(res => res.json())
  .then(response => {
    alert(response.message);
    if (response.success) {
      clearForm();
      offerForm.style.display = "none"; // ✅ Hide form after save
      fetchOffers();
    }
  });
});

document.addEventListener("DOMContentLoaded", fetchOffers);
</script>

</body>
</html>

