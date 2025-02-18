<?php
// Initialize status and message variables
$status = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect form data
  $name = htmlspecialchars(trim($_POST['name']));
  $email = htmlspecialchars(trim($_POST['email']));
  $subject = htmlspecialchars(trim($_POST['subject']));
  $message_content = htmlspecialchars(trim($_POST['message']));



  // Validate the form inputs
  if (empty($name) || empty($email) || empty($subject) || empty($message_content)) {
    // If any field is empty, show an error message
    $status = 'error';
    $message = 'All fields are required. Please fill out the form completely.';
  } else {
    // Recipient email address
    // $to = "amulya.rehabcenter08@gmail.com";

    $to = "support@amulyarehabilationcenter.com";

    // Email subject
    $email_subject = "New Message from $name - $subject";

    // Email body
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Here are the details:\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n";
    $email_body .= "Message:\n$message_content\n";

    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


    // Send email and check if it is sent successfully
    if (mail($to, $email_subject, $email_body, $headers)) {
      // If email sent successfully, show success message
      $status = 'success';
      $message = 'Your message has been sent. Thank you!';
    } else {
      // If email failed to send, show error message
      $status = 'error';
      $message = 'Sorry, something went wrong. Please try again.';
    }
  }
}


?>

<?php
include "include/header.php";
?>
<!-- ======= Contact Section ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Contact</h2>
      <ol>
        <li><a href="index.php">Home</a></li>
        <li>Contact</li>
      </ol>
    </div>

  </div>
</section><!-- End Contact Section -->

<!-- ======= Contact Section ======= -->
<section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
  <div class="container">

    <div class="row">

      <div class="col-lg-6">

        <div class="row">
          <div class="col-md-12">
            <div class="info-box">
              <i class="bx bx-map"></i>
              <h3>Our Address</h3>
              <p>C-3/8, First Floor, Yamuna Vihar,<br> Delhi - 110053 (Opposite BSES Office)</p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="info-box">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p>support@amulyarehabilationcenter.com
                <!--<br> amulya.rehabcenter08@gmail.com -->
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-box">
              <i class="bx bx-phone-call"></i>
              <h3>Call Us</h3>
              <p>8766375528<br>8920200513</p>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-6">
        <form role="form" class="email-form" id="form" method="POST">

          <!-- Success/Error Message -->
          <?php if (isset($status)): ?>
            <div class="alert <?php echo ($status === 'success') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Message" id="message"></textarea>
          </div>
          <br>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Send Message</button>
          </div>
        </form>
      </div>





    </div>

  </div>
</section>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3499.637822095947!2d77.27848089999999!3d28.7004788!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfdc9472425ad%3A0xd42dd4e280bdd606!2sAmulya%20rehabilitation%20Center!5e0!3m2!1sen!2sin!4v1733382326115!5m2!1sen!2sin" width="1400" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>


</div><!-- End Google Maps -->



</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "include/footer.php";  ?>