<?php
ob_start(); // Start output buffering to prevent "headers already sent" errors

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start the session only if it is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'logics/dbConnection.php';
include 'include/header.php'; // Ensure there's no output before this

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_SESSION['role'])) {
    // Debugging: Check session contents
    var_dump($_SESSION);

    // Redirect if already logged in
    header('Location: appointmentData.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prevent SQL injection
    $user = $con->real_escape_string($user);
    $pass = $con->real_escape_string($pass);

    // Query to check credentials
    $sql = "SELECT * FROM admin WHERE username = '$user' AND password = '$pass'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Session creation on successful login
        $_SESSION['role'] = 'admin';

        // Debugging: Check if the session is set properly
        // var_dump($_SESSION);
        header('Location: appointmentData.php');
        exit();
    } else {
        echo "<script>alert('Invalid login credentials');</script>";
    }
}

$con->close();

// End output buffering and send the output
ob_end_flush();

?>

<div class="login-container">
    <h2>Admin Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</div>

<?php include 'include/footer.php'; ?>