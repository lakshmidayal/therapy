<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!($_SESSION['role'] == 'admin')) {
    header('Location: index.php');
    exit();
}
require_once 'logics/dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $time = isset($_POST['time']) && $_POST['time'] !== '' ? mysqli_real_escape_string($con, $_POST['time']) : null;
    $reason = mysqli_real_escape_string($con, $_POST['reason']);

    // Check if an appointment already exists for the selected date (regardless of time)
    $checkDateQuery = "SELECT COUNT(*) as count FROM appointment WHERE date = ? AND isDeleted <> 'Y'";
    $stmtCheckDate = mysqli_prepare($con, $checkDateQuery);
    mysqli_stmt_bind_param($stmtCheckDate, "s", $date);
    mysqli_stmt_execute($stmtCheckDate);
    $resultDate = mysqli_stmt_get_result($stmtCheckDate);
    $rowDate = mysqli_fetch_assoc($resultDate);

    if ($rowDate['count'] > 0) {
        echo "<div class='alert alert-warning'>An appointment already exists on this date. Please delete the existing appointment first.</div>";
    } else {
        // Check if an appointment already exists for the selected date and time
        $checkAppointmentQuery = "SELECT COUNT(*) as count FROM appointment WHERE date = ? AND time = ? AND isDeleted <> 'Y'";
        $stmtCheckAppointment = mysqli_prepare($con, $checkAppointmentQuery);
        mysqli_stmt_bind_param($stmtCheckAppointment, "ss", $date, $time);
        mysqli_stmt_execute($stmtCheckAppointment);
        $resultAppointment = mysqli_stmt_get_result($stmtCheckAppointment);
        $rowAppointment = mysqli_fetch_assoc($resultAppointment);

        if ($rowAppointment['count'] > 0) {
            echo "<div class='alert alert-warning'>An appointment already exists for this date and time. Please delete the existing appointment first.</div>";
        } else {
            // Check if the slot is already disabled
            $checkQuery = "SELECT COUNT(*) as count FROM disabled_slots WHERE date = ? AND (time IS NULL OR time = ?)";
            $stmtCheck = mysqli_prepare($con, $checkQuery);
            mysqli_stmt_bind_param($stmtCheck, "ss", $date, $time);
            mysqli_stmt_execute($stmtCheck);
            $result = mysqli_stmt_get_result($stmtCheck);
            $row = mysqli_fetch_assoc($result);

            if ($row['count'] > 0) {
                echo "<div class='alert alert-warning'>This date or time is already disabled!</div>";
            } else {
                // Insert disabled slot
                $query = "INSERT INTO disabled_slots (date, time, reason) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "sss", $date, $time, $reason);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<div class='alert alert-success'>Slot disabled successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
                }

                mysqli_stmt_close($stmt);
            }

            mysqli_stmt_close($stmtCheck);
        }

        mysqli_stmt_close($stmtCheckAppointment);
    }

    mysqli_stmt_close($stmtCheckDate);
}

// Fetch disabled slots for table display
$disabledSlots = mysqli_query($con, "SELECT id, date, time, reason FROM disabled_slots");

mysqli_close($con);
include "include/header.php";


?>


<section class="breadcrumbs">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Disable Appointment Slot</h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Disable Slot</li>
            </ol>
        </div>
    </div>
</section>

<section id="disable-slot" class="appointment section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Disable a Date or Time Slot</h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <form role="form" class="email-form" method="POST" action="">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label><strong>Select Date:</strong></label>
                    <input type="text" name="date" id="disable-date" class="form-control" placeholder="Select Date" required readonly="true">

                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Select Time (Optional):</strong></label>
                    <select name="time" id="disable-time" class="form-control">
                        <option value="">Full Day</option>
                        <?php for ($hour = 10; $hour <= 17; $hour++) {
                            $time = sprintf("%02d:00", $hour);
                            echo "<option value='$time'>$time</option>";
                        } ?>
                    </select>
                </div>

                <div class="col-md-12 form-group mt-3">
                    <label><strong>Reason:</strong></label>
                    <input type="text" name="reason" class="form-control" placeholder="Reason for disabling the slot">
                </div>
            </div>

            <div class="button mt-4" style="text-align: center; width: 250px; height: 70px; margin: auto;">
                <button type="submit" class="btn btn-danger btn-lg">Disable Slot</button>
            </div>
        </form>
    </div>
</section>

<!-- Disabled Slots Table -->
<section class="container mt-5">
    <h3>Disabled Slots</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($disabledSlots)) { ?>
                <tr>
                    <td><?= $row['date']; ?></td>
                    <td><?= $row['time'] ? $row['time'] : "Full Day"; ?></td>
                    <td><?= $row['reason']; ?></td>
                    <td>
                        <a href="delete_slot.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<script>
    $(document).ready(function() {
        $("#disable-date").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0
        });
    });
</script>

<?php include "include/footer.php"; ?>