<?php
include "include/header.php";

require_once 'logics/dbConnection.php';
$query = "SELECT * FROM appointment";
$result = mysqli_query($con, $query);

?>

<div class="container table-responsive">
  <div class="text-center m-4 text-uppercase">
    <h4><U>Appointment Listing</U></h4>
  </div>
  <table class="table table-striped table-bordered table-sm mt-4">
    <thead>
      <tr>
        <th scope="col">S.No</th>
        <th scope="col">Name</th>
        <th scope="col">Date</th>
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
        echo "<tr>";
        echo "<th scope='row'>" . $sno . "</th>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
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

<?php
include "include/footer.php";
?>