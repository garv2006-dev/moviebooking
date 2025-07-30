<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bill Summary & QR Scanner</title>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f9;
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      text-align: center;
    }

    h2, h3 {
      margin-bottom: 15px;
      color: #333;
    }

    p {
      font-size: 16px;
      margin: 8px 0;
    }

    #total {
      font-weight: bold;
      font-size: 20px;
      color: #28a745;
    }

    .confirmation {
      margin-top: 20px;
      font-weight: bold;
      color: green;
      display: none;
    }

    .loading {
      display: none;
      font-weight: bold;
      color: #ff9800;
      margin-top: 20px;
    }

    #qr-reader {
      width: 300px;
      margin: 30px auto 10px auto;
    }

    img {
      width: 200px;
      height: 200px;
      margin-top: 10px;
      border-radius: 12px;
      border: 5px solid #fff;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <h2>🎟️ Booking Summary</h2>
  <p id="date"></p>
  <p id="time"></p>
  <p id="seats"></p>
  <p id="total"></p>

  <div>
    <h3>📱 Scan to Pay</h3>
    <p>Use any UPI app to scan below QR code.</p>
    
  </div>

  <div id="qr-reader"></div>

  <div class="loading" id="loading">🔄 Verifying payment...</div>
  <div class="confirmation" id="confirmation">✅ Payment successful! Enjoy your movie.</div>

  <script>
    // Load booking data
    const date = localStorage.getItem('selectedDate');
    const time = localStorage.getItem('selectedTime');
    const seats = JSON.parse(localStorage.getItem('selectedSeats') || '[]');
    const pricePerSeat = 150;
    const total = seats.length * pricePerSeat;

    document.getElementById('date').textContent = `📅 Date: ${date}`;
    document.getElementById('time').textContent = `⏰ Time: ${time}`;
    document.getElementById('seats').textContent = `💺 Seats: ${seats.join(', ')}`;
    document.getElementById('total').textContent = `Total: ₹${total}`;


    // QR Code Scanner
    function onScanSuccess(decodedText, decodedResult) {
      // Optional: check content of decodedText if needed
      document.getElementById("loading").style.display = 'block';

      html5QrcodeScanner.clear().then(_ => {
        setTimeout(() => {
          document.getElementById("loading").style.display = 'none';
          document.getElementById("confirmation").style.display = 'block';
        }, 2000); // simulate verification delay
      }).catch(error => {
        console.error('Failed to stop QR scanner.', error);
      });
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