 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Movie Booking</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #f8f9fa, #e0eafc);
      padding: 40px;
      color: #333;
    }

    .container {
      max-width: 500px;
      margin: auto;
      padding: 30px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      margin-bottom: 40px;
    }

    h1, h2 {
      text-align: center;
      color: #0077cc;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-top: 20px;
      font-weight: bold;
    }

    select, input[type="date"] {
      padding: 10px;
      width: 100%;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    #movie-details {
      margin-top: 25px;
      font-size: 1.1rem;
      color: #0056b3;
      font-weight: 500;
    }

    .btn, #submit-btn {
      margin-top: 30px;
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      font-weight: bold;
      background-color: #0077cc;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn:hover, #submit-btn:hover {
      background-color: #005fa3;
    }

    .section {
      display: none;
      animation: fadeIn 0.5s ease-in-out;
    }

    .section.active {
      display: block;
    }

    .time-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
      margin-top: 15px;
    }

    button.time-btn {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 12px 18px;
      font-size: 16px;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button.time-btn:hover {
      background-color: #0056b3;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<!-- Step 1: Location & Cinema Selection -->
<div id="locationSection" class="container section active">
  <h1>Location</h1>
  <label for="city-select">Choose your city:</label>
  <select id="city-select">
    <option value="">-- Select City --</option>
    <option value="surat">Surat</option>
    <option value="mumbai">Mumbai</option>
    <option value="hyderabad">Hyderabad</option>
    <option value="delhi">Delhi</option>
    <option value="punjab">Punjab</option>
    <option value="rajasthan">Rajasthan</option>
    <option value="madhyapradesh">Madhya Pradesh</option>
    <option value="kolkata">Kolkata</option>
    <option value="bengaluru">Bengaluru</option>
    <option value="chennai">Chennai</option>
    <option value="lucknow">Lucknow</option>
  </select>

  <div id="dropdown-container"></div>
  <p id="movie-details"></p>
  <button id="submit-btn" style="display: none;">Next</button>
</div>

<!-- Step 2: Date Selection -->
<div id="dateSection" class="container section">
  <h2>Select a Date</h2>
  <input type="date" id="datePicker">
  <button class="btn" onclick="nextToTime(event)">Next</button>
</div>

<!-- Step 3: Time Selection -->
<div id="timeSection" class="container section">
  <h2>Select a Show Time</h2>
  <div class="time-buttons">
    <button class="time-btn" onclick="selectTime('10:00 AM')">10:00 AM</button>
    <button class="time-btn" onclick="selectTime('1:00 PM')">1:00 PM</button>
    <button class="time-btn" onclick="selectTime('4:00 PM')">4:00 PM</button>
    <button class="time-btn" onclick="selectTime('7:00 PM')">7:00 PM</button>
    <button class="time-btn" onclick="selectTime('10:00 PM')">10:00 PM</button>
  </div>
</div>

<script>
  const citySelect = document.getElementById("city-select");
  const dropdownContainer = document.getElementById("dropdown-container");
  const movieDetails = document.getElementById("movie-details");
  const submitBtn = document.getElementById("submit-btn");

  const cinemaData = {
    surat: ["PVR", "INOX", "Carnival", "R World"],
    mumbai: ["Cinepolis", "PVR Phoenix", "MovieTime", "Mukta A2"],
    hyderabad: ["Asian Cinemas", "Prasads", "INOX GVK", "PVR RK Cineplex"],
    delhi: ["PVR Select", "Wave Cinemas", "DT Cinemas", "Fun Cinemas"],
    punjab: ["PVR Amritsar", "Silvercity", "Big Cinemas", "Raj Theatre"],
    rajasthan: ["Raj Mandir", "PVR Jaipur", "INOX Udaipur", "Fun Udaipur"],
    madhyapradesh: ["PVR Bhopal", "SRS Cinemas", "Cinepolis Indore", "Velocity Jabalpur"],
    kolkata: ["Nandan", "Priya Cinema", "INOX Quest", "RDB Adlabs"],
    bengaluru: ["PVR Orion", "Cinepolis Royal", "INOX Garuda", "Urvashi Cinema"],
    chennai: ["Sathyam Cinemas", "Escape", "Luxe", "AGS Cinemas"],
    lucknow: ["PVR Phoenix", "SRS Cinemas", "Cinepolis", "INOX"]
  };

  citySelect.addEventListener("change", function () {
    const selectedCity = this.value;
    dropdownContainer.innerHTML = "";
    movieDetails.textContent = "";
    submitBtn.style.display = "none";

    if (!selectedCity || !cinemaData[selectedCity]) return;

    const cinemas = cinemaData[selectedCity];

    const cinemaSelectHTML = `
      <label for="cinema-select">Choose your cinema in ${selectedCity.charAt(0).toUpperCase() + selectedCity.slice(1)}:</label>
      <select id="cinema-select">
        <option value="">-- Select Cinema --</option>
        ${cinemas.map(cinema => `<option value="${cinema}">${cinema}</option>`).join("")}
      </select>
    `;

    dropdownContainer.innerHTML = cinemaSelectHTML;

    const cinemaSelect = document.getElementById("cinema-select");
    cinemaSelect.addEventListener("change", function () {
      const selectedCinema = this.value;
      if (selectedCinema) {
        movieDetails.textContent = `You selected "${selectedCinema}" in ${selectedCity.charAt(0).toUpperCase() + selectedCity.slice(1)}.`;
        submitBtn.style.display = "block";
      } else {
        movieDetails.textContent = "";
        submitBtn.style.display = "none";
      }
    });
  });

  submitBtn.addEventListener("click", function () {
    const selectedCity = citySelect.value;
    const cinemaSelect = document.getElementById("cinema-select");
    const selectedCinema = cinemaSelect ? cinemaSelect.value : "";

    if (selectedCity && selectedCinema) {
      alert(`✅ Booking initialized at ${selectedCinema} in ${selectedCity.charAt(0).toUpperCase() + selectedCity.slice(1)}!`);
      localStorage.setItem("selectedCity", selectedCity);
      localStorage.setItem("selectedCinema", selectedCinema);
      document.getElementById('locationSection').classList.remove('active');
      document.getElementById('dateSection').classList.add('active');
    }
  });

  function nextToTime(event) {
    event.preventDefault();
    const date = document.getElementById('datePicker').value;
    if (date) {
      localStorage.setItem('selectedDate', date);
      document.getElementById('dateSection').classList.remove('active');
      document.getElementById('timeSection').classList.add('active');
    } else {
      alert('Please select a date.');
    }
  }

  function selectTime(time) {
    localStorage.setItem('selectedTime', time);
    // alert("🎟️ Seat booking will now begin on 'seat.html'");
    window.location.href = 'seat.php';
  }
</script>

</body>
</html>

