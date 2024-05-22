<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
        <h1 class="text-xl font-bold mb-4">Send Announcement</h1>
        <?php
        require_once __DIR__ . '/../config/configuration.php'; 
       

            // Prepare and bind parameters
            $stmt = $conn->prepare("INSERT INTO announcements (name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $description);

            // Set parameters and execute
            $name = $_POST["name"];
            $description = $_POST["description"];
            $stmt->execute();

            // Close statement and connection
            $stmt->close();
            $conn->close();

            echo '<div class="bg-green-200 text-green-900 p-2 mb-4">Announcement sent successfully!</div>';
        
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send</button>
        </form>
    </div>
</body>
</html>
