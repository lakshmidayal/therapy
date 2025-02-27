<?php
include "logics/dbConnection.php";

$disabledSlots = [];

// Fetch disabled slots from the database
$query = "SELECT date, time FROM disabled_slots";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['date'];
    $time = $row['time'];

    if (!isset($disabledSlots[$date])) {
        $disabledSlots[$date] = [];
    }

    if ($time) {
        $disabledSlots[$date][] = $time; // Store disabled time slots
    } else {
        $disabledSlots[$date] = "full-day"; // Mark full-day disabled
    }
}

mysqli_close($con);

// Send JSON response
header("Content-Type: application/json");
echo json_encode($disabledSlots);
