<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!($_SESSION['role'] == 'admin')) {
  header('Location: index.php');
  exit();
}
// echo '<script>alert(' . $_SESSION . ')</script>';
include "include/header.php";
require_once 'logics/dbConnection.php';

// Fetch all unique booked dates in descending order
$dateQuery = "SELECT DISTINCT date FROM appointment where isDeleted <> 'Y' ORDER BY date DESC";
$dateResult = mysqli_query($con, $dateQuery);

// Default date (latest date)
$selectedDate = isset($_GET['date']) ? $_GET['date'] : '';

// Fetch appointments (filtered by date if selected)
$query = "SELECT id, name, CONCAT(date, ' ', time) AS datetime, email, mob_no, treatment, therapy, message, status, isDeleted FROM appointment";
if (!empty($selectedDate)) {
  $query .= " WHERE date = '$selectedDate'";
}
$query .= " ORDER BY date DESC, time ASC"; // Show latest to earliest

$result = mysqli_query($con, $query);

// Handle the 'Accept' and 'Delete' actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['accept_id'])) {
    // Update status to 'Accepted'
    $acceptId = $_POST['accept_id'];
    $updateQuery = "UPDATE appointment SET status = 'accepted' WHERE id = $acceptId";
    mysqli_query($con, $updateQuery);
  }
  if (isset($_POST['pending_id'])) {
    // Update status to 'Pending'
    $pendingId = $_POST['pending_id'];
    $updateQuery = "UPDATE appointment SET status = 'pending' WHERE id = $pendingId";
    mysqli_query($con, $updateQuery);
  }

  if (isset($_POST['delete_id'])) {
    // Mark as deleted
    $deleteId = $_POST['delete_id'];
    $deleteQuery = "UPDATE appointment SET isDeleted = 'Y' WHERE id = $deleteId";
    mysqli_query($con, $deleteQuery);
  }

  // Get the selected date from the GET parameter or fall back to an empty string
  $currentDate = isset($_GET['date']) ? $_GET['date'] : '';
  // Reload the page with the same date filter applied
  echo "<script>window.location.href = 'appointmentData.php?date=" . $currentDate . "';</script>";
}
?>

<div class="container">
  <div class="text-center m-4 text-uppercase">
    <h4><U>Appointment Listing</U></h4>
  </div>

  <!-- Dropdown for filtering appointments by date -->
  <div class="mb-3">
    <label for="filter-date" class="form-label">Filter by Date:</label>
    <select id="filter-date" class="form-select">
      <option value="">All Dates</option>
      <?php
      while ($row = mysqli_fetch_assoc($dateResult)) {
        $dateValue = $row['date'];
        $selected = ($selectedDate == $dateValue) ? "selected" : "";
        echo "<option value='$dateValue' $selected>$dateValue</option>";
      }
      ?>
    </select>
  </div>

  <!-- Appointment Table -->
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-sm mt-4">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Name</th>
          <th scope="col">Date & Time</th>
          <th scope="col">Email</th>
          <th scope="col">Mob. No</th>
          <th scope="col">Treatment</th>
          <th scope="col">Therapy</th>
          <th scope="col">Message</th>
          <th scope="col">Status</th>
          <th colspan="2" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sno = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          $formatted_date = date("d/m/y - H:i", strtotime($row['datetime']));
          $status = $row['status'];
          $isDeleted = $row['isDeleted'];

          // Skip deleted appointments
          if ($isDeleted == 'Y') {
            continue;
          }

          echo "<tr>";
          echo "<th scope='row'>" . $sno . "</th>";
          echo "<td>" . htmlspecialchars($row['name']) . "</td>";
          echo "<td>" . $formatted_date . "</td>";
          echo "<td>" . htmlspecialchars($row['email']) . "</td>";
          echo "<td>" . htmlspecialchars($row['mob_no']) . "</td>";
          echo "<td>" . htmlspecialchars($row['treatment']) . "</td>";
          echo "<td>" . htmlspecialchars($row['therapy']) . "</td>";
          echo "<td>" . htmlspecialchars($row['message']) . "</td>";
          echo "<td>" . ($status ? htmlspecialchars($status) : 'pending') . "</td>";

          // Action buttons
          if ($status == 'accepted') {
            echo "<td>
                    <form method='POST' style='display:inline;'>
                      <button type='submit' class='btn btn-warning btn-sm' name='pending_id' value='" . $row['id'] . "'>Pending</button>
                    </form>
                  </td>";
          } else {
            echo "<td>
                    <form method='POST' style='display:inline;'>
                      <button type='submit' class='btn btn-success btn-sm' name='accept_id' value='" . $row['id'] . "'>Accept</button>
                    </form>
                  </td>";
          }

          echo "<td>
                  <form method='POST' style='display:inline;'>
                    <button type='submit' class='btn btn-danger btn-sm' name='delete_id' value='" . $row['id'] . "'>Delete</button>
                  </form>
                </td>";
          echo "</tr>";

          $sno++;
        }
        mysqli_close($con);
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  document.getElementById("filter-date").addEventListener("change", function() {
    let selectedDate = this.value;
    window.location.href = selectedDate ? "appointmentData.php?date=" + selectedDate : "appointmentData.php"; // Use the correct path without query params if empty
  });
</script>

<?php include "include/footer.php"; ?>