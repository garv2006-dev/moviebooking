<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>QR Code Scanner</title>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <style>
    #qr-reader {
      width: 300px;
      margin: auto;
      padding-top: 50px;
    }
    #message {
      text-align: center;
      font-size: 1.5em;
      color: green;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div id="qr-reader"></div>
  <div id="message"></div>

  <script>
    function onScanSuccess(decodedText, decodedResult) {
      html5QrcodeScanner.clear().then(_ => {
        document.getElementById("message").innerText = "Welcome! 🎉 QR Code Scanned: " + decodedText;
      }).catch(error => {
        console.error('Failed to clear QR scanner.', error);
      });
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
      "qr-reader", 
      { fps: 10, qrbox: 250 },
      /* verbose= */ false);
      
    html5QrcodeScanner.render(onScanSuccess);
  </script>
</body>
</html>