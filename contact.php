<?php

// session_start();
// $_SESSION['login'] = "ok";
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Amulya Rehabilation Center</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Moderna
  * Template URL: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/
  * Updated: May 7 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

      <div class="logo">
        <h1 class="text-light"><a href="index.php"><span></span></a></h1>


        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="index.php"><img src="assets/img/logo_1.png" width="150px" height="350px" alt=""></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="active " href="index.php">Home</a></li>

          <li><a href="about.php">About</a></li>


          <li class="dropdown"><a href="#"><span>Services</span> <i class="bi bi-chevron-down"></i></a>
            <ul>

              <li class="dropdown"><a href="#"><span>Treatment</span> <i class="bi bi-chevron-right"></i></a>

                <ul>

                  <li><a href="stuttering.php">Stuttering</a></li>
                  <li><a href="speech_therapy.php">Speech and Language Therapy</a></li>
                  <li><a href="autism _therapy.php">Autism Spectrum Disorder (ASD)</a></li>
                  <li><a href="adhd.php">ADHD(Attention Deficit Hyperactive Disorder)</a></li>

                </ul>
              </li>


              <li class="dropdown"><a href="#"><span>Therapy</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="pediatric _therapy.php">Pediatric Physiotherapy</a></li>
                  <li><a href="CBT_therapy.php">Cognitive Behaviour Therapy (CBT)</a></li>
                  <li><a href="speech_therapy.php">Speech Language Therapy</a></li>
                  <li><a href="Articulation_Therapy.php">Articulation Therapy</a></li>
                  <li><a href="adhd.php">Speech Therapy for Autism and ADHD</a></li>
                  <li><a href="autism _therapy.php">Autism Spectrum Disorder</a></li>
                  <li><a href="speech_therapy.php">Speech Delay</a></li>
                  <li><a href="speech_therapy.php">Speech therapy for communication disorders</a></li>
                  <li><a href="speech_therapy.php">Speech Therapy For Voice Disorder</a></li>
                  <li><a href="speech_therapy.php">Speech Therapy for Speech Disorder</a></li>
                  <li><a href="speech_therapy.php">Speech therapy for Autism</a></li>
                  <li><a href="speech_therapy.php">Speech Therapy for children and infants</a></li>
                  <li><a href="speech_therapy.php">Speech Therapy for children with delayed speech and language</a></li>
                  <li><a href="adhd.php">ADHD (Attention Deficit Hyperactive Disorder)</a></li>


                </ul>
              </li>

            </ul>
          </li>


          </li>



          <li><a href="Gallery.php">Gallery</a></li>
          <li><a href="appointment.php">Appointment</a></li>

          <li><a class="active " href="contact.php">Contact Us</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <h4 class="button"><a href="appointment.php" style="color: white;">Appointment</a></h4>

    </div>
  </header><!-- End Header -->

  <main id="main">

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