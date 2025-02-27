<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (($_SESSION['role'] == 'admin')) {
    header('Location: index.php');
    exit();
}
require_once 'logics/dbConnection.php';

$bookedSlots = [];

// Fetch booked appointments
$query = "SELECT date, TIME_FORMAT(time, '%H:%i') AS time FROM appointment where isDeleted <> 'Y'";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['date'];
    $time = $row['time'];

    if (!isset($bookedSlots[$date])) {
        $bookedSlots[$date] = [];
    }
    $bookedSlots[$date][] = $time;
}

header("Content-Type: application/json");
echo json_encode($bookedSlots);

mysqli_close($con);
