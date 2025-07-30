<!-- Select Seats Page -->
<!DOCTYPE html>
<html>
<head>
  <title>Select Seats</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #fdfbfb, #ebedee);
      padding: 30px;
      max-width: 800px;
      margin: auto;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
      margin-top: 60px;
    }
  
    h2 {
      color: #333;
      margin-bottom: 20px;
    }
  
    #seatsContainer {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
  
    .seat {
      background-color: #007bff;
      color: #fff;
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
  
    .seat:hover {
      transform: scale(1.05);
      background-color: #0056b3;
    }
  
    .seat.selected {
      background-color: #28a745;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
  
    button {
      background-color: #ffc107;
      color: #000;
      border: none;
      padding: 12px 24px;
      font-size: 16px;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
  
    button:hover {
      background-color: #e0a800;
    }
    .container{
      border: 2px solid #007bff;
      background: #f4f4f9;
      width: 100%;
      height: 10px;
      background-color: #000;
    }
  </style>
  
</head>
<body>
  <div class="container"></div>
  <h2>Select Seats</h2>
  <div id="seatsContainer"></div>
  <button onclick="proceed()">Next</button>

  <script>
    const seatsContainer = document.getElementById('seatsContainer');
    let selectedSeats = [];

    for (let i = 1; i <= 99; i++) {
      const seat = document.createElement('div');
      seat.className = 'seat';
      seat.innerText = `${i}`;
      seat.onclick = () => {
        seat.classList.toggle('selected');
        const seatName = seat.innerText;
        if (selectedSeats.includes(seatName)) {
          selectedSeats = selectedSeats.filter(s => s !== seatName);
        } else {
          selectedSeats.push(seatName);
        }
      };
      seatsContainer.appendChild(seat);
    }

    function proceed() {
      if (selectedSeats.length === 0) {
        alert('Select at least one seat.');
        return;
      }
      localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
      window.location.href = 'bill.php';
    }
  </script>
</body>
</html>