<?php
session_start();
require_once __DIR__ . '../config/configuration.php';
require_once __DIR__ . '../config/validation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate login credentials
    $user = ValidateLogin($email, $password);

    if (is_string($user)) {
        echo '<script>alert("Login failed: ' . $user . '");</script>';
    } else {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['type'];

        // Generate a unique token
        $token = bin2hex(random_bytes(16));
        $_SESSION['token'] = $token;

        // Redirect based on user type
        switch ($user['type']) {
            case 'admin':
                header("Location: ./admin/home.php?id=" . urlencode($user['id']));
                exit();
            case 'user':
                header("Location: ./users/product.php?id=" . urlencode($user['id']));
                exit();
            default:
                echo "Invalid user type";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="globals.css" />
  <link rel="stylesheet" href="login01.css" />
</head>

<body>
  <div class="login">
    <div class="overlap-wrapper">
      <div class="overlap">
        <div class="ellipse"></div>
        <div class="rectangle"></div>
        <div class="frame">
          <div class="text-wrapper">
            <a href="login1.html">
              <button class="Button">LOGIN</button>
            </a>
          </div>
        </div>
        <p class="div">Nice to meet you, Officer!</p>
        <div class="text-wrapper-2">Login Your Account</div>
        <img class="logo" src="img/logo.png" />
        <form method="POST" action="">
          <div class="frame-2">
            <input type="email" name="email" class="input" placeholder="Enter your email" required />
            <img class="letter" src="img/letter.png" />
          </div>
          <div class="frame-3">
            <img class="eye" src="img/eye.png" />
            <div class="overlap-group">
              <input type="password" name="password" class="input" placeholder="Enter your password" required />
              <img class="password-key" src="img/password-key.png" />
            </div>
          </div>
          <button type="submit" class="submit-button">Login</button>
        </form>
        <div class="text-wrapper-5">Don’t have an Account?</div>
        <div class="div-wrapper"><a href="signup.html" class="text-wrapper-6">Signup Here.</a></div>
        <div class="ellipse-2"></div>
        <img class="add-a-heading" src="img/add-a-heading-3-1.png" />
      </div>
    </div>
  </div>
</body>

</html>