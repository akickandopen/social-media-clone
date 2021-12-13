<?php
    $connect = mysqli_connect("localhost", "root", "", "connect_db");

    if(mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }
?>