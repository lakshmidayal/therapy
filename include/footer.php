</main><!-- End #main -->

<!-- ======= Footer ======= -->
<section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
  <div class="container">

    <div class="row">

      <div class="col-lg-12">

        <div class="row">
          <div class="col-md-4">
            <div class="info-box">
              <i class="bx bx-map"></i>
              <h3>Our Address</h3>
              <p>C-3/8, First Floor, Yamuna Vihar,<br> Delhi - 110053 (Opposite BSES Office)</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-box">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p>support@amulyarehabilationcenter.com
                <!-- <br> amulya.rehabcenter08@gmail.com</p> -->
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

      <div class="container" style="width:100%;">
        <div class="copyright"
          style=" text-align: center; color: white; background-color: rgb(11, 37, 122); padding: 12px;">
          Amulya Rehabilation Center
        </div>

        </footer><!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">

        <script>
          $(document).ready(function() {
            let bookedSlots = {}; // Store fetched booked dates & times
            let disabledSlots = {}; // Store fetched disabled slots

            // Initialize Datepicker
            $("#appointment-date").datepicker({
              dateFormat: "yy-mm-dd",
              minDate: 0,
              beforeShowDay: function(date) {
                let formattedDate = $.datepicker.formatDate("yy-mm-dd", date);

                // Check if fully booked
                if (bookedSlots[formattedDate] && bookedSlots[formattedDate].length >= 8) {
                  return [false, "fully-booked", "Fully Booked"];
                }

                // Check if doctor is unavailable for the full day
                if (disabledSlots[formattedDate] === "full-day") {
                  return [false, "fully-booked", "Doctor Not Available"];
                }

                return [true, "", "Available"];
              },
              onSelect: function(selectedDate) {
                updateTimeSlots(selectedDate);
              }
            });

            // Fetch booked and disabled slots from the database
            function fetchSlots() {
              $.getJSON("fetch_booked_dates.php", function(data) {
                bookedSlots = data;
              });

              $.getJSON("fetch_disabled_slots.php", function(data) {
                disabledSlots = data;
              });
            }

            fetchSlots(); // Initial fetch

            function updateTimeSlots(selectedDate) {
              let bookedTimes = bookedSlots[selectedDate] || [];
              let disabledTimes = disabledSlots[selectedDate] || [];
              let timeSelect = $("#appointment-time");
              timeSelect.empty().append('<option value="">Select Time</option>');

              for (let hour = 10; hour <= 17; hour++) {
                let time = (hour < 10 ? "0" : "") + hour + ":00";

                if (bookedTimes.includes(time) || disabledTimes.includes(time)) {
                  timeSelect.append(`<option value="${time}" disabled>${time} (Booked)</option>`);
                } else {
                  timeSelect.append(`<option value="${time}">${time}</option>`);
                }
              }
            }

            // Auto-refresh every 10 seconds
            setInterval(fetchSlots, 10000);
          });
        </script>
        <!-- <script>
          $(document).ready(function() {
            let disabledSlots = {}; // Store fetched disabled dates & times

            // Initialize Datepicker
            $("#appointment-date").datepicker({
              dateFormat: "yy-mm-dd",
              minDate: 0,
              beforeShowDay: function(date) {
                let formattedDate = $.datepicker.formatDate("yy-mm-dd", date);

                // If full-day is disabled, block the entire date
                if (disabledSlots[formattedDate] === "full-day") {
                  return [false, "fully-booked", "Dr. Not Available"];
                }
                return [true, "", "Available"];
              },
              onSelect: function(selectedDate) {
                updateTimeSlots(selectedDate);
              }
            });

            // Fetch disabled slots from the database
            function fetchDisabledSlots() {
              $.getJSON("fetch_disabled_slots.php", function(data) {
                disabledSlots = data;
              });
            }

            fetchDisabledSlots(); // Initial fetch

            function updateTimeSlots(selectedDate) {
              let disabledTimes = disabledSlots[selectedDate] || [];
              let timeSelect = $("#appointment-time");
              timeSelect.empty().append('<option value="">Select Time</option>');

              for (let hour = 10; hour <= 17; hour++) {
                let time = (hour < 10 ? "0" : "") + hour + ":00";

                if (disabledTimes.includes(time)) {
                  timeSelect.append('<option value="' + time + '" disabled>' + time + ' (Dr. Not Available)</option>');
                } else {
                  timeSelect.append('<option value="' + time + '">' + time + '</option>');
                }
              }
            }

            // Auto-refresh disabled slots every 10 seconds
            setInterval(fetchDisabledSlots, 10000);
          });
        </script> -->


        <style>
          .fully-booked a {
            background-color: orange !important;
            color: white !important;
          }

          .doctor-unavailable a {
            background-color: red !important;
            color: white !important;
          }
        </style>

        <script>
          $(function() {
            $("#disable-date").datepicker({
              dateFormat: "yy-mm-dd",
              minDate: 0
            });
          });
        </script>

        </body>

        </html>