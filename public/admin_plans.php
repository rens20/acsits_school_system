<?php
// Include database configuration
require_once __DIR__ . '/../config/configuration.php';

// Handle form submission to add events
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $event_date = $_POST['event_date'];
    $event_title = $_POST['event_title'];
    $event_description = $_POST['event_description'];

    $stmt = $conn->prepare("INSERT INTO events (event_date, event_title, event_description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $event_date, $event_title, $event_description);

    if ($stmt->execute()) {
        echo "<script>alert('Event added successfully!');</script>";

        // Generate JSON data for the new event
        $new_event = [
            'event_date' => $event_date,
            'event_title' => $event_title,
            'event_description' => $event_description
        ];

        // Read existing JSON data from file
        $file_path = __DIR__ . '/../json/events.json';
        $json_data = file_get_contents($file_path);
        $events = json_decode($json_data, true);

        // Append the new event to the existing events array
        $events[] = $new_event;

        // Encode the updated events array back to JSON
        $updated_json_data = json_encode($events, JSON_PRETTY_PRINT);

        // Save JSON data back to the file
        file_put_contents($file_path, $updated_json_data);

    } else {
        echo "<script>alert('Error adding event: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fetch all events for display and management
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-8">Event Management</h1>

        <!-- Add Event Form with Animation -->
        <form action="" method="POST" class="bg-white rounded-lg shadow p-6 mb-8 animate__animated animate__fadeInDown">
            <h2 class="text-xl font-bold mb-4">Add New Event</h2>
            <div class="mb-4">
                <label for="event_date">Date:</label>
                <input type="date" id="event_date" name="event_date" required class="block w-full mt-1">
            </div>
            <div class="mb-4">
                <label for="event_title">Title:</label>
                <input type="text" id="event_title" name="event_title" required class="block w-full mt-1">
            </div>
            <div class="mb-4">
                <label for="event_description">Description:</label>
                <textarea id="event_description" name="event_description" rows="4" cols="50" class="block w-full mt-1"></textarea>
            </div>
            <button type="submit" name="add_event" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add Event</button>
        </form>

        <!-- Existing Events List with Animation -->
        <div class="bg-white rounded-lg shadow p-6 mb-8 animate__animated animate__fadeInUp">
            <h2 class="text-xl font-bold mb-4">Existing Events</h2>
            <ul>
                <?php foreach ($events as $event) : ?>
                    <li class="mb-4 border-b border-gray-200 pb-4">
                        <h3 class="font-bold"><?= $event['event_title'] ?></h3>
                        <span><?= $event['event_date'] ?></span>
                        <p class="mt-2"><?= $event['event_description'] ?></p>
                        <div class="mt-4">
                            <a href="edit_event.php?id=<?= $event['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                            <a href="delete_event.php?id=<?= $event['id'] ?>" class="text-red-500 hover:underline ml-4">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Add more functionality and styling as needed -->
    </div>
</body>
</html>
