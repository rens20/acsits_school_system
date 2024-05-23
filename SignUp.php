<?php

require_once __DIR__ . '../config/configuration.php'; 
require_once __DIR__ . '../config/validation.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $con_password = $_POST['confirm_password'];

    $message = Register($email, $password, $con_password, $fullname);
  
     // If registration is successful, redirect to profile.php with user ID
    if ($message === 'success') {
        header("Location: profile.php?id=$user_id");
        exit(); // Ensure no further output is sent
    } else {
        echo $message; // Display any error messages
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="signup01.css" />
  </head>
  <body>
    <div class="sign-up">
      <div class="overlap-wrapper">
        <div class="overlap">
          <div class="ellipse"></div>
          <div class="rectangle"></div>
          <div class="frame">
            <div class="text-wrapper">SIGN UP</div>
          </div>
          <p class="div">Nice to meet you, Officer!</p>
          <div class="text-wrapper-2">Create New Account</div>
          <img class="logo" src="img/logo.png" />
          
          <form method="POST" action="">
            <div class="frame-2">
              <div class="text-wrapper-3">Full Name</div>
              <img class="identification" src="img/identification-documents.png" />
              <input type="text" name="fullname" class="input" placeholder="Enter your full name" required />
            </div>
            
            <div class="frame-3">
              <div class="text-wrapper-4">Email</div>
              <img class="letter" src="img/letter.png" />
              <input type="email" name="email" class="input" placeholder="Enter your email" required />
            </div>
            
            <div class="frame-4">
              <img class="eye" src="img/eye-1.png" />
              <input class="overlap-group" type="password" name="password" class="input" placeholder="Enter your password" required >
                <div  class="text-wrapper-6">Password</>
                <img class="img" src="img/password-key.png" />
                <!-- <input type="password" name="password" class="input" placeholder="Enter your password" required /> -->
              </div>
              <!-- <input class="text-wrapper-7" type="password" name="confirm_password" class="input" placeholder="Confirm your password" required /> -->
        
            </div>
            
            <div class="frame-5">
              <div class="overlap-2">
                <input class="text-wrapper-7" type="password" name="confirm_password" class="input" placeholder="Confirm your password" required />
                <img class="img" src="img/validation.png" />
           
                <!-- <input type="password" name="confirm_password" class="input" placeholder="Confirm your password" required /> -->
              </div>
              
              <img class="eye" src="img/eye-1.png" />
             <!-- <button type="submit" ><h1>signUP</h1>Sign Up</button> -->
                     <button type="submit" ><h1>signUP</h1>Sign Up</button>
            </div>
            
            <!-- <div class="text-wrapper-8">Already have an Account?</div> -->
            <!-- <div class="frame-6"><div class="text-wrapper-9">Login Here.</div></div> -->
            <!-- <button type="submit" class="submit-button">Sign Up</button> -->
          </form>
          
          <div class="ellipse-2"></div>
          <!-- <img class="add-a-heading" src="img/add-a-heading-3-1.png" /> -->
          <!-- <img class="street-view" src="img/street-view.png" /> -->
        </div>
      </div>
    </div>
  </body>
</html>
