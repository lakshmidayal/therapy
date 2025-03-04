<?php
ob_start();

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

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
    var_dump($_SESSION);
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

<div class="container mt-0">
    <div class="row mt-0">
        <div class="col-md-6 offset-md-3">

            <div class="card">
                <h2 class="text-center text-dark mt-0">Admin Login</h2>
                <form class="card-body cardbody-color " action="login.php" method="POST">

                    <div class="text-center">
                        <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                            width="150px" alt="profile">
                    </div>

                    <div class="mb-2">
                        <input type="text" class="form-control" id="Username" name="username" aria-describedby="emailHelp"
                            placeholder="User Name">
                    </div>
                    <div class="mb-2">
                        <input type="password" class="form-control" id="password" name="password" placeholder="password">
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-light px-5 mb-5 w-100 border">Login</button></div>
                    <!-- <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not
                        Registered? <a href="#" class="text-dark fw-bold"> Create an
                            Account</a>
                    </div> -->
                    <div id="emailHelp" class="form-text text-center mb-1 text-dark">Forgot Password <a href="#" class="text-dark fw-bold"> Reset Password</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- <div class="login-container">
    <h2>Admin Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</div> -->

<?php include 'include/footer.php'; ?>