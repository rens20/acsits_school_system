<?php
require_once __DIR__ . '/../config/configuration.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = $_POST['text'];
    $description = $_POST['description'];

    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOK = 1;

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOK = 1;
    } else {
        echo "File is not an image.";
        $uploadOK = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOK = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOK = 0;
    }

    // Check if $uploadOK is set to 0 by an error
    if ($uploadOK == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO merch (text, description, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $text, $description, $target_file);

            if ($stmt->execute()) {
                echo "The announcement has been uploaded successfully.";
            } else {
                echo "ERROR: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Merch</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Send Merch</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-md">
            <div class="mb-4">
                <label for="text" class="block text-sm font-medium text-gray-700">Announcement Name</label>
                <input type="text" id="text" name="text" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" id="image" name="image" accept="image/*" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Send Merch</button>
        </form>
    </div>
</body>
</html>
