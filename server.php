<?php
    $connect = mysqli_connect("localhost", "root", "", "neverland_db");

    if(mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }
?>