<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking Summary & Payment</title>
  
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      background-color: #f0f2f5;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
    }
    .card {
      max-width: 600px;
      width: 100%;
      margin: 24px;
      padding: 24px;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0,0,0,.08);
      background: #fff;
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 24px;
      font-size: 24px;
    }
    .summary {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 12px;
      border: 1px solid #eee;
    }
    .summary p {
      font-size: 16px;
      margin: 8px 0;
      display: flex;
      justify-content: space-between;
    }
    .summary p strong {
      color: #444;
    }
    #total {
      font-size: 20px;
      font-weight: bold;
      color: #28a745;
      margin-top: 12px;
      text-align: right;
    }
    .payment-section {
      margin-top: 30px;
      text-align: center;
    }
    .loading, .confirmation {
      display: none;
      font-weight: bold;
      margin-top: 15px;
    }
    .loading { color: #ff9800; }
    .confirmation { color: green; }
    #qr-reader {
      width: 280px;
      margin: 20px auto 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    #downloadBill {
      display: none; /* Initially hidden */
      margin-top: 20px;
      padding: 12px 24px;
      border: none;
      background: #007bff;
      color: #fff;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    #downloadBill:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

<div class="card">
  <h2>🎟️ Offer Booking Summary</h2>

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
    <div id="payment-box">
        <h3>📱 Scan to Pay</h3>
        <p>Use any UPI app to scan the QR code below.</p>
        <div id="qr-reader"></div>
    </div>
    <div class="loading" id="loading">🔄 Verifying payment...</div>
    <div class="confirmation" id="confirmation">✅ Payment successful! Enjoy your movie.</div>
    <button id="downloadBill">⬇️ Download Bill</button>
  </div>
</div>

<script>
    // Retrieve booking data from localStorage
    const movieName = localStorage.getItem('selectedMovieName') || '—';
    const userData = JSON.parse(localStorage.getItem('bookingUser') || '{}');
    const date = localStorage.getItem('selectedDate') || '—';
    const time = localStorage.getItem('selectedTime') || '—';
    const seats = JSON.parse(localStorage.getItem('selectedSeats') || '[]');
    const pricePerSeat = parseFloat(localStorage.getItem("selectedMoviePrice")) || 0;
    const total = seats.length * pricePerSeat;

    // Populate summary fields on the page
    document.getElementById('movie').textContent = movieName;
    document.getElementById('cust-name').textContent = userData.name || '—';
    document.getElementById('cust-phone').textContent = userData.phone || '—';
    document.getElementById('cust-email').textContent = userData.email || '—';
    document.getElementById('date').textContent = date;
    document.getElementById('time').textContent = time;
    document.getElementById('seats').textContent = seats.join(', ') || '—';
    document.getElementById('price').textContent = pricePerSeat.toFixed(2);
    document.getElementById('total').textContent = `Total: ₹${total.toFixed(2)}`;

    // --- QR Code Scanner Logic ---
    function onScanSuccess(decodedText) {
      const paymentBox = document.getElementById("payment-box");
      const loadingDiv = document.getElementById("loading");
      const confirmationDiv = document.getElementById("confirmation");
      const downloadBtn = document.getElementById("downloadBill");
      
      paymentBox.style.display = 'none'; // Hide scanner
      loadingDiv.style.display = 'block'; // Show loading message
      
      html5QrcodeScanner.clear().then(() => {
        setTimeout(() => {
          loadingDiv.style.display = 'none'; // Hide loading
          confirmationDiv.style.display = 'block'; // Show confirmation
          downloadBtn.style.display = 'inline-block'; // Show download button
        }, 2000);
      }).catch(error => console.error('Failed to stop QR scanner.', error));
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
      "qr-reader", { fps: 10, qrbox: 250 }, false
    );
    html5QrcodeScanner.render(onScanSuccess);

    // --- PDF Download Logic ---
    document.getElementById("downloadBill").addEventListener("click", () => {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      // Title
      doc.setFontSize(20);
      // **** THIS LINE IS CHANGED ****
      doc.text("CineBook - Offer Booking Invoice", 14, 22);
      doc.setFontSize(12);
      doc.text(`Booking Date: ${new Date().toLocaleDateString()}`, 14, 30);

      // Table Data
      const tableData = [
        ["Movie", movieName],
        ["Name", userData.name || "—"],
        ["Phone", userData.phone || "—"],
        ["Email", userData.email || "—"],
        ["Show Date", date],
        ["Show Time", time],
        ["Seats", seats.join(', ') || "—"],
        ["Price per Ticket", `₹${pricePerSeat.toFixed(2)}`],
        ["Total Amount", `₹${total.toFixed(2)}`],
        ["Status", "✅ Payment Successful"]
      ];

      doc.autoTable({
        startY: 40,
        head: [['Detail', 'Information']],
        body: tableData,
        theme: "grid",
        headStyles: { fillColor: [22, 160, 133], halign: 'center' },
        columnStyles: { 0: { fontStyle: 'bold' } }
      });

      // Footer
      const finalY = doc.lastAutoTable.finalY || 100;
      doc.setFontSize(10);
      doc.text("Thank you for booking with CineBook!", 14, finalY + 15);
      
      doc.save("CineBook_Offer_Ticket.pdf");
    });
</script>

</body>
</html>