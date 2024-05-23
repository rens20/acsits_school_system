<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">merch</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
             require_once __DIR__ . '/../config/configuration.php';

            $sql = "SELECT text, description, image_path, created_at FROM merch ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<div class="bg-white p-4 rounded shadow-md">';
                    echo '<h2 class="text-xl font-bold">' . htmlspecialchars($row["text"]) . '</h2>';
                    echo '<p class="text-gray-700">' . htmlspecialchars($row["description"]) . '</p>';
                    if (!empty($row["image_path"])) {
                        echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="' . htmlspecialchars($row["text"]) . '" class="mt-2 rounded">';
                    }
                    echo '<p class="text-sm text-gray-500 mt-2">Posted on ' . date("F j, Y, g:i a", strtotime($row["created_at"])) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No announcements found.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
