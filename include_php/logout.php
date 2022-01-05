<?php
    session_start();
    session_destroy();

    //redirect to register page after logging out
    header("Location: ../register.php");
?>