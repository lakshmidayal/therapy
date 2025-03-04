<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Check if the user is an admin
// Uncomment the following lines if you need to ensure only admins can access this page
// if (!($_SESSION['role'] == 'admin')) {
//   header('Location: index.php');
//   exit();
// }


require_once 'logics/dbConnection.php';


if (isset($_POST['read_id'])) {
    $read_id = intval($_POST['read_id']);
    $updateQuery = "UPDATE contact_form SET status='read' WHERE id=$read_id AND status='unread'";
    mysqli_query($con, $updateQuery);
}


if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $deleteQuery = "UPDATE contact_form SET isDeleted='Y' WHERE id=$delete_id";
    mysqli_query($con, $deleteQuery);
}


if (isset($_POST['rply_id'])) {
    $rply_id = intval($_POST['rply_id']);
    $replyQuery = "SELECT * FROM contact_form WHERE id=$rply_id";
    $replyResult = mysqli_query($con, $replyQuery);
    $replyData = mysqli_fetch_assoc($replyResult);
    $subject = $replyData['subject'];
    $message = $replyData['message'];
    $userEmail = $replyData['email'];

    echo "<script>
        $(document).ready(function(){
            $('#replyModal').modal('show');
        });
    </script>";
}

include 'include/header.php';
?>

<!-- ======= Contact Section ======= -->
<section class="breadcrumbs">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2>Contact List</h2>
    </div>
  </div>
</section><!-- End Contact Section -->

<!-- ======= Submitted Contact Forms Section ======= -->
<section class="submitted-contact-forms">
  <div class="container">
    <?php
    // Fetch all submitted contact forms
    $query = "SELECT * FROM contact_form WHERE isDeleted='N' ORDER BY createdAt DESC";
    $result = mysqli_query($con, $query);

    if (!$result) {
      die("Error fetching data from the database: " . mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0): ?>
      <h3>Submitted Contact Forms</h3>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Read</th>
            <th colspan="2" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['subject']); ?></td>
              <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
              <td>
                <?php if ($row['status'] == 'unread'): ?>
                  <form method='POST' style='display:inline;'>
                    <button type='submit' class='btn btn-warning btn-sm' name='read_id' value='<?php echo $row['ID']; ?>'>Read Message</button>
                  </form>
                <?php else: ?>
                  <button class="btn btn-success btn-sm" disabled>Read</button>
                <?php endif; ?>
              </td>
              <td>
                <form method='POST' style='display:inline;'>
                  <button type='submit' class='btn btn-primary btn-sm' name='rply_id' value='<?php echo $row['ID']; ?>'>Reply</button>
                </form>
              </td>
              <td>
                <form method='POST' style='display:inline;'>
                  <button type='submit' class='btn btn-danger btn-sm' name='delete_id' value='<?php echo $row['ID']; ?>'>Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No contact forms have been submitted yet.</p>
    <?php endif; ?>
  </div>
</section><!-- End Submitted Contact Forms Section -->

<!-- ======= Reply Modal ======= -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="replyModalLabel">Reply to Contact Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="send_reply.php">
          <input type="hidden" name="user_email" value="<?php echo isset($userEmail) ? $userEmail : ''; ?>">
          <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo isset($subject) ? $subject : ''; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="reply_message">Reply Message:</label>
            <textarea class="form-control" id="reply_message" name="reply_message" rows="5"></textarea>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Send Reply</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ======= Footer ======= -->
<?php include "include/footer.php"; ?>

