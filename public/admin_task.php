
<?php
 require_once __DIR__ . '/../config/configuration.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $due_date = $_POST["due_date"];
    $assignee = $_POST["assignee"];

    // Insert into the database
    $sql = "INSERT INTO task (title, description, due_date, assignee) 
            VALUES ('$title', '$description', '$due_date', '$assignee')";

    if ($conn->query($sql) === TRUE) {

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200 py-8">
    <div class="max-w-4xl mx-auto">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Task Management</h1>
            <div class="space-x-4">
                <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Add Task</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600
                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">My Task</button>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600
                    focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">Accomplish Task</button>
            </div>
        </header>
        <div id="modal" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-md shadow-md">
                <h1 class="text-2xl font-bold mb-4">Add Task</h1>
                <form action="" method="POST">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                        <input type="text" id="title" name="title" class="mt-1 px-4 py-2 block w-full border-gray-300
                            rounded-md focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 px-4 py-2 block w-full
                            border-gray-300 rounded-md focus:ring-violet-500 focus:border-violet-500 sm:text-sm"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date:</label>
                        <input type="date" id="due_date" name="due_date" class="mt-1 px-4 py-2 block w-full border-gray-300
                            rounded-md focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="assignee" class="block text-sm font-medium text-gray-700">Assign To:</label>
                        <input type="text" id="assignee" name="assignee" class="mt-1 px-4 py-2 block w-full border-gray-300
                            rounded-md focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" id="true" class="bg-violet-500 text-black px-4 py-2 rounded-md hover:bg-violet-600
                            focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">Add Task</button>
                        <button onclick="closeModal()" type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md
                            hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 ml-4">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();
            showSweetAlert();
            setTimeout(function () {
                document.querySelector('form').submit();
            }, 5000);
        });

        function showSweetAlert() {
            Swal.fire({
                title: "Success",
                text: "Task added successfully",
                icon: "success"
            });
        }
    </script>
</body>

</html>
