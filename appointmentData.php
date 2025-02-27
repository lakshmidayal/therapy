<?php
include "include/header.php";
require_once 'logics/dbConnection.php';

// Fetch all unique booked dates in descending order
$dateQuery = "SELECT DISTINCT date FROM appointment ORDER BY date DESC";
$dateResult = mysqli_query($con, $dateQuery);

// Default date (latest date)
$selectedDate = isset($_GET['date']) ? $_GET['date'] : '';

// Fetch appointments (filtered by date if selected)
$query = "SELECT id, name, CONCAT(date, ' ', time) AS datetime, email, mob_no, treatment, therapy, message FROM appointment";
if (!empty($selectedDate)) {
  $query .= " WHERE date = '$selectedDate'";
}
$query .= " ORDER BY date DESC, time ASC"; // Show latest to earliest

$result = mysqli_query($con, $query);
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
        </tr>
      </thead>
      <tbody>
        <?php
        $sno = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          $formatted_date = date("d/m/y - H:i", strtotime($row['datetime']));

          echo "<tr>";
          echo "<th scope='row'>" . $sno . "</th>";
          echo "<td>" . htmlspecialchars($row['name']) . "</td>";
          echo "<td>" . $formatted_date . "</td>";
          echo "<td>" . htmlspecialchars($row['email']) . "</td>";
          echo "<td>" . htmlspecialchars($row['mob_no']) . "</td>";
          echo "<td>" . htmlspecialchars($row['treatment']) . "</td>";
          echo "<td>" . htmlspecialchars($row['therapy']) . "</td>";
          echo "<td>" . htmlspecialchars($row['message']) . "</td>";
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
    window.location.href = selectedDate ? "?date=" + selectedDate : "?";
  });
</script>

<?php include "include/footer.php"; ?>