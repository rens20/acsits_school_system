<?php
// Include database configuration
require_once __DIR__ . '/../config/configuration.php';

// Get the current month and year, or use the month/year from the query parameters
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Calculate the first and last days of the current month
$firstDayOfMonth = date('Y-m-01', strtotime("$year-$month-01"));
$lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

// Calculate the first and last days of the next month
$nextMonth = ($month == 12) ? 1 : $month + 1;
$nextYear = ($month == 12) ? $year + 1 : $year;
$nextFirstDayOfMonth = date('Y-m-01', strtotime("$nextYear-$nextMonth-01"));
$nextLastDayOfMonth = date('Y-m-t', strtotime($nextFirstDayOfMonth));

// Fetch events for the current month and next month
$sql = "SELECT * FROM events 
        WHERE 
            (event_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
            OR 
            (event_date BETWEEN '$nextFirstDayOfMonth' AND '$nextLastDayOfMonth')";
$result = $conn->query($sql);
$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[$row['event_date']][] = $row;
    }
}

// Calculate previous and next month for navigation links
$prevMonth = ($month == 1) ? 12 : $month - 1;
$prevYear = ($month == 1) ? $year - 1 : $year;
$nextMonth = ($month == 12) ? 1 : $month + 1;
$nextYear = ($month == 12) ? $year + 1 : $year;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-8">Calendar</h1>
        <div class="flex justify-between mb-4">
            <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="text-blue-500 hover:underline">Previous</a>
            <h2 class="text-xl font-bold"><?= date('F Y', strtotime("$year-$month-01")) ?></h2>
            <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="text-blue-500 hover:underline">Next</a>
        </div>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <?php
                    $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    foreach ($daysOfWeek as $day) {
                        echo "<th class='py-2 px-4 border-b bg-gray-200'>$day</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the calendar
                $firstDayOfWeek = date('w', strtotime($firstDayOfMonth));
                $daysInMonth = date('t', strtotime($firstDayOfMonth));
                $currentDay = 1;
                $i = 0;

                // Pad the start of the month with empty cells
                echo "<tr>";
                for ($i = 0; $i < $firstDayOfWeek; $i++) {
                    echo "<td class='py-2 px-4 border-b'></td>";
                }

                // Display the days with events for the current month
                while ($currentDay <= $daysInMonth) {
                    if (($i % 7) == 0 && $i != 0) {
                        echo "</tr><tr>";
                    }

                    $currentDate = "$year-$month-" . str_pad($currentDay, 2, '0', STR_PAD_LEFT);
                    echo "<td class='py-2 px-4 border-b align-top'>";
                    echo "<div class='text-center font-bold'>$currentDay</div>";

                    if (isset($events[$currentDate])) {
                        foreach ($events[$currentDate] as $event) {
                            echo "<div class='bg-blue-100 p-2 rounded mt-2'>";
                            echo "<h3 class='font-bold text-sm'>{$event['event_title']}</h3>";
                            echo "<p class='text-gray-700 text-xs'>{$event['event_description']}</p>";
                            echo "</div>";
                        }
                    }

                    echo "</td>";
                    $currentDay++;
                    $i++;
                }

                // Pad the end of the month with empty cells
                while (($i % 7) != 0) {
                    echo "<td class='py-2 px-4 border-b'></td>";
                    $i++;
                }
                echo "</tr>";
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
