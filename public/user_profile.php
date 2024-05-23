<?php
require_once __DIR__ . '/../config/configuration.php'; 

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_SESSION['user'] ?? null; // Use null coalescing operator to handle unset session
    if (!$user) {
        echo 'User not logged in.';
        exit;
    }

    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    
    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        // Your image upload code remains the same
        // ...

        // Update user details in the database
        $sql = "UPDATE profiles SET name = ?, age = ?, gender = ?, email = ?, position = ?, profile_image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo 'Error in preparing SQL statement.';
            exit;
        }

        // Bind parameters
        $stmt->bind_param('sisssd', $name, $age, $gender, $email, $position, $profileImagePath, $user['id']);

        if ($stmt->execute()) {
            echo 'Profile updated successfully.';
        } else {
            echo 'Error updating profile: ' . $conn->error;
        }
    } else {
        echo 'Error uploading profile image.';
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Edit Profile</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                <input type="number" id="age" name="age" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" name="gender" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                <input type="text" id="position" name="position" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md">Update Profile</button>
        </form>
    </div>
</body>
</html>
