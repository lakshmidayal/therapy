<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
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
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .disabled-date {
      background-color: lightcoral !important;
    }

    .booked-date {
      background-color: lightyellow !important;
    }

    .available-date {
      background-color: lightgreen !important;
    }
  </style>


  <style>
    .navbar-mobile ul {

      background-color: #fff;

    }
  </style>
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
          <?php

          if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            echo '
          <li><a href="appointmentData.php">Appointment List</a></li><li>
          <li><a href="disable_slot.php">Block Date/Time</a></li>
          <li><a href="logout.php">Logout</a></li><li>';
          } else {
            echo '<li><a class="active " href="index.php">Home</a></li>

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

          <li><a class="active " href="contact.php">Contact Us</a></li>';
          }
          ?>


        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <?php
      if (empty($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        echo '<h4 class="button"><a href="appointment.php" style="color: white;">Appointment</a></h4>';
      }
      // 
      ?>

    </div>
  </header><!-- End Header -->

  <main id="main">