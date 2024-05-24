<?php
require_once __DIR__ . '/../config/configuration.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST["task_id"];

    // Update the task status to 'accomplished'
    $sql = "UPDATE task SET status = 'accomplished' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        // Redirect back to the task list page
        header("Location:accomplish_task.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
