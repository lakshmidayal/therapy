<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!($_SESSION['role'] == 'admin')) {
    header('Location: index.php');
    exit();
}
require_once "logics/dbConnection.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM disabled_slots WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: disable_slot.php?success=1");
    } else {
        echo "<div class='alert alert-danger'>Error deleting slot.</div>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($con);
