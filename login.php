<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CineBook</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        #lgpage {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #fff;
            font-weight: 600;
        }

        .form-row {
            margin-bottom: 25px;
            position: relative;
        }

        .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.7;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px 15px 15px 45px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #e50914;
            background: rgba(255, 255, 255, 0.15);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: #e50914;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #b20710;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            #lgpage {
                padding: 30px 20px;
                margin: 0 15px;
            }
            
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <form id="lgpage" onsubmit="handleLogin(event)">

      <h1>Sign In to CineBook</h1>
  
      <div class="form-row">
        <img src="./img/man.jpg" alt="User Icon" class="icon">
        <input type="text" id="n1" placeholder="Username" required>
      </div>
  
      <div class="form-row">
        <img src="./img/loce.png" alt="Lock Icon" class="icon">
        <input type="password" id="n2" placeholder="Password" required>
      </div>
      <!-- <a href="register.php">Create New Account</a> -->
      <div class="form-row">
        <input type="submit" value="Login" class="submit-btn">
      </div>
    </form>
    <script>
function handleLogin(e) {
    e.preventDefault(); // stop default form action

    const username = document.getElementById("n1").value;
    const password = document.getElementById("n2").value;

    // Admin credentials
    const adminUser = "admin";
    // const adminPass = "admin123";

    if (username === adminUser) {
        // Redirect to admin panel
        // window.location.href='http://localhost/new/index.php';
                window.location.href="admin.php";

    } else {
        // alert("not valid create new account plz");
        window.location.href="indexss.php";
    }
}
</script>

</body>
</html>