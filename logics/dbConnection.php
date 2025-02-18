<?php

$con = mysqli_connect("localhost", "root", "Datatec@123#", "amulya", 3307);
if (!$con) {

    echo "Connection failed: " . mysqli_connect_error();
    die();
}
