<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['user_email'];
    $subject = $_POST['subject'];
    $replyMessage = $_POST['reply_message'];

    // Send email to the user
    $to = $userEmail;
    $from = "support@amulyarehabilationcenter.com";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "Content-type: text/html\r\n";

    $body = "<h3>Reply to your inquiry:</h3>";
    $body .= "<p><strong>Subject:</strong> $subject</p>";
    $body .= "<p><strong>Reply:</strong></p>";
    $body .= "<p>$replyMessage</p>";

    if (mail($to, "Reply to your inquiry", $body, $headers)) {
        echo "Reply sent successfully!";
    } else {
        echo "Failed to send reply.";
    }
}
