<?php
require_once __DIR__ . '/../config/configuration.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['month']) && isset($_GET['year'])) {
    $month = intval($_GET['month']);
    $year = intval($_GET['year']);

    // Calculate the first and last days of the month
    $firstDayOfMonth = date('Y-m-01', strtotime("$year-$month-01"));
    $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

    // Fetch events for the month
    $sql = "SELECT * FROM events WHERE event_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
    $result = $conn->query($sql);

    $events = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[$row['event_date']][] = $row;
        }
    }

    // Generate the calendar HTML
    $html = '<thead><tr>';
    $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    foreach ($daysOfWeek as $day) {
        $html .= "<th class='py-2 px-4 border-b bg-gray-200'>$day</th>";
    }
    $html .= '</tr></thead><tbody>';

    $firstDayOfWeek = date('w', strtotime($firstDayOfMonth));
    $daysInMonth = date('t', strtotime($firstDayOfMonth));
    $currentDay = 1;
    $i = 0;

    $html .= '<tr>';
    for ($i = 0; $i < $firstDayOfWeek; $i++) {
        $html .= "<td class='py-2 px-4 border-b'></td>";
    }

    while ($currentDay <= $daysInMonth) {
        if (($i % 7) == 0 && $i != 0) {
            $html .= '</tr><tr>';
        }

        $currentDate = "$year-$month-" . str_pad($currentDay, 2, '0', STR_PAD_LEFT);
        $html .= "<td class='py-2 px-4 border-b align-top'>";
        $html .= "<div class='text-center font-bold'>$currentDay</div>";

        if (isset($events[$currentDate])) {
            foreach ($events[$currentDate] as $event) {
                $html .= "<div class='bg-blue-100 p-2 rounded mt-2'>";
                $html .= "<h3 class='font-bold text-sm'>{$event['event_title']}</h3>";
                $html .= "<p class='text-gray-700 text-xs'>{$event['event_description']}</p>";
                $html .= '</div>';
            }
        }

        $html .= '</td>';
        $currentDay++;
        $i++;
    }

    while (($i % 7) != 0) {
        $html .= "<td class='py-2 px-4 border-b'></td>";
        $i++;
    }

    $html .= '</tr></tbody>';

    echo $html;
}

$conn->close();
?>
