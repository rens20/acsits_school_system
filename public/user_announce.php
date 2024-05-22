<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Announcements</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
        <h1 class="text-xl font-bold mb-4">Announcements</h1>
        <?php
        require_once __DIR__ . '/../config/configuration.php'; 

        // Retrieve announcements from the database
        $sql = "SELECT name, description FROM announcements ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="mb-4">';
                echo '<h3 class="text-lg font-bold">' . $row["name"] . '</h3>';
                echo '<p>' . $row["description"] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No announcements available.</p>';
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
