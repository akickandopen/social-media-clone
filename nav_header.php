<?php require 'server.php'; 

    // redirect to register.php when user is not logged in
    if (isset($_SESSION['first_name'])){
        $userLoggedIn = $_SESSION['first_name'];
    } 
    else {
        header("Location: register.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bond</title>
</head>

<body>
