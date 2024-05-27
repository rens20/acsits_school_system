<?php

function ValidateLogin($email, $password) {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users_admin WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) {
            
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['type'];

            // Generate a unique token
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;

            // Redirect based on user role
            if ($user['type'] === 'admin') {
                header("Location: ../public/admin.php");
            } else {
                header("Location: ../public/home.php");
            }
            exit();
        } else {
            // Password is incorrect
            return "Invalid password.";
        }
    } else {
        // Email not found
        return "No user found with that email.";
    }

    // Close connection
    mysqli_close($conn);
}

function Register($email, $fullname, $password,) {
    // if ($password !== $con_password) {
    //     return "Passwords do not match.";
    // }

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $email);
    $fullname = mysqli_real_escape_string($conn, $fullname);
    $password = mysqli_real_escape_string($conn, $password);
    // $con_password = mysqli_real_escape_string($conn, $con_password);

    // Store the plain text password in the database
    $insert = "INSERT INTO users_admin (email, fullname, password,  type) VALUES ('$email', '$fullname', '$password', 'user')";
    if (mysqli_query($conn, $insert)) {
        $report = 'Registration Complete!';
        header("Location: ../public/home.php");
        exit();
    } else {
        $report = 'Error: ' . $insert . '<br>' . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
    return $report;
}
