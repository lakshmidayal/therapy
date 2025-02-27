<?php
require_once 'logics/dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = mysqli_real_escape_string($con, trim($_POST['name']));
  $date = mysqli_real_escape_string($con, trim($_POST['date']));
  $time = mysqli_real_escape_string($con, trim($_POST['time']));
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $mob_no = mysqli_real_escape_string($con, trim($_POST['subject']));
  $treatment = mysqli_real_escape_string($con, trim($_POST['department']));
  $therapy = mysqli_real_escape_string($con, trim($_POST['doctor']));
  $message = mysqli_real_escape_string($con, trim($_POST['message']));

  if (empty($name) || empty($date) || empty($time) || empty($email) || empty($mob_no)) {
    echo '<div class="alert alert-danger">Please fill all required fields!</div>';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="alert alert-danger">Invalid email format!</div>';
  } else {
    // ✅ Check if the selected date or time is disabled
    $checkDisabledQuery = "SELECT COUNT(*) as count FROM disabled_slots WHERE date = ? AND (time IS NULL OR time = ?)";
    $stmtDisabled = mysqli_prepare($con, $checkDisabledQuery);
    mysqli_stmt_bind_param($stmtDisabled, "ss", $date, $time);
    mysqli_stmt_execute($stmtDisabled);
    $resultDisabled = mysqli_stmt_get_result($stmtDisabled);
    $rowDisabled = mysqli_fetch_assoc($resultDisabled);

    if ($rowDisabled['count'] > 0) {
      echo '<div class="alert alert-danger">Sorry, Doctor Not Available!</div>';
    } else {
      // ✅ Check if the selected date-time is already booked
      $checkQuery = "SELECT * FROM appointment WHERE date = ? AND time = ? AND isDeleted <> 'Y'";
      $stmtCheck = mysqli_prepare($con, $checkQuery);
      mysqli_stmt_bind_param($stmtCheck, "ss", $date, $time);
      mysqli_stmt_execute($stmtCheck);
      $resultCheck = mysqli_stmt_get_result($stmtCheck);

      if (mysqli_num_rows($resultCheck) > 0) {
        echo '<div class="alert alert-danger">Sorry, this time slot is already booked. Please select another time.</div>';
      } else {

        $sql = "INSERT INTO appointment (name, date, time, email, mob_no, treatment, therapy, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmtInsert, "ssssssss", $name, $date, $time, $email, $mob_no, $treatment, $therapy, $message);

        if (mysqli_stmt_execute($stmtInsert)) {
          // header("Location: appointment.php");
          // exit();
          echo '<div class="alert alert-success">Appointment Request Sent!</div>';
        } else {
          echo '<div class="alert alert-danger">Error: ' . mysqli_error($con) . '</div>';
        }
        mysqli_stmt_close($stmtInsert);
      }
      mysqli_stmt_close($stmtCheck);
    }
    mysqli_stmt_close($stmtDisabled);
  }
}
mysqli_close($con);

include "include/header.php";
?>





<!-- ======= Contact Section ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Appointment</h2>
      <ol>
        <li><a href="index.php">Home</a></li>
        <li>Appointment</li>
      </ol>
    </div>

  </div>
</section>

<!-- Appointment Section -->


<!-- HTML Form -->
<section id="appointment" class="appointment section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Appointment</h2>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <form role="form" id="appointment-form" class="email-form" method="POST" action="appointment.php">
      <div class="row">
        <div class="col-md-6 form-group">
          <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
        </div>

        <div class="col-md-6 form-group">
          <input type="text" name="date" class="form-control" id="appointment-date" placeholder="Select Date" required readonly>
        </div>

        <div class="col-md-6 form-group">
          <select name="time" class="form-control" id="appointment-time" required>
            <option value="">Select Time</option>
          </select>
        </div>

        <div class="col-md-6 form-group mt-3 mt-md-0">
          <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
        </div>

        <div class="col-md-6 form-group mt-3 mt-md-0">
          <input type="number" class="form-control" name="subject" id="mobile" maxlength="10" placeholder="Mobile no." required>
        </div>

        <div class="col-md-6 form-group mt-3">
          <select name="department" id="treatment" class="form-select" required>
            <option value="">-------Select Treatment---------</option>
            <option value="Stuttering">Stuttering</option>
            <option value="Speech Disorder">Speech Disorder</option>
            <option value="Abnormal Behaviour">Abnormal Behaviour</option>
            <option value="ADHD(Attention Deficit Hyperactive Disorder)">ADHD (Attention Deficit Hyperactive Disorder)</option>
          </select>
        </div>

        <div class="col-md-6 form-group mt-3">
          <select name="doctor" id="therapy" class="form-select" required>
            <option value="">---------Select Therapy---------</option>
            <option value="Cognitive Behaviour Therapy (CBT)">Cognitive Behaviour Therapy (CBT)</option>
            <option value="Speech Language Therapy">Speech Language Therapy</option>
            <option value="Pediatric Physiotherapy">Pediatric Physiotherapy</option>
            <option value="Articulation Therapy">Articulation Therapy</option>
            <option value="Speech Therapy for Autism and ADHD">Speech Therapy for Autism and ADHD</option>
            <option value="Autism Spectrum Disorder">Autism Spectrum Disorder</option>
            <option value="Speech Delay">Speech Delay</option>
          </select>
        </div>
      </div>

      <div class="form-group mt-3">
        <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message (Optional)"></textarea>
      </div>

      <div class="button" style="text-align: center;width: 250px; height:70px; margin: auto;font-size:15px; font-weight: 700;">
        <button type="submit">Make an Appointment</button>
      </div>
    </form>
  </div>
</section>

<?php
include "include/footer.php";

?>