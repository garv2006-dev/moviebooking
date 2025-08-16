<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking Summary & Payment</title>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f9;
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    .summary {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .summary p {
      font-size: 16px;
      margin: 6px 0;
    }
    .summary p strong {
      color: #444;
    }
    #total {
      font-size: 18px;
      font-weight: bold;
      color: #28a745;
      margin-top: 10px;
    }
    .payment-section {
      margin-top: 30px;
      text-align: center;
    }
    .loading {
      display: none;
      font-weight: bold;
      color: #ff9800;
      margin-top: 15px;
    }
    .confirmation {
      display: none;
      margin-top: 15px;
      font-weight: bold;
      color: green;
    }
    #qr-reader {
      width: 300px;
      margin: 20px auto 0;
    }
  </style>
</head>
<body>

  <h2>🎟 Offer Booking Summary</h2>

  <div class="summary">
    <p><strong>Movie:</strong> <span id="movie"></span></p>
    <p><strong>Name:</strong> <span id="cust-name"></span></p>
    <p><strong>Phone:</strong> <span id="cust-phone"></span></p>
    <p><strong>Email:</strong> <span id="cust-email"></span></p>
    <p><strong>Date:</strong> <span id="date"></span></p>
    <p><strong>Time:</strong> <span id="time"></span></p>
    <p><strong>Seats:</strong> <span id="seats"></span></p>
    <p><strong>Ticket Price:</strong> ₹<span id="price"></span></p>
    <p id="total"></p>
  </div>

  <div class="payment-section">
    <h3>📱 Scan to Pay</h3>
    <p>Use any UPI app to scan the QR code below.</p>
    <div id="qr-reader"></div>
    <div class="loading" id="loading">🔄 Verifying payment...</div>
    <div class="confirmation" id="confirmation">✅ Payment successful! Enjoy your movie.</div>
  </div>

  <script>
    // Retrieve booking data
      const movieName = localStorage.getItem('selectedMovieName') || '—';
      const userData = JSON.parse(localStorage.getItem('bookingUser') || '{}');
      const date = localStorage.getItem('selectedDate') || '—';
      const time = localStorage.getItem('selectedTime') || '—';
      const seats = JSON.parse(localStorage.getItem('selectedSeats') || '[]');
      const pricePerSeat = parseFloat(localStorage.getItem("selectedMoviePrice")) || 0;
      const total = seats.length * pricePerSeat;

      // Populate fields
      document.getElementById('movie').textContent = movieName;
      document.getElementById('cust-name').textContent = userData.name || '—';
      document.getElementById('cust-phone').textContent = userData.phone || '—';
      document.getElementById('cust-email').textContent = userData.email || '—';
      document.getElementById('date').textContent = date;
      document.getElementById('time').textContent = time;
      document.getElementById('seats').textContent = seats.join(', ') || '—';
      document.getElementById('price').textContent = pricePerSeat.toFixed(2);
      document.getElementById('total').textContent = `Total: ₹${total.toFixed(2)}`;

    // QR Code Scanner
    function onScanSuccess(decodedText) {
      document.getElementById("loading").style.display = 'block';
      html5QrcodeScanner.clear().then(() => {
        setTimeout(() => {
          document.getElementById("loading").style.display = 'none';
          document.getElementById("confirmation").style.display = 'block';
        }, 2000);
      }).catch(error => console.error('Failed to stop QR scanner.', error));
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
      "qr-reader",
      { fps: 10, qrbox: 250 },
      false
    );
    html5QrcodeScanner.render(onScanSuccess);
  </script>

</body>
</html>
