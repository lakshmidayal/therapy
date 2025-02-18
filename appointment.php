<?php
require_once 'logics/dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Getting form values
  $name = mysqli_real_escape_string($con, $_POST['name']);
  $date = mysqli_real_escape_string($con, $_POST['date']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $mob_no = mysqli_real_escape_string($con, $_POST['subject']);
  $treatment = mysqli_real_escape_string($con, $_POST['department']);
  $therapy = mysqli_real_escape_string($con, $_POST['doctor']);
  $message = mysqli_real_escape_string($con, $_POST['message']);

  // SQL query to insert the data into the appointment table
  $sql = "INSERT INTO appointment (name, date, email, mob_no, treatment, therapy, message) 
            VALUES ('$name', '$date', '$email', '$mob_no', '$treatment', '$therapy', '$message')";

  if (mysqli_query($con, $sql)) {
    echo '<div class="alert alert-success" role="alert">
  Appointment successfully created!
</div>';
    // echo "Appointment successfully created!";
    // You can redirect to the 'thanks.php' page if you want:
    // header("Location: thanks.php");
  } else {
    echo '    <div class="alert alert-danger" role="alert">
  Cannot book appointment right now!
</div>';
    //echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }
}

mysqli_close($con);
?>
<?php
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
    <form role="form" class="email-form" method="POST" action="appointment.php">
      <div class="row">
        <div class="col-md-6 form-group">
          <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
        </div>

        <div class="col-md-6 form-group">
          <input type="datetime-local" name="date" class="form-control datepicker" id="date" placeholder="Date of Appointment" required>
        </div>

        <div class="col-md-6 form-group mt-3 mt-md-0">
          <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
        </div>

        <div class="col-md-6 form-group mt-3 mt-md-0">
          <input type="text" class="form-control" name="subject" id="mobile" placeholder="Mobile no." required>
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